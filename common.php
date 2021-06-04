<?php
define('APP_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('LEVEL_DB', 'subscribers');
define('VAPID_SUBJECT', 'mailto:you@example.com'); // https://pwa.ketoha.com
define('PUBLIC_KEY', '{イントール方法において取得したpair.txt内の"publicKey"の値}');
define('PRIVATE_KEY', '{イントール方法において取得したpair.txt内の"privateKey"の値}');

define('LEVEL_DB_BASE_OPTIONS', serialize([
    'create_if_missing' => true,
    'error_if_exists' => false,
    'paranoid_checks' => false,
    'block_cache_size' => 8 * (2 << 20),
    'write_buffer_size' => 4<<20,
    'block_size' => 4096,
    'max_open_files' => 1000,
    'block_restart_interval' => 16,
    'compression' => 1,
    'comparator' => NULL,
]));
define('LEVEL_DB_READ_OPTIONS', serialize([
    'verify_check_sum' => false,
    'fill_cache' => true,
    'snapshot' => null
]));
define('LEVEL_DB_WRITE_OPTIONS', serialize([
    'sync' => false,
]));
