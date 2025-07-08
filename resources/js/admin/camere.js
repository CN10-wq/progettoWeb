//serve per prendere il valore del token csrf della pagina
window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


window.gestioneCamere_data = []; //contiene l'elenco delle camere caricate con i vari dati (utile in particolare per lo scorrimento delle immagini)
window.gestioneCamere_index = {}; //hashmap in cui la chiave è l'id della camera e il valore è l'indice dell'immagine corrente mostrata nella card
window.cameraDaRipristinare = null; //serve per memorizzare l'id della camera che l'admin vuole ripristinare, utile nel modale


//gestisce la selezione del tipo di visualizzazione della camera(4 scelte)
window.selezionaTipoCamera = function (tipo) {
    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.classList.remove('text-white', 'bg-white/20', 'border', 'border-white');
        btn.classList.add('text-white/70', 'bg-white/10', 'border-transparent');
    });

    const bottone = document.getElementById(`btn-${tipo}`);
    bottone?.classList.add('text-white', 'bg-white/20', 'border', 'border-white');
    bottone?.classList.remove('text-white/70', 'bg-white/10');

    if (tipo === 'disponibili') {
        gestioneCamere_caricaDisponibiliOggi();
    } else if (tipo === 'nuova') {
        gestioneCamere_mostraFormAggiunta();
    } else if (tipo === 'eliminate') {
        gestioneCamere_eliminate();
    } else if (tipo === 'attive') {
        gestioneCamere_attive();
    }
};


//evidenzia il btn selezionato e ripristina lo stile degli altri
const gestioneCamere_evidenziaBottone = (id) => {
    document.querySelectorAll('button[id^="btn-"]').forEach(btn => {
        btn.classList.replace('text-white', 'text-white/70');
        btn.classList.replace('border-white', 'border-transparent');
        btn.classList.replace('bg-white/20', 'bg-white/10');
    });

    const attivo = document.getElementById(id);
    if (attivo) {
        attivo.classList.replace('text-white/70', 'text-white');
        attivo.classList.replace('border-transparent', 'border-white');
        attivo.classList.replace('bg-white/10', 'bg-white/20');
    }
};


//carica dinamicamente le camere che sono disponibili in data odierna e aggiorna la pagina con le diverse card
const gestioneCamere_caricaDisponibiliOggi = () => {
    const msgDiv = document.getElementById('messaggioSuccessoCamera');
    if (msgDiv && window.messaggioCameraVisibile) {
        msgDiv.classList.remove('opacity-100');
        msgDiv.classList.add('opacity-0');
        setTimeout(() => msgDiv.classList.add('hidden'), 500);
        window.messaggioCameraVisibile = false;
    }

    fetch('/admin/camere/disponibili-oggi')
        .then(res => res.json())
        .then(camere => {
            window.gestioneCamere_data = camere;
            const contenuto = document.getElementById('contenuto-camere');
            contenuto.innerHTML = '';

            if (camere.length === 0) {
                contenuto.innerHTML = '<p class="text-center text-white/60">Nessuna camera disponibile oggi.</p>';
                return;
            }

            camere.forEach(camera => {
                const card = creaCardCamera(camera, {}); 
                contenuto.appendChild(card);
            });
        })
        .catch(() => {
            mostraMessaggioCamera('Errore nel caricamento delle camere disponibili oggi.', 'error');
        });

    gestioneCamere_evidenziaBottone('btn-disponibili');
};


//serve per selezionare subito la voce camere disponibili oggi se l'admin arriva dalla sua dashboard (ha cliccando la card corrispondente)
//e per mostrare un messaggio di successo se è stato salvato precedentemente
document.addEventListener('DOMContentLoaded', function () {
    const tipo = window.location.hash.replace('#', '');
    
    if (tipo === 'disponibili') {
        selezionaTipoCamera('disponibili');
        window.history.replaceState(null, '', window.location.pathname);
    }

    const messaggio = sessionStorage.getItem('cameraSuccess');
    if (messaggio) {
        mostraMessaggioCamera(messaggio, 'success');
        sessionStorage.removeItem('cameraSuccess');
    }
});


