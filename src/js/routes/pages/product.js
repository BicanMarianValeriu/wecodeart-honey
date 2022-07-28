// ...as well as this small plugin
export default {
	complete: () => {
		jQuery(document.body).on('show_variation', ({ target }) => {
			jQuery(target).find('[data-bs-toggle="tooltip"]').tooltip();
		});
	}
};