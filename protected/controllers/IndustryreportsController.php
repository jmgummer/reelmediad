<?php

/**
* IndustryreportsController Controller Class
* This Class Is Used To Handle all Industry Reports actions
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

class IndustryreportsController extends Controller
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
				'actions'=>array('index','mentions','getdata','tests'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionMentions()
	{
		ini_set('memory_limit', '1024M');
		$model = new StorySearch('search');
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=$_POST['StorySearch'];
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			if(Yii::app()->user->usertype!='agency'){
				// $industry = Industry::model()->find('company_id=:a', array(':a'=>Yii::app()->user->company_id));
				$model->industry = IndustryCompany::model()->find('company_id=:a', array(':a'=>Yii::app()->user->company_id))->industry_id;
			}
			$model->startdate = $model->enddate = date('Y-m-d');
		}
		if(Yii::app()->user->usertype=='agency'){
			$this->render('agency_reports',array('model'=>$model));
		}else{
			$this->render('mentions', array('model'=>$model));
		}
		
	}

	public function actiontests()
	{
		ini_set('memory_limit', '1024M');
		$model = new StorySearch('search');
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=$_POST['StorySearch'];
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			if(Yii::app()->user->usertype!='agency'){
				// $industry = Industry::model()->find('company_id=:a', array(':a'=>Yii::app()->user->company_id));
				$model->industry = IndustryCompany::model()->find('company_id=:a', array(':a'=>Yii::app()->user->company_id))->industry_id;
			}
			$model->startdate = $model->enddate = date('Y-m-d');
		}
		if(Yii::app()->user->usertype=='agency'){
			$this->render('tests',array('model'=>$model));
		}else{
			$this->render('mentions', array('model'=>$model));
		}
		
	}

	public function actionGetdata()
	{
		/* For Industry Data */

		if(isset($_POST['company'])){
			$company = $_POST['company'];
			$sql = 'SELECT Industry_List, industry.Industry_ID, sup_ind_id, sect_id, sub_ind_id FROM industry,industry_company 
			where industry_company.company_id='.$company.' and industry_company.industry_id=industry.Industry_ID order by sub_ind_id, Industry_List';
			if($industries = Industry::model()->findAllBySql($sql)){
				foreach ($industries as $value) {
					$this_industry_id=$value["Industry_ID"];
					$this_industry_name=trim($value["ConcatName"]);

					echo '<option value="'.$this_industry_id.'">'.$this_industry_name.'</option>';
				}
			}else{
				echo '<option>No Results Found</option>';
			}
		}
	}

	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		elseif($model->user_id!=Yii::app()->user->s_uid)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
