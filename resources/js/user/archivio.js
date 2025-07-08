//serve per gestire dinamicamente la visualizzazione dell’archivio delle prenotazioni di un cliente, con possibilità di filtrarle in base allo stato (con caricamento ajax)
document.addEventListener('DOMContentLoaded', function () {
    const btnArchivio = document.getElementById('visualizzaArchivio');
    const contenitoreArchivio = document.getElementById('contenitoreArchivio');
    const prenotazioniAttive = document.getElementById('prenotazioniAttive');
    const filtroSelect = document.getElementById('filtroStato');
    const contenitoreFiltro = document.getElementById('contenitoreFiltro');

    if (!btnArchivio || !contenitoreArchivio || !prenotazioniAttive) return;

    let archivioVisibile = false;

    btnArchivio.addEventListener('click', () => {
        archivioVisibile = !archivioVisibile;
        const areaControlli = document.getElementById('areaControlliArchivio');

        if (archivioVisibile) {
            prenotazioniAttive.classList.add('hidden');
            contenitoreFiltro.classList.remove('hidden');

            areaControlli.classList.remove('sm:justify-center', 'flex-col', 'items-center');
            areaControlli.classList.add('sm:justify-between');

            btnArchivio.textContent = 'Nascondi archivio';
            caricaArchivio();
        } else {
            contenitoreArchivio.classList.add('hidden');
            prenotazioniAttive.classList.remove('hidden');

            contenitoreFiltro.classList.add('hidden');
            filtroSelect.value = 'tutte';

            areaControlli.classList.remove('sm:justify-between');
            areaControlli.classList.add('flex-col', 'items-center', 'sm:justify-center');

            btnArchivio.textContent = 'Visualizza tutto l\'archivio';
        }
    });

    filtroSelect.addEventListener('change', () => {
        if (archivioVisibile) {
            caricaArchivio();
        }
    });

    function caricaArchivio() {
        const statoId = filtroSelect.value;
        const labelFiltro = filtroSelect.options[filtroSelect.selectedIndex].textContent;
        const valoreFiltro = statoId;

        contenitoreArchivio.classList.remove('hidden');
        contenitoreArchivio.innerHTML = '';

        fetch(`/cliente/archivio-prenotazioni?stato_id=${encodeURIComponent(statoId)}&label=${encodeURIComponent(labelFiltro)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                contenitoreArchivio.innerHTML = '';

                if (data.vuoto) {
                    const label = valoreFiltro === 'tutte' ? '' : ` ${data.label?.toLowerCase()}`;
                    contenitoreArchivio.innerHTML = `
                        <p class="text-center text-white/70 italic">
                            Nessuna prenotazione${label} trovata nell'archivio.
                        </p>
                    `;
                    return;
                }

                contenitoreArchivio.innerHTML = data.html;

                if (typeof inizializzaGallerieDinamiche === 'function') {
                    inizializzaGallerieDinamiche();
                }
            })
            .catch(error => {
                console.error('Errore durante il caricamento dell’archivio:', error);
                contenitoreArchivio.innerHTML = `<p class="text-red-500 text-center">Errore durante il caricamento dell'archivio.</p>`;
            });
    }
});


