document.addEventListener("DOMContentLoaded", function() {
    console.log("El archivo filter.js se ha cargado"); // Mensaje de depuración
    document.querySelector('.filter-toggle').addEventListener('click', function() {
        const filterForm = document.querySelector('.filter-form');
        if (filterForm.style.display === 'none' || filterForm.style.display === '') {
            filterForm.style.display = 'block';
            this.textContent = 'Ocultar Filtros';
        } else {
            filterForm.style.display = 'none';
            this.textContent = 'Mostrar Filtros';
        }
    });
});