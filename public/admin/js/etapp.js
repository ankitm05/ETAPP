// my js starts

	$(document).ready(function() {
              var owl = $('.appscrplay');
              owl.owlCarousel({
                items: 1,
				nav:true,
                loop: true,
                margin: 20,
                autoplay: true,
                autoplaySpeed: 2000,
                autoplayHoverPause: true,
				  responsive:{
        0:{
            items:1,
            nav:true,
        },
        600:{
            items:1,
            nav:true,
        },
        1000:{
            items:1,
            nav:true,
			dots:false,
            loop:true
        }
    }
              });
              $('.play').on('click', function() {
                owl.trigger('play.owl.autoplay', [1000])
              })
              $('.stop').on('click', function() {
                owl.trigger('stop.owl.autoplay')
              })
			  
			
            });