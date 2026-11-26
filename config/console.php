<?php

/** @var array $env */

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

return [
    'id' => 'catering-consola',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'timeZone' => 'America/Argentina/Buenos_Aires',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'cache' => ['class' => 'yii\caching\FileCache'],
        'log' => [
            'targets' => [
                ['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
