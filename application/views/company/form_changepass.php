<?php
	require_once(FCPATH."/extraphp/class_ASWForm.php");
	$aswf = new ASWForm();
	echo $aswf->v_open( url('company/changepass/'.$company->company_id), "POST", true, null, 'data-abide novalidate' );

		echo '<div class="col-sm-6">'.$aswf->v_text("username", "Firma Girişi İçin Kullanıcı Adı", $company->company_username, null, 'disabled').'</div>';
		echo '<div class="col-sm-6">'.$aswf->v_password("oldpassword", "Eski Firma Giriş Şifresi",N,N,'required',N,abide_error("Bu alan zorunludur.")).'</div>';

		echo '<div class="col-sm-6">'.$aswf->v_password("password", "Yeni Firma Giriş Şifresi",N,N,'required',N,abide_error("Bu alan zorunludur.")).'</div>';
		echo '<div class="col-sm-6">'.$aswf->v_password("repassword", "Yeni Firma Giriş Şifresini Tekrar Yazın",N,N,'required data-equalto="password"',N,abide_error("Şifreler Uyuşmuyor yada bu alan boş bırakılmış.")).'</div>';

		echo '<div class="clearfix"></div>';
		echo $aswf->v_save("Şifreyi Değiştir");
		echo ' <a href="'.site_url('company/edit/'.$company->company_id).'" class="btn btn-warning">Firma düzenleme sayfasına geri dön</a>';
	echo $aswf->close();
?>
