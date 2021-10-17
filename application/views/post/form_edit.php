<?php

	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('post/edit/'.$post->post_id), "POST", true, null, 'data-abide novalidate' );

		echo '<div class="col-sm-9">';
			echo $aswf->v_text("title", "Başlık",$post->post_title,null, 'required',null, abide_error("Bu alana en az 3 karakterlik birşeyler girmelisiniz."));
			echo $aswf->v_text("keywords", "Anahtar Kelimeler",$post->post_keywords);
			echo $aswf->v_textarea("description", "Açıklama", $post->post_description);

			$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
			echo $aswf->v_radio('status', 'Yayım Durumu', $post->post_status, $statusItems);

			echo $aswf->v_file("cover", "Kapak Fotoğrafı", $post->post_cover);
			echo $aswf->v_ckeditor("content", "İçerik", $post->post_content);
		echo '</div>';


		echo '<div class="col-sm-3 form-group"><label for="">Yazı Kategorisi</label><div class="list_checkboxes">';
			if($categories){
			foreach($categories as $category){
				$itemid = seo_link($category->category_name.'_'.$category->category_id);
				if( $category->category_show_posts=="yes" ){
					$seleced = !in_array($category->category_id, $selected_categories)? null : ' checked';
					echo '<label for="'.$itemid.'" class="allow_select">'.$category->category_empty.'<input type="checkbox"'.$seleced.' name="categories[]" value="'.$category->category_id.'" id="'.$itemid.'" />'.$category->category_name.'</label>';
				}else{
					echo '<label for="'.$itemid.'" class="deny_select">'.$category->category_empty.'<input type="checkbox" disabled id="'.$itemid.'" />'.$category->category_name.'</label>';
				}
			}
			}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Güncelle");
	echo $aswf->close();
?>
