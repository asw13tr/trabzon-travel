<?php
class Realestate_model extends CI_Model{

	private $table_name = 'realestates';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('re_id', $id)->update($this->table_name);
	}

	public function get_realestates(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_realestates_with_join(){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=realestates.re_province');
		$this->db->join('counties', 'counties.county_id=realestates.re_district');
		$this->db->join('companies', 'companies.company_id=realestates.re_company');
		return $this->db->get()->result();
	}


	public function get_realestate($id){
		return $this->db->where('re_id', $id)->get($this->table_name)->row();
	}

	public function get_realestate_with_join($id){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=realestates.re_province');
		$this->db->join('counties', 'counties.county_id=realestates.re_district');
		$this->db->join('companies', 'companies.company_id=realestates.re_company');
		$this->db->where('realestates.re_id', $id);
		return $this->db->get()->row();
	}



	public function delete_realestate($realestate_ids){
		$ids = explode('-', $realestate_ids);
	    return $this->db->where_in('re_id', $ids)->delete($this->table_name);
	}


	public function get_features($where=null){
		return $this->db->where($where)->order_by('ref_name')->get('realestate_features')->result();
	}




	public function save_img($datas){
		return $this->db->insert('realestate_photos', $datas);
	}

	public function get_realestate_images($id){
		return $this->db->where('rep_estate', $id)->get('realestate_photos')->result();
	}

	public function delete_realestate_images($id){
		return $this->db->where('rep_estate', $id)->delete('realestate_photos');
	}

	public function get_realestate_img($id){
		return $this->db->where('rep_id', $id)->get('realestate_photos')->row();
	}

	public function get_img_with_join($id){
		$this->db->select("*");
		$this->db->from('realestate_photos');
		$this->db->join('realestates', 'realestates.re_id=realestate_photos.rep_estate');
		$this->db->where('rep_id', $id);
		return $this->db->get()->row();
	}

	public function delete_img_of_realestate($id){
		$bul = $this->get_realestate_img($id);
		if($bul){
			$img_src = $bul->rep_image;
			$sil = $this->db->where('rep_id', $id)->delete('realestate_photos');
			if($sil){
				return $img_src;
			}else{
				return $false;
			}
		}else{
			return false;
		}
	}



}//Company_model
?>
