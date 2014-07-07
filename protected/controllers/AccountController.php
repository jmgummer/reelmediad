<?php

class AccountController  extends Controller
{
	/**
	 * @var This is the Archive controller
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
		// $model = $model = new StorySearch('search');
		// $model->unsetAttributes();
		// if(isset($_POST['StorySearch']))
		// {
		// 	$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
		// 	$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
		// 	$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		// }else{
		// 	$model->storytype = 1;
		// 	$model->startdate = $model->enddate = date('Y-m-d');
		// }
		$this->render('index');
	}
	
}
?>