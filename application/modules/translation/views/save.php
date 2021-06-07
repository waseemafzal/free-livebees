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
			Translation Managment

		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
			<li> <a href="translation">View Translation </a></li>
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
									<label for="exampleInputEmail1">Category</label>

									<select class="form-control" name="cat_id">
										<option value="0">others</option>
										<?php
										$selected = '';
										foreach ($categories as $cat) {
											if (isset($row)) {
												if ($cat['id'] == $row->cat_id) {
													$selected = 'selected="selected"';
												} else {
													$selected = '';
												}
											}

										?>
											<option <?= $selected ?> value="<?= $cat['id'] ?>"><?php echo $cat['title'] ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-xs-12 col-md-6">
									<label for="exampleInputEmail1">Conversion Key</label>

									<input type="text" class="form-control" placeholder="Conversion Key Should be Unique" name="tkey" id="tkey" value="<?php if (isset($row)) {
																									echo $row->tkey;
																								}  ?>" />

								</div>
								<div class="clearfix">&nbsp;</div>
								<div class="col-xs-12 col-md-12">
									<label for="exampleInputEmail1">English Sentence</label>

									<textarea rows="4" class="form-control" id="ens" name="ens"><?php if (isset($row)) {
																		echo $row->english;
																	}  ?></textarea>

								</div>



								<div class="clearfix">&nbsp;</div>
								<div class="col-xs-12 col-md-12">
									<label for="exampleInputEmail1">French Sentence</label>

									<textarea rows="4" class="form-control" id="frs" name="frs"><?php if (isset($row)) {
																		echo $row->french;
																	}  ?></textarea>

								</div>
								<div class="clearfix">&nbsp;</div>



								<br>
								<div id="add_images_wrap" class="col-xs-12 col-md-12 other_wrap">
									<label class="hidden">Banner</small></label>
									<input class="hidden" type="file" name="file[]" class=" file" id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif">


									<?php
									if (isset($row)) {
										$post_id = $row->id;
										$where = array('post_id' => $post_id);
										$ImgData = get_by_where_array($where, 'post_images');

										foreach ($ImgData->result() as $Imgrow) {
											$src = base_url() . 'uploads/' . $Imgrow->file; { ?>
												<div class="col-xs-4 col-md-2  box-primary  img_wrap_<?php echo $Imgrow->id ?>">
													<img id="img_<?php echo $Imgrow->id ?>" src="<?php echo $src ?>" class="img-responsive"><br>
													<center>
														<a onclick="getImage('<?php echo $Imgrow->id ?>','post_images')" class="btn btn-xs btn-success" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Edit">
															<i class="fa fa-pencil"></i></a>
														<a class="btn btn-xs btn-danger" onclick="deleteImage('<?php echo $Imgrow->id ?>','post_images')" href="javascript:void(0)" data-toggle="tooltip" title="" style="overflow: hidden; position: relative;" data-original-title="Delete"><i class="fa fa-times"></i>
														</a>
													</center>

												</div>
									<?php }
										}
									}
									?>
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
		if ($('#tkey').val() == '') {
			alert('Please Input Conversion Key');
			return false;
		}
		if ($('#ens').val() == '') {
			alert('Please Input english sentence');
			return false;
		}
		if ($('#frs').val() == '') {
			alert('Please Input French sentence');
			return false;
		}
		var formData = new FormData();
		// make sure there is file(s) to upload




		var other_data = $('#form_add_update').serializeArray();
		$.each(other_data, function(key, input) {
			formData.append(input.name, input.value);
		});
		/*	post_description = CKEDITOR.instances.editor1.getData();
					formData.append("post_description", post_description);
		*/
		// ajax start
		$.ajax({
			type: "POST",
			url: "<?php echo base_url() . 'translation/save'; ?>",
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
				if (data.status == 200) {
					$(".alert").addClass('alert-success');
					$(".alert").html(data.message);
					$(".alert").removeClass('hidden');
					setTimeout(function() {
						$(".alert").addClass('hidden');
						//	$('#form_add_update')[0].reset();
					}, 3000);
				} else if (data.status == 100) {
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
						window.location = 'leprojects';
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