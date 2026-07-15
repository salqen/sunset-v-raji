(function () {
  'use strict';
  // tabs
  var tabs = document.getElementById('tabs');
  if (tabs) {
    tabs.addEventListener('click', function (e) {
      var b = e.target.closest('button[data-tab]');
      if (!b) return;
      tabs.querySelectorAll('button').forEach(function (x) { x.classList.remove('on'); });
      document.querySelectorAll('.tab').forEach(function (x) { x.classList.remove('on'); });
      b.classList.add('on');
      document.getElementById('tab-' + b.dataset.tab).classList.add('on');
    });
  }
  // repeaters
  var templates = {
    pday: '<div class="row3"><input name="pday[time][]" placeholder="14:00"><input name="pday[title][]" placeholder="Názov bodu"><input name="pday[desc][]" placeholder="Krátky popis (nepovinné)"><button type="button" class="del" title="Odstrániť">×</button></div>',
    pnight: '<div class="row3"><input name="pnight[time][]" placeholder="20:00"><input name="pnight[title][]" placeholder="Názov bodu / DJ"><input name="pnight[desc][]" placeholder="Krátky popis (nepovinné)"><button type="button" class="del" title="Odstrániť">×</button></div>',
    lineup: '<div class="rowdj"><span class="djprev djempty">?</span><input name="lineup[name][]" placeholder="Meno"><input name="lineup[meta][]" placeholder="Napr. CZ" class="short"><input name="lineup[desc][]" placeholder="Popis / čas vystúpenia"><input type="hidden" name="lineup[photo][]" value=""><input type="file" name="lineup_photo[]" accept="image/*"><button type="button" class="del" title="Odstrániť">×</button></div>'
  };
  document.querySelectorAll('.add').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var key = btn.dataset.add;
      var box = document.querySelector('[data-rows="' + key + '"]');
      box.insertAdjacentHTML('beforeend', templates[key]);
    });
  });
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('del')) {
      e.target.closest('.row3, .rowdj').remove();
    }
    if (e.target.classList.contains('up') || e.target.classList.contains('down')) {
      var row = e.target.closest('.galrow');
      if (e.target.classList.contains('up') && row.previousElementSibling) {
        row.parentNode.insertBefore(row, row.previousElementSibling);
      } else if (e.target.classList.contains('down') && row.nextElementSibling) {
        row.parentNode.insertBefore(row.nextElementSibling, row);
      }
    }
  });
  // g_del checkboxes need index alignment: convert to per-row hidden values
  var form = document.querySelector('form.editor');
  if (form) {
    form.addEventListener('submit', function () {
      document.querySelectorAll('#galRows .galrow').forEach(function (row) {
        var chk = row.querySelector('input[type=checkbox]');
        chk.value = chk.checked ? '1' : '';
        chk.checked = true; // ensure a value is always submitted for index alignment
      });
    });
  }
})();
