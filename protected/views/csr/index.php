<?php
$this->pageTitle=Yii::app()->name.' | Corporate Social Responsibility Reports';
$this->breadcrumbs=array('CSR Reports'=>array('csr/index'), 'Corporate Social Responsibility');
?>
<script src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionCharts.js'; ?>"></script>
<script language="JavaScript" src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionChartsExportComponent.js'; ?>"></script>
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
if($search!=' '){
	$nara_search = '( '.$search.' )';
}else{
	$nara_search = '';
}
$narrative= 'Searched for CSR Stories '.$nara_search.' between '.$startdate.' and '.$enddate;

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
		$stories = Csr::GetClientStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s2">';
		$stories = Csr::GetElectronicStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s4">';
		$stories = Csr::GetClientElectronicIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
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
		$stories = Csr::GetClientStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
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
		$stories = Csr::GetElectronicStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '<div class="tab-pane fade" id="s3">';
		$stories = Csr::GetClientElectronicIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}



// echo $sql='select issues_client,csr_client from company where company_id='.Yii::app()->user->company_id;
// $c_issue = Company::model()->findBySql($sql);
// echo '<br>this_csr_client'.$this_csr_client = $c_issue->csr_client;
// if($this_csr_client==1) {
//         echo $csr_table=', story_client';
//         echo $csr_query=' and story.story_id=story_client.story_id and story_client.client_id='.Yii::app()->user->company_id;
// }

// if($this_csr_client==2) {
//         echo $csr_table=', story_industry';
//         echo $csr_query=' and story.story_id=story_industry.story_id and story_client.cindustry_id IN (select industry_id from industry_company where company_id='.Yii::app()->user->company_id.')';
// }

// if($this_csr_client==3) {
//         echo $csr_table='';
//         echo $csr_query='';
// }

	?>

</div>
</div>

<style type="text/css">
#content{
	min-height: 900px;
}
</style>