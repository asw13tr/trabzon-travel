<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('company/add'), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("name", "*Firma Adı", null, null, 'required', null, abide_error("Bu alan zorunludur.")).'</div>';
			$company_username_error = "Firma kullanıcı adında hata.<br/>1) Kullanıcı adını girdiğinizden emin olun.<br/>2) Kullanıcı adınızın (harf, rakam, _, - veya .) dan başka karakter içermediğinden emin olun.";
			echo '<div class="col-sm-6">'.$aswf->v_text("username", "*Firma Girişi İçin Kullanıcı Adı", null, null, 'required pattern="[a-zA-Z0-9_-.]+"', null, abide_error($company_username_error)).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_password("password", "*Firma giriş şifresi",N,N,'required minlength="6"',N,abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_password("repassword", "*Firma giriş şifresini tekrar yazın",N,N,'required minlength="6" data-equalto="password"',N,abide_error("Şifreler Uyuşmuyor yada bu alan boş bırakılmış.")).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Firma Logosu").'</div>';


			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("owner", "Firma Yetkilisi").'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_text("date", "Firmanın Kuruluş Tarihi").'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_tel("phone", "*Telefon", N, N, 'required',N,abide_error("Telefon numarası zorunludur.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_tel("fax", "Fax").'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
			echo '<div class="col-sm-6">'.$aswf->v_mail("email", "*E-posta Adresi", N, N, 'required pattern="email"',N,abide_error("E-posta Adresi Hatalı veya Boş Bırakılmış.")).'</div>';
			echo '<div class="col-sm-6">'.$aswf->v_url("website", "Website Adresi", N, N, 'pattern="url"', N, abide_error("Website adresi hatalı: http://siteismi.uzantı şeklinde deneyin.")).'</div>';
			echo '<div class="clearfix"></div></div>';

			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(0 => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", 0, $counties_array).'</div>';




			echo '<div class="col-sm-12">'.$aswf->v_textarea("address", "Adres").'</div>';
			$helpLocationUrl = '<a href="#">Konumumunuzu nasıl ekleyebileceğinizi öğrenin?</a>';
			echo '<div class="col-sm-12">'.$aswf->v_text("location", "Konum").'</div>';

			$statusItems = [ 1=>"Onaylanmış Firma", 0=>"Onaylanmamış Firma" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', 1, $statusItems).'</div>';

			$premiumItems = [ 1=>"Premium Hesap", 0=>"Ücretsiz Hesap" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('premium', 'Hesap Türü', 0, $premiumItems).'</div>';

			echo '
			<div class="clearfix"></div>
			<div class="col-xs-12"><h5><b>Mesai Gün ve Saatleri</b></h5></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Pazartesi</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_1g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_1c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Salı</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_2g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_2c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Çarşamba</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_3g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_3c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Perşembe</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_4g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_4c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Cuma</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_5g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_5c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Cumartesi</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_6g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_6c"/></div>
			</div></div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2"><div class="form-group"><label for="" class="control-label">Pazar</label>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Giriş Saati" name="saat_7g"/></div>
					<div class="col-xs-6 col-sm-12 p0"><input type="text" class="form-control" placeholder="Çıkış Saati" name="saat_7c"/></div>
			</div></div>
			<div class="clearfix"></div>
			';

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
		<label for="">Firma Kategorisi</label>
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
