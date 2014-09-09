<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 18:02
 */
?>
<form action="<?=$params['action']?>" class="form-container" method="post">

    <h2><?=($params['user_data']['id_platform']?'Edit "'.$params['user_data']['name_platform'].'" platform':'Add new platform')?></h2>
    <table>
        <tr>
            <td>Name:</td>
            <td><input class="form-field" type="text" name="name_platform" value="<?=$params['user_data']['name_platform']?>" /></td>
        </tr>
        <tr>
            <td>UA string:</td>
            <td><textarea name="UA_string"><?=$params['user_data']['UA_string']?></textarea></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><textarea name="description_platform" ><?=$params['user_data']['description_platform']?></textarea></td>
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
                <input type="hidden" name="id_platform" value="<?=$params['user_data']['id_platform']?>" />
            </td>
            <td>
                <input class="submit-button" type="submit" value="Apply" />
            </td>
        </tr>
    </table>
</form>
