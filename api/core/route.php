<?php

/* check array, jadikan map array,
kalau bukan, stripslash,
ini akan berulang, untuk array multidimensi */
function strips($_val) {
    return is_array($_val) ?
    array_map('strips', $_val) : stripslashes($_val);
}
/* cari disemua parameter, 
get_magic_quote deprecated di PHP 7.4,
tidak ada di PHP 8*/
if(get_magic_quotes_gpc()){
    $_GET    = strips($_GET);
    $_POST   = strips($_POST);
    $_COOKIE = strips($_COOKIE);
}
/* ganti nya seperti ini saja
    di PHP 8
    $_GET    = strips($_GET);
    $_POST   = strips($_POST);
    $_COOKIE = strips($_COOKIE); */


/* hapus semua variabel $_GLOBALS */
if(ini_get('register_globals')){
    $_qry = array('_SESSION',
    '_POST',
    '_GET',
    '_COOKIE',
    '_REQUEST',
    '_SERVER',
    '_ENV',
    '_FILES'
);
    foreach ($_qry as $array) {
        foreach ($GLOBALS[$array] as $key => $var) {
         if ($var === $GLOBALS[$key])unset($GLOBALS[$key]);
        }
    }
}

/* buang hyphen (non karakter) */
function textFromUrl($text){
    $array=array('-','+',' ','|','!');
    $text=str_replace($array,'_',$text);
    $text=str_replace('//','/',$text);
    $text=str_replace('=/','',$text);
    return $text;
}

/* fungsi untuk parsing $_GET['u'] */
function parseQry($get,$limit=10){
    $array=array();
    for ($i=0; $i < $limit; $i++){
        $array[]='';
    }

    $qry=textFromUrl($get);
    $a=explode('/',$qry);
    foreach($a as $key => $value) {
        $array[$key]=$value;
    }
    return $array;
}
$get_u=parseQry($_GET['u']);

/* fallback class */
$s='Ctrl';

/* periksa klas ada, 
ada, buang satu query param */ 
if(!empty($get_u[0])){
    $c=ucfirst($get_u[0]);
    if(class_exists($c)) {
        $s=$c;
        array_shift($get_u);
    }
}
$ctrl=$s;

/* fallback method */
$s='index';

/* periksa method dari controller 
 bila ada buang satu query param */
if(!empty($get_u[0])){
    $c=$get_u[0];
    if(method_exists($ctrl,$c)) {
        $s=$c;
        array_shift($get_u);
    }
}
$mtd=$s;
/* variabel untuk q0..qN */
$query=$get_u;

/* check class harus otentifikasi ? */
if(!in_array(strtolower($ctrl),$noauth)){
    $login=new Login;
    $authlogin=$login->check();
    /* otentifikasi tidak valid */
    if($authlogin==false) exit;
    $login=null;
}
/* jalankan controller->method */
$object=new $ctrl;
$object->$mtd();