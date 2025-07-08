import 'jquery';
import '@popperjs/core';
import 'bootstrap';
import flatpickr from "flatpickr";
import 'flatpickr/dist/themes/dark.css';



import './utility/immagini';
import './guest/navbarGuest';
import './admin/navbarApp';
import './guest/welcome';
import './utility/modale';
import './utility/authentication';
import './guest/camera';
import './guest/camere';
import './user/prenotazione';
import './admin/admin_dashboard';
import './admin/servizi';
import './user/archivio';
import './admin/prenotazione';
import './admin/camere';


//navbar all'inizio trasparente, poi cambia colore se si scorre
// document.addEventListener('DOMContentLoaded', () => {
//     const navbar = document.getElementById('navbarGuest');
//     window.addEventListener('scroll', () => {
//         if (window.scrollY > 10) {
//             navbar.classList.remove('bg-transparent');
//             navbar.classList.add('bg-[#2b2b2b]');
//         } else {
//             navbar.classList.add('bg-transparent');
//             navbar.classList.remove('bg-[#2b2b2b]');
//         }
//     });
// });

// document.addEventListener('DOMContentLoaded', () => {
//     const navbar = document.getElementById('navbarApp');
//     window.addEventListener('scroll', () => {
//         if (window.scrollY > 10) {
//             navbar.classList.remove('bg-transparent');
//             navbar.classList.add('bg-[#2b2b2b]');
//         } else {
//             navbar.classList.add('bg-transparent');
//             navbar.classList.remove('bg-[#2b2b2b]');
//         }
//     });
// });


// document.addEventListener('DOMContentLoaded', () => {
//     const toggle = document.getElementById('mobile-menu-toggle');
// const menu = document.getElementById('mobile-menu');

// if (toggle && menu) {
//     toggle.addEventListener('click', () => {
//         menu.classList.toggle('hidden');
//     });
// }

// });

//effetto di scrittura pagina iniziale
// document.addEventListener("DOMContentLoaded", () => {
//     const element = document.getElementById("slogan");
//     if (element) {
//         const text = '"A timeless experience where elegance meets history"';
//         let i = 0;

//         function typeWriter() {
//             if (i < text.length) {
//                 element.innerHTML += text.charAt(i);
//                 i++;
//                 setTimeout(typeWriter, 50); 
//             }
//         }

//         setTimeout(typeWriter, 1000);
//     }
// });

//per gestire il calendario, arrivo e partenza
// document.addEventListener('DOMContentLoaded', () => {
//     const endPicker = flatpickr("#data_fine", {
//         dateFormat: "d-m-Y",
//         altInput: true,
//         altFormat: "d F Y",
//         minDate: "today"
//     });

//     const startPicker = flatpickr("#data_inizio", {
//         dateFormat: "d-m-Y",
//         altInput: true,
//         altFormat: "d F Y",
//         minDate: "today",
//         onChange: function (selectedDates) {
//             if (selectedDates.length > 0) {
//                 const selectedDate = selectedDates[0];
//                 const nextDay = new Date(selectedDate);
//                 nextDay.setDate(nextDay.getDate() + 1);
//                 endPicker.set('minDate', nextDay);
//                 endPicker.jumpToDate(nextDay);
//                 endPicker.open();
//             }
//         }
//     });
// });

//per aprire la lightbox dell'immagine e chiuderla
// document.addEventListener('DOMContentLoaded', () => {
//     const modal = document.getElementById('lightbox');
//     const modalImg = document.getElementById('lightbox-img');
//     const closeBtn = document.getElementById('lightbox-close');

//     if (!modal || !modalImg || !closeBtn) {
//         console.warn('Lightbox non trovato nel DOM');
//         return;
//     }

//     document.querySelectorAll('.img-preview').forEach(img => {
//         img.addEventListener('click', () => {
//             modalImg.src = img.dataset.src;
//             modal.style.display = 'flex';
//             setTimeout(() => modal.style.opacity = '1', 10);
//         });
//     });

//     closeBtn.addEventListener('click', () => {
//         modal.style.opacity = '0';
//         setTimeout(() => modal.style.display = 'none', 300);
//     });

//     modal.addEventListener('click', (e) => {
//         if (e.target === modal) {
//             modal.style.opacity = '0';
//             setTimeout(() => modal.style.display = 'none', 300);
//         }
//     });

//     document.addEventListener('keydown', (e) => {
//         if (e.key === 'Escape' && modal.style.display === 'flex') {
//             modal.style.opacity = '0';
//             setTimeout(() => modal.style.display = 'none', 300);
//         }
//     });
// });

//aprire e chiudere il modale accedi/registrati/torna indietro
// window.apriModale = function(id) {
//     const modale = document.getElementById(id);
//     if (modale) {
//         modale.classList.remove('hidden');
//         modale.classList.add('flex');
//     }
// }

// window.chiudiModale = function(id) {
//     const modale = document.getElementById(id);
//     if (modale) {
//         modale.classList.remove('flex');
//         modale.classList.add('hidden');
//     }
// }


