import { Controller } from '@hotwired/stimulus';

/**
 * Reliable show/hide for invoice grid detail rows (Bootstrap collapse breaks inside tables).
 */
export default class extends Controller {
    static values = {
        rowId: String,
    };

    toggle(event) {
        event.preventDefault();
        const row = document.getElementById(this.rowIdValue);
        if (!row) return;

        row.classList.toggle('d-none');
        const expanded = !row.classList.contains('d-none');
        this.element.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    }
}
