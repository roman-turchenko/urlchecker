<?
class appsModel extends classModel{

	function __construct(){ }

    /**
     * Get application list
     */
    static function getApps(){
        return array(

            array('name' => 'Yandex', 'url' => 'http://yandex.ru'),
            array('name' => 'Google', 'url' => 'http://google.ru'),
            array('name' => 'HabrHabr', 'url' => 'http://habrahabr.ru'),
        );
    }
}
?>