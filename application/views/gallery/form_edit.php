<div class="">
<h3>Galeri Görselleri</h3>
<h5><em>Galeri görsellerini aşağıdaki alana tıklayarak yada sürükleyip bırakarak yükleyebilirisiniz.<br/><br/></em></h5>
<form action="<?php echo site_url('gallery/upload/'.$gallery->gallery_id); ?>" class="dropzone" enctype="multipart/form-data">
  <div class="fallback">
    <input name="file" type="file" multiple />
  </div>
</form><br/>
</div>

<div class="text-center"><h3><a href="#" onClick="window.location.reload(); return false;">Görseller yüklendikten sonra buraya tıklayarak sayfayı yenileyin.</a></h3></div>
<?php if($photos): ?>
<div id="galeri_resimleri" class="row">
<?php foreach($photos as $img){
	$url = URL_UPLOADS."/gallery-photos\/".$img->gp_img;
	$del_url = site_url("gallery/delete_image");
	echo '<figure class="col-md-1 text-center" id="gpimg-'.$img->gp_id.'" style="padding:6px 10px; margin:0px;">
			<div style="border:1px solid #d0d0d0; padding: 2px;">
			<a href="'.$url.'" data-fancybox="gallery-'.$gallery->gallery_id.'">
			<img src="'.$url.'" alt="" class="img-resposnive center-block" style="width:100px; height:80px;" />
			</a>
			</div>
			<a href="javascript:void(0)"
			onclick="delwajax('.$img->gp_id.', \'Fotoğraf Galeriden Silinecek\', \''.$del_url.'\', \'figure#gpimg-'.$img->gp_id.'\' )">
			Görseli Kaldır
			</a>
			</figure>';
} ?>
</div>
<?php endif; ?>
<div class="clearfix"></div><br/><br/><div class="clearfix"></div>
<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('gallery/edit/'.$gallery->gallery_id), "POST", true, null, 'data-abide novalidate' );
		echo $aswf->v_text("title", "Galeri Başlığı", $gallery->gallery_title, N, 'required', N, abide_error("Bu alan zorunludur."));
		echo $aswf->v_file("cover", "Kapak Fotoğrafı", $gallery->gallery_cover);
		echo '<div class="form-group video_select_categories">'.selectlist_categories('category[]', json_decode($gallery->gallery_category, true)).'</div>';

		$statusItems = [ 1=>"Yayımla", 0=>"Yayımlama" ];
		echo $aswf->v_radio('status', 'Yayım Durumu', $gallery->gallery_status, $statusItems);

		echo $aswf->v_save("Galeriyi Güncelle");
	echo $aswf->close();
	require(__DIR__.'/javascript.php')
?>
