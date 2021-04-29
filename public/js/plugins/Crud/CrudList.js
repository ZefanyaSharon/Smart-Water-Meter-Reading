$(function() {
    jqGridLoad();
});

$(document).ready(function() {
    var input = document.getElementById("InputSearch");
    if (input)
        input.addEventListener("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                document.getElementById("btnSearch").click();
            }
        });

    $("#btnSearch").click(function() {
        // console.log($("#inputType").val())
        var searchFilter = $("#InputSearch").val(),
            grid = $('#' + tableId),
            f;

        if (searchFilter.length === 0) {
            grid[0].p.search = false;
            $.extend(grid[0].p.postData, { filters: "" });
        }
        f = { groupOp: "OR", rules: [] };

        $.each(setModels, function(key, value) {
            f.rules.push({ field: value['index'], op: "cn", data: searchFilter });
        });
        grid[0].p.search = true;
        $.extend(grid[0].p.postData, { filters: JSON.stringify(f) });
        grid.trigger("reloadGrid", [{ page: 1, current: true }]);
    });

});

function after_grid_load() {
    $('#btnNew').click(function() {
        document.location.href = url + '/form';
    });

    $("#btnEdit").click(function() {
        var id = $('#' + tableId).getGridParam('selrow');
        if (id) {
            var _editUrl = url + '/form?id=' + id;
            document.location.href = _editUrl;
        } else
            swal({
                title: 'Warning',
                text: 'Please select one of the data to be changed !',
                type: 'warning',
            });
    });

    $('.btnDelete').click(function() {
        destroy_record($(this).prop('id'));
    });

    $('.btnES').click(function() {
        index($(this).prop('id'));
    });

    $('#toExcel').click(function() {
        exportTo('excel');
    });

    $('#toPdf').click(function() {
        exportTo('pdf');
    });

    // console.log(jqgrid_window_fixed_width('jqGridTable'));
}


function destroy_record(btnId) {
    if (typeof $('#' + btnId).data('id') == 'undefined') {
        // for multiple delete
        if (multiselect) {
            id = $('#' + tableId).jqGrid('getGridParam', 'selarrrow');
            if (id.length < 1)
                id = null;
        } else
            id = $('#' + tableId).getGridParam('selrow');
    } else
        id = $('#' + btnId).data('id');

    var url_target = $('#' + btnId).data('urlTarget'); // -- ex. api/revoke-token
    url_target = (typeof url_target === "undefined" ? url + '/delete/' : url_target);
    if (id) {
        swal({
            title: 'Alert',
            text: 'Apakah anda yakin ingin menghapus data ini ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
            closeOnConfirm: false
        }, function() {
            var data = {
                "id": id
            };
            $.ajax({
                url: url_target,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                data: data,
                dataType: 'json',
                async: false,
                error: jquery_ajax_error_handler,
                beforeSend: function(jqXHR, settings) {
                    jquery_blockui();
                },
                success: function(data, textStatus, jqXHR) {
                    if (data.response == false)
                        swal('Something Wrong', data.value, 'error');
                    else {
                        $('#' + tableId).trigger('reloadGrid', [{ current: true }]);
                        swal('Hapus !', 'Data berhasil di hapus.', 'success');
                    }
                },
                complete: function(jqXHR, textStatus) {
                    jquery_unblockui();
                }
            });
        });
    } else {
        swal({
            title: 'Warning',
            text: 'Please select one of the data to be deleted !',
            type: 'warning',
        });
    }
}

function index(btnId) {
    id = $('#' + btnId).data('id');

    var url_target = $('#' + btnId).data('urlTarget'); // -- ex. api/revoke-token
    url_target = (typeof url_target === "undefined" ? url + '/reindex_es/' : url_target);
    if (id) {
        swal({
            title: 'Alert',
            text: 'Apakah anda ingin reindex elastic ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Ya, Reindex!',
            cancelButtonText: 'Tidak',
            closeOnConfirm: false
        }, function() {
            var data = {
                "id": id
            };
            $.ajax({
                url: url_target,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                data: data,
                dataType: 'json',
                async: false,
                error: jquery_ajax_error_handler,
                beforeSend: function(jqXHR, settings) {
                    jquery_blockui();
                },
                success: function(data, textStatus, jqXHR) {
                    if (data.response == false)
                        swal('Telah terjadi kesalahan', data.value, 'error');
                    else {
                        $('#' + tableId).trigger('reloadGrid', [{ current: true }]);
                        swal('Berhasil !', 'Data berhasil di reindex.', 'success');
                    }
                },
                complete: function(jqXHR, textStatus) {
                    jquery_unblockui();
                }
            });
        });
    } else {
        swal({
            title: 'Warning',
            text: 'Please select one of the data to be deleted !',
            type: 'warning',
        });
    }
}

function exportTo(to) {
    swal({
        title: 'Ekspor Data',
        text: 'Apakah anda ingin ekspor data ini ?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, ekspor!',
        cancelButtonText: 'Tidak',
        closeOnConfirm: true
    }, function() {
        var filters = $('#' + tableId).jqGrid('getGridParam', 'postData');

        // ini di commenting karena sifatnya untuk ekspor menjadi non limited (menyebabkan error exhausted memory pada php karena ekspor data tidak terbatas)
        // filters.rows = 0;
        // filters.page = 0;

        var params = jQuery.param(filters);
        document.location.href = url + '/export/' + to + '/?' + params;
    });
}

