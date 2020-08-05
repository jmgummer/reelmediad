<?php
$this->pageTitle=Yii::app()->name.' | Industry Reports';
$this->breadcrumbs=array('Industry Reports'=>array('industryreports/index'), 'Number of Mentions'=>array('industryreports/mentions'));
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.css'; ?>"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.plugin.js'; ?>"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/datepick/jquery.datepick.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/myscripts.js'; ?>"></script>


<div class="row-fluid clearfix">
<div class="col-md-3">
<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">
<?php
        $svm3narrative='';
        $svm2narrative='';
        $mention_value='';
        $share_ink_ave='';
        $mention_ave = '';
        $ton = '';
        $tonalities = '';
        $ton_values = '';
        $cats_values = '';
        $cat_men = '';
        $number_tonality = '';
        $tonality = '';
        $footage = '';
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
        $cothers = 'others'. ',' . "( $ttotal Mentions  )";
        $mine = "$company". ',' . " ( $ctotal Mentions )" ;
        //Mention Highchart DIV
        echo "<div id='mentions' style='height: 400px'></div>";
        echo '</div>';
        echo '</div>';
        ?>
        <script type="text/javascript">
            var ctotal = <?php echo json_encode($ctotal)?>;
            var ttotal = <?php echo json_encode($ttotal) ?>;
            var mine = <?php echo json_encode($mine) ?>;
            var others = <?php echo json_encode($cothers) ?>;
            var narrative = <?php echo json_encode($narrative) ?>;
        </script>
        <?php
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
        
        //Highchart DIV
        echo "<div id='AVE' style='height: 400px'></div>";
        echo '</div>';
        echo '</div>';
        ?>
            <script type="text/javascript">
            var avtotal = <?php echo json_encode($avtotal)?>;
            var avttotal = <?php echo json_encode($avttotal) ?>;
            var ctext = <?php echo json_encode($ctext) ?>;
            var otext = <?php echo json_encode($otext) ?>;
            var avnarrative = <?php echo json_encode($avnarrative) ?>;
            </script>
        <?php
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

            $radio_total      = $radio;
            $tv_total          = $tv;
            $print_total      = $print;
        
        

                //Load the Share of Voice/Ink - By Media Type Report highchart
        echo "
       <div id='share_voice_media' style='height: 400px'></div>
        ";
       ?>
                   <!--  scripts here -->
            <script type="text/javascript">
                var radio_total = <?php echo json_encode($radio_total); ?>;
                var total = <?php echo json_encode($total); ?>;
                var tv_total = <?php echo json_encode($tv_total) ?>;
                var print_total = <?php echo json_encode($print_total) ?>;
                var svmnarrative = <?php echo json_encode($svmnarrative) ?>;

            </script>
       <?php
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By Mentions */
      case 4:
      $count = 0;
        if($active_tab==4){
            echo '<div class="tab-pane fade active in" id="4">';
        }else{
            echo '<div class="tab-pane fade" id="4">';
        }
        $chart_name = 'Share_By_Mentions';
        echo '<p>This report compares your company´s mentions to those of the top 20 companies in your industry</p>';
        $svm2narrative = $company.' Share of Voice - By Mentions Top 20 Performers in '.$inda_text.' Between '.$drange;
        // Get Array of Companies
        $wol = IndustryQueries::GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $mentions = "";
        $count =  0;
        foreach ($wol as  $value) {
            
             $array = array_values($value);
             //echo "<pre>".print_r($array,true)."</pre>";
             $company = "$array[1]";
             $No_of_mentions = "$array[0]";
             $mentions .= "[\"$company\" , $No_of_mentions]," ;//echo "<pre>".print_r($mentions,true)."</pre>";
             //$comboClass[] = $mentions;
              if($count == 20){
                break;
            }   
            $count++;
               
            }
           //$mention_value = implode(' , ', $comboClass);
            $mention_value = rtrim($mentions, ",");

            //Load the Share of Voice/Ink - By Media Type Report highchart
        echo"<div id='share_voice_mention' style='height: 400px'></div>";
        ?>
        <script type="text/javascript">
     
        </script>
        <?php
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Share of Voice/Ink - By AVE */
      case 5:
      $count = 0;
      $company = $company_words->company_name;
        if($active_tab==5){
            echo '<div class="tab-pane fade active in" id="5">';
        }else{
            echo '<div class="tab-pane fade" id="5">';
        }
        $chart_name = 'Share_By_AVE';
        echo '<p>This report compares your AVE to those of the top 20 companies in your industry</p>';
        $svm3narrative = $company.' Share of Voice - By AVE Top 20 Performers in '.$inda_text.' Between '.$drange;
        // Get Array of Companies
        $aol = IndustryQueries::GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
       $count = 1;
        $othersvalue = 0;
        $mentions_va2 = '';
        foreach ($aol as $key) {
            $co_name2 = $key['company_name'];
            $co_value2 = IndustryQueries::GetCompanyAve($key['client_id'],$startdate,$enddate,$industry,$backdate);
            //echo "<pre>".print_r($co_name2 ."=". $co_value2,true). "</pre>";
             $mentions_va2 .= "[\"$co_name2 , ".Conversions::number_format_short( $co_value2)." \" , $co_value2]," ;
            if($count == 20){
                break;
            }   
            $count++;
        }
        $mention_ave = rtrim($mentions_va2, ",");
         echo "<div id='share_ave' style='height: 400px'></div>";
        //echo "$mention_ave";
