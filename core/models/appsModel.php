<?
class appsModel extends classModel{

	function __construct(){ }

    /**
     * Get application list
     */
    static function getApps(){
        return array(

            array('name' => 'Yandex', 'url' => 'http://www.yandex.ru'),
            array('name' => 'Google', 'url' => 'http://www.google.ru'),
            array('name' => 'HabrHabr', 'url' => 'http://www.habrahabr.ru',),
            array('name' => 'MySite', 'url' => 'http://www.mysite.ru/lol',),
            array('name' => 'Test', 'url' => 'http://test1.ru/',),
        );
    }

    static function getAppLook( $url, $device = '' ){

        $device;
        $ch = curl_init($url);
        ob_start();
        curl_exec($ch);

        return ob_get_clean();
    }
}
?>