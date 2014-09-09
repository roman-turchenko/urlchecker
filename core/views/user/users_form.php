<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 16:19
 */
?>
<form action="<?=$params['action']?>" class="form-container" method="post">
    <h2><?=($params['user_data']['id_user']?'Edit "'.$params['user_data']['login_user'].'" user':'Add new user')?></h2>
    <table>
        <tr>
            <td>Login:</td>
            <td><input class="form-field" type="text" name="login_user" value="<?=$params['user_data']['login_user']?>" /></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input class="form-field" type="text" name="email_user" value="<?=$params['user_data']['email_user']?>" /></td>
        </tr>
        <tr>
            <td>New password:</td>
            <td><input class="form-field" type="text" name="password_user" value="<?=$params['user_data']['password_user']?>" /></td>
        </tr>
        <tr>
            <td colspan="2">
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
            </td>
        </tr>
        <tr>
            <td>
                <input name="id_user" type="hidden" value="<?=$params['user_data']['id_user']?>" />
            </td>
            <td>
                <input class="submit-button" type="submit" value="Apply" />
            </td>
        </tr>
    </table>
</form>
