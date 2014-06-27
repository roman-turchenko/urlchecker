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
        <th>HTTP code</th>
        <th>Show</th>
        <th>Dif</th>
    </tr>
<?
foreach ($params['apps_list'] as $v) {
?>
    <tr>
        <td><?=$v['name']?></td>
        <td><?=$v['url']?></td>
        <td><div class="http_code" data-url="<?=$v['url']?>">&nbsp;</div></td>
        <td></td>
        <td></td>
    </tr>
<?
    }
?>
</table>
