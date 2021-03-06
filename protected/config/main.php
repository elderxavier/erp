<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'ERP',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
    ),

    'modules'=>array(
        'buy',
        'contractors',
        'main',
        'pdf',
        'products',
        'reports',
        'sell',
        'services',
        'stock',
        'users',

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),

    // application components
    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(

                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',

                //uncomment the following for multi-language
//                '<language:\w{2}>/<controller:\w+>'=>'<controller>/index',
//                '<language:\w{2}>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
//                '<language:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<language:\w{2}>/<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',

//                '<controller:\w+>'=>'<controller>/index',
//                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//                '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',

                '<module:\w+>/ajax'=>'<module>/ajax/index',
                '<module:\w+>/ajax/<id:\d+>'=>'<module>/ajax/view',
                '<module:\w+>/ajax/<action:\w+>/<id:\d+>'=>'<module>/ajax/<action>',
                '<module:\w+>/ajax/<action:\w+>/*'=>'<module>/ajax/<action>',

                '<module:\w+>'=>'<module>/main/index',
                '<module:\w+>/<id:\d+>'=>'<module>/main/view',
                '<module:\w+>/<action:\w+>/<id:\d+>'=>'<module>/main/<action>',
                '<module:\w+>/<action:\w+>/*'=>'<module>/main/<action>',

                '/' => 'main/main/index',
            ),
        ),

        'labels'=>array(
            'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/labels_lt.db',
            'class' => 'CDbConnection'
        ),

        // uncomment the following to use a MySQL database

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=alex_erp2',
            'emulatePrepare' => true,
            'username' => 'alex_erp2',
            'password' => 'bsv5rPLa',
            'charset' => 'utf8',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
//            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
    ),
);