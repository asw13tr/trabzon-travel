<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('realestate/add'), "POST", true, N, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div>';
			echo '<div class="col-sm-12">'.$aswf->v_text("name", "İlan Başlığı*", N, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				$company_list = array(' '=>"Bir Firma Seçiniz");
				foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
				echo '<div class="col-sm-12">'.$aswf->v_select("company", "Tedarikçi Firma <i>(Zorunlu)</i>", ' ', $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
			echo '<div class="clearfix"></div></div>';



			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(' ' => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", ' ', $counties_array, N, 'required').'</div>';



			echo '<div>';
				$estate_status_array = array(' ' => 'Emlak Durumunu Seçin'); if($estate_status_list) foreach($estate_status_list as $item) $estate_status_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("estate_status", "Emlak Durumu", 0, $estate_status_array, N, 'required').'</div>';
				$estate_type_array = array(' ' => 'Emlak Tipini Seçin'); if($estate_type_list) foreach($estate_type_list as $item) $estate_type_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("estate_type", "Emlak Tipi", 0, $estate_type_array, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				$build_status_array = array(' ' => 'Yapı Durumunu Seçin'); if($build_status_list) foreach($build_status_list as $item) $build_status_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("build_status", "Yapı Durumu", 0, $build_status_array, N, 'required').'</div>';
				$build_type_array = array(' ' => 'Yapı Tipini Seçin'); if($build_type_list) foreach($build_type_list as $item) $build_type_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("build_type", "Yapı Tipi", 0, $build_type_array, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';



			echo '<div>';
				$heating_array = array(' ' => 'Isıtma Sistemi Seçin'); if($heating_list) foreach($heating_list as $item) $heating_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("heating", "Isıtma Sistemi", 0, $heating_array, N, 'required').'</div>';
				$room_array = array(' ' => 'Oda Sayısı'); if($room_list) foreach($room_list as $item) $room_array[$item->ref_id] = $item->ref_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("room", "Oda Sayısı", 0, $room_array, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("floor_total", "Toplam Kat").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("floor_number", "Bulunduğu Kat").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("area", "Yüzölçümü <small>m2</small>").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("age", "Yapı Yaşı").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("finish", "Proje Tamamlanma Tarihi").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("video", "Video Linki").'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "İlan Fotoğrafı").'</div>';

			$helpLocationUrl = '<a href="#">Konumumunuzu nasıl ekleyebileceğinizi öğrenin?</a>';
			echo '<div class="col-sm-12">'.$aswf->v_text("location", "Konum").'</div>';

			$statusItems = [ 1=>"Onaylanmış İlan", 0=>"Onaylanmamış İlan" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', 1, $statusItems).'</div>';



			echo '<div class="col-sm-12">'.$aswf->v_ckeditor("description", "Açıklama").'</div>';
		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Otel Özellikleri</label>
		<div class="list_checkboxes">';
		if($features){
		foreach($features as $feature){
			$itemid = seo_link($feature->ref_name.'_'.$feature->ref_id);
				echo '<label for="'.$itemid.'" class="allow_select"><input type="checkbox" name="features[]" value="'.$feature->ref_id.'" id="'.$itemid.'" />'.$feature->ref_name.'</label>';
		}
		}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
