<?
    include('constants.php');
    include('functions.php');

	if( !$controller ) $controller = 'main';
	if( !$action ) $action = 'main';

    classModel::$controller = $controller;
	classModel::$action     = $action;

    $controller .= 'Controller';
	$action     .= 'Action';

    if( !file_exists(CONTEROLLERS_DIR.'/'.$controller.'.php') ) _404();

//  init controller and execute action
	if( !method_exists($obj = new $controller(), $action) ) _404();
	else
		$obj->$action();
?>
