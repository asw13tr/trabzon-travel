<?php
class Page extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('page_model');
	}

	public function index(){
		$viewData["pageTitle"] = 'SAYFALAR';
		$viewData['posts'] = $this->page_model->get_items();
		$this->load_view('page/index', $viewData);
	}




	//##################### YENİ SAYFA OLUŞTURMA İŞLEMLERİ
	public function add(){
		$viewData['pageTitle'] = "Yeni Sayfa Oluştur";
		$pages_list_for_select = $this->page_model->pages_list_for_select();
		$viewData['pages_list_for_select'] = !$pages_list_for_select? array("0"=>"Sayfa Yok") : $pages_list_for_select;
		$this->add_post();
		$this->load_view('page/form_add', $viewData);
	}

	public function add_post(){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'post_title' 		=> post('title',''),
					'post_link' 		=> seo_link(post('title','')),
					'post_keywords' 	=> post('keywords',''),
					'post_description' 	=> post('description',''),
					'post_parent' 		=> post('post_parent',0),
					'post_cover' 		=> post_cover(),
					'post_content' 		=> post('content',''),
					'post_status' 		=> post('status',0),
					'post_type' 		=> "page",
					'post_user' 		=> get_session('user_id', 0)
				);

				$run = $this->page_model->add_item($db_datas);
				if( !run ){
					set_flashalert('Sayfa olulturulamadı lütfen daha sonra tekrar deneyin.');
				}else{
					set_flashalert('Sayfa Oluşturuldu.');
					redirect('page/edit/'.$run);
				}

			}//if($this->add_validates() == TRUE)
		}//if($_POST)
	}//add_post


	public function input_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Sayfa Başlığı','required|min_length[3]',
								array(
						                'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 3 karakterden daha az olamaz.'
						        ));
		$this->form_validation->set_rules('content', 'İçerik', 'required|min_length[15]',
								array(
										'required'      => ' %s boş bırakılamaz.',
										'min_length'     => '%s 15 karakterden daha az olamaz.'
								));
		return $this->form_validation->run();
	}//add_validates



	//##################### SAYFA DÜZENLEME İŞLEMLERİ
	public function edit($id){
		if(!$id){ redirect('page'); exit; }
		$viewData['pageTitle'] = "Bir Sayfayı Düzenle";
		$pages_list_for_select = $this->page_model->pages_list_for_select();
		$viewData['pages_list_for_select'] = !$pages_list_for_select? array("0"=>"Sayfa Yok") : $pages_list_for_select;
		$viewData["post"] = $this->page_model->get_item_by_id($id);
		if(!$viewData["post"]){ redirect('page'); exit; }
		$this->edit_post($id);
		$this->load_view('page/form_edit', $viewData);
	}

	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'post_title' 		=> post('title',''),
					'post_link' 		=> seo_link(post('title','')),
					'post_keywords' 	=> post('keywords',''),
					'post_description' 	=> post('description',''),
					'post_parent' 		=> post('post_parent',0),
					'post_cover' 		=> post_cover(),
					'post_content' 		=> post('content',''),
					'post_status' 		=> post('status',0),
					'post_type' 		=> "page",
					'post_user' 		=> get_session('user_id', 0)
				);

				$run = $this->page_model->update_item($db_datas, $id);
				if( !run ){
					set_flashalert('Sayfa güncellendi lütfen daha sonra tekrar deneyin.');
				}else{
					set_flashalert('Sayfa Güncellendi.');
					redirect('page/edit/'.$id);
				}

			}//if($this->add_validates() == TRUE)
		}//if($_POST)
	}//edit_post

	public function delete(){
	if($_POST){
		$id = post("id");
		$page = $this->page_model->get_item_by_id($id);
		$imgs = json_decode($page->post_cover);
		if(!$page){
			echo 'false';
		}else{
			$delete = $this->page_model->delete_item($id);
			if(!$delete){
				echo 'false';
			}else{
				foreach ($imgs as $img) {
					if( file_exists(PATH_UPLOAD_IMAGES.$img) ){ unlink(PATH_UPLOAD_IMAGES.$img); }
				}
				echo 'true';
			}
		}
	}
	}

}
?>
