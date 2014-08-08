<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 08.07.14
 * Time: 19:07
 */
?>

<ul class="top_menu main">
<?

foreach( $params['main_menu'] as $v )
        print '<li class="'.$v['current'].'"><a href="'.$v['url'].'">'.$v["title"].'</a></li>';
?>
</ul>

<ul class="top_menu sub">
    <?

    foreach( $params['sub_menu'] as $v )
        print '<li class="'.$v['current'].'"><a href="'.$v['url'].'">'.$v["title"].'</a></li>';
    ?>
</ul>
<div class="clear"></div>