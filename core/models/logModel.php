<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 11:40
 */
class logModel extends classModel{

    function __construct(){ }

    public static function insertData( $data ){

        $sql = "INSERT INTO check_log SET
                id_application = '".$data['id_application']."',
                id_platform    = '".$data['id_platform']."',
                id_user        = '".$data['id_user']."',
                HTTP_code      = '".$data['HTTP_code']."',
                date_check     = '".$data['date_check']."',
                size_download  = '".$data['size_download']."',
                download_content_length = '".$data['download_content_length']."',
                redirect_url = '".self::escapeString($data['redirect_url'])."',
                request_header = '".self::escapeString($data['request_header'])."'
                ";

        self::query($sql);
        print self::queryError();
    return self::insertID();
    }

    public static function getLastLogs(){

        $result = array();

        $sql = "SELECT ch.*
                FROM check_log ch
                WHERE date_check IN (
                    SELECT MAX(date_check) FROM check_log WHERE id_application = ch.id_application AND id_platform = ch.id_platform
                )";

        $q = self::query($sql);
        while( $r = self::fetchAssoc($q) )
            $result[$r['id_application']][$r['id_platform']] = $r;

    return $result;
    }

    public static function getAppLog( $id_application, $limit = false ){

        $result = array();
        $sql = "SELECT * FROM check_log
                WHERE id_application = '".$id_application."'
                ORDER BY date_check DESC".
                ($limit ? " LIMIT 0, ".$limit : "");

        $q = self::query($sql);
        while( $r = self::fetchAssoc($q) )
            $result[] = $r;

        return $result;
    }

}