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
		// Icons
		dom.watch();
	},
};