<?php
class Company extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('location_model');
		$this->load->model("category_model");
	}

	public function index(){
		$viewData["pageTitle"] = 'Firma Listesi';
		$viewData["companies"] = $this->company_model->get_companies_with_join();
		$this->load_view('company/index', $viewData);
	}

	//### YENİ FİRMA OLUŞTURMA FORMUNU GÖSTERECEK OLAN KODLAR.
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Firma Ekle";

		$viewData['categories'] = $this->category_model->categories_with_sub();
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->add_post();
		$this->load_view('company/form_add', $viewData);
	}



	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$db_datas['company_password'] = convert_password(post('password'));
				$db_datas['company_username'] = post('username');
				$run = $this->company_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('Firma Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					$category_status_message = $this->connect_categories(post('categories'), $run);
					set_flashalert('Firma Eklendi'.$category_status_message);
					redirect('company/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('company/add');
			}
		}//if($_POST)
	}//add_post





	//##################### FİRMA DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('company'); exit; }
		$viewData["company"] = $this->company_model->get_company_with_join($id);
		if(!$viewData["company"]){ set_flashalert('Firma Bulunamadı', 'red'); redirect('company'); exit; }

		$viewData['pageTitle'] = "Bir Firma Düzenle";
		$viewData['categories'] = $this->category_model->categories_with_sub();
		$viewData["selected_categories"] = $this->company_model->get_selected_categories($id);
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);
		$this->edit_post($id);
		$this->load_view('company/form_edit', $viewData);
	}




	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function edit_post($id){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates(false, false) == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->company_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('Firma Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					$category_status_message = $this->connect_categories(post('categories'), $id);
					set_flashalert('Firma güncellendi'.$category_status_message);
					redirect('company/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('company/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post





	// # FİRMA GİRİŞ ŞİFRESİ DEĞİŞTİRME İŞLEMLERİ
	public function changepass($id){
		if(!$id){ redirect('company'); exit; }
		$viewData["company"] = $this->company_model->get_company_with_join($id);
		if(!$viewData["company"]){ set_flashalert('Firma Bulunamadı', 'red'); redirect('company'); exit; }

		$viewData['pageTitle'] = "Bir Firma Şifresini Değiştir";
		$this->changepass_post($id);
		$this->load_view('company/form_changepass', $viewData);
	}//changepass

	public function changepass_post($id){
		if($_POST){
			$oldpass = post("oldpassword");
			$newpass = post("password");
			$renewpass = post("repassword");

			$company = $this->company_model->get_company_with_oldpassword($id, convert_password($oldpass));
			if(!$oldpass || !$newpass || !$renewpass){
				set_flashalert('Tüm alanların doldurulduğundan emin olunuz.', 'red');
			}elseif(!$company){
				set_flashalert('Firma eski şifresi hatalı. Lütfen yeniden deneyin.', 'red');
			}elseif(strlen($newpass) < 6){
				set_flashalert('Yeni şifre en az 6 karakterden oluşmalı.', 'red');
			}elseif($newpass != $renewpass){
				set_flashalert('Firma yeni şifreleri birbiri ile eşleşmiyor.', 'red');
			}else{
				$db_datas["company_password"] = convert_password($newpass);
				$run = $this->company_model->save('update',$db_datas, $id);
				if(!$run){
					set_flashalert('Firma bilgileri güncellenirken bir sorun oluştu. Lütfen daha sonra yeniden deneyin.', 'red');
				}else{
					set_flashalert('Firma giriş şifresi değiştirildi.', 'green');
				}
			}
			redirect('company/changepass/'.$id);
		}
	}//changepass_post







	// FİRMA SİLME İŞLEMLERİ
	public function delete(){
		if($_POST){
			$id = post("id");
			$company = $this->company_model->get_company($id);
			$logo = $company->company_logo;
			if(!$company){
				echo 'false';
			}else{
				$delete = $this->company_model->delete_company($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($logo);
					$this->company_model->delete_connect_category($id);
					echo 'true';
				}
			}
		}
	}//delete



	public function input_validates($add_post=true, $pass=true){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Firma Adı','trim|required|min_length[3]',
								array(	'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.' ));


		if($add_post==true){
			$username_infos = array(	'required'      => ' %s boş bırakılamaz.',
										'min_length'     => '%s 3 karakterden daha az olamaz.',
										'is_unique'		=> 'Aynı kullanıcı adıyla bir kayıt zaten mevcut.');
			$this->form_validation->set_rules('username', 'Firma Girişi Kullanıcı Adı','trim|required|min_length[3]|is_unique[companies.company_username]', $username_infos);
		}

		$this->form_validation->set_rules('email', 'E-posta Adresi','trim|required|valid_email',
								array(	'required'      => ' %s boş bırakılamaz.',
									 	'valid_email'    => '%s geçersiz.' ));

		$this->form_validation->set_rules('categories[]', 'Firma Kategorisi', 'required',
								array(	'required'      => 'En az bir %s seçmek zorundasınız.'));

		if($pass==true){
			$this->form_validation->set_rules('password', 'Firma Giriş Şifresi','trim|required|min_length[6]',
									array(	'required'      => ' %s boş bırakılamaz.',
							                'min_length'     => '%s 6 karakterden daha az olamaz.' ));

			$this->form_validation->set_rules('repassword', 'Firma Giriş Şifresi Tekrarı','trim|required|min_length[6]|matches[password]',
									array(	'required'      => ' %s boş bırakılamaz.',
							                'min_length'     => '%s 6 karakterden daha az olamaz.',
											'matches'      => 'Parolalar birbiri ile eşleşmiyor.' ));
		}
		return $this->form_validation->run();
	}//add_validates




	// Firmaları kategorilere bağlama işlemleri
	public function connect_categories($categories, $id){
		if(isset($categories[0])){
			$db_datas_connect = array();
			foreach($categories as $cid){ $db_datas_connect[] = array( 'ccc_company'=>$id, 'ccc_category'=>$cid ); }
			$connect_status = $this->company_model->connect_category($db_datas_connect, $id);
			if($connect_status){
				$category_status_message = ' ve seçili kategorilere bağlandı.';
			}else{
				$category_status_message = ' ama kategoriler ile bağlantısı kurulamadı';
			}
		}
		return $category_status_message;
	}//connect_categories



	//Posttan gelen verileri alma işlemleri
	public function post_datas(){
		$saatler = array(
			1 => array( post("saat_1g"), post("saat_1c") ),
			2 => array( post("saat_2g"), post("saat_2c") ),
			3 => array( post("saat_3g"), post("saat_3c") ),
			4 => array( post("saat_4g"), post("saat_4c") ),
			5 => array( post("saat_5g"), post("saat_5c") ),
			6 => array( post("saat_6g"), post("saat_6c") ),
			7 => array( post("saat_7g"), post("saat_7c") )
		);

		$datas = array(
			'company_name' 		=> post('name'),
			'company_slug' 		=> seo_link(post('name')),
			'company_logo' 		=> post_cover(),
			'company_owner' 	=> post('owner'),
			'company_date' 		=> post('date'),
			'company_phone' 	=> post('phone'),
			'company_fax' 		=> post('fax'),
			'company_email' 	=> post('email'),
			'company_website' 	=> post('website'),
			'company_province' 	=> 61,
			'company_district' 	=> post('district'),
			'company_address' 	=> post('address'),
			'company_location' 	=> post('location'),
			'company_status' 	=> post('status'),
			'company_premium' 	=> post('premium'),
			'company_description' => post('description'),
			'company_hours'		=> json_encode($saatler),
			'company_socials'	=> json_encode(post('socials'))
		);
		return $datas;
	}//post_datas





}
?>
