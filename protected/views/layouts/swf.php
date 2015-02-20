<?php if(!isset($_SESSION['view'])){ $class = 'unminified'; }else{ $class = $_SESSION['view']; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/url.js"></script>
</head>
<script type="text/javascript">
    setInterval("checkLoad()",2000);
</script>
<body class=" fixed-header fixed-navigation minified">
	<div id="preLoaderDiv">
	    <img id="preloaderAnimation" src="<?php echo Yii::app()->request->baseUrl . '/images/loading.gif'; ?>" />
	</div>

	<header id="header">
		<div id="logo-group">
			<!-- PLACE YOUR LOGO HERE -->
			<span id="logo"> <a href="<?=Yii::app()->createUrl("site");?>"><img src="<?php echo Yii::app()->request->baseUrl . '/images/reelforge_logo.png'; ?>" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" ></a> </span>
			<!-- END LOGO PLACEHOLDER -->
		</div>
		<div class="pull-right">
			<img src="<?php echo Yii::app()->request->baseUrl . '/images/header_reelmedia.png'; ?>" alt="Reelmedia Logo" >
			<div id="hide-menu" class="btn-header pull-right">
				<span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
			</div>
		</div>
	</header>

	<aside id="left-panel" style="min-height:100%">
		<!-- User info -->
			
			
		
	</aside>
	<div id="main" role="main">
		<div id="ribbon">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>
		</div>
		<?php
		$this->widget('bootstrap.widgets.TbAlert', array(
		    'fade'=>true,
		    'closeText'=>'&times;',
		    'alerts'=>array(
		        'success'=>array('block'=>false, 'fade'=>true, 'closeText'=>'&times;'),
		        'info'=>array('block'=>false, 'fade'=>true, 'closeText'=>'&times;'), 
		        'warning'=>array('block'=>false, 'fade'=>true, 'closeText'=>'&times;'),
		        'error'=>array('block'=>false, 'fade'=>true, 'closeText'=>'&times;'),
		        'danger'=>array('block'=>false, 'fade'=>true, 'closeText'=>'&times;')
		    )
		)); 
		?>
	<?php echo $content; ?>
	</div>

	
<a href="#" class="back-to-top">Back to Top</a>
<div id="bottom"></div>
</body>
</html>
<style type="text/css">
.alert {
    margin-bottom: 0px !important;
    }
#content{
	min-height: 900px;
}
.back-to-top {
    position: fixed;
    bottom: 2em;
    right: 0px;
    text-decoration: none;
    color: #000000;
    background-color: rgba(135, 135, 135, 0.50);
    font-size: 12px;
    padding: 1em;
    display: none;
    text-decoration: none;
}

.back-to-top:hover {    
    background-color: rgba(135, 135, 135, 0.50);
    text-decoration: none;
    color: #000000;
}
</style>
<script type="text/javascript">
function checkLoad()
{
   if(document.getElementById("bottom"))
   {
	document.getElementById("preLoaderDiv").style.visibility = "hidden";
   }
}

$(document).ready(function(){
	$("#slideopen").click(function(){
		SetMinified();
	});
});
</script>