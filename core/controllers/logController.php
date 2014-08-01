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
        $log_data  = logModel::getAppLog( $id_application );
        $platforms = platformModel::getPlatforms();

        foreach( $platforms as $k => $v )
            $platforms[$v['id_platform']] = $v['name_platform'];

        foreach( $log_data as $k => $v ){

            $result[$v['id_platform']][] = $v + array(
                'name_platform' => $platforms[$v['id_platform']],
            );
        }

        return $this->render('app_log', array(
            'app_log' => $result,
        ));
    }
}