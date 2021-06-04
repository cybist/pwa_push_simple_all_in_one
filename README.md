# pwa_push_simple_all_in_one

PWA(Progressive Web Apps)�ɂ�����push�ʒm���t�����g�G���h�ƃo�b�N�G���h�̑o���Ɏ��������ȈՓI�ȃX�^���h�A�����A�v���P�[�V�����ɂȂ�܂��B
�ʒm�Ώۂ̍w�ǎҊǗ��ɂ�levelDB(KVS)�𗘗p���Ă��܂��B

## �m�F�ϓ����
* CentOS 7
* PHP 7.4.0
* levelDB 1.12
* web-push-php 4.0

## �C���X�g�[��
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
    {��Lpair.txt����"publicKey"�̒l}

touch public_html/img/icon-192.png
	{���ۂɗ��p����A�C�R���摜�̔z�u�𐄏�}

touch public_html/img/icon-256.png
	{���ۂɗ��p����A�C�R���摜�̔z�u�𐄏�}
```

## ����t���[
1. public_html/index.html �ɑ�������URL�ɃA�N�Z�X
1. public_html/manifest.json ��pwa�Ɋւ���}�j�t�F�X�g�̓ǂݍ���
1. public_html/service-worker.js ��push�ʒm���̐U�镑���Ɋւ����`�̓ǂݍ���
1. public_html/common.js ��push�ʒm��v��
1. public_html/register.php �ŗv�����ꂽpush�ʒm�̍w�ǎ҂�o�^
1. sendpush.php �ŔC�Ӄ^�C�~���O��push�ʒm�̎��{

sendpush.php �̓^�[�~�i������ȉ��̂悤�Ɏ��{���Ă��������B
```bash
php ~/projects/pwa/sendpush.php {�ʒm���������b�Z�[�W}
```

�����push�ʒm���������S�[����levelDB�ɓo�^����Ă���w�ǎ҂��t�F�b�`���Ȃ���z�M�������Ȃ��܂��B

https://camo.qiitausercontent.com/81310b4a690cfcf5268b84e85581471e90eaea92/68747470733a2f2f71696974612d696d6167652d73746f72652e73332e61702d6e6f727468656173742d312e616d617a6f6e6177732e636f6d2f302f3238323333322f61343333383039642d373164322d323966322d356231362d6236656632373937643133632e706e67

��L�摜�̂悤�Ȓʒm���͂��̂��m�F�ł���Γ��������ł��B