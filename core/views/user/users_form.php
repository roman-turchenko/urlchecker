<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 16:19
 */

?>
<form action="<?=$params['action']?>" class="form-container" method="post">

    <div class="form-title"><h2>Users</h2></div>
    <br />
    <div class="form-title">Login</div>
    <input class="form-field" type="text" name="login_user" value="<?=$params['user_data']['login_user']?>" /><br />

    <div class="form-title">Email</div>
    <input class="form-field" type="text" name="email_user" value="<?=$params['user_data']['email_user']?>" /><br />

    <div class="form-title">New password</div>
    <input class="form-field" type="text" name="password_user" value="<?=$params['user_data']['password_user']?>" /><br />

    <input type="hidden" name="id_user" value="<?=$params['user_data']['id_user']?>" />

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