// !BigTree Media Gallery Class
/*
var BigTreeMediaGallery = Class.extend({
	container: false,
	counter: false,
	dragging: false,
	key: false,
	videoInput: false,
	activeCaption: false,
	
	init: function(container,key,counter,max) {
		this.key = key;
		this.maxItems = max;
		this.container = $("#" + container);
		this.counter = counter;
		this.container.find(".add_video").click($.proxy(this.addVideo,this));
		this.videoInput = this.container.find("input.video_id");
		this.typeInput = this.container.find("select.type");
		
		this.container.find("ul").sortable({ items: "li" });
		this.container.on("click",".icon_delete",$.proxy(this.deleteVideo,this));
		this.container.on("click",".icon_edit",$.proxy(this.editVideo,this));
	},
	
	addVideo: function() {
		if (!this.videoInput.val()) {
			return false;
		}

		new BigTreeDialog("Video Caption",'<fieldset><label>Caption</label><input type="text" name="caption" /></fieldset>',$.proxy(this.saveVideo,this),"caption");
		return false;
	},
	
	saveVideo: function(data) {
		console.log(this.counter);
		
		var video = this.videoInput.val(),
			type = this.typeInput.val(),
			caption = data.caption;
		
		var li = $('<li>').html('<figure><img src="www_root/images/placeholder/75x75" alt="" /></figure><a href="#" class="icon_delete delete_video"></a>');
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][video]" class="video" />').val(video));
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][type]" class="caption" />').val(type));
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][caption]" class="caption" />').val(caption));
		this.container.find("ul").append(li);
		
		this.videoInput.val("");
		// this.typeInput.val("");
		
		if (this.container.find("ul li").length >= this.maxItems) {
			this.container.find("footer").hide();
		} 
		
		this.counter++;
	},
	
	deleteVideo: function(e) {
		var $link = $(e.currentTarget);
		
		new BigTreeDialog("Delete Video",'<p class="confirm">Are you sure you want to delete this video?</p>',$.proxy(function() {
			$link.parents("li").remove();
			
			if (this.container.find("ul li").length < this.maxItems) {
				this.container.find("footer").show();
			} 
			
		},this),"delete",false,"OK");
		
		return false;
	},
	
	editVideo: function(ev) {
		link = $(ev.target);
		this.activeCaption = link.siblings(".caption");
		new BigTreeDialog("Image Caption",'<fieldset><label>Caption</label><input type="text" name="caption" value="' + htmlspecialchars(this.activeCaption.val()) + '"/></fieldset>',$.proxy(this.saveCaption,this),"caption");
		return false;
	},
	
	saveCaption: function(data) {
		this.activeCaption.val(data.caption);
		this.activeCaption = false;
	}
});
*/

var BigTreeMediaGallery = Class.extend({
	container: false,
	counter: false,
	dragging: false,
	key: false,
	fileInput: false,
	videoSelect: false,
	activeCaption: false,
	
	init: function(container,key,counter,max) {
		this.key = key;
		this.maxItems = max;
		this.container = $("#" + container);
		this.counter = counter;
		this.container.find(".add_photo").click($.proxy(this.addPhoto,this));
		this.container.find(".add_video").click($.proxy(this.addVideo,this));
		this.fileInput = this.container.find("footer.image_field input");
		this.videoInput = this.container.find("input.video_id");
		this.typeInput = this.container.find("select.type");
		
		this.container.find("ul").sortable({ items: "li" });
		this.container.on("click",".icon_delete",$.proxy(this.deleteMedia,this));
		this.container.on("click",".icon_edit",$.proxy(this.editPhoto,this));
	},
	
	addPhoto: function() {
		if (!this.fileInput.val()) {
			return false;
		}
		new BigTreeDialog("Image Caption",'<fieldset><label>Caption</label><input type="text" name="caption" /></fieldset>',$.proxy(this.saveNewFile,this),"caption");
		return false;
	},

	addVideo: function() {
		if (!this.videoInput.val()) {
			return false;
		}

		new BigTreeDialog("Video Caption",'<fieldset><label>Caption</label><input type="text" name="caption" /></fieldset>',$.proxy(this.saveVideo,this),"caption");
		return false;
	},
	
	saveVideo: function(data) {
		console.log(this.counter);
		
		var video = this.videoInput.val(),
			type = this.typeInput.val(),
			caption = data.caption;
		
		var li = $('<li>').html('<figure><img src="www_root/images/placeholder/75x75" alt="" /></figure><a href="#" class="icon_delete delete_video"></a>');
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][video]" class="video" />').val(video));
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][type]" class="caption" />').val(type));
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][caption]" class="caption" />').val(caption));
		this.container.find("ul").append(li);
		
		this.videoInput.val("");
		// this.typeInput.val("");
		
		if (this.container.find("ul li").length >= this.maxItems) {
			this.container.find("footer").hide();
		} 
		
		this.counter++;
	},
	
	deleteMedia: function(e) {
		var $link = $(e.currentTarget);
		
		new BigTreeDialog("Delete Media",'<p class="confirm">Are you sure you want to delete this media?</p>',$.proxy(function() {
			var $input = $link.parents("li").find("input");
			if ($link.hasClass("delete_video")) {
				if ($link.hasClass("delete_local")) {
					this.localSelect[0].customControl.add($input.val(), $input.attr("title"));
				} else {
					this.videoSelect[0].customControl.add($input.val(), $input.attr("title"));
				}
			}
			$link.parents("li").remove();
			
			if (this.container.find("ul li").length < this.maxItems) {
				this.container.find(".button").show();
			} 
			
		},this),"delete",false,"OK");
		
		return false;
	},
	
	editPhoto: function(ev) {
		link = $(ev.target);
		this.activeCaption = link.siblings(".caption");
		new BigTreeDialog("Image Caption",'<fieldset><label>Caption</label><input type="text" name="caption" value="' + htmlspecialchars(this.activeCaption.val()) + '"/></fieldset>',$.proxy(this.saveCaption,this),"caption");
		return false;
	},
	
	saveCaption: function(data) {
		this.activeCaption.val(data.caption);
		this.activeCaption = false;
	},
	
	saveNewFile: function(data) {
		li = $('<li>').html('<figure><img src="www_root/images/placeholder/image/75x75" alt="" /></figure><a href="#" class="icon_edit"></a><a href="#" class="icon_delete delete_photo"></a>');
		li.append(this.fileInput.attr("name",this.key + '[' + this.counter + '][image]').hide());
		li.append($('<input type="hidden" name="' + this.key + '[' + this.counter + '][caption]" class="caption" />').val(data.caption));
		this.container.find("ul").append(li);
		
		this.container.find(".placeholder").remove();
		
		this.counter++;
		c = this.counter;
		
		new_file = $('<input type="file" class="custom_control" name="' + this.key + '[' + this.counter + '][image]">').hide();
		this.container.find(".file_wrapper").append(new_file);
		customControl = this.fileInput.get(0).customControl;
		new_file.get(0).customControl = customControl.connect(new_file.get(0));
		this.fileInput.get(0).customControl = false;
		this.fileInput = new_file;
		
		if (this.container.find("ul li").length >= this.maxItems) {
			this.container.find(".button").hide();
		} 
	}
});
