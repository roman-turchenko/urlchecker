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
        <th>HTTP code</th>
        <th>Dif</th>
    </tr>
<?
foreach ($params['apps_list'] as $v) {
?>
    <tr>
        <td><?=$v['name']?></td>
        <td><img src="./img/12_cyrle_two_24.gif" alt="loading..."/></td>
        <td></td>
    </tr>
<?
    }
?>
</table>