<div>
	<a href="<?php echo site_url("company/add"); ?>" class="btn btn-primary">Firma Ekle</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th width="60"></th>
		<th width="10"></th>
		<th width="10"></th>
		<th>Firma</th>
		<th>Yetkili</th>
		<th>İletişim</th>
		<th>Kategorisi</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $companies ): ?>
<?php foreach( $companies as $company ):
	$companyid = $company->company_id;
	$companyname = $company->company_name;
	$delete_url = site_url("company/delete");

	$kategoriler = array();
	$kategoriler_results = $this->company_model->get_linked_categories($company->company_id);
	if($kategoriler_results && is_array($kategoriler_results)){
		foreach($kategoriler_results as $kat) $kategoriler[] = $kat->category_name;
	}

?>
	<tr id="company_<?php echo $company->company_id; ?>">
		<td><?php
			$cover_photo = image_from_json($company->company_logo, 'xs', false);
			$cover_photo_big = image_from_json($company->company_logo, 'original', false);
			if($cover_photo) echo '<a href="'.URL_UPLOAD_IMAGES.$cover_photo_big.'" data-fancybox="company-logo"><img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" /></a>'; ?>
		</td>
		<td><?php echo is_premium($company->company_premium); ?></td>
		<td><?php echo is_active($company->company_status); ?></td>
		<td><b><?php echo $company->company_name; ?></b> <small>(<?php echo $company->company_username; ?>)</small><br/>
			<small><?php echo $company->city_name.' / '.$company->county_name; ?></small></td>
		<td><?php echo $company->company_owner; ?></td>
		<td>
			<small><?php echo $company->company_phone; ?></small><br/>
			<small><?php echo $company->company_email; ?></small>
		</td>
		<td><?php echo implode(', ', $kategoriler); ?></td>
		<td class="text-center"><a href="<?php echo site_url("company/edit/$company->company_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$companyid}, '{$companyname} Firması', '{$delete_url}', 'tr#company_{$companyid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
