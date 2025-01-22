const swiperTop = new Swiper(".mySwiper", {
    autoplay: {
        delay: 5000,
    },
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: ".swiper-next-top",
        prevEl: ".swiper-prev-top",
    },
});

const swiperServices = new Swiper(".slider-services", {
    autoplay: {
        delay: 3000,
    },
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-next-services",
        prevEl: ".swiper-prev-services",
    },
});


const swiperServicesMobile = new Swiper(".slider-services-mobile", {
    autoplay: {
        delay: 3000,
    },
    slidesPerView: 1,
    spaceBetween: 30,
    navigation: {
        nextEl: ".swiper-next-services",
        prevEl: ".swiper-prev-services",
    },
});
