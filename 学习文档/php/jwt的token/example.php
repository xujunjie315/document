<?php

namespace app\index\controller;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class Token
{
    /**
     * 获取token
     */
    public function getToken()
    {
        $id = 'xujunjie';
        $key = '123456';
        $data = 'shuju';
        $signer = new Sha256();
        $time = time();
        $token = (new Builder())->issuedBy('http://example.com')
            ->permittedFor('http://example.org')
            ->identifiedBy($id, true)
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time + 60)
            ->expiresAt($time + 3600)
            ->withClaim('userInfo', $data)
            ->getToken($signer, new Key($key));
        return (string) $token;
    }
    /**
     * 验证token
     */
    public function verifyToken()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6Inh1anVuamllIn0.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUub3JnIiwianRpIjoieHVqdW5qaWUiLCJpYXQiOjE1NzE4MTM2ODMsIm5iZiI6MTU3MTgxMzc0MywiZXhwIjoxNTcxODE3MjgzLCJ1c2VySW5mbyI6InNodWp1In0.Rdn_ytB-yVp3COJ7wnspY3NgkbNpbA81yW3uaKIFAvw';
        $key = '123456';
        $id = 'xujunjie';
        //验证是否是jwt生成的字符串
        try{
            $token = (new Parser())->parse((string) $token);
            $token->getHeaders();
            $token->getClaims();
        }catch(\Exception $e){
            return $e->getCode() . '--' . $e->getMessage();
        }
        //验证签名
        $signer = new Sha256();
        if(!$token->verify($signer, $key)){
            return '验证失败！';
        }
        //验证是否过时
        $data = new ValidationData();
        $data->setIssuer('http://example.com');
        $data->setAudience('http://example.org');
        $data->setId($id);
        $data->setCurrentTime(time());
        if(!$token->validate($data)){
            return '过时了';
        }
        echo $token->getClaim('userInfo');
    }
}