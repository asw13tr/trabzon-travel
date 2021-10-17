<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	$days = range(1,31,1);
	$months = array(
		'01' => 'Ocak',
		'02' => 'Şubat',
		'03' => 'Mart',
		'04' => 'Nisan',
		'05' => 'Mayıs',
		'06' => 'Haziran',
		'07' => 'Temmuz',
		'08' => 'Ağustos',
		'09' => 'Eylül',
		'10' => 'Ekim',
		'11' => 'Kasım',
		'12' => 'Aralık'
	);
	$years = range(date('Y')-15, date('Y')-60, 1);

	echo $aswf->v_open( url('user/edit/'.$user->user_id), "POST", true, null, 'data-abide novalidate' );

	echo '<div class="col-sm-12">
		<br/>
		<a href="'.site_url("user/changepass/".$user->user_id).'" class="alert alert-primary col-xs-12">Şifre değiştirme işlemi için buraya tıklayınız.</a>
		<div class="clearfix"></div>
		<br/><br/>
		</div>
		<div class="clearfix"></div>';

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_text("username", "Kullanıcı Adı*", $user->user_nickname, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
				<div class="col-sm-6">'.$aswf->v_mail("email", "E-posta Adresi*", $user->user_email, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
			</div>';

			/*
			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_password("password", "Parola*").'</div>
				<div class="col-sm-6">'.$aswf->v_password("repassword", "Parola Tekrarı*").'</div>
			</div>';
			*/

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_text("firstname", "İsim*", $user->user_firstname, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
				<div class="col-sm-6">'.$aswf->v_text("lastname", "Soyisim", $user->user_lastname).'</div>
			</div>';

			$getdate = explode('-', $user->user_birthday);
			$dogumtarihi = '<div class="row">
			<div class="col-xs-4">'.$aswf->v_selectez("day", "Doğum Tarihi", $getdate[2], $days).'</div>
			<div class="col-xs-4">'.$aswf->v_select("month", " ", $getdate[1], $months).'</div>
			<div class="col-xs-4">'.$aswf->v_selectez("year", " ", $getdate[0], $years).'</div>
			</div>';

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_tel("phone", "Telefon Numarası", $user->user_phone).'</div>
				<div class="col-sm-6">'.$dogumtarihi.'</div>
			</div>';

			echo $aswf->v_textarea("address", "Adres", $user->user_address);

			echo $aswf->v_file("cover", "Profil Fotoğrafı", $user->user_photo);

			$statusItems = [ 1=>"Aktif", 0=>"Pasif" ];
			global $userLevels;

			echo '<div class="clearfix"></div><div class="row">
				<div class="col-sm-6">'.$aswf->v_select('status', 'Hesap Durumu', $user->user_status, $statusItems).'</div>
				<div class="col-sm-6">'.$aswf->v_select('level', 'Üye Rütbesi', $user->user_level, $userLevels).'</div>
			</div>';

			echo $aswf->v_save("Güncelle");

	echo $aswf->close();
?>
