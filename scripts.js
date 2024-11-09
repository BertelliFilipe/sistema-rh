// Seleção de elementos
const loginBtn = document.getElementById('login-btn');
const modal = document.getElementById('login-modal');
const closeBtn = document.querySelector('.close');

// Função para abrir o modal de login
function openModal() {
    modal.style.display = 'block';
}

// Função para fechar o modal de login
function closeModal() {
    modal.style.display = 'none';
}

// Abrir modal ao clicar no botão de login
loginBtn.addEventListener('click', openModal);

// Fechar modal ao clicar no botão de fechar
closeBtn.addEventListener('click', closeModal);

// Fechar modal ao clicar fora do modal
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        closeModal();
    }
});

// Fechar modal ao pressionar a tecla "Esc" (acessibilidade)
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && modal.style.display === 'block') {
        closeModal();
    }
});

