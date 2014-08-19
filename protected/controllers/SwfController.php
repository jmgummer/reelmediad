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
				'actions'=>array('index','view','image'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		
		$this->render('index');
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
			// echo $file = $_GET['file'];
			echo $pdf_file =  substr($file, 11);
			if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){
				echo $pdf_path;
				$png_file = substr($pdf_file, 0,-3).'png';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize = "convert $png_path  -resize 50% $png_path";

				system($cmd_conv_pdf);
				system($cmd_resize);
				// //$final_file_path['url'] = str_replace('/home/srv/www/htdocs/', 'http://www.reelforge.com/', $png);
				// $final_file_path['url'] = "http://reelapp.reelforge.com/rf_droid/view/view.php?id=".$story_id."&img=".$png_file;
				
				$this->render('view', array('png_file'=>$png_file));
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	
}
