jQuery.extend(jQuery.jgrid.defaults, { 
	loadComplete: function (data){
		if (jQuery(this).jqGrid('getGridParam', 'reccount') == 0)
		{
			jQuery(this, ".jqgfirstrow").css("height", "1px");
		}
		else
		{
			jQuery(this, ".jqgfirstrow").css("height", "auto");
		}
		
		jQuery(this).triggerHandler("loadComplete.jqGrid", data);
	}
});

// -- Patch untuk freexe kolom yang amburadul -- https://stackoverflow.com/a/8771429/4845057
var resizeColumnHeader = function () {
	var rowHight, resizeSpanHeight,
		// get the header row which contains
		headerRow = $(this).closest("div.ui-jqgrid-view")
			.find("table.ui-jqgrid-htable>thead>tr.ui-jqgrid-labels");

	// reset column height
	headerRow.find("span.ui-jqgrid-resize").each(function () {
		this.style.height = '';
	});

	// increase the height of the resizing span
	resizeSpanHeight = 'height: ' + headerRow.height() + 'px !important; cursor: col-resize;';
	headerRow.find("span.ui-jqgrid-resize").each(function () {
		this.style.cssText = resizeSpanHeight;
	});

	// set position of the dive with the column header text to the middle
	rowHight = headerRow.height();
	headerRow.find("div.ui-jqgrid-sortable").each(function () {
		var $div = $(this);
		$div.css('top', (rowHight - $div.outerHeight()) / 2 + 'px');
	});
},
fixPositionsOfFrozenDivs = function () {
	var $rows;
	if (typeof this.grid.fbDiv !== undefined) {
		$rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
		$('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
			var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
			if ($(this).hasClass("jqgrow")) {
				$(this).height(rowHight);
				rowHightFrozen = $(this).height();
				if (rowHight !== rowHightFrozen) {
					$(this).height(rowHight + (rowHight - rowHightFrozen));
				}
			}
		});
		$(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
		$(this.grid.fbDiv).css($(this.grid.bDiv).position());
	}
	if (typeof this.grid.fhDiv !== undefined) {
		$rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
		$('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
			var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
			$(this).height(rowHight);
			rowHightFrozen = $(this).height();
			if (rowHight !== rowHightFrozen) {
				$(this).height(rowHight + (rowHight - rowHightFrozen));
			}
		});
		$(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
		$(this.grid.fhDiv).css($(this.grid.hDiv).position());
	}
},
fixGboxHeight = function () {
	var gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight(),
		pagerHeight = $(this.p.pager).outerHeight();

	$("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
	gviewHeight = $("#gview_" + $.jgrid.jqID(this.id)).outerHeight();
	pagerHeight = $(this.p.pager).outerHeight();
	$("#gbox_" + $.jgrid.jqID(this.id)).height(gviewHeight + pagerHeight);
};