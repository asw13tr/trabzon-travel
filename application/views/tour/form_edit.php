<div class="well">
<div class="col-md-12"><h3>Tur Görselleri</h3></div>
<div class="col-md-12">
<div class="row">
<?php $totalimg=0; if($tour_images): $totalimg = count($tour_images); foreach($tour_images as $img): ?>
	<div class="col-xs-6 col-sm-3"><div>
		<img src="<?php echo URL_UPLOAD_IMAGES_TOURS.$img->tp_image; ?>" style="width:100%; height:170px;" class="img-responsive center-block">
		<a href="<?php echo site_url('tour/del_img/'.$img->tp_id); ?>" class="btn btn-danger form-control text-center">Görseli Sil</a>
	</div></div>
<?php endforeach; endif; ?>
</div>
</div>
<div class="clearfix"></div>
<?php if($totalimg<4): ?>
<form class="horizontal-form" action="<?php echo site_url('tour/add_img/'.$tour->tour_id); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="p_id" value="<?php echo $tour->tour_id; ?>">
	<div class="form-group"></div>
	<div class="col-sm-10 col-xs-9 add_photos_div"><input type="file" name="p_img" class="form-control"></div>
	<div class="col-sm-2 col-xs-3"><button class="btn btn-primary form-control">Yükle</button></div>
</form>
<?php else:
	echo '<br/><p class="alert alert-warning">Turunuz için maksimum resim sayısına ulaştınız. Yeni bir resim ekleyebilmek için resimlerden silmeniz gerekmektedir.</p>';
endif; ?>
<div class="clearfix"></div>
</div>





<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('tour/edit/'.$tour->tour_id), "POST", true, N, 'data-abide novalidate' );
		echo '<div class="col-sm-12">';

			echo '<div>';
			echo '<div class="col-sm-12">'.$aswf->v_text("name", "Tur Başlığı*", $tour->tour_name, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>';
			echo '<div class="clearfix"></div></div>';


			echo '<div>';
				$company_list = array(' '=>"Bir Firma Seçiniz");
				foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
				echo '<div class="col-sm-12">'.$aswf->v_select("company", "Tedarikçi Firma <i>(Zorunlu)</i>", $tour->tour_company, $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';
			echo '<div class="clearfix"></div></div>';


			$cities_array = array(0 => "Bir Şehir Seçin");
			if($cities) foreach($cities as $city) $cities_array[$city->city_id] = $city->city_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("province", "İl", $tour->tour_province, $cities_array, null, 'required').'</div>';

			$category_list = array(' '=>"Bir Kategori Seçiniz");
			foreach($categories as $category) $category_list[$category->tf_id] = $category->tf_name;
			echo '<div class="col-sm-6">'.$aswf->v_select("category", "Tur Kategorisi <i>(Zorunlu)</i>", $tour->tour_category, $category_list, N, 'required', N, abide_error("Bu alan zorunludur.") ).'</div>';



			echo '<div>';
				echo '<div class="col-sm-12">'.$aswf->v_text("price", "Tur Fiyatı", $tour->tour_price).'</div>';
			echo '<div class="clearfix"></div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("start_date", "Tur Başlangıç Tarihi", $tour->tour_start_date).'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("end_date", "Tur Bitiş Tarihi", $tour->tour_end_date).'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("start_time", "Tur Başlangıç Saati", $tour->tour_start_time).'</div>';
				echo '<div class="col-sm-6">'.$aswf->v_text("end_time", "Tur Bitiş Saati", $tour->tour_end_time).'</div>';
			echo '<div class="clearfix"></div></div>';

			echo '<div class="col-sm-12">'.$aswf->v_file("cover", "Tur Kapak Fotoğrafı", $tour->tour_cover).'</div>';

			$statusItems = [ 1=>"Onaylanmış İlan", 0=>"Onaylanmamış İlan" ];
			echo '<div class="col-sm-6">'.$aswf->v_radio('status', 'Onay Durumu', $tour->tour_status, $statusItems).'</div>';

			echo '<div class="col-sm-12">'.$aswf->v_textarea("description", "Tur Hakkında Açıklama Yazısı Girin", $tour->tour_description).'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("visits", "Tur boyunca ziyaret edilecek yerleri alt alta yazın", $tour->tour_visits).'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("inc_services", "Tura dahil olan hizmetleri alt alta yazın", $tour->tour_inc_services).'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("exc_services", "Tur içinde fiyata dahil olmayan hizmetleri yazın", $tour->tour_exc_services).'</div>';
			echo '<div class="col-sm-12">'.$aswf->v_textarea("suggestions", "Tura katılacak olan kişilere önerilerinizi yazın", $tour->tour_suggestions).'</div>';

		echo '</div>';


		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Güncelle");
	echo $aswf->close();
?>
