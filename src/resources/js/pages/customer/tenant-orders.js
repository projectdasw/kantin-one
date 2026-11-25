
document.addEventListener('DOMContentLoaded', () => {
    const ordersContainer = document.getElementById('ordersContainer');
    const searchInput = document.getElementById('searchOrders');
    const filterContainer = document.getElementById('orderFilters');
    const refreshButton = document.getElementById('refreshOrders');

    if (!ordersContainer || !searchInput || !filterContainer) {
        return;
    }

    const dataUrl = '/tenant/orders';
    let activeFilter = 'all';
    let searchKeyword = '';

    const countElements = {
        pending: document.getElementById('countWaiting'),
        preparing: document.getElementById('countProcessing'),
        ready: document.getElementById('countReady'),
        completed: document.getElementById('countCompleted'),
    };


    async function updateOrderStatus(orderId, newStatus) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!csrfToken) {
            alert('Token keamanan tidak ditemukan. Silakan muat ulang halaman.');
            return;
        }

        try {
            const response = await fetch('/tenant/orders/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    tenant_order_id: orderId,
                    status: newStatus,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message ?? 'Gagal memperbarui status pesanan.');
            }

            await loadOrders();
        } catch (error) {
            console.error(error);
            alert(error.message);
        }
    }

    async function loadOrders({ showLoading = true } = {}) {
        if (showLoading) {
            ordersContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="small text-muted mt-2">Memuat pesanan...</div>
                </div>
            `;
        }

        const params = new URLSearchParams({
            status: activeFilter,
            search: searchKeyword,
        });

        try {
            const response = await fetch(`${dataUrl}?${params}`, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data pesanan.');
            }

            const result = await response.json();

            Object.entries(countElements).forEach(([status, element]) => {
                if (element) {
                    element.textContent = result.counts?.[
                        status === 'pending' ? 'waiting' :
                        status === 'preparing' ? 'processing' :
                        status
                    ] ?? 0;
                }
            });

            renderOrders(result.orders ?? []);
        } catch (error) {
            console.error(error);

            if (showLoading) {
                ordersContainer.innerHTML = `
                    <div class="alert alert-danger mb-0">
                        Gagal memuat pesanan. Silakan coba kembali.
                    </div>
                `;
            }
        }
    }

    
    function renderOrders(orders) {
        if (!orders.length) {
            ordersContainer.innerHTML = `
                <div class="container d-flex flex-column justify-content-center
                    align-items-center bg-secondary-subtle rounded-2 py-4">
                    <div class="display-6 text-secondary mb-2">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <h6 class="m-0">Belum ada pesanan masuk</h6>
                </div>
            `;
            return;
        }

        const statusConfig = {
            pending: {
                label: 'Menunggu Konfirmasi',
                badge: 'bg-warning text-dark',
                button: 'Terima Pesanan',
                nextStatus: 'preparing',
                buttonClass: 'btn-primary',
            },
            preparing: {
                label: 'Sedang Diproses',
                badge: 'bg-info text-dark',
                button: 'Siap Diambil',
                nextStatus: 'ready',
                buttonClass: 'btn-success',
            },
            ready: {
                label: 'Siap Diambil',
                badge: 'bg-success',
                button: 'Selesaikan Pesanan',
                nextStatus: 'completed',
                buttonClass: 'btn-dark',
            },
            completed: {
                label: 'Selesai',
                badge: 'bg-secondary',
                button: null,
                nextStatus: null,
                buttonClass: null,
            },
        };

        ordersContainer.innerHTML = orders.map(order => {
            const config = statusConfig[order.status] ?? statusConfig.pending;

            return `
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="fw-bold mb-1">
                                    ${escapeHtml(order.order_number)}
                                </h6>
                                <div class="small text-muted">
                                    ${escapeHtml(order.order?.customer_name ?? '-')}
                                </div>
                                ${order.order?.created_at ? `
                                    <div class="small text-muted mt-1">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        Dipesan:
                                        ${escapeHtml(new Intl.DateTimeFormat('id-ID', {
                                            day: '2-digit',
                                            month: 'long',
                                            year: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            timeZone: 'Asia/Jakarta',
                                        }).format(new Date(order.order.created_at)))}
                                    </div>
                                ` : ''}
                                <div class="small text-muted mt-1">
                                    Layanan:
                                    ${escapeHtml({
                                        dine_in: 'Dine In',
                                        take_away: 'Take Away',
                                        after_activity: 'After Activity',
                                    }[order.order?.service_type] ?? '-')}
                                </div>
                                ${order.order?.service_type === 'after_activity' &&
                                    order.order?.pickup_date && order.order?.pickup_time ? `
                                    <div class="small text-muted mt-1">
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        Jadwal Pengambilan:
                                        ${escapeHtml(formatPickupDate(order.order.pickup_date))}
                                        ${escapeHtml(String(order.order.pickup_time).slice(0, 5))}
                                    </div>
                                ` : ''}
                            </div>
                            <span class="badge ${config.badge}">
                                ${escapeHtml(config.label)}
                            </span>
                        </div>
                        <div class="fs-5 fw-bold text-success">
                            ${escapeHtml(order.pickup_code)}
                        </div>
                        <hr>                  
                        <div class="mb-3">
                            <div class="small fw-semibold mb-2">
                                Daftar Produk
                            </div>
                            <div class="d-flex flex-column gap-2">
                                ${(order.items ?? []).map(item => `
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small">
                                            ${escapeHtml(item.product_name)}
                                        </span>
                                        <span class="badge bg-light text-dark border">
                                            ${escapeHtml(item.quantity)}x
                                        </span>
                                    </div>
                                `).join('')}
                            </div>
                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mb-3">
                                <span class="small fw-semibold">Subtotal</span>
                                <span class="fw-bold text-primary">
                                    Rp ${Number(order.subtotal).toLocaleString('id-ID')}
                                </span>
                            </div>
                            ${order.order?.notes ? `
                                <div class="mb-3">
                                    <div class="small fw-semibold mb-1">
                                        Catatan Pelanggan
                                    </div>
                                    <div class="small text-muted bg-light rounded-2 p-2">
                                        ${escapeHtml(order.order.notes)}
                                    </div>
                                </div>
                            ` : ''}
                            ${order.notes ? `
                                <div class="mb-3">
                                    <div class="small fw-semibold mb-1">
                                        Catatan untuk Tenant
                                    </div>
                                    <div class="small text-muted bg-warning-subtle rounded-2 p-2">
                                        ${escapeHtml(order.notes)}
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                        ${config.button ? `
                            <div class="d-flex justify-content-end mt-3">
                                <button
                                    type="button"
                                    class="btn ${config.buttonClass} btn-sm"
                                    data-order-id="${escapeHtml(order.id)}"
                                    data-next-status="${config.nextStatus}">
                                    ${config.button}
                                </button>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, character => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        })[character]);
    }


    function formatPickupDate(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '-';
        }

        return new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            timeZone: 'Asia/Jakarta',
        }).format(date);
    }

    searchInput.addEventListener('input', () => {
        searchKeyword = searchInput.value.trim();
        loadOrders();
    });

    filterContainer.addEventListener('click', event => {
        const button = event.target.closest('[data-filter]');

        if (!button) {
            return;
        }

        activeFilter = button.dataset.filter;

        filterContainer.querySelectorAll('[data-filter]').forEach(item => {
            item.classList.remove('active');
        });

        button.classList.add('active');
        loadOrders();
    });

    
    ordersContainer.addEventListener('click', event => {
        const button = event.target.closest('[data-order-id][data-next-status]');

        if (!button) {
            return;
        }

        updateOrderStatus(
            button.dataset.orderId,
            button.dataset.nextStatus
        );
    });

    refreshButton?.addEventListener('click', () => {
        loadOrders({ showLoading: true });
    });

    // Pemuatan pertama
    loadOrders({ showLoading: true });

    // Pembaruan otomatis setiap 10 detik
    window.KantinAutoRefresh?.start(() => {
        return loadOrders({ showLoading: false });
    }, 10000);
});
