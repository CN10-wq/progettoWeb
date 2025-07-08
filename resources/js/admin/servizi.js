//serve per prendere il valore del token csrf della pagina
window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


//serve per mostrare/nascondere il form per l'aggiunta di un nuovo servizio-extra
window.toggleFormServizio = function () {
    const form = document.getElementById('formNuovoServizio');
    const btn = document.getElementById('toggleBtnServizio');

    if (!form || !btn) return;

    document.getElementById('formModificaServizio')?.classList.add('hidden');

    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        form.scrollIntoView({ behavior: 'smooth' });
        btn.textContent = '– Nascondi';
    } else {
        form.classList.add('hidden');
        btn.textContent = '+ Aggiungi Servizio';
    }
};


//serve per nascondere il form di modifica di un servizio-extra
window.chiudiFormModifica = function () {
    const form = document.getElementById('formModificaServizio');
    if (form) {
        form.classList.add('hidden');
    }
};


//serve per mostrare o nascondere il form di modifica per un servizio-extra sia in versione desktop che mobile.
// Chiude anche eventuali altri form aperti
window.toggleFormModificaServizio = function (servizio, id, isMobile = false) {
    const prefix = isMobile ? 'mobile-' : '';
    const row = document.getElementById(`formModificaRow-${prefix}${id}`);
    const azioni = document.getElementById(`azione-servizio-${prefix}${id}`);
    const formAggiunta = document.getElementById('formNuovoServizio');
    const btnAggiunta = document.getElementById('toggleBtnServizio');

    document.querySelectorAll('[id^="formModificaRow-"]').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('[id^="azione-servizio-"]').forEach(el => el.classList.remove('hidden'));

    if (formAggiunta) formAggiunta.classList.add('hidden');
    if (btnAggiunta) btnAggiunta.textContent = '+ Aggiungi Servizio';

    if (row.classList.contains('hidden')) {
        azioni?.classList.add('hidden');
        row.classList.remove('hidden');
        row.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        row.classList.add('hidden');
        azioni?.classList.remove('hidden');
    }
};


