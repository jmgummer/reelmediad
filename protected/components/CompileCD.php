<?php

/**
* CompileCD Component Class
* This Class Is Used To Return The Users/Company Compiled CD
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version 	   v.1.0
* @since       July 2008
*/

class CompileCD{

	/**
	*
	* @return  Return The Generated Zip File
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function Compiler($client,$startdate,$enddate,$search,$industries,$cat_identifier,$type_identifier){
		$country = Yii::app()->user->country_id;
		$company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>$client));
		$backdate = $company_words->backdate;
		$agency_id = Yii::app()->user->company_id;
		$random = CompileCD::GenerateRandomId();
		$cd_name=$agency_id . "_". $random;
		$directory_cmd ="mkdir -p ".$_SERVER['DOCUMENT_ROOT']."/reelmediad/cd/".$cd_name;
		exec($directory_cmd);

		$permissions = "chmod -Rf 777 ".$_SERVER['DOCUMENT_ROOT']."/reelmediad/cd/".$cd_name;
		exec($permissions);

		$template = $_SERVER['DOCUMENT_ROOT']."/reelmediad/cd_template/";
		$destination = $_SERVER['DOCUMENT_ROOT']."/reelmediad/cd/".$cd_name;
		$cp_template = "cp -Rf ".$template."*  ".$destination;
		exec($cp_template);

		$permissions = "chmod -Rf 777 ".$destination;
		exec($permissions);

		$stories = '';
		if($type_identifier==1){
			if($cat_identifier==1){

				$stories = '<div class="content-tent">';
				$stories .= '<h3>My Stories</h3>';
				$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>My Electronic Stories</h3>';
				$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>Industry Print Stories</h3>';
				$stories .= CdStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==2){

				$stories = '<div class="content-tent">';
				$stories .= '<h3>My Stories</h3>';
				$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>My Electronic Stories</h3>';
				$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==3){

				$stories = '<div class="content-tent">';
				$stories .=  '<h3>Industry Print Stories</h3>';
				$stories .= CdStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
		}
		if($type_identifier==2){
			if($cat_identifier==1){

				$stories = '<div class="content-tent">';
				$stories .= '<h3>My Stories</h3>';
				$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==2){

				$stories = '<div class="content-tent">';
				$stories .= '<h3>My Stories</h3>';
				$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==3){

				$stories = '<div class="content-tent">';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
		}
		if($type_identifier==3){
			if($cat_identifier==1){

				$stories = '<div class="content-tent">';
				$stories .=  '<h3>My Electronic Stories</h3>';
				$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .=  '<br>';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==2){

				$stories = '<div class="content-tent">';
				$stories .=  '<h3>My Electronic Stories</h3>';
				$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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

			}
			if($cat_identifier==3){

				$stories = '<div class="content-tent">';
				$stories .=  '<h3>Industry Electronic Stories</h3>';
				$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries,$cd_name);
				$stories .= '</div>';
				$stories .=  '<br>';

				// Create the End File

				$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/';
				$filename_html=$path . "index.html";
				$crunched = CompileCD::FileBody($stories);
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
				
			}
		}

		$zip_directory = "cd/".$cd_name;
		$zipcmd="zip  -r " .$zip_directory.".zip $zip_directory";
		exec($zipcmd);
		$file = $zip_directory.".zip";
		return $file;
	}

	/**
	*
	* @return  Return A Random ID
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GenerateRandomId ($length = 5)
	{
		$story_uniqueid = "";
		$possible = "0123456789bcdfghjkmnpqrstvwxyz";
		$i = 0;
		while ($i < $length) 
		{
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			if (!strstr($story_uniqueid, $char)) {
				$story_uniqueid .= $char;
				$i++;
			}
		}
		$story_uniqueid.=date('Y_m_d_h_i_s_').$story_uniqueid;
		return $story_uniqueid;
	}

	/**
	*
	* @return  Return A computed HTML Body
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function FileBody($content){
		$body  = '';
		$body .= CompileCD::MainStyles();
		$body .= $content;
		$body .= '</div></div></body></html>';
		return $body;
	}

	/**
	*
	* @return  Return A computed HTML Body for Print Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintBody($title,$publication,$date,$type,$journalist,$page,$ave,$summary,$swf_file){
		$body  = '';
		$body .= CompileCD::Styles();
		$body .= CompileCD::ContentHeader($title,$publication,$date,$type,$journalist);
		$body .= CompileCD::ContentBody($page,$ave,$summary);
		$body .= CompileCD::PrintPlayer($swf_file,$date);
		$body .= '<div class="clearfix"></div></div></div></body></html>';
		return $body;
	}

	/**
	*
	* @return  Return A computed HTML Body for Electronic Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicBody($title,$publication,$date,$type,$journalist,$page,$ave,$summary,$swf_file,$filepath){
		$body  = '';
		$body .= CompileCD::Styles();
		$body .= CompileCD::ContentHeaderElectronic($title,$publication,$date,$type,$journalist);
		$body .= CompileCD::ContentBodyElectronic($page,$ave,$summary);
		$body .= CompileCD::ElectronicPlayer($swf_file,$filepath);
		$body .= '<div class="clearfix"></div></div></div></body></html>';
		return $body;
	}

	/**
	*
	* @return  Return the Top Section of the HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ContentHeader($title,$publication,$date,$type,$journalist){
		$date = date('d-M-Y', strtotime($date));
		$header = '';
		$header.= '<h3>'.$title.'</h3><br>';
		$header.= '<div class="col-md-3">';
		$header.= '<p><strong>'.$publication.'</strong></p>';
		$header.= '<p>'.$date.'</p>';
		$header.= '<p><strong>Type : </strong>'.$type.'</p>';
		$header.= '<p><strong>Journalist : </strong>'.$journalist.'</p>';
		return $header;
	}

	/**
	*
	* @return  Return the Top Section of HTML Content for Electronic
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ContentHeaderElectronic($title,$publication,$date,$type,$journalist){
		$date = date('d-M-Y', strtotime($date));
		$header = '';
		$header.= '<h3>'.$title.'</h3><br>';
		$header.= '<div class="col-md-3">';
		$header.= '<p><strong>'.$publication.'</strong></p>';
		$header.= '<p>'.$date.'</p>';
		$header.= '<p><strong>Time : </strong>'.$type.'</p>';
		return $header;
	}

	/**
	*
	* @return  Return the Body of HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ContentBody($page,$ave,$summary){
		$body = '';
		$body.= '<p><strong>Page : </strong>'.$page.'</p>';
		$body.= '<p><strong>AVE : </strong>'.$ave.'</p>';
		$body.= '<p><strong>Summary</strong><br>'.$summary.'</p>';
		$body.= '</div>';
		return $body;
	}

	/**
	*
	* @return  Return the Body of HTML Content for Electronic
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ContentBodyElectronic($page,$ave,$summary){
		$body = '';
		$body.= '<p><strong>Length : </strong>'.$page.'</p>';
		$body.= '<p><strong>AVE : </strong>'.$ave.'</p>';
		$body.= '<p><strong>Summary</strong><br>'.$summary.'</p>';
		$body.= '</div>';
		return $body;
	}

	/**
	*
	* @return  Return the File Link
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ContentFile($swf_file){
		$location = '/files/';
		$content = '';
		$content.= '<div class="col-md-3">';
		$content.= '<img src="../images/reelforge_logo.png" />';
		$content.= '</div>';
		return $content;
	}

	/**
	*
	* @return  Return the Styles for HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function Styles(){
		$style = '';
		$style = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
		$style.= "<head>";
		$style.= "<title>Reelforge CD Compilation</title>";
		$style.= "<link href='../css/text.css' rel='stylesheet' type='text/css'>";
		$style.= "<link href='../css/bootstrap.min.css' rel='stylesheet' type='text/css'>";
		$style.= "</head>";
		$style.= "<body>";
		$style.= "<div class='container-fluid'>";
		$style.= "<div class='content-wrap'>";
		$style.= "<div class='content-header'><img src='../images/reelforge_logo.png' /></div>";
		return $style;
	}

	/**
	*
	* @return  Return the Styles for HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function MainStyles()
	{
		$style = '';
		$style = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
		$style.= "<head>";
		$style.= "<title>Reelforge CD Compilation</title>";
		$style.= "<link href='css/text.css' rel='stylesheet' type='text/css'>";
		$style.= "<link href='css/bootstrap.min.css' rel='stylesheet' type='text/css'>";
		$style.= "</head>";
		$style.= "<body>";
		$style.= "<div class='container-fluid'>";
		$style.= "<div class='content-wrap'>";
		$style.= "<div class='content-header'><img src='images/reelforge_logo.png' /></div>";
		return $style;
	}

	/**
	*
	* @return  Moves Print File
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function MovePrintFile($file,$date,$cd_name){
		/* 
		** Copy the Required Files, Individually
		** get a copy of the pdf file 
		** get a copy of the swf file
		*/

