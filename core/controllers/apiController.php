<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 11:20
 */
class apiController extends classController{

    function __construct(){

        //$this->set_View_folder('apps');
    }

    public function mainAction(){
        _404();
    }

    public function getHttpCodeAction(){

        //$app_url = $_GET['app_url'];
        $id_application = $_POST['id_application'];
        $id_platform    = $_POST['id_platform'];

        if( check_RequestMethod('POST') ){

            set_Json_header();

            $app_data = appsModel::getApplicationData($id_application);
            $platform_data = platformModel::getPlatformData($id_platform);

/*  bool   CURLOPT_FRESH_CONNECT - TRUE to force the use of a new connection instead of a cached one.
 *  string CURLOPT_USERAGENT     - The contents of the "User-Agent: " header to be used in a HTTP request.
 *  array  CURLOPT_HTTPHEADER     - An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100')
 *  bool   CURLOPT_RETURNTRANSFER - TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
 * */
            $response_data = apiModel::getRequestInfo($app_data['url_application'], false, array(
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_USERAGENT      => $platform_data['UA_string'],
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT    => true,
            ));

            $log_data = array(
                'id_application' => $id_application,
                'id_platform'    => $id_platform,
                'HTTP_code'      => !count(apiModel::$errors) ? $response_data['http_code'] : apiModel::$errors[0],
                'date_check'     => date('Y-m-d H:i:s', time()),
                'id_user'        => authModel::getCurrentUserId(),
                'size_download'  => $response_data['size_download'],
                'download_content_length' => $response_data['download_content_length'],
                'redirect_url'   => $response_data['redirect_url'],
                'request_header' => $response_data['request_header'],
            );

            logModel::insertData($log_data);

            print json_encode($log_data+array('curl_response' => $response_data));
            die();
        }else
            _404();
    }

/*  +++ Private section +++ */
}