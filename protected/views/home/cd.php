<?php
$this->pageTitle=Yii::app()->name.' | File Zipper';
$this->breadcrumbs=array('CD');
?>
<div class="supercenter">
	<p>Download Your File</p>
	<br>
	<i class="fa fa-file-archive-o fa-4x"></i>
	<a href="<?=Yii::app()->createUrl("$file");?>" class="btn btn-" >Download</a>
</div>
<style type="text/css">
.supercenter{
	font-weight: bold;
	font-size: 14px;
	text-align: center;
	padding: 150px 50px 50px 50px;
}

.supercenter p{
	font-weight: normal;
	
}
</style>