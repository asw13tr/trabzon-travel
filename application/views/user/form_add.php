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

	echo $aswf->v_open( url('user/add'), "POST", true, null, 'data-abide novalidate' );

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_text("username", "Kullanıcı Adı*", flash('val_username'), N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
				<div class="col-sm-6">'.$aswf->v_mail("email", "E-posta Adresi*", flash('val_email'), N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
			</div>';

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_password("password", "Parola*", N, N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
				<div class="col-sm-6">'.$aswf->v_password("repassword", "Parola Tekrarı*", N, N, 'required data-equalto="password"', N, abide_error("Parolalar Eşleşmiyor veya boş bırakılmış.")).'</div>
			</div>';

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_text("firstname", "İsim*", flash('val_firstname'), N, 'required', N, abide_error("Bu alan zorunludur.")).'</div>
				<div class="col-sm-6">'.$aswf->v_text("lastname", "Soyisim", flash('val_lastname')).'</div>
			</div>';

			$dogumtarihi = '<div class="row">
			<div class="col-xs-4">'.$aswf->v_selectez("day", "Doğum Tarihi", flash('val_day'), $days).'</div>
			<div class="col-xs-4">'.$aswf->v_select("month", " ", flash('val_month'), $months).'</div>
			<div class="col-xs-4">'.$aswf->v_selectez("year", " ", flash('val_year'), $years).'</div>
			</div>';

			echo '<div class="row">
				<div class="col-sm-6">'.$aswf->v_tel("phone", "Telefon Numarası", flash('val_phone')).'</div>
				<div class="col-sm-6">'.$dogumtarihi.'</div>
			</div>';

			echo $aswf->v_textarea("address", "Adres", flash('val_address'));

			echo $aswf->v_file("cover", "Profil Fotoğrafı");

			$statusItems = [ 1=>"Aktif", 0=>"Pasif" ];
			global $userLevels;

			echo '<div class="clearfix"></div><div class="row">
				<div class="col-sm-6">'.$aswf->v_select('status', 'Hesap Durumu', 1, $statusItems).'</div>
				<div class="col-sm-6">'.$aswf->v_select('level', 'Üye Rütbesi', 1, $userLevels).'</div>
			</div>';

			echo $aswf->v_save("Oluştur");

	echo $aswf->close();
?>
