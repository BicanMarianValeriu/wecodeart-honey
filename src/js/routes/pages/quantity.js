const updateQty = (item, action) => {
	let value = parseInt(item.value, 10);
	let min = parseInt(item.getAttribute('min'));
	let max = parseInt(item.getAttribute('max'));

	value = isNaN(value) ? 0 : value;
	min = isNaN(min) ? 0 : min;
	max = isNaN(max) ? 99999 : max;

	if (action === '-' && value > min) value--;
	if (action === '+' && value < max) value++;

	item.value = value;
	jQuery(item).trigger('change');
};

const pluginWOOQty = () => {
	const qtySelectors = document.querySelectorAll('.quantity');
	if (qtySelectors) {
		for (let i = 0; i < qtySelectors.length; i++) {
			const item = qtySelectors[i];
			if (item.hasQtyInit === true) continue;
			item.hasQtyInit = true;
			const input = item.querySelector('.quantity__qty');
			const itemBtns = item.querySelectorAll('.quantity__plus, .quantity__minus');
			for (let button of itemBtns) {
				button.addEventListener('click', ({ target: { value } }) => updateQty(input, value));
			}
		}
	}
};

export default pluginWOOQty;