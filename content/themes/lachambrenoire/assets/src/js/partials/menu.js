var Menu = (function(my, Helpers, $){

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
