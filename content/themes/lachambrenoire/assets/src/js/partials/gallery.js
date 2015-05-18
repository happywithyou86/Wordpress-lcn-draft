var Gallery = (function(my, Helpers, $){
  my.slider = $('.fade');
  my.controller = new ScrollMagic.Controller();

  my.closePhotoHolder = function(){
    $('.photo-holder .close').click(function(event) {
      var $photoHolder = $('.photo-holder');
      TweenMax.to($photoHolder, 0.4, {opacity: 0, onComplete: function(){
        TweenMax.to($photoHolder, 0.01, {"z-index": -1});
        $('.photo-holder.slick-slider').css({'pointer-events': 'none'});
      }});
      Helpers.enableScroll();
    });
  };
  my.showPhotoHolder = function(){
    $('.gallery-list .photo figure').click(function(event) {
      var $photo = $(event.target).closest('.photo');
      var $photoHolder = $('.photo-holder');
      Helpers.disableScroll();

      var index = 0;
      for(var i =0; i<$('.gallery-list .photo').length; i++){
        if($photo.is($('.gallery-list .photo')[i])){
          index = i;
          break;
        }
      }
      $('.photo-holder.slick-slider').css({'pointer-events': 'auto'});
      my.slider.slick('slickGoTo', index);

      TweenMax.to($photoHolder, 0.01, {"z-index": 30, onComplete: function(){
        TweenMax.to($photoHolder, 0.4, {opacity: 1});
      }});
    });
  };
  my.positionImages = function(){
    var photos = $('.gallery-list .photo');
    photos.each(function(index, el) {
      var $element = $(el);
      var containerWidth = $element.children('figure').width();
      var imgWidth = $element.find('img').width();
      var mean = (containerWidth - imgWidth)/2;
      if(Math.random() >= 0.5){
        mean *= -1;
      }
      $element.find('figure').css('left',mean);
    });
  };
  my.createSlide = function($element){
    var slide = '<div class="photo" data-index="">'
      +'<figure>'
      +'<img src="'+$element.find('img').attr('src')+'" alt="">'
      +'<figcaption>';
    $element.find('.starring').each(function(index, el){
      slide = slide + '<span class="origin">'+$(el).text()+'</span>';
    });
    //+'<span class="origin">'+$element.find('.origin').text()+'</span>'
    //+'<span class="date">'+$element.find('.date').text()+'</span>'
    //+'<span class="starring">'+$element.find('.starring').text()+'</span>'
    //+'<span class="produced">'+$element.find('.produced').text()+'</span>'
    slide = slide+               '</figcaption>'
    +'</figure>'
    +'</div>';
    return slide;
  };
  my.initSlides = function(){
    $('.gallery-list .photo').each(function(index, el) {
      var $element = $(el);
      $('.photo-holder .fade').append(my.createSlide($element));
    });
  };
  my.addSlide = function($element){
    my.slider.slick('slickAdd', my.createSlide($element));
  };
  my.initSlider = function(){
    my.slider.slick({
      infinite: true,
      speed: 800,
      prevArrow: $('.photo-holder .chevron-previous'),
      nextArrow: $('.photo-holder .chevron-next'),
    });
  };

  var vpWidth = $(window).width();

  my.initArtistTitleAnimation = function(){

    if ( vpWidth > 799 ) { //Don't animate on mobile
      $('.artist-wrapper').each(function(index, el) {
        var $element = $(el);
        var $container = $element.find('.artist-info');
        if ( $(window).height() <= 800){
          $container.css({'top': $(window).height() + 300});
        }
        else{
          TweenMax.to($container, 1.5,
            { top: $(window).height() * 0.68}
          );
        }
        var $info = $element.find('.info');
        //
        var duration = $element.height();

        $container.css({left: ($(window).width() - $container.width()) / 2});
        var scene = new ScrollMagic.Scene({
          triggerElement: $element,
          triggerHook: 0.1,
          duration: duration
        }).on("enter", function (event) {
            console.log('enter');
            $container.show();
            TweenMax.to($container, 0.2,
              { opacity: 1}
            );
          })
          .on("leave", function (event) {
            $container.hide();
            TweenMax.to($container, 0.2,
              { opacity: 0}
            );
          }).on("progress", function (event) {
            if (event.progress > 0.8){
              TweenMax.to($container, 1.5,
                { top: -200}
              );
            }
            else if (event.progress <= 0.8 && event.progress >= 0.2){
              if ( $(window).height() <= 800) {
                TweenMax.to($container, 1.5,
                  {top: $(window).height() * 0.5}
                );
              }
            }
            else if (event.progress < 0.2){
              if ( $(window).height() <= 800){
                TweenMax.to($container, 1.5,
                  { top: $(window).height() + 300}
                );
              }
              else{
                TweenMax.to($container, 1.5,
                  { top: $(window).height() * 0.68}
                );
              }
            }
            //console.log(event.progress);
          })
          .addTo(my.controller);
      });
    }

  };
  my.initPhotosAnimation = function(){
    if ( vpWidth > 799 ) { //Dont animate on mobile
      $('.gallery-list .photo').each(function(index, el) {
        var $element = $(el);
        var $target = $element.find('figure');

        var duration = $element.height()*2;
        var newY = 50 + ((index%3)*25);
        //console.log(newY);
        var scene = new ScrollMagic.Scene({
                  triggerElement: $element,
                  triggerHook: 0.8,
                  duration: duration
                })
                .setTween($target, {y: -newY})
                .addTo(my.controller);
      });
    }
  };

  my.initArtistListClicks = function(){
    $('.artists-list li.activated').click(function(event) {
       var self = this;
      $('.artists-list-overlay, .artists-list').addClass('fadeOut');
      var animated = false; //Prevent certain browser from firing twice
      $('.artists-list-overlay, .artists-list').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {
        if ( ! animated ) {
          animated = true;
          $('body').removeClass('artists-list-open');
          Helpers.enableScroll();
          $('.artists-list-overlay, .artists-list').removeClass('fadeOut');
          if ($('#' + $(self).data('artist')).length !== 0){
            $('body, html').animate({
                scrollTop:$('#' + $(self).data('artist')).offset().top - 100}, '500', 'swing',
              function() {
              });
          }
        }
      });

    });
  };

  my.handleImageLink = function (){
    $(window).load(function(){
      var imageSlug = Helpers.getUrlParameter('image');
      if (imageSlug !== '' && $('#' + imageSlug).length !== 0){
        $('#' + imageSlug).find('figure').click();
      //  setTimeout(function (){
      //    $('body, html').animate({
      //        scrollTop:$('#' + imageSlug).offset().top - 100}, '1000', 'swing',
      //      function() {
      //      });
      //  }, 1000);
      }
    });
  };

  my.init = function(){

    my.handleImageLink();
    my.showPhotoHolder();
    my.closePhotoHolder();
    //my.positionImages();
    my.initSlides();
    my.initSlider();
    my.initArtistTitleAnimation();
    my.initPhotosAnimation();
    my.initArtistListClicks();
  };

  return my;
}(Gallery || {}, HELPERS || {}, jQuery));
