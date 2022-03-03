<?php

/*
* Kelas BaseCtrl
* semua controller harap diturunkan dari kelas ini
* kelas post,get diganti dengan class params
*/
class Base{
    /* inisialisasi kelas */
    function __construct(){
        global $query;

        /* variabel q0..qN */
        $this->query=$query;

        /* http status ok */
        $this->_status=200;

        /* variabel untuk response */
        $this->_data=array();

        /* variabel untuk json, flexible untuk custom */
        $this->_render=true;
    }

    /* akhir merender format json variabel data */
    function __destruct(){

        /* status not ok tidak menampilkan data response */
        if($this->_status>299) $this->_render=false;

        /* status ok dan perintah send response */
        if($this->_render) {
            header('Content-Type: application/json');
            echo json_encode($this->_result);
        }

        /* http status */
        http_response_code($this->_status);
    }
    
    function status($code){
        $this->_status=$code;
    }

    /* memasukkan data */
    function data($val){
        $this->_data=$val;
    }

    /* merubah response */
    function render($value=false){
        $this->_render=$value;
    }
    
    function addModel($model){
        global $prefix;
        $tbl=ucfirst(strtolower($prefix)).ucfirst(strtolower($model));
        if(!class_exists($tbl)) return false;
        if(isset($this->$model)) return true;
        $this->$model=new $tbl;
        return $tbl;
    }

    function addClass($class){
        $class=ucfirst(strtolower($class));
        if(!class_exists($class)) return false;
        if(isset($this->$class)) return true ;
        $this->$class=new $class;
        return $class;
    }


}
