
require('vendors/mixitup/jquery.mixitup.min.js');
require('vendors/mixitup/jquery.mixitup.pagination.min.js');
// require('jquery.custom.mixitup.js');

require('vendors/lightgallery/lightgallery.min.js');
require('vendors/lightgallery/lg-fullscreen.min.js');
require('vendors/lightgallery/lg-thumbnail.min.js');
// require('vendors/lightgallery/lg-video.min.js');
require('vendors/lightgallery/lg-autoplay.min.js');
require('vendors/lightgallery/lg-zoom.min.js');

/**********************     GALLERY     *******************/

const initGallery = function() {

  /**
  *  mixitup init
  */


  var $window = $(window),
    $galleryMain = $('.gallery'),
    $galleryContainer = $('.gallery__container'),
    $filters = $('.gallery__filter'),
    $galleryPager = $('.gallery__pager');

  function maxWidthCss(max) {
    return Modernizr.mq('(max-width: ' + max + 'px)');
  }

  if (maxWidthCss(480)) {
    galleryLimit = 4; // 50%
  } else if (maxWidthCss(541)) {
    galleryLimit = 6; // 33.333%
  } else if (maxWidthCss(767)) {
    galleryLimit = 8; // 25%
  } else if (maxWidthCss(1100)) {
    galleryLimit = 15; // 20%
  } else if (maxWidthCss(1550)) {
    galleryLimit = 18; // 16.6666667
  } else if (maxWidthCss(1920)) {
    galleryLimit = 24; // 12.5%
  } else {
    galleryLimit = 36; // 8.33333333% for 4k
  }

  /* --- ON GALLERY RESIZE RECALCULATIONS --- */
  function recalculateGallery() {

    if ($galleryContainer.length) {

      function setGalleryLimit(limit) {
        // console.log(galleryLimit, 'current galleryLimit');
        // if ($galleryContainer.hasClass('explore')) return;
        if (limit != galleryLimit) {
          $galleryContainer.mixItUp('paginate', {
            limit: limit,
            page: 1
          })
          galleryLimit = limit;
        };
      };

      if (maxWidthCss(480)) {
        setGalleryLimit(4);
      } else if (maxWidthCss(541)) {
        setGalleryLimit(6);
      } else if (maxWidthCss(767)) {
        setGalleryLimit(8);
      } else if (maxWidthCss(1100)) {
        setGalleryLimit(15);
      } else if (maxWidthCss(1550)) {
        setGalleryLimit(18);
      } else if (maxWidthCss(1920)) {
        setGalleryLimit(24);
      } else {
        setGalleryLimit(36);
      }

    };

  };

  // function updateGalleryContainerHeight(){
  //   $galleryMain.css('height',$galleryMain.outerHeight());
  // }
  /* ====== ON RESIZE ====== */
  // $window.resize(_.debounce(updateGalleryContainerHeight, 200));
  $window.resize(_.debounce(recalculateGallery, 200)).trigger('resize');
  $window.on('orientationchange', recalculateGallery);
  // $window.on('orientationchange', updateGalleryContainerHeight);

  // this function will be called when json will be ready
  function getGallery(data) {

    // console.log(data.stained);
    var catergoriesArr = data; // array of objects

    // for each catergory object
    $.each(catergoriesArr, function(index, obj) {

      var category_slug = obj.c, // get category name
        category_items = obj.i, // get category items
        numberOfMixDIVs = category_items.length; // get num of items in category
      // $('#mixItUpContainer').mixItUp('destroy');

      // var galleryModal = $('[data-remodal-id="gallery__item"]').remodal({hashTracking: false});

      // for each item we will create gallery item and will append it into gallery container
      for (var i = 0; i < numberOfMixDIVs; i++) {

        // for first items from limit load images directly
        var sourceForImage = "data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=";

        var $mixDiv = $(`
                <div>
                  <div class="gallery__item-wrapper">
                    <a
                      class="gallery__link ${category_slug}-category"
                      data-title="${category_items[i].t}"
                      data-exthumbimage="${category_items[i].th}"
                      data-src="${category_items[i].im}"
                      data-category="${category_slug}"
                      data-sub-html="#gallery__item-description-${category_slug}-${i}"
                    >
                      <img class="gallery__img" src="${sourceForImage}" data-src="${category_items[i].th}" />
                    
                    </a>
                    <div class="gallery__item-short-name">${category_items[i].t}</div>
                    <div class="gallery__item-description hidden" id="gallery__item-description-${category_slug}-${i}">
                        ${category_items[i].d}
                    </div>
                  </div>
                </div>`).attr({"data-item-order": i}).addClass(`mix ${category_slug} gallery__item`);

        $galleryContainer.append($mixDiv).contents().filter(function() {
          return this.nodeType === 3;
        }).remove();

      } // END FOR loop

    }); // END EACH loop

    /** after items-load finish init filter **/
    window.galleryIsLoaded = true;
    /* INIT FILTER GALLERY */
    function galleryFilter() {

      var lightGalleryScene;

      $galleryContainer.mixItUp({
        animation: {
          duration: 600,
          effects: 'fade',
          animateResizeContainer: false,
          includePadding: false
        },
        controls: {
          enable: true
        },
        pagination: {
          limit: galleryLimit,
          generatePagers: true
        },
        selectors: {
          pagersWrapper: '.gallery__pager-list'
        },
        load: {
          sort: 'random',
          filter: function() {
            // default filter load all
            return 'all';
          }()
        },
        callbacks: {
          onMixLoad: function(state) {
            //first-time lazyLoad
            lazyLoad('.mix', function(loadedImages) {});

            $galleryContainer.mixItUp('setOptions', {
              animation: {
                effects: 'fade scale',
                animateResizeContainer: true,
              }
            });

            setTimeout(function() {
              if (lightGalleryScene)
                lightGalleryScene.data('lightGallery').destroy(true); // destroy lightGalleryScene
              lightGalleryScene = $galleryContainer.lightGallery({
                selector: '.gallery__link',
                selectWithin: $('.mix'),
                hash: false,
                download: false,
                closable: false
              }); //re-initiate gallery
            }, 100);

          },
          onMixStart: function(state, futureState) {
            // console.log({'state': state, 'futureState': futureState})
            var activeFilter = state.activeFilter.split('.')[1];
            // for all filter select all categories
            if (futureState.activeFilter == '.mix') {
              setTimeout(function() {
                if (lightGalleryScene)
                  lightGalleryScene.data('lightGallery').destroy(true); // destroy lightGalleryScene
                lightGalleryScene = $galleryContainer.lightGallery({
                  selector: '.gallery__link',
                  selectWithin: $('.mix'),
                  hash: false,
                  download: false,
                  closable: false
                }); //re-initiate gallery
              }, 100);

              // else for each category reinit lightGallery separately
            } else {
              setTimeout(function() {
                if (lightGalleryScene)
                  lightGalleryScene.data('lightGallery').destroy(true); // destroy lightGalleryScene
                lightGalleryScene = $galleryContainer.lightGallery({
                  selector: futureState.activeFilter + '-category',
                  hash: false,
                  download: false,
                  closable: false
                  // selectWithin: $('.mix:visible')
                }); //re-initiate gallery
              }, 100);
            }

            // if(futureState.activeFilter !== '.mix'){
            // 	var urlHash = futureState.activeFilter.substr(1);
            // 	location.hash = urlHash;
            // } else if(location.hash){
            // 	location.hash = 'all';
            // }
            //
            // if(history.replaceState) {
            // 	history.replaceState({}, '', window.location.href);
            // }
          },
          onMixEnd: function(state) {

            // console.log($galleryContainer.data('lightGallery'), '$galleryContainer');
          }
        }
      });

      function setImgLoaded($img) {
        // find from the parents yourself wrapper and add visible class (make hidden loader and show image)
        $img.closest('.gallery__item-wrapper').addClass('loaded');
      }

      function lazyLoad(mixString, callback) {

        // for only visible items (limit for ALL variant filter)
        $galleryContainer.find(mixString).each(function() {

          var $img = $(this).find('img'),
            src = $img.attr('data-src'),
            $originalImg = $(this).find('.gallery__link').data('original-src');

          // after deferAllthumbsImages (function deferImages)
          $img.on('load', function() {
            setImgLoaded($img);
          });

          /**
               * make defer loading for big image on link of the thumb
               * @param  {String} $originalImg - string will use to create new Image
               */
          if (!$img.hasClass('lazyloaded')) {
            // before click on the thumb we will preload his large image
            // deferImage($originalImg, function (e) {
            //
            // }
            // );
            $img.attr('src', src).addClass('lazyloaded');

          };

        });

      };

      //// END
    }
    // call FILTER GALLERY
    galleryFilter();

  } // end gallery-data func
  $.ajax({
    url: '/assets/scripts/json/gallery-data.json', type: "GET", dataType: 'json',
    // cache: true, // <-- turn ON on production
  }).done(function(jsonData) {
    getGallery(jsonData);

  }).fail(function(request, textStatus, errorThrown) {
    // console.log(request.responseText);
    // console.log(textStatus);
    // console.log(errorThrown);
  }).always(function() {
    // console.log('always')
  });

  return {vasea: 1}

}

// exports
domready(function() {
  exports.init = initGallery
})
