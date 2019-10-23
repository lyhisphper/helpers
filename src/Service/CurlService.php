<?php


namespace Service;


class CurlService
{
    /**
     *
     * 接口请求
     * @author wesmiler
     * @param $url 接口地址
     * @param $data
     * @param $type
     * @param int $timeout
     * @return mixed
     */
    function httpRequest($url, $data = '', $type = 'post', $cookie = '', $timeout = 360)
    {
        try {
            set_time_limit($timeout);
            $data = $data && is_array($data) ? http_build_query($data) : $data;
            $url = strtolower($type) == 'get' ? $url . (strpos($url, '?') === false ? '?' : '&') . $data : $url;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //是否检测服务器的域名与证书上的是否一致

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            if (!empty($cookie)) {
                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查，0-规避ssl的证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ret = curl_exec($ch);
            // file_put_contents('request.log', $url."\n".$data."\n".$ret."\n\n",8);
            curl_close($ch);
            if (!preg_match("/^{/", $ret)) {
                return ['code' => 'err', 'msg' => $ret];
            }
            $ret = $ret ? json_decode($ret, true) : ['code' => 'err', 'msg' => 'unknow error'];
        }catch (\Exception $exception){
            $ret = ['code' => 'error', 'msg' => 'request error'];
        }

        return $ret;
    }

    /**
     *
     * 异步非阻塞接口请求
     * @author wesmiler
     * @param $url 接口地址
     * @param $data
     * @param $type
     * @param int $timeout
     * @return mixed
     */
    function httpAsyncRequest($url, $data = '', $type = 'post')
    {

        try {
            $data = $data && is_array($data) ? http_build_query($data) : $data;
            $url = strtolower($type) == 'get' ? $url . (strpos($url, '?') === false ? '?' : '&') . $data : $url;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //禁止 cURL 验证对等证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //是否检测服务器的域名与证书上的是否一致

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            if (!empty($cookie)) {
                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查，0-规避ssl的证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $ret = curl_exec($ch);
            // file_put_contents('request.log', $url."\n".$data."\n".$ret."\n\n",8);
            curl_close($ch);
            if (!preg_match("/^{/", $ret)) {
                return ['code' => 'err', 'msg' => $ret];
            }
            $ret = $ret ? json_decode($ret, true) : ['code' => 'err', 'msg' => 'unknow error'];
        }catch (\Exception $exception){
            $ret = ['code' => 'success', 'msg' => 'request success'];
        }

        return $ret;
    }
}