<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 11:41
 */
class logController extends classController{

    function __construct(){

        $this->set_View_folder('log');
    }

    public function mainAction(){
        _404();
    }

    public function getAppLogs( $id_application ){

        $result = array();
        //$log_data  = logModel::getAppLog( $id_application, $id_platform );
        $platforms = platformModel::getPlatforms();

        foreach( $platforms as $k => $v ){

            $log_data = array();
            $log_data = logModel::getAppLog( $id_application, $v['id_platform'], 10 );

            if( count($log_data) )
                $result[$v['id_platform']] = $log_data + array('name_platform' => $v['name_platform']);
        }

        return $this->render('app_log', array(
            'app_log' => $result,
        ));
    }
}