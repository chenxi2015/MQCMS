# MQCMS
MQCMS是一款现代化，快速，高效，灵活，前后端分离，扩展性强的CMS系统。
MQCMS中的MQ取麻雀拼音首字母。寓意麻雀虽小五脏俱全。

### 本地开发
在docker环境下开发，window安装docker desktop for window

下载hyperf框架docker镜像
```shell script
docker pull hyperf/hyperf
```

进入docker运行命令：
```shell script
# 将项目放在本地d:/web/mqcms
docker run -it -v /d/web/mqcms:/mqcms -p 9501:9501 --entrypoint /bin/sh hyperf/hyperf
```

下载mqcms系统
```shell script
git clone https://github.com/chenxi2015/MQCMS mqcms
```

将 Composer 镜像设置为阿里云镜像，加速国内下载速度
```shell script
php mqcms/bin/composer.phar config -g repo.packagist composer https://mirrors.aliyun.com/composer

```
进入项目启动项目
```shell script
cd mqcms
php bin/hyperf.php start
```
