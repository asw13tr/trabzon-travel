<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('tour/del_img/'.$img->tp_id.'/'.$img->tp_tour), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-4 p0"><img src="'.URL_UPLOAD_IMAGES_TOURS.$img->tp_image.'" class="img-responsive" /></div><div class="clearfix"></div>
		<h3>Bu fotoğrafı silmek istediğinize emin misiniz?</h3>';
		echo '<input type="hidden" name="img_id" value="'.$img->tp_id.'" />';
		echo $aswf->v_save("Eminim Sil");
		echo '<a href="'.url('tour/edit/'.$img->tp_tour).'">Silmekten Vazgeç</a>';
	echo $aswf->close();
?>
