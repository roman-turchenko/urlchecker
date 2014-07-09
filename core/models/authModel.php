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

        $sql = "SELECT * FROM users
                WHERE
                    login_user    = '".self::escapeString($login)."' AND
                    password_user = '".md5(self::escapeString(($password)))."'";

        $q = self::query($sql);
        $r = self::fetchAssoc($q);

    return $r['id_user'] ? $r['id_user'] : null;
    }

}