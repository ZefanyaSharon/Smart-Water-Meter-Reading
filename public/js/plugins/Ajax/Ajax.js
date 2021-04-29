// -- Initialization --
var ajaxMethod = 'POST';
var ajaxData = '';
var ajaxUrl = '';
var ajaxMessageStart = '';

function callAjax(init, onSuccess)
{
	init();
	$.ajax({
		type : ajaxMethod,
		headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
		url  : url + '/' + ajaxUrl,
		data : ajaxData,
		beforeSend : function ()
		{
			jquery_blockui('', imgLoading);
		},
		statusCode : {
			404 : function () {
				swal({
					title : 'Alert',
					text  : 'Page Not Found !',
					type  : "error",
					html  : true
				});
			},
		},
		error : function ()
		{
			swal({
				title : 'Alert',
				text  : 'Proses error !',
				type  : "error",
				html  : true
			});
		},
		success : function (result)
		{
			onSuccess(result);
		},
		complete : function() {
			jquery_unblockui();
		}
	}); //-- End Ajax --
}
