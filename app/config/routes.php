<?php

return [
    '(?:\?.*)?' => [
        'controller' => 'main',
        'action' => 'index'
    ],
    'register' => [
        'controller' => 'auth',
        'action' => 'register'
    ],
    'login' => [
        'controller' => 'auth',
        'action' => 'login'
    ]
];
