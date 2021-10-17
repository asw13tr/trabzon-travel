<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('hotel/edit/'.$hotel->hotel_id), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("name", "*Otel Adı", $hotel->hotel_name, null, 'required', null, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("phone", "Otel Telefonu", $hotel->hotel_phone).'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("email", "Otel E-posta", $hotel->hotel_email).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("website", "Otel Website", $hotel->hotel_website).'</div>';
			echo '<div class="clearfix"></div></div>';




			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Otel Logosu", $hotel->hotel_cover).'</div>';


			echo '<div>';
			global $hotelTypes;
			echo '<div class="col-sm-6">'.$aswf->v_select("type", "Konaklama Türü", $hotel->hotel_type, $hotelTypes).'</div>';
			global $hotelStars;
			echo '<div class="col-sm-6">'.$aswf->v_select("stars", "Yıldız Sayısı", $hotel->hotel_star, $hotelStars).'</div>';
			echo '<div class="clearfix"></div></div>';


			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(' ' => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", $hotel->hotel_district, $counties_array).'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_textarea("address", "Adres", $hotel->hotel_address).'</div>';
			$helpLocationUrl = '<a href="#">Konumumunuzu nasıl ekleyebileceğinizi öğrenin?</a>';
			echo '<div class="col-sm-12">'.$aswf->v_text("location", "Konum", $hotel->hotel_location).'</div>';

			$statusItems = [ 1=>"Onaylanmış Firma", 0=>"Onaylanmamış Firma" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', $hotel->hotel_status, $statusItems).'</div>';

			$premiumItems = [ 1=>"Premium Hesap", 0=>"Ücretsiz Hesap" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('premium', 'Hesap Türü', $hotel->hotel_premium, $premiumItems).'</div>';

			if(!$hotel->hotel_socials){
				$social = json_decode(json_encode(array(
					'facebook' 		=> null,
					'twitter' 		=> null,
					'google_plus' 	=> null,
					'linkedin' 		=> null,
					'youtube' 		=> null,
					'instagram' 	=> null
				)));
			}else{
				$social =json_decode($hotel->hotel_socials);
			}
			echo '<div class="col-xs-12"><h5><strong>Sosyal Medya Hesap Linkleri</strong></h5><div class="clearfix"></div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[facebook]", "Facebook", @$social->facebook).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[twitter]", "Twitter", @$social->twitter).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[google_plus]", "Google+", @$social->google_plus).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[linkedin]", "Linkedin", @$social->linkedin).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[youtube]", "Youtube", @$social->youtube).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[instagram]", "Instagram", @$social->instagram).'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div class="col-sm-12">'.$aswf->v_ckeditor("description", "Firma Hakkında", $hotel->hotel_about).'</div>';
		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Otel Özellikleri</label>
		<div class="list_checkboxes">';
		if($features){
		$selected_features = json_decode( $hotel->hotel_features, true);
		foreach($features as $feature){
			$itemid = seo_link($feature->feature_name.'_'.$feature->feature_id);
			$selected = in_array( $feature->feature_id, $selected_features )? ' checked="checked"' : null ;
			echo '<label for="'.$itemid.'" class="allow_select"><input type="checkbox" name="features[]"'.$selected.' value="'.$feature->feature_id.'" id="'.$itemid.'" />'.$feature->feature_name.'</label>';
		}
		}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Güncelle");
	echo $aswf->close();
?>