?>
        <script type="text/javascript">
             var svm3narrative = <?php echo json_encode($svm3narrative); ?>
        </script>
         <?php
          //Pie Chart
          echo "<div id ='share_ave' style='height: 400px'></div>";
        echo '</div>';
        echo '</div>';
        break;
        
      /* Load the Categories Mentioned Report */
      case 6:
      $company = $company_words->company_name;
        if($active_tab==6){
            echo '<div class="tab-pane fade active in" id="6">';
        }else{
            echo '<div class="tab-pane fade" id="6">';
        }
        $chart_name = 'Categories_Mentioned';
        echo '<p>This part of the report highlights the segments on which mentions appeared. Categories here include General News, Business News, Commentaries, Special Features, Sports News and Letters. The report will compare the distribution of mentions based on these segments. </p>';
        $svm4narrative = $company.' Mentions  in '.$inda_text.' Between '.$drange;
        // Get the Array of Categories
        $cats = IndustryQueries::GetCategories();
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
          foreach ($cats as $key) {
            $category = $key->Category_ID;
           // echo "<pre>".print_r($key,true)."</pre>";
            $number = IndustryQueries::GetCatCount($client,$startdate,$enddate,$industry,$category,$backdate);
           
            if ($number > 0) {
                $cat_name = $key->Category_List;
                
               
               $cat_men .= "[\"$cat_name, $number mentions\" , $number]," ;
         }
         ?>
        <script type="text/javascript">
             var svm4narrative = <?php echo json_encode($svm4narrative); ?>
        </script>
         <?php
          $cats_values = rtrim($cat_men, ",");
        
        }
         echo "<div id ='category' style='height: 400px'></div>";
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Pictures & File Footage Report */
      case 7:
      $company = $company_words->company_name;
        if($active_tab==7){
            echo '<div class="tab-pane fade active in" id="7">';
        }else{
            echo '<div class="tab-pane fade" id="7">';
        }
        $chart_name = 'Pictures_File_Footage';
        echo '<p>This report compares the number of stories that contained pictures (for print stories) and file footage (Electronic Stories) to those that did not contain any. Pictures are a powerful medium of communication and as the saying goes ´a picture is worth a thousand words´. Of the total number of stories that appeared, how many were about ´myself´ and how many were about each of the ´others´ in my industry.</p>';
        $pnarrative = $company.' Stories with Pictures in '.$inda_text.' Between '.$drange;
        $pic_cats = IndustryQueries::GetPictures();
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        foreach ($pic_cats as $keys) {
            //echo "<pre>".print_r($keys,true)."</pre>";
            $pic_name = $keys->picture;
            $pic_value = IndustryQueries::GetPicCount($client,$startdate,$enddate,$industry,$pic_name,$backdate);
            $footage.= "[\"$pic_name, $pic_value\" , $pic_value]," ;
        }
         ?>
        <script type="text/javascript">
             var pnarrative = <?php echo json_encode($pnarrative); ?>
        </script>
         <?php
       echo "<div id ='footage' style='height: 400px'></div>";
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
        $tons= IndustryQueries::GetTonality($client,$startdate,$enddate,$industry,$backdate);
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        foreach ($tons as $tonality) {//echo "<pre>".print_r($tonality,true)."</pre>";
             $ton_array = array_values($tonality);
             $tonality_num = "$ton_array[1]";
             $name_tonality = "$ton_array[0]";
             $tonalities .= "[\"$tonality_num\" , $name_tonality]," ;
         }
          $ton_values = rtrim($tonalities, ",");
        //Mention Highchart DIV
        echo "<div id='tonality' style='height: 400px'></div>";
        
       // echo "$ton_values";
        ?>
        <script type="text/javascript">
            var tnarrative = <?php echo json_encode($tnarrative)?>;

            
        </script>
        <?php
        echo '</div>';
        echo '</div>';
        break;
      /* Load the Default Report - Mentions */
      default:
        echo '<div class="tab-pane fade active in" id="3">';
        $total1 = IndustryQueries::GetAllCompanyMentions($startdate,$enddate,$industry,$backdate);
        $ctotal1 = IndustryQueries::GetCompanyMentions($client,$startdate,$enddate,$industry,$backdate);
        $ttotal1 = $total1 - $ctotal1;
        $chart_name = 'default';
        echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
         echo '<div style="padding:0px; background-color:#fff; border:0px solid #745C92; width: 100%;">';
        $cothers1 = 'others'. ',' . "( $ttotal Mentions  )";
        $mine1 = "$company". ',' . " ( $ctotal Mentions )" ;
        //Mention Highchart DIV
        echo "<div id='default' style='height: 400px'></div>";
        echo '</div>';
        echo '</div>';
        ?>
        <script type="text/javascript">
            var ctotal1 = <?php echo json_encode($ctotal)?>;
            var ttotal1 = <?php echo json_encode($ttotal) ?>;
            var mine1 = <?php echo json_encode($mine) ?>;
            var others1 = <?php echo json_encode($cothers) ?>;
        </script>
        <?php
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
<script type="text/javascript">

                                        //ave
