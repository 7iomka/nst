domready(function () {
  exports.init = function () {
      var $chart = $('.transport-schedule__chart .chart');
      var $indicators = $chart.find('.chart__indicator').not('.chart__indicator--first');

      $(window).on('resize orientationchange', _.debounce(setBgPositionOnIndocators,250)).trigger('resize');
      function setBgPositionOnIndocators(){
        for (var i = 0; i < $indicators.length; i++) {
          (function(index){
            calcIndicatorOffset(index);
          })(i);
        }

        function calcIndicatorOffset(i) {
          var $indicator = $indicators.eq(i);
          var $indicator__value = $indicator.find('.chart__indicator-value');
          var offset = -1*(i+1) * (parseInt($indicator.css('margin-left')) + $indicator.width());
          $indicator__value.css({
            'background-position': offset + 'px 100%'
          })
        }
      }
  }
});
