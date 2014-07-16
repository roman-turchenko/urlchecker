<?
define('APP_ROOT_URL', '/');

/**
 * Start point 111111222222
 */
//session_set_cookie_params('', APP_ROOT_URL, $_SERVER['SERVER_NAME'], false, true);
session_start();

$controller = $_GET['controller'];
$action = $_GET['action'];

if( !isset($_SESSION['login']) || (bool)$_SESSION['login'] !== true ){
    $_SESSION['login']  = false;
    $_SESSION['id_user'] = null;

    if( $controller ) header("Location: ".APP_ROOT_URL);

    $controller = 'auth';
    $action = 'main';
}

require( __DIR__ . '/core/init.php' );
