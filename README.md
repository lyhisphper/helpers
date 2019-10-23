# helpers
常用助手函数

## jwtToken
```text
<?php

namespace App\Common;

use Swoft\Http\Message\Request;

class TokenServe extends \Firebase\JWT\JWT
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


    //静态调用
    private static $jwtKey_s = 'aass123456';
    private static $iss_s = 'server';// 签发者
    private static $sub_s = 'user';// 面向用户
    private static $aud_s = 'client';// 接受方
    private static $exp_s = 0;// 过期时间
    private static $nbf_s = 0;// 定义什么时间之前，不可用
    private static $iat_s = 0;// 签发时间
    private static $jti_s = '';//唯一身份表示，主要用来作为一次性token
    private static $alg_s = ['HS256'];
    private static $expByDay_s = 1; // 过期时间

    public function __construct()
    {
        // 过期时间为一天
        $this->exp = time() + ($this->expByDay * 86400);
        $this->nbf = time();
        $this->iat = time();
        $this->jti = '';

    }

    public static function init()
    {
        // 过期时间为一天
        self::$exp_s = time() + (self::$expByDay_s * 86400);
        self::$nbf_s = time();
        self::$iat_s = time();
        self::$jti_s = '';
    }

    /**
     * 获取id
     * @param $token
     * @return mixed
     */
    public function getId($token = null)
    {
        if ($token == null) {
            $request = \Swoft\Context\Context::mustGet()->getRequest();
            if (empty($auth = $request->getHeader('Authorization'))) {
                return false;
            }

            $token = str_replace('Bearer ', '', $auth[0]);
        }

        try {
            $payload = parent::decode($token, $this->jwtKey, $this->alg);
        } catch (\Exception $exception) {
            return false;
        }
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

    /**
     * 获取id
     * @param $token
     * @return mixed
     */
    public static function getIdJWT($token = null)
    {
        self::init();
        if ($token == null) {
            $request = \Swoft\Context\Context::mustGet()->getRequest();
            if (empty($auth = $request->getHeader('Authorization'))) {
                return false;
            }

            $token = str_replace('Bearer ', '', $auth[0]);
        }

        try {
            $payload = parent::decode($token, self::$jwtKey_s, self::$alg_s);
        } catch (\Exception $exception) {
            return false;
        }
        if (is_object($payload)) {
            return $payload->uid;
        }
        return false;
    }

    public static function getToken()
    {
        self::init();
        $request = \Swoft\Context\Context::mustGet()->getRequest();
        if (empty($auth = $request->getHeader('Authorization'))) {
            return false;
        }

        $token = str_replace('Bearer ', '', $auth[0]);
        return $token;
    }

    /**
     * 加密
     * @param $id
     * @return string
     */
    public static function encodeKeyJWT($id)
    {
        self::init();
        $payload = [
            "sub" => self::$sub_s,
            'iss' => self::$iss_s,
            'aub' => self::$aud_s,
            'exp' => self::$exp_s,
            'nbf' => self::$nbf_s,
            "iat" => time(),
            "uid" => $id,
        ];
        return parent::encode($payload, self::$jwtKey_s);
    }
}

```