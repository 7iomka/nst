domready(function () {
  exports.init = function () {
      var $portfolio__moreExamplesContainer = $('.portfolio__more-examples');
      var portfolio__isExpanded = false;
      var $portfolio__loadMoreButton = $('.portfolio__load-more-button');

      $portfolio__loadMoreButton.on('click', function () {
        portfolio__isExpanded = $portfolio__moreExamplesContainer.is(':visible');
        if(!portfolio__isExpanded) {
          $portfolio__moreExamplesContainer.slideDown();
        } else {
          $portfolio__moreExamplesContainer.slideUp();
        }
      });

      return {
        portfolio__isExpanded: portfolio__isExpanded
      }
  }
});
