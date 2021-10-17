<div>
	<a href="<?php echo site_url("realestate/add"); ?>" class="btn btn-primary">İlan Ekle</a>
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
<?php if( $realestates ): ?>
<?php foreach( $realestates as $estate ):
	$estateid = $estate->re_id;
	$estatename = $estate->re_name;
	$delete_url = site_url("realestate/delete");

?>
	<tr id="estate_<?php echo $estate->re_id; ?>">
		<td><?php
			$cover_photo = image_from_json($estate->re_cover, 'xs', false);
			$cover_photo_big = image_from_json($estate->re_cover, 'original', false);
			if($cover_photo) echo '<a href="'.URL_UPLOAD_IMAGES.$cover_photo_big.'" data-fancybox="company-logo"><img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" /></a>'; ?>
		</td>
		<td><?php echo is_active($estate->re_status); ?></td>
		<td><b><?php echo $estate->re_name; ?></b><br/>
			<small><?php echo $estate->city_name.' / '.$estate->county_name; ?></small></td>
		<td><?php echo  $estate->company_name; ?></td>
		<td>
			<?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_room ); ?><br/>
			<?php echo $estate->re_area; ?>m2
		</td>
		<td>
			<?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_estate_status ); ?><br/>
			<?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_estate_type ); ?>
		</td>
		<td>
			<?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_build_status ); ?><br/>
			<?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_build_type ); ?>
		</td>
		<td><?php echo  get_db_col('ref_name', 'realestate_features', 'ref_id='.$estate->re_heating ); ?></td>

		<td class="text-center"><a href="<?php echo site_url("realestate/edit/$estate->re_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$estateid}, '{$estatename} İlanı', '{$delete_url}', 'tr#estate_{$estateid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
