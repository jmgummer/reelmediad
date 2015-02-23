<?php

class ElectronicArchive{
	public static function UserStories($clientid,$search,$beginning,$ending,$media_house_id,$start, $number_of_posts){
	{
		$todaysdate=date("Y-m-d");
		$display_data = "";
		$media_code = $media_house_id;
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
		if(!empty($clientid))
		{

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
			$full_query=$full_query . " and StoryDate>'$backdate'";
		}else{
			$full_query=$full_query . " and StoryDate>2008";
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

		
		if(!empty($clientid)){
			if($url_query) {
			    $url_query=" and (" . $url_query. " ) ";
			    $full_query=$full_query . $url_query;
			    $full_query2=$full_query2 . $url_query;
			}
		}else{
			if($url_query) {
			    $url_query=" (" . $url_query. " ) ";
			    $full_query=$full_query . $url_query;
			    $full_query2=$full_query2 . $url_query;
			}
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
		$narrative.="</strong> between " .$display_date.'</p>';

		if(!empty($clientid))
		{
			$sql_industry="select  distinct(Story_ID), Title, mentioned,StoryDate,StoryTime,Media_House_ID,file_path,file,uniqueID from story 
			where MATCH(Title,mentioned) AGAINST ($my_query_words IN BOOLEAN MODE ) ". $full_query2 ." and (Media_ID='mt01' or Media_ID='mr01') 
			order by StoryDate  limit $start,10"  ;
		}else{
			$sql_industry="select  distinct(Story_ID), Title, mentioned,StoryDate,StoryTime,Media_House_ID,file_path,file,uniqueID from story 
			where ". $full_query2 ." and (Media_ID='mt01' or Media_ID='mr01') 
			order by StoryDate  limit $start,10"  ;
		}
		
		if($stories = Story::model()->findAllBySql($sql_industry)){
			$record_count = count($stories);
			$display_data .= $record_count.' Records Found';
			$display_data .= '<table class="table table-condensed ">';
			foreach ($stories as $key) {
				$format_date = date('d, F, Y', strtotime($key->StoryDate));
				$display_data .= '<tr><td>';
				$display_data .= '<h3><a href="'.Yii::app()->createUrl("video").'/'.$key->Story_ID.'" target="_blank">'.$key->Title.'</a></h3>';
				$display_data .= '<p>'.$key->Publication.' : '.$format_date.''.$key->Page.'</p>';
				$display_data .= '<p><a href="'.Yii::app()->createUrl("video").'/'.$key->Story_ID.'" target="_blank">View/Listen</a> </p>';
				$display_data .= '</td></tr>';
			}
			$display_data .= '</table>';
			if($record_count>9){
				$number_of_posts = $start+10;
				$display_data .= '<a class="btn btn-default" onclick="ShowMore('.$number_of_posts.',10)">Show More</a>';
			}
		}else{
			$display_data .= 'No Records Found';
		}
		return $display_data;
	}
}
}