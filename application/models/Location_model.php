<?php
class Location_model extends CI_Model{

	private $city_table_name = 'cities';
	private $county_table_name = 'counties';

	public function get_cities(){
		return $this->db->get($this->city_table_name)->result();
	}

	public function get_counties(){
		return $this->db->get($this->county_table_name)->result();
	}

	public function get_counties_by_plate($plate_no){
		return $this->db->where('county_city_plate', $plate_no)->get($this->county_table_name)->result();
	}

}
?>
