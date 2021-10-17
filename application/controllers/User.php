<?php
class User extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index(){
		$viewData["pageTitle"] = 'KULLANICILAR';
		$viewData["users"] = $this->user_model->list_user();
		$this->load_view('user/index', $viewData);
	}







	//##################### YENİ ÜYE OLUŞTURMA İŞLEMLERİ
	public function add(){
		$viewData['pageTitle'] = "Yeni Kullanıcı Oluştur";
		$this->add_post();
		$this->load_view('user/form_add', $viewData);
	}

	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}

			if($this->add_validates() == TRUE){

				$birthday = post('year').'-'.post('month').'-'.post('day');
				$db_datas = array(
					'user_nickname' => post('username'),
					'user_password' => convert_password(post('password')),
					'user_email' 	=> post('email',''),
					'user_phone' 	=> post('phone',''),
					'user_address' 	=> post('address',''),
					'user_firstname'=> post('firstname',''),
					'user_lastname' => post('lastname',''),
					'user_photo' 	=> post_cover(),
					'user_birthday' => $birthday,
					'user_status' 	=> post('status',0),
					'user_level' 	=> post('level',1)
				);
				$run = $this->user_model->save('create',$db_datas);
				if( !run ){
					set_flashalert('Kullanıcı Oluşturulamadı. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Kullanıcı Oluşturuldu');
					redirect('user/edit/'.$run);
				}
			}//if($this->add_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('user/add');
			}
		}//if($_POST)
	}//add_post





	public function changepass($id){
		if(!$id){ redirect('user'); exit; }
		$viewData["user"] = $this->user_model->get_user($id);
		if(!$viewData["user"]){ set_flashalert('Kullanıcı Bulunamadı', 'red'); redirect('user'); exit; }

		$viewData['pageTitle'] = "Bir Kullanıcı Şifresini Değiştir";
		$this->changepass_post($id);
		$this->load_view('user/form_changepassword', $viewData);
	}//changepass






	public function changepass_post($id){
		if($_POST){
			$oldpass = post("oldpassword");
			$newpass = post("password");
			$renewpass = post("repassword");

			$user = $this->user_model->get_user_with_oldpassword($id, convert_password($oldpass));
			if(!$oldpass || !$newpass || !$renewpass){
				set_flashalert('Tüm alanların doldurulduğundan emin olunuz.', 'red');
			}elseif(!$user){
				set_flashalert('Kullanıcı eski şifresi hatalı. Lütfen yeniden deneyin.', 'red');
			}elseif(strlen($newpass) < 6){
				set_flashalert('Yeni şifre en az 6 karakterden oluşmalı.', 'red');
			}elseif($newpass != $renewpass){
				set_flashalert('Kullanıcı yeni şifreleri birbiri ile eşleşmiyor.', 'red');
			}else{
				$db_datas["user_password"] = convert_password($newpass);
				$run = $this->user_model->save('update',$db_datas, $id);
				if(!$run){
					set_flashalert('Kullanıcı bilgileri güncellenirken bir sorun oluştu. Lütfen daha sonra yeniden deneyin.', 'red');
				}else{
					set_flashalert('Kullanıcı giriş şifresi değiştirildi.', 'green');
				}
			}
			redirect('user/changepass/'.$id);
		}
	}//changepass_post



	//##################### KULLANICI DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('user'); exit; }
		$viewData["user"] = $this->user_model->get_user($id);
		if(!$viewData["user"]){ set_flashalert('Kullanıcı Bulunamadı', 'red'); redirect('user'); exit; }

		$viewData['pageTitle'] = "Bir Kullanıcı Düzenle";
		$this->edit_post($id);
		$this->load_view('user/form_edit', $viewData);
	}

	public function edit_post($id){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}

			if($this->edit_validates() == TRUE){

				$birthday = post('year').'-'.post('month').'-'.post('day');
				$db_datas = array(
					'user_nickname' => post('username'),
					'user_email' 	=> post('email',''),
					'user_phone' 	=> post('phone',''),
					'user_address' 	=> post('address',''),
					'user_firstname'=> post('firstname',''),
					'user_lastname' => post('lastname',''),
					'user_photo' 	=> post_cover(),
					'user_birthday' => $birthday,
					'user_status' 	=> post('status',0),
					'user_level' 	=> post('level',1)
				);
				$run = $this->user_model->save('update',$db_datas, $id);
				if( !run ){
					set_flashalert('Kullanıcı Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Kullanıcı Bilgileri Güncellendi.');
					redirect('user/edit/'.$id);
				}
			}//if($this->edit_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('user/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post


	public function delete(){
	if($_POST){
		$id = post("id");
		$user = $this->user_model->get_user($id);
		$imgs = json_decode($user->user_photo);
		if(!$user){
			echo 'false';
		}else{
			$delete = $this->user_model->delete_user($id);
			if(!$delete){
				echo 'false';
			}else{
				if($imgs){
					foreach ($imgs as $img) {
						if( file_exists(PATH_UPLOAD_IMAGES.$img) ){ unlink(PATH_UPLOAD_IMAGES.$img); }
					}
				}
				echo 'true';
			}
		}
	}
	}


















	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	public function password_validates(){
		$this->form_validation->set_rules('password', 'Parola', 'required|min_length[6]',
								array(
										'required'      => ' %s boş bırakılamaz.',
										'min_length'    => '%s 6 karakterden daha az olamaz.'
								));
		$this->form_validation->set_rules('repassword', 'Parola tekrarı', 'required|matches[password]',
								array(
										'required'      => ' %s boş bırakılamaz.',
										'matches'      => 'Parolalar birbiri ile eşleşmiyor.'
								));
	}//password_validates
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	public function add_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Kullanıcı Adı','trim|required|min_length[3]|max_length[15]|is_unique[users.user_nickname]',
								array(
						                'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.',
						                'max_length'     => '%s 15 karakterden daha fazla olamaz.',
										'is_unique'		=> 'Aynı kullanıcı adıyla bir kayıt zaten mevcut.'
						        ));

		$this->form_validation->set_rules('email', 'E-posta', 'trim|required|valid_email|is_unique[users.user_email]',
								array(
										'required'      => ' %s boş bırakılamaz.',
										'valid_email'    => '%s geçersiz.',
										'is_unique'		=> 'Aynı e-posta adresi ile bir kayıt zaten mevcut.'
								));
		$this->password_validates();
		return $this->form_validation->run();
	}//add_validates


	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	public function edit_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Kullanıcı Adı','trim|required|min_length[3]|max_length[15]',
								array(
						                'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.',
						                'max_length'     => '%s 15 karakterden daha fazla olamaz.',
						        ));

		$this->form_validation->set_rules('email', 'E-posta', 'trim|required|valid_email',
								array(
										'required'      => ' %s boş bırakılamaz.',
										'valid_email'    => '%s geçersiz.',
								));
		return $this->form_validation->run();
	}//edit_validates
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#
	//#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#(!)#


}
?>
