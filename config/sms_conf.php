<?php

return [

    'base_url' => env('SMS_BASE_URL', 'https://api.mekongsms.com/api/'),

    'sender_id' => env('SMS_SENDER_ID', 'CPDMO HRMIS'),

    'username' => env('SMS_USERNAME', 'cpdmo_hrmis_sms@mekongnet'),

    'passmd5' => env('SMS_PASSMD5', '064f2754a5dcaa8bf080d8da016bf678'),

    'number_sending_per_day' => env('SMS_NUMBER_SENDING_PER_DAY', 3),

    'expired_duration' => env('SMS_EXPIRED_DURATION', 3), // In minutes

    'otp_types' => [
        'user_registration' => 'user_registration',
        'forgot_password' => 'forgot_password'
    ]
];
