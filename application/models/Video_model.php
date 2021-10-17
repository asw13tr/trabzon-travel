<?php
class Video_model extends CI_Model{

	private $table_name = 'videos';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('video_id', $id)->update($this->table_name);
	}

	public function get_video($id){
		return $this->db->where('video_id', $id)->get($this->table_name)->row();
	}

	public function delete_video($ids){
		$ids = explode('-', $ids);
	    return $this->db->where_in('video_id', $ids)->delete($this->table_name);
	}

	public function list_video(){
		return $this->db->get($this->table_name)->result();
	}

}
?>
