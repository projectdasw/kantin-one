document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('tableContainer');
    const searchInput = document.getElementById('tableSearch');
    const statusFilter = document.getElementById('tableStatus');

    // Form pembuatan meja
    const canteenSelect = document.getElementById('canteen_id');
    const buildingSelect = document.getElementById('building_id');
    const floorSelect = document.getElementById('floor_id');

    if (container && searchInput && statusFilter) {

        let debounceTimer;

        // Memuat data meja melalui AJAX
        async function loadTables(url = null) {
            const params = new URLSearchParams({
                search: searchInput.value,
                status: statusFilter.value,
            });

            const requestUrl = url || `${window.location.pathname}?${params}`;

            container.style.opacity = '0.5';

            try {
                const response = await fetch(requestUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html',
                    },
                });

                if (!response.ok) throw new Error('Gagal memuat data meja.');

                container.innerHTML = await response.text();
                initializeTooltips();
            } catch (error) {
                console.error(error);
                container.innerHTML = `
                    <div class="alert alert-danger">
                        Gagal memuat data meja. Silakan coba kembali.
                    </div>
                `;
            } finally {
                container.style.opacity = '1';
            }
        }

        // Pencarian dengan debounce
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                loadTables();
            }, 400);
        });

        // Filter status
        statusFilter.addEventListener('change', () => loadTables());

        // Pagination AJAX
        container.addEventListener('click', (event) => {
            const link = event.target.closest('.pagination a');

            if (!link) return;

            event.preventDefault();
            loadTables(link.href);
        });

        // Konfirmasi hapus
        container.addEventListener('submit', async (event) => {
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
    }

    function initializeTooltips() {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
            bootstrap.Tooltip.getOrCreateInstance(element);
        });
    }

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