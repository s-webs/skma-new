import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'

window.Alpine = Alpine;

const sidebarMobile = document.getElementById('sidebarMobile');
const closeMobileSidebar = document.getElementById('closeMobileSidebar');
const openMobileSidebar = document.getElementById('openMobileSidebar');

closeMobileSidebar.addEventListener('click', () => {
    sidebarMobile.classList.add('-translate-x-full')
    sidebarMobile.classList.remove('translate-x-full');
})

openMobileSidebar.addEventListener('click', () => {
    console.log('click')
    sidebarMobile.classList.add('translate-x-none')
    sidebarMobile.classList.remove('-translate-x-full')
})

new isvek.Bvi({
    target: '#enable-pc-impaired',
    fontSize: 24,
    theme: 'white'
    //...etc
});

Alpine.data('mobileMenu', () => ({
    openMenu: null,

    toggleSubMenu(index) {
        this.openMenu = this.openMenu === index ? null : index;
    }
}));

Alpine.data('formSearch', () => ({
    searchQuery: '',
    resetForm() {
        this.searchQuery = '';
    }
}));

Alpine.magic('fade', (el, { Alpine }) => {
    let isVisible = false;

    Alpine.effect(() => {
        if (isVisible) {
            el.classList.remove('fade-in-enter-from');
            el.classList.add('fade-in-enter-active');
        } else {
            el.classList.remove('fade-in-enter-active');
            el.classList.add('fade-in-enter-from');
        }
    });

    return () => {
        isVisible = !isVisible;
    };
});

document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll(".counter");
    let hasAnimated = false;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !hasAnimated) {
                hasAnimated = true;
                startCounters();
                observer.disconnect(); // Отключаем после анимации
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll(".counter").forEach(counter => observer.observe(counter.parentElement));

    function startCounters() {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute("data-count");
                const count = +counter.innerText;
                const speed = target / 130; // Скорость анимации

                if (count < target) {
                    counter.innerText = Math.ceil(count + speed);
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    }
});


Alpine.start();


