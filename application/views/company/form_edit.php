<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('company/edit/'.$company->company_id), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div class="col-sm-12">
				<br/>
				<a href="'.site_url("company/changepass/".$company->company_id).'" class="alert alert-primary col-xs-12">Şifre değiştirme işlemi için buraya tıklayınız.</a>
				<div class="clearfix"></div>
				<br/><br/>
				</div>
				<div class="clearfix"></div>';

			echo '<div class="col-sm-6">'.$aswf->v_text("name", "Firma Adı", $company->company_name, null, 'required', null, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("username", "Firma Girişi İçin Kullanıcı Adı", $company->company_username,null,"disabled").'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Firma Logosu", $company->company_logo).'</div>';

			echo '<div class="col-sm-6">'.$aswf->v_text("owner", "Firma Yetkilisi", $company->company_owner).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("date", "Firmanın Kuruluş Tarihi", $company->company_date).'</div>';

			echo '<div class="col-sm-6">'.$aswf->v_text("phone", "Telefon", $company->company_phone, N, 'required',N,abide_error("Telefon numarası zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("fax", "Fax", $company->company_fax).'</div>';

			echo '<div class="col-sm-6">'.$aswf->v_text("email", "E-posta Adresi", $company->company_email, N, 'required pattern="email"',N,abide_error("E-posta Adresi Hatalı veya Boş Bırakılmış.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("website", "Website Adresi", $company->company_website, N, 'pattern="url"', N, abide_error("Website adresi hatalı: http://siteismi.uzantı şeklinde deneyin.")).'</div>';


			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(0 => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", $company->company_district, $counties_array).'</div>';




			echo '<div class="col-sm-12">'.$aswf->v_textarea("address", "Adres", $company->company_address).'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("location", "Konum", $company->company_location).'</div>';

			$hours = json_decode($company->company_hours,true);
			echo '
			<div class="clearfix"></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Pazartesi</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_1g" value="'.$hours[1][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_1c" value="'.$hours[1][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Salı</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_2g" value="'.$hours[2][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_2c" value="'.$hours[2][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Çarşamba</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_3g" value="'.$hours[3][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_3c" value="'.$hours[3][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Perşembe</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_4g" value="'.$hours[4][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_4c" value="'.$hours[4][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Cuma</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_5g" value="'.$hours[5][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_5c" value="'.$hours[5][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Cumartesi</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_6g" value="'.$hours[6][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_6c" value="'.$hours[6][1].'"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Pazar</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_7g" value="'.$hours[7][0].'"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_7c" value="'.$hours[7][1].'"/></div>
			</div></div>
			';

			if(!$company->company_socials){
				$social = json_decode(json_encode(array(
					'facebook' 		=> null,
					'twitter' 		=> null,
					'google_plus' 	=> null,
					'linkedin' 		=> null,
					'youtube' 		=> null,
					'instagram' 	=> null
				)));
			}else{
				$social =json_decode($company->company_socials);
			}
			echo '<div class="col-xs-12"><h5><strong>Sosyal Medya Hesap Linkleri</strong></h5><div class="clearfix"></div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[facebook]", "Facebook", $social->facebook).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[twitter]", "Twitter", $social->twitter).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[google_plus]", "Google+", $social->google_plus).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[linkedin]", "Linkedin", $social->linkedin).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[youtube]", "Youtube", $social->youtube).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("socials[instagram]", "Instagram", $social->instagram).'</div>';
			echo '<div class="clearfix"></div></div>';

			$statusItems = [ 1=>"Onaylanmış Firma", 0=>"Onaylanmamış Firma" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', $company->company_status, $statusItems).'</div>';

			$premiumItems = [ 1=>"Premium Hesap", 0=>"Ücretsiz Hesap" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('premium', 'Hesap Türü', $company->company_premium, $premiumItems).'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_ckeditor("description", "Firma Hakkında", $company->company_description).'</div>';
		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Firma Kategorisi</label>
		<div class="list_checkboxes">';
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
