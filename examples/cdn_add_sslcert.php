<?php

require_once __DIR__ . '/../autoload.php';

use \Qiniu\Cdn\CdnManager;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Qiniu\Auth($accessKey, $secretKey);
$cdnManager = new CdnManager($auth);

/*
用户获取证书列表的接口
参数	类型	含义
Cert	object	结构请参考 证书
Authorization: QBox <QBoxToken>
{
    "name": <CertName>,
    "common_name":<CommonName>,
    "pri": <Pri>,
    "ca": <Ca>,
}
https://developer.qiniu.com/fusion/api/4248/certificate
https://developer.qiniu.com/fusion/api/4249/product-features#9
*/
$todoDomain = $argv[1];

$name = $todoDomain . '_ssl_cert_'.date("Y-m-d-h-i-s");//$argv[1];
$common_name = $todoDomain;//$argv[2];
// $ca_path = __DIR__ . '/../fullchain.pem';//$argv[3];//path///etc/letsencrypt/live/qinius.meiriyouke.cn/fullchain.pem
// $pri_path = __DIR__ . '/../privkey.pem';//$argv[4];//path///etc/letsencrypt/live/qinius.meiriyouke.cn/privkey.pem
$ca_path = '/etc/letsencrypt/live/' . $todoDomain . '/fullchain.pem';
$pri_path = '/etc/letsencrypt/live/' . $todoDomain . '/privkey.pem';

$myfile = fopen($pri_path, "r") or die("Unable to open file!");
$pri = fread($myfile,filesize($pri_path));
fclose($myfile);

$myfile = fopen($ca_path, "r") or die("Unable to open file!");
$ca = fread($myfile,filesize($ca_path));
fclose($myfile);

list($getData, $getErr) = $cdnManager->addSslcert(
    $name,$common_name,$pri,$ca
);

if ($getErr != null) {
    var_dump($getErr);
} else {
    echo "get data success\n";
    print_r($getData);
}
