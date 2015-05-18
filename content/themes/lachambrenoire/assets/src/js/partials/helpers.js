/* globals jQuery */
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
