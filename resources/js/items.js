document.addEventListener('DOMContentLoaded', () => {
    const categorySelect = document.getElementById('item_category_id');
    const weaponFields = document.getElementById('weapon-fields');
    const armorFields = document.getElementById('armor-fields');
    const requiresAttunement = document.getElementById('requires_attunement');
    const attunementWrapper = document.getElementById('attunement-requirements-wrapper');

    // Replace with your actual category IDs from the DB
    const WEAPON_CATEGORY_ID = '21';
    const ARMOR_CATEGORY_ID = '3';

    function toggleFields() {
        const value = categorySelect.value;
        weaponFields.classList.toggle('hidden', value !== WEAPON_CATEGORY_ID);
        armorFields.classList.toggle('hidden', value !== ARMOR_CATEGORY_ID);
    }

    if (categorySelect) {
        categorySelect.addEventListener('change', toggleFields);
        toggleFields(); // run once on load
    }

    function toggleAttunement() {
        attunementWrapper.classList.toggle('hidden', !requiresAttunement.checked);
    }

    if (requiresAttunement) {
        requiresAttunement.addEventListener('change', toggleAttunement);
        toggleAttunement();
    }
});
