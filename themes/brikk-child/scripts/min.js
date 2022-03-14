document.addEventListener('DOMContentLoaded', function(){
    jQuery(document).ready( function($){
        $('.open__title').click(function(e) {
          e.preventDefault();
          $(this).toggleClass('minus plus');
          $(this).parent().find('.desc').toggleClass('open');
        });
    });   
  $('.box__slider').slick({
         arrows: true, 
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 2,
      slidesToScroll: 2,
    
        responsive: [
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
                    dots: true,
            }
          },
          {
            breakpoint: 601,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
                    dots: true,
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
    });
 });