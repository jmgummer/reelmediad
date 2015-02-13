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

if($type_identifier==1){
	if($cat_identifier==1){
		echo '<table><tr><td>My Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>My Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>Industry Print Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==2){
		echo '<table><tr><td>My Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>My Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==3){
		echo '<table><tr><td>Industry Print Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
}
if($type_identifier==2){
	if($cat_identifier==1){
		echo '<table><tr><td>My Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==2){
		echo '<table><tr><td>My Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==3){
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
}
if($type_identifier==3){
	if($cat_identifier==1){
		echo '<table><tr><td>My Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==2){
		echo '<table><tr><td>My Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
	}
	if($cat_identifier==3){
		echo '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
		$stories = PdfStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
		echo '<br>';
		
	}
}
    
?>