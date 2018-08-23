<?php

require_once __DIR__ . '/../autoload.php';

use \Qiniu\Cdn\CdnManager;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Qiniu\Auth($accessKey, $secretKey);
$cdnManager = new CdnManager($auth);

/*
修改证书
PUT /domain/<Name>/httpsconf
Authorization: QBox <QBoxToken>

{
    "certid": <CertID>,
    "forceHttps": <ForceHttps>,
}
https://developer.qiniu.com/fusion/api/4246/the-domain-name#11
*/

$todoDomain = $argv[1];
$todoCertId = $argv[2];

$domainName = $todoDomain;//'qinius.meiriyouke.cn';//$argv[2];
$certid = $todoCertId;// '5b2e523dc7d76231fb00041e';
$forceHttps = false;

list($getData, $getErr) = $cdnManager->ChangeDomainSslcert(
    $domainName,$certid,$forceHttps
);

if ($getErr != null) {
    var_dump($getErr);
} else {
    echo "get data success\n";
    print_r($getData);
}
