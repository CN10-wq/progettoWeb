//serve per gestire diversi effetti (titolo, scroll) nella pagina introduttiva
document.addEventListener("DOMContentLoaded", () => {
    const introSection = document.getElementById("intro");
    const element = document.getElementById("slogan");
    const scrollBtn = document.getElementById("scrollToTopBtn");

    if (!introSection || !element) return;

    const text = '"Ogni stanza, un capolavoro"';
    let i = 0;
    const typeWriter = () => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    };
    element.textContent = '';
    setTimeout(typeWriter, 1000);

    window.addEventListener('wheel', (e) => {
        if (e.deltaY > 0 && window.scrollY < window.innerHeight * 0.5) {
            introSection.scrollIntoView({ behavior: 'smooth' });
        }
    }, { passive: true });

    window.addEventListener('scroll', () => {
        if (scrollBtn) {
            scrollBtn.classList.toggle('hidden', window.scrollY < window.innerHeight * 0.6);
        }
    });
});


//serve per la gestione dell'apertura e chiusura di un faq per le domande nella pagina introduttiva
window.toggleFaq = function (btn) {
    const faqItem = btn.closest('.faq-item');
    if (!faqItem) return;

    const content = faqItem.querySelector('.faq-content');
    const icon = btn.querySelector('.faq-toggle-icon');

    if (!content || !icon) return;

    content.classList.toggle('hidden');
    icon.textContent = content.classList.contains('hidden') ? '+' : '−';
}
