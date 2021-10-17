<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('category/add'), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık",null,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
		echo $aswf->v_text("keywords", "Anahtar Kelimeler");
		echo $aswf->v_file("cover", "Kapak Fotoğrafı", null,null,null,null, null, true);


		$kategori_listesi[0] = "Kategori Seçin";
		foreach($categories_list_for_select as $k => $v){ $kategori_listesi[$k] = $v; }
		echo $aswf->v_select('category_parent', 'Üst Kategori', 0, $kategori_listesi);

		$statusItems = [ 'yes'=>"İçerik Yazıları Listelensin", 'no'=>"Alt Kategoriler Listelensin" ];
		echo $aswf->v_select('show_posts', 'Bu Kategori Altında', 1, $statusItems);

		echo $aswf->v_textarea("description", "Açıklama");

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', 1, $statusItems);

		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
