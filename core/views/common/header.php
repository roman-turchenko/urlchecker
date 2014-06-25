<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin | Lg Cinema</title>
<?
	switch( get_class($this) ){
	
		case 'authController':
?>
	<link rel="stylesheet" type="text/css" href="./css/auth.css">
<?
		break;
		
		case 'postersController':
?>
	<link rel="stylesheet" type="text/css" href="./css/posters.css">
	<link rel="stylesheet" type="text/css" href="./css/timepicker.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css">
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
	<script src="./js/timepicker.js"></script>
	<script src="./js/script.js"></script>
<?
		break;
	}
?>
</head>
<body>