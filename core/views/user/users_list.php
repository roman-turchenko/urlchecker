<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 14.07.14
 * Time: 14:16
 */
?>

<table class="content">
    <tr>
        <th>Login</th>
        <th>Email</th>
        <th colspan="2" class="actions">Action</th>
    </tr>

<?  foreach( $params['users_list'] as $k => $v ){?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['login_user']?></td>
        <td><?=$v['email_user']?></td>
        <td><?=$v['btn_edit']?></td>
        <td><?=$v['btn_delete']?></td>
    </tr>
<?  }?>
</table>