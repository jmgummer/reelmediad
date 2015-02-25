<?php
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
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}

?>