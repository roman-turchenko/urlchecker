<?php
/**
 * Created by PhpStorm.
 * User: roman.turchenko
 * Date: 04.08.14
 * Time: 17:18
 */
?>
<a <?=$params['params']?> href="<?=$params['url']?>" <?=( $params['confirm_text'] ? "onClick=\"javascript: if(confirm('".$params['confirm_text']."')) return true; return false;\"":"" )?> class="delete_btn" title="Delete this" >B</a>