<?php

declare(strict_types=1);
/**
 * This file is part of CcEdu.
 *
 * @link     https://ccedu.cqq.me
 * @document https://github.com/qiachen/ccedu
 * @contact  i@cqq.me
 * @license  https://github.com/qiachen/ccedu/blob/master/LICENSE
 */
return [
    'default' => [
        'host' => env('REDIS_HOST', 'localhost'),
        'auth' => env('REDIS_AUTH', null),
        'port' => (int) env('REDIS_PORT', 6379),
        'db' => (int) env('REDIS_DB', 0),
        'pool' => [
            'min_connections' => 1,
            'max_connections' => 10,
            'connect_timeout' => 10.0,
            'wait_timeout' => 3.0,
            'heartbeat' => -1,
            'max_idle_time' => (float) env('REDIS_MAX_IDLE_TIME', 60),
        ],
    ],
];
