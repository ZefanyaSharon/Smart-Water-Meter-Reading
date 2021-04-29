var jqgird_search_string_operators = ['cn','nc','bw','bn','eq','ne','lt','le','gt','ge','in','ni','ew','en'];
var jqgird_search_date_operators = ['bw','eq','ne','lt','le','gt','ge','in','ni'];
var jqgrid_fixed_height = new Array;

function jqgrid_window_fixed_width(id)
{
	return jQuery('#gbox_' + id + '>parent').width();
}

function jqgrid_window_fixed_height(jqgrid, add_width)
{
	if (add_width == null) add_width = -240;
	var mixed = jqgrid_window_fixed_get_height(add_width);
	jqgrid_fixed_height.push([jqgrid, add_width]);

	return mixed;
}

function jqgrid_window_fixed_get_height(add_width)
{
	var mixed = jQuery(window).height() + add_width;

	if (mixed < 250)
		mixed = 250;

	return mixed;
}

function jqgrid_boolean_formatter(cellvalue, options, rowObject)
{
	return boolean_selectors[cellvalue];
}

function jqgrid_is_active_formatter(cellvalue, options, rowObject)
{
	return is_active_selectors[cellvalue];
}

function jqgrid_is_publish_formatter(cellvalue, options, rowObject)
{
	return is_publish_selectors[cellvalue];
}

function jqgrid_language_formatter(cellvalue, options, rowObject)
{
	return language_selectors[cellvalue];
}

function jqgrid_period_formatter(cellvalue, options, rowObject)
{
	return period_selectors[cellvalue];
}

function jqgrid_form_before_submit(postdata, formid)
{
	jquery_blockui();

	var _message = "Sending data...";
	return[true, _message];
}

function jqgrid_form_after_submit(response, postdata)
{
	jquery_unblockui();

	var _is_success = true;
	var _message;
	var _data = jQuery.parseJSON(response.responseText);

	if (_data.response == false)
	{
		_is_success = false;
		_message = _data.value;
	}
	else
		_message = "Data sent";

	return [_is_success, _message, postdata.id];
}

function jqgrid_form_error_text(response)
{
	jquery_unblockui();
	return jquery_ajax_error_status_handler(response);
}

function jqgrid_column_date(table_id, options)
{
	options = options || {};

	var defaults = {
		width : 110,
		formatter : 'date',
		align : 'center'
	};
	options = $.extend(defaults, options);

	options.formatoptions = options.formatoptions || {};
	options.formatoptions = $.extend({
		srcformat:server_date_format,
		newformat:client_jqgrid_date_format
	}, options.formatoptions);

	options.searchoptions = options.searchoptions || {};
	options.searchoptions = $.extend({
		sopt:jqgird_search_date_operators,
		clearSearch:false,
		dataInit:function(element){
			jQuery(element)
				.datepicker({
					format: client_picker_date_format,
					autoclose: true
				})
				.change(function(){
					jQuery('#' + table_id)[0].triggerToolbar();
			});
		}
	}, options.searchoptions);

	return options;
}

function jqgrid_column_datetime(table_id, options)
{
	options = options || {};

	var defaults = {
		width : 132,
		formatter : 'date',
		align : 'center'
	};
	options = $.extend(defaults, options);

	options.formatoptions = options.formatoptions || {};
	options.formatoptions = $.extend({
		srcformat:server_datetime_format,
		newformat:client_jqgrid_datetime_format
	}, options.formatoptions);

	options.searchoptions = options.searchoptions || {};
	options.searchoptions = $.extend({
		sopt:jqgird_search_date_operators,
		clearSearch:false,
		dataInit:function(element){
			jQuery(element)
				.attr("data-date-format", client_picker_datetime_format)
				.datetimepicker({
					icons: {
						time: "fa fa-clock-o",
						date: "fa fa-calendar",
						up: "fa fa-arrow-up",
						down: "fa fa-arrow-down"
					},
					useSeconds: true,
					format: true
				})
				.change(function(){
					jQuery('#' + table_id)[0].triggerToolbar();
				});
		}
	}, options.searchoptions);

	return options;
}

