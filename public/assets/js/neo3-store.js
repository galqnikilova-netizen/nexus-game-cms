(() => {
  'use strict';

  const root = document.querySelector('[data-neo3-store]');
  if (!root) return;

  const grid = root.querySelector('.shop_wrapper_product');
  const cards = [...root.querySelectorAll('[data-store-card]')];
  const categoryButtons = [...root.querySelectorAll('[data-store-categories] [data-category]')];
  const serverButtons = [...root.querySelectorAll('[data-store-servers] [data-server]')];
  const sortButtons = [...root.querySelectorAll('[data-store-sort] [data-sort]')];
  const empty = root.querySelector('[data-store-empty]');
  const serverName = root.querySelector('[data-store-server-name]');
  const overlay = document.querySelector('[data-store-overlay]');
  const checkout = document.querySelector('[data-store-checkout]');
  const cartList = checkout?.querySelector('[data-store-cart-list]');
  const cartEmpty = checkout?.querySelector('[data-store-cart-empty]');
  const total = checkout?.querySelector('[data-store-total]');
  const count = document.querySelector('[data-store-cart-count]');
  const agreement = checkout?.querySelector('[data-store-agreement]');
  const steam = checkout?.querySelector('#storeSteam');
  const pay = checkout?.querySelector('[data-store-pay]');
  const details = document.querySelector('[data-store-details-panel]');
  const detailsList = details?.querySelector('[data-store-details-list]');

  let category = '0';
  let server = '0';
  let sort = 'default';
  let cart = [];

  cards.forEach((card, index) => { card.dataset.originalOrder = String(index); });

  const closeSelects = (except = null) => {
    root.querySelectorAll('[data-store-select]').forEach((select) => {
      if (select === except) return;
      select.classList.remove('is-open');
      const options = select.querySelector('[data-store-options]');
      if (options) options.hidden = true;
    });
  };

  root.querySelectorAll('[data-store-select]').forEach((select) => {
    select.addEventListener('click', (event) => {
      const option = event.target.closest('[data-store-option]');
      const options = select.querySelector('[data-store-options]');
      if (option) {
        const card = select.closest('[data-store-card]');
        const price = Number(option.dataset.price || 0);
        const label = option.dataset.label || '';
        select.querySelector('[data-store-period-label]').textContent = label;
        select.querySelector('[data-store-price-label]').textContent = `${price.toFixed(2)} лв.`;
        select.querySelector('[data-store-period-value]').value = label;
        card.dataset.price = String(price);
        card.querySelector('[data-store-footer-price]').textContent = price.toFixed(2);
        select.classList.remove('is-open');
        options.hidden = true;
        applyFilters();
        event.stopPropagation();
        return;
      }

      closeSelects(select);
      const open = options.hidden;
      options.hidden = !open;
      select.classList.toggle('is-open', open);
      event.stopPropagation();
    });
  });

  const applyFilters = () => {
    let visible = 0;
    const ordered = [...cards].sort((a, b) => {
      if (sort === 'low') return Number(a.dataset.price) - Number(b.dataset.price);
      if (sort === 'high') return Number(b.dataset.price) - Number(a.dataset.price);
      return Number(a.dataset.originalOrder) - Number(b.dataset.originalOrder);
    });

    ordered.forEach((card) => {
      const showCategory = category === '0' || card.dataset.category === category;
      const showServer = server === '0' || card.dataset.server === server;
      card.hidden = !(showCategory && showServer);
      if (!card.hidden) visible += 1;
      grid.appendChild(card);
    });

    if (empty) empty.hidden = visible > 0;
  };

  categoryButtons.forEach((button) => button.addEventListener('click', () => {
    category = button.dataset.category || '0';
    categoryButtons.forEach((item) => item.classList.toggle('active', item === button));
    applyFilters();
  }));

  serverButtons.forEach((button) => button.addEventListener('click', () => {
    server = button.dataset.server || '0';
    serverButtons.forEach((item) => item.classList.toggle('active', item === button));
    if (serverName) serverName.textContent = server === '0' ? 'Всички сървъри' : (button.querySelector('b')?.textContent || 'Избран сървър');
    applyFilters();
  }));

  sortButtons.forEach((button) => button.addEventListener('click', () => {
    sort = button.dataset.sort || 'default';
    sortButtons.forEach((item) => item.classList.toggle('active', item === button));
    applyFilters();
  }));

  const setLayer = (element, open) => {
    if (!element || !overlay) return;
    element.hidden = !open;
    overlay.hidden = !open;
    document.body.style.overflow = open ? 'hidden' : '';
  };

  const refreshCart = () => {
    const sum = cart.reduce((value, item) => value + item.price, 0);
    if (count) count.textContent = String(cart.length);
    if (total) total.textContent = `${sum.toFixed(2)} лв.`;
    if (cartEmpty) cartEmpty.hidden = cart.length > 0;

    if (cartList) {
      cartList.innerHTML = '';
      cart.forEach((item, index) => {
        const row = document.createElement('div');
        row.className = 'neo3-store-cart-item';
        row.innerHTML = `<div><strong></strong><small></small></div><span></span><button type="button" aria-label="Премахни">×</button>`;
        row.querySelector('strong').textContent = item.name;
        row.querySelector('small').textContent = `${item.period} · ${item.server}`;
        row.querySelector('span').textContent = `${item.price.toFixed(2)} лв.`;
        row.querySelector('button').addEventListener('click', () => {
          cart.splice(index, 1);
          refreshCart();
        });
        cartList.appendChild(row);
      });
    }
    refreshPayState();
  };

  const refreshPayState = () => {
    if (!pay) return;
    pay.disabled = cart.length === 0 || !agreement?.checked || !steam?.value.trim();
  };

  root.querySelectorAll('[data-store-add]').forEach((button) => button.addEventListener('click', () => {
    const card = button.closest('[data-store-card]');
    const serverButton = serverButtons.find((item) => item.dataset.server === card.dataset.server);
    cart.push({
      id: card.dataset.productId,
      name: button.dataset.productName || 'NEXUS продукт',
      period: card.querySelector('[data-store-period-label]')?.textContent || '',
      price: Number(card.dataset.price || 0),
      server: serverButton?.querySelector('b')?.textContent || 'NEXUS',
    });
    refreshCart();
    const previous = button.textContent;
    button.textContent = 'Добавено ✓';
    setTimeout(() => { button.textContent = previous; }, 1100);
  }));

  document.querySelector('[data-store-open-cart]')?.addEventListener('click', () => setLayer(checkout, true));
  checkout?.querySelector('[data-store-close]')?.addEventListener('click', () => setLayer(checkout, false));
  agreement?.addEventListener('change', refreshPayState);
  steam?.addEventListener('input', refreshPayState);

  root.querySelectorAll('[data-store-details]').forEach((button) => button.addEventListener('click', () => {
    const card = button.closest('[data-store-card]');
    const template = card.querySelector('[data-store-features]');
    if (detailsList) detailsList.innerHTML = template?.innerHTML || '';
    setLayer(details, true);
  }));
  details?.querySelector('[data-store-details-close]')?.addEventListener('click', () => setLayer(details, false));

  overlay?.addEventListener('click', () => {
    if (checkout && !checkout.hidden) setLayer(checkout, false);
    if (details && !details.hidden) setLayer(details, false);
  });
  document.addEventListener('click', () => closeSelects());
  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;
    closeSelects();
    if (checkout && !checkout.hidden) setLayer(checkout, false);
    if (details && !details.hidden) setLayer(details, false);
  });

  pay?.addEventListener('click', () => {
    const toast = document.querySelector('.neo3-toast');
    setLayer(checkout, false);
    if (toast) {
      toast.textContent = 'Checkout е готов за свързване с платежен gateway';
      toast.classList.add('is-visible');
      clearTimeout(window.__neoStoreToast);
      window.__neoStoreToast = setTimeout(() => toast.classList.remove('is-visible'), 2600);
    }
  });

  applyFilters();
  refreshCart();
})();