// mostra dinamicamente il form per l'aggiunta di una nuova camera,
// gestisce la selezione di nuove immagini(minimo 3) e invia il form via AJAX
window.gestioneCamere_mostraFormAggiunta = function () {
    gestioneCamere_evidenziaBottone('btn-nuova');

    const msgDiv = document.getElementById('messaggioSuccessoCamera');
    if (msgDiv && window.messaggioCameraVisibile) {
        msgDiv.classList.remove('opacity-100');
        msgDiv.classList.add('opacity-0');
        setTimeout(() => msgDiv.classList.add('hidden'), 500);
        window.messaggioCameraVisibile = false;
    }

    const contenuto = document.getElementById('contenuto-camere');
    contenuto.innerHTML = '<p class="text-white/70">Caricamento form...</p>';

    window.immaginiPersistenti = new Map();

    fetch('/admin/camere/create')
        .then(res => res.json())
        .then(risposta => {
            contenuto.innerHTML = risposta.html;

            setTimeout(() => {
                const container = document.getElementById('contenitore-immagini');
                if (!container) {
                    mostraMessaggioCamera('Errore nel caricamento del form.', 'error');
                    return;
                }

                const inputCapienza = document.getElementById('capienza');
                if (inputCapienza && !inputCapienza.value) {
                    inputCapienza.value = 1;
                }

                for (let i = 0; i < 3; i++) aggiungiCardUpload(container);

                document.getElementById('btn-aggiungi').addEventListener('click', () => {
                    aggiungiCardUpload(container);
                });

                document.getElementById('form-nuova-camera').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData();
                    document.querySelectorAll('#form-nuova-camera input, #form-nuova-camera select, #form-nuova-camera textarea')
                        .forEach(el => {
                            if (el.name && el.type !== 'file') {
                                formData.append(el.name, el.value);
                            }
                        });

                    let validi = 0;
                    window.immaginiPersistenti.forEach((file, id) => {
                        if (file instanceof File) {
                            formData.append('immagini[]', file);
                            validi++;
                        }
                    });

                    if (validi < 3) {
                        mostraMessaggioCamera('Devi selezionare almeno 3 immagini.', 'error');
                        return;
                    }

                    fetch('/admin/camere', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': window.csrfToken,
                        },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                sessionStorage.setItem('cameraSuccess', 'Camera aggiunta con successo!');
                                window.location.href = '/admin/camere';
                            } else {
                                mostraMessaggioCamera(data.message || 'Errore nel salvataggio della camera.', 'error');
                            }
                        })
                        .catch(() => {
                            mostraMessaggioCamera('Errore di rete nel salvataggio della camera.', 'error');
                        });
                });
            }, 0);
        });
};


