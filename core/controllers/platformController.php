<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 10:01
 */
class platformController extends classController{

    function __construct(){
        $this->set_View_folder('platform');
    }

    public function mainAction( $content = 'Hello!' ){

        echo $this->render('main', array(
            'content'  => $content,
            'top_menu' => $this->getTopMenu(),
        ));
    }

    public function listAction(){

        $this->mainAction(

            $this->render('platforms_list', array(
                'platforms_list' => platformModel::getPlatforms()
            ))
        );

        return null;
    }

    public function addAction(){

        $this->getForm(array(
            'action' => $this->makeURI(array('action' => 'insert')),
        ));

        return null;
    }

    public function editAction(){

        $this->getForm(array(
            'user_data' => platformModel::getPlatformData( (int)$_GET['id_platform'] ),
            'action'    => $this->makeURI(array('action' => 'update', 'id_platform' => (int)$_GET['id_platform'])),
        ));

        return null;
    }

    public function insertAction(){

        if( check_RequestMethod() ){

            $_POST['name_platform']  = trim($_POST['name_platform']);
            $_POST['UA_string']  = trim($_POST['UA_string']);

            if( $this->validateForm($_POST) ){

                $id_platform = platformModel::insertData(array(
                    'name_platform' => $_POST['name_platform'],
                    'UA_string'     => $_POST['UA_string'],
                    'description_platform' => nl2br($_POST['description_platform']),
                ));

                $uri_data = array('action' => 'edit', 'id_platform' => $id_platform);
            }else{
                platformModel::setSession('user_data', $_POST);
                $uri_data = array('action' => 'add');
            }

            appsModel::setSession(array(
                'errors'   => platformModel::$errors,
                'messages' => platformModel::$messages,
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

    private function validateForm($data){

        if( empty($data['name_platform']) )
            platformModel::$errors[] = 'Empty platform name';
        if( empty($data['UA_string']) )
            platformModel::$errors[] = 'Empty platform User Agent string';

        return count(platformModel::$errors) == 0;
    }

    private function getForm( $data ){

        // data from last page reload. Save it and unset
        list( $errors, $messages, $user_data ) = appsModel::getSession(array('errors','messages','user_data'));
        appsModel::unsetSession(array('errors','messages','user_data'));

        $this->mainAction(
            $this->render('platforms_form', $data + array(
                    'errors'   => $errors,
                    'messages' => $messages,
                    'user_data' => $user_data,
                ))
        );
    }
}