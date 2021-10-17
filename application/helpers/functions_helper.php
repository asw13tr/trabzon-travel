<?php
function url($more=null){
	return URL_SITE.'/'.$more;
}


function abide_error($mesaj=null){
	$mesaj = !$mesaj? "Hatalı bir giriş yaptınız." : $mesaj;
	return '<span class="form-error">'.$mesaj.'</span>';
}


// ########### CSS ve JS dosyalarını import etmek
function url_css($name = 'style.css'){ return URL_ASSETS.'/css/'.$name; }
function url_js($name = 'script.js'){ return URL_ASSETS.'/js/'.$name; }

function get_css($name='style.css', $id=null){
	$id = !$id? md5($name) : $id;
	return '<link rel="stylesheet" href="'.url_css($name).'" id="'.$id.'" />';
}
function get_js($name='script.js', $id=null){
	$id = !$id? md5($name) : $id ;
	return '<script src="'.url_js($name).'" id="'.$id.'" ></script>';
}




function get_db_col($col=null, $table=null, $where=null, $default=null){
	$ci =& get_instance();
	$data = @$ci->db->where($where)->get($table)->row()->$col;
	return !$data? $default : $data ;
}



function post($key, $default=false){
	$ci =& get_instance();
	return $ci->input->post($key, $default);
}

function convert_password($password){
	return md5(sha1(md5(sha1(md5($password)))));
}

function post_cover(){
	$covers = false;
	if(post('cover_hide', false)){    $covers['img']  = post('cover_hide'); }
	if(post('cover_hide_lg', false)){ $covers['lg']   = post('cover_hide_lg'); }
	if(post('cover_hide_md', false)){ $covers['md']   = post('cover_hide_md'); }
	if(post('cover_hide_xs', false)){ $covers['xs']   = post('cover_hide_xs'); }
	$cover = $covers!=false? json_encode($covers) : null;
	return $cover;
}

function GET($key, $default=false){
	$ci =& get_instance();
	return $ci->input->get($key, $default);
}



function asw_pre($datas=null){
	echo '<pre>';
	print_r($datas);
	echo '</pre>';
}



function get_alert($data = null, $success=null, $error=null, $info=null, $default=null){
	switch ($data) {
		case 1:  $message = '<div class="alert alert-success" role="alert">'.$success.'</div>'; break;
		case -1: $message = '<div class="alert alert-danger" role="alert">'.$error.'</div>'; break;
		case 0:  $message = '<div class="alert alert-warning" role="alert">'.$info.'</div>'; break;
		default: $message = '<div class="alert alert-info" role="alert">'.$default.'</div>'; break;
	}
	return $message;
}




/*
	####################################################################################################
	SESSION İŞLEMLERİ İÇİN FONKSİYONLAR
	####################################################################################################
*/
function set_session($key, $val=null){ return $_SESSION[$key] = $val; }
function set_sessions($vals){
	if(is_array($vals)){
		foreach($vals as $k => $v){
			$_SESSION[$k] = $v;
		}
	}
}
function get_session($key, $default=null){
	$ci =& get_instance();
	if($ci->session->has_userdata($key)){
		return $ci->session->userdata($key);
	}else{
		return $default;
	}
}

function del_session($key){ unset($_SESSION[$key]); }

function del_sessions($keys){
	if( is_array($keys) ){
		foreach($keys as $k){
			unset($_SESSION[$k]);
		}
	}
}






function set_falert($name, $class='danger', $title=null, $message=null){
	$content = '<div class="alert alert-'.$class.'"><strong>'.$title.'</strong><div class="clearfix"></div>'.$message.'</div>';
	$_SESSION[$name] = $content;
}

function get_falert($name){
	if(!$_SESSION[$name]){
		$result = null;
	}else{
		$result = $_SESSION[$name];
		unset($_SESSION[$name]);
	}
	return $result;
}

function is_falert($name){
	return !$_SESSION[$name]? false : true ;
}



function goUrl($url=null, $time=false){
	if($url){
		if($time && $time>1){
			header("refresh:$time; url=$url");
		}else{
			header("Location:$url");
		}
	}
}




function yaz($content, $rutbe=false){
	if(!$rutbe){
		echo $content;
	}else{
		global $user;
		if($user->rutbe==$rutbe){ echo $content; }
	}
}


function date2sql($date=null){
	if($date){
		list($d,$m,$y) = explode(' ', $date);
		return "{$y}-{$m}-{$d}";
	}
}

function sql2date($date=null){
	if($date){
		list($y,$m,$d) = explode('-', $date);
		return "{$d} {$m} {$y}";
	}
}

function gunFarki($date=null){
	if($date){
		$tarih = strtotime($date);
		$bugun = strtotime(date('Y-m-d'));
		$kalan = ($tarih - $bugun) / (60*60*24);
		return $kalan;
	}
}


function money2num($num=null){ return !$num? null : preg_replace('([^ 0123456789 ])', '', $num); }
function justNumber($num=null){ return !$num? null : preg_replace('([^0123456789])', '', trim($num)); }
function num2money($num=null){ return !$num? null : number_format($num, 0, ',', '.'); }

function getpar($index, $default=false){
	$result = $default;
	if($index >= 0 ){
		global $getItem;
		if(isset($getItem[$index])){
			$result = $getItem[$index];
		}
	}
	return $result;
}




function showChatDate($date){
	//2017-08-16 16:48:20
	list($tarih, $tamsaat) = explode(' ', $date);
	list($yil, $ay, $gun) = explode('-', $tarih);
	list($saat, $dakika, $saniye) = explode(':', $tamsaat);
	$ayAdi = getDayName($ay);
	return "$gun $ayAdi $yil $saat:$dakika";
}

