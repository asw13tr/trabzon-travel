<div class="col-md-12"><h3>İlan Görselleri</h3></div>
<div class="col-md-12">
<div class="row">
<?php $totalimg=0; if($realestate_images): $totalimg = count($realestate_images); foreach($realestate_images as $img): ?>
	<div class="col-xs-6 col-sm-3"><div>
		<img src="<?php echo URL_UPLOAD_IMAGES_REALESTATES.$img->rep_image; ?>" style="width:100%; height:170px;" class="img-responsive center-block">
		<a href="<?php echo site_url('realestate/del_img/'.$img->rep_id); ?>" class="btn btn-danger form-control text-center">Görseli Sil</a>
	</div></div>
<?php endforeach; endif; ?>
</div>
</div>
<div class="clearfix"></div>
<?php if($totalimg<4): ?>
<form class="horizontal-form" action="<?php echo site_url('realestate/add_img/'.$estate->re_id); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="p_id" value="<?php echo $estate->re_id; ?>">
	<div class="form-group"></div>
	<div class="col-sm-10 col-xs-9 add_photos_div"><input type="file" name="p_img" class="form-control"></div>
	<div class="col-sm-2 col-xs-3"><button class="btn btn-primary form-control">Yükle</button></div>
</form>
<?php else:
	echo '<br/><p class="alert alert-warning">İlanınız için maksimum resim sayısına ulaştınız. Yeni bir resim ekleyebilmek için resimlerden silmeniz gerekmektedir.</p>';
endif; ?>


<div class="clearfix"></div>




	<?php
		require_once(FCPATH."/extraphp/class_ASWForm.php");
		$aswf = new ASWForm();
		echo $aswf->v_open( url('realestate/edit/'.$estate->re_id), "POST", true, N, 'data-abide novalidate' );
			echo '<div class="col-sm-9">';

				echo '<div>';
				echo '<div class="col-sm-12">'.$aswf->v_text("name", "İlan Başlığı*", $estate->re_name, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>';
				echo '<div class="clearfix"></div></div>';

				echo '<div>';
					$company_list = array(''=>"Bir Firma Seçiniz");
					foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
					echo '<div class="col-sm-12">'.$aswf->v_select("company", "Tedarikçi Firma <i>(Zorunlu)</i>", $estate->re_company, $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
				echo '<div class="clearfix"></div></div>';


				$cities_array = array(0 => "Bir Şehir Seçin");
				if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

				$counties_array = array(' ' => "Bir İlçe Seçin");
				if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", $estate->re_district, $counties_array, N, 'required').'</div>';



				echo '<div>';
					$estate_status_array = array(' ' => 'Emlak Durumunu Seçin'); if($estate_status_list) foreach($estate_status_list as $item) $estate_status_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("estate_status", "Emlak Durumu", $estate->re_estate_status, $estate_status_array, N, 'required').'</div>';
					$estate_type_array = array(' ' => 'Emlak Tipini Seçin'); if($estate_type_list) foreach($estate_type_list as $item) $estate_type_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("estate_type", "Emlak Tipi", $estate->re_estate_type, $estate_type_array, N, 'required').'</div>';
				echo '<div class="clearfix"></div></div>';


				echo '<div>';
					$build_status_array = array(' ' => 'Yapı Durumunu Seçin'); if($build_status_list) foreach($build_status_list as $item) $build_status_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("build_status", "Yapı Durumu", $estate->re_build_status, $build_status_array, N, 'required').'</div>';
					$build_type_array = array(' ' => 'Yapı Tipini Seçin'); if($build_type_list) foreach($build_type_list as $item) $build_type_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("build_type", "Yapı Tipi", $estate->re_build_type, $build_type_array, N, 'required').'</div>';
				echo '<div class="clearfix"></div></div>';



				echo '<div>';
					$heating_array = array(' ' => 'Isıtma Sistemi Seçin'); if($heating_list) foreach($heating_list as $item) $heating_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("heating", "Isıtma Sistemi", $estate->re_heating, $heating_array, N, 'required').'</div>';
					$room_array = array(' ' => 'Oda Sayısı'); if($room_list) foreach($room_list as $item) $room_array[$item->ref_id] = $item->ref_name;
					echo '<div class="col-sm-6">'.$aswf->v_select("room", "Oda Sayısı", $estate->re_room, $room_array, N, 'required').'</div>';
				echo '<div class="clearfix"></div></div>';


				echo '<div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("floor_total", "Toplam Kat", $estate->re_floor_total).'</div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("floor_number", "Bulunduğu Kat", $estate->re_floor_number).'</div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("area", "Yüzölçümü <small>m2</small>", $estate->re_area).'</div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("age", "Yapı Yaşı", $estate->re_age).'</div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("finish", "Proje Tamamlanma Tarihi", $estate->re_finish).'</div>';
					echo '<div class="col-sm-6">'.$aswf->v_text("video", "Video Linki", $estate->re_video).'</div>';
				echo '<div class="clearfix"></div></div>';

				echo '<div class="col-sm-12">'.$aswf->v_file("cover", "İlan Fotoğrafı",$estate->re_cover).'</div>';

				$helpLocationUrl = '<a href="#">Konumumunuzu nasıl ekleyebileceğinizi öğrenin?</a>';
				echo '<div class="col-sm-12">'.$aswf->v_text("location", "Konum", $estate->re_location).'</div>';

				$statusItems = [ 1=>"Onaylanmış İlan", 0=>"Onaylanmamış İlan" ];
				echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', $estate->re_status, $statusItems).'</div>';



				echo '<div class="col-sm-12">'.$aswf->v_ckeditor("description", "Açıklama", $estate->re_description).'</div>';
			echo '</div>';

			echo '<div class="col-sm-3 form-group">
			<label for="">Emlak Özellikleri</label>
			<div class="list_checkboxes">';
			if($features){
			$selected_features = json_decode( $estate->re_features, true);
			foreach($features as $feature){
				$itemid = seo_link($feature->ref_name.'_'.$feature->ref_id);
				$selected = in_array( $feature->ref_id, $selected_features )? ' checked="checked"' : null ;
				echo '<label for="'.$itemid.'" class="allow_select"><input type="checkbox" name="features[]"'.$selected.' value="'.$feature->ref_id.'" id="'.$itemid.'" />'.$feature->ref_name.'</label>';
			}
			}
			echo '</div></div>';

			echo '<div class="clearfix"></div>';
			echo $aswf->v_save("Güncelle");
		echo $aswf->close();
	?>
