document.querySelectorAll('.counter').forEach(counter => {
    const target = +counter.getAttribute('data-target');
    let count = 0;
    const increment = target / 100; // Скорость анимации

    const updateCounter = () => {
        count += increment;
        if (count < target) {
            counter.textContent = Math.floor(count);
            requestAnimationFrame(updateCounter);
        } else {
            counter.textContent = target;
        }
    };

    updateCounter();
});
