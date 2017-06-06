import 'swiper';

domready(function () {
  exports.init = function () {
    var videoSlider = new Swiper('.about-video__slider', {
        // Optional parameters
        loop: true,
        // If we need pagination
        pagination: '.about-video .swiper-pagination',

        // Navigation arrows
        nextButton: '.about-video .swiper-button-next',
        prevButton: '.about-video .swiper-button-prev',
        paginationClickable: true,

      })
  }
});
