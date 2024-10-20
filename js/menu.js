// Selección de los elementos del DOM
const menu = document.getElementById('menu');
const hamburger = document.getElementById('hamburger-menu');

// Evento para abrir/cerrar el menú al hacer clic en el ícono de hamburguesa
hamburger.addEventListener('click', () => {
    menu.classList.toggle('active');
});
