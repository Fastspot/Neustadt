/*
 * Mimeo Plugin
 * @author Ben Plum
 * @version 0.0.2
 *
 * Copyright � 2012 Ben Plum <mr@benplum.com>
 * Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

/*
	<picture width="500" height="500">
	   <source media="(max-width: 45em)" src="large.jpg">
	   <source media="(max-width: 18em)" src="med.jpg">
	   <source src="small.jpg">
	   <img src="small.jpg" alt="">
	   <p>Accessible text</p>
	</picture>
*/
 
if (jQuery) (function($) {
	var $window = $(window),
		$pictures;
		/* nativeSupport = (document.createElement('picture') && window.HTMLPictureElement) */;
	
	// Default Options
	var options = {
		rubberband: false
	};
	
	// Public Methods
	var pub = {
		respond: function(bp) {
			// RESPOND
			if (bp.maxWidth) {
				_respond(bp);
			}
		},
		update: function() {
			// CACHE PICTURES
			$pictures = $("picture");
			
			$pictures.each(function(i, picture) {
				var $sources = $(picture).find("source");
				
				for (var i = 0, count = $sources.length; i < count; i++) {
					var $source = $sources.eq(i),
						media = $source.attr("media");
					
					if (media) {
						media = media.replace(Infinity, "100000px");
						$source.data("mimeo-match", window.matchMedia(media));
					}
				}
			});
		}
	};
	
	// Private Methods
	
	// Init 
	function _init(opts) {
		$.extend(options, opts || {});
		
		/*
		if (nativeSupport) {
			return;
		}
		*/
		
		pub.update();
		
		if (options.rubberband) {
			// Bind breakpoint events
			$window.on("snap", _respond);
		}
	}
	
	// Respond
	function _respond(e, bp) {
		$pictures.each(function() {
			var $target = $(this),
				$image = $target.find("img"),
				$sources = $target.find("source"),
				index = false;
			
			for (var i = 0, count = $sources.length; i < count; i++) {
				var match = $sources.eq(i).data("mimeo-match");
				
				if (match) {
					//if (media && parseInt(media.replace("(max-width:", "").replace(")", "").trim(), 10) >= bp.maxWidth) {
					if (match.matches) {
						index = i;
					}
				}
			}
			
			if (index === false) {
				index = $sources.length - 1;
			}
			
			$image.attr("src", $sources.eq(index).attr("src"));
		});
	}
	
	// Define Plugin
	$.mimeo = function(method) {
		//if ($.rubberband != undefined) {
			if (pub[method]) {
				return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || !method) {
				return _init.apply(this, arguments);
			}
		/*
		} else {
			if (console) {
				console.warn("Mimeo requires the Rubberband plugin to function");
			}
		}
		*/
		return this;
	};
})(jQuery);