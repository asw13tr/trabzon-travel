<?php
class Gallery extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('gallery_model');
	}
















	public function index(){
		$viewData["pageTitle"] = 'FOTOĞRAF GALERİLERİ';
		$viewData["galleries"] = $this->gallery_model->list_gallery();
		$this->load->model('category_model');
		$viewData["categories"] = $this->category_model->get_items();
		$this->load_view('gallery/index', $viewData);
	}















	//##################### YENİ VİDEO OLUŞTURMA İŞLEMLERİ
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Galeri Ekle";
		$this->add_post();
		$this->load_view('gallery/form_add', $viewData);
	}





	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'gallery_title' 	=> post('title'),
					'gallery_cover' 	=> post_cover(),
					'gallery_category'=> json_encode(post('category')),
					'gallery_status' 	=> post('status',0)
				);
				$run = $this->gallery_model->save('create',$db_datas);
				if( !run ){
					set_flashalert('Galeri Oluşturulamadı. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Galeri Oluşturuldu şimdi galeri için fotoğraflarınızı ekleyin.');
					redirect('gallery/edit/'.$run);
				}
			}//if($this->add_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('gallery/add');
			}
		}//if($_POST)
	}//add_post
















	//##################### VİDEO DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('gallery'); exit; }
		$viewData["gallery"] = $this->gallery_model->get_gallery($id);
		$viewData["photos"] = $this->gallery_model->get_images($id);
		if(!$viewData["gallery"]){ set_flashalert('Galeri Bulunamadı', 'red'); redirect('gallery'); exit; }

		$viewData['pageTitle'] = "Bir Galeriyi Düzenle";
		$this->edit_post($id);
		$this->load_view('gallery/form_edit', $viewData);
	}






	public function edit_post($id){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'gallery_title' 	=> post('title'),
					'gallery_cover' 	=> post_cover(),
					'gallery_category'=> json_encode(post('category')),
					'gallery_status' 	=> post('status',0)
				);
				$run = $this->gallery_model->save('update',$db_datas, $id);
				if( !run ){
					set_flashalert('Galeri bilgileri güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Galeri bilgileri güncellendi.');
					redirect('gallery/edit/'.$id);
				}
			}//if($this->add_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('gallery/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post














	public function delete(){
	if($_POST){
		$id = post("id");
		$gallery = $this->gallery_model->get_gallery($id);
		if(!$gallery){
			echo 'false';
		}else{
			$delete = $this->gallery_model->delete_gallery($id);
			if(!$delete){
				echo 'false';
			}else{
				echo 'true';
				$images = $this->gallery_model->get_images($id);
				$del_images = $this->gallery_model->delete_images($id);
				if($del_images){
					foreach ($images as $img) {
						unlink(PATH_UPLOADS."gallery-photos/".$img->gp_img);
					}
				}//if($del_images){
			}
		}
	}
	}



	public function delete_image(){
	if($_POST){
		$id = post("id");
		$image = $this->gallery_model->get_image($id);
		if(!$image){
			echo 'false';
		}else{
			$delete = $this->gallery_model->delete_image($id);
			if(!$delete){
				echo 'false';
			}else{
				echo 'true';
				unlink(PATH_UPLOADS."gallery-photos/".$image->gp_img);
			}
		}
	}
	}//delete_image()



	public function input_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Galeri Başlığı','trim|required|min_length[3]',
								array(
						                'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.'
						        ));
		$this->form_validation->set_rules('cover_hide', 'Kapak Fotoğrafı', 'trim|required',
								array(
										'required'      => ' %s seçmek zorundasınız.'
								));
		$this->form_validation->set_rules('category[]', 'Kategori', 'required',
								array(
										'required'      => ' %s seçmek zorundasınız.'
								));
		return $this->form_validation->run();
	}//add_validates








	public function upload($id){
		if(!empty($_FILES) && $id){
			  $config['file_name']            = date('Ymd').time().'-'.rand(1000,9999).uniqid();
			  $config['upload_path']          = PATH_UPLOADS.'gallery-photos/';
			  $config['allowed_types']        = 'gif|jpg|png|jpeg';
			  $config['max_size']             = 5120;
			  $config['max_width']            = 2600;
			  $config['max_height']           = 2200;

			  $this->load->library('upload', $config);

			  if(!$this->upload->do_upload('file')){
			    $sonuc['status'] = false;
			    $sonuc['message'] = $this->upload->display_errors();
				$ekran = "false";
			  }else{
			    $sonuc = $this->upload->data();
			    $sonuc['status'] = true;
				$addphoto = $this->gallery_model->add_photo($id, $sonuc['file_name']);
				$ekran = $sonuc['file_name'];
			  }

			  echo $ekran;
		}
	}//upload_et



}
?>
