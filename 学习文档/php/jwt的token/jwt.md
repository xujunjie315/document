# jwt

## 1.下载jwt

```bash
composer require lcobucci/jwt
```

## 2.生成token

```bash
use Lcobucci\JWT\Builder;
$time = time();
$token = (new Builder())->issuedBy('http://example.com')
        ->permittedFor('http://example.org')
        ->identifiedBy('4f1g23a12aa', true)
        ->issuedAt($time)
        ->canOnlyBeUsedAfter($time + 60)
        ->expiresAt($time + 3600)
        ->withClaim('uid', 1)
        ->getToken();
echo $token;
```

## 3.从字符串解析内容

```bash
use Lcobucci\JWT\Parser;
$token = (new Parser())->parse((string) $token);
$token->getHeaders();
$token->getClaims();
echo $token->getClaim('jti');
echo $token->getClaim('iss');
echo $token->getClaim('uid'); 
```

## 4.验证

```bash
use Lcobucci\JWT\ValidationData;
$data = new ValidationData();
$data->setIssuer('http://example.com');
$data->setAudience('http://example.org');
$data->setId($id);
$data->setCurrentTime($time);
var_dump($token->validate($data));
```

## 5.签名

```bash
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
$signer = new Sha256();
$time = time();
$token = (new Builder())->issuedBy('http://example.com')
        ->permittedFor('http://example.org')
        ->identifiedBy('4f1g23a12aa', true)
        ->issuedAt($time)
        ->canOnlyBeUsedAfter($time + 60)
        ->expiresAt($time + 3600)
        ->withClaim('uid', 1)
        ->getToken($signer, new Key('testing'));
var_dump($token->verify($signer, 'testing'));
```

## 6.参考

* [文档](https://github.com/lcobucci/jwt/blob/3.3/README.md)