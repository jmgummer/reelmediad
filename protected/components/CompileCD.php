<?php

class CompileCD{
	public static function Compile()
	{}

	public static function CreateDirectories()
	{
		$cd_name=$agency_client_co_id . "_". $random;
		$cmd ="mkdir -p cd/" . $cd_name ."/files";
		exec($cmd);
		$cmd ="mkdir -p cd/" . $cd_name ."/video_files/";
		exec($cmd);
		$cmd ="mkdir -p cd/" . $cd_name ."/pdf_files/";
		exec($cmd);
		$cmd ="mkdir -p cd/" . $cd_name ."/swf_files/";
		exec($cmd);
		$cmd ="mkdir -p cd/" . $cd_name ."/clip_files/";
		exec($cmd);	
		$cmd ="mkdir -p cd/" . $cd_name ."/html_files/";
		exec($cmd);		
		$cmd="cp -fR /home/srv/www/htdocs/reelmedia/cd_template/* cd/" . $cd_name . "/";
		exec($cmd);
	}

	public static function FileBody($content){
		$body  = '';
		$body .= CompileCD::MainStyles();
		$body .= $content;
		$body .= '</div></div></body></html>';
		return $body;
	}

	public static function PrintBody($title,$publication,$date,$type,$journalist,$page,$ave,$summary,$swf_file){
		$body  = '';
		$body .= CompileCD::Styles();
		$body .= CompileCD::ContentHeader($title,$publication,$date,$type,$journalist);
		$body .= CompileCD::ContentBody($page,$ave,$summary);
		$body .= CompileCD::ContentFile($swf_file);
		$body .= '</div></div></body></html>';
		return $body;
	}

	public static function ElectronicBody($title,$publication,$date,$type,$journalist,$page,$ave,$summary,$swf_file){
		$body  = '';
		$body .= CompileCD::Styles();
		$body .= CompileCD::ContentHeaderElectronic($title,$publication,$date,$type,$journalist);
		$body .= CompileCD::ContentBodyElectronic($page,$ave,$summary);
		$body .= CompileCD::ContentFile($swf_file);
		$body .= '</div></div></body></html>';
		return $body;
	}

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

	public static function ContentBody($page,$ave,$summary){
		$body = '';
		$body.= '<p><strong>Page : </strong>'.$page.'</p>';
		$body.= '<p><strong>AVE : </strong>'.$ave.'</p>';
		$body.= '<p><strong>Summary</strong><br>'.$summary.'</p>';
		$body.= '</div>';
		return $body;
	}
	public static function ContentBodyElectronic($page,$ave,$summary){
		$body = '';
		$body.= '<p><strong>Length : </strong>'.$page.'</p>';
		$body.= '<p><strong>AVE : </strong>'.$ave.'</p>';
		$body.= '<p><strong>Summary</strong><br>'.$summary.'</p>';
		$body.= '</div>';
		return $body;
	}
	public static function ContentFile($swf_file){
		$location = '/files/';
		$content = '';
		$content.= '<div class="col-md-3">';
		$content.= '<img src="../images/reelforge_logo.png" />';
		$content.= '</div>';
		return $content;
	}
	public static function Styles()
	{
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

	public static function MoveFile($file){
		$location = $_SERVER['DOCUMENT_ROOT']."/reelmedia/files/pdf/";
		$pdf_file = $location.$file;
		$swf_file = strtolower(str_replace('.pdf', '.swf', $file));
		$swf_file = $location.$swf_file;

		$pdf_destination = $_SERVER['DOCUMENT_ROOT']."/reelmediad/cd/pdf_files/".$pdf_file;
		$swf_destination = $_SERVER['DOCUMENT_ROOT']."/reelmediad/cd/swf_files/".$swf_file;
		$pdf_cmd ="cp ".$pdf_file ." ".$pdf_destination;
		$swf_cmd ="cp ".$swf_file ." ".$swf_destination;
	}
}