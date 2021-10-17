<?php
	$categories_list = array();
	if($categories){
		foreach($categories as $category){
			$categories_list[$category->category_id] = $category->category_name;
		}
	}
?>
<div>
	<a href="<?php echo site_url("video/add"); ?>" class="btn btn-primary">Video Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th>Başlık</th>
		<th>Bağlantı Linki</th>
		<th>Kategoriler</th>
		<th>Durum</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $videos ): ?>
<?php foreach( $videos as $video ):
	$videoid = $video->video_id;
	$videoname = $video->video_title;
	$delete_url = site_url("video/delete");
	$kategoriler = null;
	if($video->video_category){
		$kategoriler = array();
		foreach (json_decode($video->video_category, true) as $id) {
			$kategoriler[] = $categories_list[$id] ;
		}
	}//if($video->video_category)
?>
	<tr id="video_<?php echo $video->video_id; ?>">
		<td><?php echo $video->video_title; ?></td>
		<td><?php echo $video->video_url; ?></td>
		<td><?php echo !$kategoriler? null : implode(', ', $kategoriler); ?></td>
		<td><?php echo $video->video_status==1? 'Yayımda' : 'Pasif' ; ?></td>
		<td class="text-center"><a href="<?php echo site_url("video/edit/$video->video_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$videoid}, '{$videoname} videosu', '{$delete_url}', 'tr#video_{$videoid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
