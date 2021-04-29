/*
 * Version 1.1
 * Author: Chenri Jano
 * Date: 2012 12 15
 * Feature:
 * - add row: copy the last row in the table <tbody> and insert after last row
 * row_add(table_id);
 * - delete row: delete the selected row and put the id to hidden field
 * row_delete(this,table_id,key,hidden_field_for_delete);
 */

/**
 *  delete row for dynamic row
 */
function row_delete(obj, table_id, key, hidden, is_class)
{
	if (typeof(is_class)==='undefined' || is_class == false)
	{
		var count = $('#' + table_id + ' tbody>tr').length;
	}
	else
	{
		var count = $('.' + table_id + ' tbody>tr').length;
	}

	if (confirm("Apakah Anda yakin akan menghapus data detil tersebut ?"))
	{
		if (key && hidden)
		{
			if ($('[name="'+key+'"]').val())
				$('[name="'+hidden+'"]').val($('[name="'+hidden+'"]').val() + $('[name="'+key+'"]').val() + "|");
		}
		if (count == 1)
		{
			row_add('#' + table_id, false, is_class);
		}
		$(obj).parents("tr:first").remove();
	}
}

/**
 * Untuk cloning row HTML
 * Contoh :
 * row_add('#table-id', function (row, num) {
 * 		callBackFunction(num);
 * })
 *
 * @param string table_selector Bisa menggunkana # (id) atau . dot (class)
 * @param closure call_back
 *
 * @return void
 */
function row_add(table_selector, call_back)
{
	var row = $(table_selector + ' tbody>tr:last').clone(false).insertAfter(table_selector + ' tbody>tr:last');
	// untuk clear checkbox saat add button
	row.find("input:checkbox").attr('checked', false);

	$("select", row).val('');
	$("input:not(:button,:reset,:checkbox)", row).val('');
	$("textarea", row).val('');
	/**
	 * Jika ada element yang tidak terhapus value nya maka tambahkan class dibawah ini
	 */
	$(".clear-html", row).html('');
	$(".clear-val", row).val('');
	$(".clear-img", row).prop('src', '');

	var num = 0;

	/**
	 *  Reindex input form get last index object base on property id[index]
	 */
	$.each($("input, textarea, select", row), function () {
		row.find("span").remove();
		row.find(".select2").select2();
		var old = $(this).attr('id');
		var start_pos = old.indexOf('[') + 1;
		var end_pos = old.indexOf(']',start_pos);

		var arr_old = old.substring(start_pos,end_pos);
		var name = old.substring(0,start_pos-1);

		/**
		 *  generate new id and name
		 */
		num = (parseInt(arr_old) + 1);
		var name_id_new = name + '[' + num + ']';
		$('#'+ name +'\\['+arr_old+'\\]', row).attr('name', ''+ name_id_new +'').attr('id', ''+ name_id_new +'');
	});

	if (typeof ((call_back) !== 'undefined') && (call_back !== false)) {
		call_back(row, num);
	}

	// if (typeof(custom_attribute) !== 'undefined' && custom_attribute == true)
	// {
	// 	$("select", row).removeAttr("readonly");
	// 	$("select", row).removeClass();
	// 	$("input:not(:button,:reset)", row).removeAttr("readonly");
	// 	$("input:not(:button,:reset)", row).removeClass();
	// }
	/**
	 * Untuk re-assign fungsi js (datepicker, datetimepicker, digit grouping)
	 * Fungsi ini ada di inspinia.js
	 */
	reload_script();
}
