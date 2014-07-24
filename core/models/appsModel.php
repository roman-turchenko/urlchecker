<?
class appsModel extends classModel{

	function __construct(){ }

    /**
     * Get application list
     */
    static function getApps( $id_user ){

        $result = array();
        $sql = "SELECT a.*
                FROM applications a
                WHERE a.id_user = '".$id_user."'";
        $q = self::query($sql);

        while( $r = self::fetchAssoc($q) )
            $result[] = $r;

        return $result;
    }

    static function getApplicationData( $id_application ){

        $sql = "SELECT a.*
                FROM applications a
                WHERE
                    id_application = '".$id_application."'";
        $q = self::query($sql);

    return self::fetchAssoc($q);
    }


    static function getAppLook( $url, $device = '' ){

        $device;
        $ch = curl_init($url);
        ob_start();
        curl_exec($ch);

        return ob_get_clean();
    }

    static function insertData( $data ){

        $sql = "INSERT INTO applications
                SET
                  name_application = '".self::escapeString($data['name_application'])."',
                  url_application  = '".self::escapeString($data['url_application'])."',
                  description_application = '".self::escapeString($data['description_application'])."',
                  id_user = '".$data['id_user']."'";
        self::query($sql);

    return self::insertID();
    }

    static function updateData( $data ){

        $sql = "UPDATE applications
                SET
                    name_application = '".self::escapeString($data['name_application'])."',
                    url_application  = '".self::escapeString($data['url_application'])."',
                    description_application = '".self::escapeString($data['description_application'])."'
                WHERE
                    id_application = '".$data['id_application']."' AND
                    id_user = '".$data['id_user']."'";
        self::query($sql);

    return null;
    }

    static function deleteData( $id_application ){
        $sql = "DELETE FROM applications WHERE id_application = '".$id_application."'";
        self::query($sql);

    return null;
    }

    public static function getApp2PlatformData( $id_application ){

        $result = array();
        if( !empty($id_application) ){
            $sql = "SELECT * FROM app2platforms WHERE id_application = '".$id_application."'";
            $q = self::query($sql);
            while( $r = self::fetchAssoc($q) ) $result[] = $r['id_platform'];
        }
        return $result;
    }

    public static function insertApp2PlatformData( $id_application, $data ){

        $sql = "INSERT INTO app2platforms (id_application, id_platform) VALUES ('"
            .$id_application."', '".implode("'),('".$id_application."', '", $data)
            ."')";
        self::query($sql);

    return null;
    }

    public static function deleteApp2PlatformData( $id_application ){
        $sql = "DELETE FROM app2platforms WHERE id_application = '".$id_application."'";
        self::query($sql);
    }

    static function getSubMenuData(){
    return array(

        array('title' => 'Add new application',
              'url'   => classController::st_makeURI(array('controller' => 'apps', 'action' => 'add'))),
        );
    }
}
?>