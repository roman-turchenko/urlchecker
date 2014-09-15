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


        $resources = array();
        $id_application = $_GET['id_application'];
        $id_platform    = $_GET['id_platform'];

        if( check_RequestMethod('GET') ){

            set_Json_header();

            $app_data = appsModel::getApplicationData($id_application);
            $platform_data = platformModel::getPlatformData($id_platform);

/*  bool   CURLOPT_FRESH_CONNECT - TRUE to force the use of a new connection instead of a cached one.
 *  string CURLOPT_USERAGENT     - The contents of the "User-Agent: " header to be used in a HTTP request.
 *  array  CURLOPT_HTTPHEADER     - An array of HTTP header fields to set, in the format array('Content-type: text/plain', 'Content-length: 100')
 *  bool   CURLOPT_RETURNTRANSFER - TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
 * */
            $response_data = apiModel::getRequestInfo($app_data['url_application'], array(
                CURLOPT_FRESH_CONNECT  => true,
                CURLOPT_USERAGENT      => $platform_data['UA_string'],
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT    => true,
            ));
print_r($response_data);
            $resources = $this->getResources( $app_data['url_application'], $response_data['html'] );
            if( is_array($resources) ) foreach( $resources as $v ){

                $r = apiModel::getRequestInfo($v, array(
                    CURLOPT_FRESH_CONNECT  => true,
                    CURLOPT_USERAGENT      => $platform_data['UA_string'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLINFO_HEADER_OUT    => true,
                ));

                $response_data['size_download'] += $r['size_download'];
            }

            $last_log_data = logModel::getLastLogs( $id_application, $id_platform );
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
                'weight_diff'    => $response_data['size_download'] - $last_log_data[$id_application][$id_platform]['size_download'],
                'app_resources'  => implode(', ', $resources),
            );

            if( ($id_check_log = logModel::checkInBase($log_data, array('date_check','app_resources'))) !== false ){
                logModel::updateData($log_data + array('id_check_log' => $id_check_log));
            }else{
                $id_check_log = logModel::insertData($log_data);
            }

            $log_data = logModel::getLog( $id_check_log );

            print json_encode($log_data+array('curl_response' => $response_data, 'last_log' => $last_log_data));
            die();
        }else
            _404();
    }

    public function getResouresAction(){

        //$url = 'http://app.lgerp.ru/apps/lgcinema/?id=2';
        $url = 'http://yandex.ru';
        $response_data = apiModel::getRequestInfo($url);

        $html = $response_data['html'];

        //$this->collectResources($html);
        $resources = $this->getResources( $url, $html );

        print_r($resources);
/*
        // Collecting resources
        preg_match_all('/<script[^>]*src="([^"]+\.js\?{0,1}[^>]*)"[^>]*>/', $html, $mch);
        print_r($mch);

        preg_match_all('/<style[^>]*src="([^"]+\.css\?{0,1}[^>]*)"[^>]*>/', $html, $mch);
        print_r($mch);

        preg_match_all('/<link[^>]*href="([^"]+\.css\?{0,1}[^>]*)"[^>]*>/', $html, $mch);
        print_r($mch);

        print_r($html);
  */
        exit();
/*
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLINFO_HTTP_CODE, 1);
        curl_exec($ch);
        $test = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        print_r($test);
        */
        print_r($response_data);

        //print 'Hello!';
    }

/*  +++ Private section +++ */
    private function collectResources( $html ){

        $result = array();
        $patterns = array(
            // js
            '/<script[^>]*src="([^"]+\.js\?{0,1}[^>]*)"[^>]*>/',
            // css
            '/<style[^>]*src="([^"]+\.css\?{0,1}[^>]*)"[^>]*>/',
            '/<link[^>]*href="([^"]+\.css\?{0,1}[^>]*)"[^>]*>/'
        );

        foreach( $patterns as $v ){
            if( preg_match_all($v, $html, $mch) )
                $result = array_merge($result, $mch[1]);
        }

        return $result;
    }

    private function getResources( $url, $html = '' ){

        if( empty($html) ){
            $response_data = apiModel::getRequestInfo($url);
            $html = $response_data['html'];
        }

        if( $html ){

            $resources = $this->collectResources( $html );
            for( $i = 0; $i < count($resources); $i++ ){

                if( preg_match('/^\/\/[^\.]+\..+/', $resources[$i]) )
                    $resources[$i] = 'http:'.$resources[$i];

                if( !preg_match('/^http:\/\/[^\/]+\/.+/', $resources[$i]) ){

                    preg_match('/^(https{0,1}:\/\/[^\/]+\/{0,1}[^\?]*)/', $url, $mch);
                    $resources[$i] = preg_replace('/(?<!:)\/\//', '/', $mch[1].'/'.$resources[$i]);
                }
            }

            return $resources;
        }else
            apiModel::$errors[] = __METHOD__.': no html.';

        return false;
    }
}