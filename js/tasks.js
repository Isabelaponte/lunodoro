document.addEventListener('DOMContentLoaded', function () {
    const expandButtons = document.querySelectorAll('.expand-btn');

    expandButtons.forEach(button => {
        button.addEventListener('click', function () {
            const taskItem = this.closest('.task-item');
            taskItem.classList.toggle('expanded');
            this.textContent = taskItem.classList.contains('expanded') ? 'Ocultar Detalhes' : 'Mostrar Detalhes';
        });
    });
});
