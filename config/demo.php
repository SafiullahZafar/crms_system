<?php

return [
    'super_admin_email' => env('SUPER_ADMIN_EMAIL', 'safullahzafar@gmail.com'),
    'super_admin_password' => env('SUPER_ADMIN_PASSWORD'),
    'super_admin_name' => env('SUPER_ADMIN_NAME', 'Safullah Zafar'),
    'session_timeout_minutes' => (int) env('DEMO_SESSION_TIMEOUT_MINUTES', 30),
];
