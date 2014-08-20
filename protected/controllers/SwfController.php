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
		if(!isset($_POST['x1'])  || !isset($_POST['y1']) || !isset($_POST['width']) || !isset($_POST['height']) || !isset($_POST['image']) ){
			echo 'kubaya';
		}else{
			$uniquefile=ImageClass::Generatestory_uniqueid();
			$my_image="highlight_" .$uniquefile. ".jpg";
			$highlight_image="highlight_" .$uniquefile. ".jpg";

			//Get ratios
			$cmd="identify -format \"%w\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_width=exec($cmd);
			$cmd="identify -format \"%h\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_height=exec($cmd);

			$width_ratio=$actual_width/1000;
			$height_ratio=$actual_height/1298;

			$resize="/usr/bin/convert    /home/srv/www/htdocs/reelmediad/images/watermark.png  -resize  ". ($_POST['width']*$width_ratio)."x".($_POST['height']*$height_ratio)."\!   /home/srv/www/htdocs/reelmediad/tmp/$highlight_image" ;
			exec($resize);
			//echo "<hr>";
			$my_image = "/home/srv/www/htdocs/reelmediad/tmp/".$my_image;
			echo $cmd="/usr/bin/composite -compose multiply -geometry  +".($_POST['x1']*$width_ratio)."+".($_POST['y1']*$height_ratio) ." /home/srv/www/htdocs/reelmediad/tmp/$highlight_image   /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']) ."  " . $my_image;
			exec($cmd);

			$fullpath2="/home/srv/www/htdocs/reelmediad/tmp/";
			//$cropped=$fullpath2 . $my_image;
			$cropped= $my_image;
			header('Content-Description: File Transfer');
			header("Content-type: image/jpg");
			header("Content-disposition: attachment; filename= ".$cropped."");
			readfile("/home/srv/www/htdocs/reelmediad/tmp/".$cropped);
			// if($highlighted = ImageClass::Highlight($_POST['image'],$_POST['x1'],$_POST['y1'],$_POST['width'],$_POST['height'])){
			// 	echo 'wazi';
			// }else{
			// 	echo 'March Madness';
			// }
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
