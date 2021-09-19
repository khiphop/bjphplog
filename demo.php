<?php
require "vendor/autoload.php";

define('LOG_ROOT', __DIR__.'/log/');

$Test = new Bjphp\Log\Log();

$Test->write('keivn', 'default', 'LOGIN_ERROR');