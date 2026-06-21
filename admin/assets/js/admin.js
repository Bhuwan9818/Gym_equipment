/* ===========================================================
   FITRONFITNESS — Admin Panel behaviour
=========================================================== */

/* Confirm before any destructive action (delete links/buttons
   carrying data-confirm="..."). */
document.addEventListener('click', function (e) {
  const el = e.target.closest('[data-confirm]');
  if (el && !confirm(el.getAttribute('data-confirm'))) {
    e.preventDefault();
  }
});

/* Live image preview when an admin picks a new file in an
   <input type="file" data-preview="#someImgId">. */
document.addEventListener('change', function (e) {
  const input = e.target.closest('input[type="file"][data-preview]');
  if (!input || !input.files || !input.files[0]) return;
  const target = document.querySelector(input.getAttribute('data-preview'));
  if (!target) return;
  const reader = new FileReader();
  reader.onload = function (ev) { target.src = ev.target.result; };
  reader.readAsDataURL(input.files[0]);
});

/* Dynamic specification key/value rows on the product form.
   Container must have id="specRows"; each row uses class
   "a-spec-row" with two inputs named specs_key[] / specs_val[]. */
function addSpecRow(key, val) {
  const wrap = document.getElementById('specRows');
  if (!wrap) return;
  const row = document.createElement('div');
  row.className = 'a-spec-row';
  row.innerHTML =
    '<input type="text" class="a-input" name="specs_key[]" placeholder="e.g. Main Frame" value="' + (key ? escapeAttr(key) : '') + '">' +
    '<input type="text" class="a-input" name="specs_val[]" placeholder="e.g. Rectangular Steel Tube" value="' + (val ? escapeAttr(val) : '') + '">' +
    '<button type="button" class="a-spec-remove" onclick="this.closest(\'.a-spec-row\').remove()" aria-label="Remove">×</button>';
  wrap.appendChild(row);
}
function escapeAttr(s) {
  return String(s).replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

/* Auto-suggest a URL slug from the product/category name field
   while the admin hasn't manually edited the slug field yet. */
(function () {
  const nameInput = document.getElementById('nameInput');
  const slugInput = document.getElementById('slugInput');
  if (!nameInput || !slugInput) return;
  let slugTouched = slugInput.value.trim() !== '';
  slugInput.addEventListener('input', function () { slugTouched = true; });
  nameInput.addEventListener('input', function () {
    if (slugTouched) return;
    slugInput.value = nameInput.value
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');
  });
})();

/* Simple client-side filter for the product/category list tables.
   Search box needs id="tableSearch", table rows need data-search
   attribute containing lowercase searchable text. */
(function () {
  const search = document.getElementById('tableSearch');
  if (!search) return;
  search.addEventListener('input', function () {
    const q = search.value.trim().toLowerCase();
    document.querySelectorAll('[data-search]').forEach(function (row) {
      row.style.display = row.getAttribute('data-search').includes(q) ? '' : 'none';
    });
  });
})();
