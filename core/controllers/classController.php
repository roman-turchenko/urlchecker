<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 17:31
 */
class classController extends classView{

    function __construct(){
    }

    function getTopMenu(){

        $sub_menu_model = str_replace('Controller', 'Model', get_class($this));

        return $this->render_common('top_menu', array(
            'main_menu' => classModel::getMainMenuData(),
            'sub_menu'  => $sub_menu_model::getSubMenuData(),
        ));
    }

    public function makeURI( $data = array() ){

        $result = array();

        if( empty($data['controller']) && $data['controller'] !== false )
            $data = array_merge(array('controller' => str_replace('Controller', '', get_class($this))), $data);

        if( is_array($data) ) foreach( $data as $k => $v ){
            $result[] = $k.'='.$v;
        }

    return APP_ROOT_URL.(count($result) > 0 ? '?'.implode('&', $result) : '');
    }

    public static function st_makeURI( $data ){
        return self::makeURI( $data );
    }
}