//da rivedere!
// document.addEventListener("DOMContentLoaded", function () {
//     let dateOccupate = new Set();
//     let dateOccupate2 = new Set();

//     // 1. Date occupate per ARRIVO (check-in) → blocca da check_in (incluso) a check_out (escluso)
//     if (typeof window.dateOccupate !== 'undefined') {
//         window.dateOccupate.forEach(range => {
//             let current = new Date(range.from);
//             const end = new Date(range.to);

//             while (current < end) {
//                 dateOccupate.add(current.toISOString().split("T")[0]);
//                 current.setDate(current.getDate() + 1);
//             }
//         });
//     }

//     // 2. Date occupate per PARTENZA (check-out) → blocca da check_in (escluso) a check_out (incluso)
//     if (typeof window.dateOccupate2 !== 'undefined') {
//         window.dateOccupate2.forEach(range => {
//             const inizio = new Date(range.from);
//             const fine = new Date(range.to);

//             let current = new Date(inizio);
//             current.setDate(current.getDate() + 1); // salta check-in

//             while (current <= fine) {
//                 dateOccupate2.add(current.toISOString().split("T")[0]);
//                 current.setDate(current.getDate() + 1);
//             }
//         });
//     }

//    // 4. Flatpickr per data_fine (PARTENZA) — PRIMA!
// const endPicker = flatpickr("#data_fine", {
//     dateFormat: "Y-m-d",
//     altInput: true,
//     altFormat: "d F Y",
//     minDate: "today",
//     disable: Array.from(dateOccupate2),
//     onChange: function (selectedDates) {
//         const dataInizio = document.querySelector("#data_inizio").value;
//         const dataFine = selectedDates.length > 0 ? selectedDates[0] : null;

//         if (dataInizio && dataFine) {
//             const inizio = new Date(dataInizio);
//             const fine = new Date(dataFine);
//             const controllo = new Date(inizio);

//             let intervalloValido = true;

//             // Verifica tutte le notti da inizio a fine (esclusa fine)
//             while (controllo < fine) {
//                 const check = controllo.toISOString().split("T")[0];
//                 if (dateOccupate.has(check)) {
//                     intervalloValido = false;
//                     break;
//                 }
//                 controllo.setDate(controllo.getDate() + 1);
//             }

//             if (!intervalloValido) {
//                 const alertBox = document.getElementById('date-error-alert');
//                 if (alertBox) {
//                     alertBox.classList.remove('hidden');
//                     setTimeout(() => {
//                         alertBox.classList.add('opacity-100');
//                     }, 10);
            
//                     // Nasconde automaticamente dopo 4 secondi
//                     setTimeout(() => {
//                         alertBox.classList.remove('opacity-100');
//                         setTimeout(() => {
//                             alertBox.classList.add('hidden');
//                         }, 500);
//                     }, 4000);
//                 }
            
//                 endPicker.clear();
                           
//             }
            
//         }
//     }
// });

// // 3. Flatpickr per data_inizio (ARRIVO) — DOPO
// const startPicker = flatpickr("#data_inizio", {
//     dateFormat: "Y-m-d",
//     altInput: true,
//     altFormat: "d F Y",
//     minDate: "today",
//     disable: Array.from(dateOccupate),
//     onChange: function (selectedDates) {
//         if (selectedDates.length > 0) {
//             const selectedDate = selectedDates[0];
//             const nextDay = new Date(selectedDate);
//             nextDay.setDate(nextDay.getDate() + 1);

//             endPicker.set('minDate', nextDay);
//             endPicker.jumpToDate(nextDay);
//             endPicker.open();
//         }
//     }
// });

// });


//messaggio errore autenticazione
// document.addEventListener('DOMContentLoaded', function () {
//     const closeBtn = document.getElementById('close-error-alert');
//     const alertBox = document.getElementById('error-alert');

//     if (closeBtn && alertBox) {
//         closeBtn.addEventListener('click', () => {
//             alertBox.classList.add('opacity-0');
//             alertBox.classList.add('pointer-events-none');
//             setTimeout(() => {
//                 alertBox.remove();
//             }, 300);
//         });
//     }
// });

// //vedere la password nel login
// window.togglePasswordVisibility = function () {
//     const input = document.getElementById('password');
//     const icon = document.getElementById('eye-icon');

//     if (input.type === 'password') {
//         input.type = 'text';
//     } else {
//         input.type = 'password';
//     }
// };

//gestione calendario
// document.addEventListener("DOMContentLoaded", function () {
//     const inizioInput = document.getElementById("data_inizio");
//     const fineInput = document.getElementById("data_fine");
//     const resetBtn = document.getElementById("resettaDate");
//     const bottonePrenota = document.getElementById("bottonePrenota");

//     let dateOccupate = new Set();
//     let dateOccupate2 = new Set();

