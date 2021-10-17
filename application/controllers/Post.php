<?php
class Post extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('post_model');
	}

	public function index(){
		$viewData["pageTitle"] = 'YAZILAR';
		$viewData['posts'] = $this->post_model->get_items();
		$this->load_view('post/index', $viewData);
	}




	//##################### YENİ SAYFA OLUŞTURMA İŞLEMLERİ
	public function add(){
		$viewData['pageTitle'] = "Yeni Yazı Oluştur";
		$viewData['categories'] = $this->post_model->categories_with_sub();
		$this->add_post();
		$this->load_view('post/form_add', $viewData);
	}

	public function add_post(){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'post_title' 		=> post('title',''),
					'post_link' 		=> seo_link(post('title','')),
					'post_keywords' 	=> post('keywords',''),
					'post_description' 	=> post('description',''),
					'post_parent' 		=> 0,
					'post_cover' 		=> post_cover(),
					'post_content' 		=> post('content',''),
					'post_status' 		=> post('status',0),
					'post_type' 		=> "post",
					'post_user' 		=> get_session('user_id', 0)
				);

				$categories = post('categories');

				$run = $this->post_model->add_item($db_datas);
				if( !run ){
					set_flashalert('Yazı olulturulamadı lütfen daha sonra tekrar deneyin.');
				}else{
					$post_status_message = 'Yazı Oluşturuldu';
					if(isset($categories[0])){
						$db_datas_connect = array();
						foreach($categories as $cid){
							$db_datas_connect[] = array( 'cpc_post_id'=>$run, 'cpc_category_id'=>$cid );
						}
						$connect_status = $this->post_model->connect_category($db_datas_connect, $run);
						if($connect_status){
							$category_status_message = ' ve seçili kategorilere bağlandı.';
						}else{
							$category_status_message = ' ama kategoriler ile bağlantısı kurulamadı';
						}
					}

					set_flashalert($post_status_message.$category_status_message);
					redirect('post/edit/'.$run);
				}

			}//if($this->add_validates() == TRUE)
		}//if($_POST)
	}//add_post


	public function input_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Yazı Başlığı','required|min_length[3]',
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
		if(!$id){ redirect('post'); exit; }
		$viewData['pageTitle'] = "Bir Yazıyı Düzenle";
		$viewData["post"] = $this->post_model->get_item_by_id($id);
		$viewData['categories'] = $this->post_model->categories_with_sub();

		$viewData['selected_categories'] = $this->post_model->get_selected_categories($id);

		if(!$viewData["post"]){ redirect('post'); exit; }
		$this->edit_post($id);
		$this->load_view('post/form_edit', $viewData);
	}

	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = array(
					'post_title' 		=> post('title',''),
					'post_link' 		=> seo_link(post('title','')),
					'post_keywords' 	=> post('keywords',''),
					'post_description' 	=> post('description',''),
					'post_parent' 		=> 0,
					'post_cover' 		=> post_cover(),
					'post_content' 		=> post('content',''),
					'post_status' 		=> post('status',0),
					'post_type' 		=> "post",
					'post_user' 		=> get_session('user_id', 0)
				);
				$categories = post('categories');

				$run = $this->post_model->update_item($db_datas, $id);
				if( !run ){
					set_flashalert('Yazı güncellenemedi lütfen daha sonra tekrar deneyin.');
				}else{
					$post_status_message = 'Yazı Güncellendi';
					if(isset($categories[0])){
						$db_datas_connect = array();
						foreach($categories as $cid){
							$db_datas_connect[] = array( 'cpc_post_id'=>$id, 'cpc_category_id'=>$cid );
						}
						$connect_status = $this->post_model->connect_category($db_datas_connect, $id);
						if($connect_status){
							$category_status_message = ' ve seçili kategorilere bağlandı.';
						}else{
							$category_status_message = ' ama kategoriler ile bağlantısı kurulamadı';
					}

					set_flashalert($post_status_message.$category_status_message);
					redirect('post/edit/'.$id);
				}
			}//if( !run )

			}//if($this->add_validates() == TRUE)
		}//if($_POST)
	}//edit_post

	public function delete(){
	if($_POST){
		$id = post("id");
		$post = $this->post_model->get_item_by_id($id);
		$imgs = json_decode($post->post_cover);
		if(!$post){
			echo 'false';
		}else{
			$delete = $this->post_model->delete_item($id);
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
