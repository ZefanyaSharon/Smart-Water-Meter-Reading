$(document).ready(function () {
	$('#btnSubmit').click(function () {
		$('#' + formId).submit();
	});

	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('.dateyear').datepicker({
		format: "yyyy",
		weekStart: 1,
		language: "{{ app.request.locale }}",
		keyboardNavigation: false,
		viewMode: "years",
		minViewMode: "years"
	});

	$('.datetimepicker').datetimepicker({
		format: 'DD-MM-YYYY HH:mm:ss',
	});
});

$(function () {
	$('#' + formId).validate({
		submitHandler : function (form) {
			jQuery('#' + formId).ajaxSubmit({
				dataType : 'json',
				async    : true,
				error    : jquery_ajax_error_handler,
				beforeSend : function(jqXHR, settings) {
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
					422 : function (data) {
						var response_validation = '';
						$.each(data.responseJSON, function(field, item) {
							var val = '';
							$.each(item, function(a, b) {
								val += b;
							})
							response_validation += '<br>' + val;
						})
						response_validation += '</ol>';
						swal({
							title : 'Alert',
							text  : response_validation,
							type  : "error",
							html  : true
						});
					},

				},
				success : function (data, textStatus, jqXHR) {
					if (data.response == false) {
						swal({
							title : 'Warning',
							text  : data.message,
							type  : "warning",
							html  : true
						});
					} else {
						if (data.redirect_url_sukses){
							successUrl = data.redirect_url_sukses;
						}
						window.location.href = successUrl;
					}
				},
				complete : function (jqXHR, textStatus) {
					jquery_unblockui();
				}
			});
		}
	});
});

function row_delete_doc(type) {

	if (type == 'file') {
		id = $('#btnDlt').data('id');
	} else if (type == 'cover') {
		id = $('#btnDltimg').data('id');
	} else {
		id = null;
	}
	if (id) {
		swal({
			title: 'Peringatan',
			text: 'Menghapus data ini akan menghapus dokumen yang tersimpan, Ingin melanjutkan ?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: 'Ya, Lanjut Hapus Dokumen!',
			cancelButtonText: 'Tidak!',
			closeOnConfirm: false
		}, function () {
			var data = {
				"id": id
			};
			$.ajax({
				url: url_delete_dok,
				type       : 'POST',
				data       : data,
				dataType   : 'json',
				async      : false,
				error      : jquery_ajax_error_handler,
				beforeSend : function (jqXHR, settings) {
					jquery_blockui();
				},
				success : function (data, textStatus, jqXHR) {
					if (data.response == true) {
						console.log
						swal({ title: "Delete Berhasil", text: "Dokumen ini berhasil dihapus", type: "success" },
							function () {
								window.location = success_delete_dok;
							}
						);
					} else {
						swal('Delete Error !', 'Dokumen gagal dihapus', 'error');
					}
				},
				complete : function (jqXHR, textStatus) {
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
