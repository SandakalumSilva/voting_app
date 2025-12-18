<?php

return [
    'cloud_url'  => env('CLOUDINARY_URL'),

    // Optional separated credentials
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key'    => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),

    'secure' => true,
];
