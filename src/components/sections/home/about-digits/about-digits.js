require('is-in-viewport/lib/isInViewport.js');
domready(function() {
  exports.init = function() {

    var nua = navigator.userAgent;
    var isOldAndroidNativeBrowser = ((nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1) && !(nua.indexOf('Chrome') > -1));

    if (isOldAndroidNativeBrowser) {
      $("html").addClass("android-default-browser");
    }

    // add backgroundclip class if support
    Modernizr.addTest('backgroundclip', function() {

      var div = document.createElement('div');

      if ('backgroundClip' in div.style)
        return true;

      'Webkit Moz O ms Khtml'.replace(/([A-Za-z]*)/g, function(val) {
        if (val + 'BackgroundClip' in div.style)
          return true;
        }
      );

    });

    var $window = $(window);
    var $digitsSection = $('.about-digits');
    var $digits = $digitsSection.find('.about-digits__digits')
    var allDigitsWasScrolled = false;

    $window.on('scroll', _.throttle(scrollDigits, 250)).trigger('scroll');

    function scrollDigits() {

      if (allDigitsWasScrolled !== true && $digitsSection.is(':in-viewport')) {
        /** scroll digits **/
        $digits.each(function() {
          var $this = $(this),
            countTo = $this.data('count-to');

          $({countNum: $this.text()}).animate({
            countNum: countTo
          }, {

            duration: 1500,
            // easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              var completeNum = $this.hasClass('about-digits__digits--2')
                ? this.countNum.toLocaleString()
                : this.countNum;
              $this.text(completeNum);
              //alert('finished');
            }

          });

        });
        allDigitsWasScrolled = true;
      }

    }

  }
});
