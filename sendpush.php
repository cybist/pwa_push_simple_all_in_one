<?php
require_once 'common.php';
require_once 'vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

if (trim($argv[1] ?? '') === '') {
    echo "need to input message";
    exit(1);
}
$message = $argv[1];

try {
    $db = new LevelDB(APP_DIR . LEVEL_DB, unserialize(LEVEL_DB_BASE_OPTIONS), unserialize(LEVEL_DB_READ_OPTIONS), unserialize(LEVEL_DB_WRITE_OPTIONS));
    $it = new LevelDBIterator($db);
    foreach($it as $endpoint => $pairs) {
        $pairs = unserialize($pairs);
        send_push($message, $endpoint, $pairs['public_key'] ?? null, $pairs['auth_token'] ?? null);
    }

} catch (Exception $e) {
    error_log($e->getMessage());
}

function send_push(String $message, String $endpoint, ?String $public_key, ?String $auth_token) {
    $subscription = Subscription::create([
        'endpoint' => $endpoint,
        'publicKey' => $public_key,
        'authToken' => $auth_token,
    ]);

    $auth = [
        'VAPID' => [
            'subject' => VAPID_SUBJECT,
            'publicKey' => PUBLIC_KEY,
            'privateKey' => PRIVATE_KEY,
        ]
    ];

    $webPush = new WebPush($auth);
    $report = $webPush->sendNotification(
        $subscription,
        $message,
        false,
        [],
        $auth
    );
    $webPush->flush();

    return true;
}