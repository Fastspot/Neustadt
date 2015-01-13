// IE HTML5 DOM Fix | http://jdbartlett.github.com/innershiv | WTFPL License
window.innerShiv=(function(){var d,r;return function(h,u){if(!d){d=document.createElement('div');r=document.createDocumentFragment();/*@cc_on d.style.display = 'none'@*/}var e=d.cloneNode(true);/*@cc_on document.body.appendChild(e);@*/e.innerHTML=h.replace(/^\s\s*/, '').replace(/\s\s*$/, '');/*@cc_on document.body.removeChild(e);@*/if(u===false){return e.childNodes;}var f=r.cloneNode(true),i=e.childNodes.length;while(i--){f.appendChild(e.firstChild);}return f;}}());
// Create Missing Console
if (window.console === undefined) { window.console = { log: function() {}, error: function() {}, warn: function() {} }; }
	
	/* !Web Font Config */
	var WebFontConfig = {
		custom: { 
			families: ['Scala', 'Univers'],
			urls: [ 'www_root/css/fonts.css' ]
		},
		fontactive: function() {
			$.doTimeout("web-font-timer", Site.debounceTime, function() {
				$(".sizer").trigger("resize");
				$(".roller").trigger("resize");
			});
		}
	}; 
	
	var OLDIE = OLDIE || false;
	
	var Site = {
		_init: function() {
			Site.maxWidth = Infinity;
			Site.minWidth = 0;
			
			Site.$window = $(window);
			Site.$body = $("body");
			Site.oldMaxWidth = 0;
			Site.expand = false;
			$.rubberband({
				maxWidth: [ 1220, 980, 740, 500, 320 ],
				minWidth: [ 1220, 980, 740, 500, 320 ]
			});
			$(window).on("snap", Site._onRespond);
			$.mimeo({
				rubberband: true
			});
			$(".page_content").fitVids();
			$(".sizer").sizer();
			$(".roller").roller({
				useMargin: OLDIE,
				callback: function(index) {
					var $roller = $(this);
					if ($roller.hasClass("has_counter")){
						$roller.find(".current").html(index + 1);
					}
				}
			});
			$("a.boxer").boxer();
			$(".line .row span").each(function(i) {
				var text = Site._curlify($(this).html());
				$(this).html(text);
			});
			$(".vis .boxer-visible").boxer();
			$(".phrase span").fitText(1.8);
			$(".nav_slider_handle").on("click touchstart", Site._toggleNav);
			
			$("input[type=radio], input[type=checkbox]").picker();
			$("select").selecter();
			
			$(".comment .reply").on("click", Site._moveCommentForm);
			
			$(".roller").each(function() {
				if ($(this).find(".count").eq(0)) {
					$(this).find(".count").eq(0).html( $(this).find(".roller-canister").eq(0).children(".roller-item").length );
				}
			});
		},
		_onRespond: function(e, data) {
			Site.maxWidth = data.maxWidth;
			Site.minWidth = data.minWidth;
			if (Site.oldMaxWidth){
				if (Site.oldMaxWidth < Site.maxWidth){
					Site.expand = true;
				} else {
					Site.expand = false;
				}
			}
			Site.oldMaxWidth = Site.maxWidth;
			
			MainNav._respond(Site.maxWidth);
			
			$(".roller").trigger("resize");
			$(".sizer").trigger("resize");
		},
		_toggleNav: function(e) {
			e.stopPropagation();
			e.preventDefault();
			
			if (Site.$body.hasClass("nav_slider_open")) {
				Site._closeNav(e);
			} else {
				Site.$body.addClass("nav_slider_open")
				$(".nav_slider_page").one("click touchstart", Site._closeNav);
			}
		},
		_closeNav: function(e) {
			e.stopPropagation();
			e.preventDefault();
			
			if (Site.$body.hasClass("nav_slider_open")) {
				Site.$body.removeClass("nav_slider_open");
				$(".nav_slider_page").off("click touchstart", Site._closeNav);
			}
		},
		_curlify: function(text) {
			return text
				.replace(/'\b/g, "\u2019")  // Opening singles 
										    // (changed this to closing, 
											// cause they're almost always apostrophes)
				.replace(/\b'/g, "\u2019")  // Closing singles
				.replace(/"\b/g, "\u201c")  // Opening doubles
				.replace(/\b"/g, "\u201d")  // Closing doubles
				.replace(/--/g,  "\u2014"); // em-dashes
		},
		_moveCommentForm: function(e) {
			var $target = $(this),
				$comment = $target.parents(".comment").eq(0);
				$form = $("#comment_form"),
				parent = $comment.data("comment"),
				hash = $comment.attr("id");
			
			$form.addClass("reply_form")
				 .find("input[name=parent]").val(parent);
			$target.after($form);
			
			window.location.hash = hash;
		}
	};
	
	/* !Main Nav */
	var MainNav = {
		_init: function() {
			MainNav.$nav = $("nav#main");
			MainNav.$container = MainNav.$nav.find(".container");
			MainNav.$items = MainNav.$nav.find("a.link");
		},
		_respond: function(point) {
			MainNav.dropdownsActive = (point >= 980);
			
			$(".naver").trigger("close.naver");
			if (point <= 980 && point > 740) {
				MainNav.$items.each(function() {
					$(this).html( $(this).data("title-short") );
				});
			} else {
				MainNav.$items.each(function() {
					$(this).html( $(this).data("title-long") );
				});
			}
		}
	};
	
	
	/* !Roller */
/*
	(function($) {	
		var rollerCount = 0,
			options = {
				transitionSpeed: 510
			};
		
		var pub = {
			resize: function(e) {
				var data = $(e.delegateTarget).data("roller");
				$.doTimeout("roller-"+data.guid+"-reset", Site.debounceTime, function() { _resize(data); });
			},
			reset: function(e) {
				var data = $(e.delegateTarget).data("roller");
				data.$allItems = data.$roller.find(".roller_item");
				data.$items = data.$allItems.filter(":visible");
				data.$roller.trigger("resize.roller");
				_position(data, data.index, false);
			}
		};
		function _init() {
			return $(this).each(_build);
		}
		function _build() {
			var $roller = $(this),
				data = {
					$roller: $roller,
					$canister: $roller.children(".roller_canister"),
					$items: $roller.children(".roller_canister").children(".roller_item:visible"),
					$menuArrows: $roller.children(".controls").children(".roller_arrow"),
					$menuPagination: $roller.find(".pagination"),
					$menuItems: $roller.find(".roller_menu_item"),
					$controls: $roller.find(".controls"),
					$images: $roller.find("img"),
					autoAdvance: $roller.hasClass("roller_auto"),
					isAnimating: false,
					index: -1,
					leftPosition: 0,
					guid: rollerCount++,
					autoTime: 5000,
					interactied: false
				};
			
			
			data.totalImages = data.$images.length;
			
			data.$roller.data("roller", data)
						.hammer({
							preventDefault: true,
							swipe: true,
							transform: false,
							drag: false,
							drag_vertical: false,
							drag_horizontal: false,
							tap: false,
							double_tap: false,
							hold: false
						})
						.on("swipe", _swipe)
						.on("click.roller", ".roller_arrow", _advance)
						.on("click.roller", ".roller_menu_item", _select)
						.on("click.roller", ".roller_item:not('.visible')", _jump)
						.on("resize.roller", data, pub.resize)
						.on("reset.roller", data, pub.reset)
					 	.trigger("resize.roller");
			
			if (data.totalImages > 0) {
				data.loadedImages = 0;
				for (var i = 0; i < data.totalImages; i++) {
					var $img = data.$images.eq(i);
					$img.one("load", data, _onImageLoad);
					if ($img.complete) {
						$img.trigger("load");
					}
				}
			}
			
			if (data.autoAdvance) {
				$.doTimeout("roller-"+data.guid+"-auto-advance", data.autoTime, _autoAdvance, data);
			}
		}
		function _onImageLoad(e) {
			var data = e.data;
			data.loadedImages++;
			if (data.loadedImages == data.totalImages) {
				data.$roller.trigger("resize.roller");
			}
			data.$roller.data("roller", data);
		}
		function _autoAdvance(data) {
			if (!data.isAnimating && !data.interactied) {
				var index = data.index + 1;
				if (index >= data.$items.length) {
					index = 0;
				}
				_position(data, index, true);
				$.doTimeout("roller-"+data.guid+"-auto-advance", data.autoTime, _autoAdvance, data);
			}
			return false;
		}
		function _swipe(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var data = $(e.delegateTarget).data("roller");
			if (!data.isAnimating) {
				data.interactied = true;
				var index = data.index + ((e.direction == "left") ? 1 : -1);
				_position(data, index, true);
			}
		}
		function _advance(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var data = $(e.delegateTarget).data("roller");
			if (!data.isAnimating) {
				data.interactied = true;
				var index = data.index + (($(e.currentTarget).hasClass("next")) ? 1 : -1);
				_position(data, index, true);
			}
		}
		function _select(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var data = $(e.delegateTarget).data("roller");
			var index = data.$menuItems.index($(e.currentTarget));
			data.interactied = true;
			_position(data, index, true);
		}
		function _jump(e) {
			e.preventDefault();
			e.stopPropagation();
			
			var data = $(e.delegateTarget).data("roller");
			var $target = $(e.currentTarget);
			var index = Math.floor(data.$items.index($target) / data.perPage);
			data.interactied = true;
			_position(data, index, true);
		}
		function _position(data, index, animate) {
			if (animate) {
				data.isAnimating = true;
				data.$roller.addClass("animated");
			}
			
			if (index < 0) {
				index = 0;
			}
			
			if (index > data.pageCount) {
				index = data.pageCount;
			}
			
			var newLeft = -(index * data.pageMove);
			if (newLeft < data.maxMove) { 
				newLeft = data.maxMove; 
			}
			
			data.leftPosition = newLeft;
			data.$canister.css({ transform: "translate("+data.leftPosition+"px,0)" });
			
			data.$menuItems.filter(".active").removeClass("active");
			data.$menuItems.eq(index).addClass("active");
			
			data.$items.removeClass("visible");
			if (data.perPage != "Infinity") {
				for (var i = 0; i < data.perPage; i++) {
					if (newLeft == data.maxMove) {
						data.$items.eq(data.count - 1 - i).addClass("visible");
					} else {
						data.$items.eq((data.perPage * index) + i).addClass("visible");
					}
				}
			}
			
			data.index = index;
			data.$roller.data("roller", data);
			
			_updateControls(data);
			
			if (animate) {
				$.doTimeout(options.transitionSpeed, function() {
					data.isAnimating = false;
					data.$roller.removeClass("animated");
				});
			}
		}
		function _updateControls(data) {
			if (data.pageCount <= 0) {
				data.$menuArrows.addClass("disabled");
			} else {
				data.$menuArrows.removeClass("disabled");
				if (data.index <= 0) {
					data.$menuArrows.filter(".previous").addClass("disabled");
				} else if (data.index >= data.pageCount) {
					data.$menuArrows.filter(".next").addClass("disabled");
				}
			}
			if (data.$roller.hasClass("has_counter")){
				$(".current").html(data.index+1);
			}
		}
		
		function _resize(data) {
			data.$roller.addClass("initialized");
			
			data.count = data.$items.length;
			data.pageWidth = data.$roller.outerWidth(false);
			data.itemWidth = data.$items.eq(0).outerWidth(true);
			data.itemMargin = parseInt(data.$items.eq(0).css("margin-right"), 10);
			data.perPage = Math.round(data.pageWidth / data.itemWidth);
			data.pageCount = Math.ceil(data.count / data.perPage) - 1;
			
			if (data.$roller.find(".count")){
				$(".count").html(data.pageCount + 1);
			}
			
			data.pageMove = data.itemWidth * data.perPage;
			data.maxWidth = data.itemWidth * data.count;
			data.maxMove = -data.maxWidth + data.pageWidth + data.itemMargin;
			if (data.maxMove > 0) data.maxMove = 0;
			
			// Reset Page Count
			if (data.pageCount != "Infinity") {
				var html = '';
				for (var i = 0; i <= data.pageCount; i++) {
					html += '<span class="roller_menu_item page">' + i + '</span>';
				}
				data.$menuPagination.html(html);
			}
			if (data.pageCount < 1) {
				data.$controls.addClass("hidden");
				data.$menuPagination.addClass("hidden");
			} else {
				data.$controls.removeClass("hidden");
				data.$menuPagination.removeClass("hidden");
			}
			data.$menuItems = data.$roller.find(".roller_menu_item");
			
			var index = -Math.ceil(data.leftPosition / data.pageWidth);
			if(Site.expand){
				index++;
			}
			_position(data, index, false);
		}
		
		$.fn.roller = function(method) {
			if (pub[method]) {
				return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || !method) {
				return _init.apply(this, arguments);
			}
			return this;
		};
		
	})(jQuery);
*/
	
	
	/* !Featurer */
	(function($) {
		var pub = {};
		function _init() {
			return $(this).each(_build);
		}
		function _build() {
			var $feature = $(this),
				data = {
					$feature: $feature,
					$figures: $feature.find("figure"),
					$images: $feature.find("img"),
					$info: $feature.find(".info"),
					$articles: $feature.find("article"),
					$links: $feature.find(".links .set"),
					$controls: $feature.find(".controls"),
					$arrows: $feature.find(".controls span")
				};
			
			data.transitionSpeed = 500;
			data.isAnimating = false;
			data.index = 0;
			data.count = data.$figures.length - 1;
				
			data.$figures.eq(0).addClass("active");
			data.$articles.eq(0).addClass("active");
			
			if (data.count <= 0) {
				data.$controls.addClass("hidden");
			}
			
			$feature.data("featurer", data)
					.on("click.featurer", ".controls span", data, _onClick);
		}
		function _onClick(e) {
			e.preventDefault();
			e.stopPropagation();
			
			data = e.data;
			
			if (!data.isAnimating) {
				var $target = $(e.currentTarget);
				var index = data.index + (($target.hasClass("next")) ? 1 : -1);
				
				if (index < 0) {
					index = 0;
				}
				if (index > data.count) {
					index = data.count;
				}
				
				if (index != data.index) {
					data.isAnimating = true;
					data.$feature.addClass("animated");
					
					data.$articles.removeClass("active before after").each(function(i, item) {
						if (i < index) {
							$(item).addClass("before");
						} else if (i > index) {
							$(item).addClass("after");
						}
					});
					data.$articles.eq(index).addClass("active");
					
					data.$figures.filter(".active").removeClass("active").addClass("was_active");
					data.$figures.eq(index).addClass("active");
					
					data.$links.filter(".active").removeClass("active");
					data.$links.eq(index).addClass("active");
					
					$.doTimeout("featurer-cleanup", data.transitionSpeed, function() {
						data.$feature.removeClass("animated");
						data.$figures.filter(".was_active").removeClass("was_active");
						data.isAnimating = false;
					});
					
					
					data.$arrows.removeClass("disabled");
					if (index == 0) {
						data.$arrows.filter(".previous").addClass("disabled");
					} else if (index >= data.count) {
						data.$arrows.filter(".next").addClass("disabled");
					}
					
					data.index = index;
				}
			}
		}
		$.fn.featurer = function(method) {
			if (pub[method]) {
				return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || !method) {
				return _init.apply(this, arguments);
			}
			return this;
		};
	})(jQuery);
	
	
	$(document).ready(function() {
		// DOM Ready
		Site._init();
		MainNav._init();
	});