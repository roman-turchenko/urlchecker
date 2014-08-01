<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 26.06.14
 * Time: 13:11
 */
?>
<table class="content">
    <tr>
        <th rowspan="2">App. name</th>
        <th rowspan="2" colspan="2">Actions</th>
        <th colspan="<?=count($params['platforms'])?>">Platforms</th>
    </tr>
    <tr>
<?  if( !count($params['platforms']) ){?>
    <th>No platforms <a href="<?=classController::st_makeURI(array('controller' => 'platforms', 'action' => 'add'))?>">Add platform</a></th>
<?
}else foreach( $params['platforms'] as $v ){?>
        <th class="name_platform"><?=$v['name_platform']?></th>
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
}else foreach ($params['apps_list'] as $k => $v) {
?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['name_application']?></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'edit', 'id_application' => $v['id_application'], 'id_user' => $v['id_user']))?>">Edit</a></td>
        <td><a onClick="javascript: if(confirm('Delete?')) return true; return false;" href="<?=classController::st_makeURI(array('controller' => 'apps', 'action' => 'delete', 'id_application' => $v['id_application']))?>">Delete</a></td>
<?
    foreach( $params['platforms'] as $va ){
?>
        <td><?=(in_array($va['id_platform'], $v['platforms'])
                ? '<div class="code check_code" data-params=\'{"id_application":"'.$v['id_application'].'","id_platform":"'.$va['id_platform'].'"}\' >'.
                    ($params['logs'][$v['id_application']][$va['id_platform']]?$params['logs'][$v['id_application']][$va['id_platform']]['HTTP_code']:'check now')
                  .'</div>'
                : '<div class="no_need_to_check">&mdash;</div>' )?>
        </td>
<?
    }
?>
    </tr>
<?
    }
?>
</table>
