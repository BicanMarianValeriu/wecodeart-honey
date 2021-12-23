import Toast from 'bootstrap/js/dist/toast';
import Tooltip from 'bootstrap/js/dist/tooltip';

/**
 * Handle Feedback Ajax
 */
export default () => {
	const { Template } = wecodeart;
	let isLoading = false;

	function handleFeedback(e) {
		e.preventDefault();

		if (isLoading) return;

		const { ajaxUrl, nonce } = wecodeart;

		const form = new FormData();
		form.append('_wpnonce', nonce);
		form.append('action', 'wecodeart_document_feedback');
		form.append('post_id', this.dataset.id);
		form.append('type', this.dataset.type);
		const params = new URLSearchParams(form);

		isLoading = true;

		return fetch(ajaxUrl, {
			method: 'POST',
			body: params
		}).then(r => r.json()).then(r => {
			const { success, data: { meta = false, message, title } } = r;

			const toastHtml = `
			<div id="feedback-toast" class="toast has-{{ background }}-background-color has-white-color" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-header">
					<strong class="me-auto">{{ title }}</strong>
					<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">{{ message }}</div>
			</div>
			`;

			if (meta && parseInt(meta[this.dataset.type])) {
				const instance = Tooltip.getInstance(this);
				instance.hide();

				const value = meta[this.dataset.type].toString();

				// Update tooltip text
				const newTooltip = this.dataset.bsOriginalTitle.replace(/\d/g, value);
				this.setAttribute('data-bs-original-title', newTooltip);

				// Update tooltip badge
				const likesCount = this.querySelector('.badge');
				if (likesCount) likesCount.innerText = value;

				// Update meta count
				const metaCount = document.querySelector('.wp-block-post-likes span');
				if (metaCount) metaCount.innerText = value;
			}

			document.querySelector('.wp-site-toasts').insertAdjacentHTML('beforeend', Template.renderToString(toastHtml, {
				background: success ? 'success' : 'danger',
				title,
				message
			}));

			const feedbackEl = document.getElementById('feedback-toast');
			feedbackEl.addEventListener('hidden.bs.toast', feedbackEl.remove);
			const feedbackToast = new Toast(feedbackEl);
			feedbackToast.show();

			isLoading = false;
		});
	};

	// Attach Events
	const feedbackButtons = document.querySelectorAll('.document-feedback a.btn');
	for (let item of feedbackButtons) item.addEventListener('click', handleFeedback);
};