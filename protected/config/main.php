<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Reelmedia',
	'aliases'=>array(
		'homeimages'=>'http://media.reelforge.com/reelmediad/images',
		'homeUrl' => 'http://media.reelforge.com/reelmediad',
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
		'application.extensions.phpexcel.*',
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
		'curl' => array(
			'class' => 'ext.curl.Curl',
			//'options' => array(/.. additional curl options ../)
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
			'connectionString' => 'mysql:host=197.248.27.6:3307;dbname=app_settings',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Pambazuka08',
			'charset' => 'utf8',
		),

		'db2'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=197.248.27.6:3307;dbname=reelmedia',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'Pambazuka08',
			'charset' => 'utf8',
		),

		'db3'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=197.248.27.6dbname=forgedb',
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

        'ePdf2' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
	            'mpdf'     => array(
	                'librarySourcePath' => 'application.vendors.mpdf.*',
	                'constants'         => array(
	                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
	                ),
	                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
	                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
	                    'mode'              => '', //  This parameter specifies the mode of the new document.
	                    'format'            => 'A3', // format A4, A5, ...
	                    'default_font_size' => 11, // Sets the default document font size in points (pt)
	                    'default_font'      => 'Arial', // Sets the default font-family for the new document.
	                    'mgl'               => 15, // margin_left. Sets the page margins for the new document.
	                    'mgr'               => 15, // margin_right
	                    'mgt'               => 16, // margin_top
	                    'mgb'               => 16, // margin_bottom
	                    'mgh'               => 9, // margin_header
	                    'mgf'               => 9, // margin_footer
	                    'orientation'       => 'L', // landscape or portrait orientation
	                ),
	            ),
	        ),
	    ),
		//PHPMailer Wrapper
		'mailer' => array(
	      'class' => 'application.extensions.mailer.EMailer',
	      'pathViews' => 'application.views.email',
	      'pathLayouts' => 'application.views.email.layouts'
	   ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'steve.oyugi@reelforge.com',
		'video_url'=>'http://www.reelforge.com/',
		'print_url'=>'http://www.reelforge.com/',

		'printplayer'=>'http://media.reelforge.com/player/index.php?',
		'electronicplayer'=>'http://media.reelforge.com/player/video.php?',
		'printarchiveplayer'=>'http://media.reelforge.com/player/archive.php?',
		'fileactions'=>'http://media.reelforge.com/player/',
		'pff_link'=>'http://media.reelforge.com/reelmedia/files/pdf/',

		'reelmedia_api' => 'http://197.248.156.26/api-reelmedia/public/api/external/',

		'redirect_url'=>'http://www.reelforge.com/reelforge/site/login.php',

		'country_code'=>'KE',
		'country_currency'=>'KSH',

	),
);