		$location = $_SERVER['DOCUMENT_ROOT']."reelmedia/files/pdf/";
		$pdf_file = $location.$file;
		$swffile = strtolower(str_replace('.pdf', '.swf', $file));
		$swf_file = $location.$swffile;
		$build_date = date('Y/m/d/' ,strtotime($date));
		$pdf_destination = $_SERVER['DOCUMENT_ROOT']."reelmediad/cd/".$cd_name."/pdf_files/".str_replace($build_date, '', $file);
		$swf_destination = $_SERVER['DOCUMENT_ROOT']."reelmediad/cd/".$cd_name."/swf_files/".str_replace($build_date, '', $swffile);
		$pdf_cmd ="cp -v ".$pdf_file ."  ".$pdf_destination."  ";
		exec($pdf_cmd);
		$swf_cmd ="cp -v ".$swf_file ."  ".$swf_destination."  ";
		exec($swf_cmd);
	}

	/**
	*
	* @return  Moves the Electronic File
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function MoveElectronicFile($file,$date,$cd_name,$filepath)
	{
		/* 
		** Copy the Required Files, Individually
		** get a copy of the electronic file, mp3 or mpg/flv
		** Check if Flash File Exists 
		** Convert to lower caps then try and find
		** flv or else copy mpg
		*/
		$clip=str_replace("files/","",$file);
		$flash_clip=$filepath .$clip;
		if(file_exists($flash_file = str_replace(".mpg",".flv", strtolower($flash_clip)))){
			$destination_file= str_replace(".mpg",".flv",$clip);
			$destination_file = str_replace(":", "_", $clip);
			$destination_file = strtolower($destination_file);
			$flash_destination = $_SERVER['DOCUMENT_ROOT']."reelmediad/cd/".$cd_name."/electronic_files/".$destination_file;
			$flash_cmd ="cp -v ".$flash_file ."  ".$flash_destination." ";
			exec($flash_cmd);
		}else{
			$destination_file = str_replace(":", "_", $clip);
			$destination_file = strtolower($destination_file);
			$flash_destination = $_SERVER['DOCUMENT_ROOT']."reelmediad/cd/".$cd_name."/electronic_files/".$destination_file;
			$flash_cmd ="cp -v ".$flash_clip ."  ".$flash_destination." ";
			exec($flash_cmd);
		}
	}

	/**
	*
	* @return  Embed the Electronic Player for HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicPlayer($file,$filepath){
		/* 
		** Copy the Required Files, Individually
		** get a copy of the electronic file, mp3 or mpg/flv
		** Check if Flash File Exists 
		** Convert to lower caps then try and find
		** flv or else copy mpg
		*/
		$clip=str_replace("files/","",$file);
		$flash_clip=$filepath .$clip;
		if(file_exists($flash_file = str_replace(".mpg",".flv", strtolower($flash_clip)))){
			$destination_file= str_replace(".mpg",".flv",$clip);
			$destination_file = str_replace(":", "_", $clip);
			$destination_file = strtolower($destination_file);
			$file = $destination_file;
		}else{
			$destination_file = str_replace(":", "_", $clip);
			$destination_file = strtolower($destination_file);
			$file = $destination_file;
		}
		$data = '';
		$data.= '<div class="col-md-9">';
		$data.="<script type='text/javascript' src='../essentials/flowplayer-3.1.1.min.js'></script>";
		$data.= "<script type='text/javascript' src='../essentials/swfobject.js'></script>
		<script type='text/javascript'>
			swfobject.registerObject('player','9.0.98','../essentials/expressInstall.swf');
		</script>
		<object id='player' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' name='player' width='520' height='350'>
			<param name='movie' value='../essentials/player.swf' />
			<param name='allowfullscreen' value='true' />
			<param name='allowscriptaccess' value='always' />
			<param name='flashvars' value='file=../electronic_files/".$file."&image=../flash_video/preview.jpg' />
			<object type='application/x-shockwave-flash' data='../essentials/player-viral.swf' width='520' height='350'>
				<param name='movie' value='../essentials/player-viral.swf' />
				<param name='allowfullscreen' value='true' />
				<param name='allowscriptaccess' value='always' />
				<param name='flashvars' value='file=../electronic_files/".$file."&image=../essentials/flash_video/preview.jpg' />
				<p><a href='http://get.adobe.com/flashplayer'>Get Flash</a> to see this player.</p>
			</object>
		</object>";
		$data.= '</div>';

		return $data;
	}

	/**
	*
	* @return  Ember the Print Player for HTML Content
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintPlayer($file,$date){
		$build_date = date('Y/m/d/' ,strtotime($date));
		$file = str_replace($build_date, "", $file);
		$data = '';
		$data.= '<div class="col-md-9">';
		$data.="<script type='text/javascript' src='../essentials/swfobject/swfobject.js'></script>
		 <script type='text/javascript'>
					var flashvars = {
					 doc_url: '../swf_files/".$file."',
					};
					var params = {
					 menu: 'false',
					 bgcolor: '#efefef',
					 allowFullScreen: 'true'
					};
					var attributes = {
						id: 'website'
					};
		 swfobject.embedSWF('../essentials/zviewer.swf?r=11', 'website', '100%', '1100', '9.0.45',
		 '../essentials/swfobject/expressinstall.swf', flashvars, params, attributes);
		 </script>";
		 $data.="<div align=center> 
			<div id='website'>
				<p align='center' class='style1'>In order to view this page you need Flash Player 9+ support!</p>
				<p align='center'>
					<a href='http://www.adobe.com/go/getflashplayer'> 
						<img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /> 
					</a> 
				</p> 
			</div>
		</div>";
		$data.= '</div>';
		return $data;
	}

}