(() => {
  'use strict';

  document.querySelectorAll('.faq-item > button').forEach((button) => {
    button.addEventListener('click', () => button.closest('.faq-item')?.classList.toggle('is-open'));
  });

  document.querySelectorAll('[data-modal-open]').forEach((button) => {
    button.addEventListener('click', () => {
      const modal = document.getElementById(button.dataset.modalOpen || '');
      modal?.classList.add('is-open');
      document.body.style.overflow = 'hidden';
    });
  });

  const closeModal = (modal) => {
    modal?.classList.remove('is-open');
    if (!document.querySelector('.modal.is-open')) document.body.style.overflow = '';
  };

  document.querySelectorAll('[data-modal-close]').forEach((button) => {
    button.addEventListener('click', () => closeModal(button.closest('.modal')));
  });

  document.querySelectorAll('.modal').forEach((modal) => {
    modal.addEventListener('click', (event) => {
      if (event.target === modal) closeModal(modal);
    });
  });

  document.querySelectorAll('.segmented').forEach((group) => {
    group.querySelectorAll('button').forEach((button) => {
      button.addEventListener('click', () => {
        group.querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === button));
      });
    });
  });

  document.querySelectorAll('.collection-list').forEach((list) => {
    list.querySelectorAll('button').forEach((button) => {
      button.addEventListener('click', () => {
        list.querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === button));
      });
    });
  });

  const punishmentSearch = document.querySelector('.data-toolbar .input-shell input');
  const punishmentSelect = document.querySelector('.data-toolbar select');
  const punishmentRows = [...document.querySelectorAll('.punishment-cards article')];
  const filterPunishments = () => {
    if (!punishmentRows.length) return;
    const term = String(punishmentSearch?.value || '').toLocaleLowerCase('bg-BG').trim();
    const status = String(punishmentSelect?.value || '').toLocaleLowerCase('bg-BG');
    punishmentRows.forEach((row) => {
      const text = row.textContent.toLocaleLowerCase('bg-BG');
      const matchesText = !term || text.includes(term);
      const matchesStatus = status.includes('всички') || !status || text.includes(status.includes('актив') ? 'активно' : 'изтекло');
      row.hidden = !(matchesText && matchesStatus);
    });
  };
  punishmentSearch?.addEventListener('input', filterPunishments);
  punishmentSelect?.addEventListener('change', filterPunishments);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') document.querySelectorAll('.modal.is-open').forEach(closeModal);
  });
})();
