<?php getHead(); ?>

<style>
	.box-primary {

		margin: 5px 2px;

	}



	.box-primary img {

		min-width: 200px;

		min-height: 200px;



	}



	div.center {

		background-color: #fff;

		border-radius: 5px;

		box-shadow: -2px 2px 7px 1px;

		left: 0;

		margin-left: -100px;

		padding: 11px;

		position: absolute;

		top: 10%;

		width: 50%;

	}
</style>

<div class="content-wrapper">

	<!-- Content Header (Page header) -->

	<section class="content-header">

		<h1>

			Update Main Menu



		</h1>

		<ol class="breadcrumb">

			<li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>

			<li> <a href="leprojects">Main Menu </a></li>

		</ol>

	</section>



	<!-- Main content -->

	<section class="content">

		<div class="row">

			<div class="col-xs-12">

				<div class="box">

					<div class="box-header">





					</div>

					<!-- /.box-header -->

					<div class="box-body">

						<form id="form_add_update" name="form_add_update" role="form">

							<div class="alert hidden"></div>

							<div class="form-group wrap_form">

								<div class="col-xs-12 col-md-6">

									<label for="Cleanurl">Clean url</label>

									<input type="text" class="form-control" id="Cleanurl" placeholder="Title" name="slug" value="<?php if (isset($row)) {

																						echo $row->slug;
																					} ?>">



								</div>

								<div class="col-xs-12 col-md-6">

									<label for="Actualurl"> Actual url

									</label>

									<input type="text" class="form-control" id="Actualurl" placeholder="" name="controller" value="<?php if (isset($row)) {

																						echo $row->controller;
																					} ?>">



								</div>

								<div style="margin-top:10px" class="col-xs-12 col-md-6">

									<label for="NavTitle"> Nav Title In French

									</label>

									<input type="text" class="form-control" id="NavTitle" placeholder="Title" name="title_french" value="<?php if (isset($row)) {

																							echo $row->title_french;
																						} ?>">



								</div>
								<div style="margin-top:10px" class="col-xs-12 col-md-6">

									<label for="NavTitle"> Nav Title In English

									</label>

									<input type="text" class="form-control" id="NavTitle" placeholder="Title" name="title_english" value="<?php if (isset($row)) {

																							echo $row->title_english;
																						} ?>">



								</div>

								<div style="margin-top:10px" class="col-xs-12 col-md-6">

									<div class="form-group">

										<label for="want_to_show">Want To Show?

										</label>

										<select name="show_in_nav" class="form-control" id="want_to_show">

											<option>-- choose --</option>

											<option <?php echo selected($row->show_in_nav, 'yes') ?> value="yes">Yes</option>

											<option <?php echo selected($row->show_in_nav, 'no') ?> value="no">No</option>



										</select>

									</div>



								</div>

								<div style="margin-top:10px" class="col-xs-12 col-md-12">

									<div class="form-group">

										<label for="icon_class">Icon Class

										</label>

										<input type="text" class="form-control" id="icon_class" placeholder="" name="icon_class" value="<?php if (isset($row)) {

																							echo $row->icon_class;
																						} ?>">

										<span style='color:red;'>link for Icons:<a href="https://www.w3schools.com/bootstrap/bootstrap_ref_comp_glyphs.asp" target="_blank">Glyphicon icons in W3 School</a>

											<span style='color:red'>&nbsp;|&nbsp;</span><a href="https://marcoceppi.github.io/bootstrap-glyphicons/" target="_blank">Glyphicon icons in GITHUB</a> </span>



									</div>



								</div>

















								<div class="clearfix">&nbsp;</div>





							</div>

							<div class="clearfix">&nbsp;</div>

							<div class="col-xs-12 col-md-6">

								<button type="submit" class="btn btn-info">Submit</button>

								<input type="hidden" id="id" name="id" value="<?php if (isset($row)) {

															echo $row->id;
														} ?>">

							</div>

					</div>











					</form>

					<?php include_once 'edit_img_form.php' ?>

				</div>

				<div class="clearfix">&nbsp;</div>

				<div class="clearfix">&nbsp;</div>

				<script>
					function gettype(val) {

						if (val == 'video') {

							$('#upload_video_wrap').show();

							$('#video_wrap').hide();

							$('#add_images_wrap').hide();



						} else if (val == 'image') {

							$('#add_images_wrap').show();

							$('#video_wrap').hide();

							$('#upload_video_wrap').hide();

						} else if (val == 'embed url') {

							$('#video_wrap').show();

							$('#add_images_wrap').hide();

							$('#upload_video_wrap').hide();

						} else {

							$('#video_wrap').hide();

							$('#add_images_wrap').hide();

							$('#upload_video_wrap').hide();

						}

					}
				</script>

			</div>

		</div>



		<!-- /.box -->

</div>

<!-- /.col -->

</div>

<!-- /.row -->

</section>

<!-- /.content -->

</div>





