<?php
class Tour extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('tour_model');
		$this->load->model('location_model');
	}

	public function index(){
		$viewData["pageTitle"] = 'Tur Listesi';
		$viewData["tours"] = $this->tour_model->get_tours_with_join();
		$this->load_view('tour/index', $viewData);
	}













	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Tur Ekle";

		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$viewData['categories'] = $this->tour_model->get_features('tf_parent=1');
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->add_post();
		$this->load_view('tour/form_add', $viewData);
	}
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->tour_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('Tur Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Tur Eklendi');
					redirect('tour/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('tour/add');
			}
		}//if($_POST)
	}//add_post











	public function edit($id){
		if(!$id){ redirect('tour'); exit; }
		$viewData["tour"] = $this->tour_model->get_tour_with_join($id);
		$viewData["tour_images"] = $this->tour_model->get_tour_images($id);
		if(!$viewData["tour"]){ set_flashalert('Tur Bulunamadı', 'red'); redirect('tour'); exit; }

		$viewData['pageTitle'] = "Bir Turu Düzenle";
		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$viewData['categories'] = $this->tour_model->get_features('tf_parent=1');
		$viewData["cities"] = $this->location_model->get_cities();
		$viewData["counties"] = $this->location_model->get_counties_by_plate($this->current_plate_no);

		$this->edit_post($id);
		$this->load_view('tour/form_edit', $viewData);
	}
	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->tour_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('Tur Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Tur bilgileri güncellendi');
					redirect('tour/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('tour/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post













	// FİRMA SİLME İŞLEMLERİ
	public function delete(){
		if($_POST){
			$id = post("id");
			$tour = $this->tour_model->get_tour($id);
			if(!$tour){
				echo 'false';
			}else{
				$cover = $tour->tour_cover;
				$delete = $this->tour_model->delete_tour($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($cover);
					$imgs = $this->tour_model->get_tour_images($id);
					$this->tour_model->delete_tour_images($id);
					foreach($imgs as $img){ @unlink(PATH_UPLOAD_IMAGES_TOURS.$img->tp_image); }
					echo 'true';
				}
			}
		}
	}//delete



	public function input_validates($add_post=true, $pass=true){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Tur Başlığı','trim|required|min_length[10]',array(	'required'      => ' %s boş bırakılamaz.','min_length'     => '%s 10 karakterden daha az olamaz.' ));

		$this->form_validation->set_rules('province', 		'Şehir',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('company', 		'Şirket',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('category', 		'Kategori',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('price', 			'Fiyat',		'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('start_time', 	'Başlama Saati','trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('end_time', 		'Bitiş Saati',	'trim|required',array(	'required'=> ' %s seçmek zorundasınız.') );

		return $this->form_validation->run();
	}//add_validates


	public function post_datas(){

		$datas = array(
			'tour_name' 		=> post('name'),
			'tour_slug' 		=> seo_link(post('name')),
			'tour_province' 	=> post('province'),
			'tour_company' 		=> post('company'),
			'tour_category' 	=> post('category'),
			'tour_cover'		=> post_cover(),
			'tour_description'	=> post('description'),
			'tour_price'		=> post('price'),
			'tour_start_date'	=> post('start_date'),
			'tour_end_date'		=> post('end_date'),
			'tour_start_time'	=> post('start_time'),
			'tour_end_time'		=> post('end_time'),
			'tour_inc_services'	=> post('inc_services'),
			'tour_exc_services'	=> post('exc_services'),
			'tour_suggestions'	=> post('suggestions'),
			'tour_visits'		=> post('visits'),
			'tour_status'		=> post('status')
		);
		return $datas;
	}//post_datas




















	public function add_img($id){
		$sonuc = null;
		if($_FILES['p_img']){
			$config['file_name']     = date('Ymd').time().'-'.rand(1000,9999).uniqid();
			$config['upload_path']   = PATH_UPLOADS.'tours/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']      = 1024;
			$config['max_width']     = 1600;
			$config['max_height']    = 1600;
			$this->load->library('upload', $config);

			if(!$this->upload->do_upload('p_img')){
			  $sonuc['status'] = false;
			  $sonuc['message'] = $this->upload->display_errors();
			  $sonuc['db_status'] = false;
			  set_flashalert("Tur fotoğrafı yüklenirken bir sorun oluştu.\n".$sonuc["message"], 'red');

			}else{
			  $sonuc = $this->upload->data();
			  $sonuc['status'] = true;

			  $db_datas = array(
				  'tp_tour' => $id,
				  'tp_image' => $sonuc['file_name'],
				  'tp_info' => json_encode(array( $sonuc['image_width'], $sonuc['image_height'], $sonuc['file_size'], $sonuc['file_type'], $sonuc['file_ext'] ))
			  );
			  $run = $this->tour_model->save_img($db_datas);
			  if($run){
				  $sonuc['db_status'] = true;
				  set_flashalert("Tur fotoğrafı yüklendi");
			  }else{
				  $sonuc['db_status'] = false;
				  set_flashalert("Tur fotoğrafı yüklenirken bir sorun oluştu.\nVeritabanı kaydı başarısız.", 'red');
			  }
			}

		}//$_FILE['p_img']
		redirect('tour/edit/'.$id);
	}//add_img



	public function del_img($id){
		$viewData['pageTitle'] = 'Bir Tur Fotoğrafı Sil';
		$viewData['img'] = $this->tour_model->get_img_with_join($id);
		$product_id = $viewData['img']->tp_tour;
		if($_POST){
			$del = $this->tour_model->delete_img_of_tour($id);
			if(!$del){}else{
				unlink(PATH_UPLOAD_IMAGES_TOURS.$del);
			}
			redirect('tour/edit/'.$product_id);
		}
		$this->load_view('tour/del_img', $viewData);
	}





}
?>
