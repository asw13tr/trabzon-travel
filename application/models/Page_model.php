<?php class Page_model extends CI_Model{

	public $pages_list_with_parent = array();
  /*
  CREATE TABLE `categories` (
    `category_id` int(11) NOT NULL,
    `category_name` varchar(255) NOT NULL,
    `category_link` varchar(255) NOT NULL,
    `category_keywords` varchar(512) DEFAULT NULL,
    `category_parent` int(11) NOT NULL DEFAULT '0',
    `category_cover` varchar(512) NOT NULL DEFAULT '',
    `category_description` varchar(512) DEFAULT NULL,
    `category_insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `category_update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `category_status` tinyint(4) NOT NULL DEFAULT '1',
    `category_show_posts` varchar(10) NOT NULL DEFAULT 'no'
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
  */
  private $table_name = 'posts';

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
    return $this->db->where('post_type', 'page')->get($this->table_name)->result();
  }

  public function get_item_by_id($id){
	  return $this->db->where("post_type", "page")->where("post_id", $id)->get($this->table_name)->row();
  }

  public function delete_item($ids){
    $ids = explode('-', $ids);
    return $this->db->where_in('post_id', $ids)->delete($this->table_name);
  }


  public function get_pages_list_for_select($parent=0, $repeat=-1){
	  $items = $this->db->where('post_parent', $parent)->where('post_type', 'page')->get($this->table_name)->result();
	  if(!$items){
		  return array();
	  }
	  if($items){ $repeat++; }
	  foreach ($items as $key => $value) {
		  $value->post_title = str_repeat("        ", $repeat).$value->post_title;
		  $this->pages_list_with_parent[] = $value;
		  $this->get_pages_list_for_select($value->post_id, $repeat);
	  }
	  return $this->pages_list_with_parent;
  }

  public function pages_list_for_select(){
	  $items = $this->get_pages_list_for_select();
	  if(!$items){
		  return array();
	  }
	  $datas = array();
	  foreach ($items as $item) {
		  $datas[$item->post_id] =  $item->post_title;
	  }
	  return $datas;
  }

} ?>
