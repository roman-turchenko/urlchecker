<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 13:11
 */
?>
<table border="1">
    <tr>
        <th>App. name</th>
        <th>URL</th>
        <th colspan="2">Actions</th>
        <th>HTTP code</th>
        <th>Show</th>
        <th>Dif</th>
    </tr>
<?
foreach ($params['apps_list'] as $v) {
?>
    <tr>
        <td><?=$v['name_application']?></td>
        <td><?=$v['url_application']?></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'edit', 'id_application' => $v['id_application']))?>">Edit</a></td>
        <td><a onClick="javascript: if(confirm('Delete?')) return true; return false;" href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'delete', 'id_application' => $v['id_application']))?>">Delete</a></td>
        <td><div class="http_code" data-url="<?=$v['url']?>">&nbsp;</div></td>
        <td></td>
        <td></td>
    </tr>
<?
    }
?>
</table>
