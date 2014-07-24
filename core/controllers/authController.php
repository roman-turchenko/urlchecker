<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 01.07.14
 * Time: 11:31
 */
class authController extends classController{

    function __construct(){

        $this->set_View_folder('auth');
    }

    public function mainAction(){

        if( check_RequestMethod() && count($_POST) > 0 ){

            $login    = trim($_POST['login']);
            $password = trim($_POST['password']);

            if( empty($login) )    authModel::$errors[] = 'Empty login';
            if( empty($password) ) authModel::$errors[] = 'Empty password';

            if( !count(classModel::$errors) )
                $this->Authorize( $login, $password );
        }

        echo $this->render('main', array(
            'errors'    => classModel::$errors,
            'user_data' => array('login' => $login),
        ));
    }

    public function logoutAction(){

        setcookie('PHPSESSID', '', time() - 1000);
        session_destroy();

        header("Location: ".$this->makeURI());
        die();
    }

    private function Authorize( $login, $password ){

        if( ($id_user = authModel::checkInBase($login, $password)) !== null ){

            authModel::setSession(array(
                'id_user' => $id_user,
                'login'   => true,
                'curent_user' => userModel::getUserData($id_user),
            ));

            header("Location: ".$this->makeURI(array(
                    'controller' => 'apps',
                    'action'     => 'list')));
            die();
        }else
            authModel::$errors[] = 'Wrong login\password';

        return null;
    }
}