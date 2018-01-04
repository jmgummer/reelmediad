<?php
$this->pageTitle=Yii::app()->name.' | Industry Reports';
$this->breadcrumbs=array('Industry Reports'=>array('industryreports/index'), 'Number of Mentions'=>array('industryreports/mentions'));
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionCharts.js'; ?>"></script>
<script language="JavaScript" src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionChartsExportComponent.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-3">
<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
<?php

$report_identifier = array();
if(isset($_POST['StorySearch'])){
    $model->attributes=$_POST['StorySearch'];
    $client = $model->company;
    $csql = 'SELECT company_name, backdate from company WHERE company_id ='.$client;
    $company_words = Company::model()->findBySql($csql);
    $backdate = $company_words->backdate;
    $company = $company_words->company_name;
    $narrative = 'Number of '.$company.' stories in ';

    $model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $_POST['StorySearch']['startdate'])));
    $model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $_POST['StorySearch']['enddate'])));

    $startdate = $model->startdate;
    $enddate = $model->enddate;

    $industry = implode(',', $model->industry);
    $inda=array();
    foreach ($model->industry as $key) {
        $indas = Industry::model()->find('Industry_ID=:a',array(':a'=>$key))->Industry_List;
        $inda[] = $indas;
    }
    $inda_text = implode(', ', $inda);
    $narrative .= $inda_text.' Between ';
    $drange = date('d-M-Y',strtotime(str_replace('-', '/', $startdate))).' and '.date('d-M-Y',strtotime(str_replace('-', '/', $enddate)));
    $narrative .= $drange;
    if(isset($model->industryreports) && !empty($model->industryreports)){
        foreach ($model->industryreports as $report_id) {
            $report_identifier[]= $report_id;
        }
    }
    
    $setindustry = implode(',', $_POST['StorySearch']['industry']);

    echo '<div class="widget-body">
    <ul id="tabs" class="nav nav-tabs bordered">';
    $active_tab = $report_identifier[0];
    foreach ($report_identifier as $report_header) {
        $tab_id = $report_header;
        if($tab_id==1){ $report_name = 'Number of Mentions';}
        if($tab_id==2){ $report_name = 'AVE';}
        if($tab_id==3){ $report_name = 'Share of Voice/Ink - By Media Type';}
        if($tab_id==4){ $report_name = 'Share of Voice/Ink - By Mentions';}
        if($tab_id==5){ $report_name = 'Share of Voice/Ink - By AVE';}
        if($tab_id==6){ $report_name = 'Categories Mentioned';}
        if($tab_id==7){ $report_name = 'Pictures & File Footage';}
        if($tab_id==8){ $report_name = 'Tonality';}
        if($tab_id==$active_tab){
            echo '<li class="active"><a href="#'.$tab_id.'" data-toggle="tab">'.$report_name.'</a></li>';
        }else{
            echo '<li><a href="#'.$tab_id.'" data-toggle="tab">'.$report_name.'</a></li>';
        }
    }
    echo '</ul>';
    echo '<div id="myTabContent1" class="tab-content padding-10">';
	
  foreach ($report_identifier as $repkey) {
    switch ($repkey) {
      /* Load the Mentions Report */
      case 1:
        if($active_tab==1){
            echo '<div class="tab-pane fade active in" id="1">';
        }else{
            echo '<div class="tab-pane fade" id="1">';
        }
        // $setindustries = implode(',', $model->industry);
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry,$backdate);
        $ctotal = IndustryQueries::GetCompanyMentions($client,$startdate,$enddate,$industry,$backdate);
        $ttotal = $total - $ctotal;
        echo '<p>This simply gives an aggregate of the total number of stories that appeared in the media about your organisation or topic of interest being monitored. If the subscriber is interested in industry mentions, the report will aggregate the total number of stories for the industry and indicate which stories were about ´myself´ and how many were for the ´others´. The number of mentions is also reported by distribution by media-house.</p>';
        $chart_name = 'Number_of_Mentions';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($client,$narrative, $company, 'Others', $ctotal, $ttotal,$backdate,$startdate,$enddate,$setindustry);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the AVE Report */
      case 2:
        if($active_tab==2){
            echo '<div class="tab-pane fade active in" id="2">';
        }else{
            echo '<div class="tab-pane fade" id="2">';
        }
        $avtotal = IndustryQueries::GetCompanyAve($client,$startdate,$enddate,$industry,$backdate);
        $avttotal = IndustryQueries::GetAllCompanyAve($client,$startdate,$enddate,$industry,$backdate);
        $chart_name = 'AVE';
        echo '<p>Ad Value Equivalent (AVE) is a measuring tool that calculates the value of the ´space´ or ´air-time´ used for a story on the basis of the rate-card of the particular media house. The value derived thus is calculated on the same basis an Ad of similar page coverage or air play placed on the same page or time segment would. AVE compares the subscriber´s values to those of other players in the industry if the subscription includes competitors or the entire industry.</p>';
        $avnarrative = $company.' AVE in '.$inda_text.' Between '.$drange;
        $ctext ='My Ave(Kshs.'.number_format($avtotal).')';
        $otext = 'Others (Kshs.'.number_format($avttotal).')';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($client,$avnarrative, $ctext,$otext, $avtotal, $avttotal,$backdate,$startdate,$enddate,$industry);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By Media Type Report */
      case 3:
        if($active_tab==3){
            echo '<div class="tab-pane fade active in" id="3">';
        }else{
            echo '<div class="tab-pane fade" id="3">';
        }
        $tv = IndustryQueries::GetShareVoiceMediaTV($client,$startdate,$enddate,$industry,$backdate);
        $radio = IndustryQueries::GetShareVoiceMediaRadio($client,$startdate,$enddate,$industry,$backdate);
        $print = IndustryQueries::GetShareVoiceMediaPrint($client,$startdate,$enddate,$industry,$backdate);
        $total = $tv+$radio+$print;
        $chart_name = 'Share_By_Media_Type';
        echo '<p>Of the total number of stories that appeared, how many were in print and how many were on electronic media. This report will simply show the type of media where your PR activity is most visible.</p>';
        $svmnarrative = $company.' Share of Voice - By Media Type in '.$inda_text.' Between '.$drange;
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $xAxisName = 'Media';
        $yAxisName = 'Number of Mentions';
        $strXML = FusionCharts::packageColumnXML($client,$svmnarrative,$tv,$radio,$print,$total,$xAxisName,$yAxisName,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Column2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By Mentions */
      case 4:
        if($active_tab==4){
            echo '<div class="tab-pane fade active in" id="4">';
        }else{
            echo '<div class="tab-pane fade" id="4">';
        }
        $chart_name = 'Share_By_Mentions';
        echo '<p>This report compares your company´s mentions to those of the top 10 companies in your industry</p>';
        $svm2narrative = $company.' Share of Voice - By Mentions Top Performers in '.$inda_text.' Between '.$drange;
        // Get Array of Companies
        $wol = IndustryQueries::GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        // echo $client ;echo $svm2narrative;echo $company;echo  $startdate;echo $enddate;echo $industry;echo $backdate ;
        $strXML = FusionCharts::packageMentionsXML($client,$svm2narrative, $wol,$company, $startdate,$enddate,$industry,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By AVE */
      case 5:
        if($active_tab==5){
            echo '<div class="tab-pane fade active in" id="5">';
        }else{
            echo '<div class="tab-pane fade" id="5">';
        }
        $chart_name = 'Share_By_AVE';
        echo '<p>This report compares your AVE to those of the top 10 companies in your industry</p>';
        $svm3narrative = $company.' Share of Voice - By AVE Top Performers in '.$inda_text.' Between '.$drange;
        // Get Array of Companies
        $aol = IndustryQueries::GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageAVEMentionsXML($client,$svm3narrative, $aol,$company, $startdate,$enddate,$industry,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Categories Mentioned Report */
      case 6:
        if($active_tab==6){
            echo '<div class="tab-pane fade active in" id="6">';
        }else{
            echo '<div class="tab-pane fade" id="6">';
        }
        $chart_name = 'Categories_Mentioned';
        echo '<p>This part of the report highlights the segments on which mentions appeared. Categories here include General News, Business News, Commentaries, Special Features, Sports News and Letters. The report will compare the distribution of mentions based on these segments. </p>';
        $svm4narrative = $company.' Share of Voice - By AVE Top Performers in '.$inda_text.' Between '.$drange;
        // Get the Array of Categories
        $cats = IndustryQueries::GetCategories();
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageCATMentionsXML($client,$svm4narrative, $cats, $startdate,$enddate,$industry,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Pictures & File Footage Report */
      case 7:
        if($active_tab==7){
            echo '<div class="tab-pane fade active in" id="7">';
        }else{
            echo '<div class="tab-pane fade" id="7">';
        }
        $chart_name = 'Pictures_File_Footage';
        echo '<p>This report compares the number of stories that contained pictures (for print stories) and file footage (Electronic Stories) to those that did not contain any. Pictures are a powerful medium of communication and as the saying goes ´a picture is worth a thousand words´. Of the total number of stories that appeared, how many were about ´myself´ and how many were about each of the ´others´ in my industry.</p>';
        $pnarrative = $company.' Stories with Pictures in '.$inda_text.' Between '.$drange;
        $cats = IndustryQueries::GetPictures();
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packagePICMentionsXML($client,$pnarrative, $cats, $startdate,$enddate,$industry,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Tonality Report */
      case 8:
        if($active_tab==8){
            echo '<div class="tab-pane fade active in" id="8">';
        }else{
            echo '<div class="tab-pane fade" id="8">';
        }
        $chart_name = 'Tonality';
        echo '<p>Of the total number of media mentions, how many stories were positive, negative and neutral. This report will give an analysis indicating Positive, Negative and Neutral tonality of the stories over a period. This report can further drill down and aggregate tonality by Media-Houses. </p>';
        $tnarrative = 'Tonality of '.$company.' in '.$inda_text.' Between '.$drange;
        $tons = IndustryQueries::GetTonality($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageTonMentionsXML($client,$tnarrative, $tons, $startdate,$enddate,$industry,$backdate);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Default Report - Mentions */
      default:
        echo '<div class="tab-pane fade active in" id="3">';
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry,$backdate);
        $ctotal = IndustryQueries::GetCompanyMentions($client,$startdate,$enddate,$industry,$backdate);
        $ttotal = $total - $ctotal;
        $chart_name = 'default';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company,'Others', $ctotal, $ttotal,$backdate,$startdate,$enddate,$industry);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        echo '</div>';
        break;
    }
  }
echo '</div>';
echo '</div>';
}
?>
    
	</div>
</div>

<style type="text/css">
#content{
	height: 100%;
}
</style>
