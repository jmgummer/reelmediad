<?php
$this->pageTitle=Yii::app()->name.' | Online Stories';
$this->breadcrumbs=array('Online Stories');
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<div class="row-fluid clearfix">
	<?php
	$todays = date('Y-m-d');
	$clientid = Yii::app()->user->company_id;
	$c_sql = "SELECT * FROM company WHERE company_id=$clientid";
	if($company_words = Company::model()->findBySql($c_sql)){
		$rmcompanyname = $company_words->company_name;
	}

	
	$c_sql = "SELECT * FROM companies WHERE reelmedia_id=$clientid";
	$onlinecompany = OnlineCompanies::model()->findBySql($c_sql);
	if($onlinecompany){
		echo '<div class="col-md-3">';
		$this->renderPartial('online_filter',array('model'=>$model,'onlinecompany'=>$onlinecompany));
		echo '</div>';
		echo '<div class="col-md-9">';

		echo '<div class="widget-body">
		<ul id="myTab1" class="nav nav-tabs bordered">
		<li class="active"><a href="#s4" data-toggle="tab">Classified Stories</a></li>
		<li class="pull-right">
		<a href="javascript:void(0);">
		<div class="sparkline txt-color-pinkDark text-align-right" data-sparkline-height="18px" data-sparkline-width="90px" data-sparkline-barwidth="7"><canvas width="52" height="18" style="display: inline-block; width: 52px; height: 18px; vertical-align: top;"></canvas></div> </a>
		</li>
		</ul>';
		echo '<div id="myTabContent1" class="tab-content padding-10">';
		echo '<div class="tab-pane fade active in" id="s4">';
		$search = $model->search_text;
		if(!empty($search)){
			$searchqry = " AND ( (title like '%$search%') OR (mentiontext like '%$search%') OR (source like '%$search%') ) ";
		}else{
			$searchqry = " ";
		}
		$companyid = $onlinecompany->id;
		$companyname = $rmcompanyname;
		$startdate = date("Y-m-d", strtotime($model->startdate));
		$enddate = date("Y-m-d", strtotime($model->enddate));
		$reportperiod = $startdate." - ".$enddate;
		$source = $model->storytype;
		$classification = $model->industry;
		if(is_array($classification)){
			$cls_list = implode(',', $classification);
		}else{
			$cls_list = $classification;
		}
		if($source=='all'){
		    $sourceqry = " ";
		}else{
		    $sourceqry = " AND source='$source'";
		}
		$sql = "SELECT DISTINCT title, mentiondate,tonality,permalink,mentiontext,author,source,facebook_likes,twitter_followers,theme,keywords,companyid FROM rankurmentions WHERE companyid=$companyid $sourceqry $searchqry AND (mentiondate BETWEEN '$startdate' AND '$enddate') AND theme IN ($cls_list) GROUP BY title, permalink";
		if($mentions = Rankurmentions::model()->findAllBySql($sql)){
		    $recordcount = count($mentions);
		    echo "[$recordcount] Records Found<br>";
		    $excelfile = ExcelResults::OnlineExcel($mentions,$companyname,$reportperiod);
		    echo '<p><strong><a href="'.Yii::app()->request->baseUrl . '/docs/excel/'.$excelfile.'"><i class="fa fa-file-excel-o"></i> Download Excel File</a></strong></p>';

		    $tableres = new ResultsParser;
		    $table = $tableres->CreateDataTable($mentions);
		    echo $table;
		}else{
		    echo "No Records Found";
		}
		echo '</div>';

		echo '</div>';
		echo '</div>';

		echo '</div>';
	}else{
		echo "<p style='color:Red'>You are not subscribed to this product, Please get in Touch with your Client Service Representative</p>";
	}
	?>

<?php  ?>


</div>



<style type="text/css">
.radio label{
	/*font-weight: bold;*/
	/*margin-left: -10px;*/
}
.search-params{
	padding: 10px 13px;
	clear: both;
}
.pdf-excel{
	margin: 5px 1px;
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