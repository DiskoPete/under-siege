<?php
/**
 * Siege specific configuration
 */
return [
    'max_duration' => env('SIEGE_MAX_DURATION', 60),
    'max_concurrent_users' => env('SIEGE_MAX_CONCURRENT_USERS', 100),
    'user_agent' => env('SIEGE_USER_AGENT', 'UnderSiege/1.0'),
];
