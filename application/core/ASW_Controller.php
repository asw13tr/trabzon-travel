<?php
class ASW_Controller extends CI_Controller{

  public function __construct(){
    parent::__construct();

    if(get_session('lui_session', false) && get_session('lui_id', false)){
      $login_user_id = get_session('lui_id');
      global $asw_user;
      $this->load->model('user_model');
      $user = $this->user_model->get_user($login_user_id);
      if(!$user){
        $asw_user = null;
      }else{
        unset($user->user_password); 
        $asw_user = $user;
      }
    }
  }


  public function load_view($file, $datas=null){
    $this->admin_login_control();
    $pageTitle = isset($datas['pageTitle'])? $datas['pageTitle'] : PAGE_TITLE ;
    $pageDescription = isset($datas['pageDescription'])? $datas['pageDescription'] : PAGE_DESCRIPTION ;
    require_once(VIEWPATH.'/inc/header.php');
    require_once(VIEWPATH.'/inc/sidebar.php');
    echo '<div id="right"><div id="rightin"><div id="bigtitle"><h1>'.$pageTitle;
    if(get_session('lui_session', false)){ echo '<a href="'.url('account/logout').'" class="pull-right"><small>Çıkış Yap</small></a>'; }
    echo '</h1></div>';
  echo '<div id="rcontent" class="customScroll">';
  get_flashalert();

  echo '<div class="clearfix"></div>
  <!--<div class="container p0 m0">-->';

    $getViewContent = $this->load->view($file, $datas, TRUE);
    echo $getViewContent;
    echo '<!--</div>--><!-- .container --></div><!-- #rcontent --></div><!-- .rightin --></div><!-- .right -->';
    require_once(VIEWPATH.'/inc/footer.php');


  }

  public function admin_login_control(){
    global $asw_user;
    if(!$asw_user){
      redirect('account/login');
    }else{
      if($asw_user->user_status!=1 || $asw_user->user_level<2){
        redirect('account/access_denied');
      }
    }
  }

}
?>
