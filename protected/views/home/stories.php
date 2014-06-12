<?php
$this->pageTitle=Yii::app()->name.' | Stories';
$this->breadcrumbs=array('Index');
?>
<div class="row-fluid clearfix">
<div class="col-md-3">
<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
<?php 
$todays = date('Y-m-d');
$startdate = $enddate = $todays;
$search = ' ';
if(isset($_POST['StorySearch'])){

	?>

	<?php
	// echo 'owned';
	$startdate = $model->startdate;
	$enddate = $model->enddate;
	$search = $model->search_text;
	
	?>
	<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
		<header role="heading"><h2>Company : <?php echo Yii::app()->user->company_name; ?> <strong>Search</strong> for Dates between <?php echo $startdate.' and '.$enddate; ?></h2></header>
				
		<div class="reveal">
		<div id="chat-body" role="content">
			<div class="widget-body no-padding">
				<div class="search-params">
				<?php echo '<br><strong>Key Words Searched : </strong> '.$search; ?>
				</div>
				<?php 
				if($company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>Yii::app()->user->company_id))){
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
		
		<footer class="reveal-footer"><button class="btn btn-primary">View Keywords</button></footer>
		
	</div>
	<?php
}
?>

<?php
if(isset($_POST['StorySearch'])){
// print_r($_POST['StorySearch']); 
	if(isset($model->industry)){
		// echo 'inda';
		foreach ($model->industry as $key) {
			// echo $key;
		}
	}
	if(isset($model->storytype))
	{
		// echo $model->storytype;
		if($model->storytype==1){

		}
	}
	if(isset($model->storycategory)){
		// echo $model->storycategory;
		if($model->storycategory==1){
			
		}
	}
}else{
	?>
	<!-- PRINT STORIES -->
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
<header role="heading"><h2>My Print Stories</h2></header>

<?php
$stories = RecentStories::GetClientStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
?>
</div>
</div>

<!-- ELECTRONIC STORIES -->
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
<header role="heading"><h2>My Electronic Stories</h2></header>

<?php
$stories = RecentStories::GetElectronicStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
?>
</div>
</div>

<!-- INDUSTRY PRINT STORIES -->
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
<header role="heading"><h2>Industry Print Stories</h2></header>

<?php
$stories = RecentStories::GetClientIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
?>
</div>
</div>

<!-- INDUSTRY ELECTRONIC STORIES -->
<div class="row-fluid clearfix">
<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
<header role="heading"><h2>Industry Electronic Stories</h2></header>

<?php
$stories = RecentStories::GetClientElectronicIndustryStory(Yii::app()->user->company_id,$startdate,$enddate,$search);
?>
</div>
</div>
</div>
</div>
	<?php
}
?>


<style type="text/css">
.radio label{
	/*font-weight: bold;*/
	/*margin-left: -10px;*/
}
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