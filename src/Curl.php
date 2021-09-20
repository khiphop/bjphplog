<?php

namespace BjphpLog;

class Curl
{

    /**
     * 超时以ms为单位
     * @param $url
     * @param $data
     * @param int $timeout      毫秒
     * @return bool|string
     * @author      kev.zhang
     * @date        2021/7/7
     */
    public static function doPost($url, $data = [], $timeout = 5000)
    {
        if (is_array($data)) {
            $data = json_encode($data);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $return = curl_exec($ch);
        curl_close($ch);

        return $return;
    }

}