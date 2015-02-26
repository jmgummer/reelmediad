<?php
$this->pageTitle=Yii::app()->name.' | File Zipper';
$this->breadcrumbs=array('CD');
?>
<div class="supercenter">
	<p>Download Your File</p>
	<br>
	<a href="<?=Yii::app()->createUrl("$file");?>"><i class="fa fa-file-archive-o fa-3x"></i></a>
</div>
<style type="text/css">
.supercenter{
	font-weight: bold;
	font-size: 24px;
	text-align: center;
	padding: 150px 50px 50px 50px;
}
  
</style>