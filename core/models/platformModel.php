<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 10:04
 */
class platformModel extends classModel{

    function __construct(){ }

    static function getPlatforms(){

        $result = array();
        $sql = "SELECT * FROM platforms";
        $q = self::query($sql);

        while( $r = self::fetchAssoc($q) )
            $result[] = $r;

    return $result;
    }

    static function getPlatformData( $id_platform ){

        $sql = "SELECT * FROM platforms
                WHERE
                    id_platform = '".$id_platform."'";

        $q = self::query($sql);
    return self::fetchAssoc($q);
    }

    static function insertData( $data ){

        $sql = "INSERT INTO platforms
                SET
                    name_platform = '".$data['name_platform']."',
                    UA_string     = '".$data['UA_string']."',
                    description_platform = '".$data['description_platform']."'";
        $q = self::query($sql);

    return self::insertID();
    }

    static function updateData( $data ){

        $sql = "UPDATE platforms
                SET
                    name_platform = '".$data['name_platform']."',
                    UA_string     = '".$data['UA_string']."',
                    description_platform = '".$data['description_platform']."'
                WHERE
                    id_platform = '".$data['id_platform']."'";
        $q = self::query($sql);
        return null;
    }

    static function deleteData( $id_platform ){
        $sql = "DELETE FROM platforms WHERE id_platform = '".$id_platform."'";
        self::query($sql);
        return null;
    }

    static function deletePlatform2AppData( $id_platform ){
        $sql = "DELETE FROM app2platforms WHERE id_platform = '".$id_platform."'";
        self::query($sql);
        return null;
    }

    static function deleteLogData( $id_platform ){
        $sql = "DELETE FROM check_log WHERE id_platform = '".$id_platform."'";
        self::query($sql);
        return null;
    }

    static function getSubMenuData(){
        return array(

            array('title'      => 'Add new platform',
                  'controller' => 'platform',
                  'action'     => 'add')
        );
    }
}
