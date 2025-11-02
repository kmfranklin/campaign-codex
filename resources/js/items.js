document.addEventListener('DOMContentLoaded', () => {
  // Field toggles for create/edit form
  const categorySelect = document.getElementById('item_category_id');
  const weaponFields = document.getElementById('weapon-fields');
  const armorFields = document.getElementById('armor-fields');
  const requiresAttunement = document.getElementById('requires_attunement');
  const attunementWrapper = document.getElementById('attunement-requirements-wrapper');
  const WEAPON_CATEGORY_ID = '21';
  const ARMOR_CATEGORY_ID = '3';

  function toggleFields() {
    if (!categorySelect) return;
    const value = categorySelect.value;
    if (weaponFields) weaponFields.classList.toggle('hidden', value !== WEAPON_CATEGORY_ID);
    if (armorFields) armorFields.classList.toggle('hidden', value !== ARMOR_CATEGORY_ID);
  }

  if (categorySelect) {
    categorySelect.addEventListener('change', toggleFields);
    toggleFields(); // run once on load
  }

  function toggleAttunement() {
    if (!requiresAttunement || !attunementWrapper) return;
    attunementWrapper.classList.toggle('hidden', !requiresAttunement.checked);
  }

  if (requiresAttunement) {
    requiresAttunement.addEventListener('change', toggleAttunement);
    toggleAttunement();
  }

  document.addEventListener('click', async (e) => {
    const anchor = e.target.closest('#item-results a');
    if (!anchor) return;

    // allow modifier keys to open in new tab/window
    if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

    // Validate URL and detect paginator link
    let href;
    try {
      href = new URL(anchor.href, window.location.origin);
    } catch (err) {
      return;
    }

    const isPageLink = href.searchParams.has('page') || /page/i.test(anchor.getAttribute('aria-label') || '');
    if (!isPageLink) return;

    e.preventDefault();

    const currentParams = new URLSearchParams(window.location.search);
    const targetParams = new URLSearchParams(href.search);

    currentParams.forEach((value, key) => {
      if (key === 'page') return;
      if (!targetParams.has(key)) targetParams.set(key, value);
    });

    const finalUrl = `${href.origin}${href.pathname}?${targetParams.toString()}`;

    const resultsEl = document.querySelector('#item-results');
    if (!resultsEl) {
      // fallback: navigate normally if container missing
      window.location.href = finalUrl;
      return;
    }

    // Visual loading cue
    resultsEl.classList.add('opacity-70', 'pointer-events-none');

    try {
      const res = await fetch(finalUrl, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'text/html'
        },
        credentials: 'same-origin'
      });

      if (!res.ok) throw new Error('Failed to fetch pagination partial');

      const html = await res.text();
      const temp = document.createElement('div');
      temp.innerHTML = html.trim();
      const newResults = temp.firstElementChild;

      if (!newResults) throw new Error('Invalid partial HTML');

      resultsEl.replaceWith(newResults);
      window.history.pushState({}, '', finalUrl);
    } catch (err) {
      console.error('Pagination fetch failed', err);
      // fallback: navigate to href so user still gets a result
      window.location.href = finalUrl;
    } finally {
      const cur = document.querySelector('#item-results');
      if (cur) cur.classList.remove('opacity-70', 'pointer-events-none');
    }
  });

  // Handle back/forward navigation: fetch partial for current URL and replace results
  window.addEventListener('popstate', async () => {
    const resultsEl = document.querySelector('#item-results');
    if (!resultsEl) return;

    const finalUrl = location.href;

    resultsEl.classList.add('opacity-70', 'pointer-events-none');

    try {
      const res = await fetch(finalUrl, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'text/html'
        },
        credentials: 'same-origin'
      });
      if (!res.ok) throw new Error('Popstate fetch failed');

      const html = await res.text();
      const temp = document.createElement('div');
      temp.innerHTML = html.trim();
      const newResults = temp.firstElementChild;
      if (newResults) resultsEl.replaceWith(newResults);
    } catch (err) {
      console.error('popstate fetch failed', err);
    } finally {
      const cur = document.querySelector('#item-results');
      if (cur) cur.classList.remove('opacity-70', 'pointer-events-none');
    }
  });
});
