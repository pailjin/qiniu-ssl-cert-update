# qiniu-ssl-cert-update

php script for update qiniu https ssl cert

# 说明

使用qiniu php sdk 和let's encrypt配合，完成七牛的ssl证书的更新。

随着https的普及，为了支持云存储的ssl cert更新和免费ssl证书的使用。

因为七牛支持使用自由证书，那么配合let's encrypt的免费证书，则可以免费更新七牛的https

但是let's encrypt的证书有效期为3个月，需要定期更新。

所以写了个脚本“半自动”的形式更新七牛证书。

# 支持特性：

生成证书并上传/更新七牛

# todo支持：

let's encrypt生成证书需要域名指向“当前正在操作的”服务器。可以使用dnspod等域名服务器的api去自动切换域名指向自有服务器和七牛云服务器。

这样才可以使用crontab定期执行，证书生成会失败

# 使用说明


## 关键两个文件

1/ qiniusslupdate.sh ： 执行脚本。包含了证书和调用todoDomainUpdateSslcertScript.php

2/ todoDomainUpdateSslcertScript.php：上传到七牛并更新

## 执行方法：

修改qiniusslupdate.sh的七牛AK和SK

./qiniusslupdate.sh {domain}

比如：./qiniusslupdate.sh abcssl.abc.com

执行前，先把域名指向操作服务器。

执行完成后，再把域名指向七牛

## 需要自行修改的地方：

1/上面两个关键文件中，证书的位置，是按照let's encrypt默认生成路径。如果用其他方式得到证书，则自己修改路径。

2/ 如果是crebot renew，则改下qiniusslupdate.sh文件中生成证书的命令，去掉crebot renew前的#符号

3/ 如果要定期执行，则自行加入crontab

# 环境：

php

php-curl

nginx

cerbot (let's encrypt)



