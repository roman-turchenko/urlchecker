<?
class userController extends classController{

    function __construct(){

        $this->set_View_folder('user');
	}	
	
	
//+ Public section
	public function mainAction( $content = 'Hello!' ){

        echo $this->render('main', array(
            'content'  => $content['content_data'],
            'top_menu' => $this->getTopMenu(),
            'filter_section' => $this->render_common('filter_section', array(
                'data' => $content['filter_data'])),
        ));
	}

    public function addAction(){

        $this->mainAction(array(
            'content_data' => $this->getForm(array(
                'action' => $this->makeURI(array('action' => 'insert')),
            ))
        ));

        return null;
    }

    public function editAction(){

        $this->mainAction(array(
            'content_data' => $this->getForm(array(
                'user_data' => userModel::getUserData( (int)$_GET['id_user'] ),
                'action'    => $this->makeURI(array('action' => 'update', 'id_user' => (int)$_GET['id_user'])),
            ))
        ));

        return null;
    }

    public function listAction(){

        $this->mainAction(array(
            'content_data' => $this->getUsersList()
        ));

        return null;
    }

    public function insertAction(){

        if( check_RequestMethod() ){

            $_POST['login_user'] = trim($_POST['login_user']);
            $_POST['email_user'] = trim($_POST['email_user']);
            $_POST['password_user'] = trim($_POST['password_user']);

            if( $this->validateForm($_POST) ){

                $id_user = userModel::insertData(array(
                    'login_user' => $_POST['login_user'],
                    'email_user' => $_POST['email_user'],
                    'password_user' => $_POST['password_user'],
                ));

                $uri_data = array('action' => 'edit', 'id_user' => $id_user);
            }else{
                userModel::setSession('user_data', $_POST);
                $uri_data = array('action' => 'add');
            }

            if( !count(appsModel::$errors) )
                userModel::$messages[] = 'Success!';

            userModel::setSession(array(
                'errors'   => userModel::$errors,
                'messages' => userModel::$messages,
            ));

            header("Location: ".$this->makeURI($uri_data));
            die();
        }else
            _404();

    return null;
    }

    public function updateAction(){
        if( check_RequestMethod() ){

            $_POST['login_user'] = trim($_POST['login_user']);
            $_POST['email_user'] = trim($_POST['email_user']);
            $_POST['password_user'] = trim($_POST['password_user']);

            if( $this->validateForm($_POST) ){

                userModel::updateData(array(

                    'login_user' => $_POST['login_user'],
                    'email_user' => $_POST['email_user'],
                    'password_user' => $_POST['password_user'],
                    'id_user' => $_POST['id_user'],
                ));
            }

            if( !count(appsModel::$errors) )
                userModel::$messages[] = 'Success!';

            userModel::setSession(array(
                'errors'   => userModel::$errors,
                'messages' => userModel::$messages,
            ));

            header("Location: ".$this->makeURI(array('action' => 'edit', 'id_user' => $_POST['id_user'])));
            die();
        }else
            _404();
    return null;
    }

    public function deleteAction(){
        if( check_RequestMethod('GET') ){

            $user_apps_data = appsModel::getApps( (int)$_GET['id_user'] );
            if( is_array($user_apps_data) ) foreach( $user_apps_data as  $v ){
                appsModel::deleteData($v['id_application']);
                appsModel::deleteApp2PlatformData($v['id_application']);
                appsModel::deleteLogData($v['id_application']);
            }
            userModel::deleteData( (int)$_GET['id_user'] );

            header("Location: ".$this->makeURI(array('action' => 'list')));
            die();
        }else
            _404();
    }

//+ Private section

    /**
     * Get app list
     * @return string
     */
    private function getUsersList(){

        $users_list = userModel::getUsers();

        foreach( $users_list as $k => $v ){
            $users_list[$k]['btn_edit'] = $this->render_common('btn_edit', array(
                'url' => $this->makeURI(array('action' => 'edit', 'id_user' => $v['id_user']))
            ));


            if( classModel::getCurrentUserId() !== $v['id_user'] )
                $users_list[$k]['btn_delete'] = $this->render_common('btn_delete', array(
                    'url' => $this->makeURI(array('action' => 'delete', 'id_user' => $v['id_user'])),
                    'confirm_text' => 'Do you want to delete this user?'
                ));
            else
                $users_list[$k]['btn_delete'] = 'Current';
        }

        return $this->render('users_list', array(
            'users_list' => $users_list,
        ));
    }

    private function validateForm($data){

        if( empty($data['login_user']) )
            userModel::$errors[] = 'Empty user login';
        if( empty($data['email_user']) )
            userModel::$errors[] = 'Empty user email';

        if( userModel::$action == 'insert' && empty($data['password_user']) )
            userModel::$errors[] = 'Empty user password';

        if( !empty($data['password_user']) && strlen($data['password_user']) < 6 )
            userModel::$errors[] = 'User`s password must contain more than 6 symbols';

        return count(userModel::$errors) == 0;
    }

    private function getForm( $data ){

        // data from last page reload. Save it and unset
        list( $errors, $messages, $user_data ) = userModel::getSession(array('errors','messages','user_data'));
        userModel::unsetSession(array('errors','messages','user_data'));

        if( userModel::$action == 'edit' )
            unset( $data['user_data']['password_user'] );

        return $this->render('users_form', $data + array(
            'errors'        => $errors,
            'messages'      => $messages,
            'user_data'     => $user_data,
        ));
    }
}
?>
