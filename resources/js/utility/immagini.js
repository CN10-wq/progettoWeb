// Serve per mostrare l'immagine precedente in una galleria di immagini
window.gestioneCamere_prevImg = function (cameraId) {
    const indiceCorrente = window.gestioneCamere_index[cameraId] ?? 0;
    const listaImmagini = window.gestioneCamere_data.find(c => c.id === cameraId)?.immagini ?? [];
    if (listaImmagini.length === 0) return;

    const nuovoIndice = (indiceCorrente - 1 + listaImmagini.length) % listaImmagini.length;
    window.gestioneCamere_index[cameraId] = nuovoIndice;

    const nuovaSorgenteImmagine = listaImmagini[nuovoIndice].path;
    document.getElementById(`img-${cameraId}`).src = nuovaSorgenteImmagine;
};

// Serve per mostrare l'immagine successiva in una galleria di immagini
window.gestioneCamere_nextImg = function (cameraId) {
    const indiceCorrente = window.gestioneCamere_index[cameraId] ?? 0;
    const listaImmagini = window.gestioneCamere_data.find(c => c.id === cameraId)?.immagini ?? [];
    if (listaImmagini.length === 0) return;

    const nuovoIndice = (indiceCorrente + 1) % listaImmagini.length;
    window.gestioneCamere_index[cameraId] = nuovoIndice;

    const nuovaSorgenteImmagine = listaImmagini[nuovoIndice].path;
    document.getElementById(`img-${cameraId}`).src = nuovaSorgenteImmagine;
};


//serve per inizializzare le gallerie dinamiche/carousel + attivare la lightbox per singole immagini (tramite l'ausilio di una libreria esterna baguetteBox)
document.addEventListener('DOMContentLoaded', () => {
    if (typeof inizializzaGallerieDinamiche === 'function') {
        inizializzaGallerieDinamiche();
    }

    if (document.querySelector('.gallery-uno')) {
        baguetteBox.run('.gallery-uno');
    }

    if (document.querySelector('.gallery-due')) {
        baguetteBox.run('.gallery-due');
    }

    if (typeof inizializzaCarouselSincronizzati === 'function') {
        inizializzaCarouselSincronizzati();
    }

    if (document.querySelector('.gallery-intro')) {
        baguetteBox.run('.gallery-intro', {
            animation: 'fadeIn',
            noScrollbars: true,
            captions: true,
        });
    }
});


//serve per creare delle gallerie dinamiche per le camere: genera le lightbox per le immagini (con l'ausilio di una libreria esterna baguetteBox)
//e mostra le frecce per scorrere nella galleria se presente più di una immagine
function inizializzaGallerieDinamiche() {
    const gallerie = {};

    document.querySelectorAll('[id^="galleria-camera-"]').forEach(div => {
        const idCamera = parseInt(div.id.replace('galleria-camera-', ''));
        const immagini = JSON.parse(div.dataset.immagini || '[]');
        if (!immagini.length) return;

        gallerie[idCamera] = { immagini, index: 0 };
        div.innerHTML = '';

        const contenitore = document.createElement('div');
        contenitore.className = 'gallery relative group overflow-hidden shadow-md w-full max-w-md mx-auto';

        const imgVisibile = document.createElement('img');
        const pathIniziale = immagini[0].path.startsWith('/storage/')
            ? immagini[0].path
            : `/storage/immagini/${immagini[0].path}`;
        imgVisibile.src = pathIniziale;
        imgVisibile.alt = 'Camera';
        imgVisibile.id = `img-${idCamera}`;
        imgVisibile.className = 'w-full h-auto max-h-80 sm:max-h-96 object-cover cursor-pointer transition-all duration-300';

        const linkPrincipale = document.createElement('a');
        linkPrincipale.href = pathIniziale;
        linkPrincipale.appendChild(imgVisibile);
        contenitore.appendChild(linkPrincipale);

        for (let i = 1; i < immagini.length; i++) {
            const link = document.createElement('a');
            const pathCompleto = immagini[i].path.startsWith('/storage/')
                ? immagini[i].path
                : `/storage/immagini/${immagini[i].path}`;
            link.href = pathCompleto;

            const imgNascosta = document.createElement('img');
            imgNascosta.src = pathCompleto;
            imgNascosta.alt = 'Camera';
            imgNascosta.className = 'hidden';
            link.appendChild(imgNascosta);

            contenitore.appendChild(link);
        }

        if (immagini.length > 1) {
            const btnIndietro = document.createElement('button');
            btnIndietro.innerHTML = '&#10094;';
            btnIndietro.className = 'absolute top-1/2 -translate-y-1/2 left-2 text-white text-xl p-1 rounded-full bg-white/10 hover:bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300';
            btnIndietro.onclick = (e) => {
                e.preventDefault();
                const dati = gallerie[idCamera];
                dati.index = (dati.index - 1 + dati.immagini.length) % dati.immagini.length;
                const nuovoPath = dati.immagini[dati.index].path;
                imgVisibile.src = nuovoPath.startsWith('/storage/') ? nuovoPath : `/storage/immagini/${nuovoPath}`;
                linkPrincipale.href = imgVisibile.src;
            };

            const btnAvanti = document.createElement('button');
            btnAvanti.innerHTML = '&#10095;';
            btnAvanti.className = 'absolute top-1/2 -translate-y-1/2 right-2 text-white text-xl p-1 rounded-full bg-white/10 hover:bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300';
            btnAvanti.onclick = (e) => {
                e.preventDefault();
                const dati = gallerie[idCamera];
                dati.index = (dati.index + 1) % dati.immagini.length;
                const nuovoPath = dati.immagini[dati.index].path;
                imgVisibile.src = nuovoPath.startsWith('/storage/') ? nuovoPath : `/storage/immagini/${nuovoPath}`;
                linkPrincipale.href = imgVisibile.src;
            };

            contenitore.appendChild(btnIndietro);
            contenitore.appendChild(btnAvanti);
        }

        div.appendChild(contenitore);
        baguetteBox.run(`#${div.id}`);
    });
}


