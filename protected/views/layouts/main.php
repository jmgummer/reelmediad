<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="">
<!-- HEADER -->
		<header id="header">
			<div id="logo-group">

				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"> <a href="<?=Yii::app()->createUrl("site");?>"><img src="<?php echo Yii::app()->request->baseUrl . '/images/reelforge_logo.png'; ?>" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" ></a> </span>
				<!-- END LOGO PLACEHOLDER -->

				
			</div>

			<!-- projects dropdown -->
			<div id="project-context">

				<span class="label">Apps:</span>
				<span id="project-selector" class="popover-trigger-element dropdown-toggle" data-toggle="dropdown">Other Applications <i class="fa fa-angle-down"></i></span>

				<!-- Suggestion: populate this list with fetch and push technique -->
				<ul class="dropdown-menu">
					<li>
						<a href="javascript:void(0);">Feature Coming Soon</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
					</li>
				</ul>
				<!-- end dropdown-menu-->

			</div>
			<!-- end projects dropdown -->

			<!-- pulled right: nav area -->
			<div class="pull-right">

				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a href="javascript:void(0);" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?=Yii::app()->createUrl("site/logout");?>" title="Sign Out"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- search mobile button (this is hidden till mobile view port) -->
				<div id="search-mobile" class="btn-header transparent pull-right">
					<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
				</div>
				<!-- end search mobile button -->

				<!-- input: search field -->
				<form action="#search.html" class="header-search pull-right">
					<input type="text" placeholder="Find reports and more" id="search-fld">
					<button type="submit">
						<i class="fa fa-search"></i>
					</button>
					<a href="javascript:void(0);" id="cancel-search-js" title="Cancel Search"><i class="fa fa-times"></i></a>
				</form>
				<!-- end input: search field -->


			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->



	<aside id="left-panel" style="min-height:100%">
		<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
					
					<a href="javascript:void(0);" id="show-shortcut">
						<img src="<?php echo Yii::app()->request->baseUrl . '/images/avatars/male.png'; ?>" alt="me" class="online" /> 
						<span>
							<?php echo Yii::app()->user->company_name; ?>
						</span>
					</a> 
					
				</span>
			</div>
			<nav>
				<ul>
					<li class="active">
						<a href="<?=Yii::app()->createUrl("home/index");?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("home/print");?>" title="Stories"><i class="fa fa-lg fa-fw fa-pencil"></i> <span class="menu-item-parent">Stories</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("industryreports/mentions");?>" title="Industry Reports"><i class="fa fa-lg fa-fw fa-file-text"></i> <span class="menu-item-parent">Industry Reports</span></a>
						<!-- <a href="#"><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Industry Reports</span></a>
						<ul>
							<li><a href="<?=Yii::app()->createUrl("industryreports/mentions");?>">Number of Mentions</a></li>
							<li><a href="<?=Yii::app()->createUrl("industryreports/ave");?>">AVE</a></li>
							<li><a href="<?=Yii::app()->createUrl("industryreports/categories");?>">Categories Mentioned</a></li>
						</ul> -->
					</li>
				</ul>
				<?php 
				// $this->widget('bootstrap.widgets.TbMenu',array(
				// 	'type'=>'list', // '', 'tabs', 'pills' (or 'list')
				// 	'items'=>array(
				// 		array('label'=>'Home', 'icon'=>'home', 'url'=>array('/home/index')),
				// 	),
				// )); 
				?>
			</nav>
			<span class="minifyme" style><i class="fa fa-arrow-circle-left hit" style="margin-top:4px;"></i></span>
		
	</aside>
	<div id="main" role="main">
		<div id="ribbon">
			<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				)); ?><!-- breadcrumbs -->
			<?php endif?>
		</div>

	<?php echo $content; ?>
	</div>

	


</body>
</html>
