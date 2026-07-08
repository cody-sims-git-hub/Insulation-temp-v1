import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/** Scroll reveals — light IntersectionObserver, honors reduced-motion. */
function initReveals() {
	const els = document.querySelectorAll('[data-reveal]');
	const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (reduce || !('IntersectionObserver' in window)) {
		els.forEach((el) => el.classList.add('is-visible'));
		return;
	}

	const io = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					io.unobserve(entry.target);
				}
			});
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.12 }
	);

	els.forEach((el) => io.observe(el));

	// Safety net: never leave a section hidden.
	window.addEventListener('load', () => {
		setTimeout(() => {
			document.querySelectorAll('[data-reveal]:not(.is-visible)').forEach((el) => {
				if (el.getBoundingClientRect().top < window.innerHeight) el.classList.add('is-visible');
			});
		}, 1200);
	});
}

if (document.readyState !== 'loading') initReveals();
else document.addEventListener('DOMContentLoaded', initReveals);
