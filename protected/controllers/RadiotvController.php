<?php

/**
* RadiotvController Controller Class
* This Class Is Used To Handle all Radio/TV archive actions
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

class RadiotvController extends Controller
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
				'actions'=>array('index','stories'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$model = $model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$model->storytype = 1;
			$model->startdate = $model->enddate = date('Y-m-d');
		}
		$this->render('index', array('model'=>$model));
	}

	public function actionStories()
	{
		if(isset($_POST['clientid']) && isset($_POST['search']) && isset($_POST['beginning']) && isset($_POST['ending']) && isset($_POST['media_house_id']) ){
			$clientid = $_POST['clientid'];
			$search = $_POST['search'];
			$beginning = date('Y-m-d',strtotime($_POST['beginning']));
			$ending =  date('Y-m-d',strtotime($_POST['ending']));;
			$media_house_id = $_POST['media_house_id'];
			if(isset($_POST['start'])){ 
				$start=$_POST['start']; 
			}else{ 
				$start=0; 
			}
			if(isset($_POST['stop'])){ 
				$number_of_posts=$_POST['stop']; 
			}else{ 
				$number_of_posts = 10; 
			}
			echo ElectronicArchive::UserStories($clientid,$search,$beginning,$ending,$media_house_id,$start,$number_of_posts);
		}
	}
	
}
