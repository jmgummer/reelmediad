<?php
$this->pageTitle=Yii::app()->name.' | File Zipper';
$this->breadcrumbs=array('CD');
$date = date('d-m-Y');
?>
<div class="supercenter">
	<p>Download Your File</p>
	<br>
	<i class="fa fa-file-archive-o fa-4x"></i>
	<br>
	<p><?php echo $date; ?></p>
	<a href="<?=Yii::app()->createUrl("$file");?>" class="btn btn-primary" >Download</a>
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
</style>