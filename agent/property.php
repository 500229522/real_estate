<!-- <?php 
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT r.*,t.name as rtype FROM `real_estate_list` r inner join `type_list` t on r.type_id = t.id where r.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
        if(isset($id)){
            $meta_qry = $conn->query("SELECT * FROM `real_estate_meta` where real_estate_id = '{$id}'");
            while($row = $meta_qry->fetch_assoc()){
                ${$row['meta_field']} = $row['meta_value'];
            }

            $amenity_ids = [];
            $amentiy_qry = $conn->query("SELECT * FROM `amenity_list` where id in (SELECT `amenity_id` FROM `real_estate_amenities` where real_estate_id = '{$id}') order by `name`");
            while($row = $amentiy_qry->fetch_assoc()){
                $amenity_ids[] = $row['id'];
            }
        }
        if(isset($agent_id)){
            $agent_det = [];
            $agent = $conn->query("SELECT *,CONCAT(lastname,', ', firstname, ' ', COALESCE(middlename,''))as fullname FROM `agent_list` where id = '{$agent_id}' ");
            $agent_det = $agent->fetch_array();
        }
    }else{
        echo '<script> alert("Unknown Real Estate\'s ID."); location.replace("./?page=real_estate"); </script>';
    }
}
?> -->
<style>
    img#cimg{
		max-height: 20vh;
		width: 100%;
		object-fit: scale-down;
		object-position: center center;
	}
