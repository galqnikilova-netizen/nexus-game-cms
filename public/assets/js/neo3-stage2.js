(() => {
  'use strict';

  const normalise = (value) => String(value ?? '').toLocaleLowerCase('bg-BG').trim();

  function initLeaderboard(root) {
    const body = root.querySelector('#leaderboardTableBody');
    if (!body) return;

    const rows = [...body.querySelectorAll('tr[data-rank]')];
    const emptyRow = body.querySelector('.neo3-empty-row');
    const search = root.querySelector('#leaderboardSearch');
    const server = root.querySelector('#leaderboardServer');
    const onlyOnline = root.querySelector('#leaderboardOnline');
    const sortInputs = [...root.querySelectorAll('input[name="leaderboard_sort"]')];
    const reset = root.querySelector('#resetLeaderboard');

    const render = () => {
      const term = normalise(search?.value);
      const selectedServer = server?.value || 'all';
      const online = Boolean(onlyOnline?.checked);
      const sortKey = sortInputs.find((input) => input.checked)?.value || 'rating';

      const sorted = [...rows].sort((a, b) => {
        const av = Number(a.dataset[sortKey] || 0);
        const bv = Number(b.dataset[sortKey] || 0);
        return bv - av || Number(a.dataset.rank) - Number(b.dataset.rank);
      });

      let visible = 0;
      sorted.forEach((row) => {
        const matchesTerm = !term || normalise(row.dataset.name).includes(term);
        const matchesServer = selectedServer === 'all' || row.dataset.server === selectedServer;
        const matchesOnline = !online || row.dataset.status === 'online';
        row.hidden = !(matchesTerm && matchesServer && matchesOnline);
        if (!row.hidden) visible += 1;
        body.insertBefore(row, emptyRow);
      });
      if (emptyRow) emptyRow.hidden = visible !== 0;
    };

    [search, server, onlyOnline, ...sortInputs].filter(Boolean).forEach((control) => {
      control.addEventListener(control === search ? 'input' : 'change', render);
    });

    reset?.addEventListener('click', () => {
      if (search) search.value = '';
      if (server) server.value = 'all';
      if (onlyOnline) onlyOnline.checked = false;
      sortInputs.forEach((input) => { input.checked = input.value === 'rating'; });
      render();
    });

    render();
  }

  function initProfile(root) {
    const buttons = [...root.querySelectorAll('[data-profile-tab]')];
    const panels = [...root.querySelectorAll('[data-profile-panel]')];
    if (!buttons.length || !panels.length) return;

    const open = (name, updateHash = true) => {
      const safeName = panels.some((panel) => panel.dataset.profilePanel === name) ? name : 'overview';
      buttons.forEach((button) => button.classList.toggle('active', button.dataset.profileTab === safeName));
      panels.forEach((panel) => { panel.hidden = panel.dataset.profilePanel !== safeName; });
      if (updateHash) history.replaceState(null, '', safeName === 'overview' ? location.pathname : `#${safeName}`);
    };

    buttons.forEach((button) => button.addEventListener('click', () => open(button.dataset.profileTab)));
    open(location.hash.replace('#', '') || 'overview', false);
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-neo3-leaderboard]').forEach(initLeaderboard);
    document.querySelectorAll('[data-neo3-profile]').forEach(initProfile);
  });
})();
