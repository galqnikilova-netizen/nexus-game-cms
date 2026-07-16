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

const colorInput = document.querySelector('#accent-color');
const colorOutput = document.querySelector('#accent-output');
const previewName = document.querySelector('#preview-name');
const siteName = document.querySelector('#site-name');
const applyPreview = (color) => { if (!color) return; document.body.style.setProperty('--accent', color); if (colorOutput) colorOutput.textContent = color.toUpperCase(); };
colorInput?.addEventListener('input', (event) => applyPreview(event.target.value));
siteName?.addEventListener('input', (event) => { if (previewName) previewName.textContent = event.target.value || 'NEXUS'; });
document.querySelectorAll('[data-color]').forEach((button) => button.addEventListener('click', () => { colorInput.value = button.dataset.color; applyPreview(button.dataset.color); }));

const serverBrowser = document.querySelector('[data-server-browser]');
document.querySelectorAll('[data-server-view]').forEach((button) => {
    button.addEventListener('click', () => {
        const view = button.dataset.serverView;
        serverBrowser.dataset.view = view;
        document.querySelectorAll('[data-server-view]').forEach((item) => item.classList.toggle('active', item === button));
        localStorage.setItem('nexus-server-view', view);
    });
});
if (serverBrowser) {
    const savedView = localStorage.getItem('nexus-server-view');
    if (['cards', 'table'].includes(savedView)) serverBrowser.querySelector(`[data-server-view="${savedView}"]`)?.click();
}
document.querySelectorAll('[data-copy-server]').forEach((button) => button.addEventListener('click', async () => {
    await navigator.clipboard.writeText(button.dataset.copyServer);
    const label = button.textContent;
    button.textContent = 'COPIED';
    setTimeout(() => { button.textContent = label; }, 1200);
}));
