var Artist = (function(my, $){

  my.initScrollBox = function(){
    console.log('init scroll box');
    $('.artist-slider').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      prevArrow: $('.other-artist .chevron-previous'),
      nextArrow: $('.other-artist .chevron-next'),
      responsive: [
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: false
          }
        }
      ]
    });

    var artist_fname = $('.img-holder').data('fname');
    var artist_lname = $('.img-holder').data('lname');
    var img_url = $('.img-holder').data('src');
    if ( img_url ) {
      $("<img />").attr("src", img_url);
      $('.img-holder').backstretch(img_url, {
        speed: 1200
      });
    }

    $('#js-artist-photo').click( function() {
      window.location.href = "gallery#slug("+artist_fname+", "+artist_lname+")";
    });
  };

  my.initAritistSliderClick = function(){
    $('.artist-slider .artist').on('click', function(e){
      var self = this;
      if (!$(self).hasClass('activated')) {
        e.preventDefault();
        return false;
      }
      else{
        //window.location.href = $(this).data('link');
        $('.text-holder .mounth').text($(self).data('month'));
        $('.text-holder .fname').text($(self).data('fname'));
        $('.text-holder .lname').text($(self).data('lname'));
        $('.text-holder .description').text($(self).data('description'));
        $('.img-holder').data('src',$(self).data('image_src'));
        $('.img-holder').backstretch($(self).data('image_src'), {
          speed: 600
        });
        TweenMax.to($('body'), 0.6,
          { scrollTop: 0, onComplete: function(){
            //$('.artist-slider .artist').show();
            //$(self).hide();
          }}
        );
      }
    })
  };

  my.init = function(){
    console.log('init Artist module');
    my.initScrollBox();
    my.initAritistSliderClick();
  };

  return my;
}(Artist || {}, jQuery));
