 import { Controller } from '@hotwired/stimulus';

/**
 * Computes and fills "Total with VAT" for an invoice line.
 * Formula: totalWithVat = quantity * (amount + vatAmount)
 * Requires targets: quantity, amount, vatAmount, totalWithVat (on inputs within the controller element).
 */
export default class extends Controller {
    static targets = ['quantity', 'amount', 'vatAmount', 'totalWithVat'];

    connect() {
        this.boundUpdate = this.updateTotal.bind(this);
        for (const name of ['quantity', 'amount', 'vatAmount']) {
            if (this[`has${name.charAt(0).toUpperCase() + name.slice(1)}Target`]) {
                const el = this[`${name}Target`];
                el.addEventListener('input', this.boundUpdate);
                el.addEventListener('change', this.boundUpdate);
            }
        }
        this.updateTotal();
    }

    disconnect() {
        for (const name of ['quantity', 'amount', 'vatAmount']) {
            if (this[`has${name.charAt(0).toUpperCase() + name.slice(1)}Target`]) {
                const el = this[`${name}Target`];
                el.removeEventListener('input', this.boundUpdate);
                el.removeEventListener('change', this.boundUpdate);
            }
        }
    }

    updateTotal() {
        if (!this.hasTotalWithVatTarget) return;

        const q = this.parseNumber(this.hasQuantityTarget ? this.quantityTarget.value : null);
        const a = this.parseNumber(this.hasAmountTarget ? this.amountTarget.value : null);
        const v = this.parseNumber(this.hasVatAmountTarget ? this.vatAmountTarget.value : null);

        const total = (q * (a + (v/100*a)));
        const value = Number.isFinite(total) ? total.toFixed(2) : '';

        this.totalWithVatTarget.value = value;
    }

    parseNumber(value) {
        if (value === null || value === undefined || value === '') return 0;
        const n = Number(String(value).replace(',', '.'));
        return Number.isFinite(n) ? n : 0;
    }
}
