<?php
// Mentions Class to Handle All Mentions Data
class AllMentionsData{
	public static function TempTable()
    {
        /**
        * Create Temp table 
        */
        $temp_table="mentions_summary_temp_" . date("Ymdhis");
        $temp_sql="CREATE TEMPORARY  TABLE `".$temp_table."` (
        `id` INT  AUTO_INCREMENT PRIMARY KEY ,
        `Story_ID` INT,
        `StoryDate` varchar(255)  ,
        `Title` varchar(255)  ,
        `Story` varchar(255)  ,
        `StoryPage` varchar(255)  ,
        `cont_on` varchar(255)  ,
        `cont_from` varchar(255)  ,
        `editor` varchar(255)  ,
        `Media_House_ID` varchar(255)  ,
        `journalist` varchar(255),
        `col` varchar(255),
        `centimeter` varchar(255),
        `StoryDuration` varchar(255),
        `StoryTime` varchar(255),
        `picture` varchar(255),
        `Media_ID` varchar(255),
        `tonality` varchar(255),
        `print_rate` varchar(255),
        `uniqueID` varchar(255),
        `ave` varchar(255),
        `Media_House_List` varchar(255)
        )ENGINE = MYISAM ;";
        Yii::app()->db2->createCommand($temp_sql)->execute();

