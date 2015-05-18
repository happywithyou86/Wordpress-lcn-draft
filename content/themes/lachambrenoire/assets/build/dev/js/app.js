var CONFIG = (function(my){
  my.fbAppID = '831632540243818';

  return my;
}(CONFIG || {}));

;/* globals jQuery */
'use strict';
var HELPERS = (function(helpers, $){
  helpers.disableScroll = function(){
    $('body').on({
      'mousewheel': function(e) {
        if ($(e.target).closest('.artists-list').length === 0){
          e.preventDefault();
        }
        e.stopPropagation();
      },
      'touchmove': function(e){
        if ($(e.target).closest('.artists-list').length === 0){
          e.preventDefault();
        }
        e.stopPropagation();
      }
    });
  };
  helpers.enableScroll = function(){
    $('body').unbind('mousewheel');
    $('body').unbind('touchmove');
  };
  helpers.getIndex = function (item, array){
    var indexItem = 0;
    for(var i = 0; i < array.length; i++){
      if(item === array[i]){
        indexItem = i;
        break;
      }
    }
    return indexItem;
  };

  helpers.getUrlParameter = function(sParam)
  {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam)
      {
        return sParameterName[1];
      }
    }
  }

  return helpers;
}(HELPERS || {}, jQuery));
;var Artist = (function(my, $){

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
;var Contact = (function(my, Helpers, $){

  my.initLogoFade = function() {

    var logo = $('.contact .logo.single');
    TweenMax.to( logo, 2, {opacity: 0, "z-index": 0, onComplete: my.formFade});
  };

  my.formFade = function() {
    var form = $('.contact .main');
    $('.contact .logo.single').hide();
    TweenMax.to( form, 1, {opacity: 1, top: "50%", onComplete: my.elemFade});
  };

  my.elemFade = function() {
    TweenMax.staggerTo(".wpcf7 p", 0.5, {top: 0, opacity: 1}, 0.3 );
  }

  my.init = function(){
    my.initLogoFade();
  };

  return my;
}(Contact || {}, HELPERS || {}, jQuery));
;var Gallery = (function(my, Helpers, $){
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
;var Menu = (function(my, Helpers, $){

  my.initMenuOpen = function(){
    $('#js-menu-open').click(function(event) {
      $('body').addClass('menu-open');
      Helpers.disableScroll();
    });
  };
  my.initMenuClose = function(){
    $('#js-menu-close, .menu-overlay').click(function(event) {

      if (Modernizr.touch){
        $('.menu-overlay, .menu-holder').addClass('fadeOutMobile');
        var animated = false;
        if ( ! animated ) {
          animated = true;
          $('body').removeClass('menu-open');
          Helpers.enableScroll();
          if (Modernizr.touch){
            $('.menu-overlay, .menu-holder').removeClass('fadeOutMobile');
          }
          else{
            $('.menu-overlay, .menu-holder').removeClass('fadeOut');
          }
        }
      }
      else{
        $('.menu-overlay, .menu-holder').addClass('fadeOut');
        var animated = false; //Prevent certain browser from firing twice
        $('.menu-overlay, .menu-holder').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {

          if ( ! animated ) {
            animated = true;
            $('body').removeClass('menu-open');
            Helpers.enableScroll();
            if (Modernizr.touch){
              $('.menu-overlay, .menu-holder').removeClass('fadeOutMobile');
            }
            else{
              $('.menu-overlay, .menu-holder').removeClass('fadeOut');
            }
          }
        });
      }

    });
  };

  my.initSeeAllMenuOpen = function(){
    $('#see-all').click(function(event) {
      $('body').addClass('artists-list-open');
      Helpers.disableScroll();
    });
  };
  my.initSeeAllMenuClose = function(){
    $('#js-artists-list-close, .artists-list-overlay').click(function(event) {

      $('.artists-list-overlay, .artists-list').addClass('fadeOut');
      var animated = false; //Prevent certain browser from firing twice
      $('.artists-list-overlay, .artists-list').one("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function() {

        if ( ! animated ) {
          animated = true;
          $('body').removeClass('artists-list-open');
          Helpers.enableScroll();
          $('.artists-list-overlay, .artists-list').removeClass('fadeOut');
        }
      });
    });
  };

  my.init = function(){
    my.initMenuOpen();
    my.initMenuClose();
    my.initSeeAllMenuOpen();
    my.initSeeAllMenuClose();
    $('body').keyup(function(e){
      if(e.keyCode == 32){
        if ($('.menu-open').length !==0){
          e.preventDefault();
          e.stopPropagation();
          $('#js-menu-close').click();
          return false;
        }
        if ($('.artists-list-open').length !==0){
          e.preventDefault();
          $('#js-artists-list-close').click();
          return false;
        }
      }
    });
  };

  return my;
}(Menu || {}, HELPERS || {}, jQuery));
;var SHARE = (function(my, Helpers, Config, $) {

  my.init = function() {
    $(':not(.type2) .social .twitter-btn').each(function(){
      my.addTwitterShareLink($(this));
    });

    $(':not(.type2) .social .facebook-btn').each(function(){
      my.addFacebookShareLink($(this));
    });
  };

  my.addTwitterShareLink = function ($el) {
    var twittLink = $('<a/>', {
      href: '',
      title: 'LCN',
      'class': 'fa fa-twitter',
      html: ''
    }).on('click', function (e) {
      var shareText = $el.closest('figure').find('img').attr('alt') === undefined? '': $el.closest('figure').find('img').attr('alt');
      e.preventDefault();
      window.open('http://twitter.com/share?' +
        'text=' + encodeURIComponent(shareText) + ' ' + '&url=' + $el.data('link'),
        'twitterwindow',
        'height=450, width=550, top=' +
        ($(window).height() / 2 - 225) +
        ', left=' + ($(window).width() / 2 - 275) +
        ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
      return false;
    });
    $el.append(twittLink);
  };

  my.addFacebookShareLink = function ($el) {
    var GLOBALIMAGEURL = $el.data('link');
    var fbLink = $('<a/>', {
      href: '#',
      'class': 'fa fa-facebook',
      html: ''
    }).on('click', function (e) {
      e.preventDefault();
      FB.ui({
        app_id: Config.fbAppID,
        method: 'feed',
        link: GLOBALIMAGEURL
      }, function (response) {
        //console.log(response);
      });
      return false;
    });
    $el.append(fbLink);
  };


  return my;
}(SHARE || {}, HELPERS || {}, CONFIG || {}, jQuery));
;/* globals */
var SLIDER = (function(my, Config){
  'use strict';
  my.init = function(el){
    // Init slick sldier
    var $element = $(el );
    var $parent = $element.parent(),
      $prevArrow = $(el + ' .chevron-previous' ),
      $nextArrow = $(el + ' .chevron-next');
      $element.slick({
        autoplay: false,
        autoplaySpeed: 10000,
        fade: true,
        cssEase: 'linear',
        prevArrow: $prevArrow,
        nextArrow: $nextArrow,
        slide: '.slide',
        slidesToShow: 1,
        slidesToScroll: 1,
        draggable: false,
        onInit: function(){
          var $sliderList = $element.find('.slick-list');
          $sliderList.css({
              marginTop: ($(window).height() - $sliderList.outerHeight()) / 2
          });
          //if (Modernizr.touch) {
          //  $($element.find('.slider-item img')).each(function () {
          //    my.activatePinch(this);
          //  });
          //} else {
          //  $($element.find('.slider-item img')).each(function(){
          //    my.activateZoom(this);
          //  });
          //}
          //$('#courseListLoader').remove();
        },
        onAfterChange: function(){
          //$parent.find('.slider-title').text($parent.find('.slick-active').data('name'));
        }
      });

  };


  return my;
}(SLIDER || {}, CONFIG || {}));
;var MAIN = (function(my, Helpers, Gallery, Artist, Menu, Share, $) {
  var delayRepeat = 5000;

  my.initHomeScrollAnimation = function() {
    var vpWidth = $(window).width(),
      $target = $('.logo.single'),
      $desc = $('.artist-holder.big'),
      firstScroll = true;

    if ( vpWidth > 799) { //Don't animate on mobile
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
              TweenMax.to($desc, 1, {
                top: $(window).height() * 0.5,
                opacity: 1,
                "z-index": 10
              });
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
;/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($, Main) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
      Main.init();
    }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery, MAIN || {}); // Fully reference jQuery after this point.
