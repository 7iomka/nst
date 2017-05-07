import 'vendors/jquery.fancybox.min.js';

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
          focus: false,
          closeClickOutside : closeClickOutside,
          touch: false,
          onComplete : function() {

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
