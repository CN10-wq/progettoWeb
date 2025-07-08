//serve per prendere il valore del token csrf della pagina
window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


// serve per la gestione della selezione del tipo di prenotazioni (attesa, oggi, archivio), evidenziando il bottone cliccato,
// mostrando il filtro per stato se archivio e caricando le prenotazioni corrispondenti.
window.selezionaTipoPrenotazione = function (tipo) {
    document.querySelectorAll('[id^="btn-"]').forEach(btn => {
        btn.classList.remove('text-white', 'bg-white/20', 'border', 'border-white');
        btn.classList.add('text-white/70', 'bg-white/10');
    });

    const btnCorrente = document.getElementById(`btn-${tipo}`);
    btnCorrente?.classList.add('text-white', 'bg-white/20', 'border', 'border-white');
    btnCorrente?.classList.remove('text-white/70', 'bg-white/10');

    const filtroArchivio = document.getElementById('filtroArchivio');
    if (tipo === 'archivio') {
        if (filtroArchivio) filtroArchivio.classList.remove('hidden');
        filtraStatoArchivio('tutte');
    } else {
        if (filtroArchivio) filtroArchivio.classList.add('hidden');
        caricaPrenotazioni(tipo);
    }
};



//serve per caricare e visualizzare le prenotazioni(a seconda della voce attesa, oggi e archivio),
//con supporto per filtraggio in base alla stato, aggiunta di btn per accettare/rifiutare prenotazioni
window.caricaPrenotazioni = function (tipo, filtro = 'tutte') {
    let endpoint = `/admin/prenotazioni/${tipo}`;
    if (tipo === 'archivio' && filtro !== 'tutte') {
        endpoint += `?stato_id=${filtro}`;
    }

    fetch(endpoint)
        .then(res => res.json())
        .then(data => {
            const contenitore = document.getElementById('contenitorePrenotazioni');
            if (!contenitore) return;

            contenitore.innerHTML = '';

            if (data.length === 0) {
                let messaggio = 'Nessuna prenotazione trovata.';
                if (tipo === 'archivio') {
                    if (filtro === 'tutte') {
                        messaggio = 'Nessuna prenotazione in archivio.';
                    } else {
                        const statiNomi = {
                            '1': 'annullata',
                            '2': 'confermata',
                            '3': 'in attesa',
                            '4': 'effettuata'
                        };
                        const statoNome = statiNomi[filtro] ?? 'con questo stato';
                        messaggio = `Nessuna prenotazione nello stato di ${statoNome} in archivio.`;
                    }
                } else if (tipo === 'attesa') {
                    messaggio = 'Nessuna prenotazione in attesa.';
                } else if (tipo === 'oggi') {
                    messaggio = 'Nessuna prenotazione per oggi.';
                }

                contenitore.innerHTML = `<p class="text-white/50 text-center">${messaggio}</p>`;
                return;
            }

            data.forEach(p => {
                const servizi = p.servizi_extra.map(se =>
                    `<li>
                        ${se.nome} × ${se.pivot.quantita} 
                        (<span class="italic">
                            €${Number(se.pivot.prezzo_unitario).toLocaleString('it-IT', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })} al ${se.prezzo_unita}
                        </span>)
                    </li>`
                ).join('');

                let html = `
<div id="card-${p.id}" class="bg-white/5 border border-white/10 rounded-2xl p-6 shadow-xl backdrop-blur-md text-white w-full max-w-full mx-auto mb-6">
`;

                html += `
<div class="mb-4 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
    <div>
        <h2 class="text-2xl font-bold tracking-wide uppercase">
            ${p.camera.titolo}
        </h2>
        <p class="text-sm text-white/70 mt-1">
            Cliente: <span class="font-semibold">${p.user.name} ${p.user.surname ?? ''}</span> –
            <em class="text-white/60">${p.user.email}</em>
        </p>
    </div>
    ${tipo === 'archivio' ? `
    <div class="mt-2 sm:mt-0 sm:self-start">
        <span class="px-3 py-1 rounded-full text-xs bg-white/10 border border-white/20 font-medium whitespace-nowrap">
            ${p.stato?.nome ?? '—'}
        </span>
    </div>
    ` : ''}
</div>
`;

                html += `
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
    <div>
        <p><strong>Check-in:</strong> ${formatData(p.data_inizio)}</p>  
        <p><strong>Check-out:</strong> ${formatData(p.data_fine)}</p>
        <p><strong>Ospiti:</strong> ${p.numero_persone} ${p.numero_persone === 1 ? 'persona' : 'persone'}</p>
    </div>

    <div>
        <p><strong>Richieste cliente:</strong><br> ${p.eventuali_richieste_cliente || 'Nessuna'}</p>
    </div>
</div>
`;

                html += `
<div class="mt-4">
    <p><strong>Pernottamento (totale camera):</strong> 
        €${Number(p.prezzo_totale_camera).toLocaleString('it-IT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}
    </p>

    <p class="mt-2"><strong>Servizi extra:</strong></p>
    <ul class="list-disc list-inside text-sm text-white/90 mt-1 ml-2 space-y-1">
        ${p.servizi_extra.length > 0 ? p.servizi_extra.map(se => `
            <li class="break-words leading-snug">
                <span class="whitespace-nowrap">${se.nome} × ${se.pivot.quantita}</span> 
                <span class="whitespace-nowrap italic text-white/70">(
                    €${Number(se.pivot.prezzo_unitario).toLocaleString('it-IT', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })} / ${se.prezzo_unita}
                )</span>
            </li>
        `).join('') : '<li><span class="italic text-white/60">Nessuno</span></li>'}
    </ul>
</div>
`;

                html += `
<div class="mt-4 text-right">
    <p class="text-lg font-semibold tracking-wide">
        Totale: 
        <span class="text-white">
            €${p.totale_spesa.toLocaleString('it-IT', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}
        </span>
    </p>
</div>
`;

                if (tipo === 'attesa') {
                    html += `
<div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 mt-6">
    <button onclick="confermaPrenotazione(${p.id})"
        class="px-5 py-2 bg-white/10 hover:bg-white/20 rounded border border-white/30 transition duration-200 font-bold">
        ACCETTA
    </button>
    <button onclick="annullaPrenotazione(${p.id})"
        class="px-5 py-2 bg-white/10 hover:bg-white/20 rounded border border-white/30 text-white-400 transition duration-200 font-bold">
        RIFIUTA
    </button>
</div>
`;
                }

                html += `</div>`;
                contenitore.innerHTML += html;
            });
        });
};


