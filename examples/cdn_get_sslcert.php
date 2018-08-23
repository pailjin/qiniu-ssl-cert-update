<?php

require_once __DIR__ . '/../autoload.php';

use \Qiniu\Cdn\CdnManager;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Qiniu\Auth($accessKey, $secretKey);
$cdnManager = new CdnManager($auth);

//用户获取证书列表的接口
//参考文档：https://developer.qiniu.com/fusion/api/4248/certificate

//获取带宽数据
list($getData, $getErr) = $cdnManager->listSslcert(
    null,
    null
);

if ($getErr != null) {
    var_dump($getErr);
} else {
    echo "get data success\n";
    print_r($getData);
}
