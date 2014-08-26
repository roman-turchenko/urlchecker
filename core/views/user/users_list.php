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
        <th class="user_login">Login</th>
        <th class="user_email">Email</th>
        <th colspan="2" class="actions">Action</th>
    </tr>

<?  foreach( $params['users_list'] as $k => $v ){?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['login_user']?></td>
        <td><?=$v['email_user']?></td>
        <td class="actions"><?=$v['btn_edit']?></td>
        <td class="actions"><?=$v['btn_delete']?></td>
    </tr>
<?  }?>
</table>