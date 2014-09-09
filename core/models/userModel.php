<?
class userModel extends classModel{

	function __construct(){ }

    /**
     * Get application list
     */
    static function getUsers(){

        $result = array();
        $sql = "SELECT * FROM users";
        $q = parent::query($sql);

        while( $r = parent::fetchAssoc($q) )
            $result[] = $r;

        return $result;
    }

    static function getUserData( $id_user ){

        $sql = "SELECT *
                FROM users
                WHERE
                    id_user = '".$id_user."'";
        $q = parent::query($sql);

    return parent::fetchAssoc($q);
    }

    static function insertData( $data ){

        $sql = "INSERT INTO users
                SET
                  login_user = '".parent::escapeString($data['login_user'])."',
                  email_user = '".parent::escapeString($data['email_user'])."',
                  password_user = '".md5(parent::escapeString($data['password_user']))."'";
        parent::query($sql);
        
        if( parent::queryError() ){
            self::$errors[] = parent::queryError();
            return false;
        }else
            return parent::insertID();
    }

    static function updateData( $data ){

        $sql = "UPDATE users
                SET
                    login_user = '".parent::escapeString($data['login_user'])."',
                    email_user = '".parent::escapeString($data['email_user'])."'
               ".( !empty($data['password_user']) ? ", password_user = '".md5(parent::escapeString($data['password_user']))."'" : "" )."
                WHERE
                    id_user = '".$data['id_user']."'";

        parent::query($sql);
        if( parent::queryError() )
            self::$errors[] = parent::queryError();

    return null;
    }

    static function deleteData( $id_user ){
        $sql = "DELETE FROM users WHERE id_user = '".$id_user."'";
        parent::query($sql);

    return null;
    }

    public static function checkInBase( $login, $password ){

        $sql = "SELECT * FROM users
                WHERE
                    login_user    = '".parent::escapeString($login)."' AND
                    password_user = '".md5(parent::escapeString(($password)))."'";

        $q = parent::query($sql);
        $r = parent::fetchAssoc($q);

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