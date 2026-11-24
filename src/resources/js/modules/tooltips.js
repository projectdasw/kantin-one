import { Tooltip } from 'bootstrap';

function initializeTooltips() {
    Tooltip.getOrCreateInstance(document.body, {
        selector: '[data-bs-toggle="tooltip"]',
        trigger: 'hover focus',
        boundary: document.body,
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeTooltips, {
        once: true,
    });
} else {
    initializeTooltips();
}