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
        <th colspan="2">Action</th>
    </tr>

<?  foreach( $params['users_list'] as $k => $v ){?>
    <tr class="<?=( $k%2 == 0?'even':'uneven' )?>">
        <td><?=$v['login_user']?></td>
        <td><?=$v['email_user']?></td>
        <td><a href="<?=classController::st_makeURI(array('controller' => 'user', 'action' => 'edit', 'id_user' => $v['id_user']))?>">Edit</a></td>
        <td>
<?  if( $_SESSION['id_user'] != $v['id_user'] ){?>
            <a href="<?=classController::st_makeURI(array('controller' => 'user', 'action' => 'delete', 'id_user' => $v['id_user']))?>">Delete</a></td>
<?  }else{
?>
    Curent
<?
}?>
    </tr>
<?  }?>
</table>