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
        <th class="platform_name">Name</th>
        <th class="platform_descr">Description</th>
        <th colspan="2" class="actions">Actions</th>
    </tr>
<?
    if( count($params['platforms_list']) == 0 ){
?>
        <tr>
            <td colspan="3" class="no-data">No data</td>
        </tr>
<?
    }else foreach( $params['platforms_list'] as $k => $v ){
?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['name_platform']?></td>
        <td><?=$v['description_platform']?></td>
        <td class="actions"><?=$v['btn_edit']?></td>
        <td class="actions"><?=$v['btn_delete']?></td>
    </tr>
<?
    }
?>
</table>
