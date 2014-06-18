<?php
$this->pageTitle=Yii::app()->name.' | Industry Reports';
$this->breadcrumbs=array('Industry Reports'=>array('industryreports/index'), 'Number of Mentions'=>array('industryreports/mentions'));
?>
<script src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionCharts.js'; ?>"></script>
<script language="JavaScript" src="<?php echo Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/FusionChartsExportComponent.js'; ?>"></script>
<div class="row-fluid clearfix">
<div class="col-md-3">
<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
<?php
  $report_identifier = array();
  $company = Yii::app()->user->company_name;
  $narrative = 'Number of '.$company.' stories in ';
  if(isset($_POST['StorySearch'])){
    $model->attributes=Yii::app()->input->stripClean($_POST['StorySearch']);
    $model->startdate = date('Y-m-d',strtotime(str_replace('-', '/', $model->startdate)));
    $model->enddate = date('Y-m-d',strtotime(str_replace('-', '/', $model->enddate)));

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
  }else{
    $report_identifier[] = 1;
    $industry = $model->industry;
    $startdate = $model->startdate;
    $enddate = $model->enddate;
    $indas = Industry::model()->find('Industry_ID=:a',array(':a'=>$industry))->Industry_List;
    $narrative .= $indas.' Between ';
    $drange = date('d-M-Y',strtotime(str_replace('-', '/', $startdate))).' and '.date('d-M-Y',strtotime(str_replace('-', '/', $enddate)));
    $narrative .= $drange;
  }
	
  foreach ($report_identifier as $repkey) {
    switch ($repkey) {
      /* Load the Mentions Report */
      case 1:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        echo '<h3>Number of Mentions</h3>';
        $chart_name = 'Number_of_Mentions';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company, 'Others', $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the AVE Report */
      case 2:
        $avtotal = IndustryQueries::GetCompanyAve(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $avttotal = IndustryQueries::GetAllCompanyAve(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $chart_name = 'AVE';
        echo '<h3>AVE</h3>';
        $avnarrative = $company.' AVE in '.$inda_text.' Between '.$drange;
        $ctext ='My Ave(Kshs.'.number_format($avtotal).')';
        $otext = 'Others (Kshs.'.number_format($avttotal).')';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($avnarrative, $ctext,$otext, $avtotal, $avttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By Media Type Report */
      case 3:
        $tv = IndustryQueries::GetShareVoiceMediaTV(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $radio = IndustryQueries::GetShareVoiceMediaRadio(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $print = IndustryQueries::GetShareVoiceMediaPrint(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $total = $tv+$radio+$print;
        $chart_name = 'Share_By_Media_Type';
        echo '<h3>Share of Voice/Ink - By Media Type</h3>';
        $svmnarrative = $company.' Share of Voice - By Media Type in '.$inda_text.' Between '.$drange;
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $xAxisName = 'Media';
        $yAxisName = 'Number of Mentions';
        $strXML = FusionCharts::packageColumnXML($svmnarrative,$tv,$radio,$print,$total,$xAxisName,$yAxisName);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Column2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By Mentions */
      case 4:
        $chart_name = 'Share_By_Mentions';
        echo '<h3>Share of Voice/Ink - By Mentions</h3>';
        $svm2narrative = $company.' Share of Voice - By Mentions Top Performers in '.$inda_text.' Between '.$drange;
        $wol = IndustryQueries::GetShareVoiceIndustry(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageMentionsXML($narrative, $wol,$company, $startdate,$enddate,$industry);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By AVE */
      case 5:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        $chart_name = 'Share_By_AVE';
        echo '<h3>Share of Voice/Ink - By AVE</h3>';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company, $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Categories Mentioned Report */
      case 6:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        $chart_name = 'Categories_Mentioned';
        echo '<h3>Categories Mentioned</h3>';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company, $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Pictures & File Footage Report */
      case 7:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        $chart_name = 'Pictures_File_Footage';
        echo '<h3>Pictures & File Footage</h3>';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company, $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Tonality Report */
      case 8:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        $chart_name = 'Tonality';
        echo '<h3>Tonality</h3>';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company, $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
      /* Load the Default Report - Mentions */
      default:
        $total = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry);
        $ctotal = IndustryQueries::GetCompanyMentions(Yii::app()->user->company_id,$startdate,$enddate,$industry);
        $ttotal = $total - $ctotal;
        $chart_name = 'default';
        echo '<h3>Default</h3>';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $strXML = FusionCharts::packageXML($narrative, $company,'Others', $ctotal, $ttotal);
        $charty = new FusionCharts;
        echo FusionCharts::renderChart(Yii::app()->request->baseUrl . '/FusionCharts/FusionCharts/FusionCharts/Pie2D.swf', "", $strXML, $chart_name, 600, 300, false, true, true);
        echo '</div>';
        break;
    }
  }
    
  ?>
    
	</div>
</div>

<style type="text/css">
#content{
	height: 100%;
}
</style>
