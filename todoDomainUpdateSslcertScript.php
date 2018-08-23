<?php

require_once './autoload.php';

use \Qiniu\Cdn\CdnManager;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Qiniu\Auth($accessKey, $secretKey);
$cdnManager = new CdnManager($auth);

$todoDomain = $argv[1];

// 2/ 上传到七牛证书管理[注意上传时的域名别名，最好用域名为开头，方便删除]

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
    return;
} else {
    echo "get data success\n";
    // print_r($getData);

}
$addsslcertRet = $getData;
print_r($addsslcertRet);


// $todoDomain = $argv[1];
$todoCertId = $addsslcertRet->certID;

// # # 3/ 更新域名证书

$domainName = $todoDomain;//'qinius.meiriyouke.cn';//$argv[2];
$certid = $todoCertId;// '5b2e523dc7d76231fb00041e';
$forceHttps = false;

list($getData, $getErr) = $cdnManager->ChangeDomainSslcert(
    $domainName,$certid,$forceHttps
);

if ($getErr != null) {
    var_dump($getErr);
    return;
} else {
    echo "get data success\n";
    // print_r($getData);
}

$ChangeDomainSslcertRet = $getData;
print_r($ChangeDomainSslcertRet);
