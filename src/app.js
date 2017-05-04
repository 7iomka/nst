//
// function requireAll(r) { r.keys().forEach(r); }
// requireAll(
//   require.context('./components/', true, /\.js$/)
// );

/// import actions

// polifill for es6 vendors
import "babel-polyfill";

// boggyfill for viewport units (vw/vh/vmin/vmax)
const viewportUnitsHacks = require('viewport-units-buggyfill.hacks');
const viewportUnitsBuggyfill = require('viewport-units-buggyfill');


// smooth-animate jquery plugin
import "vendors/jquery.smooth-animate.js";

// util for run some code after css transition end
import "utils/jquery.after-transition.js";


// defer images util
import deferImages from "utils/defer-images.js";


  // import siteGallery from './components/common/_site-gallery/site-gallery.js';
  // import productsGallery from './components/common/product-group-item/product-group-item.js';

	// import './components/common/accordion/accordion.js';
	// import './components/common/base-slider/base-slider.js';

	import './components/common/button/button.js';
	// init modal-links && fancybox set-up
	import modalActions from './components/global/modal/modal.js';

	import videoReview from './components/common/video-review/video-review.js';
	// init scroll-links to target
	import scrollLinks from './components/global/scroll-link/scroll-link.js';
	// ajax && validation for all siteModals
	import siteModals from './components/partials/site-modals/site-modals.js';
	// import './components/common/calendar/calendar.js';
	// import './components/common/gallery-slider/gallery-slider.js';
	// import './components/common/goup/goup.js';
	// import './components/common/news-list/news-list.js';
  //
	// import './components/common/responsive-table/responsive-table.js';
	// import './components/common/spinner/spinner.js';
	// import './components/common/video-review/video-review.js';
	// import './components/global/navigation/navigation.js';
	// import './components/sections/about/about-reviews/about-reviews.js';
	// import './components/sections/cart/cart-items/cart-items.js';
	// import './components/sections/cart/cart-totals/cart-totals.js';
	// import './components/sections/catalog-3/product-group-actions.js';
	// import './components/sections/certificates/certificates.js';
	// import './components/sections/contacts/contacts/contacts.js';
	// import './components/sections/dealers/dealers/dealers.js';
	// import './components/sections/gosts/gosts-list/gosts-list.js';
	// import './components/sections/terms/terms-description/terms-description.js';


	// import headerMenu from './components/partials/site-header/header-menu.js';
	import gallery from './components/sections/home/our-works/our-works.js';

	import aboutDigits from './components/sections/home/about-digits/about-digits.js';
	import portfolioActions from './components/sections/home/portfolio/portfolio.js';


	import assortimentSliderActions from './components/global/assortiment-slider/assortiment-slider.js';

	import offerActions from './components/sections/home/offer/offer.js';
	import mapActions from './components/partials/site-footer/map.js';

  //
  // import './components/common/accordion/accordion-init.js';



// init actions
domready(function () {
	const vubInstance = viewportUnitsBuggyfill.init({
		hacks: viewportUnitsHacks,
		refreshDebounceWait: 250
	});
  const publicApi = {
		viewportUnitsBuggyfill: vubInstance,
		deferImages: deferImages.init(),
		// headerMenu: headerMenu.init(),
		videoReview: videoReview.init(),
		// scrollLinks: scrollLinks.init(),
		// gallery: gallery.init(),
		// mapActions: mapActions.init(),
		modalActions: modalActions.init(),
		siteModals: siteModals.init(),
		assortimentSliderActions: assortimentSliderActions.init(),
		// offerActions: offerActions.init(),
		aboutDigits: aboutDigits.init(),
		portfolioActions: portfolioActions.init(),
  }

  exports.publicApi =  {
    ...publicApi
  };

	// advanced resize triger for viewportUnitsBuggyfill
	$(window).on('resize orientationchange', function () {
		viewportUnitsBuggyfill.refresh();
	});
})

  // var siteGalleryInit = siteGallery();

// var glob = require("glob")
// var path = require('path');
// var basePath = './components/';
//
// var mods = glob.sync(path.join(basePath, '**/*.js')).reduce(function (loaded, file) {
//   var mod = require(file);
//
//   // mod is a function with a name, so use it!
//   if (mod instanceof Function) {
//     loaded[mod.name] = mod;
//   } else {
//     Object.keys(mod).forEach(function (property) {
//       loaded[property] = mod.property;
//     });
//   }
//
//   return loaded;
// }, {});

// console.log(mods);
