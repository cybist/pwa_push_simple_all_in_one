# pwa_push_simple_all_in_one

PWA(Progressive Web Apps)におけるpush通知をフロントエンドとバックエンドの双方に実装した簡易的なスタンドアロンアプリケーションになります。
通知対象の購読者管理にはlevelDB(KVS)を利用しています。

## 確認済動作環境
* CentOS 7
* PHP 7.4.0
* levelDB 1.12
* web-push-php 4.0

## インストール
```bash
sudo yum --enablerepo=epel install leveldb-devel

cd /usr/local/src/
git clone https://github.com/reeze/php-leveldb.git

cd php-leveldb/
phpize
./configure --prefix=/home/{you}/.phpenv/versions/7.4.0/lib/php/leveldb --with-libdir=lib64 --with-leveldb=/usr/include/leveldb --with-php-config=/home/{you}/.phpenv/versions/7.4.0/bin/php-config
make
make install

vi ~/.phpenv/versions/7.4.0/etc/php.ini
    extension=/home/{you}/.phpenv/versions/7.4.0/lib/php/extensions/no-debug-non-zts-20190902/leveldb.so

~/.phpenv/versions/7.4.0/etc/init.d/php-fpm restart

mkdir -p ~/projects/
git clone https://github.com/cybist/pwa_push_simple_all_in_one.git pwa/
cd ~/projects/pwa/

composer require minishlink/web-push
vi composer.json
    "minishlink/web-push": "^4.0"

composer update

npm install web-push
./node_modules/.bin/web-push generate-vapid-keys --json > pairs.txt

vi public_html/vapidPublicKey
    {上記pair.txt内の"publicKey"の値}

touch public_html/img/icon-192.png
	{実際に利用するアイコン画像の配置を推奨}

touch public_html/img/icon-256.png
	{実際に利用するアイコン画像の配置を推奨}
```

## 動作フロー
1. public_html/index.html に相当するURLにアクセス
1. public_html/manifest.json でpwaに関するマニフェストの読み込み
1. public_html/service-worker.js でpush通知等の振る舞いに関する定義の読み込み
1. public_html/common.js でpush通知を要求
1. public_html/register.php で要求されたpush通知の購読者を登録
1. sendpush.php で任意タイミングでpush通知の実施

sendpush.php はターミナルから以下のように実施してください。
```bash
php ~/projects/pwa/sendpush.php {通知したいメッセージ}
```

これでpush通知を許可した全端末にlevelDBに登録されている購読者をフェッチしながら配信をおこないます。

https://camo.qiitausercontent.com/81310b4a690cfcf5268b84e85581471e90eaea92/68747470733a2f2f71696974612d696d6167652d73746f72652e73332e61702d6e6f727468656173742d312e616d617a6f6e6177732e636f6d2f302f3238323333322f61343333383039642d373164322d323966322d356231362d6236656632373937643133632e706e67

上記画像のような通知が届くのを確認できれば導入成功です。