//serve per la gestione di 3 carousel sincronizzati di immagini di una camera, ognuno dei quali è sfasato, per avere un effetto a cascata nella diagonale delle immagini 
//(le immagini possono essere aperte sempre tramite lightbox con BaguetteBox)
function inizializzaCarouselSincronizzati() {
    const wrapperLista = document.querySelectorAll('[id^="carousel-wrapper-1-"]');

    wrapperLista.forEach(wrapper => {
        const cameraId = wrapper.id.replace('carousel-wrapper-1-', '');
        const immagini = JSON.parse(wrapper.dataset.immagini || '[]');
        if (!immagini.length) return;

        const wrapperGruppo = [
            document.getElementById(`carousel-wrapper-1-${cameraId}`),
            document.getElementById(`carousel-wrapper-2-${cameraId}`),
            document.getElementById(`carousel-wrapper-3-${cameraId}`)
        ];
        if (wrapperGruppo.some(w => !w)) return;

        let indiceCorrente = 0;

        function aggiornaCarousel() {
            wrapperGruppo.forEach((wrapper, offset) => {
                const contenitore = wrapper.querySelector('.carousel-track');
                if (!contenitore) return;

                contenitore.innerHTML = '';

                const imgIndex = (indiceCorrente + offset) % immagini.length;
                const percorso = immagini[imgIndex].path.startsWith('/storage/')
                    ? immagini[imgIndex].path
                    : `/storage/immagini/${immagini[imgIndex].path}`;

                const img = document.createElement('img');
                img.src = percorso;
                img.alt = 'Camera';
                img.className = 'object-cover transition duration-300';

                const link = document.createElement('a');
                link.href = percorso;
                link.className = 'lightbox-img';
                link.appendChild(img);

                contenitore.appendChild(link);
            });

            baguetteBox.run('.carousel-track', { animation: 'fadeIn' });
        }

        wrapperGruppo.forEach(wrapper => {
            wrapper.querySelector('.carousel-btn-prev')?.addEventListener('click', () => {
                indiceCorrente = (indiceCorrente - 1 + immagini.length) % immagini.length;
                aggiornaCarousel();
            });

            wrapper.querySelector('.carousel-btn-next')?.addEventListener('click', () => {
                indiceCorrente = (indiceCorrente + 1) % immagini.length;
                aggiornaCarousel();
            });
        });

        aggiornaCarousel();
    });
}


//rende la funzione disponibile globalmente per poterla usare anche in user/archivio.js
window.inizializzaGallerieDinamiche = inizializzaGallerieDinamiche;
