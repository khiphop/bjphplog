<?php

namespace BjphpLog;

class LogUtil
{

    const LOG_UID = 'BP_LOG_UID';
    const EMAIL_URL = 'http://yj.dfwgame.com/h5agency/phpTransfer/gameApi.php?service=ApiPublic.SendEmail.Send';

    /**
     * 发出告警并记录
     * @param $addresses
     * @param $msg
     * @param $data
     * @param string $dir
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2021/9/20
     */
    public static function alarm($addresses, $msg = '', $data = [], $dir = 'default', $tag = '')
    {
        if ($addresses) {
            $title = $tag . ':' . $msg;
            $url = self::EMAIL_URL . '&addresses=' . $addresses . '&title=' . $title . '&content=' . self::formatContent($data);
            Curl::doPost($url);
        }

        self::write($msg, $data, 'alarm', $dir, $tag);
    }

    /**
     * 调试日志
     * @param string $msg
     * @param $data
     * @param $request
     * @param string $dir
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2021/9/20
     */
    public static function debug($msg = '', $data = [], $request = [], $dir = 'default', $tag = '')
    {
        if (!$request) $request = $_REQUEST;

        $dataFormat = self::formatContent($data);

        $content = $dataFormat . ' | Request:' . json_encode($request);
        $content .= ' | Trace:' . json_encode(debug_backtrace());

        self::write($msg, $content, 'debug', $dir, $tag);
    }

    /**
     * 信息日志
     * @param string $msg
     * @param $data
     * @param string $dir
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2021/9/20
     */
    public static function info($msg = '', $data = [], $dir = 'default', $tag = '')
    {
        self::write($msg, $data, 'info', $dir, $tag);
    }

    /**
     * 错误日志
     * @param $msg
     * @param $data
     * @param string $dir
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2021/9/20
     */
    public static function error($msg, $data = [], $dir = 'default', $tag = '')
    {
        self::write($msg, $data, 'error', $dir, $tag);
    }

    /**
     * 核心写入
     * @param string $msg 字符串内容
     * @param $data
     * @param string $level
     * @param string $dir
     * @param string $tag
     * @return void
     * @author      kev.zhang
     * @date        2021/9/20
     */
    public static function write($msg = '', $data = [], $level = 'info', $dir = 'default', $tag = '')
    {
        if (!defined('LOG_ROOT')) {
            die('LOG_ROOT NOT DEFINED!');
        }

        $basePath = LOG_ROOT . '/' . $dir . '/';
        if (!is_dir($basePath)) {
            mkdir($basePath, 0777, true);
        }

        // 日志正文开始拼装 -----------------------------------------------------------------------------
        // 拼装时间
        $txt = '[' . self::getMillisecondDate() . '] ';

        // 拼装UID
        $txt .= 'UID:[' . self::getLogUid() . ']';

        // 拼装 Level
        $txt .= ' | _' . strtoupper($level) . '_';

        // 拼装标签
        if ($tag) $txt .= ' | ' . $tag;

        // 正文
        $dataFormat = self::formatContent($data);
        $txt .= ' | ' . $msg . ' ' . $dataFormat;
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
        if (!$content) {
            return '[]';
        }

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
        $GLOBALS[self::LOG_UID] = $uid;
    }

    /**
     * 获取 uid
     * @return string
     * @author      kev.zhang
     * @date        2021/9/19
     */
    private static function getLogUid()
    {
        if (!(isset($GLOBALS[self::LOG_UID]) && $GLOBALS[self::LOG_UID])) {
            $GLOBALS[self::LOG_UID] = uniqid();
        }

        return $GLOBALS[self::LOG_UID];
    }
}