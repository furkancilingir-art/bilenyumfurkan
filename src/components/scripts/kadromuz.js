(function () {
  'use strict';

  function applyFilter(activeDept, grid, emptyEl, buttons) {
    var cards = grid.querySelectorAll('.kadro-card');
    var visible = 0;
    cards.forEach(function (card) {
      var dept = card.getAttribute('data-dept') || '';
      var show = activeDept === 'all' || dept === activeDept;
      card.hidden = !show;
      card.style.display = show ? '' : 'none';
      if (show) visible += 1;
    });
    if (emptyEl) {
      var hideEmpty = visible > 0;
      emptyEl.classList.toggle('kadro-empty--hidden', hideEmpty);
      emptyEl.setAttribute('aria-hidden', hideEmpty ? 'true' : 'false');
    }
    if (buttons && buttons.length) {
      buttons.forEach(function (btn) {
        var d = btn.getAttribute('data-dept') || '';
        var on = d === activeDept;
        btn.classList.toggle('is-active', on);
        btn.setAttribute('aria-pressed', on ? 'true' : 'false');
      });
    }
  }

  function init() {
    var grid = document.getElementById('kadro-grid');
    var empty = document.getElementById('kadro-empty-state');
    var bar = document.querySelector('.kadro-filter-buttons');
    if (!grid || !bar) return;

    var buttons = bar.querySelectorAll('.kadro-dept-btn');
    var activeDept = 'all';

    buttons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        activeDept = btn.getAttribute('data-dept') || 'all';
        applyFilter(activeDept, grid, empty, buttons);
      });
    });

    applyFilter(activeDept, grid, empty, buttons);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
