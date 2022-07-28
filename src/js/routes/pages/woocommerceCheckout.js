export default {
	init: () => {
		jQuery(document.body).on('checkout_error', (e) => document.forms['checkout'].classList.add('was-validated'));
	}
};