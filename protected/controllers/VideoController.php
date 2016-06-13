<?php

/**
* VideoController Controller Class
* This Class Is Used To Handle all Video actions
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Controllers
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version 	   v.1.0
* @since       July 2008
*/

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