function getDayName($index=null){
	$key = (int)$index;
	$days = array(
		1 => 'Ocak',
		01 => 'Ocak',
		2 => 'Şubat',
		02 => 'Şubat',
		3 => 'Mart',
		03 => 'Mart',
		4 => 'Nisan',
		04 => 'Nisan',
		5 => 'Mayıs',
		05 => 'Mayıs',
		6 => 'Haziran',
		06 => 'Haziran',
		7 => 'Temmuz',
		07 => 'Temmuz',
		8 => 'Ağustos',
		08 => 'Ağustos',
		9 => 'Eylül',
		09 => 'Eylül',
		10 => 'Ekim',
		11 => 'Kasım',
		12 => 'Aralık'
	);
	$result = $days[$key];
	return $result;
}


function replaceSpace($string)
{
	$string = preg_replace("/\s+/", " ", $string);
	$string = trim($string);
	return $string;
}




function seo_link($str, $options = array()){

    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());


    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'transliterate' => true,
    );

    $options = array_merge($defaults, $options);
    $dmr = $defaults["delimiter"];
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', ' ' => $dmr, 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',

        // Latin symbols
        '©' => '(c)',

        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',

        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',

        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',

        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );


    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}



function image_from_json($json, $which='img', $default=false){
	$data = json_decode($json);
	if(!isset($data->img)){
		$sonuc = $default;
	}else{
		switch($which){
			case 'lg':
			case 'big':
			case 'large':
			case 'buyuk':
				$sonuc = isset($data->lg)? $data->lg : $data->img;
				break;

			case 'md':
			case 'medium':
			case 'middle':
			case 'orta':
				if(isset($data->md)){ $sonuc = $data->md; }
				elseif(isset($data->lg)){ $sonuc = $data->lg; }
				else{ $sonuc = $data->img; }
				break;

			case 'xs':
			case 'small':
			case 'kucuk':
			case 'thumb':
			case 'thumbnail':
				if(isset($data->xs)){ $sonuc = $data->xs; }
				elseif(isset($data->md)){ $sonuc = $data->md; }
				elseif(isset($data->lg)){ $sonuc = $data->lg; }
				else{ $sonuc = $data->img; }
				break;

			default:
				$sonuc = $data->img;
				break;

		}//switch
	}//$data->img
	return $sonuc;
}//image_from_json



function delete_images_from_json($json){
	if($json){
		$imgs = json_decode($json);
		foreach ($imgs as $img) {
			if( file_exists(PATH_UPLOAD_IMAGES.$img) ){ unlink(PATH_UPLOAD_IMAGES.$img); }
		}
	}
}//delete_images_from_json


function set_flashalert($message=null, $color='success'){
	$ci =& get_instance();
	switch($color){
		case "danger":
		case "no":
		case "error":
		case "hata":
		case "red":
			$classname = "danger";
			break;

		case "warning":
		case "yellow":
		case "orange":
			$classname = "warning";
			break;

		case "blue":
		case "info":
			$classname = "info";
			break;

		case "success":
		case "yes":
		case "green":
		case "ok":
		case "okey":
			$classname = "success";
			break;

		default:
			$classname = "success";
			break;
	}
	$ci->session->set_flashdata('flashalert_class', $classname);
	$ci->session->set_flashdata('flashalert_message', $message);
}

function get_flashalert(){
	$ci =& get_instance();
	if( $ci->session->flashdata('flashalert_message') ){
		$message = $ci->session->flashdata('flashalert_message');
		$classname = $ci->session->flashdata('flashalert_class');
		echo '<div class="alert alert-'.$classname.' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$message.'</div>';
	}
}


function set_flash($key, $val=null){
	$ci =& get_instance();
	$ci->session->set_flash($key, $val);
}
function flash($key, $default=null){
	$ci =& get_instance();
	if( !$ci->session->flashdata($key) ){
		return $default;
	}else{
		return $ci->session->flashdata($key);
	}
}





function selectlist_categories($name, $values=null){
	$ci =& get_instance();
	$ci->load->model('post_model');
	$categories = $ci->post_model->categories_with_sub();

	if(!is_array($values)){
		$selected = array($values);
	}else{
		$selected = $values;
	}

	$result = '<label for="">Yazı Kategorisi</label>
	<div class="list_checkboxes">';
	if($categories){
	foreach($categories as $category){
		$itemid = seo_link($category->category_name.'_'.$category->category_id);
		if( $category->category_show_posts=="yes" ){
			$selectedtag = in_array($category->category_id, $selected)? ' checked' : null ;
			$result .= '<label for="'.$itemid.'" class="allow_select">'.$category->category_empty.'<input type="checkbox"'.$selectedtag.' name="'.$name.'" value="'.$category->category_id.'" id="'.$itemid.'" />'.$category->category_name.'</label>';
		}else{
			$result .= '<label for="'.$itemid.'" class="deny_select">'.$category->category_empty.'<input type="checkbox" disabled id="'.$itemid.'" />'.$category->category_name.'</label>';
		}
	}
	}
	$result .= '</div>';
	return $result;
}//selectlist_categories

function is_premium($status){
	if($status==1 || $status==true){
		return '<em class="fa fa-star premium-content" title="Premium Hesap"></em>';
	}else{
		return '<em class="fa fa-star-o notpremium-content" title="Premium Olmayan Hesap"></em>';
	}
}
function is_active($status){
	if($status==1 || $status==true){
		return '<em class="fa fa-check active-content" title="Aktif İçerik"></em>';
	}else{
		return '<em class="fa fa-times passive-content" title="Pasif İçerik"></em>';
	}
}


?>