//serve per gestire l'aggiunta di immagini all'interno del form per creare una nuova camera (se le immagini sono >3 permette anche di eliminarle)
window.aggiungiCardUpload = function (container) {
    const card = document.createElement('div');
    const numero = container.children.length + 1;
    const idInput = `immagine-${numero}`;
    card.className = "relative card-upload bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-4 shadow-md space-y-3";

    card.innerHTML = `
        <label class="block text-white/70 text-sm mb-2">Immagine ${numero}</label>
        <input type="file" accept="image/*"
            class="input-file hidden" id="${idInput}">
        <button type="button"
            class="btn-carica w-full file-trigger bg-white/10 text-white/80 border border-white/20 rounded-lg py-2 px-4 text-sm hover:bg-white/20 transition">
            Seleziona file
        </button>
        <img src="#" alt="Anteprima" class="anteprima hidden mt-4 w-full h-auto rounded-lg mx-auto">
        <button type="button" class="btn-reset-file text-xs mt-2 underline text-white/60 hover:text-white transition hidden">✖ Rimuovi selezione</button>
    `;

    const fileInput = card.querySelector('.input-file');
    const triggerBtn = card.querySelector('.btn-carica');
    const anteprima = card.querySelector('.anteprima');
    const resetBtn = card.querySelector('.btn-reset-file');

    triggerBtn.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        const file = fileInput.files[0];
        if (file) {
            window.immaginiPersistenti.set(fileInput.id, file);
            const reader = new FileReader();
            reader.onload = e => {
                anteprima.src = e.target.result;
                anteprima.classList.remove('hidden');
                resetBtn.classList.remove('hidden');
                triggerBtn.textContent = 'File selezionato';
            };
            reader.readAsDataURL(file);
        }
    });

    resetBtn.addEventListener('click', () => {
        window.immaginiPersistenti.delete(fileInput.id);
        fileInput.value = '';
        anteprima.src = '#';
        anteprima.classList.add('hidden');
        resetBtn.classList.add('hidden');
        triggerBtn.textContent = 'Seleziona file';
    });

    if (container.children.length >= 3) {
        const btnRimuovi = document.createElement('button');
        btnRimuovi.type = 'button';
        btnRimuovi.innerHTML = '&times;';
        btnRimuovi.className = 'absolute top-2 right-2 text-white bg-white/10 hover:bg-white/20 rounded-full w-7 h-7 flex items-center justify-center shadow border border-white/20 transition';
        btnRimuovi.addEventListener('click', () => {
            if (container.children.length <= 3) {
                mostraMessaggioCamera('Devi mantenere almeno 3 immagini.', 'warning', 5000);
                return;
            }
            window.immaginiPersistenti.delete(fileInput.id);
            card.remove();
        });
        card.appendChild(btnRimuovi);
    }

    container.appendChild(card);
}

//serve per deselezionare tutti i vari filtri
window.gestioneCamere_deselezionaTutti = function () {
    document.querySelectorAll('button[id^="btn-"]').forEach(btn => {
        btn.classList.remove('text-white', 'bg-white/20', 'border', 'border-white');
        btn.classList.add('text-white/70', 'bg-white/10', 'border-transparent');
    });

    const contenuto = document.getElementById('contenuto-camere');
    contenuto.innerHTML = '';
    window.location.hash = '';
};


//ripristina con successo una camera eliminata (dopo aver accettato tramite un modale) e aggiorna la pagina
window.confermaRipristinoCamera = function () {
    if (!window.cameraDaRipristinare) return;

    fetch(`/admin/camere/${cameraDaRipristinare}/ripristina`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            chiudiModale('modaleConfermaRipristino');
            gestioneCamere_eliminate('Camera ripristinata con successo!');
        } else {
            mostraMessaggioCamera(data.message || 'Errore nel ripristino.', 'error');
        }
    })
    .catch(() => {
        mostraMessaggioCamera('Errore di rete durante il ripristino.', 'error');
    });
};


