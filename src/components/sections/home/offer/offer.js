require('vendors/lightgallery/lightgallery.min.js');
require('vendors/lightgallery/lg-fullscreen.min.js');
require('vendors/lightgallery/lg-thumbnail.min.js');
require('vendors/lightgallery/lg-autoplay.min.js');
require('vendors/lightgallery/lg-zoom.min.js');


domready(function () {
  exports.init = function () {
    var $offerGallery = $('.offer__gallery');
    var $offerGalleryItem = $offerGallery.find('.offer__gallery-item');
    var $offerGalleryInitaliser = $('.offer__figure');

    var offerGalleryInstance = $offerGallery.lightGallery({
      selector: $offerGalleryItem,
      hash: false,
      download: false,
      closable: false
    }); 

    offerGalleryInstance.on('onAfterSlide.lg',function(event, prevIndex, index, fromTouch, fromThumb){
        $offerGalleryItem.removeClass('active');
        $offerGalleryItem.eq(index).addClass('active');
    });

    $offerGalleryInitaliser.on('click', function () {
      $offerGalleryItem.filter('.active').click();
    });

    return {
      DOM: {
        $offerGallery,
        $offerGalleryItem,
        $offerGalleryInitaliser
      },
      offerGalleryInstance,
    }
  }
});
