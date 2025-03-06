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

Alpine.magic('fade', (el, {Alpine}) => {
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
    }, {threshold: 0.5});

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

import Swiper from 'swiper';
import {Autoplay} from "swiper/modules";
import 'swiper/css';

const gallerySlider = new Swiper(".gallery-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 1500,
    },
    slidesPerView: 4.5,
    spaceBetween: 20,
    loop: true,
});

const galleryMdSlider = new Swiper(".gallery-md-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 1500,
    },
    slidesPerView: 3,
    spaceBetween: 10,
    loop: true,
});

const gallerySmSlider = new Swiper(".gallery-sm-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 1500,
    },
    slidesPerView: 2.3,
    spaceBetween: 15,
    loop: true,
});

const servicesSlider = new Swiper(".slider-services", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 3.7,
    spaceBetween: 10,
    loop: true,
});
const servicesMdSlider = new Swiper(".slider-md-services", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 2.7,
    spaceBetween: 10,
    loop: true,
});
const servicesSmSlider = new Swiper(".slider-sm-services", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 1.5,
    spaceBetween: 10,
    loop: true,
});


const nextButton = document.querySelector("#services-next");
const prevButton = document.querySelector("#services-prev");

nextButton.addEventListener("click", () => servicesSlider.slideNext());
nextButton.addEventListener("click", () => servicesMdSlider.slideNext());
nextButton.addEventListener("click", () => servicesSmSlider.slideNext());
prevButton.addEventListener("click", () => servicesSlider.slidePrev());
prevButton.addEventListener("click", () => servicesMdSlider.slidePrev());
prevButton.addEventListener("click", () => servicesSmSlider.slidePrev());

const partnersSlider = new Swiper(".partners-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 5,
    spaceBetween: 30,
    freeMode: true,
});

const partnersMdSlider = new Swiper(".partners-md-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 4,
    spaceBetween: 30,
    freeMode: true,
});

const partnersSmSlider = new Swiper(".partners-sm-slider", {
    modules: [Autoplay],
    autoplay: {
        delay: 2500,
    },
    slidesPerView: 3,
    spaceBetween: 30,
    freeMode: true,
});

Alpine.start();


