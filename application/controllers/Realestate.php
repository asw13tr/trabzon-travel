<?php
class Realestate extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('realestate_model');
		$this->load->model('location_model');
	}

	public function index(){
		$viewData["pageTitle"] = 'İlan Listesi';
		$viewData["realestates"] = $this->realestate_model->get_realestates_with_join();
		$this->load_view('realestate/index', $viewData);
	}













	public function add(){
		$viewData['pageTitle'] = "Yeni Bir İlan Ekle";

		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$viewData['features'] = $this->realestate_model->get_features('ref_parent=6');
		$viewData['estate_status_list'] = $this->realestate_model->get_features('ref_parent=1');
		$viewData['estate_type_list'] = $this->realestate_model->get_features('ref_parent=4');
		$viewData['build_status_list'] = $this->realestate_model->get_features('ref_parent=2');
		$viewData['build_type_list'] = $this->realestate_model->get_features('ref_parent=3');
		$viewData['heating_list'] = $this->realestate_model->get_features('ref_parent=5');
		$viewData['room_list'] = $this->realestate_model->get_features('ref_parent=52');
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->add_post();
		$this->load_view('realestate/form_add', $viewData);
	}
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->realestate_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('İlan Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('İlan Eklendi');
					redirect('realestate/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('realestate/add');
			}
		}//if($_POST)
	}//add_post











	public function edit($id){
		if(!$id){ redirect('realestate'); exit; }
		$viewData["estate"] = $this->realestate_model->get_realestate_with_join($id);
		$viewData["realestate_images"] = $this->realestate_model->get_realestate_images($id);
		if(!$viewData["estate"]){ set_flashalert('İlan Bulunamadı', 'red'); redirect('realestate'); exit; }

		$viewData['pageTitle'] = "Bir İlanı Düzenle";
		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$viewData['features'] = $this->realestate_model->get_features('ref_parent=6');
		$viewData['estate_status_list'] = $this->realestate_model->get_features('ref_parent=1');
		$viewData['estate_type_list'] = $this->realestate_model->get_features('ref_parent=4');
		$viewData['build_status_list'] = $this->realestate_model->get_features('ref_parent=2');
		$viewData['build_type_list'] = $this->realestate_model->get_features('ref_parent=3');
		$viewData['heating_list'] = $this->realestate_model->get_features('ref_parent=5');
		$viewData['room_list'] = $this->realestate_model->get_features('ref_parent=52');
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->edit_post($id);
		$this->load_view('realestate/form_edit', $viewData);
	}
	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->realestate_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('İlan Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('İlan bilgileri güncellendi');
					redirect('realestate/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('realestate/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post













	// FİRMA SİLME İŞLEMLERİ
	public function delete(){
		if($_POST){
			$id = post("id");
			$realestate = $this->realestate_model->get_realestate($id);
			if(!$realestate){
				echo 'false';
			}else{
				$cover = $realestate->re_cover;
				$delete = $this->realestate_model->delete_realestate($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($cover);
					$imgs = $this->realestate_model->get_realestate_images($id);
					$this->realestate_model->delete_realestate_images($id);
					foreach($imgs as $img){ @unlink(PATH_UPLOAD_IMAGES_REALESTATES.$img->rep_image); }
					echo 'true';
				}
			}
		}
	}//delete



	public function input_validates($add_post=true, $pass=true){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Otel Adı','trim|required|min_length[10]',array(	'required'      => ' %s boş bırakılamaz.','min_length'     => '%s 10 karakterden daha az olamaz.' ));

		$this->form_validation->set_rules('district', 		'İlçe',				'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('estate_status', 	'Emlak durumu',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('estate_type', 	'Emlak tipi',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('build_status', 	'Yapı durumu',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('build_type', 	'Yapı tipi',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('heating', 		'Isıtma sistemi',	'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('room', 			'Oda sayısı',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );

		return $this->form_validation->run();
	}//add_validates


	public function post_datas(){

		$datas = array(
			're_name' 			=> post('name'),
			're_slug' 			=> seo_link(post('name')),
			're_province' 		=> 61,
			're_company' 		=> post('company'),
			're_district' 		=> post('district'),
			're_estate_status' 	=> post('estate_status'),
			're_estate_type' 	=> post('estate_type'),
			're_build_status' 	=> post('build_status'),
			're_build_type' 	=> post('build_type'),
			're_heating' 		=> post('heating'),
			're_room' 			=> post('room'),
			're_area' 			=> post('area'),
			're_age' 			=> post('age'),
			're_floor_total' 	=> post('floor_total'),
			're_floor_number' 	=> post('floor_number'),
			're_description' 	=> post('description'),
			're_features'		=> json_encode(post('features')),
			're_cover'			=> post_cover(),
			're_video'			=> post('video'),
			're_location'		=> post('location'),
			're_finish'			=> post('finish'),
			're_status'			=> post('status')
		);
		return $datas;
	}//post_datas




















	public function add_img($id){
		$sonuc = null;
		if($_FILES['p_img']){
			$config['file_name']            = date('Ymd').time().'-'.rand(1000,9999).uniqid();
			$config['upload_path']          = PATH_UPLOADS.'realestates/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 1024;
			$config['max_width']            = 1600;
			$config['max_height']           = 1600;
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('p_img')){
			  $sonuc['status'] = false;
			  $sonuc['message'] = $this->upload->display_errors();
			  $sonuc['db_status'] = false;
			  set_flashalert("İlan fotoğrafı yüklenirken bir sorun oluştu.\n".$sonuc["message"], 'red');

			}else{
			  $sonuc = $this->upload->data();
			  $sonuc['status'] = true;

			  $db_datas = array(
				  'rep_estate' => $id,
				  'rep_image' => $sonuc['file_name'],
				  'rep_info' => json_encode(array( $sonuc['image_width'], $sonuc['image_height'], $sonuc['file_size'], $sonuc['file_type'], $sonuc['file_ext'] ))
			  );
			  $run = $this->realestate_model->save_img($db_datas);
			  if($run){
				  $sonuc['db_status'] = true;
				  set_flashalert("İlan fotoğrafı yüklendi");
			  }else{
				  $sonuc['db_status'] = false;
				  set_flashalert("İlan fotoğrafı yüklenirken bir sorun oluştu.\nVeritabanı kaydı başarısız.", 'red');
			  }
			}

		}//$_FILE['p_img']
		redirect('realestate/edit/'.$id);
	}//add_img



	public function del_img($id){
		$viewData['pageTitle'] = 'Bir İlan Fotoğrafı Sil';
		$viewData['img'] = $this->realestate_model->get_img_with_join($id);
		$product_id = $viewData['img']->rep_estate;
		if($_POST){
			$del = $this->realestate_model->delete_img_of_realestate($id);
			if(!$del){}else{
				unlink(PATH_UPLOAD_IMAGES_REALESTATES.$del);
			}
			redirect('realestate/edit/'.$product_id);
		}
		$this->load_view('realestate/del_img', $viewData);
	}





}
?>
