<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud
    | service that offers a solution to a web application's entire image
    | management pipeline.
    |
    */

    'cloud_url' => env('CLOUDINARY_URL'),

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Upload Route
    |--------------------------------------------------------------------------
    |
    | Here you may configure the route that will be used to upload files to
    | Cloudinary.
    |
    */

    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),

    /*
    |--------------------------------------------------------------------------
    | Upload Action
    |--------------------------------------------------------------------------
    |
    | Here you may configure the action that will be used to upload files to
    | Cloudinary.
    |
    */

    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),

];
