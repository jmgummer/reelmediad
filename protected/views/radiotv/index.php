<?php
$this->pageTitle=Yii::app()->name.' | Radio/TV';
$this->breadcrumbs=array('Radio/TV Reports'=>array('radiotv/index'), 'Radio/TV');
?>
<div class="row-fluid clearfix">
<div class="col-md-3">
	<?php $this->renderPartial('search_filter',array('model'=>$model)); ?>
</div>
<div class="col-md-9">

<?php

$todaysdate=date("Y-m-d");
if(isset($_POST['StorySearch'])){
	$search = $model->search_text;
	$beginning = $model->startdate;
	$ending = $model->enddate;
	$media_code = $media_house_id = $model->publications;
	// Initialize Empty Variables
	$query = '';
	$full_query = '';
	
	$my_query_words = '';
	$url_query = '';
	$full_query2 = '';
	$display_search ='';
	$narrative = '';

	if(!empty($search)){
	    $display_search=$search=trim($search);
	    $search_phrase=$search=str_replace("  "," ",$search);   $search=str_replace("  "," ",$search);
	    $strings=explode(" ",$search);
	    $search_strings= count($strings);
	    $search2=str_replace(" ","%",trim($search));
	    $search2=" or story.mentioned like '%". $search2 . "%'  or story.Title like '%". $search2 . "%'";
	    $search=" ( (story.mentioned  like '% ".$search . " %' or story.Title  like '% ".$search . " %' )   $search2)";
	}

	// Formating Dates for Search

	$year_start 	= date('Y',strtotime($beginning));
	$month_start 	= date('m',strtotime($beginning));
	$day_start 		= date('d',strtotime($beginning));
	$year_end 		= date('Y',strtotime($ending));
	$month_end 		= date('m',strtotime($ending));
	$day_end 		= date('d',strtotime($ending));

	$mysearch=$search;
	// I'm not very sure why Sammy Used 2 Here, I drink Monster, I suspect he has something waaa..y better, HEHEHE
	$post_date='2';

	$display_keywords='';

	$difference = $day_end - $day_start;
	if ($difference < 0) { $difference = 0; }
	$number_of_days = floor($difference/60/60/24);

	//This is where we start the search

	//first we get the Company keywords
	if(Yii::app()->user->usertype=='agency'){
		$clientid = $model->company;
	}else{
		$clientid = Yii::app()->user->company_id;
	}
	$sql_mykeywords = Company::model()->find('company_id=:a', array(':a'=>$clientid));
	$backdate = $sql_mykeywords->backdate;
	$my_keywords=$sql_mykeywords->keywords;
	$my_subs=trim($sql_mykeywords->subs);

	$words=$my_keywords;
	$my_keywords=str_replace(", ",",",$my_keywords);
	$all_keywords=explode(",",$words);
	$all_keywords=array_filter($all_keywords);
	$all_my_keywords=array_unique($all_keywords);
	$all_my_keywords=array_unique($all_my_keywords);
	$my_keyword_count=count($all_keywords);

	for($x=0; $x<=$my_keyword_count; $x++)
	{
		if(isset($all_my_keywords[$x])){
			if(trim($all_my_keywords[$x])){
		        $all_my_keywords[$x]=trim($all_my_keywords[$x]);
		        $display_keywords.=$all_my_keywords[$x] . ", ";
		        $query.="story.mentioned like '% " . trim($all_my_keywords[$x]) . " %' or ";
		        $query.="story.mentioned like '% " . trim($all_my_keywords[$x]) . ", %' or ";
		        $query.="story.mentioned like '% " . trim($all_my_keywords[$x]) . ". %' or ";
		        $query.="story.Title like '% " . trim($all_my_keywords[$x]) . " %' or ";
		        $query.="story.Title like '% " . trim($all_my_keywords[$x]) . ", %' or ";
		        $query.="story.Title like '% " . trim($all_my_keywords[$x]) . ". %' or ";
		        $my_query_words.="'\"".trim($all_my_keywords[$x]) ."\"' ";
		    }
		}
	}


	$display_keywords=trim($display_keywords);
	if(substr($display_keywords,-1)==",") {
	 $display_keywords=substr($display_keywords,0,-1);
	}

	if($query) {
	        $query=" and (" . substr($query,0,-3) . " ) ";
	        $full_query=$full_query . $query;
	}

	for($x=0; $x<=$number_of_days; $x++) {
        $offset=$x*60*60*24;
        $day_from_start=$day_start+ $offset;
        $this_year = $year_start;
        $this_month = $month_start;
        $this_day= $day_start;
        $url_query.=" StoryDate like '%$this_year$this_month$this_day%'  or ";
	}

	$url_query=" StoryDate between '" . $year_start."-".$month_start."-".$day_start . "' and '" . $year_end."-".$month_end."-0".$day_end ."' ";

	$full_query=$full_query . " and StoryDate>'$backdate'";
	// $full_query2=$full_query2 . " and StoryDate>'$backdate'";

	//$url_query=substr($url_query,0,-3);
	if($url_query) {
	    $url_query=" and (" . $url_query. " ) ";
	    $full_query=$full_query . $url_query;
	    $full_query2=$full_query2 . $url_query;
	}

	if(     $mysearch || $search) {
		$full_query=$full_query . " and " . $search ;
		$full_query2=$full_query2 . " and " . $search ;
	}


	if(!empty($media_code)) {
		$full_query=$full_query . " and story.Media_House_ID =$media_code";
		$full_query2=$full_query2 . " and story.Media_House_ID =$media_code";
	}

	if (!$post_date){
	    $this_i_date="and StoryDate between '".$td_yyyy."-".$td_mm."-".$td_dd."' and  '".$td_yyyy."-".$td_mm."-".$td_dd."' "  ;
	    $year_start=$td_yyyy;
	    $month_start=$td_mm;
	    $day_start=$td_dd;
	    $year_start=$td_yyyy;
	    $month_start=$td_mm;
	    $day_start=$td_dd;
	    $display_date=" <strong>".$td_yyyy."-".$td_mm."-".$td_dd."</strong> and <strong>".$td_yyyy."-".$td_mm."-".$td_dd  ."</strong>";
	}

	if ($post_date==1){
	    $display_date= " <strong>".$newdate."</strong> and <strong>".$todaysdate ."</strong>";
	}

	if ($post_date==2){
	    $display_date=" <strong>".$beginning."</strong> and <strong>".$ending ."</strong>";
	}

	// Get The Publication Name for The Narrative
	if(!$media_code) {
	    $publication= "All Stations";
	} else {
		$publication = Mediahouse::model()->find('media_house_id=:a', array(':a'=>$media_code))->Media_House_List;
	}

	$narrative="<p style='font-size:11px;'>Searched <strong>$publication</strong> for the following keywords <strong>";
	if($display_search) {$narrative.='including '.$display_search;}
// 	$narrative.=" " .$display_keywords;
	$narrative.="</strong> between " .$display_date.'</p>';
	?>
	<div id="wid-id-0" class="jarviswidget jarviswidget-sortable"style="" role="widget">
		<header role="heading"><h2>Search Results</h2></header>
				
		<div class="reveal">
		<div id="chat-body" role="content">
			<div class="widget-body no-padding">
				<div class="force-padding">
				
					<?php
					echo $narrative;
					if($pieces = explode(",", $my_keywords)){
						foreach ($pieces as $mkey) {
							echo '<div class="col-md-3">'.$mkey.'</div>';
						}
					}
					?>
				</div>
			</div>
		</div>
		</div>
		<footer class="reveal-footer"><button class="btn btn-primary">View Keywords</button></footer>
	</div>
	
	<?php
	// Create Tables to Search From
	// echo $year_start;
	// echo $year_end;
	// echo $month_start;
	// echo $month_end;
	// echo $temp_table ="story_".$year_end.'_'.$month_end;
	$sql_industry="select  distinct(Story_ID), Title, mentioned,StoryDate,StoryTime,Media_House_ID,file_path,file,uniqueID from story where MATCH(Title,mentioned) AGAINST ($my_query_words IN BOOLEAN MODE ) ". $full_query2 ." and (Media_ID='mt01' or Media_ID='mr01') order by StoryDate  limit 10"  ;
	
	if($stories = Story::model()->findAllBySql($sql_industry)){
		$record_count = count($stories);
		echo $record_count.' Records Found';
		foreach ($stories as $key) {
			$format_date = date('D, F, Y', strtotime($key->StoryDate));
			echo '<h3><a href="http://www.reelforge.com/reelmedia/stream/video_stream.php?itemid='.$key->Story_ID.'&client_id='.Yii::app()->user->company_id.'&encryptid='.$key->uniqueID.'" target="_blank">'.$key->Title.'</a></h3>';
			echo '<p>'.$key->Publication.' : '.$format_date.''.$key->Page.'</p>';
			echo '<p><a href="http://www.reelforge.com/reelmedia/stream/video_stream.php?itemid='.$key->Story_ID.'&client_id='.Yii::app()->user->company_id.'&encryptid='.$key->uniqueID.'" target="_blank">View/Listen</a> </p>';
		}
	}else{
		echo '<p>No Records Found</p>';
	}


}else{
	echo '<h3>Electronic Media Search</h3>';
	echo '<p>Electronic Archives – You may search our electronic archives here. Search results are limited to your subscription terms. Please call your client service representative for more information.</p>';
}

?>
</div>
</div>

<style type="text/css">
#content{
	min-height: 900px;
}
.radio label{
	/*font-weight: bold;*/
	/*margin-left: -10px;*/
}
.search-params{
	padding: 10px 13px;
	clear: both;
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
    border: none;
    border-image: none;
}
table{
	font-size: 12px;
}
table a{
	color: #2F5961;
}
.force-padding{
	padding: 5px;
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
<script>
$(document).ready(function(){
$(".reveal").hide();
  $("button").click(function(){
    $(".reveal").slideToggle();
  });
});
</script>