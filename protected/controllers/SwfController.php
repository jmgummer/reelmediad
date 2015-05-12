<?php

class SwfController extends Controller
{
	/**
	 * @var This is the admin controller
	 */
	public $layout='//layouts/swf';

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
				$png_file = substr($pdf_file, 0,-3).'jpg';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize = "convert $png_path  -resize 60% $png_path";

				system($cmd_conv_pdf);

				// $this->render('view', array('png_file'=>$png_file));

				if(isset($_GET['name'])){
					$image_name = $_GET['name'];
				}else{
					$image_name = 'download_';
				}

				$location = $_SERVER['DOCUMENT_ROOT']."/reelmediad/conversions/";
				$file = $location.$png_file;
				$type = 'image/jpeg';
				if(file_exists($file)){
					header('Content-Type:'.$type);
					header('Content-Length: ' . filesize($file));
					header('Content-Disposition: attachment; filename="'.$image_name.'.jpg"');
					readfile($file);
				}
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	/* 
	** This Function is used to Create a Highlighted Image
	** Create The File and await Highlighting 
	*/

	public function actionHighlight()
	{
		if(isset($_GET['file'])){
			$file = $_GET['file'];
			$pdf_file =  substr($file, 11);
			if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){
				$png_file = substr($pdf_file, 0,-3).'jpg';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize="/usr/bin/convert  -resize 1000x 1298\!    $png_path  $png_path";
				// $cmd_resize = "convert $png_path  -resize 1000x 1298\! $png_path";
				exec($cmd_conv_pdf);
				exec($cmd_resize);
				$this->render('highlight', array('png_file'=>$png_file));
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	/* 
	** This Function Generates the Highlighted Section, Generate A Unique Name for the File,
	** Create Ratios, pass the command to be executed and echo the resultant image to be
	** To Be used by JS
	*/

	public function actionManipulator()
	{
		if(!isset($_POST['x1'])  || !isset($_POST['y1']) || !isset($_POST['width']) || !isset($_POST['height']) || !isset($_POST['image']) ){
			echo 'Error';
		}else{
			$uniquefile=ImageClass::Generatestory_uniqueid();
			$my_image="highlight_" .$uniquefile. ".jpg";
			$highlight_image="highlight_" .$uniquefile. ".jpg";
			$cmd="identify -format \"%w\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_width=exec($cmd);
			$cmd="identify -format \"%h\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_height=exec($cmd);
			$width_ratio=$actual_width/1000;
			$height_ratio=$actual_height/1298;
			$resize="/usr/bin/convert    /home/srv/www/htdocs/reelmediad/images/watermark.png  -resize  ". ($_POST['width']*$width_ratio)."x".($_POST['height']*$height_ratio)."\!   /home/srv/www/htdocs/reelmediad/tmp/$highlight_image" ;
			exec($resize);
			$my_image = "/home/srv/www/htdocs/reelmediad/tmp/".$my_image;
			$cmd="/usr/bin/composite -compose multiply -geometry  +".($_POST['x1']*$width_ratio)."+".($_POST['y1']*$height_ratio) ." /home/srv/www/htdocs/reelmediad/tmp/$highlight_image   /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']) ."  " . $my_image;
			exec($cmd);
			echo $highlight_image;

			// header('Content-Type: image/jpeg');

			// // Output the image
			// imagejpeg($highlight_image);

			// // Free up memory
			// imagedestroy($highlight_image);
		}
	}

	public function actionDownloadimage()
	{
		if(isset($_GET['image']) && !empty($_GET['image'])){
			if(isset($_GET['name'])){
				$image_name = $_GET['name'];
			}else{
				$image_name = $_GET['image'];
			}
			$location = $_SERVER['DOCUMENT_ROOT']."/reelmediad/tmp/";
			$file = $location.$_GET['image'];
			$type = 'image/jpeg';
			if(file_exists($file)){
				header('Content-Type:'.$type);
				header('Content-Length: ' . filesize($file));
				header('Content-Disposition: attachment; filename="'.$image_name.'.jpg"');
				readfile($file);
			}else{
				echo 'not found';
			}
			
		}
	}

	/* 
	** This Function is used to Create a Cropped Image
	** Create The File and await Cropping 
	*/

	public function actionCrop()
	{
		if(isset($_GET['file'])){
			$file = $_GET['file'];
			$pdf_file =  substr($file, 11);
			if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){
				$png_file = substr($pdf_file, 0,-3).'jpg';
				$png_path = '/home/srv/www/htdocs/reelmediad/conversions/'.$png_file;
				$cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
				$cmd_resize="/usr/bin/convert  -resize 1000x 1298\!    $png_path  $png_path";
				// $cmd_resize = "convert $png_path  -resize 1000x 1298\! $png_path";
				exec($cmd_conv_pdf);
				exec($cmd_resize);
				$this->render('crop', array('png_file'=>$png_file));
			}else{
				echo 'pdf_file_missing';
			}
		}else{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}

	/* 
	** This Function Generates the Cropped Section, Generate A Unique Name for the File,
	** Create Ratios, pass the command to be executed and echo the resultant image to be,
	** To Be used by JS
	*/

	public function actionCropper()
	{
		if(!isset($_POST['x1'])  || !isset($_POST['y1']) || !isset($_POST['width']) || !isset($_POST['height']) || !isset($_POST['image']) ){
			echo 'Error';
		}else{
			$uniquefile=ImageClass::Generatestory_uniqueid();

			$my_image="crop_" .$uniquefile. ".jpg";
			$crop_image="crop_" .$uniquefile. ".jpg";
			$cmd="identify -format \"%w\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_width=exec($cmd);
			$cmd="identify -format \"%h\"  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']);
			$actual_height=exec($cmd);
			$width_ratio=$actual_width/1000;
			$height_ratio=$actual_height/1298;
			$resize="/usr/bin/convert  /home/srv/www/htdocs/reelmediad/conversions/" . trim($_POST['image']) . " -crop ". ($_POST['width']*$width_ratio)."x".($_POST['height']*$height_ratio)."+".($_POST['x1']*$width_ratio)."+".($_POST['y1']*$height_ratio) ."  /home/srv/www/htdocs/reelmediad/tmp/$my_image" ;
			exec($resize);
			echo $crop_image;
		}
	}
}
