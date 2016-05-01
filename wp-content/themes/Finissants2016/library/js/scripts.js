/*
 * Bones Scripts File
 * Author: Eddie Machado
 *
 * This file should contain any js scripts you want to add to the site.
 * Instead of calling it in the header or throwing it inside wp_head()
 * this file will be called automatically in the footer so as not to
 * slow the page load.
 *
 * There are a lot of example functions and tools in here. If you don't
 * need any of it, just remove it. They are meant to be helpers and are
 * not required. It's your world baby, you can do whatever you want.
*/


/*
 * Get Viewport Dimensions
 * returns object with viewport dimensions to match css in width and height properties
 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
*/
function updateViewportDimensions() {
	var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
	return { width:x,height:y };
}
// setting the viewport width
var viewport = updateViewportDimensions();


/*
 * Throttle Resize-triggered Events
 * Wrap your actions in this function to throttle the frequency of firing them off, for better performance, esp. on mobile.
 * ( source: http://stackoverflow.com/questions/2854407/javascript-jquery-window-resize-how-to-fire-after-the-resize-is-completed )
*/
var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) { uniqueId = "Don't call this twice without a uniqueId"; }
		if (timers[uniqueId]) { clearTimeout (timers[uniqueId]); }
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();

// how long to wait before deciding the resize has stopped, in ms. Around 50-100 should work ok.
var timeToWaitForLast = 100;


/*
 * Here's an example so you can see how we're using the above function
 *
 * This is commented out so it won't work, but you can copy it and
 * remove the comments.
 *
 *
 *
 * If we want to only do it on a certain page, we can setup checks so we do it
 * as efficient as possible.
 *
 * if( typeof is_home === "undefined" ) var is_home = $('body').hasClass('home');
 *
 * This once checks to see if you're on the home page based on the body class
 * We can then use that check to perform actions on the home page only
 *
 * When the window is resized, we perform this function
 * $(window).resize(function () {
 *
 *    // if we're on the home page, we wait the set amount (in function above) then fire the function
 *    if( is_home ) { waitForFinalEvent( function() {
 *
 *	// update the viewport, in case the window size has changed
 *	viewport = updateViewportDimensions();
 *
 *      // if we're above or equal to 768 fire this off
 *      if( viewport.width >= 768 ) {
 *        console.log('On home page and window sized to 768 width or more.');
 *      } else {
 *        // otherwise, let's do this instead
 *        console.log('Not on home page, or window sized to less than 768.');
 *      }
 *
 *    }, timeToWaitForLast, "your-function-identifier-string"); }
 * });
 *
 * Pretty cool huh? You can create functions like this to conditionally load
 * content and other stuff dependent on the viewport.
 * Remember that mobile devices and javascript aren't the best of friends.
 * Keep it light and always make sure the larger viewports are doing the heavy lifting.
 *
*/

/*
 * We're going to swap out the gravatars.
 * In the functions.php file, you can see we're not loading the gravatar
 * images on mobile to save bandwidth. Once we hit an acceptable viewport
 * then we can swap out those images since they are located in a data attribute.
*/
function loadGravatars() {
  // set the viewport using the function above
  viewport = updateViewportDimensions();
  // if the viewport is tablet or larger, we load in the gravatars
  if (viewport.width >= 768) {
  jQuery('.comment img[data-gravatar]').each(function(){
    jQuery(this).attr('src',jQuery(this).attr('data-gravatar'));
  });
	}
} // end function


