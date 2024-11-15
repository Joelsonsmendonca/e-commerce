let prevScrollPos = window.pageYOffset;
const navBar = document.querySelector('.barra-navegacao');

window.onscroll = () => {
    const currentScrollPos = window.pageYOffset;

    if (prevScrollPos > currentScrollPos) {
        // Quando o usuário estiver rolando para cima, irá mostrar a barra de navegação.
        navBar.style.top = "0";
    } else {
        // Quando o usuário estiver rolando para baixo, irá esconder a barra de navegação.
        navBar.style.top = "-100px";
    }

    prevScrollPos = currentScrollPos;
};