        return $temp_table;
    }

    public static function GetDirectRecords($startdate,$enddate,$mediatype,$tonality,$backdate,$client,$country_list,$industries,$search){
    	// Date Formatting, if Needed
    	$year_start     = date('Y',strtotime($startdate));  
		$month_start    = date('m',strtotime($startdate));  
		$day_start      = date('d',strtotime($startdate));
		$year_end       = date('Y',strtotime($enddate)); 
		$month_end      = date('m',strtotime($enddate)); 
		$day_end        = date('d',strtotime($enddate));
		$temp_table = AllMentionsData::TempTable();
		// Table Loop
		for ($x=$year_start;$x<=$year_end;$x++)
		{
		    if($x==$year_start) { $month_start_count=$month_start; } else { $month_start_count='1';}
		    if($x==$year_end) { $month_end_count=$month_end; } else { $month_end_count='12';}
		    $month_start_count=$month_start_count+0;
		    for ($y=$month_start_count;$y<=$month_end_count;$y++)
		    {
		        if($y<10) { $my_month='0'.$y;   } else {  $my_month=$y; }
		        // The Temp Table
				$storytable = 'story_'.$x."_".$my_month;
				// Media Types
				if($mediatype=='all'){
					$mediatypequery = " ";
				}else{
					if($mediatype=='mp01'){
						$mediatypequery = "AND $storytable.Media_ID='mp01'";
					}else{
						$mediatypequery = "AND $storytable.Media_ID!='mp01'";
					}
				}
				// Tonality Query - Recent Introduction
				if($tonality!='all'){
					$tonalityquery = "AND mediamap_analysis.tonality = '$tonality'";
				}else{
					$tonalityquery = " ";
				}
				// Search Query
				if(!empty($search)){
					$searchqry = " AND ( ($storytable.Story like '%$search%') OR ($storytable.Title like '%$search%') OR ($storytable.mentioned like '%$search%') ) ";
				}else{
					$searchqry = " ";
				}
		        // Create The SQL 
		        $mentions_sql = "INSERT into $temp_table 
		        (Story_ID,StoryDate,Title,Story,StoryPage,cont_on,cont_from,editor,Media_House_ID,journalist,col,centimeter,StoryDuration,StoryTime,picture,Media_ID,tonality,print_rate,uniqueID,ave,Media_House_List)
		        SELECT DISTINCT 
		        $storytable.Story_ID,$storytable.StoryDate,$storytable.Title,$storytable.Story,$storytable.StoryPage,$storytable.cont_on,
		        $storytable.cont_from,$storytable.editor,$storytable.Media_House_ID,$storytable.journalist,$storytable.col ,
		        $storytable.centimeter , $storytable.StoryDuration,$storytable.StoryTime,$storytable.picture, $storytable.Media_ID,
		        mediamap_analysis.tonality,$storytable.print_rate, $storytable.uniqueID, $storytable.ave, mediahouse.Media_House_List
				FROM $storytable INNER JOIN story_mention on $storytable.Story_ID=story_mention.story_id 
				INNER JOIN mediahouse on $storytable.Media_House_ID=mediahouse.Media_House_ID
				INNER JOIN story_industry on story_industry.story_id=$storytable.Story_ID 
				INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
				INNER JOIN mediamap_analysis ON mediamap_analysis.story_id = $storytable.story_id
				WHERE 
				story_mention.client_id=$client AND $storytable.step3=1 AND mediamap_analysis.company_id = $client 
				AND $storytable.StoryDate>'$backdate' 
				$tonalityquery $mediatypequery
				AND $storytable.cont_from = 0 
				AND ($storytable.StoryDate BETWEEN '$startdate' AND '$enddate')  $searchqry
				AND industry_subs.company_id =$client AND industry_subs.industry_id IN ($industries)
				order by $storytable.StoryDate asc, Media_House_List asc, page_no asc";
				// Insert into Temp Table
		        $insertsql = Yii::app()->db2->createCommand($mentions_sql)->execute();
		    }
		}
		return $temp_table;
    }

    public static function GetIndustryRecords($startdate,$enddate,$mediatype,$tonality,$backdate,$client,$country_list,$industries,$search){
    	// Date Formatting, if Needed
    	$year_start     = date('Y',strtotime($startdate));  
		$month_start    = date('m',strtotime($startdate));  
		$day_start      = date('d',strtotime($startdate));
		$year_end       = date('Y',strtotime($enddate)); 
		$month_end      = date('m',strtotime($enddate)); 
		$day_end        = date('d',strtotime($enddate));
		$temp_table = AllMentionsData::TempTable();
		// Table Loop
		for ($x=$year_start;$x<=$year_end;$x++)
		{
		    if($x==$year_start) { $month_start_count=$month_start; } else { $month_start_count='1';}
		    if($x==$year_end) { $month_end_count=$month_end; } else { $month_end_count='12';}
		    $month_start_count=$month_start_count+0;
		    for ($y=$month_start_count;$y<=$month_end_count;$y++)
		    {
		        if($y<10) { $my_month='0'.$y;   } else {  $my_month=$y; }
		        // The Temp Table
				$storytable = 'story_'.$x."_".$my_month;
				// Media Types
				if($mediatype=='all'){
					$mediatypequery = " ";
				}else{
					if($mediatype=='mp01'){
						$mediatypequery = "AND $storytable.Media_ID='mp01'";
					}else{
						$mediatypequery = "AND $storytable.Media_ID!='mp01'";
					}
				}
				// Tonality Query - Recent Introduction
				if($tonality!='all'){
					$tonalityquery = "AND mediamap_analysis.tonality = '$tonality'";
				}else{
					$tonalityquery = " ";
				}
				// Search Query
				if(!empty($search)){
					$searchqry = " AND ( ($storytable.Story like '%$search%') OR ($storytable.Title like '%$search%') OR ($storytable.mentioned like '%$search%') ) ";
				}else{
					$searchqry = " ";
				}
		        // Create The SQL 
		        echo $mentions_sql = "INSERT into $temp_table 
		        (Story_ID,StoryDate,Title,Story,StoryPage,cont_on,cont_from,editor,Media_House_ID,journalist,col,centimeter,StoryDuration,StoryTime,picture,Media_ID,tonality,print_rate,uniqueID,ave,Media_House_List)
		        SELECT DISTINCT 
		        $storytable.Story_ID,$storytable.StoryDate,$storytable.Title,$storytable.Story,$storytable.StoryPage,$storytable.cont_on,
		        $storytable.cont_from,$storytable.editor,$storytable.Media_House_ID,$storytable.journalist,$storytable.col ,
		        $storytable.centimeter , $storytable.StoryDuration,$storytable.StoryTime,$storytable.picture, $storytable.Media_ID, 
		        mediamap_analysis.tonality,$storytable.print_rate, $storytable.uniqueID, $storytable.ave, mediahouse.Media_House_List
				FROM $storytable INNER JOIN story_mention on $storytable.Story_ID=story_mention.story_id 
				INNER JOIN mediahouse on $storytable.Media_House_ID=mediahouse.Media_House_ID
				INNER JOIN story_industry on story_industry.story_id=$storytable.Story_ID 
				INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
				INNER JOIN mediamap_analysis ON mediamap_analysis.story_id = $storytable.story_id
				WHERE 
				$storytable.story_id NOT IN (SELECT story_id from story_mention where client_id=$client) 
				AND story_mention.client_id=mediamap_analysis.company_id AND $storytable.step3=1 AND $storytable.StoryDate>'$backdate' 
				$tonalityquery $mediatypequery
				AND $storytable.cont_from = 0 
				AND ($storytable.StoryDate BETWEEN '$startdate' AND '$enddate')  $searchqry
				AND industry_subs.company_id = story_mention.client_id AND industry_subs.industry_id IN ($industries)
				order by $storytable.StoryDate asc, Media_House_List asc, page_no asc";
				echo "<hr>";
				// Insert into Temp Table
		        $insertsql = Yii::app()->db2->createCommand($mentions_sql)->execute();
		    }
		}
		return $temp_table;
    }
}