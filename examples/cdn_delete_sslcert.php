<?php

require_once __DIR__ . '/../autoload.php';

use \Qiniu\Cdn\CdnManager;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Qiniu\Auth($accessKey, $secretKey);
$cdnManager = new CdnManager($auth);

/*
 * 用户删除证书的接口
 DELETE /sslcert/<CertID>
 Authorization: QBox <QBoxToken>
 https://developer.qiniu.com/fusion/api/4248/certificate
 */
$certId = '5b2e4d5c54be51795e00042a';//'5b2e42d2340597388f0003de';
list($getData, $getErr) = $cdnManager->deleteSslcert(
    $certId
);

if ($getErr != null) {
    var_dump($getErr);
} else {
    echo "get data success\n";
    print_r($getData);
}
