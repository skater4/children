<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
return [
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'common*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'someRandomKey',

        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=skater4.mysql.tools;dbname=skater4_children',
            'username' => 'skater4_skater4',
            'password' => 'gavnovoz',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
        ],
    ],
];