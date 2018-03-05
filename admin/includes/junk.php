<?php
/**
 * Created by IntelliJ IDEA.
 * User: riskiii
 * Date: 10/2/16
 * Time: 2:56 PM
 */

$my_row[ 'the_id' ] = 5;
echo preg_replace("/\$[^_](\w+)\[[ ]'([^']+)'[ ]\]/U", "\$$1->$2", $my_row[ 'the_id' ]);