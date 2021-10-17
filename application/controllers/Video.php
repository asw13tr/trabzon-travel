<?php
class Video extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('video_model');
	}
















	public function index(){
		$viewData["pageTitle"] = 'VİDEOLAR';
		$viewData["videos"] = $this->video_model->list_video();
		$this->load->model('category_model');
		$viewData["categories"] = $this->category_model->get_items();
		$this->load_view('video/index', $viewData);
	}















	//##################### YENİ VİDEO OLUŞTURMA İŞLEMLERİ
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Video Ekle";
		$this->add_post();
		$this->load_view('video/form_add', $viewData);
	}





	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'video_title' 	=> post('title'),
					'video_url' 	=> post('url'),
					'video_category'=> json_encode(post('category')),
					'video_status' 	=> post('status',0)
				);
				$run = $this->video_model->save('create',$db_datas);
				if( !run ){
					set_flashalert('Video Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Video Eklendi');
					redirect('video/edit/'.$run);
				}
			}//if($this->add_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('video/add');
			}
		}//if($_POST)
	}//add_post
















	//##################### VİDEO DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('video'); exit; }
		$viewData["video"] = $this->video_model->get_video($id);
		if(!$viewData["video"]){ set_flashalert('Video Bulunamadı', 'red'); redirect('video'); exit; }

		$viewData['pageTitle'] = "Bir Video Düzenle";
		$this->edit_post($id);
		$this->load_view('video/form_edit', $viewData);
	}






	public function edit_post($id){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){
				$this->session->set_flashdata('val_'.$key, $val);
			}
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'video_title' 	=> post('title'),
					'video_url' 	=> post('url'),
					'video_category'=> json_encode(post('category')),
					'video_status' 	=> post('status',0)
				);
				$run = $this->video_model->save('update',$db_datas, $id);
				if( !run ){
					set_flashalert('Video Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Video Güncellendi');
					redirect('video/edit/'.$id);
				}
			}//if($this->add_validates() == TRUE)
			else{
				set_flashalert(validation_errors(), 'red');
				redirect('video/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post














	public function delete(){
	if($_POST){
		$id = post("id");
		$video = $this->video_model->get_video($id);
		if(!$video){
			echo 'false';
		}else{
			$delete = $this->video_model->delete_video($id);
			if(!$delete){
				echo 'false';
			}else{
				echo 'true';
			}
		}
	}
	}

/*













*/


	public function input_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Video Başlığı','trim|required|min_length[3]',
								array(
						                'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.'
						        ));

		$this->form_validation->set_rules('url', 'Video Bağlantı Adresi', 'trim|required',
								array(
										'required'      => ' %s boş bırakılamaz.'
								));
		$this->form_validation->set_rules('category[]', 'Kategori', 'required',
								array(
										'required'      => ' %s seçmek zorundasınız.'
								));
		return $this->form_validation->run();
	}//add_validates



}
?>
