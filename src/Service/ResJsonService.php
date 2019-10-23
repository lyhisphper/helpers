<?php

namespace Service;

class ResJsonService
{
    public static function success($data = '', $cmd = '', $code = StatusEnum::Success)
    {
        $data = [
            "code" => $code,
            "cmd"  => $cmd,
            "data" => $data,
            //  "statusCode" => $statusCode
        ];
        return $data;
    }

    public static function error($cmd = '', $statusCode = StatusEnum::FailCode, $code = StatusEnum::Fail)
    {
        $data = [
            "code"       => $code,
            "cmd"        => $cmd,
            "statusCode" => $statusCode
        ];
        return $data;
    }

    public static function echoJson(...$data)
    {
        foreach ($data as $v) {
            echo "[" . date('H:i:s') . "]: " . (is_array($v) || is_object($v) ? json_encode($v) : $v) . PHP_EOL;
        }
    }
}