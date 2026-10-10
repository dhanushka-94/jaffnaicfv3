import './bootstrap';
import 'aos/dist/aos.css';
import 'swiper/swiper-bundle.css';
import AOS from 'aos';
import Swiper from 'swiper';
import Alpine from 'alpinejs';

Alpine.data('programmeGallery', (images = []) => ({
	openLightbox: false,
	currentIndex: 0,
	images,
	openImage(index) {
		this.currentIndex = index;
		this.openLightbox = true;
		document.body.style.overflow = 'hidden';
	},
	closeLightbox() {
		this.openLightbox = false;
		document.body.style.overflow = '';
	},
	nextImage() {
		if (this.images.length > 0) {
			this.currentIndex = (this.currentIndex + 1) % this.images.length;
		}
	},
	prevImage() {
		if (this.images.length > 0) {
			this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
		}
	},
}));

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('click', (event) => {
	const link = event.target.closest('a.js-application-pdf');
	if (!link) {
		return;
	}

	event.preventDefault();

	const viewUrl = link.href;
	const saveUrl = `${viewUrl}${viewUrl.includes('?') ? '&' : '?'}save=1`;

	window.open(viewUrl, '_blank', 'noopener');

	const download = document.createElement('a');
	download.href = saveUrl;
	download.download = '';
	download.hidden = true;
	document.body.appendChild(download);
	download.click();
	download.remove();
});

window.addEventListener('DOMContentLoaded', () => {
	AOS.init({
		duration: 700,
		easing: 'ease-out',
		once: true,
	});
	// eslint-disable-next-line no-new
	new Swiper('.hero-swiper', {
		loop: true,
		autoHeight: true,
		autoplay: { delay: 5000 },
		pagination: { el: '.swiper-pagination', clickable: true },
		navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
	});
});
