<?
class classModel{

    public static  $action = null;
    public static  $controller = null;
    public static  $errors = array();
    public static  $messages = array();

    function __construct(){

    }


//  ++++ Curl
    static function getRequestInfo( $url, $opt = false ){

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);

        $result = !self::getCurlError(curl_errno($ch))
            ? ($opt ? curl_getinfo($ch, $opt):curl_getinfo($ch))
            : self::getCurlError(curl_errno($ch));

        curl_close($ch);

        return $result;
    }

    /**
     * @param $url
     * @return bool|mixed
     * Get last request HTTP code
     * TODO: add headers for different tv platforms
     */
    static function getRequestHttpCode( $url ){
        return self::getRequestInfo( $url, CURLINFO_HTTP_CODE );
    }

    static function getCurlError( $error_code ){

        $error_codes=array(
            '1' => 'CURLE_UNSUPPORTED_PROTOCOL',
            '2' => 'CURLE_FAILED_INIT',
            '3' => 'CURLE_URL_MALFORMAT',
            '4' => 'CURLE_URL_MALFORMAT_USER',
            '5' => 'CURLE_COULDNT_RESOLVE_PROXY',
            '6' => 'CURLE_COULDNT_RESOLVE_HOST',
            '7' => 'CURLE_COULDNT_CONNECT',
            '8' => 'CURLE_FTP_WEIRD_SERVER_REPLY',
            '9' => 'CURLE_REMOTE_ACCESS_DENIED',
            '11' => 'CURLE_FTP_WEIRD_PASS_REPLY',
            '13' => 'CURLE_FTP_WEIRD_PASV_REPLY',
            '14' => 'CURLE_FTP_WEIRD_227_FORMAT',
            '15' => 'CURLE_FTP_CANT_GET_HOST',
            '17' => 'CURLE_FTP_COULDNT_SET_TYPE',
            '18' => 'CURLE_PARTIAL_FILE',
            '19' => 'CURLE_FTP_COULDNT_RETR_FILE',
            '21' => 'CURLE_QUOTE_ERROR',
            '22' => 'CURLE_HTTP_RETURNED_ERROR',
            '23' => 'CURLE_WRITE_ERROR',
            '25' => 'CURLE_UPLOAD_FAILED',
            '26' => 'CURLE_READ_ERROR',
            '27' => 'CURLE_OUT_OF_MEMORY',
            '28' => 'CURLE_OPERATION_TIMEDOUT',
            '30' => 'CURLE_FTP_PORT_FAILED',
            '31' => 'CURLE_FTP_COULDNT_USE_REST',
            '33' => 'CURLE_RANGE_ERROR',
            '34' => 'CURLE_HTTP_POST_ERROR',
            '35' => 'CURLE_SSL_CONNECT_ERROR',
            '36' => 'CURLE_BAD_DOWNLOAD_RESUME',
            '37' => 'CURLE_FILE_COULDNT_READ_FILE',
            '38' => 'CURLE_LDAP_CANNOT_BIND',
            '39' => 'CURLE_LDAP_SEARCH_FAILED',
            '41' => 'CURLE_FUNCTION_NOT_FOUND',
            '42' => 'CURLE_ABORTED_BY_CALLBACK',
            '43' => 'CURLE_BAD_FUNCTION_ARGUMENT',
            '45' => 'CURLE_INTERFACE_FAILED',
            '47' => 'CURLE_TOO_MANY_REDIRECTS',
            '48' => 'CURLE_UNKNOWN_TELNET_OPTION',
            '49' => 'CURLE_TELNET_OPTION_SYNTAX',
            '51' => 'CURLE_PEER_FAILED_VERIFICATION',
            '52' => 'CURLE_GOT_NOTHING',
            '53' => 'CURLE_SSL_ENGINE_NOTFOUND',
            '54' => 'CURLE_SSL_ENGINE_SETFAILED',
            '55' => 'CURLE_SEND_ERROR',
            '56' => 'CURLE_RECV_ERROR',
            '58' => 'CURLE_SSL_CERTPROBLEM',
            '59' => 'CURLE_SSL_CIPHER',
            '60' => 'CURLE_SSL_CACERT',
            '61' => 'CURLE_BAD_CONTENT_ENCODING',
            '62' => 'CURLE_LDAP_INVALID_URL',
            '63' => 'CURLE_FILESIZE_EXCEEDED',
            '64' => 'CURLE_USE_SSL_FAILED',
            '65' => 'CURLE_SEND_FAIL_REWIND',
            '66' => 'CURLE_SSL_ENGINE_INITFAILED',
            '67' => 'CURLE_LOGIN_DENIED',
            '68' => 'CURLE_TFTP_NOTFOUND',
            '69' => 'CURLE_TFTP_PERM',
            '70' => 'CURLE_REMOTE_DISK_FULL',
            '71' => 'CURLE_TFTP_ILLEGAL',
            '72' => 'CURLE_TFTP_UNKNOWNID',
            '73' => 'CURLE_REMOTE_FILE_EXISTS',
            '74' => 'CURLE_TFTP_NOSUCHUSER',
            '75' => 'CURLE_CONV_FAILED',
            '76' => 'CURLE_CONV_REQD',
            '77' => 'CURLE_SSL_CACERT_BADFILE',
            '78' => 'CURLE_REMOTE_FILE_NOT_FOUND',
            '79' => 'CURLE_SSH',
            '80' => 'CURLE_SSL_SHUTDOWN_FAILED',
            '81' => 'CURLE_AGAIN',
            '82' => 'CURLE_SSL_CRL_BADFILE',
            '83' => 'CURLE_SSL_ISSUER_ERROR',
            '84' => 'CURLE_FTP_PRET_FAILED',
            '85' => 'CURLE_RTSP_CSEQ_ERROR',
            '86' => 'CURLE_RTSP_SESSION_ERROR',
            '87' => 'CURLE_FTP_BAD_FILE_LIST',
            '88' => 'CURLE_CHUNK_FAILED');

        return $error_codes[$error_code]?$error_codes[$error_code]:false;
    }