function jqgrid_get_search_string_operators(def)
{
	var search_string_operators = new Array();
	if (def)
		search_string_operators.push(def);
	jQuery.each(jqgird_search_string_operators, function(index, value){
		if (value != def)
			search_string_operators.push(value);
	});

	return search_string_operators;
}

jQuery(window).resize(function()
{
	for (var _jqgrid_counter = 0; _jqgrid_counter < jqgrid_fixed_height.length; _jqgrid_counter++)
	{
		var height = jqgrid_window_fixed_get_height(jqgrid_fixed_height[_jqgrid_counter][1]);
		jqgrid_fixed_height[_jqgrid_counter][0].setGridHeight(height);
	}

	$(".sweet-alert").css("margin-top",-$(".sweet-alert").outerHeight()/2);
});

jQuery(document).ready(function()
{
	jquery_ready_load();
});

function jquery_ready_load()
{
	var bootstrapButton = $.fn.button.noConflict(); // return $.fn.button to previously assigned value
	$.fn.bootstrapBtn = bootstrapButton;
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
	jQuery("#dialog_alert_container").dialog({
		modal: true,
		autoOpen: false,
		close: function(event, ui)
		{
			jQuery("#dialog_alert_icon").removeClass();
		},
		buttons: {
			OK: function() {
				jQuery(this).dialog("close");
			}
		}
	});

	jQuery("#dialog_confirm_container").dialog({
		modal: true,
		autoOpen: false,
		close: function(event, ui)
		{
			jQuery("#dialog_confirm_icon").removeClass();
		},
		buttons: {
			OK: function() {
				jQuery(this).dialog("close");
			},
			Cancel: function() {
				jQuery(this).dialog("close");
			}
		}
	});

	// MetsiMenu -- From Inspinia template
	$('#side-menu').metisMenu();

	// Collapse ibox function
	$('.collapse-link').click( function() {
		var ibox = $(this).closest('div.ibox');
		var button = $(this).find('i');
		var content = ibox.find('div.ibox-content');
		content.slideToggle(200);
		button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
		ibox.toggleClass('').toggleClass('border-bottom');
		setTimeout(function () {
			ibox.resize();
			ibox.find('[id^=map-]').resize();
		}, 50);
	});

	// Close ibox function
	$('.close-link').click( function() {
		var content = $(this).closest('div.ibox');
		content.remove();
	});

	// Small todo handler
	$('.check-link').click( function(){
		var button = $(this).find('i');
		var label = $(this).next('span');
		button.toggleClass('fa-check-square').toggleClass('fa-square-o');
		label.toggleClass('todo-completed');
		return false;
	});

	// minimalize menu
	$('.navbar-minimalize').click(function () {
		$("body").toggleClass("mini-navbar");
		SmoothlyMenu();
	})

	// tooltips
	$('.tooltips').tooltip({
		selector: "[data-toggle=tooltip]",
		container: "body"
	})

	// Move modal to body
	// Fix Bootstrap backdrop issu with animation.css
	$('.modal').appendTo("body")

	// Full height of sidebar
	function fix_height() {
		var heightWithoutNavbar = $("body > #wrapper").height() - 61;
		$(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");
		var windowWidth = $( window ).height();
		$("#page-wrapper").css("min-height", windowWidth + 'px');
	}
	fix_height();

	// Fixed Sidebar
	// unComment this only whe you have a fixed-sidebar
			//    $(window).bind("load", function() {
			//        if($("body").hasClass('fixed-sidebar')) {
			//            $('.sidebar-collapse').slimScroll({
			//                height: 'auto',
			//                railOpacity: 0.9,
			//            });
			//        }
			//    })

	$(window).bind("load resize click scroll", function() {
		if(!$("body").hasClass('body-small')) {
			fix_height();
		}
	})

	$("[data-toggle=popover]")
		.popover();

	reload_script();
}

function reload_script() {
	// $('.input-group.date').datepicker({
		// format: client_picker_date_format,
		// todayBtn: "linked",
		// keyboardNavigation: false,
		// forceParse: false,
		// calendarWeeks: true,
		// autoclose: true
	// });
	jQuery(".input-group.datetime").datetimepicker({
		format: client_picker_datetime_format,
	});
	jQuery(".datetime-nosecond").datetimepicker({
		timeFormat: client_picker_time_nosecond_format
	});

	$(".number").bind("keyup", function() {
		var svalue=0;
		svalue = $(this).val().replace(/,/gi, '');
		$(this).val(add_commas(svalue));
	});

	$(".year").bind("keyup", function() {
		var svalue = 0;
		svalue = $(this).val().replace(/[^0-9]/g, '');
		$(this).val(svalue);
	});
}

function jquery_search_date(element)
{
	jQuery(element).datepicker();
}

function jquery_search_datetime(element)
{
	jQuery(element).datetimepicker({
		showSecond: true,
		timeFormat: client_picker_time_format
	});
}

function jquery_search_datetime_nosecond(element)
{
	jQuery(element).datetimepicker({
		timeFormat: client_picker_time_nosecond_format
	});
}

function jquery_show_message(message, title, icon_class)
{
	if (title == null) title = "Information";
	jQuery("#dialog_alert_container").dialog("option", "title", title);

	if (icon_class == null)
		icon_class = "ui-icon-info";

	jQuery("#dialog_alert_icon").addClass("ui-icon");
	jQuery("#dialog_alert_icon").addClass(icon_class);

	jQuery("#dialog_alert_message").html(message);

	jQuery("#dialog_alert_container").dialog("open");
}

function jquery_show_confirm(message, ok_func, cancel_func, title, icon_class)
{
	if (title == null) title = "Confirmation";
	jQuery("#dialog_confirm_container").dialog("option", "title", title);

	if (icon_class == null)
		icon_class = "ui-icon-help";

	jQuery("#dialog_confirm_icon").addClass("ui-icon");
	jQuery("#dialog_confirm_icon").addClass(icon_class);

	jQuery("#dialog_confirm_message").html(message);

	jQuery("#dialog_confirm_container").dialog("option",
		"buttons",
		[	{text: "OK",
			 click: function()
			 {
				jQuery(this).dialog("close");
				if (ok_func != null)
					ok_func();
			 }
			},
			{text: "Cancel",
			 click: function()
			 {
				jQuery(this).dialog("close");
				if (cancel_func != null)
					cancel_func();
			 }
			}
		]
	);

	jQuery("#dialog_confirm_container").dialog("open");
}

function jquery_form_set(form_id, data)
{
	for (var _field_name in data)
	{
		var _value = data[_field_name];
		var _selected_el = '#' + form_id + ' [name="' + _field_name + '"]';

		jquery_field_set(_selected_el, _value);
	}
}

function jquery_field_set(selector_str, value)
{
	var _input_type = jQuery(selector_str).attr('type');
	switch (_input_type)
	{
		case "checkbox":
			if (value === true || value == "1" || value == "yes" || value == "y" || value == "true" || value == "t" || value == 1)
				jQuery(selector_str).prop('checked', true);
			else
				jQuery(selector_str).prop('checked', false);
		break;
		case "radio":
			if (jQuery(selector_str + '[value="' + value + '"]').length > 0)
				jQuery(selector_str + '[value="' + value + '"]').prop('checked', true);
			else
				jQuery(selector_str + '[value="' + value + '"]').prop('checked', false);
		break;
		default:
			if (jQuery(selector_str).hasClass('date'))
			{
				if (isDate(value, server_client_parse_validate_date_format))
				{
					var _date = new Date(getDateFromFormat(value, server_client_parse_validate_date_format));
					if (jQuery(selector_str).is(':data(datepicker)'))
						jQuery(selector_str).datepicker('setDate', _date);
					else
						jQuery(selector_str).val(formatDate(_date, client_validate_date_format));
				}
				else
				{
					if (jQuery(selector_str).is(':data(datepicker)') && value == null)
						jQuery(selector_str).datepicker('setDate', null);
					else
						jQuery(selector_str).val(value);
				}
			}
			else if (jQuery(selector_str).hasClass('time'))
			{
				if (isDate(value, server_client_parse_validate_time_format))
				{
					var _time = new Date(getDateFromFormat(value, server_client_parse_validate_time_format));
					if (jQuery(selector_str).is(':data(timepicker)'))
						jQuery(selector_str).datepicker('setTime', _time);
					else
						jQuery(selector_str).val(formatDate(_date, client_validate_time_format));
				}
				else
				{
					if (jQuery(selector_str).is(':data(timepicker)') && value == null)
						jQuery(selector_str).datepicker('setTime', null);
					else
						jQuery(selector_str).val(value);
				}
			}
			else if (jQuery(selector_str).hasClass('datetime'))
			{
				if (isDate(value, server_client_parse_validate_datetime_format))
				{
					var _date_time = new Date(getDateFromFormat(value, server_client_parse_validate_datetime_format));
					if (jQuery(selector_str).is(':data(datetimepicker)'))
						jQuery(selector_str).datepicker('setDate', _date_time);
					else
						jQuery(selector_str).val(formatDate(_date_time, client_validate_datetime_format));
				}
				else
				{
					if (jQuery(selector_str).is(':data(datetimepicker)') && value == null)
						jQuery(selector_str).datepicker('setDate', null);
					else
						jQuery(selector_str).val(value);
				}
			}
			else if (jQuery(selector_str).hasClass('datetime-nosecond'))
			{
				if (isDate(value, server_client_parse_validate_datetime_nosecond_format))
				{
					var _date_time = new Date(getDateFromFormat(value, server_client_parse_validate_datetime_nosecond_format));
					if (jQuery(selector_str).is(':data(datetimepicker)'))
						jQuery(selector_str).datepicker('setDate', _date_time);
					else
						jQuery(selector_str).val(formatDate(_date_time, client_validate_datetime_nosecond_format));
				}
				else
				{
					if (jQuery(selector_str).is(':data(datetimepicker)') && value == null)
						jQuery(selector_str).datepicker('setDate', null);
					else
						jQuery(selector_str).val(value);
				}
			}
			else if (jQuery(selector_str).hasClass('ckeditor'))
			{
				var cke_id = jQuery(selector_str).attr('id');
				var cke = CKEDITOR.instances[cke_id];
				jQuery(selector_str).val(value);
				cke.setData(value);
			}
			else
				jQuery(selector_str).val(value);
		break;
	}
}

function jquery_blockui(jq_element, message)
{
	if ( message == undefined)
		message = "";
	if (jq_element && jq_element.length > 0)
	{
		jq_element.block({
			message: '<span class="blocker-ui">' + message + '</span>',
			css: {border: 'none', width: '50px', height: '50px', left: '47%', backgroundColor: 'transparent'}
		});
	}
	else
	{
		jQuery.blockUI({
			message: '<span class="blocker-ui">' + message + '</span>',
			css: {border: 'none', width: '50px', height: '50px', left: '47%', backgroundColor: 'transparent'},
			baseZ: 9999
		});
	}
}

function jquery_unblockui(jq_element)
{
	if (jq_element && jq_element.length > 0)
		jq_element.unblock();
	else
		jQuery.unblockUI();
}

function jquery_add_date(date, day, month, year)
{
	if (day)
		return new Date(date.getTime() + day * 24 * 60 * 60 * 1000);
	else if (month)
	{
		var new_month = date.getMonth() + month;
		if (new_month < 0)
			new_month = 11;
		return new Date(date.getFullYear(), new_month, date.getDate());
	}
	else if (year)
		return new Date(date.getFullYear() + year, date.getMonth(), date.getDate());

	return date;
}

function jquery_ajax_error_handler(xhr, exception)
{
	var _status_error = jquery_ajax_error_status_handler(xhr, exception);
	var _server_error = jquery_ajax_error_server_handler(xhr, exception);
	var _error_message = _status_error + (_server_error ? "<br/>" + _server_error : '');

	swal({
		title : 'Alert',
		text  : _error_message,
		type  : "error",
		html  : true
	});
}

function jquery_ajax_error_server_handler(xhr, exception)
{
	var server_message = "";
	try
	{
		var jsonResponse = jQuery.parseJSON(xhr.responseText);

		var server_messages = new Array;
		if (jsonResponse.title != undefined)
			server_messages.push('<strong>' + jsonResponse.title + '</strong>');
		if (jsonResponse.heading != undefined)
			server_messages.push('<i>' + jsonResponse.heading + '</i>');
		if (jsonResponse.message != undefined)
			server_messages.push(jsonResponse.message);
		if (jsonResponse.value != undefined)
			server_messages.push(jsonResponse.value);
		if (jsonResponse.severity != undefined)
			server_messages.push('severity : ' + jsonResponse.severity);
		if (jsonResponse.filepath != undefined)
			server_messages.push('file : ' + jsonResponse.filepath);
		if (jsonResponse.line != undefined)
			server_messages.push('line : ' + jsonResponse.line);

		server_message = server_messages.join('<br/>');
	}
	catch (e)
	{
		server_message = xhr.responseText;
	}

	return server_message;
}

function jquery_ajax_error_status_handler(xhr, exception)
{
	var error_message = "";
	if (xhr.status === 0) {
		error_message += 'Not connect.<br/>Verify network.';
	} else if (xhr.status == 400) {
		error_message += 'Server understood the request but request content was invalid.';
	} else if (xhr.status == 401) {
		error_message += 'Unauthorised access.';
	} else if (xhr.status == 403) {
		error_message += 'Forbidden resouce can\'t be accessed.';
	} else if (xhr.status == 404) {
		error_message += 'Requested not found.';
	} else if (xhr.status == 500) {
		error_message += 'Internal server error.';
	} else if (xhr.status == 503) {
		error_message += 'Service unavailable.';
	} else if (exception != null) {
		if (exception === 'parsererror') {
			error_message += 'Requested JSON parse failed.';
		} else if (exception === 'timeout') {
			error_message += 'Time out error.';
		} else if (exception === 'abort') {
			error_message += 'Request aborted.';
		}
	} else {
		error_message += 'Uncaught Error.';
	}

	return error_message;
}

function jquery_dialog_form_open(element_id, url, data, on_submit, dialog_options)
{
	var container_elem = jQuery('#' + element_id);
	if (container_elem && container_elem.length > 0)
		container_elem.remove();

	data = data || {};

	var buttons = new Array;
	if (on_submit != null)
	{
		buttons = [
			{text: "Simpan",
			 icons: {
				primary: "ui-icon-disk"
			 },
			 click: function(){
				on_submit(jQuery(this));
			 }
			},
			{text: "Batal",
			 icons: {
				primary: "ui-icon-cancel"
			 },
			 click: function(){
				jQuery(this).dialog("close");
			 }
			}
		];
	}

	dialog_options = dialog_options || {};
	var dialog_defaults = {
		autoOpen: true,
		modal: false,
		buttons: buttons,
		close: function(event, ui){
			jQuery(this).remove();
		}
	};
	dialog_options = $.extend(dialog_defaults, dialog_options);

	jQuery.ajax({
		url: url,
		type: "GET",
		dataType: "html",
		async : false,
		data : data,
		error: jquery_ajax_error_handler,
		success: function(data, textStatus, jqXHR){
			jQuery("<div>", {
				id		: element_id,
				'class'	: "ui-widget ui-widget-content ui-corner-all"
			})
			.dialog(dialog_options)
			.html(data)
			.dialog("option", "position", {my: "center", at: "center", of: window})
			.find('form').keypress(function(e){
				var charCode = e.charCode || e.keyCode || e.which;
				if (charCode  == 13)
				{
					e.preventDefault();
					return false;
				}
			});
		}
	});
}

function jquery_select2_build(src_element, url, options)
{
	options = options || {};
	var defaults = {
		minimumInputLength	: 0,
		allowClear			: true,
		ajax 				: {
			url: url,
			quietMillis: 800,
			dataType: 'json',
			data: function(term, page){
				return {
					q: term,
					page: page,
					limit: 20
				};
			},
			results: function(data, page){
				return {
					more: data.more,
					results: data.results,
					context: data
				};
			}
		},
		initSelection 		: function (element, callback){
			var id = element.val();
			if (id)
			{
				if (element.is("[data-text]") && element.attr('data-text') != null)
				{
					callback({
						id 		: id,
						text 	: element.attr('data-text')
					});
				}
				else
				{
					jQuery.ajax({
						url: url,
						type: "GET",
						dataType: "json",
						data : {
							id : id
						},
						error: jquery_ajax_error_handler,
						success: function(data, textStatus, jqXHR){
							if (data.results.length > 0)
							{
								var selected_data = data.results[0];
								callback(selected_data);
							}
						}
					});
				}
			}
		}
	};
	options = $.extend(defaults, options);
	jQuery(src_element).select2(options);
}

function jquery_autocomplete_build(src_element, url, display_options, options, render_item)
{
	display_options = display_options || {};
	var default_display_options = {
		must_select : true,
		width : 200
	}
	display_options = $.extend(default_display_options, display_options);

	src_id = jQuery(src_element).attr('id') + '_caption';
	src_class = jQuery(src_element).attr('class');

	target_element = src_element + '_caption';

	options = options || {};
	var defaults = {
		source: url,
		autoFocus: true,
		minLength: 0,
		change: function(event, ui){
			if (display_options.must_select == true)
			{
				if (ui.item == null)
				{
					jQuery(this).val('');
					jQuery(src_element).val('');
				}
			}
			if (ui.item != null)
			{
				jQuery(src_element).val(ui.item.id);
			}
		}
	};
	options = $.extend(defaults, options);

	var text_default = '';
	if (jQuery(src_element).is("[data-text]") && jQuery(src_element).attr('data-text') != null)
		text_default = jQuery(src_element).attr('data-text');

	jQuery("<input>", {type : 'text', id : src_id, 'class' : src_class})
		.width(display_options.width)
		.val(text_default)
		.insertAfter(jQuery(src_element))
		.autocomplete(options)
		.data("ui-autocomplete")._renderItem = function( ul, item ) {
			if (typeof(render_item) == "undefined")
				render_item = '';

			if (render_item != '')
			{
				return render_item(ul, item);
			}
			else
			{
				return $( "<li>" )
					.append( $( "<a>" ).text( item.label ) )
					.appendTo( ul );
			}
		};
}

function replaceAll(string, find, replace)
{
	return string.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function escapeRegExp(string)
{
	return string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function toCamelCase(str)
{
	return str.replace(/(?:^|\s)\w/g, function(match) {
		return match.toUpperCase();
	});
}

function number_format(number, decimals, dec_point, thousands_sep)
{
	//	example 1: number_format(1234.56);
	//  returns 1: '1,235'
	//  example 2: number_format(1234.56, 2, ',', ' ');
	//  returns 2: '1 234,56'
	//	example 3: number_format(1234.5678, 2, '.', '');
	//	returns 3: '1234.57'
	//	example 4: number_format(67, 2, ',', '.');
	//	returns 4: '67,00'
	//	example 5: number_format(1000);
	//	returns 5: '1,000'
	//	example 6: number_format(67.311, 2);
	//	returns 6: '67.31'
	//	example 7: number_format(1000.55, 1);
	//	returns 7: '1,000.6'
	//	example 8: number_format(67000, 5, ',', '.');
	//	returns 8: '67.000,00000'
	//	example 9: number_format(0.9, 0);
	//	returns 9: '1'
	//	example 10: number_format('1.20', 2);
	//	returns 10: '1.20'
	//	example 11: number_format('1.20', 4);
	//	returns 11: '1.2000'
	//	example 12: number_format('1.2000', 3);
	//	returns 12: '1.200'
	//	example 13: number_format('1 000,50', 2, '.', ' ');
	//	returns 13: '100 050.00'
	//	example 14: number_format(1e-8, 8, '.', '');
	//	returns 14: '0.00000001'

	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : + number;
	var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
	var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
	var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
	var s = '';
	toFixedFix = function(n, prec)
	{
		var k = Math.pow(10, prec);
		return '' + (Math.round(n * k) / k).toFixed(prec);
	};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3)
	{
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec)
	{
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

function convert_filesize(size)
{
	if (size > 1048576)
		return number_format(size / 1048576 , 2, ',', '.') + ' MB';
	else if (size > 1024)
		return number_format(size / 1024 , 2, ',', '.') + ' KB';
	else
		return number_format(size / 1024 , 2, ',', '.') + ' Byte';
}

function chk_all(chlAll, targetClass)
{
	$('#' + chlAll).click(function () {
		$('.' + targetClass).prop('checked', this.checked);
	});
}
// Minimalize menu when screen is less than 768px
$(function() {
	$(window).bind("load resize", function() {
		if ($(this).width() < 769) {
			$('body').addClass('body-small')
		} else {
			$('body').removeClass('body-small')
		}
	})
})
