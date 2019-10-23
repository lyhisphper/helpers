<?php

namespace Service;


class UrlService
{
    /**
     *
     * @param $url
     * @return string|string[]|null
     */
    public static function joinUrl($url, $domain = null)
    {
        if ($domain == null) {
            $domain = self::getRequestDomain();
        }
        return $domain . $url;
    }

    public static function reSetUrl($url)
    {
        return preg_replace('^((http://)|(https://))?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}(/)', '', $url);
    }

    public static function success($data = '', $code = CmdState::Success)
    {
        $data = [
            "code" => $code,
            "data" => $data,
            //   "statusCode" => $statusCode
        ];
        return $data;
    }

    public static function error($statusCode = CmdState::FailCode, $code = CmdState::Fail)
    {
        $data = [
            "code"       => $code,
            "statusCode" => $statusCode
        ];
        return $data;
    }

    public static function getRequestDomain()
    {
        $domain = $_SERVER['HTTP_HOST'];
        return $domain;
    }

    public static function getIp()
    {
        //php获取ip的算法
        if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) {
            $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
        } elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) {
            $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
        } elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) {
            $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "Unknown";
        }
        return $ip;

    }
}