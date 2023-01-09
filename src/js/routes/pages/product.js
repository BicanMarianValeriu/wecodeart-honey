// ...as well as this small plugin
export default {
	complete: () => {
		import( /* webpackChunkName: "bootstrap/tooltip" */ "bootstrap/js/dist/tooltip").then(({ default: Tooltip }) => {
			jQuery(document.body).on('show_variation', ({ target }) => {
				const tooltipEl = target.querySelector('[data-bs-toggle="tooltip"]');
				if(!tooltipEl) return;
				const tooltipObj = new Tooltip(tooltipEl);
			});
		});
	}
};