</style>
<div class="card card-outline rounded-0 card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Add New " ?> Estate</h3>
	</div>
	<div class="card-body">
		<form action="" id="estate-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="control-label">Estate Name</label>
                    <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" required value="<?php echo isset($name) ?$name : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="type_id" class="control-label">Real Estate Type</label>
                    <select name="type_id" id="type_id" class="form-control form-control-sm rounded-0" required>
                    <option value=""></option>
                    <?php
                        $qry = $conn->query("SELECT * FROM `property_types` where deleted_date is null order by `type` asc");
                        while($row= $qry->fetch_assoc()):
                    ?>
                    <option value="<?php echo $row['id'] ?>" <?php echo isset($type_id) && $type_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['type'] ?></option>
                    <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="purpose" class="control-label">Purpose</label>
                    <select name="purpose" id="purpose" class="form-control form-control-sm rounded-0" required="required">
                        <option>For Sale</option>
                        <option>For Rent</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="area" class="control-label">Area</label>
                    <input type="text" name="area" id="area" class="form-control form-control-sm rounded-0" required value="<?php echo isset($area) ?$area : '' ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="sale_price" class="control-label">Price</label>
                    <input type="text" name="sale_price" id="sale_price" class="form-control form-control-sm rounded-0" required value="<?php echo isset($sale_price) ?$sale_price : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="amenity_ids" class="control-label">Amenities</label>
                    <select name="amenity_ids[]" id="amenity_ids" class="form-control form-control-sm -rounded-0 select2" multiple required>
                        <option value=""></option>
                        <?php
                            $qry = $conn->query("SELECT * FROM `amenities` where deleted_date is null order by `amenity` asc");
                            while($row= $qry->fetch_assoc()):
                        ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($type_id) && isset($amenity_ids) && in_array($type_id,$amenity_ids) ? 'selected' : '' ?>><?php echo $row['amenity'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="address_line1" class="control-label">Address<sup></sup></label>
                    <input name="address_line1" id="address_line1" class="form-control form-control-sm rounded-0" value="<?=isset($address_line1) ? $address_line1 : "" ?>"></input>
                </div>
                <div class="col-md-6">
                    <label for="city" class="control-label">City<sup></sup></label>
                    <input name="city" id="city" class="form-control form-control-sm rounded-0" value="<?=isset($city) ? $city : "" ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="postal_code" class="control-label">Postal Code<sup></sup></label>
                    <input name="postal_code" id="postal_code" class="form-control form-control-sm rounded-0" value="<?=isset($postal_code) ? $postal_code : "" ?>"></input>
                </div>
                <div class="col-md-6">
                    <label for="country" class="control-label">Country<sup></sup></label>
                    <input name="country" id="country" class="form-control form-control-sm rounded-0" value="<?=isset($country) ? $country : "" ?>"></input>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="coordinates" class="control-label">Map Coordinates</label>
                    <input type="text" name="coordinates" id="coordinates" class="form-control form-control-sm rounded-0" required value="<?php echo isset($coordinates) ?$coordinates : '' ?>" />
                </div>
                <div class="col-md-6">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-control form-control-sm rounded-0">
                        <option value="active" <?php echo isset($status) && $status == "active" ? 'selected' : '' ?>>Active</option>
                        <option value="pending" <?php echo isset($status) && $status == "pending" ? 'selected' : '' ?>>Pending</option>
                        <option value="sold" <?php echo isset($status) && $status == "sold" ? 'selected' : '' ?>>Sold</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea name="description" id="" cols="5" rows="2" class="form-control form no-resize summernote"><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>

            <div class="row">
                <div class="col-md-6">
                    <label for="" class="control-label">Thumbnail</label>
                    <div class="custom-file custom-file-sm rounded-0">
                        <input type="hidden" name="thumbnail_path" value="<?= isset($thumbnail_path) ? $thumbnail_path : "" ?>">
                        <input type="file" class="custom-file-input rounded-0 form-control-sm" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
                        <label class="custom-file-label rounded-0" for="customFile">Choose file</label>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo validate_image(isset($thumbnail_path) ? $thumbnail_path : "") ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="" class="control-label">Other Images</label>
                    <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="imgs[]" multiple accept="image/png, image/jpeg" onchange="displayImg2(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="row my-3">
                    <?php 
                    if(isset($id)):
                    $upload_path = "uploads/estate_".$id;
                    if(is_dir(base_app.$upload_path)): 
                    ?>
                    <?php 
                    
                        $file= scandir(base_app.$upload_path);
                        foreach($file as $img):
                            if(in_array($img,array('.','..')))
                                continue;
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="d-flex align-items-center img-item w-100">
                            <span><img src="<?php echo base_url.$upload_path.'/'.$img ?>" width="150px" height="100px" style="object-fit:cover;" class="img-thumbnail" alt=""></span>
                            <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_img" type="button" data-path="<?php echo base_app.$upload_path.'/'.$img ?>"><i class="fa fa-trash"></i></button></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="estate-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=dashboard">Cancel</a>
	</div>
</div>
<script>
     function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        	_this.siblings('label', input.files[0].name);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }else{
			$('#cimg').attr('src', "<?php echo validate_image('') ?>");
            _this.siblings('label','Choose File');
		}
	}
    function displayImg2(input,_this) {
        console.log(input.files)
        var fnames = []
        Object.keys(input.files).map(k=>{
            fnames.push(input.files[k].name)
        })
        _this.siblings('.custom-file-label').html(fnames.join(", "))
	    
	}
    function delete_img($path){
        start_loader()
        
        $.ajax({
            url: _base_url_+'classes/Master.php?f=delete_img',
            data:{path:$path},
            method:'POST',
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured while deleting an Image","error");
                end_loader()
            },
            success:function(resp){
                $('.modal').modal('hide')
                if(typeof resp =='object' && resp.status == 'success'){
                    $('[data-path="'+$path+'"]').closest('.img-item').hide('slow',function(){
                        $('[data-path="'+$path+'"]').closest('.img-item').remove()
                    })
                    alert_toast("Image Successfully Deleted","success");
                }else{
                    console.log(resp)
                    alert_toast("An error occured while deleting an Image","error");
                }
                end_loader()
            }
        })
    }
	$(document).ready(function(){
        $('.rem_img').click(function(){
            _conf("Are sure to delete this image permanently?",'delete_img',["'"+$(this).attr('data-path')+"'"])
        })
       
        $('.select2').select2({placeholder:"Please Select here",width:"relative"})
        if(parseInt("<?php echo isset($category_id) ? $category_id : 0 ?>") > 0){
            console.log('test')
            start_loader()
            setTimeout(() => {
                $('#category_id').trigger("change");
                end_loader()
            }, 750);
        }
		$('#estate-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_estate",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=real_estate/view_estate&id="+resp.eid;
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            if(!!resp.id)
                            $('[name="id"]').val(resp.id)
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
		        height: 100,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'codeview', 'help' ] ]
		        ]
		    })
	})
</script>