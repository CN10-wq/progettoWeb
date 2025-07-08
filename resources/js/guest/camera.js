import {Italian} from "flatpickr/dist/l10n/it.js";


//serve per la gestione della barra di prenotazione di una singola camera in due versioni: desktop e responsitive.
//Non permette di selezionare le date già occupate da altre prenotazioni e nel momento in cui sono inserite due date valide 
//esce il btn prenota per procedere. Es. se c'è una prenotazione per la notte tra il 5 Luglio e il 6 Luglio, come check-in si potrà selezionare il 6 Luglio o se si dovesse
//selezionare come check-in il 4 luglio si potrà selezionare come check-out il 5 luglio.
document.addEventListener("DOMContentLoaded", function () {
    const inizioInput = document.getElementById("data_inizio");
    const fineInput = document.getElementById("data_fine");
    const resetBtn = document.getElementById("resettaDate");
    const bottonePrenota = document.getElementById("bottonePrenota");
    const jsonDiv = document.getElementById("prenotazioni-data");

    if (!jsonDiv) return;

    const jsonString = jsonDiv.getAttribute("data-json");
    if (!jsonString) return;

    let data;
    try {
        data = JSON.parse(jsonString);
    } catch (e) {
        console.error("JSON non valido.");
        return;
    }

    window.dateOccupate = window.dateOccupate2 = data;

    if (!inizioInput || !fineInput) return;

    let dateOccupate = new Set();
    let dateOccupate2 = new Set();

    if (typeof window.dateOccupate !== 'undefined') {
        window.dateOccupate.forEach(range => {
            let current = new Date(range.from);
            const end = new Date(range.to);
            while (current < end) {
                dateOccupate.add(formatDateLocal(current));
                current.setDate(current.getDate() + 1);
            }
        });
    }

    if (typeof window.dateOccupate2 !== 'undefined') {
        window.dateOccupate2.forEach(range => {
            let current = new Date(range.from);
            current.setDate(current.getDate() + 1);
            const end = new Date(range.to);
            while (current <= end) {
                dateOccupate2.add(formatDateLocal(current));
                current.setDate(current.getDate() + 1);
            }
        });
    }

    const endPicker = flatpickr(fineInput, {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        minDate: "today",
        disable: Array.from(dateOccupate2),
        locale: Italian,
        minMobile: true,
        onChange: function (selectedDates) {
            const dataInizio = inizioInput.value;
            const dataFine = selectedDates.length > 0 ? selectedDates[0] : null;

            if (dataInizio && dataFine) {
                const inizio = new Date(dataInizio);
                const fine = new Date(dataFine);
                const controllo = new Date(inizio);
                let valido = true;

                while (controllo < fine) {
                    const check = formatDateLocal(controllo);
                    if (dateOccupate.has(check)) {
                        valido = false;
                        break;
                    }
                    controllo.setDate(controllo.getDate() + 1);
                }

                if (!valido) {
                    const alertBox = document.getElementById('date-error-alert');
                    if (alertBox) {
                        alertBox.classList.remove('hidden');
                        setTimeout(() => alertBox.classList.add('opacity-100'), 10);
                        setTimeout(() => {
                            alertBox.classList.remove('opacity-100');
                            setTimeout(() => alertBox.classList.add('hidden'), 500);
                        }, 4000);
                    }
                    endPicker.clear();
                }
            }
        }
    });

    const startPicker = flatpickr(inizioInput, {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d F Y",
        minDate: "today",
        locale: Italian,
        minMobile: true,
        disable: Array.from(dateOccupate),
        onChange: function (selectedDates) {
            if (selectedDates.length > 0) {
                const selectedDate = selectedDates[0];
                const nextDay = new Date(selectedDate);
                nextDay.setDate(nextDay.getDate() + 1);
                endPicker.set('minDate', nextDay);
                endPicker.jumpToDate(nextDay);
                endPicker.open();
            }
        }
    });

    inizioInput.addEventListener("focus", () => {
        startPicker.clear();
        endPicker.clear();
        inizioInput.value = "";
        fineInput.value = "";
        endPicker.set("minDate", "today");
        aggiornaVisibilitaReset();
        aggiornaVisibilitaPrenota();
    });

    window.resettaDate = function () {
        startPicker.clear();
        endPicker.clear();
        aggiornaVisibilitaReset();
    };

    if (resetBtn) {
        resetBtn.addEventListener("click", window.resettaDate);
    }

    function aggiornaVisibilitaReset() {
        if (!resetBtn) return;

        const hasStart = inizioInput.value.trim() !== "";
        const hasEnd = fineInput.value.trim() !== "";

        if (hasStart || hasEnd) {
            resetBtn.classList.remove('hidden');
        } else {
            resetBtn.classList.add('hidden');
        }
    }

    inizioInput.addEventListener("input", aggiornaVisibilitaReset);
    fineInput.addEventListener("input", aggiornaVisibilitaReset);

    startPicker.config.onChange.push(aggiornaVisibilitaReset);
    endPicker.config.onChange.push(aggiornaVisibilitaReset);

    aggiornaVisibilitaReset();

    function aggiornaVisibilitaPrenota() {
        if (!bottonePrenota) return;

        const hasStart = inizioInput.value.trim() !== "";
        const hasEnd = fineInput.value.trim() !== "";

        if (hasStart && hasEnd) {
            bottonePrenota.classList.remove('hidden');
            setTimeout(() => bottonePrenota.classList.add('opacity-100'), 10);
        } else {
            bottonePrenota.classList.remove('opacity-100');
            setTimeout(() => bottonePrenota.classList.add('hidden'), 300); 
        }
    }

    inizioInput.addEventListener("input", aggiornaVisibilitaPrenota);
    fineInput.addEventListener("input", aggiornaVisibilitaPrenota);

    startPicker.config.onChange.push(aggiornaVisibilitaPrenota);
    endPicker.config.onChange.push(aggiornaVisibilitaPrenota);

    aggiornaVisibilitaPrenota();

    //versione mobile
    const inizioInputMobile = document.getElementById("data_inizio_mobile");
    const fineInputMobile = document.getElementById("data_fine_mobile");
    const resetBtnMobile = document.getElementById("resettaDateMobile");
    const bottonePrenotaMobile = document.getElementById("bottonePrenotaMobile");

    if (inizioInputMobile && fineInputMobile) {
        const endPickerMobile = flatpickr(fineInputMobile, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            minDate: "today",
            disable: Array.from(dateOccupate2),
            locale: Italian,
            minMobile: true,
            onChange: function (selectedDates) {
                const dataInizio = inizioInputMobile.value;
                const dataFine = selectedDates.length > 0 ? selectedDates[0] : null;

                if (dataInizio && dataFine) {
                    const inizio = new Date(dataInizio);
                    const fine = new Date(dataFine);
                    const controllo = new Date(inizio);
                    let valido = true;

                    while (controllo < fine) {
                        const check = formatDateLocal(controllo);
                        if (dateOccupate.has(check)) {
                            valido = false;
                            break;
                        }
                        controllo.setDate(controllo.getDate() + 1);
                    }

                    if (!valido) {
                        const alertBox = document.getElementById('date-error-alert');
                        if (alertBox) {
                            alertBox.classList.remove('hidden');
                            setTimeout(() => alertBox.classList.add('opacity-100'), 10);
                            setTimeout(() => {
                                alertBox.classList.remove('opacity-100');
                                setTimeout(() => alertBox.classList.add('hidden'), 500);
                            }, 4000);
                        }
                        endPickerMobile.clear();
                    }
                }
            }
        });

        const startPickerMobile = flatpickr(inizioInputMobile, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            minDate: "today",
            disable: Array.from(dateOccupate),
            locale: Italian,
            minMobile: true,
            onChange: function (selectedDates) {
                if (selectedDates.length > 0) {
                    const selectedDate = selectedDates[0];
                    const nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    endPickerMobile.set('minDate', nextDay);
                    endPickerMobile.jumpToDate(nextDay);
                    endPickerMobile.open();
                }
            }
        });

        inizioInputMobile.addEventListener("focus", () => {
            startPickerMobile.clear();
            endPickerMobile.clear();
            inizioInputMobile.value = "";
            fineInputMobile.value = "";
            endPickerMobile.set("minDate", "today");
            aggiornaResetMobile();
            aggiornaPrenotaMobile();
        });

        window.resettaDateMobile = function () {
            startPickerMobile.clear();
            endPickerMobile.clear();
            aggiornaResetMobile();
        };

        if (resetBtnMobile) {
            resetBtnMobile.addEventListener("click", window.resettaDateMobile);
        }

        function aggiornaResetMobile() {
            if (!resetBtnMobile) return;

            const hasStart = inizioInputMobile.value.trim() !== "";
            const hasEnd = fineInputMobile.value.trim() !== "";

            if (hasStart || hasEnd) {
                resetBtnMobile.classList.remove("hidden");
            } else {
                resetBtnMobile.classList.add("hidden");
            }
        }

        function aggiornaPrenotaMobile() {
            if (!bottonePrenotaMobile) return;

            const hasStart = inizioInputMobile.value.trim() !== "";
            const hasEnd = fineInputMobile.value.trim() !== "";

            if (hasStart && hasEnd) {
                bottonePrenotaMobile.classList.remove("hidden");
                setTimeout(() => bottonePrenotaMobile.classList.add("opacity-100"), 10);
            } else {
                bottonePrenotaMobile.classList.remove("opacity-100");
                setTimeout(() => bottonePrenotaMobile.classList.add("hidden"), 300);
            }
        }

        inizioInputMobile.addEventListener("input", aggiornaResetMobile);
        fineInputMobile.addEventListener("input", aggiornaResetMobile);
        startPickerMobile.config.onChange.push(aggiornaResetMobile);
        endPickerMobile.config.onChange.push(aggiornaResetMobile);
        aggiornaResetMobile();

        inizioInputMobile.addEventListener("input", aggiornaPrenotaMobile);
        fineInputMobile.addEventListener("input", aggiornaPrenotaMobile);
        startPickerMobile.config.onChange.push(aggiornaPrenotaMobile);
        endPickerMobile.config.onChange.push(aggiornaPrenotaMobile);
        aggiornaPrenotaMobile();
    }
});


//converte una data in una stringa YYYY-MM-DD, tenendo conto del fuso orario
function formatDateLocal(date) {
    const localDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
    return localDate.toISOString().split("T")[0];
}



