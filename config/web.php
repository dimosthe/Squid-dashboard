<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' =>[
                'users'                             => 'user/admin/index',
                'user/create'                       => 'user/admin/create',
                'user/update/<id:\d+>'              => 'user/admin/update',
                'user/update-profile/<id:\d+>'      => 'user/admin/update-profile',
                'user/info/<id:\d+>'                => 'user/admin/info',
                'webaccessgroups'                   => 'delaygroup/index',
                'webaccessgroup/create'             => 'delaygroup/create',
                'webaccessgroup/<id:\d+>'           => 'delaygroup/view',
                'webaccessgroup/<action>/<id:\d+>'  => 'delaygroup/<action>',
                'filteringgroups'                   => 'filteringgroup/index',
                'filteringgroup/<id:\d+>'           => 'filteringgroup/view',
                'filteringgroup/<action>/<id:\d+>'  => 'filteringgroup/<action>',
                'blacklists'                        => 'blacklist/index',
                'blacklist/<id:\d+>'                => 'blacklist/view',
            ]
		],
		'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'purvj5k5dfRuBkj0xAkHQilVdW_1Xd0e',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true, // enable cookie-based login
        ],*/
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'enableRegistration' => false,
            'admins' => ['admin'],
            'modelMap' => [
                'User' => 'app\models\User',
                'LoginForm' => 'app\models\LoginForm'
            ],
            'controllerMap' => [
                'security' => 'app\controllers\SecurityController',
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*.*.*.*']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module', //adding gii module
        'allowedIPs' => ['192.168.56.1', '::1'] //allowing ip's
    ];
}

return $config;
