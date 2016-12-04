<?php

return [
    'upload_path' => env('UPLOAD_PATH'),
    'asset_base_url' => env('ASSET_BASE_URL'),
    'asset_url' => env('ASSET_URL'),
    'asset_path' => env('ASSET_PATH', storage_path().'/'),
];
