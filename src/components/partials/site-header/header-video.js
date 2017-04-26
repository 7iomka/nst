import 'vendors/jquery.vide.min.js';

domready(function () {
  exports.init = function () {
    /**
     * Header video background
     */
    var $header = $('.header');
    if(!$header.length) return;
    
    var videoPath = '/assets/videos/video';
    var posterPath = '/assets/images/videos/video';

    $header.vide({
        mp4: videoPath,
        webm: videoPath,
        ogv: videoPath,
        poster: posterPath
    }, {
        posterType: 'jpg',
        autoplay: true
    });
    // Get instance of the plugin
    var headerVideoInstance = $header.data('vide');

    // Get video element of the background. Do what you want.
    window.headerVideo = headerVideoInstance.getVideoObject();
  }
})
