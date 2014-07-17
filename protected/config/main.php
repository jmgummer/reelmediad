<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Reelmedia',
	'aliases'=>array(
		'homeimages'=>'http://localhost/reelmediad/images',
		'homeUrl' => 'http://localhost/reelmediad',
		),

	// preloading 'log' component
	'preload'=>array('log','input','bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.input.components.*',
		'application.modules.cal.*',
		'application.modules.cal.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'huhuhaha',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','192.168.0.234'),
			'generatorPaths'=>array('bootstrap.gii'),
		),
		'clientservice',
		
	),

	// application components
	'components'=>array(
		//twitter bootstrap extension
		'bootstrap'=>array(
        	'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
    	),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=192.168.0.60;dbname=app_settings',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Pambazuka08',
			'charset' => 'utf8',
		),

		'db2'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=192.168.0.5;dbname=reelmedia',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Pambazuka08',
			'charset' => 'utf8',
		),

		'db3'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=192.168.0.5;dbname=forgedb',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Pambazuka08',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
		//Input filter
        'input'=>array(
            'class'         => 'CmsInput',
            'cleanPost'     => false,
            'cleanGet'      => false,
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'steve.oyugi@reelforge.com',
	),
);