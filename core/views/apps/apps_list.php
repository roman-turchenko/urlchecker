<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 13:11
 */
?>

<?
if( count($params['user_filter_data']) ){
    // users filter
?>
    <form action="" method="post">
        <select name="id_user" onchange="this.form.submit()">
<?
    foreach( $params['user_filter_data'] as $v )
        print '<option value="'.$v['id_user'].'" '.( $v['id_user'] == $params['curent_user'] ? 'selected' : '' ).'>'.$v['login_user'].'</option>';
?>
        </select>
    </form>
<?
}
?>

<table border="1">
    <tr>
        <th rowspan="2">App. name</th>
        <th rowspan="2">URL</th>
        <th rowspan="2" colspan="2">Actions</th>
        <th colspan="<?=count($params['platforms'])?>">Platforms</th>
    </tr>
    <tr>
<?  if( !count($params['platforms']) ){?>
    <th>No platforms <a href="<?=classController::st_makeURI(array('controller' => 'platforms', 'action' => 'add'))?>">Add platform</a></th>
<?
}else foreach( $params['platforms'] as $v ){?>
        <th><?=$v['name_platform']?></th>
<?
    }
?>
    </tr>
<?
if( !count($params['apps_list']) ){
?>
    <tr>
        <td colspan="10">No data</td>
    </tr>
<?
}else foreach ($params['apps_list'] as $v) {
?>
    <tr>
        <td><?=$v['name_application']?></td>
        <td><?=$v['url_application']?></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'edit', 'id_application' => $v['id_application']))?>">Edit</a></td>
        <td><a onClick="javascript: if(confirm('Delete?')) return true; return false;" href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'delete', 'id_application' => $v['id_application']))?>">Delete</a></td>
<?
    foreach( $params['platforms'] as $va ){
?>
        <td><?=(in_array($va['id_platform'], $v['platforms'])? true : false )?></td>
<?
    }
?>
    </tr>
<?
    }
?>
</table>
