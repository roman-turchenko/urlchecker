<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 11:40
 */
class logModel extends classModel{

    function __construct(){ }

    public static function getLog( $id_check_log ){
        $sql = "SELECT *,
                    CONCAT(weight_diff, ' B') weight_diff_b,
                    CONCAT(weight_diff/1000, ' kB') weight_diff_kb
                FROM check_log
                WHERE id_check_log = '".$id_check_log."'";
        $q = self::query($sql);

    return self::fetchAssoc($q);
    }

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
                request_header = '".self::escapeString($data['request_header'])."',
                weight_diff    = '".$data['weight_diff']."',
                app_resources    = '".$data['app_resources']."'
                ";

        self::query($sql);
        print self::queryError();
    return self::insertID();
    }

    public static function updateData( $data ){

        $sql = "UPDATE check_log SET
                id_application = '".$data['id_application']."',
                id_platform    = '".$data['id_platform']."',
                id_user        = '".$data['id_user']."',
                HTTP_code      = '".$data['HTTP_code']."',
                date_check     = '".$data['date_check']."',
                size_download  = '".$data['size_download']."',
                download_content_length = '".$data['download_content_length']."',
                redirect_url = '".self::escapeString($data['redirect_url'])."',
                request_header = '".self::escapeString($data['request_header'])."',
                weight_diff    = '".$data['weight_diff']."',
                app_resources  = '".$data['app_resources']."'

                WHERE
                    id_check_log = '".$data['id_check_log']."'
                ";

        self::query($sql);
        print self::queryError();
        return null;
    }

    public static function getLastLogs( $id_applicaton = 0, $id_platform = 0 ){

        $result = array();

        $sql = "SELECT ch.*,
                    CONCAT(ch.weight_diff, ' B') weight_diff_b,
                    CONCAT(ch.weight_diff/1000, ' kB') weight_diff_kb
                FROM check_log ch
                WHERE ch.date_check IN (
                    SELECT MAX(date_check) FROM check_log WHERE id_application = ch.id_application AND id_platform = ch.id_platform
                )"
                .( $id_application ? " AND ch.id_application = '".$id_application."'" : "" )
                .( $id_platform ? " AND ch.id_platform = '".$id_platform."'" : "" );

        $q = self::query($sql);
        while( $r = self::fetchAssoc($q) )
            $result[$r['id_application']][$r['id_platform']] = $r;

    return $result;
    }

    public static function getAppLog( $id_application, $id_platform = false, $limit = false ){

        $result = array();
        $sql = "SELECT cl.*, u.email_user
                FROM check_log cl
                LEFT JOIN users u ON cl.id_user = u.id_user
                WHERE cl.id_application = '".self::escapeString($id_application)."'
                ".( $id_platform ? " AND cl.id_platform = '".self::escapeString($id_platform)."'":"" )."
                ORDER BY cl.date_check DESC".
                ($limit ? " LIMIT 0, ".$limit : "");

        $q = self::query($sql);
        while( $r = self::fetchAssoc($q) )
            $result[] = $r;

        return $result;
    }

    public static function checkInBase( $data, $exceptions = array() ){

        $condition = array();
        if( is_array($data) ) foreach( $data as $k => $v ){

            if( !in_array($k, $exceptions) )
                $condition[] = $k.' = "'.parent::escapeString($v).'"';
        }

        if( count($condition) ){

            $sql = "SELECT * FROM check_log
                    WHERE ".implode(" AND ", $condition);

            $q = parent::query($sql);
            $r = parent::fetchAssoc($q);
            print parent::queryError();

            return $r['id_check_log'] ? $r['id_check_log'] : false;
        }

        return false;
    }
}