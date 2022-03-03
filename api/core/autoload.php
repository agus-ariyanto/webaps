<?php
function auto_load($_class){
    
    /* konvensional autoload */
    $_file = strtolower($_class).'.php';
    $_core = ROOT_DIR.DS.'core'.DS.$_file;
    $_lib  = ROOT_DIR.DS.'lib'.DS.$_file;
    $_mdl  = ROOT_DIR.DS.'model'.DS.$_file;
    $_ctrl = ROOT_DIR.DS.'ctrl'.DS.$_file;

    /* cari di folder /api/core */
    if(file_exists($_core)){
        require_once($_core);
        return true;
    }

    /* cari di folder /api/ctrl */
    if(file_exists($_ctrl)){
        require_once($_ctrl);
        return true;
    }

    /* cari di folder /api/model */
    if(file_exists($_mdl)){
        require_once($_mdl);
        return true;
    }

    /* cari di folder /api/lib */
    if(file_exists($_lib)){
        require_once($_lib);
        return true;
    }

    /* untuk autoload yang pake namespace */
    $_file = str_replace("\\" ,DS,$_class ).'.php' ;
    $_lib  = ROOT_DIR.DS.'lib'.DS.$_file ;

    if(file_exists($_lib)){
        require_once($_lib);
        return true;
    }

    /* nggak ada semua */
    return false;
}

/* daftarkan fungsi diatas di spl 
untuk diaktifkan fungsinya */
spl_autoload_register('auto_load');

