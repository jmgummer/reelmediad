<?php

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
				'actions'=>array('index','print','view','video','tests','pdf','excel'),
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
		}
		$this->render('stories',array('model'=>$model));
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
	  $mPDF1 = Yii::app()->ePdf2->Download('pdf',array('model'=>$model),'PDF');
	}

	public function actionExcel()
	{
		// Create new PHPExcel object
		$PHPExcel = new PHPExcel();
			
		// Set properties
		$PHPExcel->getProperties()->setCreator("Reelforge")
		->setTitle("Reelforge Reports")
		->setSubject("Reelforge Reports")
		->setDescription("Reelforge Reports");

		// Add some data
		$PHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'DATE')
		->setCellValue('B1', 'PUBLICATION')
		->setCellValue('C1', 'JOURNALIST')
		->setCellValue('D1', 'HEADLINE/SUBJECT')
		->setCellValue('E1', 'PAGE')
		->setCellValue('F1', 'PUBLICATION TYPE')
		->setCellValue('G1', 'PICTURE')
		->setCellValue('H1', 'EFFECT')
		->setCellValue('I1', 'AVE(Kshs.)');

		/* Add Values to the Spreadsheet */

		//Start from second row
        $count = 2;
        foreach($model as $rows)
        {
            $PHPExcel->getActiveSheet()
            ->setCellValue("A$count", $rows->name)
            ->setCellValue("B$count", $rows->description)
            ->setCellValue("C$count", $rows->price)
            ->setCellValue("G$count", $rows->error);
            $count++;
        }

        // Rename sheet
		$PHPExcel->getActiveSheet()->setTitle('Stories');

		// Set active sheet index to the first sheet,
		// so Excel opens this as the first sheet
		$PHPExcel->setActiveSheetIndex(0);
			
		// Redirect output to a clients web browser (Excel2003)
		header('Content-Type: application/excel');
		header('Content-Disposition: attachment;filename="Business_Items_Error.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
		$objWriter->save('php://output');
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
		// if($id!=null){
		// 	header($_GET['ext_link']);
		// }
		if($id !=NULL && isset($_GET['ext_link'])){
			$link = $_GET['ext_link'];
			// header("'Location: ".$link."'");
			header("Location: ".$link);
			// header($_GET['ext_link']);
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
