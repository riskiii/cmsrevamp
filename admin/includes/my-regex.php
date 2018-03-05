<?php
/**
 * Created by IntelliJ IDEA.
 * User: dsmith
 * Date: 9/30/16
 * Time: 2:59 PM
 */

var $string = array();
const user_id;

$string = <<<EOD
$my_user[ 'user_id' ];
EOD;

$pattern = '/\$[^_]?(\w+)\[[ ]"([^"]+)"[ ]\]/gU';
$replacement = '$1->$3';
echo preg_replace("/\$?[^_](\w+)\[[ ]'([^']+)'[ ]\]/gU", "\$$1->$2", $string);
//echo preg_replace($pattern, $replacement, $string);
