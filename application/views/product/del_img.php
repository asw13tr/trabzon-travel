<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('product/del_img/'.$img->pp_id.'/'.$img->pp_product), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-4 p0"><img src="'.URL_UPLOAD_IMAGES_PRODUCTS.$img->pp_image.'" class="img-responsive" /></div><div class="clearfix"></div>
		<h3>Bu fotoğrafı silmek istediğinize emin misiniz?</h3>';
		echo '<input type="hidden" name="img_id" value="'.$img->pp_id.'" />';
		echo $aswf->v_save("Eminim Sil");
		echo '<a href="'.url('product/edit/'.$img->pp_product).'">Silmekten Vazgeç</a>';
	echo $aswf->close();
?>
