document.addEventListener('DOMContentLoaded', () => {
    initBuildingManagement();
    initFloorManagement();
});

/*
|--------------------------------------------------------------------------
| Building Management
|--------------------------------------------------------------------------
*/

function initBuildingManagement() {
    window.addEventListener('load', function () {
        const mainTable = window.LaravelDataTables?.['buildings-table'];
        const inactiveTable = window.LaravelDataTables?.['buildings-inactive-table'];
        const restoreTable = window.LaravelDataTables?.['buildings-restore-table'];

        const statusFilter = document.getElementById('buildingStatus');
        const resetButton = document.getElementById('resetBuildingFilters');
        const filtersContainer = document.getElementById('buildingFilters');

        const tableId = mainTable
            ? 'buildings-table'
            : inactiveTable
                ? 'buildings-inactive-table'
                : 'buildings-restore-table';

        const table = mainTable || inactiveTable || restoreTable;

        if (!table) {
            console.error('DataTables Gedung tidak ditemukan.');
            return;
        }

        // Gabungkan pencarian dan filter pada halaman Master Gedung.
        const searchContainer = document.querySelector(
            `#${tableId}_wrapper .dt-search`
        );

        if (filtersContainer && searchContainer) {
            searchContainer.classList.add(
                'd-flex',
                'flex-wrap',
                'align-items-center',
                'gap-2'
            );

            const searchLabel = searchContainer.querySelector('label');

            if (searchLabel) {
                searchLabel.classList.add('mb-0');
            }

            const searchInput = searchContainer.querySelector('input');

            if (searchInput) {
                searchInput.style.width = '260px';
            }

            searchContainer.appendChild(filtersContainer);
        }

        // Filter status Master Gedung.
        statusFilter?.addEventListener('change', function () {
            table.ajax.reload();
        });

        // Reset pencarian dan filter Master Gedung.
        resetButton?.addEventListener('click', function () {
            if (statusFilter) {
                statusFilter.value = '';
            }

            const searchInput = document.querySelector(
                `#${tableId}_wrapper .dt-search input`
            );

            if (searchInput) {
                searchInput.value = '';
            }

            table.search('').draw();
        });

        // Konfirmasi aksi Gedung.
        document.addEventListener('submit', async function (event) {
            const statusForm = event.target.closest('.building-status-form');
            const deleteForm = event.target.closest('.building-delete-form');
            const restoreForm = event.target.closest('.building-restore-form');

            if (!statusForm && !deleteForm && !restoreForm) return;

            event.preventDefault();

            if (statusForm) {
                const result = await Swal.fire({
                    title: 'Ubah Status Gedung?',
                    text: 'Apakah Anda yakin ingin mengubah status gedung ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                });

                if (result.isConfirmed) {
                    statusForm.submit();
                }
            }

            if (deleteForm) {
                if (restoreForm) {
                    const result = await Swal.fire({
                        title: 'Pulihkan Gedung?',
                        text: 'Gedung akan dikembalikan ke Master Gedung.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, pulihkan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#198754',
                        reverseButtons: true,
                    });

                    if (result.isConfirmed) {
                        restoreForm.submit();
                    }
                }
                
                const result = await Swal.fire({
                    title: 'Hapus Gedung?',
                    text: 'Gedung akan dipindahkan ke Recycle Bin.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545',
                    reverseButtons: true,
                });

                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            }
        });

        // Tooltip Bootstrap.
        function initializeTooltips() {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
                bootstrap.Tooltip.getOrCreateInstance(element);
            });
        }

        initializeTooltips();

        if (window.jQuery) {
            $(`#${tableId}`).on('draw.dt', initializeTooltips);
        }
    });
}

/*
|--------------------------------------------------------------------------
| Floor Management
|--------------------------------------------------------------------------
*/

function initFloorManagement() {
    document.addEventListener('submit', (event) => {
        const statusForm = event.target.closest('.floor-status-form');

        if (!statusForm) return;

        event.preventDefault();

        const isActive = statusForm.dataset.active === '1';

        Swal.fire({
            title: isActive ? 'Nonaktifkan Lantai?' : 'Aktifkan Lantai?',
            text: isActive
                ? 'Lantai yang dinonaktifkan tidak dapat digunakan.'
                : 'Apakah Anda yakin ingin mengaktifkan lantai ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: isActive ? 'Ya, nonaktifkan' : 'Ya, aktifkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: isActive ? '#dc3545' : '#198754',
        }).then((result) => {
            if (result.isConfirmed) {
                statusForm.submit();
            }
        });
    });

    document.addEventListener('submit', (event) => {
        const deleteForm = event.target.closest('.floor-delete-form');

        if (!deleteForm) return;

        event.preventDefault();

        Swal.fire({
            title: 'Hapus Lantai?',
            text: 'Lantai akan dipindahkan ke data terhapus. Anda yakin ingin melanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc3545',
        }).then((result) => {
            if (result.isConfirmed) {
                deleteForm.submit();
            }
        });
    });
}