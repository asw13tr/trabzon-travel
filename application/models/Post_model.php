<?php class Post_model extends CI_Model{

	//public $pages_list_with_parent = array();
  private $table_name = 'posts';
  private $connect_table_name = 'conn_post_category';

  public function add_item($datas=false){
    	$insert = $this->db->insert($this->table_name, $datas);
		if(!$insert){
			return false;
		}else{
			return $this->db->insert_id();
		}
  }

  public function update_item($datas=false, $id=false){
        return $this->db->set($datas)->where('post_id', $id)->update($this->table_name);
  }



  public function get_items(){
    return $this->db->where('post_type', 'post')->get($this->table_name)->result();
  }

  public function get_item_by_id($id){
	  return $this->db->where("post_type", "post")->where("post_id", $id)->get($this->table_name)->row();
  }

  public function delete_item($ids){
    $ids = explode('-', $ids);
    return $this->db->where_in('post_id', $ids)->delete($this->table_name);
  }

 	public function connect_category($datas, $post_id){
		$ids = explode('-', $post_id);
		$this->db->where_in('cpc_post_id', $ids)->delete($this->connect_table_name);
		return $this->db->insert_batch($this->connect_table_name, $datas);
	}

	public function get_selected_categories($post_id){
		$categories = $this->db->where('cpc_post_id', $post_id)->get($this->connect_table_name)->result();
		$result = array();
		if($categories){
			foreach($categories as $category){
				$result[] = $category->cpc_category_id;
			}
		}
		return $result;
	}

	public $categories_with_sub = array();
	public function categories_with_sub($parent=0, $repeat=-1){
		$categories = $this->db
								->where('category_parent', $parent)
								->order_by('category_name')
								->get('categories')
								->result();
		if($categories){
			$repeat++;;
			foreach($categories as $category){
				$category->category_empty = str_repeat("    ", $repeat);
				$this->categories_with_sub[] = $category;
				$this->categories_with_sub($category->category_id, $repeat);
			}
		}
		return $this->categories_with_sub;
	}


} ?>
