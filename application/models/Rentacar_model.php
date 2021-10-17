<?php
class rentacar_model extends CI_Model{

	private $table_name = 'cars';
	private $connect_table_name = 'conn_company_category';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('car_id', $id)->update($this->table_name);
	}

	public function get_cars(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_cars_with_join(){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('companies', 'companies.company_id=cars.car_company');
		return $this->db->get()->result();
	}


	public function get_car($id){
		return $this->db->where('car_id', $id)->get($this->table_name)->row();
	}

	public function get_car_datas(){
		return $this->db->get('rac_datas')->result();
	}

	public function get_car_with_join($id){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('companies', 'companies.company_id=cars.car_company');
		$this->db->where('cars.car_id', $id);
		return $this->db->get()->row();
	}



	public function delete_car($car_ids){
		$ids = explode('-', $car_ids);
	    return $this->db->where_in('car_id', $ids)->delete($this->table_name);
	}


	public function get_features(){
		return $this->db->get('cars_features')->result();
	}



}//Company_model
?>
