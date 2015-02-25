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

$stories = '';
if($type_identifier==1){
	if($cat_identifier==1){

		$stories = '<div class="content-tent">';
		$stories .= '<h3>My Stories</h3>';
		$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>My Electronic Stories</h3>';
		$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>Industry Print Stories</h3>';
		$stories .= CdStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>Industry Electronic Stories</h3>';
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>My Electronic Stories</h3>';
		$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>Industry Electronic Stories</h3>';
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>Industry Electronic Stories</h3>';
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .=  '<br>';
		$stories .=  '<h3>Industry Electronic Stories</h3>';
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
		$stories .= CdStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		$stories .= '</div>';
		$stories .=  '<br>';

		// Create the End File

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/';
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
    
?>