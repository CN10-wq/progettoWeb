//serve per cambiare lo stile della navbarApp
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbarApp');
    if (!navbar) return;

    const changeNavbarStyle = () => {
        if (window.scrollY > 10) {
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-sfondo'); 
        } else {
            navbar.classList.add('bg-transparent');
            navbar.classList.remove('bg-sfondo');
        }
    };

    changeNavbarStyle();

    window.addEventListener('scroll', changeNavbarStyle);
});
