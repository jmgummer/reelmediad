<?php

/**
* Track Company Mentions based off of Keywords
*/
class AdvancedSearch
{
	private $companyid;
	private $startdate;
	private $enddate;
	private $indexterms;
	private $brandrows;
	private $chartarray;
	private $adsrow;
	private $excelarray;
	
	public function __construct($companyid,$startdate,$enddate){
        $this->startdate = date('Y-m-d',strtotime($startdate));
        $this->enddate = date('Y-m-d',strtotime($enddate));
        $this->companyid = $companyid;
        $this->indexterms = $this->GetCompanyTerms();
        $this->companies = $this->GetCompanyIds();
        $this->temp_table = $this->TempTable();
        $this->companyname = $this->CompanyName();
    }

    public function CompanyName(){
    	$company_id = $this->companyid;
    	$company_sql = "SELECT company_name FROM company WHERE company_id=$company_id";
    	if($query = Yii::app()->db2->createCommand($company_sql)->queryRow()){
    		$company_name = $query['company_name'];
    		return $company_name;
    	}else{
    		return 'Unknown';
    	}
    }

    // Create Temp Table to hold data
    public function TempTable(){
    	/* Create Temp table */
        $temp_table="rmreg_log_temp_" . date("Ymdhis");
        $temp_sql="CREATE TEMPORARY  TABLE `".$temp_table."` (
        `id` INT  AUTO_INCREMENT PRIMARY KEY ,
        `Story_ID` INT,
        `Title` varchar(255)  ,
        `ave` INT  ,
        `print_rate` INT  ,
        `Media_ID` varchar(30)  ,
        `Media_House_List` varchar(30)  ,
        `StoryDate` varchar(30)  ,
        `StoryTime` varchar(30)  ,
        `StoryDuration` varchar(30)  ,
        `StoryPage` varchar(30)  ,
        `journalist` varchar(100)  ,
        `uniqueID` varchar(255),
        `Story` text,
        `companyname` varchar(150),
        `mentioned` varchar(250)
        ) ENGINE = MYISAM ;";
        Yii::app()->db2->createCommand($temp_sql)->execute();
        return $temp_table;
    }

    public function GetCompanyIds(){
    	$companyids = array();
    	$indexterms = $this->indexterms;
    	$companynamequery = "";
    	$full_query = "";
    	$words=$indexterms;
		$my_keywords=str_replace(", ",",",$indexterms);
		$all_keywords=$words;
		$all_keywords=array_filter($all_keywords);
		$all_my_keywords=array_unique($all_keywords);
		$all_my_keywords=array_unique($all_my_keywords);
		$my_keyword_count=count($all_keywords);
		for($x=0; $x<=$my_keyword_count; $x++) 
		{
			if(isset($all_my_keywords[$x])){
				if(trim($all_my_keywords[$x])){
			        $all_my_keywords[$x]=trim($all_my_keywords[$x]);
			        if(strlen($all_my_keywords[$x])>4) {
			            $companynamequery.=' company_name LIKE "%'. trim($all_my_keywords[$x]) .'%" OR ';	
			        }
			        if(strlen($all_my_keywords[$x])<=4) {
			            $companynamequery.=' company_name LIKE "%'. trim($all_my_keywords[$x]) .', %" OR ';
			            $companynamequery.=' company_name LIKE "%'. trim($all_my_keywords[$x]) . '. %" OR ';
			        }
			    }
			}
		}
		if($companynamequery){
		    $companynamequery=' AND (' . substr($companynamequery,0,-3) . ') ';
		    $companynamequery=$full_query . $companynamequery;
		}
    	$tablerows = "";
    	$company_sql = "SELECT company_id FROM company WHERE company_name!='' $companynamequery";
    	if($query = Yii::app()->db2->createCommand($company_sql)->queryAll()){
    		foreach ($query as $row) {
				$companyids[] = $row['company_id'];
    		}
    	}
		return $companyids;
    }

    public function GetCompanyTerms(){
    	$indexterms = array();
    	$company= $this->companyid;
    	$indexsql = "SELECT index_term FROM company_index_terms WHERE company_index_terms.index_id IN (SELECT DISTINCT company_indexing.id FROM company_indexing WHERE company_indexing.company_id=$company)";
		if($query = Yii::app()->db2->createCommand($indexsql)->queryAll()){
			foreach ($query as $row) {
				$indexterms[] = trim($row['index_term']);
			}
		}
		return $indexterms;
    }

    public function GetMentions(){
    	$startdate = $this->startdate;
    	$enddate = $this->enddate;
    	$indexterms = $this->indexterms;
    	$companyids = $this->companies;
    	$temp_table = $this->temp_table;
    	$foundkeyarray = array();
    	$excelarray = array();
		$printarray = array();
		$radioarray = array();
		$tvarray = array();
    	$tabletitles = "";
    	// Convert IDS to string
    	$companylist = implode(',', $companyids);
    	if(isset($companyids) && count($companyids)>0){
    		$companysearch = "story_mention.client_id IN ($companylist) AND";
    	}else{
    		$companysearch = " ";
    	}
    	// Get stories from Companies built using the keywords - Print
		$companystories_sql = "INSERT into $temp_table (Story_ID,Title,ave,print_rate,Media_ID,Media_House_List,StoryDate,StoryTime,StoryPage,uniqueID,Story,mentioned,journalist) SELECT DISTINCT story.Story_ID, story.Title, story.ave, story.print_rate, story.Media_ID, mediahouse.Media_House_List, 
		story.StoryDate, story.StoryTime, story.StoryPage, story.uniqueID, story.Story, story.mentioned, story.journalist 
		FROM story 
		INNER JOIN story_mention ON story.Story_ID=story_mention.story_id
		INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID
		WHERE $companysearch story.Media_ID='mp01' AND (story.StoryDate BETWEEN '$startdate' AND '$enddate')";
		Yii::app()->db2->createCommand($companystories_sql)->execute();
		// Get stories from Companies built using the keywords - Electronic
		$companystories_sql = "INSERT into $temp_table (Story_ID,Title,ave,print_rate,Media_ID,Media_House_List,StoryDate,StoryTime,StoryPage,uniqueID,Story,mentioned,StoryDuration,journalist) SELECT DISTINCT story.Story_ID, story.Title, story.ave, story.print_rate, story.Media_ID, mediahouse.Media_House_List, 
		story.StoryDate, story.StoryTime, story.StoryPage, story.uniqueID, story.Story,story.mentioned, story.StoryDuration, story.journalist
		FROM story 
		INNER JOIN story_mention ON story.Story_ID=story_mention.story_id
		INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID
		WHERE $companysearch story.Media_ID!='mp01' AND (story.StoryDate BETWEEN '$startdate' AND '$enddate')";
		Yii::app()->db2->createCommand($companystories_sql)->execute();
		/*
		** Run Keywords Part, it is not reliant on companies mentioned
		** Build Keywords Query
		*/ 
    	$mention_query = "";
    	$full_query = "";
    	$words=$indexterms;
		$my_keywords=str_replace(", ",",",$indexterms);
		$all_keywords=$words;
		$all_keywords=array_filter($all_keywords);
		$all_my_keywords=array_unique($all_keywords);
		$all_my_keywords=array_unique($all_my_keywords);
		$my_keyword_count=count($all_keywords);
		for($x=0; $x<=$my_keyword_count; $x++) 
		{
			if(isset($all_my_keywords[$x])){
				if(trim($all_my_keywords[$x])){
			        $all_my_keywords[$x]=trim($all_my_keywords[$x]);
			        if(strlen($all_my_keywords[$x])>4) {
			            $mention_query.=' mentioned LIKE "%'. trim($all_my_keywords[$x]) .'%" OR ';	
			        }
			        if(strlen($all_my_keywords[$x])<=4) {
			            $mention_query.=' mentioned LIKE "%'. trim($all_my_keywords[$x]) .', %" OR ';
			            $mention_query.=' mentioned LIKE "%'. trim($all_my_keywords[$x]) . '. %" OR ';
			        }
			    }
			}
		}
		if($mention_query){
		    $mention_query=' AND (' . substr($mention_query,0,-3) . ') ';
		    $mention_query=$full_query . $mention_query;
		}
    	$tablerows = "";
    	// Get stories using the keywords - Print
    	$insert_sql = "INSERT into $temp_table (Story_ID,Title,ave,print_rate,Media_ID,Media_House_List,StoryDate,StoryTime,StoryPage,uniqueID,Story,mentioned,journalist) SELECT DISTINCT story.Story_ID, story.Title, story.ave, story.print_rate, story.Media_ID, mediahouse.Media_House_List, 
		story.StoryDate, story.StoryTime, story.StoryPage, story.uniqueID, story.Story, story.mentioned, story.journalist 
    	FROM story 
    	INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID 
    	WHERE (story.StoryDate BETWEEN '$startdate' AND '$enddate') AND story.Media_ID='mp01'  $mention_query";
		Yii::app()->db2->createCommand($insert_sql)->execute();
    	// Get stories using the keywords - Electronic
    	$insert_sql = "INSERT into $temp_table (Story_ID,Title,ave,print_rate,Media_ID,Media_House_List,StoryDate,StoryTime,StoryPage,uniqueID,Story,mentioned,StoryDuration,journalist) SELECT DISTINCT story.Story_ID, story.Title, story.ave, story.print_rate, story.Media_ID, mediahouse.Media_House_List, 
		story.StoryDate, story.StoryTime, story.StoryPage, story.uniqueID, story.Story, story.mentioned, story.StoryDuration, story.journalist 
    	FROM story 
    	INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID 
    	WHERE (story.StoryDate BETWEEN '$startdate' AND '$enddate') AND story.Media_ID!='mp01'  $mention_query";
		Yii::app()->db2->createCommand($insert_sql)->execute();
		/*
		** Look for the Keywords that actually have stories, the keyword will be used as a row id
		** Anything that is left out will be tagged under OTHERS
		** Re-obtain Filtered List of keywords to avoid reports with different keywords
		*/
		$companyid = $this->companyid;
		$sqlkeys = "SELECT id, index_term FROM company_index_terms 
		WHERE company_index_terms.index_id IN (SELECT DISTINCT company_indexing.id FROM company_indexing 
		WHERE company_indexing.company_id=$companyid)
		AND parent_id=0";
		if($keyquery = Yii::app()->db2->createCommand($sqlkeys)->queryAll()){
			foreach ($keyquery as $keyrow) {
				$keywordid = $keyrow['id'];
				$keywordkey = trim($keyrow['index_term']);
				// Get the sub key
				$subquery = "";
				$sqlsubkeys = "SELECT index_term FROM company_index_terms 
				WHERE company_index_terms.index_id IN (SELECT DISTINCT company_indexing.id FROM company_indexing 
				WHERE company_indexing.company_id=$companyid)
				AND parent_id=$keywordid LIMIT 1";
				if($subkeyquery = Yii::app()->db2->createCommand($sqlsubkeys)->queryAll()){
					foreach ($subkeyquery as $subkeyrow) {
						$subkeywordkey = trim($subkeyrow['index_term']);
						$subquery .=' mentioned LIKE "%'.$subkeywordkey.'%" OR ';
					}
				}
				// Select ALL Entries for the Email
				$mentions_sql = "SELECT DISTINCT Story_ID, Title, ave, print_rate, Media_ID, Media_House_List, 
				StoryDate, StoryTime, StoryPage, uniqueID, Story, mentioned, StoryDuration, journalist 
				FROM $temp_table WHERE ($subquery mentioned LIKE '%$keywordkey%')  ORDER BY StoryDate,StoryPage,StoryTime";
				if($query = Yii::app()->db2->createCommand($mentions_sql)->queryAll()){
					$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;' id='$keywordkey'><td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'><font style='color:#505050;font-weight:bold;'>$keywordkey</font></td></tr>";
					foreach ($query as $row) {
						$mediahouse = $row['Media_House_List'];
						$Story_ID = $row['Story_ID'];
						$title = $row['Title'];
						$StoryDate = $row['StoryDate'];
						$Story = $row['Story'];
						$encriptdid = $row['uniqueID'];
						$mentioned = $row['mentioned'];
						$storytime= $row['StoryTime'];
						$storypage = $row['StoryPage'];
						$journalist = $row['journalist'];
						$customtag = $keywordkey;

						if($row['Media_ID']=='mp01'){
							$mediatype = 'Print';
							$extra = "Page: ".$row['StoryPage'];
							$printplayer = Yii::app()->params['printplayer'];
							$url = $printplayer."storyid=$Story_ID&encriptdid=$encriptdid";
							$ave = $row['print_rate'];
							$duration = '-';
							// Add to Print Array
							$printarray[] = array(
								'mediahouse'=>$mediahouse,
								'title'=>$title,
								'StoryDate'=>$StoryDate,
								'Story'=>$Story,
								'url'=>$url,
								'ave'=>$ave,
								'customtag'=>$customtag,
								'mentioned'=>$mentioned,
								'duration'=>$duration,
								'mediatype'=>$mediatype,
								'storytime'=>'-',
								'storypage'=>$storypage,
								'journalist'=>$journalist
							);
						}elseif($row['Media_ID']=='mr01'){
							$mediatype = 'Radio';
							$extra = "Time: ".$row['StoryTime'];
							$electronicplayer = Yii::app()->params['electronicplayer'];
							$url = $electronicplayer."storyid=$Story_ID&encriptdid=$encriptdid";
							$ave = $row['ave'];
							$duration = $row['StoryDuration'];
							// Add to Radio Array
							$radioarray[] = array(
								'mediahouse'=>$mediahouse,
								'title'=>$title,
								'StoryDate'=>$StoryDate,
								'Story'=>$Story,
								'url'=>$url,
								'ave'=>$ave,
								'customtag'=>$customtag,
								'mentioned'=>$mentioned,
								'duration'=>$duration,
								'mediatype'=>$mediatype,
								'storytime'=>$storytime,
								'storypage'=>'-',
								'journalist'=>$journalist
							);
						}else{
							$mediatype = 'TV';
							$extra = "Time: ".$row['StoryTime'];
							$electronicplayer = Yii::app()->params['electronicplayer'];
							$url = $electronicplayer."storyid=$Story_ID&encriptdid=$encriptdid";
							$ave = $row['ave'];
							$duration = $row['StoryDuration'];
							// Add to TV Array
							$tvarray[] = array(
								'mediahouse'=>$mediahouse,
								'title'=>$title,
								'StoryDate'=>$StoryDate,
								'Story'=>$Story,
								'url'=>$url,
								'ave'=>$ave,
								'customtag'=>$customtag,
								'mentioned'=>$mentioned,
								'duration'=>$duration,
								'mediatype'=>$mediatype,
								'storytime'=>$storytime,
								'storypage'=>'-',
								'journalist'=>$journalist
							);
						}
						$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;'>";
						$tablerows .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'>";
						$tablerows .= "<a href='$url' style='color: #336699;font-weight: normal;text-decoration: underline;' target='_blank'>$title</a> <font style='color:#505050;'>($mediahouse, $extra)</font>";
						$tablerows .= "<br><font style='color:#505050;'>$Story<br></font>";
						$tablerows .= "</td>";
						$tablerows .= "</tr>";
					}
				}
			}
		}
		$excelarray = array(
			'printarray'=>$printarray,
			'radioarray'=>$radioarray,
			'tvarray'=>$tvarray
		);
		$dropsql = "DROP TABLE $temp_table";
		Yii::app()->db2->createCommand($dropsql)->execute();
		$this->brandrows = $tablerows;
		$this->excelarray = $excelarray;
		return TRUE;
    }

    public function CreateTable(){
    	$tvmentions = $this->excelarray['tvarray'];
    	$printmentions = $this->excelarray['printarray'];
    	$radiomentions = $this->excelarray['radioarray'];
    	$reportperiod = $this->startdate." - ".$this->enddate;
    	$company_name = $this->companyname;
    	$excelfile = AdvancedSearchFiles::ExcelFile($tvmentions,$printmentions,$radiomentions,$reportperiod,$company_name);
		echo '<p><strong><a href="'.Yii::app()->request->baseUrl . '/docs/excel/'.$excelfile.'"><i class="fa fa-file-excel-o"></i> Download Excel File</a></strong></p>';
    	$table = "<table style='width: 100%;font-family: Arial;font-size: 14px;line-height: 150%;text-align: left;border-spacing: 0;border-collapse: collapse;'>";
    	$table.= $this->brandrows;
    	$table.= "</table>";
    	return $table;
    }
}