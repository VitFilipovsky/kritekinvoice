import { Controller } from '@hotwired/stimulus';

const ROW_WRAPPER = '<li class="mb-3"><div class="card border-secondary-subtle"><div class="card-body bg-white" data-controller="invoice-line-total">__content__</div></div></li>';

/**
 * Handles dynamic add of invoice line rows in the invoice form.
 * Requires:
 *   - data-invoice-lines-target="list" on the ul (with data-prototype and data-index)
 *   - data-invoice-lines-target="addButton" on the add button
 */
export default class extends Controller {
    static targets = ['list', 'addButton'];

    connect() {
        this.boundAddLine = this.addLine.bind(this);
        this.addButtonTarget.addEventListener('click', this.boundAddLine);
    }

    disconnect() {
        if (this.hasAddButtonTarget) {
            this.addButtonTarget.removeEventListener('click', this.boundAddLine);
        }
    }

    addLine() {
        if (!this.hasListTarget) return;

        const list = this.listTarget;
        const index = list.dataset.index ?? list.children.length;
        const prototype = list.dataset.prototype ?? '';

        const newRow = prototype.replace(/__name__/g, index);
        const wrapper = ROW_WRAPPER.replace('__content__', newRow);
        list.insertAdjacentHTML('beforeend', wrapper);
        list.dataset.index = String(parseInt(index, 10) + 1);
    }
}
