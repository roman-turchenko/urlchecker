<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 09.07.14
 * Time: 10:06
 */
include(VIEWS_DIR.'/common/header.php');
echo $params['top_menu'];
echo $params['filter_section'];
echo $params['content'];
include(VIEWS_DIR.'/common/footer.php');