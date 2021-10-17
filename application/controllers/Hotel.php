<?php
class Hotel extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('hotel_model');
		$this->load->model('location_model');
		$this->load->model("category_model");
	}

	public function index(){
		$viewData["pageTitle"] = 'Otel Listesi';
		$viewData["hotels"] = $this->hotel_model->get_hotels_with_join();
		$this->load_view('hotel/index', $viewData);
	}












	//### YENİ FİRMA OLUŞTURMA FORMUNU GÖSTERECEK OLAN KODLAR.
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Otel Ekle";

		$viewData['features'] = $this->hotel_model->get_features();
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->add_post();
		$this->load_view('hotel/form_add', $viewData);
	}
	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->hotel_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('Otel Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Otel Eklendi');
					redirect('hotel/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('hotel/add');
			}
		}//if($_POST)
	}//add_post










	//##################### FİRMA DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('hotel'); exit; }
		$viewData["hotel"] = $this->hotel_model->get_hotel_with_join($id);
		if(!$viewData["hotel"]){ set_flashalert('Otel Bulunamadı', 'red'); redirect('company'); exit; }

		$viewData['features'] = $this->hotel_model->get_features();
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);
		$this->edit_post($id);
		$this->load_view('hotel/form_edit', $viewData);
	}
	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->hotel_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('Otel Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Otel bilgileri güncellendi');
					redirect('hotel/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('hotel/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post





	public function changepass_post($id){
		if($_POST){
			$oldpass = post("oldpassword");
			$newpass = post("password");
			$renewpass = post("repassword");

			$company = $this->hotel_model->get_company_with_oldpassword($id, convert_password($oldpass));
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
				$run = $this->hotel_model->save('update',$db_datas, $id);
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
			$hotel = $this->hotel_model->get_hotel($id);
			$logo = $hotel->hotel_cover;
			if(!$hotel){
				echo 'false';
			}else{
				$delete = $this->hotel_model->delete_hotel($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($logo);
					echo 'true';
				}
			}
		}
	}//delete



	public function input_validates($add_post=true, $pass=true){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Otel Adı','trim|required|min_length[3]',
								array(	'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.' ));

		$this->form_validation->set_rules('district', 'İlçe','trim|required',
								array(	'required'      => ' %s seçmek zorundasınız.') );

		return $this->form_validation->run();
	}//add_validates




	// Firmaları kategorilere bağlama işlemleri
	public function connect_categories($categories, $id){
		if(isset($categories[0])){
			$db_datas_connect = array();
			foreach($categories as $cid){ $db_datas_connect[] = array( 'ccc_company'=>$id, 'ccc_category'=>$cid ); }
			$connect_status = $this->hotel_model->connect_category($db_datas_connect, $id);
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

		$datas = array(
			'hotel_name' 		=> post('name'),
			'hotel_slug' 		=> seo_link(post('name')),
			'hotel_cover' 		=> post_cover(),
			//'hotel_owner' 		=> post('owner'),
			//'hotel_date' 		=> post('date'),
			'hotel_phone' 		=> post('phone'),
			//'hotel_fax' 		=> post('fax'),
			'hotel_email' 		=> post('email'),
			'hotel_website' 	=> post('website'),
			'hotel_type' 		=> post('type'),
			'hotel_star' 		=> post('stars'),
			'hotel_province' 	=> 61,
			'hotel_district' 	=> post('district'),
			'hotel_address' 	=> post('address'),
			'hotel_location' 	=> post('location'),
			'hotel_status' 		=> post('status'),
			'hotel_premium' 	=> post('premium'),
			'hotel_about' 		=> post('description'),
			'hotel_features'	=> json_encode(post('features')),
			'hotel_socials'		=> json_encode(post('socials'))
		);
		return $datas;
	}//post_datas





}
?>
