<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 17:31
 */
class classController extends classView{

    public $add_id_user_to_links = false;
    public $instances = array();

    function __construct(){
    }

    function getTopMenu(){

        $current_controller_id = str_replace('Controller', '', get_class($this));
        $sub_menu_model = $current_controller_id.'Model';

        // Getting menues data
        $main_menu_data = classModel::getMainMenuData();
        $sub_menu_data  = $sub_menu_model::getSubMenuData();

        foreach( $main_menu_data as $k => $v ){

            $query_str_data = array();

            // if not  superuser - reassign "User" menu item
            if( !authModel::is_SuperUserSession() && $v['controller'] == 'user' ){
                $v['action'] = 'edit';
                $query_str_data = array('id_user' => classModel::getSession('id_user'));
            }

            $query_str_data += array('controller' => $v['controller'], 'action' => $v['action']);

            // define the current menu-item
            if( $current_controller_id == $v['controller'] )
                $main_menu_data[$k]['current'] = 'current';

            // Add URI
            $main_menu_data[$k]['url'] = $this->makeURI($query_str_data);
        }

        foreach( $sub_menu_data as $k => $v ){

            $query_str_data = array();

            // if not superuser - remove "Add" menu item in "Users" section
            if( !authModel::is_SuperUserSession() && $v['controller'] == 'user' ){
                unset($sub_menu_data[$k]);
            }

            $query_str_data = array('controller' => $v['controller'], 'action' => $v['action']);

            // define the current menu-item
            if( $current_controller_id == $v['controller'] )
                $sub_menu_data[$k]['current'] = 'current';

            // Add URL
            $sub_menu_data[$k]['url'] = $this->makeURI($query_str_data);
        }

        return $this->render_common('top_menu', array(
            'main_menu' => $main_menu_data,
            'sub_menu'  => $sub_menu_data,
        ));
    }

    public function makeURI( $data = array() ){

        $result = array();

        if( empty($data['controller']) && $data['controller'] !== false )
            $data = array_merge(array('controller' => str_replace('Controller', '', get_class($this))), $data);

        if( is_array($data) ) foreach( $data as $k => $v ){
            $result[] = $k.'='.$v;
        }

        // add user information if superuser
        /*
        if( authModel::is_SuperUserSession() )
            $result[] = 'id_user='.classModel::getCurrentUserId();
*/
    return APP_ROOT_URL.(count($result) > 0 ? '?'.implode('&', $result) : '');
    }

    public static function st_makeURI( $data ){
        return self::makeURI( $data );
    }

    public function getInstance( $name ){

        if( !is_object($this->instances[$name]) )
            $this->instances[$name] = new $name();

        return $this->instances[$name];
    }

}