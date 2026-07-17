(() => {
  const body = document.body;
  const sidebarToggle = document.querySelector('.sidebar__toggle');
  const burger = document.querySelector('.header_burger');
  const sidebar = document.querySelector('.sidebar');

  const syncSidebar = () => localStorage.setItem('nexus.neo3.sidebar', body.classList.contains('sidebar-collapse') ? 'collapsed' : 'open');
  const toggleSidebar = () => { body.classList.toggle('sidebar-collapse'); syncSidebar(); };
  if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
  if (burger) burger.addEventListener('click', () => sidebar?.classList.toggle('sidebar--mobile-open'));

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
  languageButton?.addEventListener('click', (event) => { event.stopPropagation(); languageModal?.classList.toggle('active'); });
  document.addEventListener('click', (event) => {
    if (languageModal && !languageModal.contains(event.target) && event.target !== languageButton) languageModal.classList.remove('active');
  });
})();
