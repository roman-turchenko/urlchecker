<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 16:19
 */

?>
<form action="<?=$params['action']?>" class="form-container" method="post">

		<div class="form-title"><h2>Application</h2></div>
        <br />
		<div class="form-title">Name application</div>
		<input class="form-field" type="text" name="name_application" value="<?=$params['user_data']['name_application']?>" /><br />

		<div class="form-title">URL application</div>
		<input class="form-field" type="text" name="url_application" value="<?=$params['user_data']['url_application']?>" /><br />

        <div class="form-title">Description</div>
        <textarea name="description_application" ><?=$params['user_data']['description_application']?></textarea><br />


        <input type="hidden" name="id_application" value="<?=$params['user_data']['id_application']?>" />

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