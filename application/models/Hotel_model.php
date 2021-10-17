<?php
class Hotel_model extends CI_Model{

	private $table_name = 'hotels';
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
		return $this->db->set($datas)->where('hotel_id', $id)->update($this->table_name);
	}

	public function get_hotels(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_hotels_with_join(){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=hotels.hotel_province');
		$this->db->join('counties', 'counties.county_id=hotels.hotel_district');
		return $this->db->get()->result();
	}


	public function get_hotel($id){
		return $this->db->where('hotel_id', $id)->get($this->table_name)->row();
	}

	public function get_hotel_with_join($id){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=hotels.hotel_province');
		$this->db->join('counties', 'counties.county_id=hotels.hotel_district');
		$this->db->where('hotels.hotel_id', $id);
		return $this->db->get()->row();
	}



	public function delete_hotel($hotel_ids){
		$ids = explode('-', $hotel_ids);
	    return $this->db->where_in('hotel_id', $ids)->delete($this->table_name);
	}


	public function get_features(){
		return $this->db->get('hotel_features')->result();
	}



}//Company_model
?>