<?php getFooter(); ?>



<script src="bower_components/ckeditor/ckeditor.js"></script>



<script>
	/**********************************save************************************/

	$('#form_add_update').on("submit", function(e) {

		e.preventDefault();



		// var inputFile = $('input#file');

		// var filesToUpload = inputFile[0].files;





		var formData = new FormData();

		// make sure there is file(s) to upload



		// if (filesToUpload.length > 0) {

		// 	// provide the form data

		// 	// that would be sent to sever through ajax

		// 	for (var i = 0; i < filesToUpload.length; i++) {

		// 		var file = filesToUpload[i];

		// 		formData.append("file[]", file, file.name);

		// 	}

		// }

		// if ($('#post_type').val() == 'video') {

		// 	if ($('#upload_video').val() != '') {

		// 		formData.append("upload_video", document.getElementById('upload_video').files[0]);

		// 	}

		// 	if ($('#thumbnail').val() != '') {

		// 		formData.append("thumbnail", document.getElementById('thumbnail').files[0]);

		// 	}

		// }





		var other_data = $('#form_add_update').serializeArray();



		$.each(other_data, function(key, input) {

			formData.append(input.name, input.value);

		});



		// post_description = CKEDITOR.instances.editor1.getData();

		// formData.append("post_description", post_description);



		// ajax start

		$.ajax({

			type: "POST",

			url: "<?php echo base_url() . 'mainmenu/save'; ?>",

			data: formData,

			cache: false,

			contentType: false,

			processData: false,

			dataType: 'JSON',

			beforeSend: function() {

				$('#loader').removeClass('hidden');

				//	$('#form_add_update .btn_au').addClass('hidden');

			},

			success: function(data) {

				$('#loader').addClass('hidden');

				$('#form_add_update .btn_au').removeClass('hidden');

				//alert(data.status);

				//var obj = jQuery.parseJSON(data);

				if (data.status == 1) {

					$(".alert").addClass('alert-success');

					$(".alert").html(data.message);

					$(".alert").removeClass('hidden');

					setTimeout(function() {

						$(".alert").addClass('hidden');

						$('#form_add_update')[0].reset();

					}, 3000);

				} else if (data.status == 0) {

					$(".alert").addClass('alert-danger');

					$(".alert").html(data.message);

					$(".alert").removeClass('hidden');

					setTimeout(function() {

						$(".alert").addClass('hidden');

					}, 3000);

				} else if (data.status == 2) {

					$(".alert").addClass('alert-success');

					$(".alert").html(data.message);

					$(".alert").removeClass('hidden');

					setTimeout(function() {

						window.location = 'mainmenu';

					}, 1000);

				} else if (data.status == "validation_error") {

					alert(data.status);

					$(".alert").addClass('alert-warning');

					$(".alert").html(data.message);

					$(".alert").removeClass('hidden');



				}



			}

		});



		//ajax end    

	});



	/******************************/



	$('#form_edit_image').on("submit", function(e) {



		e.preventDefault();

		var inputFile = $('input#edit_image');

		var filesToUpload = inputFile[0].files;

		var formData = new FormData();



		// make sure there is file(s) to upload

		if (filesToUpload.length > 0) {

			// provide the form data

			// that would be sent to sever through ajax

			for (var i = 0; i < filesToUpload.length; i++) {

				var file = filesToUpload[i];

				formData.append("file[]", file, file.name);

			}

		}

		var other_data = $('#form_edit_image').serializeArray();

		$.each(other_data, function(key, input) {

			formData.append(input.name, input.value);

		});



		// ajax start

		$.ajax({

			type: "POST",

			url: "<?php echo base_url() . 'leprojects/update_image'; ?>",

			data: formData,

			cache: false,

			contentType: false,

			processData: false,

			beforeSend: function() {

				$('#loader').removeClass('hidden');

				//$('#form_sample .btn_au').addClass('hidden');

			},

			success: function(data) {

				$('#loader').addClass('hidden');

				$('#form_sample .btn_au').removeClass('hidden');

				var obj = jQuery.parseJSON(data);

				if (obj.status == 1) {

					var src = obj.image;

					if (src != 0) {

						var src = '<?php echo base_url() ?>uploads/' + obj.image;

						$("#img_" + obj.id).attr("src", src);

					}

					setTimeout(function() {

						$('#edit_image_wrap').hide('slow');

						$("#edit_small_image_div img").attr("src", src);

					}, 2000);

				}





			}

		});



		//ajax end    

	});
</script>

<script>
	$(function() {

		// Replace the <textarea id="editor1"> with a CKEditor

		// instance, using default configuration.

		CKEDITOR.replace('editor1')



	})
</script>



<script>
	$(function() {

		// Replace the <textarea id="editor1"> with a CKEditor

		// instance, using default configuration.

		//CKEDITOR.config.contentsLangDirection = 'rtl'; // This line will make right to left

		CKEDITOR.replace('editor1')



	})
</script>