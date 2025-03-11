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
import {Autoplay, Pagination} from "swiper/modules";
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

document.addEventListener("DOMContentLoaded", function () {
    const nextButton = document.querySelector("#services-next");
    const prevButton = document.querySelector("#services-prev");

    if (nextButton && prevButton) { // Проверяем, существуют ли элементы
        nextButton.addEventListener("click", () => {
            if (servicesSlider) servicesSlider.slideNext();
            if (servicesMdSlider) servicesMdSlider.slideNext();
            if (servicesSmSlider) servicesSmSlider.slideNext();
        });
        prevButton.addEventListener("click", () => {
            if (servicesSlider) servicesSlider.slidePrev();
            if (servicesMdSlider) servicesMdSlider.slidePrev();
            if (servicesSmSlider) servicesSmSlider.slidePrev();
        });
    }
})

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

const newsSlider = new Swiper(".news-slider", {
    modules: [Autoplay, Pagination],
    autoplay: {
        delay: 2500,
    },
    pagination: {
        el: ".swiper-pagination",
    },
});

Alpine.start();

import lightGallery from 'lightgallery';

// Plugins
import lgThumbnail from 'lightgallery/plugins/thumbnail'
import lgZoom from 'lightgallery/plugins/zoom'
import 'lightgallery/css/lightgallery.css'
import 'lightgallery/css/lg-zoom.css'
import 'lightgallery/css/lg-thumbnail.css'

lightGallery(document.getElementById('lightgallery'), {
    plugins: [lgThumbnail],
    animateThumb: false,
    zoomFromOrigin: false,
    allowMediaOverlap: true,
    toggleThumb: true,
});

document.addEventListener('DOMContentLoaded', function() {
    const toggleStructureMenu = document.getElementById('toggleStructureMenu');
    const structureMenu = document.getElementById('structureMenu');
    const menuIcon = document.getElementById('structureMenuIcon');

    if (toggleStructureMenu && structureMenu && menuIcon) {
        structureMenu.style.display = 'none';

        toggleStructureMenu.addEventListener('click', function() {
            if (structureMenu.style.display === 'none' || structureMenu.style.display === '') {
                structureMenu.style.display = 'block';
                menuIcon.classList.add('rotate-90');
            } else {
                structureMenu.style.display = 'none';
                menuIcon.classList.remove('rotate-90');
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const searchModal = document.getElementById("searchModal");
    const openSearchModal = document.getElementById("openSearchModal");
    const closeSearchModal = document.getElementById("closeSearchModal");

    function openModal() {
        searchModal.classList.remove("invisible", "opacity-0", "-translate-y-10");
        searchModal.classList.add("opacity-100", "translate-y-0");
    }

    function closeModal() {
        searchModal.classList.remove("opacity-100", "translate-y-0");
        searchModal.classList.add("opacity-0", "-translate-y-10");
        setTimeout(() => {
            searchModal.classList.add("invisible");
        }, 300); // Задержка равна duration-300 в Tailwind
    }

    // Открытие модального окна
    openSearchModal.addEventListener("click", openModal);

    // Закрытие при клике вне формы
    searchModal.addEventListener("click", function (event) {
        if (event.target === searchModal) {
            closeModal();
        }
    });

    // Закрытие при нажатии Escape
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && !searchModal.classList.contains("invisible")) {
            closeModal();
        }
    });

    // Закрытие по клику на кнопку "X"
    closeSearchModal.addEventListener("click", closeModal);
});


document.addEventListener('DOMContentLoaded', function() {
    const toggleDivisions = document.querySelectorAll('.toggle-division');

    toggleDivisions.forEach(function(toggleDivision) {
        toggleDivision.addEventListener('click', function(event) {
            event.preventDefault();

            const divisionId = this.dataset.id;
            const childrenDiv = document.getElementById('children-' + divisionId);

            if (childrenDiv) {
                childrenDiv.classList.toggle('hidden');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const toggleStructureMenu = document.getElementById('toggleStructureMenu');
    const structureMenu = document.getElementById('structureMenu');
    const structureMenuIcon = document.getElementById('structureMenuIcon');

    toggleStructureMenu.addEventListener('click', function() {
        structureMenu.classList.toggle('hidden');
        structureMenuIcon.classList.toggle('rotate-90');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const toggleMobileDivisions = document.querySelectorAll('.toggle-mobile-division');

    toggleMobileDivisions.forEach(function(toggleMobileDivision) {
        toggleMobileDivision.addEventListener('click', function() {
            const divisionId = this.dataset.id;
            const childrenDiv = document.getElementById('mobile-children-' + divisionId);

            if (childrenDiv) {
                childrenDiv.classList.toggle('hidden');
            }
        });
    });
});



