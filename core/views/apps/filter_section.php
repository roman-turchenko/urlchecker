<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 25.07.14
 * Time: 12:43
 */
?>
<?
if( count($params['user_filter']) ){
    // users filter
    ?>
    <form action="" method="post">
        <select name="id_user" onchange="this.form.submit()">
            <?
            foreach( $params['user_filter'] as $v )
                print '<option value="'.$v['id_user'].'" '.( $v['id_user'] == $params['curent_user'] ? 'selected' : '' ).'>'.$v['login_user'].'</option>';
            ?>
        </select>
    </form>
<?
}
?>