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
            'content'  => $content['content_data'],
            'top_menu' => $this->getTopMenu(),
            'filter_section' => $this->render_common('filter_section', array(
                'data' => $content['filter_data']
             ))
        ));
    }

    public function listAction(){

        $platforms_list = platformModel::getPlatforms();

        foreach( $platforms_list as $k => $v ){

            $platforms_list[$k]['btn_edit'] = $this->render_common('btn_edit', array(
                'url' => $this->makeURI(array('action' => 'edit', 'id_platform' => $v['id_platform']))
            ));

            $platforms_list[$k]['btn_delete'] = $this->render_common('btn_delete', array(
                'url' => $this->makeURI(array('action' => 'delete', 'id_platform' => $v['id_platform'])),
                'confirm_text' => 'Do you want to delete this platform?'
            ));
        }

        $this->mainAction(array(
            'content_data' => $this->render('platforms_list', array(
                'platforms_list' => $platforms_list
            )),
        ));

        return null;
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
                'user_data' => platformModel::getPlatformData( (int)$_GET['id_platform'] ),
                'action'    => $this->makeURI(array('action' => 'update', 'id_platform' => (int)$_GET['id_platform'])),
            ))
        ));

        return null;
    }

    public function deleteAction(){

        if( check_RequestMethod('GET') ){
            platformModel::deleteData((int)$_GET['id_platform']);
            platformModel::deletePlatform2AppData((int)$_GET['id_platform']);
            platformModel::deleteLogData((int)$_GET['id_platform']);

            header("Location: ".$this->makeURI(array('action' => 'list')));
        }else
            _404();
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

            if( !count(platformModel::$errors) )
                platformModel::$messages[] = 'Success!';

            platformModel::setSession(array(
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

            $_POST['name_platform'] = trim($_POST['name_platform']);
            $_POST['UA_string']   = trim($_POST['UA_string']);

            if( $this->validateForm($_POST) ){

                platformModel::updateData(array(

                    'name_platform' => $_POST['name_platform'],
                    'UA_string'  => $_POST['UA_string'],
                    'description_platform' => strip_tags($_POST['description_platform']),
                    'id_user' => platformModel::getSession('id_user'),
                    'id_platform' => $_POST['id_platform'],
                ));
            }

            if( !count(platformModel::$errors) )
                platformModel::$messages[] = 'Success!';

            platformModel::setSession(array(
                'errors'   => platformModel::$errors,
                'messages' => platformModel::$messages,
            ));

            header("Location: ".$this->makeURI(array('action' => 'edit', 'id_platform' => $_POST['id_platform'])));
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
        list( $errors, $messages, $user_data ) = platformModel::getSession(array('errors','messages','user_data'));
        platformModel::unsetSession(array('errors','messages','user_data'));


        return $this->render('platforms_form', $data + array(
            'errors'   => $errors,
            'messages' => $messages,
            'user_data' => $user_data,
        ));
    }
}