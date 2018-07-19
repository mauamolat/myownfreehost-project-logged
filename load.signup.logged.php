<?php

$inc_config = true;
require_once 'config.logged.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo '<b>>> POST <<</b>';
    var_dump($_POST);
}

$showPage = 'signup';
require ROOT.'/view.logged.php';

?>
