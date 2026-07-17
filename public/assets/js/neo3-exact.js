(() => {
  'use strict';

  const body = document.body;
  const sidebarToggle = document.querySelector('.sidebar__toggle');
  const burger = document.querySelector('.header_burger');
  const sidebar = document.querySelector('.sidebar');
  const backdrop = document.querySelector('[data-neo3-backdrop]');

  const syncSidebar = () => localStorage.setItem('nexus.neo3.sidebar', body.classList.contains('sidebar-collapse') ? 'collapsed' : 'open');
  const toggleSidebar = () => {
    body.classList.toggle('sidebar-collapse');
    syncSidebar();
  };

  const closeMobileSidebar = () => {
    sidebar?.classList.remove('is-open');
    backdrop?.classList.remove('is-open');
    burger?.setAttribute('aria-expanded', 'false');
    body.style.overflow = '';
  };

  const toggleMobileSidebar = () => {
    const open = !sidebar?.classList.contains('is-open');
    sidebar?.classList.toggle('is-open', open);
    backdrop?.classList.toggle('is-open', open);
    burger?.setAttribute('aria-expanded', open ? 'true' : 'false');
    body.style.overflow = open ? 'hidden' : '';
  };

  const savedSidebar = localStorage.getItem('nexus.neo3.sidebar');
  if (savedSidebar === 'open') body.classList.remove('sidebar-collapse');
  if (savedSidebar === 'collapsed') body.classList.add('sidebar-collapse');

  sidebarToggle?.addEventListener('click', toggleSidebar);
  burger?.setAttribute('aria-expanded', 'false');
  burger?.addEventListener('click', toggleMobileSidebar);
  backdrop?.addEventListener('click', closeMobileSidebar);

  document.querySelectorAll('.sidebar__submenu').forEach((button) => {
    button.addEventListener('click', () => {
      const item = button.closest('li');
      item?.classList.toggle('is-open');
      button.setAttribute('aria-expanded', item?.classList.contains('is-open') ? 'true' : 'false');
    });
  });

  document.querySelectorAll('[data-neo-tab]').forEach((button) => {
    button.addEventListener('click', () => {
      const group = button.closest('[data-neo-tabs]');
      if (!group) return;
      const id = button.dataset.neoTab;
      group.querySelectorAll('[data-neo-tab]').forEach((el) => el.classList.toggle('active', el === button));
      group.querySelectorAll('[data-neo-tab-panel]').forEach((panel) => { panel.hidden = panel.dataset.neoTabPanel !== id; });
    });
  });

  document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
      try { await navigator.clipboard.writeText(button.dataset.copy || ''); } catch (_) {}
      const toast = document.querySelector('.neo3-toast');
      if (!toast) return;
      toast.classList.add('is-visible');
      clearTimeout(window.__neoToast);
      window.__neoToast = setTimeout(() => toast.classList.remove('is-visible'), 1600);
    });
  });

  const languageButton = document.getElementById('openLanguage');
  const languageModal = document.querySelector('.language__modal');
  languageButton?.addEventListener('click', (event) => {
    event.stopPropagation();
    languageModal?.classList.toggle('is-open');
  });

  const online = document.querySelector('.online');
  const onlineCounter = document.querySelector('.online__counter');
  onlineCounter?.addEventListener('click', (event) => {
    event.stopPropagation();
    online?.classList.toggle('is-open');
  });

  document.addEventListener('click', (event) => {
    if (languageModal && !languageModal.contains(event.target) && event.target !== languageButton) languageModal.classList.remove('is-open');
    if (online && !online.contains(event.target)) online.classList.remove('is-open');
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    closeMobileSidebar();
    languageModal?.classList.remove('is-open');
    online?.classList.remove('is-open');
  });
})();