//     if (typeof window.dateOccupate !== 'undefined') {
//         window.dateOccupate.forEach(range => {
//             let current = new Date(range.from);
//             const end = new Date(range.to);
//             while (current < end) {
//                 dateOccupate.add(current.toISOString().split("T")[0]);
//                 current.setDate(current.getDate() + 1);
//             }
//         });
//     }

//     if (typeof window.dateOccupate2 !== 'undefined') {
//         window.dateOccupate2.forEach(range => {
//             let current = new Date(range.from);
//             current.setDate(current.getDate() + 1);
//             const end = new Date(range.to);
//             while (current <= end) {
//                 dateOccupate2.add(current.toISOString().split("T")[0]);
//                 current.setDate(current.getDate() + 1);
//             }
//         });
//     }

//     const endPicker = flatpickr(fineInput, {
//         dateFormat: "Y-m-d",
//         altInput: true,
//         altFormat: "d F Y",
//         minDate: "today",
//         disable: Array.from(dateOccupate2),
//         onChange: function (selectedDates) {
//             const dataInizio = inizioInput.value;
//             const dataFine = selectedDates.length > 0 ? selectedDates[0] : null;

//             if (dataInizio && dataFine) {
//                 const inizio = new Date(dataInizio);
//                 const fine = new Date(dataFine);
//                 const controllo = new Date(inizio);
//                 let valido = true;

//                 while (controllo < fine) {
//                     const check = controllo.toISOString().split("T")[0];
//                     if (dateOccupate.has(check)) {
//                         valido = false;
//                         break;
//                     }
//                     controllo.setDate(controllo.getDate() + 1);
//                 }

//                 if (!valido) {
//                     const alertBox = document.getElementById('date-error-alert');
//                     if (alertBox) {
//                         alertBox.classList.remove('hidden');
//                         setTimeout(() => alertBox.classList.add('opacity-100'), 10);
//                         setTimeout(() => {
//                             alertBox.classList.remove('opacity-100');
//                             setTimeout(() => alertBox.classList.add('hidden'), 500);
//                         }, 4000);
//                     }
//                     endPicker.clear();
//                 }
//             }
//         }
//     });

//     const startPicker = flatpickr(inizioInput, {
//         dateFormat: "Y-m-d",
//         altInput: true,
//         altFormat: "d F Y",
//         minDate: "today",
//         disable: Array.from(dateOccupate),
//         onChange: function (selectedDates) {
//             if (selectedDates.length > 0) {
//                 const selectedDate = selectedDates[0];
//                 const nextDay = new Date(selectedDate);
//                 nextDay.setDate(nextDay.getDate() + 1);
//                 endPicker.set('minDate', nextDay);
//                 endPicker.jumpToDate(nextDay);
//                 endPicker.open();
//             }
//         }
//     });

//     window.resettaDate = function () {
//         startPicker.clear();
//         endPicker.clear();
//         aggiornaVisibilitaReset();
//     };

//     if (resetBtn) {
//         resetBtn.addEventListener("click", window.resettaDate);
//     }

//     function aggiornaVisibilitaReset() {
//         if (!resetBtn) return;
        
//         const hasStart = inizioInput.value.trim() !== "";
//         const hasEnd = fineInput.value.trim() !== "";
    
//         if (hasStart || hasEnd) {
//             resetBtn.classList.remove('hidden');
//         } else {
//             resetBtn.classList.add('hidden');
//         }
//     }
    
//     // Mostra/Nasconde il pulsante se cambiano i valori
//     inizioInput.addEventListener("input", aggiornaVisibilitaReset);
//     fineInput.addEventListener("input", aggiornaVisibilitaReset);
    
//     // Anche dopo un cambio tramite Flatpickr (non solo digitazione)
//     startPicker.config.onChange.push(aggiornaVisibilitaReset);
//     endPicker.config.onChange.push(aggiornaVisibilitaReset);
    
//     // Nascondi all'inizio
//     aggiornaVisibilitaReset();

//     function aggiornaVisibilitaPrenota() {
//         if (!bottonePrenota) return;


//         const hasStart = inizioInput.value.trim() !== "";
//         const hasEnd = fineInput.value.trim() !== "";
    
//         if (hasStart && hasEnd) {
//             // Mostra con fade-in
//             bottonePrenota.classList.remove('hidden');
//             setTimeout(() => bottonePrenota.classList.add('opacity-100'), 10);
//         } else {
//             // Nascondi con fade-out
//             bottonePrenota.classList.remove('opacity-100');
//             setTimeout(() => bottonePrenota.classList.add('hidden'), 300); // dopo la dissolvenza
//         }
//     }

//     inizioInput.addEventListener("input", aggiornaVisibilitaPrenota);
// fineInput.addEventListener("input", aggiornaVisibilitaPrenota);

// startPicker.config.onChange.push(aggiornaVisibilitaPrenota);
// endPicker.config.onChange.push(aggiornaVisibilitaPrenota);

// aggiornaVisibilitaPrenota();
    
    
// });

















