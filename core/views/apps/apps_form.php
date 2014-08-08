<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 16:19
 */

?>
<form action="<?=$params['action']?>" class="form-container" method="post">
    <h2><?=($params['user_data']['id_application']?'Edit "'.$params['user_data']['name_application'].'" application':'Add new application')?></h2>
    <table>
        <tr>
            <td>Name application:</td>
            <td><input class="form-field" type="text" name="name_application" value="<?=$params['user_data']['name_application']?>" /></td>
        </tr>
        <tr>
            <td>URL application:</td>
            <td><input class="form-field" type="text" name="url_application" value="<?=$params['user_data']['url_application']?>" /></td>
        </tr>
        <tr>
            <td>Applications platforms:</td>
            <td>
                <ul>
<?
foreach( $params['platforms'] as $v ){
?>
    <li><label><input name="id_platform[]" type="checkbox" value="<?=$v['id_platform']?>" <?=(in_array($v['id_platform'], $params['app2platform']) ? 'checked' : '')?> /> <?=$v['name_platform']?></label></li>
<?
}
?>
                </ul>
            </td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><textarea name="description_application" ><?=$params['user_data']['description_application']?></textarea></td>
        </tr>
        <tr>
            <td colspan="2">
<?  if( count($params['errors']) > 0 ){?>
                <div class="errors"><?=implode('<br />', $params['errors'])?></div>
<?  }?>
<?  if( count($params['messages']) > 0 ){?>
                <div class="messages"><?=implode('<br />', $params['messages'])?></div>
<?}?>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="id_application" value="<?=$params['user_data']['id_application']?>" />
            </td>
            <td>
                <input class="submit-button" type="submit" value="Apply" />
                <a href="<?=$params['back_url']?>">Back</a>
            </td>
        </tr>
    </table>
<?
    if( !empty($params['app_log']) ){
?>
        <div class="right_coll"><?=$params['app_log']?></div>
<?
    }
?>
</form>



