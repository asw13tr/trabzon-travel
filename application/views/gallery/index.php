<?php
	$categories_list = array();
	if($categories){
		foreach($categories as $category){
			$categories_list[$category->category_id] = $category->category_name;
		}
	}
?>
<div>
	<a href="<?php echo site_url("gallery/add"); ?>" class="btn btn-primary">Yeni Galeri Oluştur</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th>Başlık</th>
		<th>Kategoriler</th>
		<th>Durum</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $galleries ): ?>
<?php foreach( $galleries as $gallery ):
	$galleryid = $gallery->gallery_id;
	$galleryname = $gallery->gallery_title;
	$delete_url = site_url("gallery/delete");
	$kategoriler = null;
	if($gallery->gallery_category){
		$kategoriler = array();
		foreach (json_decode($gallery->gallery_category, true) as $id) {
			$kategoriler[] = $categories_list[$id] ;
		}
	}//if($gallery->gallery_category)
?>
	<tr id="gallery_<?php echo $gallery->gallery_id; ?>">
		<td><?php echo $gallery->gallery_title; ?></td>
		<td><?php echo !$kategoriler? null : implode(', ', $kategoriler); ?></td>
		<td><?php echo $gallery->gallery_status==1? 'Yayımda' : 'Pasif' ; ?></td>
		<td class="text-center"><a href="<?php echo site_url("gallery/edit/$gallery->gallery_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$galleryid}, '{$galleryname} Başlıklı foto galeri', '{$delete_url}', 'tr#gallery_{$galleryid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
