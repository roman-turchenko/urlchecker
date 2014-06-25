<?
class mainController extends classView{

	function __construct(){
		$this->set_View_folder('main');
		$this->model = new mainModel();
	}	
	
	
//+ Public section
	
	public function mainAction(){
		
		echo $this->render('main', array()); 
	}


//+ Private section
}
?>
