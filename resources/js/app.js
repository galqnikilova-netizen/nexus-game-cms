import './bootstrap';

const setSheet = (sheet, open) => {
    if (!sheet) return;
    sheet.classList.toggle('is-open', open);
    sheet.setAttribute('aria-hidden', String(!open));
    document.body.classList.toggle('overflow-hidden', open);
};

const publicSheet = document.querySelector('#nx-mobile-menu');
document.querySelector('[data-mobile-sheet-open]')?.addEventListener('click', () => setSheet(publicSheet, true));
publicSheet?.querySelectorAll('[data-mobile-sheet-close], a').forEach((item) => item.addEventListener('click', () => setSheet(publicSheet, false)));

const adminSheet = document.querySelector('#nx-admin-menu');
document.querySelector('[data-admin-sheet-open]')?.addEventListener('click', () => setSheet(adminSheet, true));
adminSheet?.querySelectorAll('[data-admin-sheet-close], a').forEach((item) => item.addEventListener('click', () => setSheet(adminSheet, false)));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') { setSheet(publicSheet, false); setSheet(adminSheet, false); }
});

document.querySelectorAll('[data-copy-server]').forEach((button) => button.addEventListener('click', async (event) => {
    event.preventDefault();
    try {
        await navigator.clipboard.writeText(button.dataset.copyServer);
        const original = button.textContent;
        button.textContent = 'COPIED';
        setTimeout(() => { button.textContent = original; }, 1200);
    } catch (_) {
        button.textContent = button.dataset.copyServer;
    }
}));

const rows = [...document.querySelectorAll('[data-server-row]')];
const search = document.querySelector('[data-server-search]');
let statusFilter = 'all';
let gameFilter = 'all';

const applyServerFilters = () => {
    const query = (search?.value || '').trim().toLowerCase();
    rows.forEach((row) => {
        const matchesStatus = statusFilter === 'all' || row.dataset.status === statusFilter;
        const matchesGame = gameFilter === 'all' || row.dataset.game === gameFilter;
        const matchesSearch = !query || row.dataset.search.includes(query);
        row.hidden = !(matchesStatus && matchesGame && matchesSearch);
    });
};

search?.addEventListener('input', applyServerFilters);
document.querySelectorAll('[data-server-filter]').forEach((button) => button.addEventListener('click', () => {
    statusFilter = button.dataset.serverFilter;
    document.querySelectorAll('[data-server-filter]').forEach((item) => item.classList.toggle('is-active', item === button));
    applyServerFilters();
}));
document.querySelectorAll('[data-server-game]').forEach((button) => button.addEventListener('click', () => {
    const selected = button.classList.contains('is-active');
    document.querySelectorAll('[data-server-game]').forEach((item) => item.classList.remove('is-active'));
    button.classList.toggle('is-active', !selected);
    gameFilter = selected ? 'all' : button.dataset.serverGame;
    applyServerFilters();
}));

const colorInput = document.querySelector('#accent-color');
colorInput?.addEventListener('input', (event) => {
    document.documentElement.style.setProperty('--nx-accent', event.target.value);
    document.documentElement.style.setProperty('--accent', event.target.value);
    const hex = event.target.value.replace('#', '');
    if (hex.length === 6) document.documentElement.style.setProperty('--nx-accent-rgb', `${parseInt(hex.slice(0,2),16)},${parseInt(hex.slice(2,4),16)},${parseInt(hex.slice(4,6),16)}`);
});
