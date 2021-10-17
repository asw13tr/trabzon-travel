<?php
class Account extends ASW_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
	}



	public function index(){
		if(get_session('lui_session', false)){ redirect(); }{ redirect('account/login'); }
	}



	public function login($sts=null){
		if(get_session('lui_session', false)){ redirect(); }
		$datas = array();
		$this->login_post();
		if($sts=='error'){
			$datas['login_status'] = array(false, 'Giriş Başarısız. Lütfen yeniden deneyin.'); 
		}elseif($sts=='success'){
			$datas['login_status'] = array(true, 'Giriş yapıldı. Yönlendiriliyorsunuz.'); 
		}
		$this->load->view('account/login.php', $datas);
	}



	public function login_post(){
		if($_POST){
			$data = array();
			$data['status'] = true;
			$username = post('trvluname');
			$password = convert_password(post('trvlpword'));

			if(!$username || !$password){
				$data['status'] = false;
				redirect('account/login/error');
			}else{
				$user = $this->user_model->is_login_user($username, $password);
				if(!$user){
					redirect('account/login/error');
				}else{
					set_sessions( array(
						'lui_session' => true,
						'lui_id' => $user->user_id
					) );
					redirect('');
				}
			}
		}//POST
	}//FUNCTİON


	public function logout(){
		if(!get_session('lui_session', false)){ redirect('account/login'); }
		session_destroy();
		unset($asw_user);
		redirect('account/login');
	}



	public function access_denied(){
		echo 'Bu panele erişiminiz engellendi.';
	}


}
?>
