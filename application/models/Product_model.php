<?php
class Product_model extends CI_Model{

	private $table_name = 'products';
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
		return $this->db->set($datas)->where('product_id', $id)->update($this->table_name);
	}

	public function save_img($datas){
		return $this->db->insert('product_photos', $datas);
	}

	public function get_companies(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_product_with_join(){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('companies', 'companies.company_id=products.product_company');
		return $this->db->get()->result();
	}

	public function get_linked_categories($id){
		$this->db->select("categories.category_id, categories.category_name");
		$this->db->from("conn_company_category");
		$this->db->join('categories', 'categories.category_id=conn_company_category.ccc_category');
		$this->db->join('companies', 'companies.company_id=conn_company_category.ccc_company');
		$this->db->where('conn_company_category.ccc_company', $id);
		return $this->db->get()->result();
	}

	public function get_product_images($id){
		return $this->db->where('pp_product', $id)->get('product_photos')->result();
	}

	public function delete_product_images($id){
		return $this->db->where('pp_product', $id)->delete('product_photos');
	}

	public function get_product_img($id){
		return $this->db->where('pp_id', $id)->get('product_photos')->row();
	}

	public function get_img_with_join($id){
		$this->db->select("*");
		$this->db->from('product_photos');
		$this->db->join('products', 'products.product_id=product_photos.pp_product');
		$this->db->where('pp_id', $id);
		return $this->db->get()->row();
	}

	public function delete_img_of_product($id){
		$bul = $this->get_product_img($id);
		if($bul){
			$img_src = $bul->pp_image;
			$sil = $this->db->where('pp_id', $id)->delete('product_photos');
			if($sil){
				return $img_src;
			}else{
				return $false;
			}
		}else{
			return false;
		}
	}



	public function get_product($id){
		return $this->db->where('product_id', $id)->get($this->table_name)->row();
	}


	public function get_company_with_join($id){
		$this->db->select("*");
		$this->db->from($this->table_name);
		$this->db->join('cities', 'cities.city_plate=companies.company_province');
		$this->db->join('counties', 'counties.county_id=companies.company_district');
		$this->db->where('companies.company_id', $id);
		return $this->db->get()->row();
	}

	public function get_selected_categories($id){
		$datas = $this->db->where('ccc_company', $id)->get($this->connect_table_name)->result();
		if(!$datas){
			return array();
		}else{
			$datas_array = array();
			foreach($datas as $data){
				$datas_array[] = $data->ccc_category;
			}
			return $datas_array;
		}
	}


	public function delete_product($id){
	    return $this->db->where('product_id', $id)->delete($this->table_name);
	}

	public function connect_category($datas, $company_id){
		$ids = explode('-', $company_id);
		$this->db->where_in('ccc_company', $ids)->delete($this->connect_table_name);
		return $this->db->insert_batch($this->connect_table_name, $datas);
	}

	public function delete_connect_category($company_id){
		return $this->db->where('ccc_company', $company_id)->delete($this->connect_table_name);
	}

	public function list_companies(){
		return $this->db->get($this->table_name)->result();
	}



}//Company_model
?>
