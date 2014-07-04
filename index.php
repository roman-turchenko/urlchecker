<?
define('APP_ROOT_URL', '/');

/**
 * Start point
 */
session_set_cookie_params('', '/', $_SERVER['SERVER_NAME'], false, true);
session_start();


$controller = $_GET['controller'];
$action = $_GET['action'];


if( !isset($_SESSION['login']) && !(bool)$_SESSION['login'] === true )
    $_SESSION['login'] = false;

if( empty($controller) || !$_SESSION['login'] ){
    $controller = 'auth';
    $action = 'main';
}

require( __DIR__ . '/core/init.php' );
