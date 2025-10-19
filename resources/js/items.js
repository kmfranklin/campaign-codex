document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('type');
    const weaponFields = document.getElementById('weapon-fields');
    const armorFields = document.getElementById('armor-fields');
    const requiresAttunement = document.getElementById('requires_attunement');
    const attuenmentWrapper = document.getElementById('attunement-requirements-wrapper');

    function toggleFields() {
        const value = typeSelect.value;
        weaponFields.classList.toggle('hidden', value !== 'Weapon');
        armorFields.classList.toggle('hidden', value !== 'Armor');
    }

    if (typeSelect) {
        typeSelect.addEventListener('change', toggleFields);
        toggleFields();
    }

    function toggleAttunement() {
        attuenmentWrapper.classList.toggle('hidden', !requiresAttunement.checked);
    }

    requiresAttunement.addEventListener('change', toggleAttunement);
    toggleAttunement();
});
