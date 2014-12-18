<?php
$this->pageTitle=Yii::app()->name.' | Radio/TV';
$this->breadcrumbs=array('Radio/TV Reports'=>array('radiotv/index'), 'Radio/TV');
?>
<div id="imageloadstatus" style="display:none"><div class="alert in fade alert-warning"><a class="close" data-dismiss="alert">×</a><strong>Loading ... </strong></div></div>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-3">
	<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
	<div class="archive-section" id="load-content">
		<h3>Electronic Media Search</h3>
		<p>Electronic Archives – You may search our electronic archives here. Search results are limited to your subscription terms. Please call your client service representative for more information.</p>
		

<?php

$todaysdate=date("Y-m-d");
if(isset($_POST['StorySearch'])){
	


}

?>
</div>
</div>
</div>

<style type="text/css">
#content{
	min-height: 900px;
}
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
    border: none;
    border-image: none;
}
table{
	font-size: 12px;
}
table a{
	color: #2F5961;
}
.force-padding{
	padding: 5px;
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