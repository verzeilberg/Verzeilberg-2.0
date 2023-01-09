<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'session_containers' => [
        Laminas\Session\Container::class,
    ],
    'session_storage' => [
        'type' => Laminas\Session\Storage\SessionArrayStorage::class,
    ],
    'session_config' => [
        'cache_expire' => 60 * 24 * 30,
        'cookie_httponly' => true,
        'cookie_lifetime' => 86400 * 30,
        'gc_maxlifetime' => 86400 * 30,
        'name' => 'mm3bb',
        'remember_me_seconds' => 86400 * 30,
        'use_cookies' => true,
    ],
    'session_manager' => [
        'config' => [
            'class' => Laminas\Session\Config\SessionConfig::class,
            'options' => [
                'name' => 'mm3bb',
            ],
        ],
        'storage' => Laminas\Session\Storage\SessionArrayStorage::class,
        'validators' => [
            Laminas\Session\Validator\RemoteAddr::class,
            Laminas\Session\Validator\HttpUserAgent::class,
        ],
    ],
    // Cache configuration.
    'caches' => [
        'FilesystemCache' => [
            'adapter' => \Laminas\Cache\Storage\Adapter\Filesystem::class,
            'options' => [
                // Store cached data in this directory.
                'cache_dir' => './data/cache',
                // Store cached data for 1 hour.
                'ttl' => 60 * 60 * 1
            ],
            'plugins' => [
                [
                    'name' => 'serializer',
                    'options' => []
                ]
            ]
        ]
    ]

];
