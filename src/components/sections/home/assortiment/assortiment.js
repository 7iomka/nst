require('vendors/tilt.jquery.min.js');
domready(function () {
  exports.init = function () {

    const tilted = $('.js-tilt').tilt({
      axis: 'x',
      // glare: true,
      // maxGlare: .3,
      scale: 1.12,
      maxTilt: 20,
      perspective: 700
    });
    // disable tilt on touch devices
    if (Modernizr.touchevents) {
      if (tilted.length) {
        tilted.tilt.destroy.call(tilted)
      }
    }
  }
})
  
