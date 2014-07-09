<?
class appsController extends classController{

    function __construct(){

        $this->set_View_folder('apps');
	}	
	
	
//+ Public section
	public function mainAction( $content = 'Hello!' ){

        echo $this->render('main', array(
            'content'  => $content,
            'top_menu' => $this->getTopMenu(),
        ));
	}

    public function addAction(){

        $this->getForm(array(
            'action' => $this->makeURI(array('action' => 'insert')),
        ));

        return null;
    }

    public function editAction(){

        $this->getForm(array(
            'user_data' => appsModel::getApplicationData( (int)$_GET['id_application'] ),
            'action'    => $this->makeURI(array('action' => 'update', 'id_aplication' => (int)$_GET['id_application'])),
        ));

        return null;
    }

    public function listAction(){

        $this->mainAction(
            $this->getAppsList()
        );

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

                $uri_data = array('action' => 'edit', 'id_application' => $id_app);
            }else{
                appsModel::setSession('user_data', $_POST);
                $uri_data = array('action' => 'add');
            }

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
            }

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
            header("Location: ".$this->makeURI(array('action' => 'list')));
            die();
        }else
            _404();
    }

    /**
     * @return bool
     * Check url
     */
    public function getHttpCodeAction(){

        if( check_RequestMethod() ){
            set_Json_header();

            $result = array(
                'code' => appsModel::getRequestHttpCode($_POST['url']),
                'total'=> appsModel::getRequestInfo($_POST['url']));

            print json_encode($result);
            die();
        }else
            _404();

        return false;
    }

    public function showAppAction(){

        $url = $_GET['url'];
        print appsModel::getAppLook($url);

        return false;
    }

//+ Private section

    /**
     * Get app list
     * @return string
     */
    private function getAppsList(){

        $apps_list = appsModel::getApps();

        return $this->render('apps_list', array(
            'apps_list' => is_array($apps_list) ? $apps_list : array()));
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

        $this->mainAction(
            $this->render('apps_form', $data + array(
                'errors'   => $errors,
                'messages' => $messages,
                'user_data' => $user_data,
            ))
        );
    }
}
?>