<h4 class="m0"><strong>Kategoriler</strong></h4>
<hr>
<?php if(isset($category_items)): ?>
<table class="table table-striped table-bordered table-hover bg_white table-responsive ">
<thead class="table-inverse">
	<tr>
		<th width="32">#</th>
		<th>IMG</th>
		<th>KATEGORİ</th>
		<th width="50">İÇERİK</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>

<tbody>
<?php foreach($category_items as $item): ?>
	<tr id="category-<?php echo $item->category_id; ?>">
		<td><input type="checkbox" name="category_id[]" value="<?php echo $item->category_id; ?>" class="form-control"/></td>
		<td width="100">
			<?php
			$cover_photo = image_from_json($item->category_cover, 'xs', false);
			if($cover_photo){
				echo '<img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" />';
			} ?>
		</td>
		<td><?php echo $item->category_name; ?></td>
		<td class="text-center"><?php echo $item->category_show_posts=="yes"? 'Yazı<br/>Listesi' : 'Kategori<br/>Listesi'; ?></td>
		<td class="text-center"><a href="<?php echo site_url("category/edit/$item->category_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash" onclick="delete_category(<?php echo $item->category_id; ?>, '<?php echo $item->category_name; ?>')"></a></td>
	</tr>
<?php endforeach; ?>
</tbody>

</table>
<?php endif; ?>
