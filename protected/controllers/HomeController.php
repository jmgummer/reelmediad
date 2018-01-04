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
class HomeController extends Controller
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
				'actions'=>array('index','print','view','video','tests','pdf','excel','cd','html','getdata'),
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
	public function actionPrint()
	{
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}else{
			$model->storycategory = 1;
			$model->storytype = 1;
		}
		if(Yii::app()->user->usertype=='agency'){
			$this->render('agency_stories',array('model'=>$model));
		}else{
			$this->render('stories',array('model'=>$model));
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

	public function actionHtml()
	{
	  	$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}

		$todays = date('Y-m-d');
		$startdate = $enddate = $todays;
		$search = ' ';
		$industries = '';
		$cat_identifier = 1;
		$type_identifier = 1;
		if(isset($_GET['clientid'])){ $client = $_GET['clientid']; }else{ 	$client = Yii::app()->user->company_id; }
		if(isset($_GET['startdate'])){ $startdate= $_GET['startdate']; }
		if(isset($_GET['enddate'])){ $enddate= $_GET['enddate']; }
		if(isset($_GET['search'])){ $search= $_GET['search']; }
		if(isset($_GET['industries'])){ $industries= $_GET['industries'];  }
		if(isset($_GET['cat_identifier'])){ $cat_identifier= $_GET['cat_identifier']; }
		if(isset($_GET['type_identifier'])){ $type_identifier= $_GET['type_identifier']; }

		$crunched = CompileHTML::Compiler($client,$startdate,$enddate,$search,$industries,$cat_identifier,$type_identifier);

		$agency_id = Yii::app()->user->company_id;
		$random = CompileCD::GenerateRandomId();
		$html_name=$agency_id . "_". $random;

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/html/';
		$filename_html=$path . "$html_name.html";
		$filecontent = $crunched;
		if (!$handle = fopen($filename_html, 'w')) {
			echo "Cannot open file ($filename_html')";
		}else{
			if (fwrite($handle, $filecontent) === FALSE) 
			{
				echo "Cannot write to file ($filename_html)";
			}
			fclose($handle);
		}

		$file = $filename_html;
		$file_name = 'Stories_'.date('Y_m_d_h_i_s');
		$type = 'text/html';
		if(file_exists($file)){
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($file));
			header('Content-Disposition: attachment; filename="'.$file_name.'.html"');
			readfile($file);
		}else{
			echo 'file not found';
		}
	}

	public function actionCd()
	{
		$model = new StorySearch('search');
		$model->unsetAttributes();
		if(isset($_POST['StorySearch']))
		{
			$model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
			$model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
			$model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));
		}
		$todays = date('Y-m-d');
		$startdate = $enddate = $todays;
		$search = ' ';
		// Adding Country Code
		$country = Yii::app()->user->country_id;
		$industries = '';
		// Adding backdate
		$cat_identifier = 1;
		$type_identifier = 1;
		

		if(isset($_GET['clientid'])){
			$client = $_GET['clientid'];
		}else{
			$client = Yii::app()->user->company_id;
		}
		if(isset($_GET['startdate'])){
		  $startdate= $_GET['startdate'];
		}
		if(isset($_GET['enddate'])){
		  $enddate= $_GET['enddate'];
		}
		if(isset($_GET['search'])){
		  $search= $_GET['search'];
		}
		if(isset($_GET['industries'])){
		  $industries= $_GET['industries'];
		}

		if(isset($_GET['cat_identifier'])){
		  $cat_identifier= $_GET['cat_identifier'];
		}
		if(isset($_GET['type_identifier'])){
		  $type_identifier= $_GET['type_identifier'];
		}

		$zipped_file = CompileCD::Compiler($client,$startdate,$enddate,$search,$industries,$cat_identifier,$type_identifier);
		$this->render('cd',array('model'=>$model,'file'=>$zipped_file));
	}

	public function actionExcel()
	{
		$todays = date('Y-m-d');
		$startdate = $enddate = $todays;
		$search = ' ';
		// Adding Country Code
		$country = Yii::app()->user->country_id;
		$industries = '';
		// Adding backdate
		$cat_identifier = 1;
		$type_identifier = 1;
		if(isset($_GET['clientid'])){
			$client = $_GET['clientid'];
		}else{
			$client = Yii::app()->user->company_id;
		}

		$company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>$client));
		$backdate = $company_words->backdate;

		if(isset($_GET['startdate'])){
		  $startdate= $_GET['startdate'];
		}
		if(isset($_GET['enddate'])){
		  $enddate= $_GET['enddate'];
		}
		if(isset($_GET['search'])){
		  $search= $_GET['search'];
		}
		if(isset($_GET['industries'])){
		  $industries= $_GET['industries'];
		}

		if(isset($_GET['cat_identifier'])){
		  $cat_identifier= $_GET['cat_identifier'];
		}
		if(isset($_GET['type_identifier'])){
		  $type_identifier= $_GET['type_identifier'];
		}

		if($type_identifier==1){
			if($cat_identifier==1){
				$option = 1;
			}
			if($cat_identifier==2){
				$option = 2;
			}
			if($cat_identifier==3){
				$option = 3;
			}
		}
		if($type_identifier==2){
			if($cat_identifier==1){
				$option = 4;
			}
			if($cat_identifier==2){
				$option = 5;
			}
			if($cat_identifier==3){
				$option = 6;
			}
		}
		if($type_identifier==3){
			if($cat_identifier==1){
				$option = 7;
			}
			if($cat_identifier==2){
				$option = 8;
			}
			if($cat_identifier==3){
				$option = 9;
			}
		}
		if(Yii::app()->user->usertype=='agency'){
			$stories = AgencyExcelStories::GetMainOption($client,$startdate,$enddate,$search,$backdate,$country,$industries,$option);
		}else{
			$stories = ExcelStories::GetMainOption($client,$startdate,$enddate,$search,$backdate,$country,$industries,$option);
		}

    	
		Yii::app()->end();
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

	public function actionGetdata()
	{
		/* For Industry Data */

		if(isset($_POST['company'])){
			$company = $_POST['company'];
			$sql = 'SELECT Industry_List, industry.Industry_ID, sup_ind_id, sect_id, sub_ind_id FROM industry,industry_company 
			where industry_company.company_id='.$company.' and industry_company.industry_id=industry.Industry_ID order by sub_ind_id, Industry_List';
			if($industries = Industry::model()->findAllBySql($sql)){
				echo '<option value="all">All Industries</option>';
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
}
