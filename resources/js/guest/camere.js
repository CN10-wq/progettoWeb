import { Italian } from "flatpickr/dist/l10n/it.js";

//serve per la gestione della barra di prenotazioni quando l'utente inserisce le date (con possibilità di reset)-> ad esempio non gli è permesso selezionare date precedenti ad oggi
// o una data di check-out antecedente a quella di check-in. Se clicca nuovamente sulla data di check-in si ripuliscono entrambi i campi.
//E' gestita sia in versione desktop che mobile/responsitive(in cui all'inizio la barra è nascosta->uso di toggle)
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("formCamere");
    const inizioInput = document.getElementById("data_inizio_camere");
    const fineInput = document.getElementById("data_fine_camere");
    const resetBtn = document.getElementById("resettaDateButton");
    const erroreDiv = document.getElementById("errore-date");

    //versione mobile
    const formMobile = document.getElementById("formCamereMobile");
    const inizioInputMobile = document.getElementById("data_inizio_camere_mobile");
    const fineInputMobile = document.getElementById("data_fine_camere_mobile");
    const resetBtnMobile = document.getElementById("resettaDateButtonMobile");
    const erroreDivMobile = document.getElementById("errore-date-mobile");
    const toggleBtn = document.getElementById("toggleDateMobile");
    const testoToggle = document.getElementById("testoToggleDate");
    const frecciaToggle = document.getElementById("frecciaToggleDate");
    const contenitoreFormMobile = document.getElementById("contenitoreFormDateMobile");

    if (!contenitoreFormMobile || !frecciaToggle || !testoToggle) return;

    const statoSezione = localStorage.getItem('sezioneDateMobileAperta');
    if (statoSezione === 'true') {
        contenitoreFormMobile.classList.remove('hidden');
        frecciaToggle.classList.remove("rotate-180");
        testoToggle.textContent = "Nascondi selezione date";
    } else {
        contenitoreFormMobile.classList.add('hidden');
        frecciaToggle.classList.add("rotate-180");
        testoToggle.textContent = "Seleziona date per verificare la disponibilità";
    }

    function aggiornaVisibilitaReset(inizio, fine, btn) {
        const hasStart = inizio?.value.trim() !== "";
        const hasEnd = fine?.value.trim() !== "";
        btn?.classList.toggle("hidden", !(hasStart || hasEnd));
    }

    function resettaDate(startPicker, endPicker, inizioInput, fineInput, btn) {
        startPicker.clear();
        endPicker.clear();
        endPicker.set("minDate", "today");
        inizioInput.value = "";
        fineInput.value = "";
        aggiornaVisibilitaReset(inizioInput, fineInput, btn);

        const url = new URL(window.location.href);
        ['arrivo', 'partenza', 'tipo'].forEach(p => url.searchParams.delete(p));
        window.history.replaceState({}, '', url.pathname);
        location.reload();
    }

    function validazioneForm(e, inizioInput, fineInput, erroreDiv) {
        const arrivo = inizioInput.value.trim();
        const partenza = fineInput.value.trim();
        if (!arrivo || !partenza) {
            e.preventDefault();
            erroreDiv?.classList.remove("hidden");
            erroreDiv.textContent = "Per poter cercare devi prima inserire entrambe le date di arrivo e partenza!";
            setTimeout(() => erroreDiv.classList.add("hidden"), 4000);
        } else {
            erroreDiv?.classList.add("hidden");
        }
    }

    function creaPicker(inizioInput, fineInput, resetBtn) {
        [inizioInput, fineInput].forEach(input => {
            input.setAttribute("readonly", true);
            input.setAttribute("inputmode", "none");
        });

        const endPicker = flatpickr(fineInput, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            minDate: "today",
            locale: Italian,
            disableMobile: true,
            altInputClass: fineInput.className,
            onOpen: function () {
                const partenza = startPicker.selectedDates[0];
                const giornoDopo = partenza ? new Date(partenza.getTime() + 86400000) : new Date();
                endPicker.set("minDate", giornoDopo);
            },
            onChange: () => aggiornaVisibilitaReset(inizioInput, fineInput, resetBtn)
        });

        const startPicker = flatpickr(inizioInput, {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            minDate: "today",
            locale: Italian,
            disableMobile: true,
            altInputClass: inizioInput.className,
            onOpen: function () {
                startPicker.clear();
                endPicker.clear();
                inizioInput.value = "";
                fineInput.value = "";
                endPicker.set("minDate", "today");
                aggiornaVisibilitaReset(inizioInput, fineInput, resetBtn);
            },
            onChange: function (selectedDates) {
                if (selectedDates.length > 0) {
                    const giornoSuccessivo = new Date(selectedDates[0].getTime() + 86400000);
                    endPicker.set("minDate", giornoSuccessivo);
                    endPicker.open();
                }
                aggiornaVisibilitaReset(inizioInput, fineInput, resetBtn);
            }
        });

        return { startPicker, endPicker };
    }

    if (form && inizioInput && fineInput) {
        const { startPicker, endPicker } = creaPicker(inizioInput, fineInput, resetBtn);
        form.addEventListener("submit", e => validazioneForm(e, inizioInput, fineInput, erroreDiv));
        resetBtn?.addEventListener("click", () => resettaDate(startPicker, endPicker, inizioInput, fineInput, resetBtn));
        aggiornaVisibilitaReset(inizioInput, fineInput, resetBtn);
    }

    if (formMobile && inizioInputMobile && fineInputMobile) {
        const { startPicker, endPicker } = creaPicker(inizioInputMobile, fineInputMobile, resetBtnMobile);
        formMobile.addEventListener("submit", e => validazioneForm(e, inizioInputMobile, fineInputMobile, erroreDivMobile));
        resetBtnMobile?.addEventListener("click", () => resettaDate(startPicker, endPicker, inizioInputMobile, fineInputMobile, resetBtnMobile));
        aggiornaVisibilitaReset(inizioInputMobile, fineInputMobile, resetBtnMobile);
    }

    toggleBtn?.addEventListener("click", () => {
        const isHidden = contenitoreFormMobile.classList.toggle("hidden");
        frecciaToggle.classList.toggle("rotate-180");

        if (isHidden) {
            testoToggle.textContent = "Seleziona date per verificare la disponibilità";
            localStorage.setItem('sezioneDateMobileAperta', 'false');
        } else {
            testoToggle.textContent = "Nascondi selezione date";
            localStorage.setItem('sezioneDateMobileAperta', 'true');
        }
    });

        scrollToSezioneCamereIfParamsPresent();
});


//serve per quando l'utenta cerca la disponibilità tra due date: scroll automatico nella sezione delle camere disponibili
function scrollToSezioneCamereIfParamsPresent() {
    const urlParams = new URLSearchParams(window.location.search);
    const arrivo = urlParams.get('arrivo');
    const partenza = urlParams.get('partenza');

    if (arrivo && partenza) {
        const target = document.getElementById('sezioneCamere');
        if (target) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        }
    }
}




































