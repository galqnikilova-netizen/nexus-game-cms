import './bootstrap';

const header = document.querySelector('.site-header');
const toggle = document.querySelector('.menu-toggle');
const navigation = document.querySelector('#primary-navigation');

toggle?.addEventListener('click', () => {
    const open = header.classList.toggle('menu-open');
    toggle.setAttribute('aria-expanded', String(open));
});

navigation?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
    header.classList.remove('menu-open');
    toggle?.setAttribute('aria-expanded', 'false');
}));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        header?.classList.remove('menu-open');
        toggle?.setAttribute('aria-expanded', 'false');
    }
});