function jqGridLoad() {
    // console.log('Start to load JqGrid');
    setSortBy = (typeof setSortBy === "undefined" ? '"updated" desc, "created"' : setSortBy);
    setSortOrder = (typeof setSortOrder === "undefined" ? 'desc' : setSortOrder);
    subGrid = (typeof subGrid === "undefined" ? '' : subGrid);
    url_target = (typeof url_opsional === "undefined" ? url + '/get_list' : url_opsional);
    $('#' + tableId).jqGrid({
        loadError: jquery_ajax_error_handler,
        datatype: 'json',
        viewrecords: true,
        rownumbers: false,
        rownumWidth: 30,
        shrinkToFit: true,
        autowidth: true,
        rowNum: jqRowNum,
        multiselect: multiselect,
        rowList: jqRowList,
        jsonReader: {
            root: 'data',
            page: 'page',
            total: 'total',
            records: 'records',
            repeatitems: false
        },
        width: jqgrid_window_fixed_width(tableId),
        url: url_target,
        colNames: setColumns,
        colModel: setModels,
        pager: '#' + tableId + 'Nav',
        sortname: setSortBy,
        sortorder: setSortOrder,
        // ondblClickRow : function (rowId) {
        //     ondblClickRow(rowId);
        // },
        loadComplete: after_grid_load,
        subGrid: (subGrid == '' ? false : true),
        subGridRowExpanded: subGrid,
        subGridOptions: {
            'plusicon': 'ui-icon-triangle-1-e',
            'minusicon': 'ui-icon-triangle-1-s',
            'openicon': 'ui-icon-arrowreturn-1-e',
            'reloadOnExpand': false, // load the subgrid data only once // and the just show/hide
            'selectOnExpand': true, // select the row when the expand column is clicked
        },
    });

    // filterToolbar setting (disabled)
    // $('#' + tableId).jqGrid('filterToolbar', {
    // 	stringResult    : true,
    // 	searchOperators : true
    // });

    // $('#' + tableId).jqGrid('navGrid', '#' + tableId + 'Nav', {
    // 	/**
    // 	 *  Button Configuration
    // 	 *  di set false karena menggunakan tombol di set diatas
    // 	 */
    // 	edit : false,
    // 	add  : false,
    // 	del  : false
    // },
    // {},
    // {},
    // {},
    // {
    // 	/**
    // 	 *  Searching Configuration
    // 	 */
    // 	multipleSearch : true,
    // 	multipleGroup  : true,
    // 	showQuery      : true
    // });

    var $grid = $('#' + tableId);
    var newWidth = $grid.closest(".ui-jqgrid").parent().width();
    var fix = "20";

    if (newWidth)
        newWidth -= fix;

    width = (typeof width === "undefined" ? '1085px' : width);

    // create the grid
    $grid.jqGrid({
        // jqGrid options
    });

    // set searching default
    $.extend($.jgrid.search, { multipleSearch: true, multipleGroup: true, showQuery: true, overlay: 0, drag: false, resize: false });

    // during creating nevigator bar (optional) one don't need include searching button
    $grid.jqGrid('navGrid', '#' + tableId + 'Nav', { add: false, edit: false, del: false, multipleSearch: true });

    // create the searching dialog
    $grid.jqGrid('searchGrid');

    var gridSelector = $.jgrid.jqID($grid[0].id), // 'list'
        $searchDialog = $("#searchmodfbox_" + gridSelector),
        $gbox = $("#gbox_" + gridSelector);

    // hide/show 'close' button of the searching dialog
    $searchDialog.find("a.ui-jqdialog-titlebar-close").show();

    // place the searching dialog above the grid
    $searchDialog.insertBefore($gbox);
    $searchDialog.css({ position: "relative", zIndex: "auto", float: "left", width: newWidth, marginBottom: "5px" })
    $gbox.css({ clear: "left" });

    $(window).on("resize", function() {
        var $grid = $('#' + tableId),
            newWidth = $grid.closest(".ui-jqgrid").parent().width();
        $grid.jqGrid("setGridWidth", newWidth, true);
    });

    $('#' + tableId).jqGrid('setFrozenColumns');
    $('#' + tableId).setGridHeight(jqgrid_window_fixed_height($('#' + tableId)));
}

// -- fungsi untuk limiter html text pada jqgrid --
function html_substr(s, n, url, id) {

    var m, r = /<([^>\s]*)[^>]*>/g,
        stack = [],
        lasti = 0,
        result = '';

    //for each tag, while we don't have enough characters
    while ((m = r.exec(s)) && n) {
        //get the text substring between the last tag and this one
        var temp = s.substring(lasti, m.index).substr(0, n);
        //append to the result and count the number of characters added
        result += temp;
        n -= temp.length;
        lasti = r.lastIndex;

        if (n) {
            result += m[0];
            if (m[1].indexOf('/') === 0) {
                //if this is a closing tag, than pop the stack (does not account for bad html)
                stack.pop();
            } else if (m[1].lastIndexOf('/') !== m[1].length - 1) {
                //if this is not a self closing tag than push it in the stack
                stack.push(m[1]);
            }
        }
    }

    //add the remainder of the string, if needed (there are no more tags in here)
    result += s.substr(lasti, n);
    result += '<a href="' + url + '/detail/' + id + '"><span class="label">... Read More</span></a>';

    //fix the unclosed tags
    while (stack.length) {
        result += '</' + stack.pop() + '>';
    }

    return result;
}