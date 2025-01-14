import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const sidebar = document.getElementById('sidebar');
const toggleMenuButton = document.getElementById('toggle-menu');
const menu = document.getElementById('menu');
const sidebarActions = document.getElementById('sidebar-actions');
const closeIcon = document.getElementById('close-icon');
const barsIcon = document.getElementById('bars-icon');
const langSwitcher = document.getElementById('lang-switcher');
const searchForm = document.getElementById('search-form');
const fullLogo = document.getElementById('full-logo');
const smallLogo = document.getElementById('small-logo');

toggleMenuButton.addEventListener('click', () => {
    if (sidebar.classList.contains('w-64')) {
        sidebar.classList.remove('w-64');
        sidebar.classList.add('w-20');
        menu.classList.add('hidden')
        sidebarActions.classList.remove('justify-between');
        sidebarActions.classList.add('justify-center');
        closeIcon.classList.add('hidden');
        barsIcon.classList.remove('hidden');
        langSwitcher.classList.add('hidden');
        searchForm.classList.add('hidden');
        fullLogo.classList.add('hidden');
        smallLogo.classList.remove('hidden');
    } else {
        sidebar.classList.remove('w-20');
        menu.classList.remove('hidden')
        sidebar.classList.add('w-64');
        sidebarActions.classList.remove('justify-center');
        sidebarActions.classList.add('justify-between');
        closeIcon.classList.remove('hidden');
        barsIcon.classList.add('hidden');
        langSwitcher.classList.remove('hidden');
        searchForm.classList.remove('hidden');
        fullLogo.classList.remove('hidden');
        smallLogo.classList.add('hidden');
    }
});

document.querySelectorAll('.submenu-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const submenu = toggle.nextElementSibling; // Находим следующее подменю
        if (submenu) {
            submenu.classList.toggle('hidden'); // Переключаем видимость подменю
        }
    });
});

