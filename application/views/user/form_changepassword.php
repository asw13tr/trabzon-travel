<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('user/changepass/'.$user->user_id), "POST", true, null, 'data-abide novalidate' );

		echo '<div class="col-sm-6">'.$aswf->v_text("username", "Kullanıcı Adı", $user->user_nickname, null, 'disabled').'</div>';
		echo '<div class="col-sm-6">'.$aswf->v_password("oldpassword", "Eski Kullanıcı Şifresi",N,N,'required',N,abide_error("Bu alan zorunludur.")).'</div>';

		echo '<div class="col-sm-6">'.$aswf->v_password("password", "Yeni Kullanıcı Şifresi",N,N,'min="6" required',N,abide_error("Bu alan zorunludur.")).'</div>';
		echo '<div class="col-sm-6">'.$aswf->v_password("repassword", "Yeni Kullanıcı Şifresini Tekrar Yazın",N,N,'min="6" required data-equalto="password"',N,abide_error("Şifreler Uyuşmuyor yada bu alan boş bırakılmış.")).'</div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Şifreyi Değiştir");
		echo ' <a href="'.site_url('user/edit/'.$user->user_id).'" class="btn btn-warning">Kullanıcı düzenleme sayfasına geri dön</a>';
	echo $aswf->close();
?>
