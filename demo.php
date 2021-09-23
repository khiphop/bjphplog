<?php

// 必要操作 -----------------------------------------------------------------------------

// 引入composer的自动引入
require "./vendor/autoload.php";

// 定义日志文件夹根目录
define('LOG_ROOT', __DIR__ . '/log/');

// 引用日志组件
use BjphpLog\LogUtil;

// End -----------------------------------------------------------------------------


// 操作Demo↓ -----------------------------------------------------------------------------

function writeString()
{
    $msg = '房间解散';
    $string = 'room_id:605412,p:800,game_id:91';

    LogUtil::info($msg, $string, 'default', 'ROOM_CANCEL');
}

function writeJson()
{
    $msg = '用户注册';

    $array = array(
        'name' => 'kevin',
        'age' => 21,
        'sex' => 1,
    );

    LogUtil::info($msg, json_encode($array, 320), 'user', 'LOGIN1000');
}

/*
 * info() 第二个参数传入为数组, 记录时会进行json编码 */
function writeArray()
{
    $msg = '用户登出';
    $array = array(
        'name' => 'kevin',
        'ip' => '127.0.0.1',
        'port' => '8445',
    );

    LogUtil::info($msg, $array, 'user', 'LOGIN1002');
}

/*
 * info() 第二个参数传入为对象, 记录时会进行json编码 */
function writeObject()
{
    $msg = '实名认证';

    $obj = new \stdClass();
    $obj->name = 'kevin';
    $obj->age = 21;

    LogUtil::info($msg, $obj, 'user', 'REAL_NAME');
}

/*
 * 相对于info(), debug()会记录请求参数和代码追踪过程 */
function debug()
{
    $_REQUEST = array_merge(
        $_REQUEST,
        array(
            'user_id' => 10963033,
            'p' => 800,
        )
    );
    $msg = '用户信息';

    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    $request = array(
        'platform' => (isset($_REQUEST['p']) && $_REQUEST['p']) ? $_REQUEST['p'] : 0,
    );

    LogUtil::debug($msg, [], $request, 'default', 'LOGIN_ERROR');

    // 第三个参数为空时会以 $_REQUEST 代替
    LogUtil::debug($msg, $array, [], 'default', 'LOGIN_ERROR');
}

function error()
{
    $msg = '用户缓存无性别';

    $array = array(
        'name' => 'kevin',
        'age' => 21,
    );

    LogUtil::error($msg, $array, 'user', 'USER_CACHE_ERR');
}

function alarm()
{
    $msg = '结算无房间缓存';

    $data = array(
        'room_id' => 570610,
        'p' => 800,
        'game_id' => 91,
    );

    /*
     * 邮件组成
     * 收件人: $addresses
     * 标题: $tag + $msg
     * 内容: $data */
    LogUtil::alarm('854641898@qq.com', $msg, $data, 'alarm', 'ROOM_CACHE_ERR');
}

/*
 * 记录日志时, 如果没有设置过日志唯一码, 会自动生成
 * 可以主动设置日志唯一码 */
//LogUtil::setLogUid('akldjf92r24');
writeString();
writeJson();
writeArray();
writeObject();
debug();
error();
alarm();


