<div>
	<a href="<?php echo site_url("product/add"); ?>" class="btn btn-primary">Ürün Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th width="80"></th>
		<th width="10"></th>
		<th>Fiyat</th>
		<th>Ürün</th>
		<th>Firma</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $products ): ?>
<?php foreach( $products as $product ):
	$productid = $product->product_id;
	$productname = $product->product_title;
	$delete_url = site_url("product/delete");
?>
	<tr id="product_<?php echo $product->product_id; ?>">
		<td>
			<?php
			$cover_photo = image_from_json($product->product_cover, 'xs', false);
			if($cover_photo){
				echo '<img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" />';
			} ?>
		</td>
		<td><?php echo is_active($product->product_status); ?></td>
		<td><?php echo $product->product_price; ?> ₺</td>
		<td><?php echo $product->product_title; ?></td>
		<td><?php echo $product->company_name; ?></td>
		<td class="text-center"><a href="<?php echo site_url("product/edit/$product->product_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$productid}, '{$productname} ürünü', '{$delete_url}', 'tr#product_{$productid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
