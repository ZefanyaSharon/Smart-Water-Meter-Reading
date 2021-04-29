<div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-md-4">
                    <div id="nestable-menu">
                        <button type="button" data-action="expand-all" class="btn btn-white btn-sm">Expand All</button>
                        <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">Collapse All</button>
                    </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Menu List Custom</h5>
                        </div>
                        <div class="ibox-content">
							<div class="dd" id="nestable2">
                                <ol class="dd-list">
									<?php echo menu_arrange($menu); ?>
								</ol>
                            </div>

							<br>
							<?php echo form_open($form_action, $form_attributes);?>
                            <textarea id="nestable2-output" name="json" id="json" class="form-control" style = "display:none;"></textarea>
							<?php
								echo btnSubmit();
							?>

							<?php echo form_close() ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
<script>
		var formId = '<?php echo $form_attributes['id'] ?>';
         $(document).ready(function(){

             var updateOutput = function (e) {
                 var list = e.length ? e : $(e.target),
                         output = list.data('output');
                 if (window.JSON) {
                     output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                 } else {
                     output.val('JSON browser support required for this demo.');
                 }
             };

             // activate Nestable for list 2
             $('#nestable2').nestable({
                 group: 1
             }).on('change', updateOutput);

             // output initial serialised data
             updateOutput($('#nestable2').data('output', $('#nestable2-output')));

             $('#nestable-menu').on('click', function (e) {
                 var target = $(e.target),
                         action = target.data('action');
                 if (action === 'expand-all') {
                     $('.dd').nestable('expandAll');
                 }
                 if (action === 'collapse-all') {
                     $('.dd').nestable('collapseAll');
                 }
             });
         });
    </script>
	<script src="<?php echo base_url('public/js/plugins/Crud/crudForm.js') ?>"></script> <!-- JS Form -->