Highcharts.chart('AVE', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: avnarrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: true
    }
  },
  
    series: [{
        name: 'AVE',
        colorByPoint: true,
        data:[
        [ ctext, avtotal],[ otext, avttotal]

        ]
      
    }]
});
//Number of Mentions

Highcharts.chart('mentions', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: narrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: true
    }
  },
  
    series: [{
        name: 'Number of Mentions',
        colorByPoint: true,
        data:[
        [ mine, ctotal],[ others, ttotal]

        ]
      
    }]
});
//share of voice/ink by media type
Highcharts.chart('share_voice_media', {
  chart: {
    type: 'column'
  },
  title: {
    text: svmnarrative
  },
  xAxis: {
    type: 'category',
     title: {
      text: 'Media'
    }

  },
  yAxis: {
    title: {
      text: 'Number of Mentions'
    }

  },
  legend: {
    enabled: true
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y:.0f} Stories'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} of '+total+'</b><br/>'
  },

  "series": [
    {
      "name": "Share of Voice/Ink - By Media Type Report",
      "colorByPoint": true,
      "data": [
        {
          "name": "Radio",
          "y": radio_total,
          "drilldown": "Tv"
        },
        {
          "name": "TV",
          "y": tv_total,
          "drilldown": "Print"
        },
        {
          "name": "Print",
          "y": print_total,
          "drilldown": "Radio"
        },{
          "name": "<b>Total</b>",
          "y": total,
          "drilldown": "Total"
        },
        
      ]
    }
  ]});
                                            //Share of Voice/Ink - By Mentions
                                            
Highcharts.chart('share_voice_mention', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: <?php echo json_encode("$svm2narrative"); ?>
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: false
    }
  },
  
    series: [{
        name: 'Share of Voice/Ink - By Mentions',
        colorByPoint: true,
        data: [<?php echo $mention_value; ?>]
      
    }]
});                                            
                                        //categories Mentioned
                                            
Highcharts.chart('category', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: svm4narrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: true
    }
  },
  
    series: [{
        name: 'Categories Mentioned',
        colorByPoint: true,
        data: [<?php echo $cats_values; ?>]
      
    }]
});
                                                            //share of voice/ink by AVE
                                            
Highcharts.chart('share_ave', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: svm3narrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: false
    }
  },
  
    series: [{
        name: 'share of voice/ink by AVE',
        colorByPoint: true,
        data: [<?php echo $mention_ave; ?>]
      
    }]
}); 
                                                            //Pictures And File Footage
                                            
Highcharts.chart('footage', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: pnarrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: false
    }
  },
    series: [{
        name: 'Pictures And File Footage',
        colorByPoint: true,
        data: [<?php echo $footage; ?>]
      
    }]
});                                           //Tonality
                                            
Highcharts.chart('tonality', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: tnarrative
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: false
    }
  },
  
    series: [{
        name: 'Tonality',
        colorByPoint: true,
        data: [<?php echo "$ton_values"; ?>]
      
    }]
});
                                                //default
//default

Highcharts.chart('default', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
    title: {
        text: 'Default'
    }, tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      },
      showInLegend: true
    }
  },
  
    series: [{
        name: 'Number of Mentions',
        colorByPoint: true,
        data:[
        [ mine1, ctotal1],[ others1, ttotal1]

        ]
      
    }]
});
</script>