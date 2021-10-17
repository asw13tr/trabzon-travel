<div>
	<a href="<?php echo site_url("tour/add"); ?>" class="btn btn-primary">İlan Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th width="60"></th>
		<th width="10"></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $tours ): ?>
<?php foreach( $tours as $tour ):
	$tourid = $tour->tour_id;
	$tourname = $tour->tour_name;
	$delete_url = site_url("tour/delete");

?>
	<tr id="tour_<?php echo $tour->tour_id; ?>">
		<td><?php
			$cover_photo = image_from_json($tour->tour_cover, 'xs', false);
			$cover_photo_big = image_from_json($tour->tour_cover, 'original', false);
			if($cover_photo) echo '<a href="'.URL_UPLOAD_IMAGES.$cover_photo_big.'" data-fancybox="company-logo"><img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" /></a>'; ?>
		</td>
		<td><?php echo is_active($tour->tour_status); ?></td>
		<td><b><?php echo $tour->tour_name; ?></b><br/><small><?php echo $tour->city_name; ?></small></td>
		<td><?php echo  $tour->company_name; ?></td>
		<td><?php echo  get_db_col('tf_name', 'tour_features', 'tf_id='.$tour->tour_category ); ?></td>
		<td><?php echo  $tour->tour_price; ?> ₺</td>
		<td>
			<?php echo  $tour->tour_start_date; ?> <b>[<?php echo  $tour->tour_start_time; ?>]</b><br/>
			<?php echo  $tour->tour_end_date; ?> <b>[<?php echo  $tour->tour_end_time; ?>]</b>
		</td>



		<td class="text-center"><a href="<?php echo site_url("tour/edit/$tour->tour_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$tourid}, '{$tourname}', '{$delete_url}', 'tr#tour_{$tourid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
