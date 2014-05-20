<?php
$this->pageTitle=Yii::app()->name.' | Home';
$this->breadcrumbs=array('Index');
?>


<?php echo Yii::app()->user->company_name; ?>
<?php $this->renderPartial('client_options'); ?>
<?php echo '<br>Date : between'; ?><?php echo $todays = date('Y-m-d'); ?>
<?php echo '<br>Key Words Searched : '; ?>
<?php echo Yii::app()->user->company_id; ?>
<div class="row-fluid clearfix">
<?php 
// if($company_words = Company::model()->find('company_id=:a', array(':a'=>Yii::app()->user->company_id))){
// 	//echo $company_words->keywords.'<br>';
// 	if($pieces = explode(",", $company_words->keywords)){
// 		foreach ($pieces as $key) {
// 			echo '<div class="col-md-3">'.$key.'</div>';
// 		}
// 	}
// }
?>
</div>
<br>
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">


<?php

// $stories = RecentStories::PrintStories(Yii::app()->user->company_id);
$stories = RecentStories::GetClientStory(Yii::app()->user->company_id);
?>
</div>
</div>