document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // DATATABLES: SATUKAN SEARCH DAN FILTER
    // ==========================================
    window.addEventListener('load', function () {
        const table = window.LaravelDataTables?.['tables-table'];

        if (!table) {
            console.error('DataTables Manajemen Meja tidak ditemukan.');
            return;
        }

        const statusFilter = document.getElementById('tableStatus');
        const resetButton = document.getElementById('resetTableFilters');
        const filtersContainer = document.getElementById('tableFilters');

        const searchContainer = document.querySelector(
            '#tables-table_wrapper .dt-search'
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

            filtersContainer.classList.add(
                'd-flex',
                'flex-wrap',
                'align-items-center',
                'gap-2'
            );

            searchContainer.appendChild(filtersContainer);
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', function () {
                table.ajax.reload();
            });
        }

        if (resetButton) {
            resetButton.addEventListener('click', function () {
                if (statusFilter) {
                    statusFilter.value = '';
                }

                const searchInput = document.querySelector(
                    '#tables-table_wrapper .dt-search input'
                );

                if (searchInput) {
                    searchInput.value = '';
                }

                table.search('').draw();
            });
        }
    });

    // Filter status DataTables
    const statusFilter = document.getElementById('tableStatus');
    const resetFilter = document.getElementById('resetTableFilters');

    if (
        window.jQuery &&
        $.fn.DataTable.isDataTable('#tables-table')
    ) {
        const table = $('#tables-table').DataTable();

        if (statusFilter) {
            statusFilter.addEventListener('change', () => {
                table.ajax.reload();
            });
        }

        if (resetFilter) {
            resetFilter.addEventListener('click', () => {
                if (statusFilter) {
                    statusFilter.value = '';
                }

                table.ajax.reload();
            });
        }
    }

    // Konfirmasi hapus meja
    document.addEventListener('submit', async (event) => {
        const form = event.target.closest('.delete-table-form');

        if (!form) return;

        event.preventDefault();

        const result = await Swal.fire({
            title: 'Hapus meja?',
            text: 'Meja akan dipindahkan ke Recycle Bin.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            form.submit();
        }
    });

    // Tooltip Bootstrap
    function initializeTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
            bootstrap.Tooltip.getOrCreateInstance(element);
        });
    }

    initializeTooltips();

    // Perbarui tooltip setelah DataTables menggambar ulang tabel
    if (window.jQuery) {
        $('#tables-table').on('draw.dt', function () {
            initializeTooltips();
        });
    }

    // Form pembuatan meja
    const canteenSelect = document.getElementById('canteen_id');
    const buildingSelect = document.getElementById('building_id');
    const floorSelect = document.getElementById('floor_id');

    if (canteenSelect && buildingSelect && floorSelect) {
        const floorsUrl = '/tables/floors';

        // Memuat lantai berdasarkan gedung
        async function loadFloors(buildingId) {
            floorSelect.innerHTML = '<option value="">Memuat lantai...</option>';
            floorSelect.disabled = true;

            if (!buildingId) {
                floorSelect.innerHTML = '<option value="">Pilih gedung terlebih dahulu</option>';
                return;
            }

            try {
                const response = await fetch(
                    `${floorsUrl}?building_id=${encodeURIComponent(buildingId)}`,
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    }
                );

                if (!response.ok) {
                    throw new Error('Gagal mengambil data lantai.');
                }

                const floors = await response.json();

                floorSelect.innerHTML = '<option value="">Pilih Lantai</option>';

                floors.forEach((floor) => {
                    const option = document.createElement('option');
                    option.value = floor.id;
                    option.textContent = `${floor.name} (${floor.code})`;
                    floorSelect.appendChild(option);
                });

                floorSelect.disabled = floors.length === 0;

                if (floors.length === 0) {
                    floorSelect.innerHTML = '<option value="">Tidak ada lantai aktif</option>';
                }

            } catch (error) {
                console.error(error);
                floorSelect.innerHTML = '<option value="">Gagal memuat lantai</option>';
            }
        }

        buildingSelect.addEventListener('change', () => {
            loadFloors(buildingSelect.value);
        });
    }

    initializeTooltips();
});