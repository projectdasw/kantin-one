
document.addEventListener('DOMContentLoaded', () => {
    const progressElements = document.querySelectorAll(
        '[data-tracking-progress]'
    );

    if (progressElements.length === 0) {
        return;
    }

    const statusConfig = {
        pending: {
            step: 1,
            label: 'Menunggu Konfirmasi',
            badge: ['bg-warning', 'text-dark'],
        },
        preparing: {
            step: 2,
            label: 'Sedang Diproses',
            badge: ['bg-info', 'text-dark'],
        },
        ready: {
            step: 3,
            label: 'Siap Diambil',
            badge: ['bg-success'],
        },
        completed: {
            step: 4,
            label: 'Selesai',
            badge: ['bg-secondary'],
        },
    };

    const statusLabels = {
        1: 'Pesanan diterima',
        2: 'Sedang diproses',
        3: 'Siap diambil',
        4: 'Pesanan selesai',
    };

    const formatDate = value => {
        if (!value) {
            return '';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '';
        }

        return `${new Intl.DateTimeFormat('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hourCycle: 'h23',
            timeZone: 'Asia/Jakarta',
        }).format(date)} WIB`;
    };

    const updateProgress = (element, tenantOrder) => {
        const config = statusConfig[tenantOrder.status];

        if (!config) {
            return;
        }

        const badge = element.querySelector('[data-tracking-status]');

        if (badge) {
            badge.classList.remove(
                'bg-warning', 'text-dark',
                'bg-info', 'bg-success', 'bg-secondary',
                'bg-light'
            );

            badge.classList.add(...config.badge);
            badge.textContent = config.label;
        }

        for (let step = 1; step <= 4; step++) {
            const active = config.step >= step;

            const circle = element.querySelector(
                `[data-tracking-step="${step}"]`
            );

            if (circle) {
                circle.classList.remove(
                    'bg-success', 'text-white', 'bg-light',
                    'text-muted', 'border'
                );

                circle.classList.add(
                    ...(active
                        ? ['bg-success', 'text-white']
                        : ['bg-light', 'text-muted', 'border'])
                );

                circle.innerHTML = active
                    ? '<i class="fa-solid fa-check small"></i>'
                    : '<i class="fa-solid fa-circle small"></i>';
            }

            const label = element.querySelector(
                `[data-tracking-label="${step}"]`
            );

            if (label) {
                label.classList.toggle('text-success', active);
                label.classList.toggle('text-muted', !active);
                label.textContent = statusLabels[step];
            }

            const timeElement = element.querySelector(
                `[data-tracking-time="${step}"]`
            );

            if (timeElement) {
                const timestamp = {
                    1: tenantOrder.created_at,
                    2: tenantOrder.accepted_at,
                    3: tenantOrder.ready_at,
                    4: tenantOrder.completed_at,
                }[step];

                timeElement.textContent = formatDate(timestamp);
            }
        }
    };

    const refreshTracking = async () => {
        const response = await fetch('/orders/status/data', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            cache: 'no-store',
        });

        if (!response.ok) {
            throw new Error('Gagal mengambil pembaruan pesanan.');
        }

        const result = await response.json();

        result.order.tenant_orders.forEach(tenantOrder => {
            const element = document.querySelector(
                `[data-tracking-progress="${CSS.escape(tenantOrder.id)}"]`
            );

            if (element) {
                updateProgress(element, tenantOrder);
            }
        });
    };

    refreshTracking();

    window.KantinAutoRefresh?.start(refreshTracking, 10000);
});
