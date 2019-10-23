<?php


namespace Service;


class JwtTokenServer
{
    private $jwtKey = 'aass123456';
    private $iss = 'server';// 签发者
    private $sub = 'user';// 面向用户
    private $aud = 'client';// 接受方
    private $exp = 0;// 过期时间
    private $nbf = 0;// 定义什么时间之前，不可用
    private $iat = 0;// 签发时间
    private $jti = '';//唯一身份表示，主要用来作为一次性token
    private $alg = ['HS256'];
    private $expByDay = 1; // 过期时间

    public function __construct()
    {
        // 过期时间为一天
        $this->exp = time() + ($this->expByDay * 86400);
        $this->nbf = time();
        $this->iat = time();
        $this->jti = '';

    }

    public function getId($token = null)
    {
        $payload = parent::decode($token, $this->jwtKey, $this->alg);
        if (is_object($payload)) {
            return $payload->uid;
        }
        return false;
    }

    /**
     * 解密
     * @param $id
     * @return string
     */
    public function encodeKey($id)
    {
        $payload = [
            "sub" => $this->sub,
            'iss' => $this->iss,
            'aub' => $this->aud,
            'exp' => $this->exp,
            'nbf' => $this->nbf,
            "iat" => time(),
            "uid" => $id,
        ];
        return parent::encode($payload, $this->jwtKey);
    }

}