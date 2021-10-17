<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('video/edit/'.$video->video_id), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık", $video->video_title, N, 'required', N, abide_error("Bu alan zorunludur."));
		echo $aswf->v_text("url", "Video Bağlantı Adresi", $video->video_url, N, 'required', N, abide_error("Bu alan zorunludur."));

		echo '<div class="form-group video_select_categories">'.selectlist_categories('category[]', json_decode($video->video_category, true)).'</div>';

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', $video->video_status, $statusItems);

		echo $aswf->v_save("Güncelle");
	echo $aswf->close();
?>
