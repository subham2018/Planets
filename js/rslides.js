$(function () {
	  $(".rslides").responsiveSlides({
	    auto: true,
	    pager: false,
	    nav: true,
	    speed: 500,
	    timeout: 5000,
	    prevText: "prev",
	    nextText: "Next", 
	    namespace: "callbacks",
	  });
	});