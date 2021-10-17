<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('video/add'), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık *", flash('val_title'), N, 'required', N, abide_error("Bu alan zorunludur."));
		echo $aswf->v_text("url", "Video Bağlantı Adresi *", flash('val_url'), N, 'required', N, abide_error("Bu alan zorunludur."));

		echo '<div class="form-group video_select_categories">'.selectlist_categories('category[]', flash('val_category')).'</div>';

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', flash('val_status', 1), $statusItems);

		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