//creazione di una card dinamica html che rappresenta una camera con le varie informazioni annesse
window.creaCardCamera = function (camera) {
    const immagini = camera.immagini?.map(img => img.path) || [];
    window.immaginiCamera = window.immaginiCamera || {};
    window.immaginiCamera[camera.id] = immagini;
    const index = window.gestioneCamere_index?.[camera.id] || 0;
    const primaImg = immagini[index] || '/images/placeholder.jpg';

    const card = document.createElement('div');
    card.id = `card-camera-${camera.id}`;
    card.className = 'bg-white/5 backdrop-blur-md rounded-xl shadow p-4 space-y-4 flex flex-col md:flex-row gap-6';

    window.gestioneCamere_index[camera.id] = 0;

    card.innerHTML = `
        <div class="relative w-full md:w-72 aspect-square">
            <img id="img-${camera.id}" src="${primaImg}" 
                class="w-full h-full object-cover rounded-lg shadow transition-all duration-300 aspect-square">

            <button type="button" onclick="gestioneCamere_prevImg(${camera.id})"
                class="absolute left-1 top-1/2 transform -translate-y-1/2 bg-black/20 hover:bg-black/30 text-white px-1.5 py-1 text-xs rounded-full">‹</button>

            <button type="button" onclick="gestioneCamere_nextImg(${camera.id})"
                class="absolute right-1 top-1/2 transform -translate-y-1/2 bg-black/20 hover:bg-black/30 text-white px-1.5 py-1 text-xs rounded-full">›</button>
        </div>

        <div class="flex-1 flex flex-col justify-between">
            <div class="space-y-2">
                <h2 class="text-xl font-semibold">${camera.titolo}</h2>
                <p class="text-sm text-white/70">${camera.tipo ?? 'Tipo non specificato'}</p>
                <p class="text-sm text-white/70">
                    €${parseFloat(camera.prezzo).toLocaleString('it-IT', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} / notte
                </p>
                <p class="text-sm text-white/70">
                    Capienza: ${camera.capienza} ${camera.capienza === 1 ? 'persona' : 'persone'}
                </p>
                <p class="text-sm text-white/60">${camera.descrizione || ''}</p>
            </div>
        </div>
    `;

    return card;
};


//gestisce la visualizzazione delle camere attive con possibilità di modifica (apertura di un form inline)
//e di eliminazione(apertura modale di conferma), con caricamenti via ajax e aggiornamenti dinamici
window.gestioneCamere_attive = function (messaggioSuccesso = null) {
    if (messaggioSuccesso) {
        mostraMessaggioCamera(messaggioSuccesso, 'success');
    } else {
        const messaggio = document.getElementById('messaggioSuccessoCamera');
        if (messaggio) {
            messaggio.classList.add('hidden', 'opacity-0');
            messaggio.innerHTML = '';
            window.messaggioCameraVisibile = false;
        }
    }

    const contenuto = document.getElementById('contenuto-camere');
    contenuto.innerHTML = '<p class="text-white/70">Caricamento camere attive...</p>';

    fetch('/admin/camere/attive')
        .then(res => res.json())
        .then(data => {
            const camere = data.camere;
            window.listaTipiCamere = data.tipi;
            window.gestioneCamere_data = camere;

            contenuto.innerHTML = '';

            if (camere.length === 0) {
                contenuto.innerHTML = '<p class="text-white/60 italic text-center">Nessuna camera attiva trovata.</p>';
                return;
            }

            camere.forEach(camera => {
                const card = creaCardCamera(camera);
                window.gestioneCamere_index[camera.id] = 0;

                const azioni = document.createElement('div');
                azioni.className = 'pt-3 text-right space-x-2';

                const btnModifica = document.createElement('button');
                btnModifica.textContent = 'Modifica';
                btnModifica.className = `
                    px-4 py-1 rounded-xl text-sm
                    text-white bg-white/10 hover:bg-white/20
                    border border-white/20 transition backdrop-blur-md font-medium
                `;
                btnModifica.addEventListener('click', () => {
                    trasformaCardInForm(camera);
                });
                azioni.appendChild(btnModifica);

                const btnElimina = document.createElement('button');
                btnElimina.textContent = 'Elimina';
                btnElimina.className = `
                    px-4 py-1 rounded-xl text-sm
                    text-white bg-white/10 hover:bg-white/20
                    border border-white/20 transition backdrop-blur-md font-medium
                `;
                btnElimina.addEventListener('click', () => {
                    window.cameraDaEliminare = camera.id;
                    apriModale('modaleConfermaEliminazione');
                });

                azioni.appendChild(btnElimina);
                card.querySelector('.flex-1').appendChild(azioni);
                contenuto.appendChild(card);
            });
        })
        .catch(() => {
            contenuto.innerHTML = '<p class="text-white/60 italic text-center">Nessuna camera attiva disponibile al momento.</p>';
        });

    gestioneCamere_evidenziaBottone('btn-attive');
};


