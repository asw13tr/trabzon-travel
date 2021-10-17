<?php global $hotelTypes; global $hotelStars; ?>
<div>
	<a href="<?php echo site_url("hotel/add"); ?>" class="btn btn-primary">Otel Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th width="60"></th>
		<th width="10"></th>
		<th width="10"></th>
		<th>İşletme Adı</th>
		<th>İşletme</th>
		<th>Yıldız</th>
		<th>İletişim</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $hotels ): ?>
<?php foreach( $hotels as $hotel ):
	$hotelid = $hotel->hotel_id;
	$hotelname = $hotel->hotel_name;
	$delete_url = site_url("hotel/delete");
/*
	$kategoriler = array();
	$kategoriler_results = $this->company_model->get_linked_categories($hotel->company_id);
	if($kategoriler_results && is_array($kategoriler_results)){
		foreach($kategoriler_results as $kat) $kategoriler[] = $kat->category_name;
	}
*/
?>
	<tr id="hotel_<?php echo $hotel->hotel_id; ?>">
		<td><?php
			$cover_photo = image_from_json($hotel->hotel_cover, 'xs', false);
			$cover_photo_big = image_from_json($hotel->hotel_cover, 'original', false);
			if($cover_photo) echo '<a href="'.URL_UPLOAD_IMAGES.$cover_photo_big.'" data-fancybox="company-logo"><img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" /></a>'; ?>
		</td>
		<td><?php echo is_premium($hotel->hotel_premium); ?></td>
		<td><?php echo is_active($hotel->hotel_status); ?></td>
		<td><b><?php echo $hotel->hotel_name; ?></b><br/>
			<small><?php echo $hotel->city_name.' / '.$hotel->county_name; ?></small></td>
		<td><?php echo  @$hotelTypes[$hotel->hotel_type]; ?></td>
		<td><?php echo  @$hotelStars[$hotel->hotel_star]; ?></td>
		<td>
			<small><?php echo $hotel->hotel_phone; ?></small><br/>
			<small><?php echo $hotel->hotel_email; ?></small>
		</td>
		<td class="text-center"><a href="<?php echo site_url("hotel/edit/$hotel->hotel_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$hotelid}, '{$hotelname} Firması', '{$delete_url}', 'tr#hotel_{$hotelid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
