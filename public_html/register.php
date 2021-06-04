<?php
require_once '../common.php';
header("Content-Type: application/json; charset=utf-8");

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

$reqs = json_decode(file_get_contents('php://input'));
$endpoint = $reqs->endpoint ?? null;
$public_key = $reqs->keys->p256dh ?? null;
$auth_token = $reqs->keys->auth ?? null;

$is = false;
if ($endpoint && $public_key && $auth_token) {
    try {
        $db = new LevelDB(APP_DIR . LEVEL_DB, unserialize(LEVEL_DB_BASE_OPTIONS), unserialize(LEVEL_DB_READ_OPTIONS), unserialize(LEVEL_DB_WRITE_OPTIONS));
        $db->put($endpoint, serialize(compact('public_key', 'auth_token')));

        // no need if the user who execute sendpush.php is same as a web server's user.
        system('find ' . APP_DIR . LEVEL_DB . ' -type d -exec chmod 0770 {} \; && find ' . APP_DIR . LEVEL_DB . ' -type f -exec chmod 0660 {} \;');

        $is = true;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

echo json_encode($is);