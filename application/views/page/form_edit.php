<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('page/edit/'.$post->post_id), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık",$post->post_title,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
		echo $aswf->v_text("keywords", "Anahtar Kelimeler",$post->post_keywords);
		echo $aswf->v_textarea("description", "Açıklama", $post->post_description);

		if(isset($pages_list_for_select)){
			array_unshift($pages_list_for_select, "Üst Sayfa");
			echo $aswf->v_select('post_parent', 'Üst Sayfa', $post->post_parent, $pages_list_for_select);
		}

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', $post->post_status, $statusItems);

		echo $aswf->v_file("cover", "Kapak Fotoğrafı", $post->post_cover);
		echo $aswf->v_ckeditor("content", "İçerik", $post->post_content);

		echo $aswf->v_save("Güncelle");
	echo $aswf->close();
?>
