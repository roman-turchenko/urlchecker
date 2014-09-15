<script>
    $(document).ready(function(){
        $("div.more u").click(function(){
            $(this).next("div.modal").toggle();
        });

        $("tr.ac_platform").click(function(){

            console.log('Platform: '+$(this).find("td").html());
            $("tr[platform-key='item-"+$(this).attr('platform-key')+"']").toggle();
        });
    });
</script>
<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 29.07.14
 * Time: 15:50
 */
if( $params['app_log'] ){?>

<div id="app_log">
    <h2>Logs:</h2>
    <table class="content">
        <tr>
            <th class="date_check">Date check</th>
            <th class="HTTP_code">Code</th>
            <th class="HTTP_code">Size (Bytes)</th>
            <th class="more">Details</th>
        </tr>

<?
    foreach( $params['app_log'] as $k => $v ){
        if( is_array($v) ){
?>
        <tr class="ac_platform log_platform" platform-key="<?=$k?>"><td colspan="6"><?=$v['name_platform']?></td></tr>
       <!--
        <tr><td colspan="6">
            <table width="100%">-->
<?
    foreach( $v as $ke => $va ){
        if( is_numeric($ke) ){
?>
        <tr class="ac_logs log_item <?=( $ke%2 == 0?'even':'uneven' )?>" platform-key="item-<?=$k?>">
            <td class="date_check"><?=$va['date_check']?></td>
            <td class="HTTP_code"><?=$va['HTTP_code']?></td>
            <td class="size_download"><?=$va['size_download']?></td>
            <td class="more">
                <div class="more">
                    <u>Show More</u>
                    <div class="modal">
                        <p>User: <?=$va['email_user']?></p>
                        <p>Size download: <?=$va['size_download']?> bytes</p>
                        <p>Content-length: <?=$va['download_content_length']?></p>
                        <p>Request-header:<br /><?=$va['request_header']?></p>
                    </div>
                </div>
            </td>
        </tr>
<?
        }
    }
?>
            <!--</table>
        </td></tr>-->
<?
        }
    }
?>
    </table>
</div>
<?}?>