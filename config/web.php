<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$wdlearningdb = require __DIR__ . '/wdlearningdb.php';
$reportingdb = require __DIR__ . '/reportingdb.php';

$config = [
    'id' => 'basic',
    'name'=>'PCare Bridging',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'components' => [
            'response' => [
                //'format' => yii\web\Response::FORMAT_JSON,
                'charset' => 'UTF-8',
                'formatters' => [
                    \yii\web\Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                        // ...
                    ],
                ],
            ],
        'request' => [
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jlAMOMv_Sl_rcw8SJGfgwlvvui8T6yyy',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'wdlearningdb' => $wdlearningdb,
        'reportingdb' => $reportingdb,
         
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest/pendaftaran',
                'extraPatterns' => [
                    'GET pendaftaran' => 'pendaftaran/regisdadsatration',
                ],
                    ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rest',
                    'extraPatterns' => [
                        'POST postfeedback' => 'postfeedback',
                    ],
                ],
            ],
        ],


        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
