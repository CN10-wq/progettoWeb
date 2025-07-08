//serve per gestire la visualizzazione e l'aggiunta di servizi-extra in una prenotazione quando la pagina è completamente caricata
document.addEventListener('DOMContentLoaded', function () {
    inizializzaDatiPrenotazione();

    const checkbox = document.getElementById('toggleServiziExtra'); //check-box per mostrare e nascondere i servizi-extra
    const sezione = document.getElementById('sezioneServiziExtra'); //contenitore dei servizi-extra
    const resetWrapper = document.getElementById('resetServiziWrapper'); //contenitore del btn rimuovi tutti i sevizi-extra
    const label = document.getElementById('labelServiziToggle'); //gestire il testo accanto alla check-box(visualizza/nascondi servizi extra)

    function toggleServizi() {
        const attivo = checkbox.checked;

        if (sezione) {
            sezione.classList.toggle('hidden', !attivo);
        }

        if (resetWrapper) {
            resetWrapper.classList.toggle('hidden', !attivo);
        }

        if (label) {
            label.textContent = attivo
                ? 'Nascondi servizi extra'
                : 'Visualizza e aggiungi servizi extra';
        }

        checkbox.setAttribute('aria-expanded', attivo);
    }

    if (checkbox) {
        checkbox.addEventListener('change', toggleServizi);
        toggleServizi(); 
    }
});


//mostra/nasconde il campo quantità e il prezzo nel momento in cui viene selezionato/deselezionato un determinato servizio-extra
window.toggleQuantita = function (id) {
    const checkbox = document.getElementById('servizio_' + id);
    const wrapper = document.getElementById('quantita_wrapper_' + id);
    const totaleText = document.getElementById('totale_servizio_' + id);
    const span = totaleText?.querySelector('span');

    if (!checkbox || !wrapper || !totaleText || !span) return;

    if (checkbox.checked) {
        document.getElementById('quantita_' + id).value = 1;
        wrapper.classList.remove('hidden');
        totaleText.classList.remove('hidden');
        wrapper.closest('.block').classList.add('border-white/30');
        aggiornaTotale(id);
    } else {
        wrapper.classList.add('hidden');
        totaleText.classList.add('hidden');
        wrapper.closest('.block').classList.remove('border-white/30');
        span.innerText = '0.00';
    }

    aggiornaTotaleComplessivo();
}


//calcola e aggiorna il costo totale di un servizio-extra selezionato
window.aggiornaTotale = function (id) {
    const prezzo = window.prezziServiziExtra?.[id.toString()] || 0;
    const quantita = parseInt(document.getElementById('quantita_' + id)?.value || 0);
    const totale = prezzo * quantita;

    const output = document.querySelector(`#totale_servizio_${id} span`);
    if (output) {
        output.innerText = totale.toLocaleString('it-IT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    aggiornaTotaleComplessivo();
}


//calcola e aggiorna il costo complessivo di tutta la prenotazione (compreso di camera e servizi)
window.aggiornaTotaleComplessivo = function () {
    let totale = window.prezzoCameraBase || 0;
    document.querySelectorAll('[id^="totale_servizio_"] span').forEach(span => {
        totale += parseFloat(span.innerText || 0);
    });

    const outputTotale = document.getElementById('totale_complessivo');
    if (outputTotale) {
        outputTotale.innerText = 'Totale complessivo: €' + totale.toLocaleString('it-IT', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
};


//serve per rimuovere contemporaneamente tutti i servizi-extra selezionati dall'utente, aggiornando anche il totale
window.resetServiziExtra = function () {
    document.querySelectorAll('[id^="servizio_"]').forEach(checkbox => {
        checkbox.checked = false;
    });

    document.querySelectorAll('[id^="quantita_wrapper_"]').forEach(wrapper => {
        wrapper.classList.add('hidden');
    });

    document.querySelectorAll('[id^="totale_servizio_"]').forEach(p => {
        p.classList.add('hidden');
        p.querySelector('span').innerText = '0.00';
    });

    document.querySelectorAll('[id^="servizio_"]').forEach(input => {
        input.closest('.block').classList.remove('border-white/30');
    });

    aggiornaTotaleComplessivo();
}

//serve per recuperare i prezzi della camera e dei vari servizi-extra
window.inizializzaDatiPrenotazione = function () {
    const el = document.getElementById('datiPrenotazione');
    if (!el) return;

    window.prezzoCameraBase = parseFloat(el.dataset.prezzoCamera) || 0;
    window.prezziServiziExtra = JSON.parse(el.dataset.serviziExtra || '{}');
};

