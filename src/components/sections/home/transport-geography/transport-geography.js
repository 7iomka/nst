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



      $.getScript('//api-maps.yandex.ru/2.1/?lang=ru_RU', function() {
        $transportGeographyCore.addClass('map-loading');
          ymaps.ready(function() {

              YandexReadyHandlerSiteMap();
              setTimeout(function () {
                  $mapPreloader.fadeOut(),
                  $mapPreloaderOverlay.fadeOut(),
                  mapIsLoaded = true;
                  $transportGeographyCore.removeClass('map-loading');
                  // $('#map').on('touchstart', function (e) {
                  //     if (e.touches.length <= 1) {
                  //       e.preventDefault();
                  //     }
                  //
                  // });
              },200)

          });

      });
    }

    /**
     * Yandex map ready callback
     */
    function YandexReadyHandlerSiteMap() {
        if (!myMap) {
            myMap = new ymaps.Map("map", {
                center: [
                    55.81764532573242, 37.575106041664064
                ],
                zoom: 17,
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
            myMap.geoObjects.add(new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: [55.816855509771, 37.574210183853]
                },
                properties: {
                    balloonContent: decodeURIComponent("%3Cp%3E%0A%09%20%D0%B3.%20%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%94%D0%BC%D0%B8%D1%82%D1%80%D0%BE%D0%B2%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2C%20%D0%B4.11%0A%3C%2Fp%3E"),
                    iconCaption: decodeURIComponent("%D0%B3.%20%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%94%D0%BC%D0%B8%D1%82%D1%80%D0%BE%D0%B2%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2C%20%D0%B4.11"),
                    hintCaption: decodeURIComponent("%D0%B3.%20%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%94%D0%BC%D0%B8%D1%82%D1%80%D0%BE%D0%B2%D1%81%D0%BA%D0%BE%D0%B5%20%D1%88%D0%BE%D1%81%D1%81%D0%B5%2C%20%D0%B4.11")
                }
            }, {preset: "islands#redDotIconWithCaption"}));
            myMap.geoObjects.add(new ymaps.GeoObject({
                geometry: {
                    type: "Point",
                    coordinates: [55.818645030304, 37.574513273471]
                },
                properties: {
                    balloonContent: decodeURIComponent("%3Cp%3E%0A%09%D0%B3.%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%BC.%20%D0%A2%D0%B8%D0%BC%D0%B8%D1%80%D1%8F%D0%B7%D0%B5%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%3Cbr%3E%0A%3C%2Fp%3E"),
                    iconCaption: decodeURIComponent("C%D1%82%D0%B0%D0%BD%D1%86%D0%B8%D1%8F%20%D0%BC%D0%B5%D1%82%D1%80%D0%BE%20%D0%A2%D0%B8%D0%BC%D0%B8%D1%80%D1%8F%D0%B7%D0%B5%D0%B2%D1%81%D0%BA%D0%B0%D1%8F"),
                    hintCaption: decodeURIComponent("C%D1%82%D0%B0%D0%BD%D1%86%D0%B8%D1%8F%20%D0%BC%D0%B5%D1%82%D1%80%D0%BE%20%D0%A2%D0%B8%D0%BC%D0%B8%D1%80%D1%8F%D0%B7%D0%B5%D0%B2%D1%81%D0%BA%D0%B0%D1%8F")
                }
            }, {preset: "islands#blueCircleDotIconWithCaption"}));
            myMap.geoObjects.add(new ymaps.GeoObject({
                geometry: {
                    type: "LineString",
                    coordinates: [
                        [
                            55.816872147601, 37.574191979669
                        ],
                        [
                            55.816940105545, 37.574060551427
                        ],
                        [
                            55.816805699736, 37.573419503473
                        ],
                        [
                            55.81694010552, 37.573328308366
                        ],
                        [
                            55.817349360806, 37.575138799451
                        ],
                        [
                            55.817927363132, 37.574817841691
                        ],
                        [
                            55.818532538874, 37.574475426259
                        ],
                        [
                            55.818574822035, 37.574550528111
                        ],
                        [
                            55.818621635453, 37.57452638823
                        ],
                        [55.818644287096, 37.574512977185]
                    ]
                },
                properties: {
                    balloonContent: decodeURIComponent(""),
                    iconCaption: decodeURIComponent("%D0%9A%D0%B0%D0%BA%20%D0%B4%D0%BE%D0%B1%D1%80%D0%B0%D1%82%D1%8C%D1%81%D1%8F%20%D0%BE%D1%82%20%D0%BC%D0%B5%D1%82%D1%80%D0%BE"),
                    hintCaption: decodeURIComponent("%D0%9A%D0%B0%D0%BA%20%D0%B4%D0%BE%D0%B1%D1%80%D0%B0%D1%82%D1%8C%D1%81%D1%8F%20%D0%BE%D1%82%20%D0%BC%D0%B5%D1%82%D1%80%D0%BE")
                }
            }, {
                fillColor: "#1e98ff",
                strokeColor: "#1e98ff",
                fillOpacity: 0.35,
                strokeOpacity: 1.00000,
                strokeWidth: 4
            }));
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
