<?php
$this->pageTitle=Yii::app()->name.' | Client Stories';
$this->breadcrumbs=array('Client Stories');
?>
<div class="row-fluid clearfix">
<div class="col-md-12">
<?php
$search = '';
$todays = date('Y-m-d');
$country = Yii::app()->user->country_id;
$cat_identifier = 1;
$type_identifier = 1;

if(isset($_GET['client_id'])){
	$clientid = $_GET['client_id'];
	$startdate = $_GET['startdate'];
	$enddate = $_GET['enddate'];

	$inda=array();
	if(isset($_GET['industries']) && !empty($_GET['industries'])){
	    $industries = $_GET['industries'];
	}
    // Adding backdate and Keywords
    $company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>$_GET['client_id']));
	$backdate = $company_words->backdate;
	$company_name = $company_words->company_name;
	
	$mystories=$_GET['mystories'];
	if($mystories==1){
		$type_identifier=1;
		$cat_identifier=2;
	}else{
		$type_identifier=1;
		$cat_identifier=3;
	}
	?>
	<br>
	<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
		<header role="heading">
			<h2>Export Reports ? 
				<a href="<?=Yii::app()->createUrl("home/pdf?clientid=$clientid&startdate=$startdate&enddate=$enddate&search=$search&industries=$industries&cat_identifier=$cat_identifier&type_identifier=$type_identifier");?>" class="btn btn-danger btn-xs pdf-excel"><i class="fa fa-file-pdf-o"></i> PDF</a>
				<a href="<?=Yii::app()->createUrl("home/excel?clientid=$clientid&startdate=$startdate&enddate=$enddate&search=$search&industries=$industries&cat_identifier=$cat_identifier&type_identifier=$type_identifier");?>" class="btn btn-success btn-xs pdf-excel"><i class="fa fa-file-excel-o"></i> EXCEL</a>
			</h2>
		</header>
	</div>
	
	<?php
}



echo '<div class="widget-body">
<ul id="myTab1" class="nav nav-tabs bordered">';
if($_GET['mystories']==1){
	echo '<li class="active"><a href="#s1" data-toggle="tab">My Print Stories</a></li>
	<li class=""><a href="#s2" data-toggle="tab">My Electronic Stories</a></li>';
}else{
	echo '<li class="active"><a href="#s3" data-toggle="tab">Industry Print Stories</a></li>
	<li class=""><a href="#s4" data-toggle="tab">Industry Electronic Stories</a></li>';
}

	echo '<li class="pull-right">
		<a href="javascript:void(0);">
		<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
	</li>
</ul>';
echo '<div id="myTabContent1" class="tab-content padding-10">';

if($_GET['mystories']==1){
		echo '<div class="tab-pane fade active in" id="s1">';
	$stories = RecentStories::GetClientStory($clientid,$startdate,$enddate,$search,$backdate,$country,$industries);
	echo '</div>';

	echo '<div class="tab-pane fade" id="s2">';
	$stories = RecentStories::GetElectronicStory($clientid,$startdate,$enddate,$search,$backdate,$country,$industries);
	echo '</div>';
}else{
	echo '<div class="tab-pane fade active in" id="s3">';
	$stories = RecentStories::GetClientIndustryStory($clientid,$startdate,$enddate,$search,$backdate,$country,$industries);
	echo '</div>';

	echo '<div class="tab-pane fade" id="s4">';
	$stories = RecentStories::GetClientElectronicIndustryStory($clientid,$startdate,$enddate,$search,$backdate,$country,$industries);
	echo '</div>';
}

echo '</div>';
echo '</div>';
?>
</div>
</div>



<style type="text/css">
.radio label{
	/*font-weight: bold;*/
	/*margin-left: -10px;*/
}
.search-params{
	padding: 10px 13px;
	clear: both;
}
.pdf-excel{
	margin: 5px 1px;
}
#chat-body {
    background: linear-gradient(to bottom, #F5FCFF 0px, #FFF 100%) repeat scroll 0% 0% transparent;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.04) inset;
    display: block;
    height: 270px;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 10px;
    box-sizing: border-box;
    border-right: 1px solid #FFF;
    border-width: 0px 1px 1px;
    border-style: none solid solid;
    border-color: -moz-use-text-color #FFF #FFF;
    -moz-border-top-colors: none;
    -moz-border-right-colors: none;
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    border-image: none;
}
table{
	font-size: 12px;
}
table a{
	color: #2F5961;
}
.reveal-footer{
	display: block;
	padding: 7px 14px 15px;
	border-top: 1px solid rgba(0, 0, 0, 0.1);
	background: none repeat scroll 0% 0% rgba(248, 248, 248, 0.9);
	margin: 0px;
	box-sizing: content-box;
	color: #666;
	border: 1px solid #C2C2C2;
}
</style>
<script>
$(document).ready(function(){
$(".reveal").hide();
  $("button").click(function(){
    $(".reveal").slideToggle();
  });
});
</script>