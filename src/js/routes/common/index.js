// Deps
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import Tooltip from 'bootstrap/js/dist/tooltip';

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
		tooltipTriggerList.map((tooltipTriggerEl) => new Tooltip(tooltipTriggerEl));

		// Icons
		dom.watch();

		// Select2
		// const { fn: { requireJs }, lazyJs } = wecodeart;
		// requireJs(lazyJs, ['select2'], () => jQuery('select').select2());
	},
};