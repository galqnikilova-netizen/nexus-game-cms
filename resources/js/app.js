import './bootstrap';

const mobileMenu = document.querySelector('.mobile-menu');

mobileMenu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => mobileMenu.removeAttribute('open'));
});

document.addEventListener('click', (event) => {
    if (mobileMenu?.open && !mobileMenu.contains(event.target)) mobileMenu.removeAttribute('open');
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') mobileMenu?.removeAttribute('open');
});
