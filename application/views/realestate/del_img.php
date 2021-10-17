<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('realestate/del_img/'.$img->rep_id.'/'.$img->rep_estate), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-4 p0"><img src="'.URL_UPLOAD_IMAGES_REALESTATES.$img->rep_image.'" class="img-responsive" /></div><div class="clearfix"></div>
		<h3>Bu fotoğrafı silmek istediğinize emin misiniz?</h3>';
		echo '<input type="hidden" name="img_id" value="'.$img->rep_id.'" />';
		echo $aswf->v_save("Eminim Sil");
		echo '<a href="'.url('realestate/edit/'.$img->rep_estate).'">Silmekten Vazgeç</a>';
	echo $aswf->close();
?>
