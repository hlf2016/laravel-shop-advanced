# LaravelShop
A shop based on Laravel

# 安装步骤
1. 首先 `clone` 项目到本地或其他任意位置，因为使用 `laradock` 所以需要递归 `clone` 即克隆时带上 `--recursive`。
> git clone --recursive git@github.com:hlf2016/laravel-shop-advanced.git laravel-shop
2. 进入本地的项目 **根目录** 中，通过 `composer` 安装 `PHP` 依赖。
```
// 更换为阿里镜像
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
// 下载依赖
composer install
```
3. 安装 `Node.js` 依赖
```
// 安装一下 Node.js 依赖，同样先配置镜像加速
yarn config set registry https://registry.npm.taobao.org
// 使用 yarn 命令安装 Nodejs 依赖
SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass yarn
// 编译前端代码
yarn dev
```
4. 配置 `.env` 文件
```
APP_NAME="Laravel Shop"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://shop.test

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shop-test
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_HOST=beanstalkd
QUEUE_CONNECTION=beanstalkd
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.163.com
MAIL_PORT=25
MAIL_USERNAME=xxx@163.com
MAIL_PASSWORD=xxx
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=xxx@163.com
MAIL_FROM_NAME=Pannio

```
5. 通过 `Laravel` 的命令自动生成 `APP_KEY` 值
> php artisan key:generate

6. 创建软链
> php artisan storage:link

7. 初始化数据库，在项目根目录执行：
> php artisan migrate
> mysql -h 0.0.0.0 -P 3306 -uroot -p shop-test < database/admin.sql

接下来会让你输入 **数据库密码** ，正确即可导入数据。

**参数含义**
* `-h` 和 `-P` 分别是是通过命令 `docker-compose ps` 查询出来的 `mysql` 在主机中映射的**IP**和**端口**信息。
* `shop-test` 是将被导入数据的数据库名称。

8. `Laravel-admin` 资源发布，否则后台前端样式会失效。
> php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
