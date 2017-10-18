/**
 * layout.js
 *
 * Theme layout enhancements.
 *
 */
 
 (function($){
		
		// load styled scrollbar
		$(window).load(function(){
			var $ratio = 367.906 / 263.188;
			
		    $('.products .product-category:not(.type-product)').height($('.products .product-category:not(.type-product)').width() * $ratio);
		    $('.products .product-categorie:not(.type-product)').height($('.products .product-categorie:not(.type-product)').width() * $ratio);
		    $('.products .wc-product-image').height($('.products .wc-product-image').width() * $ratio);
		});
		
		// Hide mobile navigation on resize
		$(window).resize(function(){
		    var $ratio = 367.906 / 263.188;
			
			$('.products .product-category:not(.type-product)').height($('.products .product-category:not(.type-product)').width() * $ratio);
			$('.products .product-categorie:not(.type-product)').height($('.products .product-categorie:not(.type-product)').width() * $ratio);
			$('.products .wc-product-image').height($('.products .wc-product-image').width() * $ratio);
		});
})(jQuery);