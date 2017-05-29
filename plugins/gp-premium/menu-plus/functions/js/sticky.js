(function ($, window, document) {
    var StickUp = function(elem, opts) {
        var lastScrollTop = 0,
        scroll = 0,
        scrollDir = '',
        scrollDistance = 0,
        active = false,
        bottom = false,
        hold = false,
        disabled = false,
        landscape = false,
        portrait = false,
        stickyHeight = 0,
        outerHeight = 0,
		currentOuterHeight = 0,
        viewportHeight = 0,
        scrollBottom = 0,
        elementOffset = 0,
        elementOffsetBottom = 0,
        $element = $(),
        topMargin = 0,
        offset = 0,
        $placeholder = $( elem ).clone().css({
			'visibility': 'hidden',
			'display': 'none'
		}).attr({
			id: 'sticky-placeholder',
			itemtype: null,
			itemscope: null,
		}),
        $parent = $(),
        stickpoints = {
            top:0,
            bottom:0,
            custom:[]
        },
        left,
        
        //defaults
        options = {
            scrollHide: false,
            lazyHeight: 0,
            topMargin: "auto",
            keepInWrapper: false,
            wrapperSelector: '',
            zIndex: 99,
            syncPosition:false,
			namespaceClass: "stuckElement",
			fixedClass: "isStuck",
            disableOn:function(){
                return true;
            }
        },
                
        getTopMargin = function () {
            if (options.topMargin === 'auto') {
                return parseInt($element.css('marginTop'));
            } else {
                if (isNaN(options.topMargin) && options.topMargin.search("px") > 0) {
                    return parseInt(options.topMargin.replace("px", ""));
                } else if (!isNaN(parseInt(options.topMargin))) {
                    return parseInt(options.topMargin);
                } else {
                    void 0;
                    return 0;
                }
            }
        },
                
        unStick = function(){
            void 0;
			$placeholder.hide().removeClass( options.fixedClass ).removeClass( 'sticky-navigation-transition' );
            $element.removeClass(options.fixedClass)
            .css({ 
                maxWidth:"",
                marginTop: "", 
                marginLeft:"",
                marginRight:"",
                position: "",
                top: "",
                left: "", 
                right: "",
                bottom:"",
				width:""
            }).removeClass( 'sticky-navigation-transition' );
            active = false;
            bottom = false;
            hold = false;
            if(options.syncPosition)
                syncMargins();
			
			$element.trigger( 'stickUp:unStick' );
        },
                
        holdIt = function(forceBottom){
            void 0;
			$placeholder.show().addClass( options.fixedClass );
            var offsetParent = $placeholder.offsetParent();
            
            if (forceBottom){
                $element.css({
                    position: "absolute"
                });
                var topOffset = 
                    ($parent.offset().top + $parent.outerHeight()) //bottom of container
                    - offsetParent.offset().top - currentOuterHeight //parent-position - elementHeight
                    - parseInt($parent.css("paddingBottom"));
            }
            void 0;
            void 0;
            $element.css({
                position: "absolute",
                marginTop: topMargin,
                bottom:"",
                left:$placeholder.position().left,
                top: forceBottom? topOffset : $element.offset().top - offsetParent.offset().top - topMargin
            });
			
			$element.trigger( 'stickUp:holdIt' );
        },
        stickIt = function(){
            void 0;
            active = true;
			$placeholder.show().addClass( options.fixedClass );
            $element.addClass(options.fixedClass);
            var topDistance = -offset;

            $element.css({
                //maxWidth: parseInt($element.outerWidth()),
                marginTop: topMargin,
                position: "fixed",
                top: topDistance + 'px',
                left:"",
                right:"",
                //right: "auto",
                bottom:""
            });
			
			$element.trigger( 'stickUp:stickIt' );
        },
        syncWidth = function(){
			if($placeholder.width()!==$element.outerWidth()) {
				$element.outerWidth($placeholder.outerWidth());
			}
        },
        syncPosition = function(){
            //retrieve margin
            left = $placeholder.offset().left;
            if(left !== $element.offset().left);
                $element.offset({'left':left});
        },
        syncMargins = function(){
            //retrieve margin
            $placeholder.css({
                'margin-left':$element.css('margin-left'),
                'margin-right':$element.css('margin-left')
            });
            $element.css({
                 "margin-left" :$placeholder.css('margin-left'),
                 "margin-right" :$placeholder.css('margin-right')
            });
        },

        stickUpScrollHandlerFn = function (event) {
            if(!options.disableOn()){
                if(!disabled){
                    void 0;
                    unStick();
                    disabled = true;
                }
                return;
            }else if(disabled){
                disabled = false;
            }
            if(options.keepInWrapper && !$parent.is(':visible')) {
                return;
            }
            scroll = $(event.target).scrollTop();
            scrollDir = (scroll >= lastScrollTop) ? 'down' : 'up';
            scrollDistance = Math.abs(lastScrollTop - scroll);
            viewportHeight = $(window).outerHeight();
            scrollBottom = scroll+viewportHeight;
            lastScrollTop = scroll;
            elementOffset = $element.offset().top;
            stickyHeight = parseInt($element.outerHeight()+topMargin)+parseInt($element.css('marginBottom'));
			if (!active && !hold && !bottom) {
                outerHeight = parseInt($element.outerHeight(true));
                if(!bottom && !hold)
                    stickpoints.top = parseInt($element.offset().top);
                else
                stickpoints.top = parseInt($placeholder.offset().top);
                left = parseInt($element.offset().left)+5;
            }
			currentOuterHeight = parseInt($element.outerHeight())+parseInt($element.css('margin-bottom'))+topMargin;
            if(options.keepInWrapper)
                stickpoints.bottom = $parent.offset().top+$parent.outerHeight()-parseInt($parent.css('paddingBottom'));
            else
                stickpoints.bottom = $(document).outerHeight();
            elementOffsetBottom = $element.offset().top+currentOuterHeight;
            
			landscape = true;
			if(portrait){
				if(hold)
					holdIt();
				portrait = false;
			}
			// Google like reappearance on upward scroll
			if (options.scrollHide)
				offset = stickyHeight + options.lazyHeight; //negative offset for initial hiding
			else
				offset = options.lazyHeight;
			
			if(!active && !bottom && scroll >= stickpoints.top - topMargin + offset 
			|| bottom && hold && scroll <= elementOffset - topMargin + offset){
				void 0;
				stickIt();
				active = true;
				bottom = false;
				hold = false;
			}
			
			if ( active && scroll >= stickpoints.top - topMargin + offset + ( $element.outerHeight() / 2 ) ) {
				$placeholder.addClass( 'sticky-navigation-transition' );
				$element.addClass( 'sticky-navigation-transition' );
			}
			
			//FORCE BOTTOM
			if(options.keepInWrapper
			&& parseInt(elementOffsetBottom - topMargin) !== parseInt(stickpoints.bottom)
			&& scroll >= stickpoints.bottom - currentOuterHeight + offset){
				void 0;
				holdIt(true);
				active = false;
				bottom = true;
				hold = true;
			}
			//Calculate lazyHeight and autoHide
			if (active) {
				var topValue = parseInt($element.css('top'));
				if (scrollDir === 'up' && topValue !== 0) {
					var newTopValue = scrollDistance > -topValue ? 0 : topValue + scrollDistance;
					$element.css('top', newTopValue + 'px');
				} else if (scrollDir === "down" && topValue > -offset) {
					var newTopValue = scrollDistance > offset + topValue ? -offset : topValue - scrollDistance;
					$element.css('top', newTopValue + 'px');
				}
			}
            
            //UNSTICK
            if ((active || hold || bottom) && scroll <= stickpoints.top - topMargin) {
                void 0;
                unStick();
            }
            //RESPONSIVE baby ;-)
			if(active || hold || bottom)
				syncWidth();
            
            //Special cases which need a specified position like margin:0 centered elements
            if(options.syncPosition && active || hold)
				syncPosition();
            //console.log("active ",active,"hold ",hold,"bottom ",bottom);
        },
        stickUpResponsiveHandlerFn = function(event){
            if(hold){
                holdIt();
                bottom = false;
            }
            void 0;
                stickUpScrollHandlerFn(event);

        };

        //init
        var initialize = function(elem,opts){
            $element = $(elem);
			
			$element.after( $placeholder );
			
			if ( $( '.gen-sidebar-nav' ).length ) {
				$placeholder.css( 'height', $element.outerHeight() );
			}

            // adding a class to users div
            $element.addClass(options.namespaceClass);
            //getting options
            if (opts) {
                $.extend(true, options, opts);
            } 
            topMargin = (options.topMargin !== null) ? getTopMargin() : 0;
            if(options.lazyHeight)
                topMargin = topMargin + options.lazyHeight;
            if(options.keepInWrapper){
                if(options.wrapperSelector !== '')
                    $parent = $element.closest(options.wrapperSelector);
                //if no Wrapper available use offsetParent
                if(!$parent.length)
                    $parent = $element.parent();
            }else{
                $parent = $('body');
            }
            if(options.zIndex)
                $element.css('z-index',options.zIndex);
            
            if(syncPosition){
                syncMargins();
            }
            
            $(window).on('scroll.stickUp', stickUpScrollHandlerFn);
            $(window).on('resize.stickUp', stickUpResponsiveHandlerFn);
            //initial round ;-)
            stickUpScrollHandlerFn({target: document});
			
			
        };
        initialize.call(this, elem, opts);
		
		$(elem).on( 'stickUp:detach', function( opts ) {
			void 0;
			$element = $(this);
			$element.removeClass(options.namespaceClass);
			$placeholder.remove();
			$element.removeClass(options.fixedClass)
			.css({ 
				maxWidth:"",
				marginTop: "", 
				marginLeft:"",
				marginRight:"",
				position: "",
				top: "",
				left: "", 
				right: "",
				bottom:"",
				width:""
			});
			active = false;
			bottom = false;
			hold = false;
			disabled = true;
			$(window).off('scroll.stickUp', stickUpScrollHandlerFn);
			$(window).off('resize.stickUp', stickUpResponsiveHandlerFn);
		})
    };

    $.fn.stickUp = function( options ) {
        return this.each(function() {
          new StickUp( this, options );
        });
    };
	
}(jQuery, window, document));

function generateStickyDebounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

(function ( $ ) {
	$.fn.GenerateSimpleSticky = function( options ) {
		var settings = $.extend({
			menu: $( this ),
			parent: false,
			offsetElement: '#wpadminbar',
			disableOn: function() {
				return true;
			}
		}, options );
		
		var body = $( 'body' ), parent = null, offset = null;
		
		if ( settings.parent ) {
			parent = settings.parent;
		} else {
			parent = settings.menu.parent();
		}
		
		if ( settings.menu.parents('.site-header').length > 0 || settings.menu.parents( '.generate-page-header' ).length > 0 ) {
			parent = body;
		}
		
		if ( body.hasClass( 'nav-right-sidebar' ) || body.hasClass( 'nav-left-sidebar' ) ) {
			parent = $( '.site-content' );
		}
		
		offset = ( jQuery( settings.offsetElement ).length > 0 && jQuery( settings.offsetElement ).css( 'position' ) == 'fixed' ) ? jQuery( settings.offsetElement ).outerHeight() : 0;
		
		settings.menu.stickUp({
			scrollHide: false,
			keepInWrapper: true,
			wrapperSelector: parent,
			fixedClass: 'is_stuck navigation-stick',
			topMargin: offset,
			disableOn: settings.disableOn
		});
		
		if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
			jQuery(document)
			.on('focus', '.is_stuck .search-field', function() {
				body.addClass('fixfixed');
				settings.menu.trigger( 'stickUp:detach' );
			})
			.on('blur', '.search-field', function() {
				body.removeClass('fixfixed');
				settings.menu.stickUp({
					scrollHide: false,
					keepInWrapper: true,
					wrapperSelector: parent,
					fixedClass: 'is_stuck navigation-stick',
					topMargin: offset,
					disableOn: settings.disableOn
				});
			});
		}
	}
}( jQuery ));

