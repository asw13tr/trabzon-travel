<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('page/add'), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık",null,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
		echo $aswf->v_text("keywords", "Anahtar Kelimeler");
		echo $aswf->v_textarea("description", "Açıklama");

		if(isset($pages_list_for_select)){
			array_unshift($pages_list_for_select, "Üst Sayfa");
			echo $aswf->v_select('post_parent', 'Üst Sayfa', 0, $pages_list_for_select);
		}

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', 1, $statusItems);

		echo $aswf->v_file("cover", "Kapak Fotoğrafı");
		echo $aswf->v_ckeditor("content", "İçerik");

		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
