<?php

class DefaultController extends Controller
{
	/**
	* @var This is The Client Service Report Generator Controller
	*/
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
				'actions'=>array('index'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$model=new StorySearch;
		$this->render('index',array('model'=>$model));
	}
}