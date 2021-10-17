<?php
require_once(FCPATH.'extraphp/verot_upload/class.verot_upload.php');
class Uploadfile extends CI_Controller{


  public function __construct(){
    parent::__construct();
    $this->load->library('image_lib');
  }

/*
  public function image(){
		$finishUpload = false;
		if($_FILES["image"]){
      echo "\n resim seçildi";
		$classVerot = new verot_upload($_FILES['image']);
		if($classVerot->uploaded) {

			$imageName = date('Ymd').time().'-'.rand(100,999).uniqid();
			$upXS = $this->imgUpload($classVerot, 'xs-'.$imageName, true, 150, false, 150, false, false, 'png', 9 );
			if($upXS!=false){
				$uploads['imgNameXS'] = $upXS;
				$upMD = $this->imgUpload($classVerot, 'md-'.$imageName, true, 750, false, 500, true, false, 'jpg', 5, 80 );

				if($upMD!=false){
					$uploads['imgNameMD'] = $upMD;
					$upLG = $this->imgUpload($classVerot, 'lg-'.$imageName, true, 1200, false, 1200, true, false, false, null, 100 );

					if($upLG!=false){
						$uploads['imgNameLG'] = $upLG;
						$uploads['imgName'] = $imageName;
						$uploads['status'] = true;
					}else{
						$uploads['status'] = false;
					}
				}
			}

		$classVerot->Clean();
		}
		}//if($_FILES["image"])
		echo json_encode($uploads);
}// image
*/

public function form(){
?>
<form action="<?php echo base_url('uploadfile/image_ajax'); ?>" method="post" enctype="multipart/form-data">

  <input type="file" name="image" id="image">
  <input type="text" name="deneme" value="">
  <input type="text" name="isSend" value="">
  <button type="submit" name="button">Gönder</button>

</form>
<?php
}

public function delete_ajax(){
if($_POST){
	$img = $_POST["img"];
	$xs = $_POST["xs"];
	$md = $_POST["md"];
	$lg = $_POST["lg"];

	if( file_exists(PATH_UPLOAD_IMAGES.$img) ){ unlink(PATH_UPLOAD_IMAGES.$img); }
	if( file_exists(PATH_UPLOAD_IMAGES.$xs) ){ unlink(PATH_UPLOAD_IMAGES.$xs); }
	if( file_exists(PATH_UPLOAD_IMAGES.$md) ){ unlink(PATH_UPLOAD_IMAGES.$md); }
	if( file_exists(PATH_UPLOAD_IMAGES.$lg) ){ unlink(PATH_UPLOAD_IMAGES.$lg); }
	echo 'true';
}
}

public function image_ajax(){
  echo $this->image();
}


public function image(){
  $data['status'] = false;
  if($_FILES['image']){
    $img = $this->upload('image');
    if($img->status==true){
      $data['status'] = true;
      $data['name'] = $img->file_name;

      if($img->image_width>=IMG_XS_WIDTH || $img->image_height>=IMG_XS_HEIGHT){
        $resizeXS = $this->resize(PATH_UPLOAD_IMAGES.$img->file_name, IMG_XS_PRE, IMG_XS_WIDTH, IMG_XS_HEIGHT, TRUE, TRUE, 80);
        if($resizeXS==true){ $data['name_xs'] = IMG_XS_PRE.$img->file_name; }
      }

      if($img->image_width>=IMG_MD_WIDTH || $img->image_height>=IMG_MD_HEIGHT){
        $resizeMD = $this->resize(PATH_UPLOAD_IMAGES.$img->file_name, IMG_MD_PRE, IMG_MD_WIDTH, IMG_MD_HEIGHT, TRUE, TRUE, 70);
        if($resizeMD==true){ $data['name_md'] = IMG_MD_PRE.$img->file_name; }
      }

      if($img->image_width>=IMG_LG_WIDTH || $img->image_height>=IMG_LG_HEIGHT){
        $resizeLG = $this->resize(PATH_UPLOAD_IMAGES.$img->file_name, IMG_LG_PRE, IMG_LG_WIDTH, IMG_LG_HEIGHT, TRUE, TRUE, 50);
        if($resizeLG==true){ $data['name_lg'] = IMG_LG_PRE.$img->file_name; }
      }
    }else{
      $data['message'] = $upload_et->message;
    }
  }
  return json_encode($data);
}


public function upload($key){
  $config['file_name']            = date('Ymd').time().'-'.rand(1000,9999).uniqid();
  $config['upload_path']          = PATH_UPLOAD_IMAGES;
  $config['allowed_types']        = 'gif|jpg|png|jpeg';
  $config['max_size']             = 5120;
  $config['max_width']            = 2600;
  $config['max_height']           = 2200;

  $this->load->library('upload', $config);

  if(!$this->upload->do_upload($key)){
    $sonuc['status'] = false;
    $sonuc['message'] = $this->upload->display_errors();
  }else{
    $sonuc = $this->upload->data();
    $sonuc['status'] = true;
  }

  return json_decode(json_encode($sonuc));
}//upload_et



public function resize($path, $pre='', $width=150, $height=150, $create_thumb=TRUE, $ratio=TRUE, $quality=90){
  $config['image_library']  = 'gd2';
  $config['source_image']   = $path;
  $datas = explode('/', $path);
  $config['new_image']      = PATH_UPLOAD_IMAGES.$pre.end($datas);
  $config['create_thumb']   = $create_thumb;
  $config['maintain_ratio'] = $ratio;
  $config['width']          = $width;
  $config['height']         = $height;
  $config['thumb_marker']   = null;
  //$config['dynamic_output']   = TRUE;
  $config['master_dim']   = 'auto'; //auto, width, height
  $config['quality']   = $quality; //auto, width, height

  $this->image_lib->initialize($config);
  if(!$this->image_lib->resize()){
      $sonuc = $this->image_lib->display_errors();
  }else{
    $sonuc = true;
  }
  $this->image_lib->clear();
  return $sonuc;
}



  /*
		$name = Upload edilen resmin yeni adı.

		$resize = Resim yeniden boyutlandırılsın mı?

		$w = Genişlik
		$wr = Genşlik otomatik ayarlansın mı?

		$h = Yükseklik
		$hr = Yükseklik otomatik ayarlansın mı?

		$crop = Resim kırpılsın mı?

		$convert = Resim dönüştürülsün mü? Dönüştürülecekse hangi uzantıya (false, gif, jpg, jpeg, png)

		$compress = PNG resimler için resim sıkıştırılsın mı? (false - 1..9)

		$jpeg_quality = JPG için yüklenen resmin kalite ayarlaması (false - 0..100)

	*/
  /*
	public function imgUpload($obj=false, $name=null, $resize=true, $w=100, $wr=false, $h=100, $hr=false, $crop=true, $convert=false, $compress=null, $jpeg_quality=false){
			   $obj->allowed = array('image/*');
			   $obj->file_new_name_body = $name;
			   $obj->file_max_size = '3145728'; //3MB
			   $obj->image_resize = $resize;
			   $obj->image_convert = $convert;
			   $obj->jpeg_quality = $jpeg_quality;
			   $obj->image_x = $w;
			   $obj->image_ratio_x = $wr;
			   $obj->image_y = $h;
			   $obj->image_ratio_y = $hr;
			   $obj->image_ratio_crop = $crop;
			   $obj->png_compression = $compress;
			   $obj->image_ratio_fill = true;
			   $obj->Process('uploads/images');
			   return !$obj->processed? false : $obj->file_dst_name;
			   //return $obj;
	}//imgUpload
*/

} ?>
