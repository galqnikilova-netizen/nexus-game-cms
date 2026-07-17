import './bootstrap';

const toggleDrawer = (drawer, open) => {
    if (!drawer) return;
    const panel = drawer.querySelector('aside');
    drawer.classList.toggle('pointer-events-none', !open);
    drawer.classList.toggle('opacity-0', !open);
    panel?.classList.toggle('translate-x-full', !open && panel.classList.contains('right-0'));
    panel?.classList.toggle('-translate-x-full', !open && panel.classList.contains('left-0'));
    document.body.classList.toggle('overflow-hidden', open);
};

const mobile = document.querySelector('#nx-mobile-menu');
document.querySelector('#nx-menu-open')?.addEventListener('click', () => toggleDrawer(mobile, true));
mobile?.querySelectorAll('[data-nx-menu-close], a').forEach((item) => item.addEventListener('click', () => toggleDrawer(mobile, false)));

const adminMobile = document.querySelector('#nx-admin-menu');
document.querySelector('#nx-admin-menu-open')?.addEventListener('click', () => toggleDrawer(adminMobile, true));
adminMobile?.querySelectorAll('[data-nx-admin-close], a').forEach((item) => item.addEventListener('click', () => toggleDrawer(adminMobile, false)));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') { toggleDrawer(mobile, false); toggleDrawer(adminMobile, false); }
});

const browser = document.querySelector('[data-server-browser]');
document.querySelectorAll('[data-server-view]').forEach((button, index) => button.addEventListener('click', () => {
    browser?.children[0]?.classList.toggle('hidden', index === 1);
    browser?.children[1]?.classList.toggle('hidden', index === 0);
    document.querySelectorAll('[data-server-view]').forEach((item) => {
        item.classList.toggle('bg-[var(--accent)]', item === button);
        item.classList.toggle('text-black', item === button);
        item.classList.toggle('text-slate-500', item !== button);
    });
}));

document.querySelectorAll('[data-copy-server]').forEach((button) => button.addEventListener('click', async () => {
    await navigator.clipboard.writeText(button.dataset.copyServer);
    button.textContent = 'COPIED'; setTimeout(() => { button.textContent = 'COPY IP'; }, 1200);
}));

const colorInput = document.querySelector('#accent-color');
colorInput?.addEventListener('input', (event) => document.body.style.setProperty('--accent', event.target.value));
