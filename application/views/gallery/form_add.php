<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('gallery/add'), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Galeri Başlığı", flash('val_title'), null, 'required', null, abide_error("Bu alan zorunludur."));
		echo $aswf->v_file("cover", "Kapak Fotoğrafı", N, N, 'required', N, abide_error("Bu alan zorunludur."));
		echo '<div class="form-group video_select_categories">'.selectlist_categories('category[]', flash('val_category')).'</div>';

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', flash('val_status', 1), $statusItems);

		echo $aswf->v_save("Galeriyi oluştur ve devam et");
	echo $aswf->close();
	require(__DIR__.'/javascript.php')
?>
