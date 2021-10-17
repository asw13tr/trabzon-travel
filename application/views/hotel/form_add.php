<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('hotel/add'), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("name", "*Otel Adı", null, null, 'required', null, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("phone", "Otel Telefonu").'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("email", "Otel E-posta").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("website", "Otel Website").'</div>';
			echo '<div class="clearfix"></div></div>';




			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Otel Logosu").'</div>';


			echo '<div>';
			global $hotelTypes;
			echo '<div class="col-sm-6">'.$aswf->v_select("type", "Konaklama Türü", 1, $hotelTypes).'</div>';
			global $hotelStars;
			echo '<div class="col-sm-6">'.$aswf->v_select("stars", "Yıldız Sayısı", '-', $hotelStars).'</div>';
			echo '<div class="clearfix"></div></div>';


			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(' ' => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", ' ', $counties_array).'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_textarea("address", "Adres").'</div>';
			$helpLocationUrl = '<a href="#">Konumumunuzu nasıl ekleyebileceğinizi öğrenin?</a>';
			echo '<div class="col-sm-12">'.$aswf->v_text("location", "Konum").'</div>';

			$statusItems = [ 1=>"Onaylanmış Firma", 0=>"Onaylanmamış Firma" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', 1, $statusItems).'</div>';

			$premiumItems = [ 1=>"Premium Hesap", 0=>"Ücretsiz Hesap" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('premium', 'Hesap Türü', 0, $premiumItems).'</div>';

			echo '<div class="col-xs-12"><h5><strong>Sosyal Medya Hesap Linkleri</strong></h5><div class="clearfix"></div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[facebook]", "Facebook").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[twitter]", "Twitter").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[google_plus]", "Google+").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[linkedin]", "Linkedin").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[youtube]", "Youtube").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[instagram]", "Instagram").'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div class="col-sm-12">'.$aswf->v_ckeditor("description", "Firma Hakkında").'</div>';
		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Otel Özellikleri</label>
		<div class="list_checkboxes">';
		if($features){
		foreach($features as $feature){
			$itemid = seo_link($feature->feature_name.'_'.$feature->feature_id);
				echo '<label for="'.$itemid.'" class="allow_select"><input type="checkbox" name="features[]" value="'.$feature->feature_id.'" id="'.$itemid.'" />'.$feature->feature_name.'</label>';
		}
		}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
