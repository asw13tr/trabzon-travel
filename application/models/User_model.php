<?php
class User_model extends CI_Model{

	private $table_name = 'users';

	public function save($task, $datas, $id=null){
		if($task=='create'){ return $this->create($datas); }
		if($task=='update'){ return $this->update($datas, $id); }
	}//save

	private function create($datas){
		$run = $this->db->insert($this->table_name, $datas);
		return !$run? false : $this->db->insert_id();
	}

	private function update($datas, $id){
		return $this->db->set($datas)->where('user_id', $id)->update($this->table_name);
	}

	public function get_user($id){
		return $this->db->where('user_id', $id)->get($this->table_name)->row();
	}

	public function delete_user($ids){
		$ids = explode('-', $ids);
	    return $this->db->where_in('user_id', $ids)->delete($this->table_name);
	}

	public function list_user(){
		return $this->db->get($this->table_name)->result();
	}

	public function get_user_with_oldpassword($id, $oldpassword){
		return $this->db->where('user_id', $id)->where("user_password", $oldpassword)->get($this->table_name)->row();
	}

	public function is_login_user($username, $password){
		$where_datas = array(
			'user_nickname' => $username,
			'user_password' => $password,
			'user_status' 	=> 1,
			'user_level >=' => 2
		);
		
		return $this->db->where($where_datas)->get($this->table_name)->row();
	}

}
?>
