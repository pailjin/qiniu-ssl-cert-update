export QINIU_ACCESS_KEY=xxxx
export QINIU_SECRET_KEY=xxxx
export QINIU_TEST_BUCKET=phpsdk
export QINIU_TEST_DOMAIN=phpsdk.qiniudn.com



# test
# php examples/cdn_get_sslcert.php
# php examples/cdn_add_sslcert.php
# php examples/cdn_delete_sslcert.php
# php examples/cdn_change_domain_sslcert.php
# TODO
#获取传入参数,传递需要处理的域名
if [ $# == 2 ] then
todoDomain = $1

# 1/ let's encrypt renew证书
# service nginx stop ;echo 2|certbot certonly --standalone -d qinius.meiriyouke.cn;service nginx start
# [一般在服务器上生成一个，所以固定路径]
# /etc/letsencrypt/live/[domain]/fullchain.pem;
# /etc/letsencrypt/live/[domain]/privkey.pem;
service nginx stop ;echo 2|certbot certonly --standalone -d ${todoDomain};service nginx start
#如果是renew，则
#certbot renew --pre-hook "service nginx stop" --post-hook "service nginx start"

php todoDomainUpdateSslcertScript.php ${todoDomain}
# 2/ 上传到七牛证书管理[注意上传时的域名别名，最好用域名为开头，方便删除]
# php examples/cdn_add_sslcert.php ${todoDomain}
#
#
# # 3/ 更新域名证书
# php examples/cdn_change_domain_sslcert.php ${todoDomain}
#
# # 4/ 删除证书
# #获取证书列表
# php examples/cdn_get_sslcert.php
# #删除以自己域名开头的证书。【正在使用的证书，不会被删除。不用担心】
# php examples/cdn_delete_sslcert.php

fi