jQuery( document ).ready( function($) {
	var resizeEvent = 'onorientationchange' in window ? 'orientationchange' : 'resize',
		body = $( 'body' );
			
	if ( body.hasClass( 'sticky-menu-no-transition' ) ) {
		
		var navigation = $( '#site-navigation' );
		
		if ( body.hasClass( 'nav-right-sidebar' ) || body.hasClass( 'nav-left-sidebar' ) ) {
			navigation = jQuery( '.gen-sidebar-nav' );
		}
		
		var navigationDisableOn = function() {
			var body = jQuery( 'body' ),
				mobile = jQuery( '.menu-toggle' ),
				mobileHeader = jQuery( '#mobile-header' );
				
			if ( body.hasClass( 'desktop-sticky-menu' ) && mobile.is( ':visible' ) ) {
				return false;
			}
			
			if ( body.hasClass( 'mobile-sticky-menu' ) && ! mobile.is( ':visible' ) ) {
				return false;
			}
			
			if ( body.hasClass( 'mobile-header' ) && mobileHeader.is( ':visible' ) ) {
				return false;
			}
			
			return true;
		}
		
		$( navigation ).GenerateSimpleSticky({
			disableOn: navigationDisableOn
		});
		
		if ( body.hasClass( 'admin-bar' ) ) {
			var navigationResizeCheck = generateStickyDebounce(function() {
				navigation.trigger( 'stickUp:detach' );
				$( navigation ).GenerateSimpleSticky({
					disableOn: navigationDisableOn
				});
			}, 250);
			
			window.addEventListener( resizeEvent, navigationResizeCheck );
		}
		
		body.on( 'generate_navigation_location_updated', function() {
			navigation.trigger( 'stickUp:detach' );
			setTimeout(function() {
				$( navigation ).GenerateSimpleSticky({
					disableOn: navigationDisableOn
				});
			}, 250);
		});
		
	}
	
	if ( body.hasClass( 'mobile-header' ) && body.hasClass( 'mobile-header-sticky' ) ) {
		
		var mobileHeader = $( '#mobile-header' );
		
		mobileHeader.GenerateSimpleSticky({
			disableOn: function() {
				if ( ! mobileHeader.is( ':visible' ) ) {
					return false;
				}
				return true;
			}
		});
		
		if ( body.hasClass( 'admin-bar' ) ) {
			var mobileHeaderResizeCheck = generateStickyDebounce(function() {
				mobileHeader.trigger( 'stickUp:detach' );
				mobileHeader.GenerateSimpleSticky({
					disableOn: function() {
						if ( ! mobileHeader.is( ':visible' ) ) {
							return false;
						}
						return true;
					}
				});
			}, 250);
			
			window.addEventListener( resizeEvent, mobileHeaderResizeCheck );
		}
		
	}
});