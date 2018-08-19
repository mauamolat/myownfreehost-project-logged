<?php

$include_core = true;
require 'core.logged.php';

$system = new Logged('signup');
$system->acceptResponse();
$system->render();

echo '$system->render();';

?>