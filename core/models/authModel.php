<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 01.07.14
 * Time: 11:32
 */
class authModel extends classModel{

    function __construct(){ }

    /**
     * @param $login
     * @param $password
     * @return int
     * Check login\password pare in base
     */
    public static function checkInBase( $login, $password ){
        return userModel::checkInBase( $login, $password );
    }

    public static function is_SuperUserSession(){
        $curent_user = classModel::getSession('curent_user');
        return ( $curent_user['superuser'] == 1 );
    }

    public static function is_Authorized(){
        return ( classModel::getSession('login') === true );
    }
}