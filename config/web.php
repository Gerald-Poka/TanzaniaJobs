<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'website/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => []
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'yHY-OvSxAtovH9B5YTsd_EyoekgCoh4C',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['website/auth-signin'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/users/all' => 'admin/users/all',
                'admin/users/view/<id:\d+>' => 'admin/users/view',
                'admin/users/edit/<id:\d+>' => 'admin/users/edit',
                'admin/users/ban/<id:\d+>' => 'admin/users/ban',
                'admin/users/activate/<id:\d+>' => 'admin/users/activate',
                'admin/users/delete/<id:\d+>' => 'admin/users/delete',
                'auth-signin' => 'website/auth-signin',
                'auth-signup' => 'website/auth-signup',
                'admin/dashboard' => 'website/admin-dashboard',
                'user/dashboard' => 'website/user-dashboard',
                'logout' => 'website/logout',
                'pages-profile' => 'user/profile',
                'pages-profile-settings' => 'user/settings',
                'user/profile' => 'user/profile',
                'user/settings' => 'user/settings',
                
                // AI Features routes - NEW ADDITION
                'ai/career-recommendations' => 'ai/career-recommendations',
                'ai/job-matching' => 'ai/job-matching',
                'ai/skills-assessment' => 'ai/skills-assessment',
                'ai/get-recommendations/<id:\d+>' => 'ai/get-recommendations',
                'ai/update-preferences' => 'ai/update-preferences',
                
                // Categories routes
                'admin/categories' => 'admin/categories/list',
                'admin/categories/list' => 'admin/categories/list',
                'admin/categories/create' => 'admin/categories/create',
                'admin/categories/view/<id:\d+>' => 'admin/categories/view',
                'admin/categories/edit/<id:\d+>' => 'admin/categories/edit',
                'admin/categories/delete/<id:\d+>' => 'admin/categories/delete',
                'admin/categories/toggle-status/<id:\d+>' => 'admin/categories/toggle-status',
                'admin/categories/update-order' => 'admin/categories/update-order',
                
                // Skills routes
                'admin/skills' => 'admin/skills/list',
                'admin/skills/list' => 'admin/skills/list',
                'admin/skills/create' => 'admin/skills/create',
                'admin/skills/view/<id:\d+>' => 'admin/skills/view',
                'admin/skills/edit/<id:\d+>' => 'admin/skills/edit',
                'admin/skills/delete/<id:\d+>' => 'admin/skills/delete',
                
                // Jobs routes
                'admin/jobs' => 'admin/jobs/all',
                'admin/jobs/all' => 'admin/jobs/all',
                'admin/jobs/active' => 'admin/jobs/active',
                'admin/jobs/pending' => 'admin/jobs/pending',
                'admin/jobs/expired' => 'admin/jobs/expired',
                'admin/jobs/reported' => 'admin/jobs/reported',
                'admin/jobs/create' => 'admin/jobs/create',
                'admin/jobs/edit/<id:\d+>' => 'admin/jobs/edit',
                'admin/jobs/view/<id:\d+>' => 'admin/jobs/view',
                'admin/jobs/approve/<id:\d+>' => 'admin/jobs/approve',
                'admin/jobs/reject/<id:\d+>' => 'admin/jobs/reject',
                'admin/jobs/toggle-status/<id:\d+>' => 'admin/jobs/toggle-status',
                'admin/jobs/delete/<id:\d+>' => 'admin/jobs/delete',
                'admin/jobs/test' => 'admin/jobs/test',
                
                // Company routes
                'admin/companies' => 'admin/companies/all',
                'admin/companies/all' => 'admin/companies/all',
                'admin/companies/verified' => 'admin/companies/verified',
                'admin/companies/pending' => 'admin/companies/pending',
                'admin/companies/featured' => 'admin/companies/featured',
                'admin/companies/create' => 'admin/companies/create',
                'admin/companies/view/<id:\d+>' => 'admin/companies/view',
                'admin/companies/edit/<id:\d+>' => 'admin/companies/edit',
                'admin/companies/delete/<id:\d+>' => 'admin/companies/delete',
                'admin/companies/verify/<id:\d+>' => 'admin/companies/verify',
                'admin/companies/feature/<id:\d+>' => 'admin/companies/feature',
                'admin/companies/approve/<id:\d+>' => 'admin/companies/approve',
                'admin/companies/toggle-status/<id:\d+>' => 'admin/companies/toggle-status',
                'admin/companies/check-delete/<id:\d+>' => 'admin/companies/check-delete',

                // User job routes
                'jobs/browse' => 'jobs/browse',
                'jobs/categories' => 'jobs/categories', 
                'jobs/saved' => 'jobs/saved',
                'jobs/view/<id:\d+>' => 'jobs/view',
                'jobs/save/<id:\d+>' => 'jobs/save',
                'jobs/unsave/<id:\d+>' => 'jobs/unsave',
                'jobs/apply/<id:\d+>' => 'jobs/apply',
                'jobs/unsave-from-list/<id:\d+>' => 'jobs/unsave-from-list',

                // Application routes
                'application/form/<job_id:\d+>' => 'application/form',
                'application/submit/<job_id:\d+>' => 'application/submit',

                // Admin Applications routes - FIXED
                'admin/applications' => 'admin/applications/all',
                'admin/applications/all' => 'admin/applications/all',
                'admin/applications/pending' => 'admin/applications/pending',
                'admin/applications/approved' => 'admin/applications/approved',
                'admin/applications/rejected' => 'admin/applications/rejected',
                'admin/applications/shortlisted' => 'admin/applications/shortlisted',
                'admin/applications/view/<id:\d+>' => 'admin/applications/view',
                'admin/applications/update-status/<id:\d+>' => 'admin/applications/update-status',
                'admin/applications/analytics' => 'admin/applications/analytics',
                'admin/applications/trends' => 'admin/applications/trends',
                
                // General rule for Admin namespace controllers
                'admin/<controller:[\w-]+>/<action:[\w-]+>' => 'admin/<controller>/<action>',
                'admin/<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>' => 'admin/<controller>/<action>',
        
                // Add a catch-all rule at the end
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
