<?
class appsController extends classController{

	function __construct(){

        $this->set_View_folder('apps');
	}	
	
	
//+ Public section
	
	public function mainAction(){
		
		echo $this->render('main', array(
            'apps_list' => $this->getAppsList()));
	}

    /**
     * @return bool
     * Check url
     */
    public function getHttpCodeAction(){

        if( check_RequestMethod() ){
            set_Json_header();
            $http_code = appsModel::getRequestHttpCode($_POST['url']);
            $result = array('code' => $http_code);
            print json_encode($result);
        }else
            _404();

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
}
?>
