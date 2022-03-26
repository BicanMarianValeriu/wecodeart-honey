import pluginWOOQty from './quantity';

export default {
	init: () => {
		pluginWOOQty();
		jQuery(document.body).on('updated_cart_totals', pluginWOOQty);
	}
};