//serve quando l'admin seleziona la modifica nella sezione delle camere attive: apertura di un form inline,
//in cui l'admin può modificare le informazioni di una camera (mantenendo un minimo di 3 immagini sempre).
//Tutto sempre gestito via ajax.
window.trasformaCardInForm = function (camera) {
    const card = document.querySelector(`#card-camera-${camera.id}`);
    if (!card) return;

    card.className = 'bg-white/5 backdrop-blur-md rounded-2xl shadow p-6 space-y-6 w-full';

    const formHTML = `
        <form id="form-modifica-${camera.id}" class="text-white space-y-6" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="${window.csrfToken}">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block mb-1 text-white/80 font-medium">Titolo</label>
                    <input type="text" name="titolo" value="${camera.titolo.replace(/"/g, '&quot;')}"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl" required>
                </div>

                <div>
                    <label class="block mb-1 text-white/80 font-medium">Tipo camera</label>
                    <select name="tipo_id" class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl" required>
                        <option value="" disabled ${camera.tipo_id ? '' : 'selected'}>-- Seleziona tipo --</option>
                        ${window.listaTipiCamere.map(tipo =>
                            `<option value="${tipo.id}" ${tipo.id == camera.tipo_id ? 'selected' : ''}>${tipo.nome}</option>`
                        ).join('')}
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-white/80 font-medium">Prezzo a notte (€)</label>
                    <input type="number" step="0.01" name="prezzo_a_notte" value="${camera.prezzo}"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl" required>
                </div>

                <div>
                    <label class="block mb-1 text-white/80 font-medium">Capienza massima</label>
                    <input type="number" name="capienza" value="${camera.capienza ?? ''}"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl" min="1" required>
                </div>

                <div class="col-span-2">
                    <label class="block mb-1 text-white/80 font-medium">Descrizione</label>
                    <textarea name="descrizione" rows="4"
                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-2xl">${camera.descrizione ?? ''}</textarea>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-white/80 font-medium">Immagini attuali</label>
                <div id="immagini-esistenti-${camera.id}" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    ${(camera.immagini ?? []).map(img => `
                        <div class="relative group rounded-xl overflow-hidden border border-white/20">
                            <img src="${img.path}" class="w-full h-48 object-cover">
                            <button type="button" data-id="${img.id}"
                                class="btn-rimuovi-immagine absolute top-2 right-2 text-white text-lg leading-none bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center shadow border border-white/20 backdrop-blur-md transition">
                                &times;
                            </button>
                        </div>
                    `).join('')}
                </div>
                <input type="hidden" name="immagini_da_rimuovere" id="rimuovi-${camera.id}">
            </div>

            <div>
                <label class="block mb-2 text-white/80 font-medium">Nuove immagini</label>
                <div id="container-upload-${camera.id}" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                <button type="button" id="btn-add-upload-${camera.id}"
                    class="mt-3 text-sm text-white bg-white/10 border border-white/20 px-4 py-2 rounded-xl hover:bg-white/20">
                    + Aggiungi immagine
                </button>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <button type="button" onclick="gestioneCamere_attive()"
                    class="text-sm text-white/60 hover:text-white underline">Annulla</button>
                <button type="submit"
                    class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/30 rounded-2xl font-medium">
                    Salva modifiche
                </button>
            </div>
        </form>
    `;

    card.innerHTML = formHTML;

    const form = card.querySelector('form');
    const immaginiDaRimuovere = [];

    const containerUpload = document.getElementById(`container-upload-${camera.id}`);
    document.getElementById(`btn-add-upload-${camera.id}`).addEventListener('click', () => {
        const numero = containerUpload.children.length + 1;
        const wrapper = document.createElement('div');
        wrapper.className = 'relative bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl p-4 shadow-md';

        wrapper.innerHTML = `
            <label class="block text-white/70 text-sm mb-2">Immagine ${numero}</label>
            <input type="file" name="immagini_nuove[]" accept="image/*"
                class="w-full file:bg-white/10 file:text-white/70 file:border-none file:rounded-lg file:px-4 file:py-2 text-sm text-white/80 bg-transparent border border-white/20 rounded-lg">
            <img src="#" alt="Anteprima" class="anteprima hidden mt-4 w-full h-auto rounded-lg mx-auto">
        `;

        const btnRimuovi = document.createElement('button');
        btnRimuovi.type = 'button';
        btnRimuovi.className = 'btn-rimuovi-immagine absolute top-2 right-2 text-white text-lg leading-none bg-white/10 hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center shadow border border-white/20 backdrop-blur-md transition';
        btnRimuovi.innerHTML = '&times;';
        btnRimuovi.addEventListener('click', () => {
            const anteprimaVisibile = wrapper.querySelector('.anteprima')?.classList.contains('hidden') === false;

            if (anteprimaVisibile && contaImmaginiTotali(camera.id) <= 3) {
                mostraMessaggioCamera('Devi mantenere almeno 3 immagini totali. Aggiungine una prima di rimuovere.', 'warning', 6000);
                return;
            }

            wrapper.remove();
        });

        wrapper.appendChild(btnRimuovi);

        const input = wrapper.querySelector('input[type="file"]');
        const anteprima = wrapper.querySelector('.anteprima');

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    anteprima.src = e.target.result;
                    anteprima.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                anteprima.src = '#';
                anteprima.classList.add('hidden');
            }
        });

        containerUpload.appendChild(wrapper);
    });

    card.querySelectorAll('.btn-rimuovi-immagine').forEach(btn => {
        btn.addEventListener('click', () => {
            if (contaImmaginiTotali(camera.id) <= 3) {
                mostraMessaggioCamera('Devi mantenere almeno 3 immagini totali. Aggiungine una prima di rimuovere.', 'warning', 6000);
                return;
            }

            const imgId = btn.dataset.id;
            immaginiDaRimuovere.push(parseInt(imgId));
            btn.closest('div').remove();
            document.getElementById(`rimuovi-${camera.id}`).value = JSON.stringify(immaginiDaRimuovere);
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        formData.set('immagini_da_rimuovere', JSON.stringify(immaginiDaRimuovere));

        fetch(`/admin/camere/${camera.id}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                gestioneCamere_attive('Modifica salvata con successo!');
            } else {
                mostraMessaggioCamera(data.message ?? 'Errore durante la modifica.', 'error');
            }
        })
        .catch(() => mostraMessaggioCamera('Errore di rete.', 'error'));
    });
};


//mostra le varie notifiche di successo/errore nelle varie sezioni di gestione camera.
//Essi sono caratterizzati da scomparsa in automatico, ad eccezione degli errori.
function mostraMessaggioCamera(testo, tipo = 'success') {
    const div = document.getElementById('messaggioSuccessoCamera');

    div.className = `
        max-w-4xl mx-auto rounded-xl px-4 py-3 backdrop-blur-md
        shadow-md text-center transition-opacity duration-500
    `;

    if (tipo === 'success') {
        div.classList.add('bg-white/10', 'text-white/80', 'border', 'border-white/30');
    } else if (tipo === 'error') {
        div.classList.add('bg-red-600/10', 'text-red-300', 'border', 'border-red-400/30');
    } else if (tipo === 'warning') {
        div.classList.add('bg-yellow-600/10', 'text-yellow-300', 'border', 'border-yellow-400/30');
    } else {
        div.classList.add('bg-white/5', 'text-white/70', 'border', 'border-white/20');
    }

    div.textContent = testo;

    div.classList.remove('hidden', 'opacity-0');
    div.classList.add('opacity-100');

    if (tipo !== 'error') {
        let durata = 3000;
        if (tipo === 'warning') durata = 6000;

        setTimeout(() => {
            div.classList.remove('opacity-100');
            div.classList.add('opacity-0');

            setTimeout(() => div.classList.add('hidden'), 500);
        }, durata);
    }

    window.messaggioCameraVisibile = true;
}


//serve per procedere con l'eliminazione della camera (possibile solo se sono presenti minimo 3 camere).
//Aggiornamento della lista delle camere attive, con chiusura del modale.
window.confermaEliminazioneCamera = function () {
    if (!window.cameraDaEliminare) return;

    fetch(`/admin/camere/${cameraDaEliminare}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        chiudiModale('modaleConfermaEliminazione');

        if (data.success) {
            gestioneCamere_attive('Camera eliminata con successo!');
        } else {
            mostraMessaggioCamera(data.message || 'Errore durante l\'eliminazione.', 'error');
        }
    })
    .catch(() => {
        chiudiModale('modaleConfermaEliminazione');
        mostraMessaggioCamera('Errore di rete durante l\'eliminazione.', 'error');
    });
};


//conta il numero delle immagini di una camera (sia quelle esistenti che le anteprime)
function contaImmaginiTotali(cameraId) {
    const esistenti = document.querySelectorAll(`#immagini-esistenti-${cameraId} img`).length;

    const nuove = Array.from(document.querySelectorAll(`#container-upload-${cameraId} .anteprima`))
        .filter(img => !img.classList.contains('hidden'))
        .length;

    return esistenti + nuove;
}

//serve per visualizzare le camere eliminate con possibilità di restore (sempre tramite modale di conferma). I dati sono caricati via ajax.
window.gestioneCamere_eliminate = function (messaggioSuccesso = null) {
    const messaggio = document.getElementById('messaggioSuccessoCamera');
    if (messaggioSuccesso) {
        mostraMessaggioCamera(messaggioSuccesso, 'success');
    } else if (messaggio) {
        messaggio.classList.add('hidden', 'opacity-0');
        messaggio.innerHTML = '';
        window.messaggioCameraVisibile = false;
    }

    const contenuto = document.getElementById('contenuto-camere');
    contenuto.innerHTML = '<p class="text-white/60 italic text-center">Caricamento camere eliminate...</p>';

    fetch('/admin/camere/eliminate')
        .then(res => res.json())
        .then(data => {
            const camere = data.camere;
            window.listaTipiCamere = data.tipi;
            window.gestioneCamere_data = camere;

            contenuto.innerHTML = '';

            if (!Array.isArray(camere) || camere.length === 0) {
                contenuto.innerHTML = '<p class="text-white/50 italic text-center">Nessuna camera eliminata da poter ripristinare!</p>';
                return;
            }

            window.gestioneCamere_index = {};

            camere.forEach(camera => {
                window.gestioneCamere_index[camera.id] = 0;

                const card = creaCardCamera(camera, {}); 

                const azioni = document.createElement('div');
                azioni.className = 'pt-3 text-right space-x-2';

                const btnRipristina = document.createElement('button');
                btnRipristina.textContent = ' Ripristina';
                btnRipristina.className = `
                    px-4 py-1 rounded-xl text-sm
                    text-white bg-white/10 hover:bg-white/20
                    border border-white/20 transition backdrop-blur-md font-medium
                `.trim();

                btnRipristina.addEventListener('click', () => {
                    window.cameraDaRipristinare = camera.id;
                    apriModale('modaleConfermaRipristino');
                });

                azioni.appendChild(btnRipristina);
                card.querySelector('.flex-1')?.appendChild(azioni);
                contenuto.appendChild(card);
            });
        })
        .catch(() => {
            mostraMessaggioCamera('Errore durante il caricamento delle camere eliminate.', 'error');
        });

    gestioneCamere_evidenziaBottone('btn-eliminate');
};


