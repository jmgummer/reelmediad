<?php

class DrilldownController extends Controller
{
	/**
	 * @var This is the admin controller
	 */
	public $layout='//layouts/swf';

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
				'actions'=>array('index','mentions','clientmentions','getdata'),
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

	public function actionMentions()
	{
		if(Yii::app()->user->usertype=='agency'){
			$this->render('agency_stories');
		}else{
			$this->render('index');
		}
	}

	public function actionClientmentions()
	{
		$this->render('client_mentions');
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

}
