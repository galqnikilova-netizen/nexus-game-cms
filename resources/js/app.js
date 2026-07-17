import './bootstrap';

const n3Menu = document.querySelector('#n3-menu');
const toggleN3Menu = (open) => {
    if (!n3Menu) return;
    n3Menu.classList.toggle('open', open);
    n3Menu.setAttribute('aria-hidden', String(!open));
    document.body.style.overflow = open ? 'hidden' : '';
};
document.querySelector('[data-n3-menu-open]')?.addEventListener('click', () => toggleN3Menu(true));
n3Menu?.querySelectorAll('[data-n3-menu-close],a').forEach((item) => item.addEventListener('click', () => toggleN3Menu(false)));

const setSheet = (sheet, open) => {
    if (!sheet) return;
    sheet.classList.toggle('is-open', open);
    sheet.classList.toggle('open', open);
    sheet.setAttribute('aria-hidden', String(!open));
    document.body.classList.toggle('overflow-hidden', open);
};

const adminSheet = document.querySelector('#n3-admin-menu');
document.querySelector('[data-admin-sheet-open]')?.addEventListener('click', () => setSheet(adminSheet, true));
adminSheet?.querySelectorAll('[data-admin-sheet-close], a').forEach((item) => item.addEventListener('click', () => setSheet(adminSheet, false)));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') { toggleN3Menu(false); setSheet(adminSheet, false); }
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
    document.querySelectorAll('[data-server-filter]').forEach((item) => item.classList.toggle('active', item === button));
    applyServerFilters();
}));
document.querySelectorAll('[data-server-game]').forEach((button) => button.addEventListener('click', () => {
    const selected = button.classList.contains('active');
    document.querySelectorAll('[data-server-game]').forEach((item) => item.classList.remove('active'));
    button.classList.toggle('active', !selected);
    gameFilter = selected ? 'all' : button.dataset.serverGame;
    applyServerFilters();
}));

const setModal = (modal, open) => {
    if (!modal) return;
    modal.classList.toggle('is-open', open);
    modal.classList.toggle('open', open);
    modal.setAttribute('aria-hidden', String(!open));
    document.body.classList.toggle('overflow-hidden', open);
};

const balanceModal = document.querySelector('#balance-modal');
document.querySelectorAll('[data-balance-open]').forEach((button) => button.addEventListener('click', () => setModal(balanceModal, true)));

const productModal = document.querySelector('#product-modal');
document.querySelectorAll('[data-product-open]').forEach((button) => button.addEventListener('click', () => {
    const form = document.querySelector('#purchase-form');
    if (form) form.action = `/shop/${button.dataset.productId}/purchase`;
    const title = document.querySelector('#purchase-title');
    const price = document.querySelector('#purchase-price');
    if (title) title.textContent = button.dataset.productName;
    if (price) price.textContent = `${Number(button.dataset.productPrice).toFixed(2)} EUR`;
    setModal(productModal, true);
}));

document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => {
    setModal(button.closest('.n3-modal'), false);
}));

document.querySelectorAll('[data-amount]').forEach((button) => button.addEventListener('click', () => {
    const input = document.querySelector('#balance-amount');
    if (input) input.value = button.dataset.amount;
    document.querySelectorAll('[data-amount]').forEach((item) => item.classList.toggle('is-active', item === button));
}));

const colorInput = document.querySelector('#accent-color');
colorInput?.addEventListener('input', (event) => {
    document.documentElement.style.setProperty('--n3-accent', event.target.value);
    document.documentElement.style.setProperty('--span', event.target.value);
    const hex = event.target.value.replace('#', '');
    if (hex.length === 6) document.documentElement.style.setProperty('--n3-rgb', `${parseInt(hex.slice(0,2),16)},${parseInt(hex.slice(2,4),16)},${parseInt(hex.slice(4,6),16)}`);
});
