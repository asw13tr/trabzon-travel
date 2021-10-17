<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('product/add'), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Ürün Adı", flash('val_title'), N, 'required', N, abide_error("Bu alan zorunludur."));

		$company_list = array(''=>"Bir Firma Seçiniz");
		foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
		echo $aswf->v_select("company", "Tedarikçi Firma", 0, $company_list, N, 'required', N, abide_error("Bu alan zorunludur.") );

		echo $aswf->v_text("price", "Ürün Fiyatı ₺", flash('val_price'), N, 'required', N, abide_error("Bu alan zorunludur."));
		echo $aswf->v_file("cover", "Ürün Kapak Fotoğrafı",N,N,N,N,N,TRUE);

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', flash('val_status', 1), $statusItems);

		echo $aswf->v_ckeditor('content', "Ürün Hakkında", flash('val_content'));
		echo $aswf->v_save("Ürünü Kaydet");
	echo $aswf->close();
	require(__DIR__.'/javascript.php')
?>
