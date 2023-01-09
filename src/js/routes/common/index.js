// Deps
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// Common JS
import icons from './icons';

export default {
	/**
	 * Runs first before any JS
	 */
	init: () => {
		// Add Icons to FA Library
		library.add(icons);
	},
	complete: () => {
		// Tooltips
		const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		if (tooltipTriggerList.length) {
			import( /* webpackChunkName: "bootstrap/tooltip" */ "bootstrap/js/dist/tooltip").then(({ default: Tooltip }) => {
				tooltipTriggerList.map((tooltipTriggerEl) => new Tooltip(tooltipTriggerEl));
			});
		}

		// Icons
		dom.watch();

		// Mini Cart
		const miniCartButton = document.querySelector('.wc-block-mini-cart__button');
		if (miniCartButton) {
			miniCartButton.dispatchEvent(new Event('mouseover'));
		}

		// Select2
		// const { fn: { requireJs }, lazyJs } = wecodeart;
		// requireJs(lazyJs, ['select2'], () => jQuery('select').select2());
	},
};