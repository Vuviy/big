<?php

return [
    'rules' => [
        'phone' => [
            'pattern' => '/^\+7\d{10}$/',
            'format_message' => '+7XXXXXXXXXX',
        ],
        'mask' => [
            'pattern' => '/^\+7\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2}$/',
            'format_message' => '+7 (XXX) XXX XX XX',
        ],
        'phone_or_mask' => [
            'pattern' => '/^(\+7\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2})|(\+7\d{10})$/',
            'format_message' => '+7 (XXX) XXX XX XX :or +7XXXXXXXXXX',
        ],
    ],
    'mask' => '+7 (099) 999 99 99', // For js plugin initialization
    'mask_format' => '+7 (XXX) XXX XX XX', // "X" will be replaced with real digit
];
