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
    default:
?>
    <link rel="stylesheet" href="./fonts/glyphter-font/css/Glyphter.css" />
    <!--<link rel="stylesheet" href="./css/jquery-ui.min.css">-->
    <link rel="stylesheet" href="./css/style.css" />

	<script src="./js/jquery-1.10.2.min.js"></script>
    <!--<script src="./js/jquery.ui-1.10.4.min.js"></script>-->

	<script src="./js/script.js"></script>

<?
//  less
?>
   <!-- <link rel="stylesheet/less" type="text/css" href="./css/style.less" />
    <script src="./js/less.js"></script>-->
<?
	break;
}
?>
</head>
<body>
<div class="wrapper">