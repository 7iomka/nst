// import 'vendors/jquery.fancybox.min.js';
// import 'vendors/jquery.fancybox-3.0.min.js';
import 'vendors/jquery.fancybox-3.1.2.min.js';

function modalActions() {
  if(!$('.modal-link').length) return;
  var $modalLinkAutoOpen = $('.modal-link--autoopen');

  $('.modal-link').on('click', function(){
    var $modalTarget = $(this).data('modal-target');
    var closeClickOutsideDataAttr = $(this).data('modal-close-click-outside');
    var closeClickOutside = typeof closeClickOutsideDataAttr !== 'undefined' ? closeClickOutsideDataAttr : true;
    // if(Modernizr.pointerevents && Modernizr.mq('(max-width: 960px)')) {
    //   closeClickOutside = false;
    // }
    // if($modalLinkAutoOpen.length && $(this).is($modalLinkAutoOpen)) {
    //   closeClickOutside = false;
    // }


    $.fancybox.close();
    $.fancybox.open({
        src  : $modalTarget,
        opts : {
          autoFocus: false,
          clickOutside : 'close',
          animationEffect : "fade",
          touch : false,
          hash : false,
          infobar: true,
          transitionEffect : "slide",
          transitionDuration : 100,
          spinnerTpl : '<div class="preloader" style="display:block"></div>',
          lang : 'ru',
        	i18n : {
        		'ru' : {
        			CLOSE       : 'Закрыть',
        			NEXT        : 'Назад',
        			PREV        : 'Вперёд',
        			ERROR       : 'Не удалось установить соединение. <br/> Пожалуйста, попробуйте позднее.',
        			PLAY_START  : 'Начать слайдшоу',
        			PLAY_STOP   : 'Поставить на паузу',
        			FULL_SCREEN : 'На полный экран',
        			THUMBS      : 'Превьюшки'
        		},
          }

        }
    });
  });


  if($modalLinkAutoOpen.length) {
    $modalLinkAutoOpen.click();
  }

  $('.modal-close').on('click', function () {
    // close current active modal
    $.fancybox.close();
  });




}



domready(function () {
  exports.init = modalActions
})
