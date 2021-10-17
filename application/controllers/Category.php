<?php
class Category extends ASW_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('category_model');
  }

  public function index(){
    $viewData['pageTitle'] = 'Bu bir kategori ekleme sayfasıdır.';
    $viewData['category_items'] = $this->category_model->get_categories_list_for_select();
    $viewData['categories_list_for_select'] = $this->category_model->get_categories_for_selectlist();
    $this->load_view('category/index_view', $viewData);
  }//index


  public function add(){
    $viewData['pageTitle'] = 'Bu bir kategori ekleme sayfasıdır.';
	$viewData['category_items'] = $this->category_model->get_categories_list_for_select();
    $viewData['categories_list_for_select'] = $this->category_model->get_categories_for_selectlist();
    $this->add_post();
    $this->load_view('category/index_view', $viewData);
  }//add

  public function add_post(){
    if($_POST):
      // ==> İNPUT İLE GELEN DEĞERLER ALINIYOR.
      $title       = $this->input->post('title', false);
      $keywords    = $this->input->post('keywords', null);
      $show_posts  = $this->input->post('show_posts', 'no');
      $description = $this->input->post('description', null);
      $status      = $this->input->post('status', null);
      $parent      = $this->input->post('category_parent', 0);
      $covers = false;
      if($this->input->post('cover_hide', false)){    $covers['img']  = $this->input->post('cover_hide'); }
      if($this->input->post('cover_hide_lg', false)){ $covers['lg']   = $this->input->post('cover_hide_lg'); }
      if($this->input->post('cover_hide_md', false)){ $covers['md']   = $this->input->post('cover_hide_md'); }
      if($this->input->post('cover_hide_xs', false)){ $covers['xs']   = $this->input->post('cover_hide_xs'); }
      $cover = $covers!=false? json_encode($covers) : null;

      // ==> VERİ TABANINA YAZILACAK OLAN VERİLER DİZİ İÇERİĞİNE AKTARILIYOR.
      $add_datas = array(
        'category_name'       => $title,
        'category_link'       => seo_link($title),
        'category_keywords'   => $keywords,
        'category_parent'     => $parent,
        'category_cover'      => $cover,
        'category_description'=> $description,
        'category_status'     => $status,
        'category_show_posts' => $show_posts
      );

      // ==> VERİ TABANINA EKLEME İŞLEMİ YAPILIYOR.
      $status_insert = $this->category_model->add_item($add_datas);

      if(!$status_insert){
        echo 'Kategori ekleme başarısız oldu';
      }else{
		set_flashalert("Kategori Oluşturuldu.");
        redirect('/category');
      }

    endif;
  }//add_post






  //============================================================================




  public function edit($id){
	$category = $this->category_model->get_item_by_id($id);
	if(!$category){
		redirect('/category');
	}else{
		$viewData['pageTitle'] = 'Kategori Düzenle';
		$viewData['category_items'] = $this->category_model->get_categories_list_for_select();
	    $viewData['categories_list_for_select'] = $this->category_model->get_categories_for_selectlist();
		$viewData['category'] = $category;
		$this->edit_post($id);
	    $this->load_view('category/edit_category_view', $viewData);
	}
  }//index



  public function edit_post($id){
    if($_POST):
      // ==> İNPUT İLE GELEN DEĞERLER ALINIYOR.
      $title       = $this->input->post('title', false);
      $keywords    = $this->input->post('keywords', null);
      $show_posts  = $this->input->post('show_posts', 'no');
      $description = $this->input->post('description', null);
      $status      = $this->input->post('status', null);
      $parent      = $this->input->post('category_parent', 0);
      $covers = false;
      if($this->input->post('cover_hide', false)){    $covers['img']  = $this->input->post('cover_hide'); }
      if($this->input->post('cover_hide_lg', false)){ $covers['lg']   = $this->input->post('cover_hide_lg'); }
      if($this->input->post('cover_hide_md', false)){ $covers['md']   = $this->input->post('cover_hide_md'); }
      if($this->input->post('cover_hide_xs', false)){ $covers['xs']   = $this->input->post('cover_hide_xs'); }
      $cover = $covers!=false? json_encode($covers) : null;

      // ==> VERİ TABANINA YAZILACAK OLAN VERİLER DİZİ İÇERİĞİNE AKTARILIYOR.
      $post_datas = array(
        'category_name'       => $title,
        'category_link'       => seo_link($title),
        'category_keywords'   => $keywords,
        'category_parent'     => $parent,
        'category_cover'      => $cover,
        'category_description'=> $description,
        'category_status'     => $status,
        'category_show_posts' => $show_posts
      );

      // ==> VERİ TABANINA EKLEME İŞLEMİ YAPILIYOR.
      $status_update = $this->category_model->edit_item($post_datas, $id);

      if(!$status_update){
        echo 'Kategori başarılı bir şekilde güncellendi.';
      }else{
		set_flashalert("Kategori Güncellendi.");
        redirect('/category/edit/'.$id);
      }

    endif;
  }//add_post



  public function delete(){
	if($_POST){
		$ids = $this->input->post('id', false);
		$kategori = $this->category_model->get_item_by_id($ids);
		$cover = $kategori->category_cover;
		if($kategori){
			$do_delete = $this->category_model->delete_item($ids);
			if($do_delete){
				delete_images_from_json($cover);
				echo 'true';
			}else{
				echo 'false';
			}
		}
	}
  }



  public function test(){
	  echo '<pre>';
	  print_r( $this->category_model->select_items() );
  }


  public function select(){
	  asw_pre($this->category_model->get_categories_for_selectlist());
  }

}
?>
