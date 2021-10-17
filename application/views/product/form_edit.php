

	<div class="col-md-12"><h3>Ürün Görselleri</h3></div>
	<div class="col-md-12">
	<div class="row">
	<?php $totalimg=0; if($product_images): $totalimg = count($product_images); foreach($product_images as $img): ?>
		<div class="col-xs-6 col-sm-3"><div>
			<img src="<?php echo URL_UPLOAD_IMAGES_PRODUCTS.$img->pp_image; ?>" style="width:100%; height:170px;" class="img-responsive center-block">
			<a href="<?php echo site_url('product/del_img/'.$img->pp_id); ?>" class="btn btn-danger form-control text-center">Görseli Sil</a>
		</div></div>
	<?php endforeach; endif; ?>
	</div>
	</div>
	<div class="clearfix"></div>
	<?php if($totalimg<4): ?>
	<form class="horizontal-form" action="<?php echo site_url('product/add_img/'.$product->product_id); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="p_id" value="<?php echo $product->product_id; ?>">
		<div class="form-group"></div>
		<div class="col-sm-10 col-xs-9 add_photos_div"><input type="file" name="p_img" class="form-control"></div>
		<div class="col-sm-2 col-xs-3"><button class="btn btn-primary form-control">Yükle</button></div>
	</form>
	<?php else:
		echo '<br/><p class="alert alert-warning">Ürününüz için maksimum resim sayısına ulaştınız. Yeni bir resim ekleyebilmek için resimlerden silmeniz gerekmektedir.</p>';
	endif; ?>


<div class="clearfix"></div>
<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('product/edit/'.$product->product_id), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Ürün Adı", $product->product_title, N, 'required', N, abide_error("Bu alan zorunludur."));

		$company_list = array(0=>"Bir Firma Seçiniz");
		foreach($companies as $company) $company_list[$company->company_id] = $company->company_name;
		echo $aswf->v_select("company", "Tedarikçi Firma", $product->product_company, $company_list, N, 'required', N, abide_error("Bu alan zorunludur.")  );

		echo $aswf->v_text("price", "Ürün Fiyatı ₺", $product->product_price, N, 'required', N, abide_error("Bu alan zorunludur."));
		echo $aswf->v_file("cover", "Ürün Kapak Fotoğrafı", $product->product_cover,N,N,N,N,TRUE);

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', $product->product_status, $statusItems);

		echo $aswf->v_ckeditor('content', "Ürün Hakkında", $product->product_content);
		echo $aswf->v_save("Ürünü Kaydet");
	echo $aswf->close();
?>
