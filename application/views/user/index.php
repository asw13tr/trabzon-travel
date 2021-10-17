<div>
	<a href="<?php echo site_url("user/add"); ?>" class="btn btn-primary">Kullanıcı Oluştur</a>
	<div class="clearfix"></div>
	<hr>
</div>
<table class="table table-hover table-bordered table-striped">
<thead>
	<tr>
		<th  width="45">Görsel</th>
		<th>Kullanıcı</th>
		<th width="150">Kullanıcı Adı</th>
		<th>E-Posta</th>
		<th>Telefon</th>
		<th width="130">Rütbe</th>
		<th width="10"></th>
		<th width="10"></th>
	</tr>
</thead>
<tbody>
<?php if( $users ): ?>
<?php foreach( $users as $user ):
	$userid = $user->user_id;
	$username = $user->user_nickname;
	$delete_url = site_url("user/delete");
	global $userLevels;
?>
	<tr id="user_<?php echo $user->user_id; ?>">
		<td>
			<?php
			$cover_photo = image_from_json($user->user_photo, 'xs', false);
			if($cover_photo){
				echo '<img src="'.URL_UPLOAD_IMAGES.$cover_photo.'" class="img-responsive center-block" />';
			} ?>
		</td>
		<td><?php echo $user->user_firstname.' '.$user->user_lastname; ?></td>
		<td><?php echo $user->user_nickname; ?></td>
		<td><?php echo $user->user_email; ?></td>
		<td><?php echo $user->user_phone; ?></td>
		<td><?php echo $userLevels[$user->user_level]; ?></td>
		<td class="text-center"><a href="<?php echo site_url("user/edit/$user->user_id"); ?>" class="btn btn-warning fa fa-pencil"></a></td>
		<td class="text-center"><a href="javascript:void(0)" class="btn btn-danger fa fa-trash"
		onclick="<?php echo "delwajax({$userid}, '{$username} Kullanıcısı', '{$delete_url}', 'tr#user_{$userid}' )"; ?>">

		</a></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
