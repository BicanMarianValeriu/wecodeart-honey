/** 
 * Changelogs Lists
 */
export default () => {
	const lists = document.querySelectorAll('.changelog-list');

	for (const item of lists) {
		let type = item.classList;
		type = type[type.length - 1].split('--').pop();

		let icon = '';
		if (type === 'added') {
			icon = 'fas fa-plus-circle has-success-color';
		} else if (type === 'updated') {
			icon = 'fas fa-pen has-warning-color';
		} else if (type === 'fixed') {
			icon = 'fas fa-wrench has-primary-color';
		} else if (type === 'removed') {
			icon = 'fas fa-minus-circle has-danger-color';
		}

		const elements = item.querySelectorAll('li');
		for (const el of elements) {
			const iconEl = document.createElement('i');
			iconEl.className = `${icon} me-2`;
			el.insertBefore(iconEl, el.firstChild);
		}
	}
};