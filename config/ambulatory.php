<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ambulatory database connection name
    |--------------------------------------------------------------------------
    |
    */

    'database_connection' => env('AMBULATORY_DB_CONNECTION', 'ambulatory'),

    /*
    |--------------------------------------------------------------------------
    | Ambulatory Uploads Disk
    |--------------------------------------------------------------------------
    |
    */

    'storage_disk' => env('AMBULATORY_STORAGE_DISK', 'local'),

    'storage_path' => env('AMBULATORY_STORAGE_PATH', 'public/ambulatory'),

    /*
    |--------------------------------------------------------------------------
    | Ambulatory Path
    |--------------------------------------------------------------------------
    |
    */
    'path' => env('AMBULATORY_PATH', 'ambulatory'),
];
