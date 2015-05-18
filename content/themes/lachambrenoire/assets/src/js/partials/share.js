var SHARE = (function(my, Helpers, Config, $) {

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
