<div>
	<a href="<?php echo site_url("page/add"); ?>" class="btn btn-primary">Sayfa Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th  width="45">Görsel</th>
		<th>Sayfa</th>
		<th>Üst Sayfa</th>
		<th width="100">Durum</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $posts ): ?>
<?php foreach( $posts as $post ): $parent_page = $this->page_model->get_item_by_id($post->post_parent); ?>
	<tr id="page_<?php echo $post->post_id; ?>">
		<td>
			<?php
			$cover_photo = image_from_json($post->post_cover, 'xs', false);
			if($cover_photo){
				echo '<img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" />';
			} ?>
		</td>
		<td><?php echo $post->post_title; ?></td>
		<td><?php echo !$parent_page? 'Yok' : $parent_page->post_title; ?></td>
		<td><?php echo !$post->post_status? 'Pasif' : 'Aktif'; ?></td>
		<td class="text-center"><a href="<?php echo site_url("page/edit/$post->post_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="delwajax(<?php echo $post->post_id; ?>, 'Sayfa', '<?php echo site_url("page/delete"); ?>', 'tr#page_<?php echo $post->post_id; ?>')">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
