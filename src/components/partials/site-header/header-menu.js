domready(function() {
  exports.init = function() {
    var $window = $(window);

    var $header = $('.header');
    var headerHeight = $header.outerHeight();
    var $bottomPanelStatic = $('.bottom-panel--static');
    var $bottomPanelFixed = $('.bottom-panel--fixed');

    var $headerBottom = $('.header__bottom');

    // var $headerBottomStatic = $('.header__bottom--static');
    var $headerBottomFixed = $('.header__bottom--fixed');

    var $navToggler = $('.navigation-toggler');
    var $navTogglerWrapper = $('.navigation-toggler-wrapper');
    var $navDesktop = $headerBottomFixed.find(".nav");
    var $navMobile = $headerBottomFixed.find(".nav-mobile");

    var isLg = Modernizr.mq('(min-width: 992px)');

    // ------------------------------------------------------------------------
    // Expand navigation actions
    // ------------------------------------------------------------------------
    $navToggler.click(function() {
      // var $neededNav = $navMobile.is(':hidden') ? $navDesktop : $navMobile;
      var $neededNav = isLg
        ? $navDesktop
        : $navMobile;
      $(this).closest($headerBottom).find($neededNav).slideToggle(400);
      $(this).toggleClass('active');
    });

    // ------------------------------------------------------------------------
    // Toggle type of navigation
    // ------------------------------------------------------------------------
    $window.on('resize resize:navToggle', _.debounce(function() {
      var mq = Modernizr.mq('(min-width: 992px)');
      // update variable isLg
      isLg = mq
        ? true
        : false;

      if (mq && $navMobile.is(':visible')) {
        $navMobile.fadeOut();
        $navToggler.removeClass('active');

      }
      if (!mq && $navDesktop.is(':visible')) {
        $navDesktop.fadeOut();
        $navToggler.removeClass('active');

      }

    }, 200)).trigger('resize:navToggle');


    // ------------------------------------------------------------------------
    // Hide Header on on scroll down
    // ------------------------------------------------------------------------

    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;

    $window.on('scroll scroll:navDown', function(event) {
      didScroll = true;
    });

    setInterval(function() {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 250);

    function hasScrolled() {
      var st = $(this).scrollTop();

      // Make sure they scroll more than delta
      if (Math.abs(lastScrollTop - st) <= delta)
        return;

      // If they scrolled down and are past the navbar, add class .nav-up.
      // This is necessary so you never see what is "behind" the navbar.
      if (st > lastScrollTop) {
        if (st > headerHeight) {
          // console.log('scrolldown after header - show but not add class to down and if present - remove it');
          $headerBottomFixed.show();
          $headerBottomFixed.hasClass('nav-down') && $headerBottomFixed.removeClass('nav-down');
        } else {
          // console.log('scrolldown BEFORE header - hide and removeClass nav-down if present');
          $headerBottomFixed.hasClass('nav-down') && $headerBottomFixed.removeClass('nav-down').afterTransition(function() {
            $(this).hide();
          });
        }
        // Scroll Down
      } else {
        if (st > headerHeight) {
          // console.log('scrollUp after header - addClass naw-down')
          // condition for wide screen (like MAC)
          if (st + $window.height() < $(document).height()) {
            $headerBottomFixed.addClass('nav-down');
          }

        } else {
          // console.log('scrollUp before header - hide and removeClass nav-down if present')
          $headerBottomFixed.hasClass('nav-down') && $headerBottomFixed.removeClass('nav-down').afterTransition(function() {
            $(this).hide();
          });
        }

      }

      lastScrollTop = st;
    }

    // ------------------------------------------------------------------------
    // Toggle bottom panel from relative position to fixed
    // ------------------------------------------------------------------------

    var toggleBottomPanel = function() {
      var st = $(this).scrollTop();
      if (st > headerHeight) {
        $bottomPanelFixed.addClass('active');
      } else {
        $bottomPanelFixed.removeClass('active');
      }

    };
    $window.on('scroll', toggleBottomPanel);

  } // end export
})
