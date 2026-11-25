window.addEventListener('load', function () {
    const table = window.LaravelDataTables?.['users-trash-table'];

    const roleFilter = document.getElementById('userTrashRoleFilter');
    const statusFilter = document.getElementById('userTrashStatusFilter');
    const resetButton = document.getElementById('resetUserTrashFilters');
    const filtersContainer = document.getElementById('userTrashFilters');

    if (!table || !filtersContainer) {
        return;
    }

    // Pindahkan filter ke area pencarian DataTables.
    const searchContainer = document.querySelector(
        '#users-trash-table_wrapper .dt-search'
    );

    if (filtersContainer && searchContainer) {

        // Jadikan area pencarian sebagai toolbar horizontal
        searchContainer.classList.add(
            'd-flex',
            'flex-wrap',
            'align-items-center',
            'gap-2'
        );

        // Hilangkan margin bawaan label
        const searchLabel = searchContainer.querySelector('label');

        if (searchLabel) {
            searchLabel.classList.add('mb-0');
        }

        // Atur lebar input pencarian
        const searchInput = searchContainer.querySelector('input');

        if (searchInput) {
            searchInput.style.width = '260px';
        }

        // Masukkan filter tepat di samping pencarian
        filtersContainer.classList.add(
            'd-flex',
            'flex-wrap',
            'align-items-center',
            'gap-2'
        );

        searchContainer.appendChild(filtersContainer);
    }

    // Terapkan filter ketika pilihan berubah.
    [roleFilter, statusFilter].forEach(function (filter) {
        filter?.addEventListener('change', function () {
            table.ajax.reload();
        });
    });

    // Reset seluruh filter dan pencarian.
    resetButton?.addEventListener('click', function () {
        if (roleFilter) roleFilter.value = '';
        if (statusFilter) statusFilter.value = '';

        table.search('');
        table.ajax.reload();
    });
});