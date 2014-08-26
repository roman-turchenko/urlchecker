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
        <th class="app_name">App. name</th>

<?  if( !count($params['platforms']) ){?>
    <th>No platforms <?=$params['btn_add_platform']?></th>
<?
}else foreach( $params['platforms'] as $v ){?>
        <th class="name_platform"><?=$v['name_platform']?></th>
<?
}
?>
        <th colspan="2" class="actions">Actions</th>
    </tr>
<?
if( !count($params['apps_list']) ){
?>
    <tr>
        <td colspan="10" class="no-data">No data</td>
    </tr>
<?
}else foreach ($params['apps_list'] as $k => $v) {
?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['name_application']?></td>
<?
    foreach( $params['platforms'] as $va ){
?>
        <td><?=(in_array($va['id_platform'], $v['platforms'])
                ? '<div class="code check_code" data-params=\'{"id_application":"'.$v['id_application'].'","id_platform":"'.$va['id_platform'].'"}\' >'.
                    ($params['logs'][$v['id_application']][$va['id_platform']]
                        ?$params['logs'][$v['id_application']][$va['id_platform']]['HTTP_code']
                        :'check')
                  .'</div>
                  <div class="weight_diff">'.$params['logs'][$v['id_application']][$va['id_platform']]['weight_diff_kb'].'</div>'
                : '<div class="no_need_to_check">&mdash;</div>' )?>
        </td>
<?
    }
?>
        <td class="actions"><?=$v['btn_edit']?></td>
        <td class="actions"><?=$v['btn_delete']?></td>
    </tr>
<?
    }
?>
</table>
