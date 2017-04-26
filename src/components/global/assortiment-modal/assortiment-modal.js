import 'slick-carousel';
import "gsap";
require('gsap/src/uncompressed/plugins/ScrollToPlugin.js');

function slickSliderActions() {

  // $(document).on('opening', '.remodal.remodal--gallery-assortiment', function(e) {
  //
  //     $('.slick-slider', $(e.target)).each(function() {
  //         $(this).slick('setPosition');
  //
  //     });
  //
  // });
  var $assortimentModal = $('.assortiment-modal');

  $(document).on('afterLoad.fb', function( e, instance, slide ) {
  	// Your code goes here
    var $modalSource = $(instance.current.src);
    if ($modalSource.hasClass('assortiment-modal')) {
      $modalSource.find('.slick-slider').each(function() {
        $(this).slick('setPosition');
      });
    }

  });

  $assortimentModal.each(function() {
      var $gallery = $(this),
          galleryId = '#' + $gallery.attr('id');

      var isGlassGallery = galleryId === 'glass-gallery';
      var isMirrorsGallery = galleryId === 'mirrors-gallery';

      var bigSliderSelector = galleryId + ' .big-image-slider',
          bigSlideSelector = galleryId + ' .gallery-slide';

      var smallSliderSelector = galleryId + ' .small-image-slider',
          smallSlideSelector = galleryId + ' .gallery-thumb';

      var $bigSlider = $(bigSliderSelector),
          $smallSlider = $(smallSliderSelector);

      var slidesLength = $(smallSlideSelector).length,
          // obligatory slidesToShow need to be %2 == 0
          slidesToShow = isGlassGallery ? 6 : 4,
          centerMode = true,
          variableWidth = true;

      // if (slidesLength < slidesToShow) {
      //     slidesToShow = slidesLength;
      //     centerMode = false;
      //     variableWidth = true;
      // }

      /** LARGE IMAGE SLIDER **/
      $bigSlider.on('init beforeChange', function(event, slick, currentSlide, nextSlide) {

          var slideIndex = (typeof nextSlide !== "undefined")
              ? nextSlide
              : (typeof currentSlide !== "undefined"
                  ? currentSlide
                  : 0);
          var $currentSlide = $gallery.find("[data-slick-index='" + slideIndex + "']");

          // console.log('slideIndex: ', slideIndex);
          // console.log('surrentSlide: ', $currentSlide);

          getContentOfSlide($currentSlide, $gallery);

      }).slick({
          slide: bigSlideSelector,
          asNavFor: smallSliderSelector,
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          // cssEase: 'cubic-bezier(0.9, 0.00, 0.1, 1.0)',
          cssEase: 'ease',
          speed: 800,
          dots: false,
          //  initialSlide: 0,
      });

      /** THUMBS SLIDER **/
      $smallSlider.slick({
          slide: smallSlideSelector,
          slidesToShow: slidesToShow,
          asNavFor: bigSliderSelector,
          slidesToScroll: 1,
          dots: false,
          // lazyLoad: 'progressive',
          arrows: true,
          centerMode: centerMode,
          centerPadding: 0,
          variableWidth: variableWidth,
          swipeToSlide: true,
          focusOnSelect: true,
          //  initialSlide: 0,
          // cssEase: 'cubic-bezier(0.9, 0.00, 0.1, 1.0)',
          cssEase: 'ease',
          mobileFirst: true,
          inifinite: false,
          speed: 800,
          responsive: [
              {
                  breakpoint: 1200,
                  settings: {
                      slidesToShow: slidesToShow,
                  }
              }, {
                  breakpoint: 1024,
                  settings: {
                      slidesToShow: slidesToShow - 1
                  }
              }, {
                  breakpoint: 979,
                  settings: {
                      slidesToShow: slidesToShow - 2
                  }
              }
              , {
                  breakpoint: 768,
                  settings: {
                      slidesToShow: slidesToShow - 3,
                  }
              },
              //  {
              //     breakpoint: 480,
              //     settings: {
              //         slidesToShow: 2,
              //     }
              // }
          ]
      });


  });





  /**
   * Parse content from hidden block in each slide
   * @param  {HTMLELement} slide  - jQuery string
   * @param  {HTMLELement} context - jQuery string
   */
  function getContentOfSlide($slide, $gallery) {
      if (!$gallery) {
        console.error('$gallery instance is not defined');
        return;
      }

      var slideTitle = $slide.find('.gallery-slide__content-title').html();
      var slideDesc = $slide.find('.gallery-slide__content-desc').html();

      // var slideActions = $slide.find('.gallery-slide__content-actions').html();
      var $slideImage = $slide.find('.gallery-slide__image');

      // calcultor data
      var $calcData = $slide.find('.calculator-data');
      var nameId = $calcData.data('name-id') * 1,
          materialId = $calcData.data('materialId') * 1,
          depth = $calcData.data('depth')
                  ? ($calcData.data('depth') * 1)
                  : false;
      // добавили возможность выборки по типам
      var $types = $slide.find('.type');

      var $slideMaterial = $slide.find('.gallery-slide__content-material');
      var slideMaterialSource = $slideMaterial.attr('src');

      // modal gallery containers for dynamic data
      var $contextTitle = $gallery.find('.gallery-content__title');
      var $contextDesc = $gallery.find('.gallery-content__body');
      var $contextActions = $gallery.find('.gallery-content__actions');
      var $contextActions__depths = $contextActions.find('.gallery-content__depths');
      var $contextActions__typesContainer = $contextActions.find('.gallery-content__types-container');
      var $contextActions__types = $contextActions.find('.gallery-content__types');
      var $contextCalcBtn = $gallery.find('.gallery-content__button');



      var slideHasMaterial = $slideMaterial.length && $slideMaterial.hasClass('fullLoaded');

      // scene material
      var $contextMaterialContainer = $gallery.find('.gallery-scene__material');
      var $contextMaterialImage = $contextMaterialContainer.find('.gallery-scene__material-image');




      function renderContextActions() {
        $contextActions__depths.html('');
        $contextActions__types.html('');
        // размер по умолчанию => depth
        // массив размеров
        var depths = $calcData.data('depths');
        // массив картинок размеров (если 2 и более, иначе берется текущая картинка слайда)
        var depthsImages = $calcData.data('depths-images') ? $calcData.data('depths-images').split(',') : $slideImage.attr('src').split(',');



        // если массив размеров не пуст (у всех есть, но во избежание ошибок)
        if(depths) {
          // преобразуем значение в массив (значение может быть и числом и строкой)
          var depthsArray = ("" + depths).split(',');

          // для каждого значения размера выполним ряд действий
          for (var i = 0, len = depthsArray.length; i < len; ++i) {
            prepareRadiosForDepths(i, len);
          }
        }
        // endif

        // если есть разбивка по типами (контейнер не пуст)
        var typesLen = $types.length;
        if(typesLen) {
           for (var k = 0; k < typesLen; k++) {
             prepareRadiosForTypes(k, typesLen);
           }
           // показываем контейнер
           $contextActions__typesContainer.is(':hidden') && $contextActions__typesContainer.show();
        } else {
          // прячем контейнер для позиций без разбивки по типу
          $contextActions__typesContainer.hide();
          // ресетим data-type у кнопки
          resetTypeData($contextCalcBtn);
        }

        // функция подготовки радиокнопок выбора размера
        function prepareRadiosForDepths(i, len) {
          var $radioForDepth;
          var $input;
          // подготовка шаблона для радиокнопок размеров
          $radioForDepth = $(
            `<div class="input-wrapper">
              <input type="radio" name="radio-m-${materialId}" id="radio-m-${materialId}-d-${depthsArray[i]}" data-depth="${depthsArray[i]}">
              <label for="radio-m-${materialId}-d-${depthsArray[i]}"></label>
              <label for="radio-m-${materialId}-d-${depthsArray[i]}">${depthsArray[i]} мм</label>
            </div>`);
          // получаем доступ к инпуту
          $input = $radioForDepth.find('input[type="radio"]');

          // вешаем обработчики на созданный вариант
          $input.on('change', function(){
              var thisDepth = $(this).data('depth');
              changeImage(depthsImages[i], $slideImage);
              updateDepthData(thisDepth, $contextCalcBtn);
          });

          // должен быть выбран вариант по умолчанию
          depthsArray[i] == depth && $input.prop('checked', true).trigger("change");


          // добавляем разметку в DOM
          $contextActions__depths.append($radioForDepth);
        }

        // функция подготовки радиокнопок выбора типа
        function prepareRadiosForTypes(i, len) {


          var $radioForType, $input;

          var $type = $types.eq(i);
          var type__title = $type.find('.type__title').text();
          console.log('type__title', type__title);
          // необязательное наличие материала
          var $type_material = $type.find('.type__material');
          // если DOM элемент есть - получить картинку из дата атрибута
          var type__material = $type_material.length ? $type_material.data('img-src') : false;

          var type__image = $type.find('.type__image').data('img-src');


          // подготовка шаблона для радиокнопок размеров
          $radioForType = $(
            `<div class="input-wrapper">
              <input type="radio" name="radio-m-type" id="radio-m-${materialId}-t-${i+1}" data-type="${i+1}">
              <label for="radio-m-${materialId}-t-${i+1}"></label>
              <label for="radio-m-${materialId}-t-${i+1}">${type__title}</label>
            </div>`);
          // получаем доступ к инпуту
          $input = $radioForType.find('input[type="radio"]');

          // вешаем обработчики на созданный вариант
          $input.on('change', function(){
              changeImage(type__image, $slideImage);
              // если указан материал - обновить картинку материала
              type__material && changeImage(type__material, $contextMaterialImage);
              changeTypeData(type__title, $contextCalcBtn);
          });

          // первый из вариантов должен быть выбран по умолчанию
          i === 0 && $input.prop('checked', true).trigger("change");


          // добавляем разметку в DOM
          $contextActions__types.append($radioForType);
        }
      }

      /** Вспомогательные функции **/


      // функция обновления картинки $image источником source
      function changeImage(source, $image) {
        $image.attr('src', source);
      }


      // функция обновления данных кнопки в отношении выбранного размера
      function updateDepthData(newData, $target) {
        $target.data('depth', newData);
      }
      // функция установки выбранного типа
      function changeTypeData(newData, $target) {
        $target.data('type', newData);
      }
      function resetTypeData($target) {
        $target.data('type', '');
      }





      // dynamic data with transitions
      $contextTitle.add($contextDesc).add($contextActions).addClass('short_hidden').afterTransition(function() {
          // change new data
          $contextTitle.html(slideTitle);
          $contextDesc.html(slideDesc);
          renderContextActions();
          // make visible again
          $contextTitle.add($contextDesc).add($contextActions).removeClass('short_hidden');
      });




      $contextCalcBtn.addClass('short_shuffle').afterTransition(function() {
          $contextCalcBtn.removeClass('short_shuffle');
      })

      // if item with material preview is not empty and it image source isLoaded fully - get this
      if (slideHasMaterial) {
          $contextMaterialContainer.addClass('shortInvisible').afterTransition(function() {
              $contextMaterialImage.fadeOut(200, function() {
                  $contextMaterialImage.attr('src', slideMaterialSource);
                  $contextMaterialImage.fadeIn(200);
                  $contextMaterialContainer.removeClass('smallHiddenInRight').removeClass('shortInvisible');
              });

          });
      } else {
          $contextMaterialContainer.addClass('smallHiddenInRight');
      }



      $contextCalcBtn.off("click").on('click', function() {
        // кешируем значение размера из дата атрибута (если были переключения) или берём значение по умолчанию depth
        var dataDepth = $(this).data('depth') || depth;
        var dataType = $(this).data('type') || false;

          /** step 1 **/
          loadMaterials(nameId, 'block2', function() {

              setBlock(3, function() {
                  // check (1)
                  $('[data-name-id="' + nameId + '"]').prop("checked", true);

                  /** step 2 **/
                  // loadMaterialImage(materialId); <== DON'T work
                  loadTypes(materialId, 'block3', function() {
                      // check (2)
                      var $neededInput = $('[data-material-id="' + materialId + '"]');
                      $neededInput.prop("checked", true);
                      if(dataType) {
                        $('<span class="selected-type">' + dataType + '</span>').insertAfter($neededInput.next('label').next('label'));
                      }


                      setBlock(4, function() {
                          Raschet();
                          if (!depth)
                              return;


                          /** step 3 **/
                          loadFacet(dataDepth);
                          // check (3)
                          $('#block3 [data-depth="' + dataDepth + '"]').prop("checked", true);

                          $('#block4 div.shadow').addClass('shadow-hidden');
                          $('#block4 input[type=text] ').val('');
                          $('#block4 input[type=radio] ').removeAttr('checked');
                          $('#block4 input[type=text] ').attr('disabled', true);
                          setBlock(5);
                          Raschet();

                      });

                  });

              });
          });

          // clode modal and make focus at step 4


          $.fancybox.getInstance().close();

          // запускаем скролл после 500мс (у fancybox transition при закрытии 330мс)
          setTimeout(function () {
            var offset;
            if ($(".header__bottom--fixed").is(":visible") == true) {
                offset = $(".header__bottom--fixed").innerHeight();
            } else {
                offset = 0;
            }
            offset = offset || 60;
            TweenMax.to(window, 1.5, {
                scrollTo: {
                    y: depth
                        ? "#block4"
                        : "#block3",
                    offsetY: offset
                },
                ease: Expo.easeInOut
            });
          },330);

      });

  }



}

domready(function () {
  exports.init = function () {
      slickSliderActions();
  }
});
