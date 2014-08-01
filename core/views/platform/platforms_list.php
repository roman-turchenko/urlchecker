<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 17:49
 */
?>
<table class="content">
    <tr>
        <th>Name</th>
        <th colspan="2">Actions</th>
        <th>Description</th>
    </tr>
<?
    if( count($params['platforms_list']) == 0 ){
?>
        <tr>
            <td colspan="3">No data</td>
        </tr>
<?
    }else foreach( $params['platforms_list'] as $k => $v ){
?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['name_platform']?></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'platform', 'action' => 'edit', 'id_platform' => $v['id_platform']))?>">Edit</a></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'platform', 'action' => 'delete', 'id_platform' => $v['id_platform']))?>" onClick="javascript: if( confirm('Are you sure?')) return true; return false; ">Delete</a></td>
        <td><?=$v['description_platform']?></td>
    </tr>
<?
    }
?>
</table>
