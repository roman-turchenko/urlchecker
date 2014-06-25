<?
class classView{
	
	// controller view folder
	private $view_folder;
	
	public function set_View_folder( $view_folder ){
		$this->view_folder = strtolower($view_folder);
	}
	
	public function render( $template = 'main', $params = array() ){
		
		$template_path = VIEWS_DIR.'/'.$this->view_folder.'/'.$template.'.php';
		
		if ( !file_exists($template_path) )
			return 'No template found: '.$template_path;
			
		ob_start();
			require( $template_path );
		return ob_get_clean();
	}
}
?>
