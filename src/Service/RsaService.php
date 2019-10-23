<?php


namespace Service;


class RsaService
{
    /**
     * 加密
     */
    public static function encode($data = [])
    {
        $data       = json_encode($data);
        $public_key = file_get_contents(__DIR__ . '/rsa/pub.key');

        $encrypted = '';
        $pu_key    = openssl_pkey_get_public($public_key);
        openssl_public_encrypt($data, $encrypted, $pu_key);
        $encrypted = base64_encode($encrypted);// base64传输
        return $encrypted;
    }

    /**
     * 解密
     */
    public static function decode($encrypted)
    {

        $pi_key    = file_get_contents(__DIR__ . '/rsa/pri.key');
        $encrypted = base64_decode($encrypted);

        $decrypted = '';
        openssl_private_decrypt($encrypted, $decrypted, $pi_key);
        if (empty($decrypted)) {
            return false;
        }
        return json_decode($decrypted, true);
    }
}