<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 01.07.14
 * Time: 11:33
 */ 
 
	include(VIEWS_DIR.'/common/header.php');
?>
	<form action="" class="form-container" method="post">
		
		<div class="form-title"><h2>App check system</h2></div>
        <br />
		<div class="form-title">User login</div>
		<input class="form-field" type="text" name="login" value="<?=$params['user_data']['login']?>" /><br />
		
		<div class="form-title">Password</div>
		<input class="form-field" type="password" name="password" /><br />
		
<?
	if( count($params['errors']) ){
		print '<div class="errors">'.implode('<br />', $params['errors']).'</div>';
	}
?>
		
		<div class="submit-container">
			<input class="submit-button" type="submit" value="Login" />
		</div>
	</form>
<?
	include(VIEWS_DIR.'/common/footer.php');
?>