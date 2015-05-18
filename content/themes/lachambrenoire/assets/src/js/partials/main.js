var MAIN = (function(my, Helpers, Gallery, Artist, Menu, Share, $) {
  var delayRepeat = 5000;

  my.initHomeScrollAnimation = function() {
    var vpWidth = $(window).width(),
      $target = $('.logo.single'),
      $desc = $('.artist-holder.big'),
      firstScroll = true;

    if ( vpWidth > 799) { //Don't animate on mobile

      $('.wrap.container').css({'margin-top' : -$desc.outerHeight()});

      $('body').on({
        'mousewheel': function (e) {
          if ($(window).scrollTop() === 0) {
            firstScroll = true;
            //TweenMax.to($target, 0.4, {opacity: 1, "z-index": 10});
            $desc.css({
              'top': $(window).height()
            });
          } else {
            if (firstScroll) {
              e.preventDefault();
              e.stopPropagation();
              //TweenMax.to($target, 0.4, {opacity: 0, "z-index": 0});
              //Correct for $Desc's height
              var borderWidth = 40;
              var elemHeightAdjust = $desc.outerHeight() / 2;
              var correction = borderWidth + elemHeightAdjust;

              TweenMax.to($desc, 1, {top: $(window).height() * -0.5, opacity: 1, "z-index": 10});
              setTimeout(function () {
                firstScroll = false;
              }, 1500);
            } else {
              TweenMax.to($desc, 0.4, {
                opacity: 0,
                "z-index": 0
              });
            }
          }
        }
      })
    }
  };

  my.initLogoDispear = function() {
    var $target = $('.logo.single');
    $(window).scroll(function(event) {
      if ($(window).scrollTop() === 0) {
        $target.css({'z-index': 10});
        TweenMax.to($target, 0.4, {
          opacity: 1
        });
        if ( $(window).width() < 800 ) {
          $('.artist-holder.big').css({'opacity' : 1});
        }
      } else {
        $target.css({'z-index': 0});
        TweenMax.to($target, 0.4, {
          opacity: 0
        });
      }
    });
  };

  my.initFooterBackTop = function() {
    $('.back-top').click(function(event) {
      $('html, body').animate({
        scrollTop: 0
      }, 800);
      return false;
    });
  };
  my.initSmoothScroll = function() {
    var $window = $(window);
    var scrollTime = 0.6;
    var scrollDistance = 170;

    $window.on("mousewheel DOMMouseScroll scroll", function(event) {

      event.preventDefault();

      var delta = event.originalEvent.wheelDelta / 120 || -event.originalEvent.detail / 3;
      var scrollTop = $window.scrollTop();
      var finalScroll = scrollTop - parseInt(delta * scrollDistance);

      TweenMax.to($window, scrollTime, {
        scrollTo: {
          y: finalScroll,
          autoKill: true
        },
        ease: Power1.easeOut,
        overwrite: 5
      });

    });
  };

  my.initHomeLayout = function() {
    var container = document.querySelector('.article-list');
    var msnry = new Masonry(container, {
      itemSelector: 'article'
    });
  };

  my.animateInstagram = function() {
    setInterval(function() {
      TweenMax.to($('.fa-instagram'), 0.2, {
        color: '#fff',
        repeat: 5,
        yoyo: true,
        ease: Linear.easeOutBounce
      });
    }, delayRepeat);
  }


  my.init = function() {
    if ($('.home.page').length !== 0) {
      $(window).load(function() {
        TweenMax.to($('.home-loader'), 1.2,
          {
            height: 0,
            ease: Expo.easeIn
          }
        ).delay(0.5);
        my.initHomeLayout();
      });
      my.initHomeScrollAnimation();
      if ($(window).scrollTop() !== 0) {
        $('.logo.single, .artist-holder.big').css({
          'opacity': 0
        });
      }
    }
    my.initLogoDispear();
    if ( $(window).width() > 799 ) {
      my.initSmoothScroll();
    }
    my.initFooterBackTop();
    Gallery.init();
    Artist.init();
    Menu.init();
    Contact.init();
    Share.init();
    SLIDER.init('.photo-holder');
    my.animateInstagram();
  };

  return my;
}(MAIN || {}, HELPERS || {}, Gallery || {}, Artist || {}, Menu || {}, SHARE || {}, jQuery));
