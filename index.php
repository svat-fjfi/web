<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

define('WWW_DIR', __DIR__);

$container = require __DIR__ . '/application/app/bootstrap.php';

$container->getByType('Nette\Application\Application')->run();
