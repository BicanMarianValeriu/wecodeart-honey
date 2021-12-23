/**
 * Search JS Plugin
 * @author 		Bican Marian Valeriu
 * @license 	https://www.wecodeart.com/
 * @uses		Component class
 */

export default (function (wecodeart) {

	const { Component, Template } = wecodeart;

	Template.addTemplate('search-item', (entry) => {
		const {
			title,
			link,
			type,
			product: { name: productName = '' } = {},
		} = entry;

		const postHTML = document.createElement('li');
		postHTML.className = `list-group-item list-group-item-action search-item search-item--${type}`;

		postHTML.innerHTML = `
			<a href="${link}" class="search-item__body">
				<h6 class="search-item__title text-truncate">${title.rendered}</h6>
				<span class="badge has-light-background-color has-primary-color">${productName}</span>
			</a> 
		`;

		return postHTML;
	});


	const _defaults = {
		path: 'wp/v2/documents',
		query: {
			search: '',
			per_page: 5,
		},
		template: 'search-item',
		afterLoading: (data, options) => {
			const { Template } = wecodeart;
			const {
				DOM: {
					element,
					results
				},
				template,
				classes: {
					empty,
					found
				}
			} = options;

			results.innerHTML = '';

			if (data.length) {
				element.classList.add(found);
				element.classList.remove(empty);
				data.map(entry => results.appendChild(Template.render(template, entry)));
			} else {
				element.classList.add(empty);
				element.classList.remove(found);
				results.innerText = 'No Results found.';
			}
		},
		classes: {
			empty: 'empty',
			found: 'found',
			loading: 'js--is-loading',
		},
	};

	/**
	 * @class
	 */
	class LiveSearch extends Component {
		/**
		 * Construct Animate instance
		 * @constructor
		 * @param {Element} el
		 * @param {Object} options
		 */
		constructor(el, options) {
			super(LiveSearch, el, options);
			this.el.LiveSearch = this;
			/**
			 * Options for the animation
			 * @member LiveSearch#options
			 */
			this.options = Object.assign({}, LiveSearch.defaults, {
				DOM: {
					element: this.el,
					input: this.el.querySelector('input[type="text"]'),
					select: this.el.querySelector('select'),
					results: this.el.querySelector('.live-search__results')
				}
			}, options);
			LiveSearch._elements.push(this);
			this._setupEventHandlers();
		}

		static get defaults() {
			return _defaults;
		}

		static init(els, options) {
			return super.init(this, els, options);
		}

		/**
		 * Get Instance
		 */
		static getInstance(el) {
			const domElem = el.jquery ? el[0] : el;
			return domElem.LiveSearch;
		}

		/**
		 * Retrieves documsnts
		 *
		 * @param {object} options
		 */
		static async get({ path, query }) {
			const { REST, fn: { createParams } } = wecodeart;
			let URL = `${REST + path}/`;
			if (query) {
				const params = createParams(query);
				URL += `?${params}`;
			}
			const data = await fetch(URL).then(response => response.json());
			return data;
		}

		/**
		 * Update Option
		 */
		updateOption(keyName, value) {
			const options = this.options;
			Object.keys(options).forEach((key) => {
				if (key === keyName) {
					options[key] = value;
				}
			});
			this.options = options;
			return;
		}

		/**
		 * Teardown component
		 */
		destroy() {
			if (LiveSearch.getInstance(this.el)) {
				this._removeEventHandlers();
				const index = LiveSearch._elements.indexOf(this);
				LiveSearch._elements.splice(index, 1);
				this.el.LiveSearch = undefined;
			}
		}

		_removeClasses() {
			// IE 11 bug (can't remove multiple classes in one line)
			this.el.classList.remove(this.options.classes.loaded);
		}

		/**
		 * Setup Events
		 */
		_setupEventHandlers() {
			const {
				DOM,
				classes,
				path,
				query,
				afterLoading
			} = this.options;

			this.loading = false;
			this.hasResults = false;

			this._boundKeyBlurEvent = (e) => {
				e.preventDefault();
				const value = e.target.value;
				if (this.hasResults !== true || value === '') {
					DOM.results.innerHTML = '';
					DOM.element.classList.remove(classes.empty);
					DOM.element.classList.remove(classes.found);
					return;
				}
			};

			this._boundKeyUpEvent = (e) => {
				e.preventDefault();

				const key = e.which || e.keyCode;

				if (key === 13) return;

				const value = e.target.value;

				if (this.loading !== true && value) {
					this.loading = true;

					DOM.element.classList.add(classes.loading);

					return LiveSearch.get({
						path: this.options.path,
						query: {
							...this.options.query,
							search: value
						}
					}).then(v => {
						this.loading = false;

						afterLoading(v, this.options);

						DOM.element.classList.remove(classes.loading);

						if (v.length) {
							this.hasResults = true;
							return;
						}
						this.hasResults = false;
					});
				}

				DOM.results.innerHTML = '';
				DOM.element.classList.remove(classes.found);
				DOM.element.classList.remove(classes.empty);
			};

			this._boundSelectChangeEvent = (e) => {
				const value = e.target.value;

				if (value === 'all') {
					this.updateOption('path', path);
					this.updateOption('query', query);
				} else {
					if (value === 'changelog') {
						this.updateOption('path', 'wp/v2/changelogs');
						this.updateOption('query', query);
					} else {
						let params = {};
						const pIds = [...DOM.select.getElementsByTagName('optgroup')].map(i => i.getAttribute('data-value'));
						this.updateOption('path', path);

						if ([...pIds].includes(value)) {
							params.document_product = value;
							this.updateOption('query', { ...query, ...params });
						} else {
							const selectJq = jQuery(e.target);
							const product = selectJq.find('option:selected').parent('optgroup').attr('data-value');
							params.document_product = product;
							params.document_category = value;
							this.updateOption('query', { ...query, ...params });
						}
					}
				}

				const evt = document.createEvent('HTMLEvents');
				evt.initEvent('keyup', false, true);
				DOM.input.dispatchEvent(evt);
			};

			DOM.input.addEventListener('keyup', this._boundKeyUpEvent);
			DOM.input.addEventListener('blur', this._boundKeyBlurEvent);
			jQuery(DOM.select).on('change', this._boundSelectChangeEvent);
		}

		/**
		 * Remove Event Handlers
		 */
		_removeEventHandlers() {
			if (LiveSearch.getInstance(this.el)) {
				const { DOM } = this.options;
				DOM.input.removeEventListener('keyup', this._boundKeyUpEvent);
				DOM.input.removeEventListener('blur', this._boundKeyBlurEvent);
				jQuery('body').off('change', jQuery(DOM.select), this._boundSelectChangeEvent);
			};
		}
	}

	/**
	 * @static
	 * @memberof LiveSearch
	 */
	LiveSearch._elements = [];
	wecodeart.plugins.LiveSearch = LiveSearch;

}).apply(this, [window.wecodeart]);