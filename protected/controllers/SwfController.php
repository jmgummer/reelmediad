<?php

class SwfController extends Controller
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
				'actions'=>array('index','view','image','crop','highlight','manipulator'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('indexs');
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('index', array('model'=>$model));
	}

	public function loadModel($id)
	{
		$model = Story::model()->find('Story_ID=:a', array(':a'=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			return $model;
	}

	public function actionImage()
	{
		if(isset($_GET['file'])){
			$file = $_GET['file'];
			$pdf_file =  substr($file, 11);
			if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){
				$png_file = substr($pdf_file, 0,-3).'png';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize = "convert $png_path  -resize 80% $png_path";

				system($cmd_conv_pdf);
				$this->render('view', array('png_file'=>$png_file));
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionHighlight()
	{
		/* Create The File and await Manipulation */
		if(isset($_GET['file'])){
			$file = $_GET['file'];
			$pdf_file =  substr($file, 11);
			if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){
				$png_file = substr($pdf_file, 0,-3).'jpg';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize = "convert $png_path  -resize 80% $png_path";
				system($cmd_conv_pdf);
				$this->render('highlight', array('png_file'=>$png_file));
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	public function actionManipulator()
	{
		if(!isset($_POST['x1']) || !isset($_POST['x2']) || !isset($_POST['y1']) || !isset($_POST['y2']) || !isset($_POST['width']) || !isset($_POST['height']) || !isset($_POST['image']) ){
			echo 'kubaya';
		}else{
			if($highlighted = ImageClass::Highlight($_POST['image'],$_POST['x1'],$_POST['y1'],$_POST['width'],$_POST['height'])){
				echo 'wazi';
			}else{
				echo 'March Madness';
			}
		}
		
	}

	public function actionCrop()
	{
		$this->render('crop');
		if(!isset($_POST['x1']) || !isset($_POST['x2']) || !isset($_POST['y1']) || !isset($_POST['y2']) || !isset($_POST['width']) || !isset($_POST['height'])){
			echo 'kubaya';
		}else{
			$highlighted = ImageClass::Highlight($_POST['x1'],$_POST['x2'],$_POST['y1'],$_POST['y2'],$_POST['width'],$_POST['height']);
		}
	}

	
}
