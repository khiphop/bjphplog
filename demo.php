<?php
require "vendor/autoload.php";

define('LOG_ROOT', __DIR__.'/log/');

$Test = new Bjphplog\Log();

$Test->write('keivn', 'default', 'LOGIN_ERROR');