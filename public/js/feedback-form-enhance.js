document.addEventListener('DOMContentLoaded', function() {
    // Searchable select for unit
    const unitSelect = document.querySelector('select[name="unit_id"]');
    if (unitSelect) {
        unitSelect.outerHTML = `<input list="unit-list" name="unit_id" class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white" required />
        <datalist id="unit-list">${Array.from(unitSelect.options).map(opt => `<option value='${opt.value}'>${opt.text}</option>`).join('')}</datalist>`;
    }
    // Searchable select for inovasi
    const inovasiSelect = document.querySelector('select[name="inovasi_id"]');
    if (inovasiSelect) {
        inovasiSelect.outerHTML = `<input list="inovasi-list" name="inovasi_id" class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white" required />
        <datalist id="inovasi-list">${Array.from(inovasiSelect.options).map(opt => `<option value='${opt.value}'>${opt.text}</option>`).join('')}</datalist>`;
    }
    // Searchable select for lama implementasi
    const lamaSelect = document.querySelector('select[name="lama_implementasi"]');
    if (lamaSelect) {
        lamaSelect.outerHTML = `<input list="lama-list" name="lama_implementasi" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white" required />
        <datalist id="lama-list">${Array.from(lamaSelect.options).map(opt => `<option value='${opt.value}'>${opt.text}</option>`).join('')}</datalist>`;
    }
    // Star rating full fill
    document.querySelectorAll('.star-rating-group').forEach(group => {
        group.querySelectorAll('input[type="radio"]').forEach((radio, idx, radios) => {
            radio.addEventListener('change', function() {
                radios.forEach((r, i) => {
                    r.nextElementSibling.classList.toggle('text-yellow-400', i <= idx);
                    r.nextElementSibling.classList.toggle('text-gray-300', i > idx);
                });
            });
        });
    });
});
