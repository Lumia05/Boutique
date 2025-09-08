import './bootstrap';
document.addEventListener('DOMContentLoaded', function() {
    window.toggleSubcategories = function(button) {
        const subcategoriesList = button.nextElementSibling;
        const arrow = button.querySelector('svg');

        if (subcategoriesList) {
            const isExpanded = subcategoriesList.classList.contains('active');

            if (isExpanded) {
                subcategoriesList.classList.remove('active');
                subcategoriesList.style.maxHeight = '0';
                arrow.classList.remove('rotate-180');
            } else {
                subcategoriesList.classList.add('active');
                subcategoriesList.style.maxHeight = subcategoriesList.scrollHeight + 'px';
                arrow.classList.add('rotate-180');
            }
        }
    };
});