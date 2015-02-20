<?php

class VideoController extends Controller
{
	/**
	 * @var This is the admin controller
	 */
	public $layout='//layouts/swf';

	public function actionIndex($id)
	{
		if($model = Story::model()->find('Story_ID=:a', array(':a'=>$id))){
			$this->render('index',array('model'=>$model));
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
	}

	public function actionView($id)
	{
		if($model = Story::model()->find('Story_ID=:a', array(':a'=>$id))){
			$this->render('index',array('model'=>$model));
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
}