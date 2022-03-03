<?php

/* konfigurasi untuk koneksi dbase
 offset untuk limit record yang ditampilkan */
 $db=array(
  'host'=>'127.0.0.1',
  'user'=>'webaps_user',
  'pwd' =>'admin',
  'name'=>'webaps',
  'offset' =>'500',
 );

/* untuk prefix nama table */
$prefix='Ws';

/* untuk yang tidak membutuhkan otentifikasi */
$noauth=array('login');

/* untuk membuat token, dengan java web token */
$jwt=array(
    'alg'=>'HS256',
    'key'=>'webaps',
);

/* dev_mode -> develop mode 
beri nilai selain satu untuk production */
define('DEV_MODE',1);
 