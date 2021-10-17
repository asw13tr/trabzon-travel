<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('category/edit/'.$category->category_id), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Başlık",$category->category_name,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
		echo $aswf->v_text("keywords", "Anahtar Kelimeler", $category->category_keywords);

		echo $aswf->v_file("cover", "Kapak Fotoğrafı", $category->category_cover,null,null,null, $content=abide_error("Bir resim seçmelisiniz."), "required");

		$kategori_listesi[0] = "Kategori Seçin";
		foreach($categories_list_for_select as $k => $v){ $kategori_listesi[$k] = $v; }
		echo $aswf->v_select('category_parent', 'Üst Kategori', $category->category_parent, $kategori_listesi);

		$statusItems = [ 'yes'=>"İçerik Yazıları Listelensin", 'no'=>"Alt Kategoriler Listelensin" ];
		echo $aswf->v_select('show_posts', 'Bu Kategori Altında', $category->category_show_posts, $statusItems);

		echo $aswf->v_textarea("description", "Açıklama", $category->category_description);

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', $category->category_status, $statusItems);

		echo $aswf->v_save("Düzenle");
	echo $aswf->close();
?>
