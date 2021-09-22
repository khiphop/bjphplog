<?php
require "./vendor/autoload.php";
define('LOG_ROOT', __DIR__ . '/log/');

use BjphpLog\LogUtil;




function writeString()
{
    $string = 'name:kevin,age:21';

    LogUtil::info($string, 'default', 'LOGIN_ERROR');
}

function writeJson()
{
    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::info(json_encode($array, 320), 'default', 'LOGIN_ERROR');
}

function writeArray()
{
    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::info($array, 'default', 'LOGIN_ERROR');
}

function writeObject()
{
    $obj = new \stdClass();
    $obj->name = 'kevin';
    $obj->age = 21;

    LogUtil::info($obj, 'default', 'LOGIN_ERROR');
}

function debug()
{
    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::debug($array, 'default', 'LOGIN_ERROR');
}

function error()
{
    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::error($array, 'default', 'LOGIN_ERROR');
}

function alarm()
{
    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::alarm('854641898@qq.com', '登录错误', $array, 'default', 'LOGIN_ERROR');
}

//LogUtil::setLogUid('akldjf92r24');
writeString();
writeJson();
writeArray();
writeObject();
debug();
error();
alarm();


