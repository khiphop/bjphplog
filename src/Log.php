<?php

namespace Bjphp\Log;

class Log
{


    public static function write($info, $dir = 'default', $tag = '', $logRequest = false)
    {
        $basePath = LOG_ROOT . '/' . $dir . '/';
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        if (is_array($info)) $info = json_encode($info, 320);

        // 日志正文开始拼装
        $txt = $tag . ' | ' . $info;

        if ($logRequest) $txt .= ' | Request: ' . json_encode($_REQUEST, 320);

        $txt = 'UID:[' . self::getLogUid() . '] | ' . $txt;
        $txt = '[' . self::getMillisecondDate() . '] ' . $txt;
        $txt .= "\n";

        file_put_contents($basePath . date('Ymd') . '.log', $txt, FILE_APPEND);
    }

    /**
     * 获取毫秒时间
     * @return float
     * @author      kev.zhang
     * @date        2021/5/19
     */
    private static function getMillisecondDate()
    {
        date_default_timezone_set('PRC');
        $mtimestamp = sprintf("%.3f", microtime(true)); // 带毫秒的时间戳

        $timestamp = floor($mtimestamp); // 时间戳
        $milliseconds = round(($mtimestamp - $timestamp) * 1000); // 毫秒

        return date("H:i:s", $timestamp) . '.' . $milliseconds;
    }

    /**
     * 设置日志uid
     * @param
     * @return void
     * @author      kev.zhang
     * @date        2021/9/19
     */
    public static function setLogUid($uid)
    {
        $GLOBALS['LOG_UID'] = $uid;
    }

    /**
     * 获取 uid
     * @return string
     * @author      kev.zhang
     * @date        2021/9/19
     */
    private static function getLogUid()
    {
        if (!(isset($GLOBALS['LOG_UID']) && $GLOBALS['LOG_UID'])) {
            $GLOBALS['LOG_UID'] = uniqid();
        }

        return $GLOBALS['LOG_UID'];
    }
}