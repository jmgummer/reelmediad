<?php
$this->pageTitle=Yii::app()->name.' | File Zipper';
$this->breadcrumbs=array('CD');
$date = date('d-m-Y');
?>
<div class="supercenter">
	<p>Download Your File</p>
	<br>
	<i class="fa fa-file-archive-o fa-4x"></i>
	<div class="media-content">
		<p><?php echo $date; ?></p>
		<p><a href="<?=Yii::app()->createUrl("$file");?>" class="btn btn-primary" >Download</a></p>
	</div>
</div>
<style type="text/css">
.supercenter{
	font-weight: bold;
	font-size: 14px;
	text-align: center;
	padding: 150px 50px 50px 50px;
}
.supercenter i,.supercenter p,.supercenter a{
	font-weight: normal;
	text-align: center;
}
.supercenter a{
	margin: 
}
.media-content p{
	font-size: 12px;
	padding: 10px 10px;
}
.media-content a{
	font-size: 14px;
}
</style>