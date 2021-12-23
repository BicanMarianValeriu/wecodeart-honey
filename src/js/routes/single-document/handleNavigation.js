/**
 * Handle Navigation
 */
export default () => {
	const { fn: { getParents } } = wecodeart;
	
	const navElems = document.querySelectorAll('.hierarchy-menu__item .hierarchy-menu__list-toggle');
	for (let item of navElems) {
		const nextEl = item.nextElementSibling;
		const childLinks = nextEl.children;

		for (let item of childLinks) {
			if (item.classList.contains('hierarchy-menu__item--current')) {
				const parents = getParents(item, '.hierarchy-menu__list--child');
				for (let item of parents) {
					item.parentNode.classList.add('hierarchy-menu__item--active');
					item.style.display = 'block';
				}
			}
		}

		item.addEventListener('click', function () {
			let maybeShow = nextEl.style.display;
			item.parentNode.classList.toggle('hierarchy-menu__item--active');
			nextEl.style.display = maybeShow === 'block' ? 'none' : 'block';
		});
	}
};