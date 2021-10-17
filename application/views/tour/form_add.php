<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('tour/add'), "POST", true, N, 'data-abide novalidate' );
		echo '<div class="col-sm-12">';

			echo '<div>';
			echo '<div class="col-sm-12">'.$aswf->v_text("name", "Tur Başlığı*", N, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				$company_list = array(' '=>"Bir Firma Seçiniz");
				foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
				echo '<div class="col-sm-12">'.$aswf->v_select("company", "Tedarikçi Firma <i>(Zorunlu)</i>", ' ', $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
			echo '<div class="clearfix"></div></div>';


			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'required').'</div>';

			$category_list = array(' '=>"Bir Kategori Seçiniz");
			foreach($categories as $category) $category_list[$category->tf_id] = $category->tf_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("category", "Tur Kategorisi <i>(Zorunlu)</i>", ' ', $category_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';



			echo '<div>';
				echo '<div class="col-sm-12">'.$aswf->v_text("price", "Tur Fiyatı").'</div>';
			echo '<div class="clearfix"></div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("start_date", "Tur Başlangıç Tarihi").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("end_date", "Tur Bitiş Tarihi").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("start_time", "Tur Başlangıç Saati").'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("end_time", "Tur Bitiş Saati").'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Tur Kapak Fotoğrafı").'</div>';

			$statusItems = [ 1=>"Onaylanmış İlan", 0=>"Onaylanmamış İlan" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', 1, $statusItems).'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_textarea("description", "Tur Hakkında Açıklama Yazısı Girin").'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("visits", "Tur boyunca ziyaret edilecek yerleri alt alta yazın").'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("inc_services", "Tura dahil olan hizmetleri alt alta yazın").'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("exc_services", "Tur içinde fiyata dahil olmayan hizmetleri yazın").'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("suggestions", "Tura katılacak olan kişilere önerilerinizi yazın").'</div>';

		echo '</div>';


		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
