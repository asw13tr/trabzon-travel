<?php
require_once(FCPATH.'extraphp/verot_upload/class.verot_upload.php');
class Product extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('location_model');
		$this->load->model("product_model");
	}

	public function index(){
		$viewData["pageTitle"] = 'Ürün Listesi';
		$viewData["products"] = $this->product_model->get_product_with_join();
		$this->load_view('product/index', $viewData);
	}


	//### YENİ ÜRÜN OLUŞTURMA FORMUNU GÖSTERECEK OLAN KODLAR.
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Ürün Ekle";
		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$this->add_post();
		$this->load_view('product/form_add', $viewData);
	}

	//### YENİ ÜRÜN EKLEME FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->product_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('Ürün Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Ürün Eklendi');
					redirect('product/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('product/add');
			}
		}//if($_POST)
	}//add_post


	//##################### FİRMA DÜZENLEME İŞLEMLERİ
	public function edit($id){
		$viewData['pageTitle'] = "Bir Ürünü Düzenle";
		$viewData['companies'] = $this->company_model->get_companies_with_join();
		$viewData["product"] = $this->product_model->get_product($id);
		$viewData["product_images"] = $this->product_model->get_product_images($id);
		$this->edit_post($id);
		$this->load_view('product/form_edit', $viewData);
	}

	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->product_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('Ürün Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Ürün Güncellendi');
					redirect('product/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('product/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post




//----------------------------------------
	public function add_img($id){
		$sonuc = null;
		if($_FILES['p_img']){
			$config['file_name']            = date('Ymd').time().'-'.rand(1000,9999).uniqid();
		    $config['upload_path']          = PATH_UPLOADS.'products/';
		    $config['allowed_types']        = 'gif|jpg|png|jpeg';
		    $config['max_size']             = 1024;
		    $config['max_width']            = 1600;
		    $config['max_height']           = 1600;
		    $this->load->library('upload', $config);

		    if(!$this->upload->do_upload('p_img')){
		      $sonuc['status'] = false;
		      $sonuc['message'] = $this->upload->display_errors();
			  $sonuc['db_status'] = false;
			  set_flashalert("Ürün fotoğrafı yüklenirken bir sorun oluştu.\n".$sonuc["message"], 'red');

		    }else{
		      $sonuc = $this->upload->data();
		      $sonuc['status'] = true;

			  $db_datas = array(
				  'pp_product' => $id,
				  'pp_image' => $sonuc['file_name'],
				  'pp_info' => json_encode(array( $sonuc['image_width'], $sonuc['image_height'], $sonuc['file_size'], $sonuc['file_type'], $sonuc['file_ext'] ))
			  );
			  $run = $this->product_model->save_img($db_datas);
			  if($run){
				  $sonuc['db_status'] = true;
				  set_flashalert("Ürün fotoğrafı yüklendi");
			  }else{
				  $sonuc['db_status'] = false;
				  set_flashalert("Ürün fotoğrafı yüklenirken bir sorun oluştu.\nVeritabanı kaydı başarısız.", 'red');
			  }
		    }

		}//$_FILE['p_img']
		redirect('product/edit/'.$id);
	}//add_img



	public function del_img($id){
		$viewData['pageTitle'] = 'Bir Ürün Fotoğrafı Sil';
		$viewData['img'] = $this->product_model->get_img_with_join($id);
		$product_id = $viewData['img']->pp_product;
		if($_POST){
			$del = $this->product_model->delete_img_of_product($id);
			if(!$del){}else{
				unlink(PATH_UPLOAD_IMAGES_PRODUCTS.$del);
			}
			redirect('product/edit/'.$product_id);
		}
		$this->load_view('product/del_img', $viewData);
	}







	// FİRMA SİLME İŞLEMLERİ
	public function delete(){
		if($_POST){
			$id = post("id");
			$product = $this->product_model->get_product($id);
			if(!$product){
				echo 'false';
			}else{
				$cover = $product->product_cover;
				$delete = $this->product_model->delete_product($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($cover);
					$imgs = $this->product_model->get_product_images($id);
					$this->product_model->delete_product_images($id);
					foreach($imgs as $img){ @unlink(PATH_UPLOAD_IMAGES_PRODUCTS.$img->pp_image); }
					echo 'true';
				}
			}
		}
	}//delete




	public function input_validates(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Ürün Adı','trim|required|min_length[3]',
								array(	'required'      => ' %s boş bırakılamaz.',
										'min_length'     => '%s 3 karakterden daha az olamaz.' ));
		$this->form_validation->set_rules('price', 'Ürün Fiyatı','trim|required',
								array(	'required'      => ' %s boş bırakılamaz.'));

		return $this->form_validation->run();
	}//add_validates


	//Posttan gelen verileri alma işlemleri
	public function post_datas(){
		$datas = array(
			'product_title' 	=> post('title'),
			'product_slug' 		=> seo_link(post('title')),
			'product_cover' 	=> post_cover(),
			'product_company' 	=> post('company'),
			'product_content' 	=> post('content'),
			'product_price' 	=> post('price'),
			'product_status' 	=> post('status')
		);
		return $datas;
	}//post_datas





}
?>
