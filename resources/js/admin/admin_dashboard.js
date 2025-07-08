//serve per la gestione dell'orologio nella dashboard
document.addEventListener('DOMContentLoaded', function () {
    function aggiornaOrologioNY() {
        const opzioni = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
            timeZone: 'America/New_York'
        };

        const dataNY = new Intl.DateTimeFormat('it-IT', opzioni).format(new Date());
        const orologio = document.getElementById('orologioNY');
        if (orologio) {
            orologio.innerText = `${dataNY} — New York`;
        }
    }

    aggiornaOrologioNY();
    setInterval(aggiornaOrologioNY, 1000);
});
