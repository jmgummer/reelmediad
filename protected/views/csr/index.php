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
$narrative= 'Searched for CSR Stories '.$nara_search.' between 2014-06-25 and 2014-06-25';

echo '<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
		<header role="heading"><h2>'.$narrative.'</h2></header>
	</div>';


	if($type_identifier==1){
		echo '<div class="row-fluid clearfix"><div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>My Print Stories</h2></header>';
		$stories = Csr::GetClientStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';

		echo '<div class="row-fluid clearfix">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>My Electronic Stories</h2></header>';
		$stories = Csr::GetElectronicStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';

		echo '<div class="row-fluid clearfix">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>Industry Print Stories</h2></header>';
		$stories = Csr::GetClientIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';

		echo '<div class="row-fluid clearfix">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>Industry Electronic Stories</h2></header>';

		$stories = Csr::GetClientElectronicIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';
	}

	if($type_identifier==2){
		echo '<div class="row-fluid clearfix"><div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
				<header role="heading"><h2>My Print Stories</h2></header>';
				$stories = Csr::GetClientStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
				echo '</div></div>';

				echo '<div class="row-fluid clearfix">
				<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
				<header role="heading"><h2>Industry Print Stories</h2></header>';
				$stories = Csr::GetClientIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
				echo '</div></div>';
	}

	if($type_identifier==3){
		echo '<div class="row-fluid clearfix">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>My Electronic Stories</h2></header>';
		$stories = Csr::GetElectronicStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';

		echo '<div class="row-fluid clearfix">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
		<header role="heading"><h2>Industry Electronic Stories</h2></header>';
		$stories = Csr::GetClientElectronicIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
		echo '</div></div>';
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