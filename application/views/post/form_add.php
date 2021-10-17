<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('post/add'), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';
			echo $aswf->v_text("title", "Başlık",null,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
			echo $aswf->v_text("keywords", "Anahtar Kelimeler");
			echo $aswf->v_textarea("description", "Açıklama");

			$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
			echo $aswf->v_radio('status', 'Yayım Durumu', 1, $statusItems);

			echo $aswf->v_file("cover", "Kapak Fotoğrafı");
			echo $aswf->v_ckeditor("content", "İçerik");
		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Yazı Kategorisi</label>
		<div class="list_checkboxes">';
		if($categories){
		foreach($categories as $category){
			$itemid = seo_link($category->category_name.'_'.$category->category_id);
			if( $category->category_show_posts=="yes" ){
				echo '<label for="'.$itemid.'" class="allow_select">'.$category->category_empty.'<input type="checkbox" name="categories[]" value="'.$category->category_id.'" id="'.$itemid.'" />'.$category->category_name.'</label>';
			}else{
				echo '<label for="'.$itemid.'" class="deny_select">'.$category->category_empty.'<input type="checkbox" disabled id="'.$itemid.'" />'.$category->category_name.'</label>';
			}
		}
		}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
