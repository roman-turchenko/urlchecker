<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 16:42
 */

function __autoload( $class_name ){
    _include(CONTEROLLERS_DIR.'/'.$class_name.'.php');
    _include(MODELS_DIR.'/'.$class_name.'.php');
    _include(VIEWS_DIR.'/'.$class_name.'.php');
}

/**
 * 404 error
 */
function _404(){
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
    header("Location: ./404.php");
    exit();
}

function check_RequestMethod( $request_method = 'POST' ){
    return $_SERVER['REQUEST_METHOD'] == $request_method;
}

function _include( $path ){
    if( file_exists($path) ) include($path);
    else
        return false;
    return true;
}

function set_Json_header(){

    header('Content-type: application/json; charset=utf-8;');
}