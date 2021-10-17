<?php
class Gallery_model extends CI_Model{

	private $table_name = 'galleries';
	private $table_name_photos = 'gallery_photos';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('gallery_id', $id)->update($this->table_name);
	}

	public function get_gallery($id){
		return $this->db->where('gallery_id', $id)->get($this->table_name)->row();
	}

	public function delete_gallery($ids){
		$ids = explode('-', $ids);
	    return $this->db->where_in('gallery_id', $ids)->delete($this->table_name);
	}

	public function list_gallery(){
		return $this->db->get($this->table_name)->result();
	}

	public function add_photo($id, $img){
		$datas = array(
			'gp_gallery' => $id,
			'gp_img' => $img
		);
		return $this->db->insert($this->table_name_photos, $datas);
	}

	public function get_image($id){
		return $this->db->where('gp_id', $id)->get($this->table_name_photos)->row();
	}

	public function delete_image($ids){
		$ids = explode('-', $ids);
	    return $this->db->where_in('gp_id', $ids)->delete($this->table_name_photos);
	}

	public function get_images($id){
		return $this->db->where('gp_gallery', $id)->get($this->table_name_photos)->result();
	}

	public function delete_images($ids){
		$ids = explode('-', $ids);
	    return $this->db->where_in('gp_gallery', $ids)->delete($this->table_name_photos);
	}

}
?>
