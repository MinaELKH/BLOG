const menuButton = document.getElementById('menu-button');
const menu = document.getElementById('menuBurger');
menuButton.addEventListener('click', () => {
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
    } else {
            menu.classList.add('hidden');
    
    }
});