/*
 * Put all your regular jQuery in here.
*/
jQuery(document).ready(function($) {

  /*
   * Let's fire off the gravatar function
   * You can remove this if you don't need it
  */
  loadGravatars();

	$(window).trigger('scroll'); // init the value


	// Search
	var qsRegex;
	// Isotope
	var $grid = $('#main').imagesLoaded( function() {
		// init Isotope after all images have loaded
		$body.addClass('is-loaded');
		$grid.isotope({
			itemSelector: 'article.hentry',
			layoutMode: 'fitRows'
		});
	});

	// use value of search field to filter
		var $quicksearch = $('.quicksearch').keyup( debounce( function() {
			searchFilter();
		}, 200 ) );

	function searchFilter() {
		qsRegex = new RegExp( $quicksearch.val(), 'gi' );
		$grid.isotope({
			filter: function() {
				return qsRegex ? $(this).text().match( qsRegex ) : true;
			}
		});
	}

	// debounce so filtering doesn't happen every millisecond
		function debounce( fn, threshold ) {
			var timeout;
			return function debounced() {
				if ( timeout ) {
					clearTimeout( timeout );
				}
				function delayed() {
					fn();
					timeout = null;
				}
				timeout = setTimeout( delayed, threshold || 100 );
			}
		}

	var $body = $('body');
	var $topNav = $('ul.top-nav');
	var $main = $('main#main');
	var $studentPopup = $('.student-popup');
	var $studentPopupStudent = $studentPopup.find('.student');
	var $studentPopupProject1 = $studentPopup.find('.project--one');
	var $studentPopupProject2 = $studentPopup.find('.project--two');

	// On page load
	var slug = location.href.replace(/\/$/, "").split("/").pop();
	if($body.hasClass('category')) {
		$grid.isotope({ filter: '.category-' + slug });
		$topNav.find('li.menu-' + slug).addClass('active');
	}

	// Navigation
	$topNav.on('click','li a',function(e){
		e.preventDefault();
		var cat = $(this).attr('href').replace(/\/$/, "").split("/").pop(); // Retrieve category slug
		buttonFilter = '.category-'+cat;
		$grid.isotope({ filter: '.category-' + cat }); // Filter isotope
		if($(this).parent().hasClass('active')){ // Deactivate filter
			$grid.isotope({ filter: '*' });
			document.title = "Annuel 2016";
			// history.pushState({slug: null}, "", '/' );
			history.pushState({slug: null}, "", '/staging' );
		// } else history.pushState({slug: cat}, "", '/' + cat );
		} else history.pushState({slug: cat}, "", '/staging/' + cat );
		$(this).parent().toggleClass('active').siblings().find('a').parent().removeClass('active');
	});

	// Click on a student
	$main.on('click','article.student',function(e){
		e.preventDefault();
		// history.pushState({slug: $(this).data('slug')}, "", "/student/" + $(this).data('slug'));
		history.pushState({slug: $(this).data('slug')}, "", "/staging/student/" + $(this).data('slug'));
		$.ajax({
			// url: '/wp-json/wp/v2/student-api/' + $(this).data('id') + '/'
			url: '/staging/wp-json/wp/v2/student-api/' + $(this).data('id') + '/'
		}).done(function(data){
			document.title = data.title.rendered;
			// Students
			$studentPopupStudent.find('.student--content').html(data.content.rendered);
			$studentPopupStudent.find('.student--avatar').html('<img src="' + data.avatar + '">');
			$studentPopupStudent.find('h1').html(data.title.rendered);
			// Projects - One
			var projectOne = data.projects[0],
					$projectCopy = $('.student .project');
			$projectImagesOne = '';
			projectOne.images.forEach(function(image){
				$projectImagesOne += '<div class="project--image"><img src="' + image + '"></div>';
			});
			$studentPopupProject1.find('.project--name').html(projectOne.title);
			$studentPopupProject1.find('.project--description').html(projectOne.description);
			$studentPopupProject1.find('.project--credits').html(projectOne.credits);
			$studentPopupProject1.find('.project--images').html($projectImagesOne);
			$studentPopupProject1.find('.project--video').html(projectOne.video);
			$projectCopy.find('.project--name').html(projectOne.title);
			$projectCopy.find('.project--description').html(projectOne.description);
			$projectCopy.find('.project--credits').html(projectOne.credits);
			// Projects - Two
			var projectTwo = data.projects[1];
			$projectImagesTwo = '';
			projectTwo.images.forEach(function(image){
				$projectImagesTwo += '<div class="project--image"><img src="' + image + '"></div>';
			});
			$studentPopupProject2.find('.project--name').html(projectTwo.title);
			$studentPopupProject2.find('.project--description').html(projectTwo.description);
			$studentPopupProject2.find('.project--credits').html(projectTwo.credits);
			$studentPopupProject2.find('.project--images').html($projectImagesTwo);
			$studentPopupProject2.find('.project--video').html(projectTwo.video);

			// Show popup
			$studentPopup.addClass('is-opened');
			$body.addClass('popup--open navigated');
		});
	});

	// Update project copy on scroll
	$('.student-popup--content').on("scroll resize", function(){
		var $projects = $('.projects .project'),
				$projectCopy = $('.student .project'),
				popupHeight = $('.student-popup').height() / 1.5;
		$projects.each(function(){
			if( $(this).data('project') != $projectCopy.data('project') &&
					$(this).offset().top + $(this).innerHeight() > 0 &&
					$(this).offset().top < popupHeight
				){
				$projectCopy.find('.project--name').html($(this).find('.project--name').html());
				$projectCopy.find('.project--credits').html($(this).find('.project--credits').html());
				$projectCopy.find('.project--description').html($(this).find('.project--description').html());
				$projectCopy.data('project',$(this).data('project'));
			}
		});
	});


	// Popup
	$studentPopup.on('click',function(e){
		if($(e.target).hasClass('student-popup')) {
			$(this).removeClass('is-opened');
			$body.removeClass('popup--open');
			if($body.hasClass('navigated')) history.back();
			// else history.pushState({slug: ''}, "", "/");
			else history.pushState({slug: ''}, "", "/staging/");
			document.title = "Annuel 2016";
		}
	});

	$studentPopup.on('click','.student-popup--close',function(e){
		$studentPopup.removeClass('is-opened');
		$body.removeClass('popup--open');
		if($body.hasClass('navigated')) history.back();
		// else history.pushState({slug: ''}, "", "/");
		else history.pushState({slug: ''}, "", "/staging/");
		document.title = "Annuel 2016";
	});

	$('.menu-toggle').on('click',function(e){
		$(this).closest('header').find('nav').toggleClass('is-opened');
	});

	$('.nav-close').on('click',function(e){
		$(this).closest('nav').removeClass('is-opened');
	})


}); /* end of as page load scripts */
