<?
class userModel extends classModel{

	function __construct(){ }

    /**
     * Get application list
     */
    static function getUsers(){

        $result = array();
        $sql = "SELECT * FROM users";
        $q = self::query($sql);

        while( $r = self::fetchAssoc($q) )
            $result[] = $r;

        return $result;
    }

    static function getUserData( $id_user ){

        $sql = "SELECT *
                FROM users
                WHERE
                    id_user = '".$id_user."'";
        $q = self::query($sql);

    return self::fetchAssoc($q);
    }

    static function insertData( $data ){

        $sql = "INSERT INTO users
                SET
                  login_user = '".self::escapeString($data['login_user'])."',
                  email_user = '".self::escapeString($data['email_user'])."',
                  password_user = '".md5(self::escapeString($data['password_user']))."'";
        self::query($sql);

    return self::insertID();
    }

    static function updateData( $data ){

        $sql = "UPDATE users
                SET
                    login_user = '".self::escapeString($data['login_user'])."',
                    email_user = '".self::escapeString($data['email_user'])."'
               ".( !empty($data['password_user']) ? ", password_user = '".md5(self::escapeString($data['password_user']))."'" : "" )."
                WHERE
                    id_user = '".$data['id_user']."'";

        self::query($sql);
        self::$errors[] = self::queryError();

    return null;
    }

    static function deleteData( $id_user ){
        $sql = "DELETE FROM users WHERE id_user = '".$id_user."'";
        self::query($sql);

    return null;
    }

    public static function checkInBase( $login, $password ){

        $sql = "SELECT * FROM users
                WHERE
                    login_user    = '".self::escapeString($login)."' AND
                    password_user = '".md5(self::escapeString(($password)))."'";

        $q = self::query($sql);
        $r = self::fetchAssoc($q);

        return $r['id_user'] ? $r['id_user'] : null;
    }

    static function getSubMenuData(){
    return array(
        array('title'      => 'Add new user',
              'controller' => 'user',
              'action'     => 'add'),

        array('title'      => 'Logout',
            'controller' => 'auth',
            'action'     => 'logout'),
        );
    }
}
?>