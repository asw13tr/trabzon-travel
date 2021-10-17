<div>
	<a href="<?php echo site_url("post/add"); ?>" class="btn btn-primary">Yazı Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th  width="45">Görsel</th>
		<th>Başlık</th>
		<th width="100">Durum</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $posts ): ?>
<?php foreach( $posts as $post ): ?>
	<tr id="post_<?php echo $post->post_id; ?>">
		<td>
			<?php
			$cover_photo = image_from_json($post->post_cover, 'xs', false);
			if($cover_photo){
				echo '<img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" />';
			} ?>
		</td>
		<td><?php echo $post->post_title; ?></td>
		<td><?php echo !$post->post_status? 'Pasif' : 'Aktif'; ?></td>
		<td class="text-center"><a href="<?php echo site_url("post/edit/$post->post_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="delwajax(<?php echo $post->post_id; ?>, 'Yazı', '<?php echo site_url("post/delete"); ?>', 'tr#post_<?php echo $post->post_id; ?>')">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
