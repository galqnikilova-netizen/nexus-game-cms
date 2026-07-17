(() => {
    const shell = document.querySelector('[data-shell]');
    document.querySelectorAll('[data-menu-toggle]').forEach((button) => button.addEventListener('click', () => shell?.classList.toggle('menu-open')));

    const toast = document.querySelector('[data-toast]');
    let toastTimer;
    const showToast = (text) => {
        if (!toast) return;
        toast.querySelector('[data-toast-text]').textContent = text;
        toast.classList.add('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 2200);
    };

    document.querySelectorAll('[data-copy]').forEach((button) => button.addEventListener('click', async () => {
        const value = button.dataset.copy || '';
        try { await navigator.clipboard.writeText(value); } catch { /* Clipboard can be unavailable on non-HTTPS previews. */ }
        showToast('IP адресът е копиран');
    }));

    document.querySelectorAll('.faq-item > button').forEach((button) => button.addEventListener('click', () => {
        button.closest('.faq-item')?.classList.toggle('is-open');
    }));

    document.querySelectorAll('[data-modal-open]').forEach((button) => button.addEventListener('click', () => {
        document.getElementById(button.dataset.modalOpen)?.classList.add('is-open');
    }));
    document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => button.closest('.modal')?.classList.remove('is-open')));
    document.querySelectorAll('.modal').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) modal.classList.remove('is-open'); }));

    document.addEventListener('keydown', (event) => {
        if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
            event.preventDefault();
            document.querySelector('.topbar-search input')?.focus();
        }
        if (event.key === 'Escape') {
            shell?.classList.remove('menu-open');
            document.querySelectorAll('.modal.is-open').forEach((modal) => modal.classList.remove('is-open'));
        }
    });
})();
