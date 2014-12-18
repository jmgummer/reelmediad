<?php
$this->pageTitle=Yii::app()->name.' | Archive Reports';
$this->breadcrumbs=array('Archive Reports'=>array('archive/index'), 'Print Archive');
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
		<h3>Print Archive</h3>
		<p>You may search our print archives here. Search results are limited to your subscription terms. Please call your client service representative for more information. </p>
	</div>
</div>
</div>

<style type="text/css">
#content{
	min-height: 900px;
}
</style>