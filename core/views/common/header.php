<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>URL checker</title>
<?
switch( get_class($this) ){

    case 'authController':
?>
    <link rel="stylesheet" href="./css/auth.css">
<?
	break;
    case 'appsController':
            /*<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css">
            <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
            */
?>
    <link rel="stylesheet" href="./css/style.css" />

	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="./js/script.js"></script>
<?
		break;
	}
?>
</head>
<body>