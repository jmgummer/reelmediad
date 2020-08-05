<?php if(!isset($_SESSION['view'])){ $class = 'unminified'; }else{ $class = $_SESSION['view']; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/url.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>

	<!-- Highcharts -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/Highcharts-7.0.3.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/highcharts-3d-v7.0.3.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/highchart_exporting_module-v7.0.3.js'; ?>"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/highchart_v7.0.3_modules_export-data.js'; ?>"></script>
</head>
<script type="text/javascript">
    setInterval("checkLoad()",2000);
</script>
<body class=" fixed-header fixed-navigation <?=$class;?>">
	<div id="preLoaderDiv">
	    <img id="preloaderAnimation" src="<?php echo Yii::app()->request->baseUrl . '/images/loading.gif'; ?>" />
	</div>
	<!-- HEADER -->
	<header id="header">
		<div id="logo-group">
			<!-- PLACE YOUR LOGO HERE -->
			<span id="logo"> <a href="<?=Yii::app()->createUrl("site");?>"><img src="<?php echo Yii::app()->request->baseUrl . '/images/reelforge_logo.png'; ?>" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" ></a> </span>
			<!-- END LOGO PLACEHOLDER -->
		</div>
		<!-- pulled right: nav area -->
		<div class="pull-right">
			<img src="<?php echo Yii::app()->request->baseUrl . '/images/header_reelmedia.png'; ?>" alt="Reelmedia Logo" >
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
				<ul class="nav">
					<?php if(isset(Yii::app()->user->education_plan) && Yii::app()->user->education_plan!=1): ?>
					<li>
						<a href="<?=Yii::app()->createUrl("home/index");?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("home/print");?>" title="Stories"><i class="fa fa-lg fa-fw fa-pencil"></i> <span class="menu-item-parent">Stories</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("home/journalist");?>" title="Media Stories"><i class="fa fa-lg fa-fw fa-microphone"></i> <span class="menu-item-parent">Media Stories</span></a>
					</li>
					<?php if(Yii::app()->user->usertype!='agency') : ?>
						<li>
							<a href="<?=Yii::app()->createUrl("stories/classified");?>" title="Stories"><i class="fa fa-lg fa-fw fa-bullhorn"></i> <span class="menu-item-parent">Classified Stories</span></a>
						</li>
						<li>
							<a href="<?=Yii::app()->createUrl("stories/online");?>" title="Stories"><i class="fa fa-lg fa-fw fa-comments"></i> <span class="menu-item-parent">Online Stories</span></a>
						</li>
					<?php endif; ?>
					<?php if(Yii::app()->user->usertype=='agency' && Yii::app()->user->company_id==2 ) : ?>
						<li>
							<a href="<?=Yii::app()->createUrl("stories/classified");?>" title="Stories"><i class="fa fa-lg fa-fw fa-bullhorn"></i> <span class="menu-item-parent">Classified Stories</span></a>
						</li>
						<li>
							<a href="<?=Yii::app()->createUrl("stories/advancedsearch");?>" title="Stories"><i class="fa fa-lg fa-fw fa-anchor"></i> <span class="menu-item-parent">Advanced Search</span></a>
						</li>
						<!-- <li>
							<a href="<?//=Yii::app()->createUrl("stories/booleansearch");?>" title="Stories"><i class="fa fa-lg fa-fw fa-search"></i> <span class="menu-item-parent">Boolean Search</span></a>
						</li> -->
					<?php endif; ?>
					<li>
						<a href="<?=Yii::app()->createUrl("archive/index");?>" title="Print Archive"><i class="fa fa-lg fa-fw fa-file-archive-o"></i> <span class="menu-item-parent">Print Archive</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("radiotv/index");?>" title="Radio/TV"><i class="fa fa-lg fa-fw fa-file-image-o"></i> <span class="menu-item-parent">Radio/TV</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("industryreports/mentions");?>" title="Industry Reports"><i class="fa fa-lg fa-fw fa-file-text"></i> <span class="menu-item-parent">Industry Reports</span></a>
					</li>
					<li>
						<a href="<?=Yii::app()->createUrl("csr/index");?>" title="Stories"><i class="fa fa-lg fa-fw fa-heart"></i> <span class="menu-item-parent">CSR</span></a>
					</li>
					<?php if(Yii::app()->user->usertype=='agency'){ ?>
					<li>
						<a href="#" title="User Management"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">User Management</span></a>
						<ul>
							<li><a href="<?=Yii::app()->createUrl("account/users");?>">Staff Management</a></li>
							<li><a href="<?=Yii::app()->createUrl("account/companies");?>">Clients</a></li>
						</ul>
					</li>
					<?php } ?>
					<?php endif; ?>
					<?php if(isset(Yii::app()->user->education_plan) && Yii::app()->user->education_plan==1): ?>
					<li>
						<a href="<?=Yii::app()->createUrl("home/index");?>" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Educator Plan</span></a>
					</li>
					<?php endif; ?>
					<li>
						<a href="<?=Yii::app()->createUrl("account/index");?>" title="My Account"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">My Account</span></a>
					</li>

				</ul>
			</nav>
			<span class="minifyme" id="slideopen"><i class="fa fa-arrow-circle-left hit" style="margin-top:4px;"></i></span>
		
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
<script>
  !function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
  arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
  d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
  insertBefore(d,q)}(window,document,'script','_gs');

  _gs('GSN-097805-I');
</script>
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
function SetMinified(){
    var view = 'minified';
    $.post("../site/minified", {"view": view}, function(results) {
        // $('#slideopen').html(results);
    });
}
$(document).ready(function(){
	$("#slideopen").click(function(){
		SetMinified();
	});
});
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125781802-4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-125781802-4');
</script>
