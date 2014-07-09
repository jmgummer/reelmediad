<?php

class SwfController extends Controller
{
	/**
	 * @var This is the admin controller
	 */
	public $layout='//layouts/column1';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		
		$this->render('index');
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('index', array('model'=>$model));
	}

	public function loadModel($id)
	{
		$model = Story::model()->find('Story_ID=:a', array(':a'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			return $model;
	}

	
}
