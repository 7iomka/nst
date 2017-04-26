//
// function requireAll(r) { r.keys().forEach(r); }
// requireAll(
//   require.context('./components/', true, /\.js$/)
// );

/// import actions

// polifill for es6 vendors
import "babel-polyfill";
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

	import headerVideo from './components/partials/site-header/header-video.js';
	import headerMenu from './components/partials/site-header/header-menu.js';
	import gallery from './components/sections/home/our-works/our-works.js';
	import assortiment from './components/sections/home/assortiment/assortiment.js';
	import assortimentModalActions from './components/global/assortiment-modal/assortiment-modal.js';

	import offerActions from './components/sections/home/offer/offer.js';
	import mapActions from './components/partials/site-footer/map.js';

  //
  // import './components/common/accordion/accordion-init.js';



// init actions
domready(function () {
  const publicApi = {
		headerVideo: headerVideo.init(),
		deferImages: deferImages.init(),
		headerMenu: headerMenu.init(),
		scrollLinks: scrollLinks.init(),
		gallery: gallery.init(),
		assortiment: assortiment.init(),
		mapActions: mapActions.init(),
		modalActions: modalActions.init(),
		siteModals: siteModals.init(),
		assortimentModalActions: assortimentModalActions.init(),
		offerActions: offerActions.init()
  }

  exports.publicApi =  {
    ...publicApi
  };
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
