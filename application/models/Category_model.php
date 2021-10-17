<?php class Category_model extends CI_Model{

	public $categories_list_with_parent = array();
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
  private $table_name = 'categories';

  public function add_item($datas=false){
        return $this->db->insert($this->table_name, $datas);
  }

  public function edit_item($datas=false, $id=false){
        return $this->db->set($datas)->where('category_id', $id)->update($this->table_name);
  }

  public function get_items(){
    return $this->db->get($this->table_name)->result();
  }

  public function get_item_by_id($id){
	  return $this->db->where("category_id", $id)->get($this->table_name)->row();
  }

  public function delete_item($ids){
    $ids = explode('-', $ids);
    return $this->db->where_in('category_id', $ids)->delete($this->table_name);
  }


  public function get_categories_list_for_select($parent=0, $repeat=-1){
	  $items = $this->db->where('category_parent', $parent)->get($this->table_name)->result();
	  if($items){ $repeat++; }
	  foreach ($items as $key => $value) {
		  $value->category_name = str_repeat("        ", $repeat).$value->category_name;
		  $this->categories_list_with_parent[] = $value;
		  $this->get_categories_list_for_select($value->category_id, $repeat);
	  }


	  return $this->categories_list_with_parent;
  }

  public function categories_list_for_select(){
	  $items = $this->get_categories_list_for_select();
	  $datas = array();
	  foreach ($items as $item) {
		  $datas[$item->category_id] =  $item->category_name;
	  }
	  return $datas;
  }

  //==========================================================================================
  public $categories_for_selectlist = array();
  public function create_categories_for_selectlist($parent=0, $repeat=-1){
	  $kats = $this->db->where('category_parent', $parent)->get($this->table_name)->result();
	  if($kats){
		  $repeat++;
		  foreach($kats as $kat){
			  $this->categories_for_selectlist[$kat->category_id] = str_repeat('        ', $repeat).$kat->category_name;
			  $this->create_categories_for_selectlist($kat->category_id, $repeat);
		  }
	  }
  }//create_categories_for_selectlist
  public function get_categories_for_selectlist(){
	  $this->create_categories_for_selectlist();
	  return $this->categories_for_selectlist;
  }//get_categories_for_selectlist
  //==========================================================================================

  public $categories_with_sub = array();
  public function categories_with_sub($parent=0, $repeat=-1){
	  $categories = $this->db
							  ->where('category_parent', $parent)
							  ->order_by('category_name')
							  ->get($this->table_name)
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
  }//categories_with_sub

} ?>
