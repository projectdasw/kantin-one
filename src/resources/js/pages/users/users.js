// ==========================================
// DATATABLES: FILTER MASTER AKUN
// ==========================================
window.addEventListener('load', function () {
    const table = window.LaravelDataTables?.['users-table'];

    if (!table) {
        console.error('DataTables Master Akun tidak ditemukan.');
        return;
    }

    const roleFilter = document.getElementById('userRoleFilter');
    const statusFilter = document.getElementById('userStatusFilter');
    const resetButton = document.getElementById('resetUserFilters');

    // ==========================================
    // DATATABLES: SATUKAN SEARCH DAN FILTER
    // ==========================================
    const filtersContainer = document.getElementById('userFilters');

    const searchContainer = document.querySelector(
        '#users-table_wrapper .dt-search'
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

    // Filter berdasarkan perubahan pilihan
    [roleFilter, statusFilter].forEach(filter => {
        if (!filter) return;

        filter.addEventListener('change', function () {
            table.ajax.reload();
        });
    });

    // Reset seluruh filter
    if (resetButton) {
        resetButton.addEventListener('click', function () {

            // Reset filter peran dan status
            if (roleFilter) roleFilter.value = '';
            if (statusFilter) statusFilter.value = '';

            // Reset input pencarian
            const searchInput = document.querySelector(
                '#users-table_wrapper .dt-search input'
            );

            if (searchInput) {
                searchInput.value = '';
            }

            // Reset pencarian DataTables dan reload data
            table.search('').draw();
        });
    }
});

// ==========================================
// HTML ESCAPE FOR SWEETALERT
// ==========================================
function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, character => {
        const entities = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return entities[character];
    });
}

// ==========================================
// SWEETALERT: ACTIVATE / DEACTIVATE
// ==========================================
document.addEventListener('submit', function (event) {
    const form = event.target.closest('.status-form');
    if (!form) return;

    event.preventDefault();
    const name = form.dataset.name;
    const isActive = form.dataset.active === '1';

    Swal.fire({
        title: isActive ? 'Nonaktifkan akun?' : 'Aktifkan akun?',
        text: `Apakah Anda yakin ingin ${ isActive ? 'menonaktifkan' : 'mengaktifkan' } akun ${name}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// ==========================================
// SWEETALERT: DELETE USER (SOFT DELETE)
// ==========================================
document.addEventListener('submit', function (event) {
    const form = event.target.closest('.delete-user-form');
    if (!form) return;

    event.preventDefault();
    const name = form.dataset.name;

    Swal.fire({
        title: 'Hapus Akun?',
        html: `
            Akun <strong>${escapeHtml(name)}</strong>
            akan dipindahkan ke data terhapus.
            <br><br>
            <small class="text-muted">
                Data masih tersimpan dan dapat dipulihkan.
            </small>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then(result => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});