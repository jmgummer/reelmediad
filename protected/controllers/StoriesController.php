<?php

/**
* HomeController Controller Class
* This Class Is Used To Handle all Home actions
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
ini_set('memory_limit', '256M');
class StoriesController extends Controller
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
				'actions'=>array('index','editclassification','classified','edittonality','online','edittechnicalarea'),
				'users'=>array('admin'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('editcountry','getdata','advancedsearch','booleansearch'),
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
		$model=new StorySearch;
		$this->render('index',array('model'=>$model));
	}

	public function actionClassified()
	{
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$clientid = Yii::app()->user->company_id;
			$classificationsql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
			$cats = CompanyStoryClassification::model()->findAllBySql($classificationsql);
			$catsarray = array();
			if($cats){
				foreach ($cats as $key) {
					$catsarray[] = $key->classification_id;
				}
			}
			$model->storytype = 1;
			$model->industry = $catsarray;
		}
		$this->render('stories',array('model'=>$model));
	}

	public function actionOnline()
	{
		$catsarray = array();
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{

			$clientid = Yii::app()->user->company_id;
			$c_sql = "SELECT * FROM companies WHERE reelmedia_id=$clientid";
			$onlinecompany = OnlineCompanies::model()->findBySql($c_sql);
			if($onlinecompany){
				$onlinecid = $onlinecompany->id;
				$sql = "SELECT * FROM themes WHERE company_id = $onlinecid ORDER BY theme_name";
				$cats = Themes::model()->findAllBySql($sql);
				if($cats){
					foreach ($cats as $key) {
						$catsarray[] = $key->id;
					}
				}
			}
			$model->storytype = 'NewsBlogs';
			$model->industry = $catsarray;
		}
		$this->render('online',array('model'=>$model));
	}

	public function actionAdvancedsearch(){
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$clientid = Yii::app()->user->company_id;
			$classificationsql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
			$cats = CompanyStoryClassification::model()->findAllBySql($classificationsql);
			$catsarray = array();
			if($cats){
				foreach ($cats as $key) {
					$catsarray[] = $key->classification_id;
				}
			}
			$model->storytype = 1;
			$model->industry = $catsarray;
		}
		$this->render('advanced',array('model'=>$model));
	}

	public function actionBooleansearch(){
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$clientid = Yii::app()->user->company_id;
			$classificationsql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
			$cats = CompanyStoryClassification::model()->findAllBySql($classificationsql);
			$catsarray = array();
			if($cats){
				foreach ($cats as $key) {
					$catsarray[] = $key->classification_id;
				}
			}
			$model->storytype = 1;
			$model->industry = $catsarray;
		}
		$this->render('boolean',array('model'=>$model));
	}

	public function actionEditclassification(){
		$client = $_POST['clientid'];
		if(isset($_POST['clsmodal']) && isset($_POST['storyid']) && isset($client)){
			if($model=Story::model()->findByPk($_POST['storyid'])){
				$storyid = $model->Story_ID;
				$sql = "SELECT story_classification.auto_id, company_story_classification.classification_name, story_classification.classification_id  FROM story_classification INNER JOIN company_story_classification ON company_story_classification.classification_id=story_classification.classification_id WHERE story_classification.story_id =$storyid AND company_story_classification.company_id = $client";
				$storyclassification = Yii::app()->db2->createCommand($sql)->queryRow();
				$editid = $storyclassification['auto_id'];
				echo "<p><strong>".$model->Title."</strong></p>";
				echo "<p>".$model->Story."</p>";
				echo "<p>Current Classification - <strong>".$storyclassification['classification_name']."</strong></p>";
				$searchmodel = new StorySearch('search');
				$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form')));
				echo $form->dropDownList($searchmodel, 'industry', CompanyStoryClassification::model()->getCompanyClassificationList($client), array('class'=>'form-control','id'=>'clsclassific'));
				echo "<input type='hidden' name='editid' id='editid' value='$editid'>";
				$this->endWidget();
			}
		}elseif (isset($_POST['clsedmodal']) && isset($_POST['clsclassific']) && isset($_POST['editid']) && isset($_POST['storyid']) && isset($client)) {
			$auto_id = $_POST['editid'];
			$classification_id = $_POST['clsclassific'];
			$updatesql = "UPDATE story_classification SET classification_id=$classification_id WHERE auto_id=$auto_id";
			$updateqry = Yii::app()->db2->createCommand($updatesql)->execute();
			if($updateqry){
				echo "<p><strong>Updated Successfully.</strong> You will need to refresh to view changes</p>";
			}else{
				echo "Could not update, change your options and please try Again";
			}
		}
		else{
			echo "Error, Please Log In or Review your Query to Proceed!";
		}
	}

	public function actionEdittechnicalarea(){
		if(isset($_POST['techmodal']) && isset($_POST['storyid']) && isset(Yii::app()->user->company_id)){
			$client = Yii::app()->user->company_id;
			if($model=Story::model()->findByPk($_POST['storyid'])){
				$storyid = $model->Story_ID;
				$searchmodel = new StorySearch('search');
				// Added Technical Area
				$checksql = "SELECT story_technicalarea.auto_id, company_technical_areas.technical_area_name, county, country FROM story_technicalarea INNER JOIN company_technical_areas ON company_technical_areas.id=story_technicalarea.tech_id WHERE story_technicalarea.story_id=$storyid AND company_technical_areas.company_id = $client";
				$checkquery = Yii::app()->db2->createCommand($checksql)->queryRow();
				if($checkquery){
					$t_name = $checkquery['technical_area_name'];
					$t_country = $checkquery['country'];
					$t_county = $checkquery['county'];

					$searchmodel->country = $t_country;
					$searchmodel->county = $t_county;
				}else{
					$t_name = "-";
					$t_country = "-";
					$t_county = "-";
				}

				// Classification
				$sql = "SELECT story_classification.auto_id, company_story_classification.classification_name, story_classification.classification_id  FROM story_classification INNER JOIN company_story_classification ON company_story_classification.classification_id=story_classification.classification_id WHERE story_classification.story_id =$storyid AND company_story_classification.company_id = $client";
				$storyclassification = Yii::app()->db2->createCommand($sql)->queryRow();
				$editid = $storyclassification['auto_id'];
				echo "<p><strong>".$model->Title."</strong></p>";
				echo "<p>".$model->Story."</p>";
				echo "<p><strong>Current Classification - ".$storyclassification['classification_name']."</strong><br>Current Technical Area - $t_name<br>Country - $t_country<br>County - $t_county<br><br>Add/Edit Technical Area</p>";
				
				$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form')));
				echo $form->dropDownList($searchmodel, 'industry', CompanyTechnicalAreas::model()->getTechnicalAreaList(), array('class'=>'form-control','id'=>'tarea_id'));
				echo "<p style='color: #333;margin: 0 0 9px;'><br>Add/Edit Country<br></p>";
				echo $form->dropDownList($searchmodel, 'country', Country::model()->CountryListNames(), array('empty'=>'-- Select An Country --','class'=>'form-control','id'=>'t_country'));
				echo "<p style='color: #333;margin: 0 0 9px;'><br>Add/Edit County<br></p>";
				echo $form->dropDownList($searchmodel, 'county', Counties::model()->CountiesListNames(), array('empty'=>'-- Select An County --','class'=>'form-control','id'=>'t_county'));
				echo "<input type='hidden' name='techstoryid' id='techstoryid' value='$storyid'>";
				$this->endWidget();
			}
		}elseif (isset($_POST['tedmodal']) && isset($_POST['tarea_id']) && isset($_POST['techstoryid']) && isset(Yii::app()->user->company_id)) {
			$ccid = Yii::app()->user->company_id;
			$storyid = $_POST['techstoryid'];
			$tech_area_id = $_POST['tarea_id'];

			$country = $_POST['t_country'];
			$county = $_POST['t_county'];

			$checksql = "SELECT story_technicalarea.auto_id FROM story_technicalarea INNER JOIN company_technical_areas ON company_technical_areas.id=story_technicalarea.tech_id WHERE story_technicalarea.story_id=$storyid AND company_technical_areas.company_id = $ccid";
			$checkquery = Yii::app()->db2->createCommand($checksql)->queryRow();
			if($checkquery){
				$c_auto_id = $checkquery['auto_id'];
				$execsql = "UPDATE story_technicalarea SET tech_id=$tech_area_id,country='$country',county='$county' WHERE auto_id=$c_auto_id AND story_id=$storyid";
			}else{
				$execsql = "INSERT INTO story_technicalarea(tech_id,story_id,country,county) VALUES($tech_area_id,$storyid,'$country','$county')";
			}
			$actionqry = Yii::app()->db2->createCommand($execsql)->execute();
			if($actionqry){
				echo "<p><strong>Updated Successfully.</strong> You will need to refresh to view changes</p>";
			}else{
				echo "Could not update, change your options and please try Again";
			}
		}
		else{
			echo "Error, Please Log In or Review your Query to Proceed!";
		}
	}

	public function actionEdittonality(){
		$client = $_POST['clientid'];
		if(isset($_POST['tnltymodal']) && isset($_POST['storyid']) && isset($client)){
			if(Yii::app()->user->usertype=='agency'){
				if($model=Story::model()->findByPk($_POST['storyid'])){
					$storyid = $model->Story_ID;
					$sql = "SELECT mediamap_analysis.analysis_id, mediamap_analysis.tonality, mediamap_analysis.story_id, mediamap_analysis.client_tonality FROM mediamap_analysis WHERE mediamap_analysis.story_id =$storyid AND mediamap_analysis.company_id = $client";
					$storytonality = Yii::app()->db2->createCommand($sql)->queryRow();
					$editid = $storytonality['analysis_id'];
					echo "<p><strong>".$model->Title."</strong></p>";
					echo "<p>".$model->Story."</p>";
					echo "<p>Current Tonality - <strong>".$storytonality['tonality']." </strong></p>";
					$searchmodel = new StorySearch('search');
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form')));
					echo $form->dropDownList($searchmodel, 'industry', array('neutral'=>'Neutral','positive'=>'Positive','negative'=>'Negative'), array('class'=>'form-control','id'=>'tnlyclassific'));
					echo "<input type='hidden' name='editid' id='editid' value='$editid'>";
					$this->endWidget();
				}
			}else{
				if($model=Story::model()->findByPk($_POST['storyid'])){
					$storyid = $model->Story_ID;
					$sql = "SELECT mediamap_analysis.analysis_id, mediamap_analysis.tonality, mediamap_analysis.story_id, mediamap_analysis.client_tonality FROM mediamap_analysis WHERE mediamap_analysis.story_id =$storyid AND mediamap_analysis.company_id = $client";
					$storytonality = Yii::app()->db2->createCommand($sql)->queryRow();
					$editid = $storytonality['analysis_id'];
					echo "<p><strong>".$model->Title."</strong></p>";
					echo "<p>".$model->Story."</p>";
					echo "<p>Current Tonality - <strong>".$storytonality['tonality']." </strong> : Client Update - <strong>".$storytonality['client_tonality']."</strong></p>";
					$searchmodel = new StorySearch('search');
					$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array('id'=>'login-form','type'=>'smart-form','enableClientValidation'=>true, 'clientOptions'=>array('validateOnSubmit'=>true), 'htmlOptions'=>array('class'=>'smart-form')));
					echo $form->dropDownList($searchmodel, 'industry', array('neutral'=>'Neutral','positive'=>'Positive','negative'=>'Negative'), array('class'=>'form-control','id'=>'tnlyclassific'));
					echo "<input type='hidden' name='editid' id='editid' value='$editid'>";
					$this->endWidget();
				}
			}
		}elseif (isset($_POST['clsedmodal']) && isset($_POST['tnlyclassific']) && isset($_POST['editid']) && isset($_POST['storyid']) && isset($client)) {
			$analysis_id = $_POST['editid'];
			$client_tonality = $_POST['tnlyclassific'];
			if(Yii::app()->user->usertype=='agency'){
				$updatesql = "UPDATE mediamap_analysis SET tonality='$client_tonality' WHERE analysis_id=$analysis_id";
			}else{
				$updatesql = "UPDATE mediamap_analysis SET client_tonality='$client_tonality' WHERE analysis_id=$analysis_id";
			}
			$updateqry = Yii::app()->db2->createCommand($updatesql)->execute();
			if($updateqry){
				echo "<p><strong>Updated Successfully.</strong> You will need to refresh to view changes</p>";
			}else{
				echo "Could not update, change your options and please try Again";
			}
		}
		else{
			echo "Error, Please Log In or Review your Query to Proceed!";
		}
	}

	public function actionGetdata(){
		if(isset($_POST['classificationcompany'])){
			$clientid = $_POST['classificationcompany'];
			$sql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
			if($classifications = CompanyStoryClassification::model()->findAllBySql($sql)){
				foreach ($classifications as $value) {
					$classification_id=$value["classification_id"];
					$classification_name=trim($value["classification_name"]);
					echo '<option value="'.$classification_id.'" selected>'.$classification_name.'</option>';
				}
			}else{
				echo '<option>No Results Found</option>';
			}
		}
	}
	
	public function actionPdf()
	{
	  	$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}
		// $this->render('pdf',array('model'=>$model));
		$pdf_name = 'Stories_'.date('Y_m_d_h_i_s');
		$mPDF1 = Yii::app()->ePdf2->Download('pdf',array('model'=>$model),$pdf_name);
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

	public function actionView($id)
	{
		if($id !=NULL && isset($_GET['ext_link'])){
			$link = $_GET['ext_link'];
			header("Location: ".$link);
		}else{
			throw new Exception("Error Processing Request", 1);
		}
	}

	public function actionTests()
	{
		$this->render('tests');
	}

	public function actionVideo()
	{
		$this->render('video');
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
