jQuery('[data-carousel="swiper"]').each(function () {

	var container = jQuery(this).find('[data-swiper="container"]').attr('id');
	var slidesInt = jQuery('.swiper-slide', this).length;

	// Configuration
	var conf = {
		loopedSlides: slidesInt,
		prevButton: '#' + jQuery(this).find('[data-swiper="prev"]').attr('id'),
		nextButton: '#' + jQuery(this).find('[data-swiper="next"]').attr('id'),
		pagination: '#' + jQuery(this).find('[data-swiper="pagination"]').attr('id'),
		lazy: {
			loadPrevNext: true,
			loadPrevNextAmount: 2,
			lazy: true
		},
		watchSlidesProgress: true,
		watchSlidesVisibility: true,
		autoplay: {
			delay: 3500,
			disableOnInteraction: true,
		}
	};

	let value;
	if ( (value = jQuery(this).data('direction')) ) {
		conf.direction = value;
	}
	if ( (value = jQuery(this).data('initialslide')) ) {
		conf.initialSlide = value;
	}
	if ( (value = jQuery(this).data('autoheight')) ) {
		conf.autoHeight = value;
	}
	if ( (value = jQuery(this).data('slidesperview')) ) {
		conf.slidesPerView = value;
	}
	if ( (value = jQuery(this).data('loop')) ) {
		conf.loop = value;
	}
	if ( (value = jQuery(this).data('spacebetween')) ) {
		conf.spaceBetween = value;
	}
	if ( (value = jQuery(this).data('freemode')) ) {
		conf.freeMode = value;
	}
	if ( (value = jQuery(this).data('centeredslides')) ) {
		conf.centeredSlides = value;
	}

	// Initialization
	if (container) {
		var initID = '#' + container;
		var init = new Swiper(initID, conf);
		init.update();
	}
});
