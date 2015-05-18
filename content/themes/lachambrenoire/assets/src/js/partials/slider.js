/* globals */
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
