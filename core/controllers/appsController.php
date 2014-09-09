<?
class appsController extends classController{

    function __construct(){

        $this->set_View_folder('apps');
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
            'content_data'  => $this->getForm(array(
                'user_data' => appsModel::getApplicationData( (int)$_GET['id_application'] ),
                'action'    => $this->makeURI(array('action' => 'update', 'id_aplication' => (int)$_GET['id_application'])),
                'app_log'   => $this->getInstance('logController')->getAppLogs( (int)$_GET['id_application'] )
            ))
        ));

        return null;
    }

    public function listAction(){

        $this->mainAction(array(
            'content_data'=> $this->getAppsList(),
            'filter_data' => $this->getFilter(),
        ));

        return null;
    }

    public function insertAction(){

        if( check_RequestMethod() ){

            $_POST['name_application'] = trim($_POST['name_application']);
            $_POST['url_applicaton']   = trim($_POST['url_applicaton']);

            if( $this->validateForm($_POST) ){

                $id_app = appsModel::insertData(array(
                    'name_application' => $_POST['name_application'],
                    'url_application'  => $_POST['url_application'],
                    'description_application' => nl2br($_POST['description_application']),
                    'id_user' => appsModel::getSession('id_user'),
                ));

                if( count($_POST['id_platform']) ){
                    appsModel::insertApp2PlatformData( $id_app, $_POST['id_platform'] );
                }

                $uri_data = array('action' => 'edit', 'id_application' => $id_app);
            }else{
                appsModel::setSession('user_data', $_POST);
                $uri_data = array('action' => 'add');
            }

            if( !count(appsModel::$errors) )
                appsModel::$messages[] = 'Success!';

            appsModel::setSession(array(
                'errors'   => appsModel::$errors,
                'messages' => appsModel::$messages,
            ));

            header("Location: ".$this->makeURI($uri_data));
            die();
        }else
            _404();

    return null;
    }

    public function updateAction(){
        if( check_RequestMethod() ){

            $_POST['name_application'] = trim($_POST['name_application']);
            $_POST['url_applicaton']   = trim($_POST['url_applicaton']);

            if( $this->validateForm($_POST) ){

                appsModel::updateData(array(

                    'name_application' => $_POST['name_application'],
                    'url_application'  => $_POST['url_application'],
                    'description_application' => nl2br($_POST['description_application']),
                    'id_user' => appsModel::getSession('id_user'),
                    'id_application' => $_POST['id_application'],
                ));

                appsModel::deleteApp2PlatformData($_POST['id_application']);

                if( count($_POST['id_platform']) > 0 )
                    appsModel::insertApp2PlatformData($_POST['id_application'], $_POST['id_platform']);
            }

            if( !count(appsModel::$errors) )
                appsModel::$messages[] = 'Success!';

            appsModel::setSession(array(
                'errors'   => appsModel::$errors,
                'messages' => appsModel::$messages,
            ));

            header("Location: ".$this->makeURI(array('action' => 'edit', 'id_application' => $_POST['id_application'])));
            die();
        }else
            _404();
    return null;
    }

    public function deleteAction(){
        if( check_RequestMethod('GET') ){

            appsModel::deleteData( (int)$_GET['id_application'] );
            appsModel::deleteApp2PlatformData( (int)$_GET['id_application'] );
            appsModel::deleteLogData( (int)$_GET['id_application'] );

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
    private function getAppsList(){

        $id_user = classModel::getCurrentUserId();

        $apps_list = appsModel::getApps( $id_user );
        $platforms = platformModel::getPlatforms();
        $logs = logModel::getLastLogs();

        foreach( $apps_list as $k => $v ){
            $apps_list[$k]['platforms'] = appsModel::getApp2PlatformData( $v['id_application'] );
            $apps_list[$k]['btn_edit']  = $this->render_common('btn_edit', array(
                'url' => $this->makeURI(array('action' => 'edit', 'id_application' => $v['id_application'], 'id_user' => $v['id_user']))
            ));

            $apps_list[$k]['btn_delete'] = $this->render_common('btn_delete', array(
                'url'    => $this->makeURI(array('action' => 'delete', 'id_application' => $v['id_application'])),
                'confirm_text' => 'Do you want to delete this application?',
            ));
        }

        return $this->render('apps_list', array(
            'apps_list' => $apps_list,
            'platforms' => $platforms,
            'curent_user' => $id_user,
            'logs' => $logs,
            'btn_add_platform' => $this->render_common('btn_add', array(
                'url' => $this->makeURI(array('controller' => 'platforms', 'action' => 'add'))
            )),
        ));
    }

    private function getFilter(){

        if( authModel::is_SuperUserSession() ){

            $id_user = classModel::getCurrentUserId();

            // if the superuser is logged - set id user according to the filter state
            classModel::setSession('id_user', $id_user);
            return $this->render('filter_section', array(
                'user_filter' => userModel::getUsers(),
                'curent_user' => $id_user,
            ));
        }else
            return null;
    }

    private function validateForm($data){

        if( empty($data['name_application']) )
            appsModel::$errors[] = 'Empty application name';
        if( empty($data['url_application']) )
            appsModel::$errors[] = 'Empty application URL';

        return count(appsModel::$errors) == 0;
    }

    private function getForm( $data ){

        // data from last page reload. Save it and unset
        list( $errors, $messages, $user_data ) = appsModel::getSession(array('errors','messages','user_data'));
        appsModel::unsetSession(array('errors','messages','user_data'));

        // get platforms
        $platforms = platformModel::getPlatforms();

        // app to platforms link
        $app2platform = appsModel::getApp2PlatformData($data['user_data']['id_application']);

        return $this->render('apps_form', $data + array(
            'errors'        => $errors,
            'messages'      => $messages,
            'user_data'     => $user_data,
            'platforms'     => $platforms,
            'app2platform'  => $app2platform,
            'back_url'      => $this->makeURI(array('action' => 'list')),
        ));
    }
}
?>
