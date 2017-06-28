jQuery(function($) {

	var viewport = $(window);
	var body = $('body');
	var html = $('html');

	/* ==========================================================================
	   Swiper
	   ========================================================================== */

	var mySwiper = new Swiper ('.swiper-container', {
		slidesPerView: 'auto',
		slidesPerColumn: 1,
        speed: 100,
        centeredSlides: true,
        paginationClickable: true,
        grabCursor: true,
        loop: false,
        pagination: '.swiper-pagination',
        freeMode: true,
        keyboardControl: true,
        slidesOffsetBefore: 0,
        slidesOffsetAfter: 0,
        spaceBetween: 64,
        breakpoints: {
	        480: {
		        spaceBetween: 32
	        },
	        640: {
		        spaceBetween: 48
	        }
        }
	})

	/* ==========================================================================
	   Menu
	   ========================================================================== */

	$('#menu-handler').click(function() {
		body.toggleClass('menu-active');
	});
	
	$('#main').click(function() {
		if(body.hasClass('menu-active')) {
			body.removeClass('menu-active');
		}
	});
	
	viewport.on({
		'resize' : function() {
			if(viewport.width() > 960) {
				body.removeClass('menu-active');
			}
		},
		'orientationchange' : function() {
			if(viewport.width() > 960) {
				body.removeClass('menu-active');
			}
		}
	});

	/* ==========================================================================
	   Photoswipe
	   ========================================================================== */

	var PhotoSwipe = window.PhotoSwipe,
		PhotoSwipeUI_Default = window.PhotoSwipeUI_Default;

	$('body').on('click', 'a[data-size]', function(e) {
		if(!PhotoSwipe || !PhotoSwipeUI_Default) {
			return;
		}

		e.preventDefault();
		openPhotoSwipe( this );
	});

	var parseThumbnailElements = function(gallery, el) {
		var elements = $(gallery).find('a[data-size]').has('img'),
			galleryItems = [],
			index;

		elements.each(function(i) {
			var $el = $(this),
				size = $el.data('size').split('x'),
				caption;

			if( $el.next().is('.wp-caption-text') ) {
				// image with caption
				caption = $el.next().text();
			} else if( $el.parent().next().is('.wp-caption-text') ) {
				// gallery icon with caption
				caption = $el.parent().next().text();
			} else if( $el.parent().parent().next().is('.wp-caption-text') ) {
				// gallery icon with caption
				caption = $el.parent().parent().next().text();
			} else {
				console.log();
				caption = $el.attr('title');
			}

			galleryItems.push({
				src: $el.attr('href'),
				w: parseInt(size[0], 10),
				h: parseInt(size[1], 10),
				title: caption,
				msrc: $el.find('img').attr('src'),
				el: $el
			});
			if( el === $el.get(0) ) {
				index = i;
			}
		});

		return [galleryItems, parseInt(index, 10)];
	};

	var openPhotoSwipe = function( element, disableAnimation ) {
		var pswpElement = $('.pswp').get(0),
			galleryElement = $(element).parents('.gallery, .hentry, .main, body').first(),
			gallery,
			options,
			items, index;

		items = parseThumbnailElements(galleryElement, element);
		index = items[1];
		items = items[0];

		options = {
			index: index,
			getThumbBoundsFn: function(index) {
				var image = items[index].el.find('img'),
					offset = image.offset();

				return {x:offset.left, y:offset.top, w:image.width()};
			},
			showHideOpacity: true,
			history: false,
			shareEl: false
		};

		if(disableAnimation) {
			options.showAnimationDuration = 0;
		}

		// Pass data to PhotoSwipe and initialize it
		gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
		gallery.init();
	};
	
	/* ==========================================================================
	   FitVids
	   ========================================================================== */
	
	$('.post-content').fitVids();

});