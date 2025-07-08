//mostra un messaggio di errore, con la possibilità per l'utente di chiuderlo (usato durante le azioni di autenticazione)
document.addEventListener('DOMContentLoaded', function () {
    const btnChiudi = document.getElementById('close-error-alert');
    const boxErrore = document.getElementById('error-alert');

    if (btnChiudi && boxErrore) {
        btnChiudi.addEventListener('click', () => {
            boxErrore.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                boxErrore.classList.add('hidden');
            }, 300);
        });
    }
});


//permette all'utente di visualizzare in chiaro o meno la password in un campo di input (usato durante le azioni di autenticazione)
window.togglePasswordVisibility = function (idCampo, evento) {
    const campo = document.getElementById(idCampo);
    if (!campo) return;

    const btn = evento.currentTarget;
    const iconaOcchio = btn.querySelector('.eye-open');
    const iconaOcchioSbarrato = btn.querySelector('.eye-closed');

    const isPassword = campo.type === 'password';
    campo.type = isPassword ? 'text' : 'password';

    if (iconaOcchio && iconaOcchioSbarrato) {
        iconaOcchio.classList.toggle('hidden', !isPassword);
        iconaOcchioSbarrato.classList.toggle('hidden', isPassword);
    }
};
