document.addEventListener('DOMContentLoaded', function() {
    const userIcon = document.getElementById('user-icon');
    const dropdownMenu = document.getElementById('dropdown-menu');

    userIcon.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
    });

    window.addEventListener('click', function(event) {
        if (!event.target.matches('.user-icon')) {
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            }
        }
    });
});
