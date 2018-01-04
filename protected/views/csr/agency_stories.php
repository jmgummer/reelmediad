<?php
$this->pageTitle=Yii::app()->name.' | Corporate Social Responsibility Reports';
$this->breadcrumbs=array('CSR Reports'=>array('csr/index'), 'Corporate Social Responsibility');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-3">
	<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
	<?php 
$search = ' ';
$type_identifier = 1;
if(isset($_POST['StorySearch'])){
	$startdate = $model->startdate;
	$enddate = $model->enddate;
	$search = $model->search_text;
	if(isset($model->storytype) && !empty($model->storytype)){
    	$type_identifier= $model->storytype;
    }
}else{
	$todays = date('Y-m-d');
	$startdate = $enddate = $todays;
}
if($search!=' ' && $search!=null ){
	$nara_search = '( '.$search.' )';
}else{
	$nara_search = '';
}
$narrative= 'Searched for CSR Stories '.$nara_search.' between '.$startdate.' and '.$enddate;

if(isset($_POST['StorySearch'])){
	$client = $model->company;

echo '<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
		<header role="heading"><h2>'.$narrative.'</h2></header>
	</div>';


	if($type_identifier==1){
		echo '<div class="widget-body">
		<ul id="myTab1" class="nav nav-tabs bordered">
			<li class="active"><a href="#s1" data-toggle="tab">My Print Stories</a></li>
			<li class=""><a href="#s2" data-toggle="tab">My Electronic Stories</a></li>
			<li class=""><a href="#s3" data-toggle="tab">Industry Print Stories</a></li>
			<li class=""><a href="#s4" data-toggle="tab">Industry Electronic Stories</a></li>
			<li class="pull-right">
				<a href="javascript:void(0);">
				<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
			</li>
		</ul>';
		echo '<div id="myTabContent1" class="tab-content padding-10">';

		echo '<div class="tab-pane fade active in" id="s1">';
		$stories = Csr::GetClientStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s2">';
		$stories = Csr::GetElectronicStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientIndustryStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s4">';
		$stories = Csr::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}

	if($type_identifier==2){
		echo '<div class="widget-body">
		<ul id="myTab1" class="nav nav-tabs bordered">
			<li class="active"><a href="#s1" data-toggle="tab">My Print Stories</a></li>
			<li class=""><a href="#s3" data-toggle="tab">Industry Print Stories</a></li>
			<li class="pull-right">
				<a href="javascript:void(0);">
				<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
			</li>
		</ul>';
		echo '<div id="myTabContent1" class="tab-content padding-10">';

		echo '<div class="tab-pane fade active in" id="s1">';
		$stories = Csr::GetClientStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientIndustryStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}

	if($type_identifier==3){
		echo '<div class="widget-body">
		<ul id="myTab1" class="nav nav-tabs bordered">
			<li class="active"><a href="#s1" data-toggle="tab">My Electronic Stories</a></li>
			<li class=""><a href="#s3" data-toggle="tab">Industry Electronic Stories</a></li>
			<li class="pull-right">
				<a href="javascript:void(0);">
				<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
			</li>
		</ul>';
		echo '<div id="myTabContent1" class="tab-content padding-10">';

		echo '<div class="tab-pane fade active in" id="s1">';
		$stories = Csr::GetElectronicStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search);
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}
}else{
	
}
	?>

</div>
</div>

<style type="text/css">
#content{
	min-height: 900px;
}
</style>