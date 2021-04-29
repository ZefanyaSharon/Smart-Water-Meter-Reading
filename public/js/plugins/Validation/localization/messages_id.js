/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: MY (Malay; Melayu)
 */
(function ($) {
	$.extend($.validator.messages, {
		required: "Data ini diperlukan.",
		remote: "Mohon perbaiki data ini.",
		email: "Mohon masukan alamat email yang benar.",
		url: "Mohon masukan URL yang benar.",
		date: "Mohon masukan tanggal yang benar.",
		dateISO: "Mohon masukan tanggal(ISO) yang benar.",
		number: "Mohon masukan nomor yang benar.",
		digits: "Mohon masukan nilai digit saja.",
		creditcard: "Mohon masukan nomor kartu kredit yang benar.",
		equalTo: "Mohon masukan nilai yang sama lagi.",
		accept: "Mohon masukan nilai yang telah diterima.",
		maxlength: $.validator.format("Mohon masukan tidak lebih dari {0} huruf."),
		minlength: $.validator.format("Mohon masukan kurang dari {0} huruf."),
		rangelength: $.validator.format("Mohon masukan panjang nilai antara {0} dan {1} huruf."),
		range: $.validator.format("Mohon masukan nilai antara {0} dan {1} huruf."),
		max: $.validator.format("Mohon masukan nilai yang kurang atau sama dengan {0}."),
		min: $.validator.format("Mohon masukan nilai yang lebih atau sama dengan {0}.")
	});
}(jQuery));