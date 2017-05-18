require('is-in-viewport/lib/isInViewport.js');
/********************************      transportGeography -- map settings      *******************/
  function transportGeographyMapSettings() {
    var myMap,
        mapIsLoaded = false,
        $window = $(window);

    var $transportGeographyCore  = $('.transport-geography__map');

    var $mapPreloader        = $transportGeographyCore.find('.transport-geography__preloader'),
        $mapPreloaderOverlay = $transportGeographyCore.find('.transport-geography__preloader-overlay');

    // check if map is in viewport and run some actions (once and on scroll)
    $window.on('scroll', _.debounce(whenMapIsInViewportActions,200)).trigger('scroll');

    /**
     * Some actions for map in a viewport
     */
    function whenMapIsInViewportActions(){
      // if map loading no need anymore
      if($transportGeographyCore.hasClass('map-loading')) return;
      // run some actions after core block will be visible (on no touch devices)
      if ($transportGeographyCore.hasClass('aos-animate')) {
        expandMap();
      } else {
        // if that is touch device
        if (Modernizr.touchevents) {
          if($transportGeographyCore.is(':in-viewport')) {
            expandMap();
          }
        }
      }
    }


    /**
     * Expand map instructions
     */
    function expandMap(){

      if (mapIsLoaded) {
          return;
      }

      $transportGeographyCore.addClass('transport-geography__map--expanded');

      !mapIsLoaded && (
        $mapPreloaderOverlay.fadeIn(),
        $mapPreloader.fadeIn()
      );

      // if ymaps is not defined - get it
      if(typeof ymaps === 'undefined'){
        $.getScript('//api-maps.yandex.ru/2.1/?lang=ru_RU', afterYMapsReady);
      } else {
        afterYMapsReady();
      }

      function afterYMapsReady(){
        $transportGeographyCore.addClass('map-loading');
          ymaps.ready(function() {

              setTimeout(YandexReadyHandlerSiteMap,500);
              setTimeout(function () {
                  $mapPreloader.fadeOut(),
                  $mapPreloaderOverlay.fadeOut(),
                  mapIsLoaded = true;
                  $transportGeographyCore.removeClass('map-loading');
              },700)

          });
      }


    }

    /**
     * Yandex map ready callback
     */
    function YandexReadyHandlerSiteMap() {
      if(typeof ymaps === 'undefined') {
        setTimeout(YandexReadyHandlerSiteMap, 500);
        return;
      }
        if (!myMap) {
            myMap = new ymaps.Map("map", {
                center: [
                    60.603707, 96.629345
                ],
                zoom: 4,
                controls: [],
                type: "yandex#map"
            }, {suppressMapOpenBlock: true});

            var zoomControl = new ymaps.control.ZoomControl({
               options: {
                   size: "auto",
                   adjustMapMargin: true,
                   position: {
                    right: 10,
                    top: 220
                   }
               }
           });
           myMap.controls.add(zoomControl);

           if(Modernizr.touchevents) {
            //  myMap.events.add('touchstart', function (e) {
            //     e.preventDefault(); // При двойном щелчке зума не будет.
            //     alert('свайпить незя')
            //  });
             myMap.behaviors.disable('drag');
           }
          
            myMap.container.fitToViewport();
            myMap.behaviors.disable('scrollZoom');
            myMap.behaviors.disable('wheel');

            return myMap;
        } else {
            myMap.destroy(); // Деструктор карты
            myMap = null;
        }
    }
  }

  domready(function () {
    exports.init = transportGeographyMapSettings
  })
