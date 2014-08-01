<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 15:50
 */
if( $params['app_log'] ){?>
<script>
    $(function() {
        $( "#accordion" ).accordion();
    });
</script>
<div id="app_log">
    <h2>Logs:</h2>
    <div id="accordion">
<?
    foreach( $params['app_log'] as $k => $v ){
        if( is_array($v) ){
?>
        <h3><?=$v[0]['name_platform']?></h3>
        <div>
            <table class="content">
                <tr>
                    <th>Date check</th>
                    <th>User</th>
                    <th>Code</th>
                    <th>Size download</th>
                    <th>Content length</th>
                    <th>Headers</th>
                </tr>
<?
    foreach( $v as $ke => $va ){
?>
                <tr class="<?=( $ke%2 == 0?'even':'uneven' )?>">
                    <td><?=$va['date_check']?></td>
                    <td><?=$va['id_user']?></td>
                    <td><?=$va['HTTP_code']?></td>
                    <td><?=$va['size_download']?></td>
                    <td><?=$va['download_content_length']?></td>
                    <td><?=$va['request_header']?></td>
                </tr>
<?
    }
?>
            </table>
        </div>
<?
        }
    }
?>
    </div>
</div>
<?}?>