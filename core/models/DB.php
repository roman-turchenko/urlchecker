<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 12:07
 */

class DB{
    private static $instance;  // экземпляра объекта
    private $link = null;
    private function __construct(){

        if( $this->link == null )
            $this->link = mysqli_connect('localhost','root','','urlchecker')
            or die("Error " . mysqli_error($this->link));
    }

    private function __clone(){}
    private function __wakeup(){}

    public static function getInstance(){
        if ( empty(self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query( $sql ){
        return mysqli_query($this->link, $sql);
    }

    public function fetchAssoc( $res ){
        return mysqli_fetch_assoc($res);
    }

    public function escapeString( $string ){
        return mysqli_real_escape_string($this->link, $string);
    }

    public function numRows( $res ){
        return mysqli_num_rows($res);
    }

    public function insertID(){
        return mysqli_insert_id( $this->link );
    }

    public function getError(){
        return mysqli_error($this->link);
    }
}