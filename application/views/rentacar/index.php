<div>
	<a href="<?php echo site_url("rentacar/add"); ?>" class="btn btn-primary">Araç Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th width="60"></th>
		<th width="10"></th>
		<th>Araba</th>
		<th>Sınıf</th>
		<th>Yakıt</th>
		<th>Vites</th>
		<th>Kasa</th>
		<th>Model</th>
		<th>Kapı</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $cars ): ?>
<?php foreach( $cars as $car ):
	$carid = $car->car_id;
	$carname = $car->car_name;
	$delete_url = site_url("rentacar/delete");
?>
	<tr id="car_<?php echo $car->car_id; ?>">
		<td><?php
			$cover_photo = image_from_json($car->car_cover, 'xs', false);
			$cover_photo_big = image_from_json($car->car_cover, 'original', false);
			if($cover_photo) echo '<a href="'.URL_UPLOAD_IMAGES.$cover_photo_big.'" data-fancybox="car-logo"><img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" /></a>'; ?>
		</td>
		<td><?php echo is_active($car->car_status); ?></td>
		<td><b><?php echo $car->car_name; ?></b> (<?php echo $car->car_person; ?> kişilik)<br/>
			<?php echo $car->company_name; ?>
		</td>
		<td><?php echo  @$car_datas[$car->car_class]; ?></td>
		<td><?php echo  @$car_datas[$car->car_fuel]; ?></td>
		<td><?php echo  @$car_datas[$car->car_gear]; ?></td>
		<td><?php echo  @$car_datas[$car->car_hatch]; ?></td>
		<td><?php echo  $car->car_model; ?></td>
		<td><?php echo  $car->car_door; ?> kapı</td>
		<td class="text-center"><a href="<?php echo site_url("rentacar/edit/$car->car_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$carid}, '{$carname}', '{$delete_url}', 'tr#car_{$carid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
