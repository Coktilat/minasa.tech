// @koala-prepend "lib/jquery.matchHeight-min.js"
// @koala-prepend "lib/slick.min.js"
// MH MAGAZINE
(function ($) {
	$(document).ready( function(){
		
		var $mh_magazine_ticker = $('.mh-magazine-ticker'),
			$magazine_slideshow_posts      = $( '.slideshow-posts' );
												
		if ( $mh_magazine_ticker.length ) {
			$mh_magazine_ticker.each(function () {	
			$(this).slick({
				arrows: $(this).data('arrows'),
				rtl: $(this).data('rtl'),
				autoplay: $(this).data('auto'),
				autoplaySpeed: $(this).data('speed'),
				infinite: true,
				speed: 500,
				fade: $(this).data('fx'),
				//cssEase: 'swing'
				slidesToShow: 1,
  				slidesToScroll: 1,
				vertical: $(this).data('vertical'),
				pauseOnHover: $(this).data('pause'),
				slide: '.mh-ticker-post'
			});
			});
		}
		
		if ( $magazine_slideshow_posts.length ) {
			$magazine_slideshow_posts.each(function () {
				var $magazine_slideshow_tabs = $(this).siblings('.slideshow-tabs').find('.mh-slideshow-tabs-wrap');
				$(this).slick({
					//slidesToShow: 1,
					//slidesToScroll: 1,
					speed: 500,
					arrows: true,
					fade: true,
				//	adaptiveHeight: true,
					rtl: $(this).data('rtl'),
					autoplay: $(this).data('auto'),
					autoplaySpeed: $(this).data('speed'),
					asNavFor: ($(this).data('nav') === 'true' ? $magazine_slideshow_tabs : null),
					
				});
				if ( $magazine_slideshow_tabs.length ) {					
				$magazine_slideshow_tabs.slick({
					vertical: true,
					slidesToShow: $(this).data('show'),
					slidesToScroll: 1,
					speed: 500,
					asNavFor: $(this),
					dots: false,
					arrows: true,
					centerMode: true,
					focusOnSelect: true,
					slide: '.slideshow-tab',

				});
				}
			});
		}
	
		//match heights
		$('.all-xs .mh-magazine-post-inner').matchHeight();
		$('.all-xl .mh-magazine-post-inner').matchHeight();
		$('.slideshow-column').matchHeight();
		
	}); // end ready

})(jQuery)