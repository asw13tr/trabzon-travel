<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('rentacar/edit/'.$car->car_id), "POST", true, null, 'data-abide novalidate' );
		echo '<div class="col-sm-9">';

			echo '<div>';
			echo '<div class="col-sm-12">'.$aswf->v_text("name", "Araç Adı <i>(Zorunlu)</i>", $car->car_name, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
				$company_list = array(''=>"Bir Firma Seçiniz");
				foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
				echo '<div class="col-sm-6">'.$aswf->v_select("company", "Tedarikçi Firma <i>(Zorunlu)</i>", $car->car_company, $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("person", "Araç sürücü dahil kaç kişilik <i>(Zorunlu)</i>", $car->car_person, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
				$sinif_list = array(''=>'Araç Sınıfını Seçin');
				foreach($carDatas as $item){ if($item->tag=='sinif'){ $sinif_list[$item->id] = $item->name; } }
				echo '<div class="col-sm-6">'.$aswf->v_select("class", "Araç Sınıfı <i>(Zorunlu)</i>", $car->car_class, $sinif_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';

				$yakit_list = array(''=>'Araç Yakıtını Seçin');
				foreach($carDatas as $item){ if($item->tag=='yakit'){ $yakit_list[$item->id] = $item->name; } }
				echo '<div class="col-sm-6">'.$aswf->v_select("fuel", "Yakıt <i>(Zorunlu)</i>", $car->car_fuel, $yakit_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
				$vites_list = array(''=>'Vites Türünü Seçin');
				foreach($carDatas as $item){ if($item->tag=='vites'){ $vites_list[$item->id] = $item->name; } }
				echo '<div class="col-sm-6">'.$aswf->v_select("gear", "Vites <i>(Zorunlu)</i>", $car->car_gear, $vites_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';

				$kasa_list = array(''=>'Kasa Tipini Seçin');
				foreach($carDatas as $item){ if($item->tag=='kasa'){ $kasa_list[$item->id] = $item->name; } }
				echo '<div class="col-sm-6">'.$aswf->v_select("hatch", "Kasa Tipi <i>(Zorunlu)</i>", $car->car_hatch, $kasa_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("model", "Model Yılı <i>(Zorunlu)</i>", $car->car_model, N, 'required').'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("power", "Motor Gücü <i>(Zorunlu)</i>", $car->car_power, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("door", "Kapı Sayısı <i>(Zorunlu)</i>", $car->car_door, N, 'required').'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("baggage", "Bagaj kaç valiz alır) <i>(Zorunlu)</i>", $car->car_baggage, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';



			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Araç Resmi",$car->car_cover,N,N,N,N,true).'</div>';




			/*
			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", 61, $cities_array, null, 'disabled').'</div>';

			$counties_array = array(' ' => "Bir İlçe Seçin");
			if($counties) foreach($counties as $county) $counties_array[$county->county_id] = $county->county_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("district", "İlçe", ' ', $counties_array).'</div>';
			*/


			echo '<div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("age", "Sürücünün yaşı minimum kaç olmalı <i>(Zorunlu)</i>", $car->car_driver_age, N, 'required').'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("license", "Sürücü ehliyeti en az kaç senelik olmalı <i>(Zorunlu)</i>", $car->car_license, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("price", "Aracın 1 Günlük Kiralama Fiyatı <i>(Zorunlu)</i>", $car->car_price, N, 'required').'</div>';
			echo '<div class="clearfix"></div></div>';




			echo '<div class="col-sm-12">'.$aswf->v_textarea("description", "Açıklama", $car->car_description).'</div>';


			$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Yayın Durumu', $car->car_status, $statusItems).'</div>';




		echo '</div>';

		echo '<div class="col-sm-3 form-group">
		<label for="">Araç Özellikleri</label>
		<div class="list_checkboxes">';
		if($features){
		$selected_features = json_decode( $car->car_features, true);
		foreach($features as $feature){
			$itemid = seo_link($feature->feature_name.'_'.$feature->feature_id);
			$selected = in_array( $feature->feature_id, $selected_features )? ' checked="checked"' : null ;
			echo '<label for="'.$itemid.'" class="allow_select"><input type="checkbox" name="features[]"'.$selected.' value="'.$feature->feature_id.'" id="'.$itemid.'" />'.$feature->feature_name.'</label>';
		}
		}
		echo '</div></div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Oluştur");
	echo $aswf->close();
?>
