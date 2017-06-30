jQuery(window).on('load', function(){
	jQuery(".submit").off("click").on("click", openMenu);
	function changeIcon(type) {
		if (type == "close") {
			jQuery(".submit").off("click");
			jQuery(".submit").removeClass("submit").addClass("close").find("i").removeClass("fa-search").addClass("fa-times");
			jQuery(".close").on("click", closeMenu);
		} else if (type == "search") {
			jQuery(".close").off("click");
			jQuery(".close").removeClass("close").addClass("submit").find("i").removeClass("fa-times").addClass("fa-search");
			jQuery(".submit").on("click", openMenu);
		}
	}

	function openMenu(e) {
		e.preventDefault();
		jQuery(".site-search").addClass("active").find("input").focus();
		changeIcon("close");
	}

	function closeMenu(e) {
		e.preventDefault();
		jQuery(".site-search").removeClass("active");
		changeIcon("search");
	}
}(jQuery));