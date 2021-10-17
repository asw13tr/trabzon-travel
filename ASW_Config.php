<?php

$asw_user = null;
global $asw_user;

define('N', null);
define('PAGE_TITLE', 'ASW TURİZM');
define('PAGE_DESCRIPTION', 'ASW TURİZMMM');

define('PATH_ROOT', realpath('.').'/');
define('PATH_ASSETS', PATH_ROOT.'assets/');
define('PATH_UPLOADS', PATH_ROOT.'uploads/');
define('PATH_UPLOAD_IMAGES_PRODUCTS', PATH_UPLOADS.'products/');
define('PATH_UPLOAD_IMAGES_REALESTATES', PATH_UPLOADS.'realestates/');
define('PATH_UPLOAD_IMAGES_TOURS', PATH_UPLOADS.'tours/');
define('PATH_UPLOAD_IMAGES', PATH_UPLOADS.'images/');

define('URL_SITE', 'http://127.0.0.1/travel');
define('URL_ASSETS', URL_SITE.'/assets');
define('URL_UPLOADS', URL_SITE.'/uploads');
define('URL_UPLOAD_IMAGES_PRODUCTS', URL_SITE.'/uploads/products/');
define('URL_UPLOAD_IMAGES_REALESTATES', URL_SITE.'/uploads/realestates/');
define('URL_UPLOAD_IMAGES_TOURS', URL_SITE.'/uploads/tours/');
define('URL_UPLOAD_IMAGES', URL_UPLOADS.'/images/');
define('URL_CURRENT', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");


define('DB_HOST', 'localhost');
define('DB_NAME', 'travel_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHAR', 'utf8');


define('IMG_XS_PRE', 'xs-');
define('IMG_XS_WIDTH', 400);
define('IMG_XS_HEIGHT', 300);

define('IMG_MD_PRE', 'md-');
define('IMG_MD_WIDTH', 862);
define('IMG_MD_HEIGHT', 500);

define('IMG_LG_PRE', 'lg-');
define('IMG_LG_WIDTH', 1024);
define('IMG_LG_HEIGHT', 768);

$userLevels = array(
	''	=> 'Belirtilmedi',
	0 => "Yasaklı Üye",
	1 => "Aktif Kullanıcı",
	2 => "Editör",
	3 => "Yönetici"
);

$hotelTypes = array(
	''	=> 'Belirtilmedi',
	1 => 'Otel',
	2 => 'Motel',
	3 => 'Pansiyon',
	4 => 'Apart Otel'
);

$hotelStars = array(0=>'Belirtilmedi', 1=>1, 2=>2, 3=>3, 4=>4, 5=>5);




?>
