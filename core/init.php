<?	
	define('CORE_DIR', realpath(dirname(__FILE__)));
	define('CONTEROLLERS_DIR', CORE_DIR.'/controllers');
	define('VIEWS_DIR', CORE_DIR.'/views');
	define('MODELS_DIR', CORE_DIR.'/models');
	
	define('LIBS_DIR', CORE_DIR.'/libs');
	
	function __autoload( $class_name ){
		_include(CONTEROLLERS_DIR.'/'.$class_name.'.php');
		_include(MODELS_DIR.'/'.$class_name.'.php');
		_include(VIEWS_DIR.'/'.$class_name.'.php');
	}
	
	if( !$controller ) $controller = 'main';
	if( !$action ) $action = 'main';
	
	$controller .= 'Controller'; 
	$action     .= 'Action';

	if( !file_exists(CONTEROLLERS_DIR.'/'.$controller.'.php') ) _404();

//  init controller and execute
	if( !method_exists($obj = new $controller(), $action) ) _404();
	else
		$obj->$action();


		
/*+++ Functions +++*/  
	function _404(){
		header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
		header("Location: ./404.php");
		exit();
	}
	
	function check_RequestMethod( $request_method = 'POST' ){
		return $_SERVER['REQUEST_METHOD'] == $request_method;
	}
	
	function _include( $path ){
		if( file_exists($path) ) include($path);
		return false;
	}
?>
