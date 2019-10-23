<?php


namespace Service;


class OrderService
{
    /**
     * 生成唯一订单号
     * @param string $prefix 前缀
     * @param string $ext 扩展因子ID，如订单ID、用户ID
     * @return string
     */
    function makeOrderSn($prefix = 'tb_', $ext = '', $length = 11)
    {
        $length = max(9, $length);
        $uid    = $ext ? date('is') . substr($ext, -3, 3) : intval(time() / rand(1, 9));
        $len    = mb_strlen($uid, 'utf-8');
        if ($len < $length) {
            $uid = str_repeat('0', $length - $len - 1) . rand(0, $length) . $uid;
        } else {
            $uid = date('h') . rand(0, $length) . $uid;
        }

        return strtoupper($prefix) . date('ymd') . $uid;
    }

}