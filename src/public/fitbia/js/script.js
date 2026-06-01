// Seleciona os elementos do menu
const btnMenu = document.getElementById('menu-toggle');
const navMenu = document.getElementById('nav-menu');
const iconeMenu = btnMenu.querySelector('i');

// Adiciona o evento de clique no botão hambúrguer
btnMenu.addEventListener('click', () => {
    // Liga/Desliga a classe 'ativo' no menu (que faz ele descer ou subir no CSS)
    navMenu.classList.toggle('ativo');
    
    // Troca o ícone de hambúrguer para 'X' ao abrir, e volta para hambúrguer ao fechar
    if(navMenu.classList.contains('ativo')) {
        iconeMenu.classList.remove('ph-list');
        iconeMenu.classList.add('ph-x');
    } else {
        iconeMenu.classList.remove('ph-x');
        iconeMenu.classList.add('ph-list');
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const btnLogin = document.getElementById("btn-login"); // O ícone de usuário
    const modal = document.getElementById("modal-login");
    const btnFechar = document.getElementById("fechar-modal");

    // Abrir o modal ao clicar no ícone
    btnLogin.addEventListener("click", (e) => {
        e.preventDefault(); // Evita que a página recarregue se o ícone for uma tag <a>
        modal.style.display = "flex";
    });

    // Fechar o modal ao clicar no 'X'
    btnFechar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Fechar o modal ao clicar fora da caixinha (no overlay escuro)
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});