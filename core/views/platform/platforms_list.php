<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 17:49
 */
?>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
<?
    if( count($params['platforms_list']) == 0 ){
?>
        <tr>
            <td colspan="2">No data</td>
        </tr>
<?
    }else foreach( $params['platforms_list'] as $v ){
?>
    <tr>
        <td><?=$v['name_platform']?></td>
        <td><?=$v['description']?></td>
    </tr>
<?
    }
?>
</table>
