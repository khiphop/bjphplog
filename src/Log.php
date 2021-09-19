<?php

namespace BjphpLog;

class LogUtil
{


    public static function write($content, $dir = 'default', $tag = '')
    {
        if (!defined('LOG_ROOT')) {
            die('LOG_ROOT NOT DEFINED!');
        }

        $basePath = LOG_ROOT . '/' . $dir . '/';
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        $content = self::formatContent($content);

        // 日志正文开始拼装
        $txt = $tag . ' | ' . $content;

        $txt = 'UID:[' . self::getLogUid() . '] | ' . $txt;
        $txt = '[' . self::getMillisecondDate() . '] ' . $txt;
        $txt .= "\n";

        file_put_contents($basePath . date('Ymd') . '.log', $txt, FILE_APPEND);
    }

    /**
     * 格式化日志内容
     * @param
     * @return string
     * @author      kev.zhang
     * @date        2021/9/19
     */
    private static function formatContent($content)
    {
        if (is_object($content)) {
            $content = json_encode($content, 320);
        }

        if (is_array($content)) {
            $content = json_encode($content, 320);
        }

        return (string)$content;
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
        $GLOBALS['BP_LOG_UID'] = $uid;
    }

    /**
     * 获取 uid
     * @return string
     * @author      kev.zhang
     * @date        2021/9/19
     */
    private static function getLogUid()
    {
        if (!(isset($GLOBALS['BP_LOG_UID']) && $GLOBALS['BP_LOG_UID'])) {
            $GLOBALS['BP_LOG_UID'] = uniqid();
        }

        return $GLOBALS['BP_LOG_UID'];
    }
}