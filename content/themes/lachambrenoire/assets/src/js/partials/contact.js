var Contact = (function(my, Helpers, $){

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
