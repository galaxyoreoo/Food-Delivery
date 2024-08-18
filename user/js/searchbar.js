document.addEventListener('DOMContentLoaded', () => {
    const searchBarContainer = document.querySelector('.search-bar__container');
    const searchInput = document.querySelector('.input');
    const crossIcon = document.querySelector('.cross');
    const cancelButton = document.querySelector('.cancel');
    let clicked = false;

    searchInput.addEventListener('focus', () => {
        clicked = true;
        searchBarContainer.querySelector('.search-bar__unclicked').classList.add('search-bar__clicked');
        crossIcon.style.display = 'inline';
        cancelButton.style.display = 'inline';
    });

    crossIcon.addEventListener('click', () => {
        searchInput.value = '';
    });

    cancelButton.addEventListener('click', () => {
        clicked = false;
        searchBarContainer.querySelector('.search-bar__unclicked').classList.remove('search-bar__clicked');
        crossIcon.style.display = 'none';
        cancelButton.style.display = 'none';
        searchInput.blur();
    });
});
