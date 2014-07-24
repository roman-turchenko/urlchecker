<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 18:02
 */
?>
<form action="<?=$params['action']?>" class="form-container" method="post">

		<div class="form-title"><h2>Platform</h2></div>
        <br />
		<div class="form-title">Name platform</div>
		<input class="form-field" type="text" name="name_platform" value="<?=$params['user_data']['name_platform']?>" /><br />

		<div class="form-title">User Agent string</div>
		<input class="form-field" type="text" name="UA_string" value="<?=$params['user_data']['UA_string']?>" /><br />

        <div class="form-title">Description</div>
        <textarea name="description_platform" ><?=$params['user_data']['description_platform']?></textarea><br />


<input type="hidden" name="id_platform" value="<?=$params['user_data']['id_platform']?>" />

<div class="submit-container">
    <input class="submit-button" type="submit" value="Apply" />
</div>
</form>
<?
if( count($params['errors']) > 0 ){
    ?>
    <div class="errors"><?=implode('<br />', $params['errors'])?></div>
<?}?>

<?
if( count($params['messages']) > 0 ){
    ?>
    <div class="messages"><?=implode('<br />', $params['messages'])?></div>
<?}?>