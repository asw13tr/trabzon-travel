<?php
class Rentacar extends ASW_Controller{
	private $current_plate_no = 61;


	public function __construct(){
		parent::__construct();
		$this->load->model('company_model');
		$this->load->model('rentacar_model');
		$this->load->model('location_model');
		$this->load->model("category_model");
	}

	public function index(){
		$viewData["pageTitle"] = 'Araç Listesi';
		$car_datas = $this->rentacar_model->get_car_datas();
		$viewData['car_datas'] = null;
		if($car_datas){ foreach($car_datas as $f){ $viewData['car_datas'][$f->id] = $f->name; } }

		$viewData["cars"] = $this->rentacar_model->get_cars_with_join();
		$this->load_view('rentacar/index', $viewData);
	}












	//### YENİ FİRMA OLUŞTURMA FORMUNU GÖSTERECEK OLAN KODLAR.
	public function add(){
		$viewData['pageTitle'] = "Yeni Bir Araç Ekle";

		$viewData['features'] 	= $this->rentacar_model->get_features();
		//$viewData["cities"] 	= $this->location_model->get_cities();
		//$viewData["counties"] 	= $this->location_model->get_counties_by_plate($this->current_plate_no);
		$viewData['companies'] 	= $this->company_model->get_companies_with_join();
		$viewData['carDatas'] 	= $this->rentacar_model->get_car_datas();

		$this->add_post();
		$this->load_view('rentacar/form_add', $viewData);
	}
	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function add_post(){
		if($_POST){
			foreach( $this->input->post() as $key => $val ){ $this->session->set_flashdata('val_'.$key, $val); }
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->rentacar_model->save('create',$db_datas);
				if( !$run ){
					set_flashalert('Araç Eklenenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Araç Eklendi');
					redirect('rentacar/edit/'.$run);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('rentacar/add');
			}
		}//if($_POST)
	}//add_post










	//##################### FİRMA DÜZENLEME İŞLEMLERİ
	public function edit($id){
		$viewData['pageTitle'] = "Bir Araç Düzenle";

		if(!$id){ redirect('rentacar'); exit; }
		$viewData["car"] = $this->rentacar_model->get_car_with_join($id);
		if(!$viewData["car"]){ set_flashalert('Araç Bulunamadı', 'red'); redirect('rentacar'); exit; }
		$viewData['features'] 	= $this->rentacar_model->get_features();
		//$viewData["cities"] 	= $this->location_model->get_cities();
		//$viewData["counties"] 	= $this->location_model->get_counties_by_plate($this->current_plate_no);
		$viewData['companies'] 	= $this->company_model->get_companies_with_join();
		$viewData['carDatas'] 	= $this->rentacar_model->get_car_datas();

		$this->edit_post($id);
		$this->load_view('rentacar/form_edit', $viewData);
	}
	//### YENİ FİRMA OLUŞTURMA FORMU POST EDİLDİĞİNDE ÇALIŞACAK OLAN KODLAR.
	public function edit_post($id){
		if($_POST){
			if($this->input_validates() == TRUE){
				$db_datas = $this->post_datas();
				$run = $this->rentacar_model->save('update',$db_datas, $id);
				if( !$run ){
					set_flashalert('Araç Güncellenemedi. Sistemde beklenmedik bir hata oluştu. Lütfen daha sonra tekrar deneyin.', 'red');
				}else{
					set_flashalert('Araç bilgileri güncellendi');
					redirect('rentacar/edit/'.$id);
				}
			}else{
				set_flashalert(validation_errors(), 'red');
				redirect('rentacar/edit/'.$id);
			}
		}//if($_POST)
	}//edit_post













	// FİRMA SİLME İŞLEMLERİ
	public function delete(){
		if($_POST){
			$id = post("id");
			$car = $this->rentacar_model->get_car($id);
			$img = $car->car_cover;
			if(!$car){
				echo 'false';
			}else{
				$delete = $this->rentacar_model->delete_car($id);
				if(!$delete){
					echo 'false';
				}else{
					delete_images_from_json($img);
					echo 'true';
				}
			}
		}
	}//delete



	public function input_validates($add_post=true, $pass=true){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Araç adı','trim|required|min_length[10]',
								array(	'required'      => ' %s boş bırakılamaz.',
						                'min_length'     => '%s 10 karakterden daha az olamaz.' ));

		$this->form_validation->set_rules('person', 'Araç kişi sayısı', 'trim|required',array(			'required' => ' %s boş bırakılamaz.'));
		$this->form_validation->set_rules('model', 'Araç model','trim|required|min_length[4]',array(	'required' => ' %s boş bırakılamaz.', 'min_length'     => '%s 4 karakterden daha az olamaz.' ));
		$this->form_validation->set_rules('power', 'Motor gücü','trim|required|min_length[2]',array(	'required' => ' %s boş bırakılamaz.', 'min_length'     => '%s 2 karakterden daha az olamaz.' ));
		$this->form_validation->set_rules('door', 'Kapı sayısı','trim|required',array(					'required' => ' %s boş bırakılamaz.'));
		$this->form_validation->set_rules('baggage', 'Bagaj kapasitesi','trim|required',array(			'required' => ' %s boş bırakılamaz.'));
		$this->form_validation->set_rules('age', 'Minimum sürücü yaşı','trim|required|min_length[2]',array(	'required'      => ' %s boş bırakılamaz.', 'min_length'     => '%s 2 karakterden daha az olamaz.' ));
		$this->form_validation->set_rules('license', 'Minimum ehliyet yılı','trim|required',array(		'required' => ' %s boş bırakılamaz.'));
		$this->form_validation->set_rules('price', 'Günlük fiyat','trim|required|min_length[2]',array(	'required' => ' %s boş bırakılamaz.', 'min_length'     => '%s 2 karakterden daha az olamaz.' ));

		$this->form_validation->set_rules('company', 'Tedarikçi firma','trim|required',array( 'required' => ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('class', 'Araç sınıfı','trim|required',array( 'required' => ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('fuel', 'Yakıt Türü','trim|required',array( 'required' => ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('gear', 'Vites Tipi','trim|required',array( 'required' => ' %s seçmek zorundasınız.') );
		$this->form_validation->set_rules('hatch', 'Kasa Tipi','trim|required',array( 'required' => ' %s seçmek zorundasınız.') );

		return $this->form_validation->run();
	}//add_validates






	//Posttan gelen verileri alma işlemleri
	public function post_datas(){

		$datas = array(
			'car_name' 			=> post('name'),
			'car_slug' 			=> seo_link(post('name')),
			'car_cover' 		=> post_cover(),
			'car_company' 		=> post('company'),
			'car_class' 		=> post('class'),
			'car_fuel' 			=> post('fuel'),
			'car_gear' 			=> post('gear'),
			'car_hatch' 		=> post('hatch'),
			'car_model' 		=> post('model'),
			'car_description'	=> post('description'),
			'car_power' 		=> post('power'),
			'car_person' 		=> post('person'),
			'car_door' 			=> post('door'),
			'car_baggage' 		=> post('baggage'),
			'car_driver_age' 	=> post('age'),
			'car_license' 		=> post('license'),
			'car_status' 		=> post('status'),
			'car_price' 		=> post('price'),
			'car_features'		=> json_encode(post('features')),
		);
		return $datas;
	}//post_datas





}
?>
