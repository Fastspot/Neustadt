var elementOffset,elementScrollTimer,elementHeight,fbOffset;
var form_builder_target,form_builder_direction;

var FormBuilder = {

	objectCount: 0,
	activeItem: false,
	lastDropTimestamp: false,
	
	init: function(no_auto_scroll) {
		if ($("#form_builder_fields").length) {
			o = $(".form_builder_elements").offset();
			elementHeight = $(".form_builder_elements").height();
			elementOffset = o.top;
			o = $("#form_builder_fields").offset();
			fbOffset = o.top;
			
			$(".form_builder_elements a").click(function() {
				return false;
			}).draggable({ helper: "clone" });
		
			$("#form_builder_fields").on("click",".icon_small_delete",FormBuilder.deleteElement)
				.on("click",".icon_small_edit",FormBuilder.editElement)
				.droppable({
				drop: function(event,ui) {
					type = ui.draggable.attr("name");
					if (type) {
						FormBuilder.add(this,event,ui);
					}
				}
			});
			FormBuilder.observe();
			
			if (!no_auto_scroll) {
				$(window).scroll(function(ev) {
					y = window.scrollY;
					e = $(".form_builder_elements");
					if (y > elementOffset || (y < elementOffset && e.css("margin-top") != "0px")) {
						clearTimeout(elementScrollTimer);
						elementScrollTimer = setTimeout('\
							formHeight = $("#form_builder_fields").height();\
							newoffset = (window.scrollY - elementOffset) + 10;\
							if ((newoffset + elementHeight) > formHeight) {\
								newoffset = formHeight - elementHeight;\
							}\
							if (newoffset < 0) {\
								newoffset = 0;\
							}\
							$(".form_builder_elements").css({ "margin-top": newoffset + "px" });\
						',100);
					}
				});
			}
			
			$("#form_builder_is_paid").click(function() {
				$("#form_builder_base_price").toggle();
				$("#form_builder_early_bird").toggle();
				$("#form_builder_limit_checkbox").toggle();
				$("#form_builder_paid_extras").toggle();
			});
			$("#form_builder_early_bird").click(function() {
				$("#form_builder_early_base_price").toggle();
				$("#form_builder_early_bird_date").toggle();
			});
			$("#form_builder_limit_entries").click(function() {
				$("#form_builder_max_entries").toggle();
			});
		}
	},
	
	observe: function() {
		// Watch for a new form template.
		$("#form_builder_existing_form").change(function() {
			document.location.href = $(this).val();
		});
		
		$("#form_builder_fields").droppable("destroy");
		$(".form_builder_column").each(function(el) {
			try {
				$(el).droppable("destroy");
			} catch (error) {}
		});

		$(".form_builder_column").droppable({
			drop: function(event,ui) {
				type = ui.draggable.attr("name");
				if (type) {
					FormBuilder.add(this,event,ui);
				}
			}
		}).find("> div").sortable();
		
		$("#form_builder_fields").droppable({
			drop: function(event,ui) {
				type = ui.draggable.attr("name");
				if (type) {
					FormBuilder.add(this,event,ui);
				}
			}
		}).sortable();
		
		// Watch all the fields for clicks on radios and checkboxes to set defaults.
		$(".form_builder_element input[type=radio]").click(function(ev) {
			data_field = $(this).parents(".form_builder_element").eq(0).find("input").eq(2);
			i = $(this).parents(".form_builder_element").eq(0).find("input[type=radio]").index(this);
			$.ajax("www_root/admin/ajax/btx-form-builder/update-list/", { type: "POST", data: { data: data_field.val(), selected: i }, success: function(d) {
				data_field.val(d);
			}});
		});
		$(".form_builder_element input[type=checkbox]").click(function(ev) {
			data_field = $(this).parents(".form_builder_element").eq(0).find("input").eq(2);
			i = $(this).parents(".form_builder_element").eq(0).find("input[type=checkbox]").index(this);
			$.ajax("www_root/admin/ajax/btx-form-builder/update-checkbox/", { type: "POST", data: { data: data_field.val(), selected: i, checked: $(this).attr("checked") }, success: function(d) {
				data_field.val(d);
			}});
		});
		// Watch selects for changes to set the default
		$(".form_builder_element select").change(function(ev) {
			data_field = $(this).parents(".form_builder_element").eq(0).find("input").eq(2);
			i = $(this).prop("selectedIndex");
			$.ajax("www_root/admin/ajax/btx-form-builder/update-list/", { type: "POST", data: { data: data_field.val(), selected: i }, success: function(d) {
				data_field.val(d);
			}});
		});
	},
	
	add: function(container,event,ui) {
		if (event.timeStamp == FormBuilder.lastDropTimestamp) {
			return false;
		}
		FormBuilder.lastDropTimestamp = event.timeStamp;

		var type = ui.draggable.attr("name");
		
		FormBuilder.objectCount++;
		
		if (!$(container).hasClass("ui-droppable")) {
			container = $(container).parentsUntil(".ui-droppable");
		} else {
			container = $(container);
		}
		
		form_builder_target = false;
		form_builder_direction = false;
		
		if (container.hasClass("form_builder_column")) {
			// Can't put columns inside columns.
			if (type == "columns") {
				return;
			}
			y = ui.offset.top;
			form_builder_target = false;
			container.find(".form_builder_element").each(function() {
				offset = $(this).offset();
				height = $(this).height();
				
				// Figure out where the element begins and ends, then find where the mid point is.
				begin = offset.top - 5;
				end = begin + height + 32;
				middle = begin + (height / 2);
				
				// If the drag ended farther down than the middle, we're going to place it after the element, otherwise before.
				if (y > begin && y <= middle) {
					form_builder_target = this;
					form_builder_direction = "before";
				} else if (y > middle && y <= end) {
					form_builder_target = this;
					form_builder_direction = "after";
				}
			});
			
			if (!form_builder_target) {
				form_builder_target = container.find("> div");
				form_builder_direction = "bottom";
			}
		} else {
			y = ui.offset.top;
			form_builder_target = false;
			$(".form_builder_element").each(function() {
				offset = $(this).offset();
				height = $(this).height();
				
				// Figure out where the element begins and ends, then find where the mid point is.
				begin = offset.top - 5;
				end = begin + height + 32;
				middle = begin + (height / 2);
				
				// If the drag ended farther down than the middle, we're going to place it after the element, otherwise before.
				if (y > begin && y <= middle) {
					form_builder_target = this;
					form_builder_direction = "before";
				} else if (y > middle && y <= end) {
					form_builder_target = this;
					form_builder_direction = "after";
				}
			});
			if (!form_builder_target) {
				form_builder_target = container;
				form_builder_direction = "bottom";
			}
		}
		
		el = $('<div class="form_builder_element form_builder_' + type + '" id="form_builder_element_' + FormBuilder.objectCount + '">');
		eldata = '<input type="hidden" name="id[' + FormBuilder.objectCount + ']" value="" /><input type="hidden" name="type[' + FormBuilder.objectCount + ']" value="' + type + '" /><input type="hidden" name="data[' + FormBuilder.objectCount + ']" value="" id="form_builder_obj_data" /><div class="form_builder_wrapper">';
		
		if (type == "columns") {
			wrapper = $('<div class="form_builder_element form_builder_column_wrapper">');
			subwrapper = $('<div class="form_builder_wrapper">');
			
			// Create the first column
			el = $('<div class="form_builder_column" id="form_builder_element_' + FormBuilder.objectCount + '">');
			el.html('<input type="hidden" name="type[' + FormBuilder.objectCount + ']" value="column_start" /><div></div><input type="hidden" name="type[' + (FormBuilder.objectCount + 1) + ']" value="column_end" />');
			subwrapper.append(el);
			FormBuilder.objectCount += 2;
			
			// Create the second column
			el = $('<div class="form_builder_column" id="form_builder_element_' + FormBuilder.objectCount + '">');
			el.html('<input type="hidden" name="type[' + FormBuilder.objectCount + ']" value="column_start" /><div></div><input type="hidden" name="type[' + (FormBuilder.objectCount + 1) + ']" value="column_end" />');
			subwrapper.append(el);
			FormBuilder.objectCount++;

			wrapper.append(subwrapper);
			wrapper.append('<div class="form_builder_controls form_builder_controls_single"><a href="#" class="icon_small icon_small_delete"></a></div>');
			
			if (form_builder_direction == "before") {
				$(form_builder_target).before(wrapper);
			}
			if (form_builder_direction == "after") {
				$(form_builder_target).after(wrapper);
			}
			if (form_builder_direction == "bottom") {
				$(form_builder_target).append(wrapper);
			}
		}
		
		if (type == "section") {
			eldata += '<span class="icon"></span><div class="form_builder_object form_builder_section_title">Section Title</div><div class="form_builder_object form_builder_section_description">Section Description</div>';
			objdata = '{"title":"Section Title","description":"Section Description"}';
		}
		
		if (type == "text") {
			eldata += '<span class="icon"></span><label>Label</label><input type="text" class="form_builder_text" />';
			objdata = '{"label":"Label"}';
		}
		
		if (type == "textarea") {
			eldata += '<span class="icon"></span><label>Label</label><textarea class="form_builder_textarea"></textarea>';
			objdata = '{"label":"Label"}';
		}
		
		if (type == "checkbox") {
			eldata += '<span class="icon"></span><label>Label</label><div class="form_builder_option"><input type="checkbox" class="form_builder_checkbox" /> Option 1</div><div class="form_builder_option"><input type="checkbox" class="form_builder_checkbox" /> Option 2</div><div class="form_builder_option"><input type="checkbox" class="form_builder_checkbox" /> Option 3</div>';
			objdata = '{"label":"Label","list":{"1":{"value":"val1","description":"Option 1"},"2":{"value":"val2","description":"Option 2"},"3":{"value":"val3","description":"Option 3"}}}';
		}
		
		if (type == "radio") {
			eldata += '<span class="icon"></span><label>Label</label><div class="form_builder_option"><input type="radio" class="form_builder_radiobutton" /> Option 1</div><div class="form_builder_option"><input type="radio" class="form_builder_radiobutton" /> Option 2</div><div class="form_builder_option"><input type="radio" class="form_builder_radiobutton" /> Option 3</div>';
			objdata = '{"label":"Label","list":{"1":{"value":"val1","description":"Option 1"},"2":{"value":"val2","description":"Option 2"},"3":{"value":"val3","description":"Option 3"}}}';
		}
		
		if (type == "select") {
			eldata += '<span class="icon"></span><label>Label</label><select><option>Option 1</option><option>Option 2</option><option>Option 3</option></select>';
			objdata = '{"label":"Label","list":{"1":{"value":"val1","description":"Option 1"},"2":{"value":"val2","description":"Option 2"},"3":{"value":"val3","description":"Option 3"}}}';
		}
		
		if (type == "upload") {
			eldata += '<span class="icon"></span><label>Label</label><input type="file" class="form_builder_upload" />';
			objdata = '{"label":"Label"}';	
		}
		
		if (type == "name") {
			eldata += '<span class="icon"></span><label>Name</label><div class="form_builder_object form_builder_first_name"><input type="text" class="form_builder_text" /><label>First</label></div><div class="form_builder_object form_builder_last_name"><input type="text" class="form_builder_text" /><label>Last</label></div>';
			objdata = '{"label":"Name"}';
		}
		
		if (type == "date") {
			eldata += '<span class="icon"></span><label>Date</label><div class="form_builder_object form_builder_month"><input type="text" class="form_builder_text" /><label class="center">MM</label></div><div class="form_builder_separator">/</div><div class="form_builder_object form_builder_day"><input type="text" class="form_builder_text" /><label class="center">DD</label></div><div class="form_builder_separator">/</div><div class="form_builder_object form_builder_year"><input type="text" class="form_builder_text" /><label class="center">YYYY</label></div>';
			objdata = '{"label":"Date"}';
		}
		
		if (type == "address") {
			eldata += '<span class="icon"></span><label>Address</label><div class="form_builder_object form_builder_full"><input type="text" class="form_builder_text" /><label>Street Address</label></div><div class="form_builder_object form_builder_full"><input type="text" class="form_builder_text" /><label>Street Address Line 2</label></div><div class="form_builder_object form_builder_split"><input type="text" class="form_builder_text" /><label>City</label></div><div class="form_builder_object form_builder_split form_builder_last"><input type="text" class="form_builder_text" /><label>State / Province / Region</label></div><div class="form_builder_object form_builder_split"><input type="text" class="form_builder_text" /><label>Postal / Zip Code</label></div><div class="form_builder_object form_builder_split form_builder_last"><input type="text" class="form_builder_text" /><label>Country</label></div>';
			objdata = '{"label":"Address"}';
		}
		
		if (type == "email") {
			eldata += '<span class="icon"></span><label>Email Address</label><input type="text" class="form_builder_text" />';
			objdata = '{"label":"Email Address"}';
		}
		
		if (type == "url") {
			eldata += '<span class="icon"></span><label>Website</label><input type="text" class="form_builder_text" />';
			objdata = '{"label":"Website"}';
		}
		
		if (type == "phone") {
			eldata += '<span class="icon"></span><label>Phone Number</label><div class="form_builder_object form_builder_phone"><input type="text" class="form_builder_text" /><label class="center">###</label></div><div class="form_builder_separator">-</div><div class="form_builder_object form_builder_phone"><input type="text" class="form_builder_text" /><label class="center">###</label></div><div class="form_builder_separator">-</div><div class="form_builder_object form_builder_phone_wide"><input type="text" class="form_builder_text" /><label class="center">####</label></div>';
			objdata = '{"label":"Phone Number"}';
		}
		
		if (type == "captcha") {
			eldata += '<span class="icon"></span><label>Security Code</label><p>Please enter the security code below.</p><img src="www_root/admin/images/btx-form-builder/recaptcha.png" alt="" />';
			objdata = '{"label":"Security Code","instructions":"Please enter the security code below."}';
		}
		
		if (type != "columns") {
			eldata += '</div>';
			eldata += '<div class="form_builder_controls"><a href="#" class="icon_small icon_small_edit"></a><a href="#" class="icon_small icon_small_delete"></a></div>';
			el.html(eldata);
			
			if (form_builder_direction == "before") {
				$(form_builder_target).before(el);
			}
			if (form_builder_direction == "after") {
				$(form_builder_target).after(el);
			}
			if (form_builder_direction == "bottom") {
				$(form_builder_target).append(el);
			}
			
			$("#form_builder_obj_data").val(objdata);
			$("#form_builder_obj_data").attr("id","");
		}
		
		FormBuilder.observe();
		
	},
	
	editElement: function(ev) {
		paid = $("#form_builder_is_paid").attr("checked");
		element = $(this).parents(".form_builder_element").eq(0);
		
		// Save information
		FormBuilder.activeItem = { type: element.attr("class").replace("form_builder_element","").replace("form_builder_",""), name: element.attr("id"), id: element.find("input").eq(0).val() };
		
		$.ajax("www_root/admin/ajax/btx-form-builder/edit-element/", { type: "POST", data: { paid: paid, name: FormBuilder.activeItem.name, type: FormBuilder.activeItem.type, data: element.find("input").eq(2).val() }, success: function(response) {
			new BigTreeDialog("Edit Element",response,function(data) {
				data.name = FormBuilder.activeItem.name;
				data.type = FormBuilder.activeItem.type;
				data.id = FormBuilder.activeItem.id;
				$(element).load("www_root/admin/ajax/btx-form-builder/populate-element/", data, FormBuilder.observe);
			});
		}});
		
		return false;
	},
	
	deleteElement: function(ev) {
		$(this).parents(".form_builder_element").eq(0).remove();
		
		return false;
	}
	
};