//serve per accettare una prenotazione in attesa di conferma, con messaggio di successo
window.confermaPrenotazione = function (id) {
    fetch(`/admin/prenotazioni/${id}/conferma`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`card-${id}`).remove();
            mostraMessaggioSuccesso('Prenotazione accettata');
        }
    });
};


//serve per annullare una prenotazione in attesa di conferma, con messaggio di successo
window.annullaPrenotazione = function (id) {
    fetch(`/admin/prenotazioni/${id}/annulla`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`card-${id}`).remove();
            mostraMessaggioSuccesso('Prenotazione rifiutata');
        }
    });
};


//mostra un messaggio di successo temporaneo
window.mostraMessaggioSuccesso = function (testo) {
    const msg = document.getElementById('messaggioSuccesso');

    msg.innerHTML = `
        <div
            class="bg-white/10 text-white/80 border border-white/30 rounded-xl px-4 py-3 backdrop-blur-md shadow-md text-center transition-opacity duration-500">
            ${testo}
        </div>
    `;

    msg.classList.remove('hidden');

    setTimeout(() => {
        msg.classList.add('opacity-0');

        setTimeout(() => {
            msg.innerHTML = '';
            msg.classList.add('hidden');
            msg.classList.remove('opacity-0');
        }, 500);
    }, 3000);
};


//serve per evidenziare il filtro di stato attivo nella sezione archivio e ricarica le prenotazioni desiderate
window.filtraStatoArchivio = function (stato) {
    document.querySelectorAll('#filtroArchivio button').forEach(btn => {
        btn.classList.remove('border-white', 'text-white');
        btn.classList.add('text-white/60', 'border-transparent');
    });

    const attivo = document.getElementById(`filtro-${stato}`);
    attivo.classList.remove('text-white/60', 'border-transparent');
    attivo.classList.add('text-white', 'border-white');

    caricaPrenotazioni('archivio', stato);
};


//serve quando l'admin vuole accedere dalla dashboard alle prenotazioni di oggi direttamente, attivando correttamente il filtro
document.addEventListener('DOMContentLoaded', function () {
    const tipo = window.location.hash.replace('#', '');

    if (['attesa', 'oggi', 'archivio'].includes(tipo)) {
        selezionaTipoPrenotazione(tipo);
        window.history.replaceState(null, '', window.location.pathname);
    }
});


//formattazione di una data in formato italiano
function formatData(dataString) {
    const data = new Date(dataString);
    return data.toLocaleDateString('it-IT', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}