//  ++++ MySql
    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    public static function query( $sql ){
        return DB::getInstance()->query( $sql );
    }

    public static function fetchAssoc( $res ){
        return DB::getInstance()->fetchAssoc( $res );
    }

    public static function escapeString( $string ){
        return DB::getInstance()->escapeString( $string );
    }

    public static function numRows( $res ){
        return DB::getInstance()->numRows( $res );
    }

    public static function insertID(){
        return DB::getInstance()->insertID();
    }

    public static function queryError(){
        return DB::getInstance()->queryError();
    }


//  ++++ Menu
    static function getMainMenuData(){
        return array(

            array('title' => 'Applications list',
                  'url'     => classController::st_makeURI(array('controller' => 'apps', 'action' => 'list'))),

            array('title' => 'Platforms list',
                  'url'   => classController::st_makeURI(array('controller' => 'platform', 'action' => 'list'))),

            array('title' => 'User profile',
                  'url'   => classController::st_makeURI(array('controller' => 'user', 'action' => 'list'))),

            array('title' => 'Logout',
                  'url'   => classController::st_makeURI(array('controller' => 'auth', 'action' => 'logout'))),
        );
    }

//  ++++ SESSION
    public static function setSession($key, $value = ''){
        if( is_array($key) ) foreach( $key as $k => $v )
            $_SESSION[$k] = $v;
        else
            $_SESSION[$key] = $value;

        return null;
    }

    public static function unsetSession( $key ){

        if( is_array($key) ) foreach( $key as $v ) unset($_SESSION[$v]);
        else
            unset($_SESSION[$key]);
        return null;
    }

    public static function getSession( $key ){

        $result = null;
        if( is_array($key) ) foreach( $key as $v ) $result[] = $_SESSION[$v];
        else
            $result = $_SESSION[$key];

        return $result;
    }

}
?>