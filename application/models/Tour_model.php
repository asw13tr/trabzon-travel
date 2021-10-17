<?php
class Tour_model extends CI_Model{

	private $table_name = 'tours';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('tour_id', $id)->update($this->table_name);
	}

	public function get_tours(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_tours_with_join(){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=tours.tour_province');
		//$this->db->join('counties', 'counties.county_id=tours.tour_district');
		$this->db->join('companies', 'companies.company_id=tours.tour_company');
		return $this->db->get()->result();
	}


	public function get_tour($id){
		return $this->db->where('tour_id', $id)->get($this->table_name)->row();
	}

	public function get_tour_with_join($id){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=tours.tour_province');
		#$this->db->join('counties', 'counties.county_id=tours.tour_district');
		$this->db->join('companies', 'companies.company_id=tours.tour_company');
		$this->db->where('tours.tour_id', $id);
		return $this->db->get()->row();
	}



	public function delete_tour($tour_ids){
		$ids = explode('-', $tour_ids);
	    return $this->db->where_in('tour_id', $ids)->delete($this->table_name);
	}


	public function get_features($where=null){
		return $this->db->where($where)->order_by('tf_name')->get('tour_features')->result();
	}




	public function save_img($datas){
		return $this->db->insert('tour_photos', $datas);
	}

	public function get_tour_images($id){
		return $this->db->where('tp_tour', $id)->get('tour_photos')->result();
	}

	public function delete_tour_images($id){
		return $this->db->where('tp_tour', $id)->delete('tour_photos');
	}

	public function get_tour_img($id){
		return $this->db->where('tp_id', $id)->get('tour_photos')->row();
	}

	public function get_img_with_join($id){
		$this->db->select("*");
		$this->db->from('tour_photos');
		$this->db->join('tours', 'tours.tour_id=tour_photos.tp_tour');
		$this->db->where('tp_id', $id);
		return $this->db->get()->row();
	}

	public function delete_img_of_tour($id){
		$bul = $this->get_tour_img($id);
		if($bul){
			$img_src = $bul->tp_image;
			$sil = $this->db->where('tp_id', $id)->delete('tour_photos');
			if($sil){
				return $img_src;
			}else{
				return $false;
			}
		}else{
			return false;
		}
	}



}//Tour_model
?>
