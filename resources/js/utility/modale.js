//serve per mostrare un modale
window.apriModale = function(id) {
    const modale = document.getElementById(id);
    if (!modale) return;

    modale.classList.remove('hidden');
    modale.classList.add('flex');

    requestAnimationFrame(() => {
        modale.classList.add('opacity-100');
        modale.classList.remove('opacity-0');
    });
}


//serve per la chiusura di un modale
window.chiudiModale = function(id) {
    const modale = document.getElementById(id);
    if (!modale) return;

    modale.classList.add('opacity-0');
    modale.classList.remove('opacity-100');

    setTimeout(() => {
        modale.classList.remove('flex');
        modale.classList.add('hidden');
    }, 300); 
}


//serve per aprire un modale di un user che vuole procedere o meno con una prenotazione (inglobando le date selezionate)
window.apriModaleConPrenotazione = function(cameraId) {
    const isMobile = window.innerWidth < 1280; 

    function getFirstValidInput(possibiliId) {
        for (const id of possibiliId) {
            const el = document.getElementById(id);
            if (el && el._flatpickr) return el;
        }
        return null;
    }

    const inputInizio = isMobile
        ? getFirstValidInput(["data_inizio_mobile", "data_inizio_camere_mobile"])
        : getFirstValidInput(["data_inizio", "data_inizio_camere"]);

    const inputFine = isMobile
        ? getFirstValidInput(["data_fine_mobile", "data_fine_camere_mobile"])
        : getFirstValidInput(["data_fine", "data_fine_camere"]);

    if (!inputInizio || !inputFine) {
        console.error("Flatpickr non inizializzato correttamente.");
        return;
    }

    const dataInizio = inputInizio._flatpickr.selectedDates[0];
    const dataFine = inputFine._flatpickr.selectedDates[0];

    if (!dataInizio || !dataFine) {
        console.warn("Date non selezionate.");
        return;
    }

    const arrivo = formatDateLocal(dataInizio);
    const partenza = formatDateLocal(dataFine);

    const link = document.getElementById('linkConfermaPrenotazione');
    if (link) {
        link.href = `/prenotazione/${cameraId}?arrivo=${encodeURIComponent(arrivo)}&partenza=${encodeURIComponent(partenza)}`;
    }

    window.apriModale('modaleConfermaPrenotazione');
};


//serve per aprire un modale di un utente non autenticato che vuole prenotare, che prima però deve accedere/registrarsi (salva anche i dati di sessione della prenotazione)
window.apriModaleConPrenotazioneGuest = function(cameraId) {
    const isMobile = window.innerWidth < 1280;

    function getFirstValidInput(possibiliId) {
        for (const id of possibiliId) {
            const el = document.getElementById(id);
            if (el && el._flatpickr) return el;
        }
        return null;
    }

    const inputInizio = isMobile
        ? getFirstValidInput(["data_inizio_mobile", "data_inizio_camere_mobile"])
        : getFirstValidInput(["data_inizio", "data_inizio_camere"]);

    const inputFine = isMobile
        ? getFirstValidInput(["data_fine_mobile", "data_fine_camere_mobile"])
        : getFirstValidInput(["data_fine", "data_fine_camere"]);

    if (!inputInizio || !inputFine) {
        console.error("Flatpickr non inizializzato correttamente.");
        return;
    }

    const dataInizio = inputInizio._flatpickr.selectedDates[0];
    const dataFine = inputFine._flatpickr.selectedDates[0];

    if (!dataInizio || !dataFine) {
        console.warn("Date non selezionate.");
        return;
    }

    const arrivo = formatDateLocal(dataInizio);
    const partenza = formatDateLocal(dataFine);

    fetch('/salva-prenotazione-sessione', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            camera_id: cameraId,
            arrivo: arrivo,
            partenza: partenza
        })
    }).then(() => {
        window.apriModale('modaleGuest');
    }).catch(error => {
        console.error('Errore durante il salvataggio della prenotazione:', error);
    });
};


//converte una data in una stringa YYYY-MM-DD, tenendo conto del fuso orario
function formatDateLocal(date) {
    const localDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
    return localDate.toISOString().split("T")[0];
}


//parte admin (alcuni modali usati dallo stesso sono definiti anche in altri file .js)

//serve per mostrare un modale di eliminazione di una camera
window.mostraModaleEliminaCamera = function(id) {
    const form = document.getElementById('formEliminaCamera');
    form.action = `/admin/camere/${id}`;
    apriModale('modaleEliminaCamera');
};


//serve per mostrare un modale di eliminazione dell'account di un cliente registrato
window.apriModaleEliminazioneCliente = function(id, nomeCompleto) {
    const testo = document.getElementById('testoConfermaEliminazione');
    if (testo) {
        testo.textContent = `Sei sicuro di voler eliminare l'account del cliente: ${nomeCompleto}?`;
    }

    const form = document.getElementById('formEliminaCliente');
    if (form) {
        form.action = `/admin/elimina-cliente/${id}`;
    }

    window.apriModale('modaleConfermaEliminazioneCliente');
};


//serve per mostrare un modale di eliminazione di un servizio-extra
window.apriModaleEliminazione = function (id, nome) {
    const form = document.getElementById('formEliminaServizio');
    const testo = document.getElementById('testoEliminaServizio');
    const btn = document.getElementById('toggleBtnServizio');

    if (!form || !testo) return;

    form.action = `/admin/servizi-extra/${id}`;
    testo.textContent = `Vuoi davvero eliminare il servizio “${nome}”?`;

    document.getElementById('formNuovoServizio')?.classList.add('hidden');
    document.getElementById('formModificaServizio')?.classList.add('hidden');

    if (btn) {
        btn.textContent = '+ Aggiungi Servizio';
    }

    apriModale('modaleEliminaServizio');
};
