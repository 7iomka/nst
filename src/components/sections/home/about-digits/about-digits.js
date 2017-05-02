domready(function () {
  exports.init = function () {

    var nua = navigator.userAgent;
    var isOldAndroidNativeBrowser = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 &&     nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));

    if(isOldAndroidNativeBrowser) {
      $("html").addClass("android-default-browser");
    }

    // add backgroundclip class if support
    Modernizr.addTest('backgroundclip',function() {

      var div = document.createElement('div');

      if ('backgroundClip' in div.style)
        return true;

      'Webkit Moz O ms Khtml'.replace(/([A-Za-z]*)/g,function(val) {
        if (val+'BackgroundClip' in div.style) return true;
      });

    });


  }
});
