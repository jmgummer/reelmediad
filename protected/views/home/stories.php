<?php
$this->pageTitle=Yii::app()->name.' | Home';
$this->breadcrumbs=array('Index');
?>

<?php $this->renderPartial('search_filter'); ?>

<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
	<header role="heading"><h2>Company : <?php echo Yii::app()->user->company_name; ?></h2></header>
	<div id="chat-body" role="content">
		<div class="widget-body no-padding">
			<div class="search-params">
			<?php echo '<strong>Date : between </strong>'; ?><?php echo $todays = date('Y-m-d'); ?>
			<?php echo '<br><strong>Key Words Searched : </strong>'; ?>
			</div>
			<?php 
			if($company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>Yii::app()->user->company_id))){
				// echo $company_words->keywords;
				if($pieces = explode(",", $company_words->keywords)){
					foreach ($pieces as $key) {
						echo '<div class="col-md-3">'.$key.'</div>';
					}
				}
			}
			?>
		</div>
	</div>
</div>

<br>
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
<header role="heading"><h2>Print Stories</h2></header>

<?php

// $stories = RecentStories::PrintStories(Yii::app()->user->company_id);
$stories = RecentStories::GetClientStory(Yii::app()->user->company_id);
?>
</div>
</div>
<style type="text/css">
.search-params{
	padding: 10px 13px;
	clear: both;
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
</style>