<?php

/**
 * Class to Classify Client Emails based on themes and keywords
 */
class CustomClassification
{
	private $companyid;
	private $startdate;
	private $enddate;
	private $themes;
	private $themekeywords;
	
	public function __construct($companyid,$startdate,$enddate){
		$this->startdate = date('Y-m-d',strtotime($startdate));
		$this->enddate = date('Y-m-d',strtotime($enddate));
		$this->companyid = $companyid;
		$this->companyname = $this->CompanyName();
		$this->themes = $this->GetCompanyThemes();
		$this->themekeywords = $this->GetCompanyThemeKeywords();
		$this->industries = $this->CompanyIndustries();
	}

	public function CompanyIndustries(){
		$industries = array();
		$company_id = $this->companyid;
		$sql = "SELECT DISTINCT industry.Industry_ID, Industry_List FROM industry,industry_company where industry_company.company_id=$company_id and industry_company.industry_id=industry.Industry_ID order by sub_ind_id, Industry_List";
		if($query = Industry::model()->findAllBySql($sql)){
			foreach ($query as $key) {
				$industries[] = $key->Industry_ID;
			}
		}
		return $industries;
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

	public function GetCompanyThemes(){
		$themes = array();
		$company= $this->companyid;
		$indexsql = "SELECT DISTINCT id, theme_name AS theme FROM themes WHERE company_id=$company";
		if($query = Yii::app()->db2->createCommand($indexsql)->queryAll()){
			foreach ($query as $row) {
				$themes[$row['id']] = trim($row['theme']);
			}
		}
		return $themes;
	}

	public function GetCompanyThemeKeywords(){
		$keywords = array();
		$company= $this->companyid;
		$indexsql = "SELECT DISTINCT id, keyword, theme_id, preflevel FROM theme_keyword WHERE theme_id IN (SELECT DISTINCT id FROM themes WHERE company_id=$company)";
		if($query = Yii::app()->db2->createCommand($indexsql)->queryAll()){
			foreach ($query as $row) {
				$keywords[] = array('id'=>$row['id'],'keyword'=>trim($row['keyword']),'theme_id'=>$row['theme_id'],'preflevel'=>$row['preflevel']);
			}
		}
		return $keywords;
	}

	public function GetCompanyStories(){
		$storylinkarray = array();
		$companyid= $this->companyid;
		$startdate = $this->startdate;
		$enddate = $this->enddate;
		$industries = implode(',', $this->industries);
		$year_start     = date('Y',strtotime($startdate));  
		$month_start    = date('m',strtotime($startdate));  
		$day_start      = date('d',strtotime($startdate));
		$year_end       = date('Y',strtotime($enddate)); 
		$month_end      = date('m',strtotime($enddate)); 
		$day_end        = date('d',strtotime($enddate));
		// Combined Start Date, End Date & Industry
		$querykey 		= date('Ymd',strtotime($startdate)).date('Ymd',strtotime($enddate))."{$industries}";
		// Check if Records already Exist
		$checksql = "SELECT * FROM industrymentions WHERE querykey='$querykey'";
		if($checkquery = Yii::app()->db2->createCommand($checksql)->queryAll()){
			$this->MentionIndexing($querykey);
		}else{
			for ($x=$year_start;$x<=$year_end;$x++){
				if($x==$year_start) { $month_start_count=$month_start; } else { $month_start_count='1';}
				if($x==$year_end) { $month_end_count=$month_end; } else { $month_end_count='12';}
				$month_start_count=$month_start_count+0;
				for ($y=$month_start_count;$y<=$month_end_count;$y++)
				{
					if($y<10) {
						$my_month = '0'.$y;
					}else{
						$my_month = $y;
					}
					$storytable="story_"  .$x."_".$my_month;
					$pcviewtable="pc_view_"  .$x."_".$my_month;
					// Company Industry Stories - Print & Electronic - Combined
					$sql = "SELECT DISTINCT story_industry.story_id AS Story_ID, $storytable.link_id, $storytable.Title, $storytable.mentioned, $storytable.Story, $storytable.Media_ID, mediahouse.Media_House_List, $storytable.StoryDate, $storytable.StoryTime, $storytable.StoryPage, $storytable.uniqueID,$storytable.ave, $storytable.print_rate
					FROM story_industry  
					INNER JOIN $storytable on $storytable.Story_ID=story_industry.story_id
					INNER JOIN industry_subs ON story_industry.industry_id=industry_subs.industry_id
					INNER JOIN mediahouse ON $storytable.Media_House_ID=mediahouse.Media_House_ID
					LEFT JOIN story_mention on $storytable.Story_ID=story_mention.story_id
					WHERE industry_subs.industry_id IN ($industries)
					AND ($storytable.StoryDate between '$startdate' AND '$enddate') ";
					if($data = Yii::app()->db2->createCommand($sql)->queryAll()){
						foreach ($data as $elements) {
							if($elements['Media_ID']=='mp01'){
								// Got rid of keywords use ---- slows down the query and increases innaccuracy
								// However this then relies on the teams ability - the analysis team should not miss stories
								// $storykeywords = str_replace('"', "'", implode(',', $this->GetStoryKeywords($elements['link_id'],$pcviewtable,$storytable)));
								$storykeywords = "";
							}else{
								$storykeywords = "";
							}
							// Will be used to check if company of interest is tagged
							$companies = str_replace('"', "'", implode(',', $this->GetCompaniesMentioned($elements['Story_ID'])));
							// Story elements
							$Story_ID = $elements['Story_ID'];
							$Title = str_replace('"', "'", $elements['Title']);
							$link_id = $elements['link_id'];
							$mentioned = $elements['mentioned'];
							$Story = str_replace('"', "'", $elements['Story']);
							$Media_ID = $elements['Media_ID'];
							$Media_House_List = $elements['Media_House_List'];
							$StoryDate = $elements['StoryDate'];
							$StoryTime = $elements['StoryTime'];
							$StoryPage = $elements['StoryPage'];
							$uniqueID = $elements['uniqueID'];
							$ave = $elements['ave'];
							$print_rate = $elements['print_rate'];
							// Insert Script
							$insertsql = "INSERT IGNORE INTO industrymentions (Story_ID,Title,link_id,mentioned,companies,keywords,summary,querykey,Media_ID,companyid,preflevel,Media_House_List,StoryDate,StoryTime,StoryPage,uniqueID,ave,print_rate) VALUES ($Story_ID,\"$Title\",$link_id,\"$mentioned\",\"$companies\",\"$storykeywords\",\"$Story\",\"$querykey\",\"$Media_ID\",$companyid,0,'$Media_House_List','$StoryDate','$StoryTime','$StoryPage','$uniqueID',$ave,$print_rate)";							
							Yii::app()->db2->createCommand($insertsql)->execute();
						}
					}
				}
			}
			$this->MentionIndexing($querykey);
		}
		return $querykey;
	}

	public function GetStoryKeywords($link_id,$pcviewtable,$storytable){
		$keywordsarray = array();
		$sql = "SELECT DISTINCT keywords_found AS keywords FROM $pcviewtable WHERE $pcviewtable.link_id = $link_id";
		if($data = Yii::app()->db2->createCommand($sql)->queryAll()){
			foreach ($data as $elements) {
				$keywords = explode(',', strtolower($elements['keywords']));
				foreach ($keywords as $keyvalue) {
					if(!in_array($keyvalue, $keywordsarray)){
						$keywordsarray[] = $keyvalue;
					}
				}
			}
		}
		return $keywordsarray;
	}

	public function GetCompaniesMentioned($storyid){
		$companiesarray = array();
		if($mentions = StoryMention::model()->findAll('story_id=:a', array(':a'=>$storyid))){
			foreach ($mentions as $key) {
				$companiesarray[] = $key->Client;
			}
		}
		return $companiesarray;
	}

	public function MentionIndexing($querykey){
		$companyid= $this->companyid;
		/**
		*** SO we are gonna do this the Prefence Way
		*** This will allow us to Make Better Decisons when Tagging Brands/Themes
		*** 1 - Combinations e.g. "tusker and fc"
		*** 2 - Phrases e.g. "tusker fc"
		*** 3 - Any of the words e.g. "tusker or fc"
		**/
		$themesql = "SELECT DISTINCT keyword, theme_id FROM theme_keyword WHERE theme_id IN (SELECT DISTINCT id FROM themes WHERE company_id=$companyid) AND preflevel=1";
		if($data = Yii::app()->db2->createCommand($themesql)->queryAll()){
			foreach ($data as $row) {
				$theme_id = $row['theme_id'];
				$keyword = trim($row['keyword']);
				$keyword_s = str_replace("'", "%", str_replace("-", "%", str_replace('_', '\_', $keyword) ) );
				$wordarrays = explode(' and', $keyword_s);
				$wordkeytext = " ";
				foreach ($wordarrays as $wordkey) {
					$searchkey = str_replace(' ', '%', trim($wordkey));
					$wordkeytext .= " AND (`Title` LIKE '%$searchkey%' OR `keywords` LIKE '%$searchkey%' OR companies LIKE '%$searchkey%' OR mentioned LIKE '%$searchkey%' OR summary LIKE '%$searchkey%')";
				}
				$sql_keyword = "SELECT id, theme_id, theme_keywords FROM industrymentions WHERE companyid = $companyid AND (theme_id='' OR theme_id IS NULL) AND querykey='$querykey' $wordkeytext";
				if($ig_query = Yii::app()->db2->createCommand($sql_keyword)->queryAll()){
					$recordcount = count($ig_query);
					if($recordcount>0){
						// Update Records at a GO!
						foreach ($ig_query as $ig_row) {
							$rowid = $ig_row['id'];
							$foundkeys = $ig_row['theme_keywords'];
							$foundthemes = $ig_row['theme_id'];
							// If the themes are not empty
							if($foundthemes!=''){
								$themesarray = explode(',', $foundthemes);
							}else{
								$themesarray = array();
							}
							// If the Keywords are not empty
							if($foundkeys!=''){
								$keysarray = explode(',', $foundkeys);
							}else{
								$keysarray = array();
							}
							// Check if the Theme Was Already Added, Else Add
							if(!in_array($theme_id, $themesarray)){
								$themesarray[] = $theme_id;
								$themestring = implode(',', $themesarray);
								// Check if the keyword was already added, else add
								if(!in_array($keyword, $keysarray)){
									$keysarray[] = $keyword;
								}
								$keystring = implode(',', $keysarray);
								$updatesql = "UPDATE industrymentions set theme_id = '$themestring', theme_keywords='$keystring', preflevel=1 WHERE companyid = $companyid AND id = $rowid";
								Yii::app()->db2->createCommand($updatesql)->execute();
							}
						}
					}
				}
			}
		}
		$themesql = "SELECT DISTINCT keyword, theme_id FROM theme_keyword WHERE theme_id IN (SELECT DISTINCT id FROM themes WHERE company_id=$companyid) AND preflevel=2";
		if($data = Yii::app()->db2->createCommand($themesql)->queryAll()){
			foreach ($data as $row) {
				$theme_id = $row['theme_id'];
				$keyword = trim($row['keyword']);
				$keyword_s = str_replace("'", "%", str_replace("-", "%", str_replace('_', '\_', $keyword) ) );
				$wordkeytext = " ";
				$searchkey = str_replace(' ', '%', trim($keyword_s));
				$wordkeytext .= " AND (`Title` LIKE '%$searchkey%' OR `keywords` LIKE '%$searchkey%' OR companies LIKE '%$searchkey%' OR mentioned LIKE '%$searchkey%' OR summary LIKE '%$searchkey%')";
				$sql_keyword = "SELECT id, theme_id, theme_keywords FROM industrymentions WHERE companyid = $companyid AND (theme_id='' OR theme_id IS NULL) AND (preflevel =0 OR preflevel>1) AND querykey='$querykey' $wordkeytext";
				if($ig_query = Yii::app()->db2->createCommand($sql_keyword)->queryAll()){
					$recordcount = count($ig_query);
					if($recordcount>0){
						// Update Records at a GO!
						foreach ($ig_query as $ig_row) {
							$rowid = $ig_row['id'];
							$foundkeys = $ig_row['theme_keywords'];
							$foundthemes = $ig_row['theme_id'];
							// If the themes are not empty
							if($foundthemes!=''){
								$themesarray = explode(',', $foundthemes);
							}else{
								$themesarray = array();
							}
							// If the Keywords are not empty
							if($foundkeys!=''){
								$keysarray = explode(',', $foundkeys);
							}else{
								$keysarray = array();
							}
							// Check if the Theme Was Already Added, Else Add
							if(!in_array($theme_id, $themesarray)){
								$themesarray[] = $theme_id;
								$themestring = implode(',', $themesarray);
								// Check if the keyword was already added, else add
								if(!in_array($keyword, $keysarray)){
									$keysarray[] = $keyword;
								}
								$keystring = implode(',', $keysarray);
								$updatesql = "UPDATE industrymentions set theme_id = '$themestring', theme_keywords='$keystring', preflevel=2 WHERE companyid = $companyid AND id = $rowid";
								Yii::app()->db2->createCommand($updatesql)->execute();
							}
						}
					}
				}
			}
		}
		$themesql = "SELECT DISTINCT keyword, theme_id FROM theme_keyword WHERE theme_id IN (SELECT DISTINCT id FROM themes WHERE company_id=$companyid) AND preflevel=3";
		if($data = Yii::app()->db2->createCommand($themesql)->queryAll()){
			foreach ($data as $row) {
				$theme_id = $row['theme_id'];
				$keyword = trim($row['keyword']);
				$keyword_s = str_replace("'", "%", str_replace("-", "%", str_replace('_', '\_', $keyword) ) );
				$wordarrays = explode(' or', $keyword_s);
				$prefix = $wordkeytext = '';
				foreach ($wordarrays as $wordkey){
					$searchkey = str_replace(' ', '%', trim($wordkey));
				    $wordkeytext .= $prefix . "`Title` LIKE '%$searchkey%' OR `keywords` LIKE '%$searchkey%' OR companies LIKE '%$searchkey%' OR mentioned LIKE '%$searchkey%' OR summary LIKE '%$searchkey%' ";
				    $prefix = 'OR ';
				}
				$cwordkeytext = " AND ( $wordkeytext )";
				$sql_keyword = "SELECT id, theme_id, theme_keywords FROM industrymentions WHERE companyid = $companyid AND (theme_id='' OR theme_id IS NULL) AND (preflevel =0 OR preflevel>2) AND querykey='$querykey' $cwordkeytext";
				if($ig_query = Yii::app()->db2->createCommand($sql_keyword)->queryAll()){
					$recordcount = count($ig_query);
					if($recordcount>0){
						// Update Records at a GO!
						foreach ($ig_query as $ig_row) {
							$rowid = $ig_row['id'];
							$foundkeys = $ig_row['theme_keywords'];
							$foundthemes = $ig_row['theme_id'];
							// If the themes are not empty
							if($foundthemes!=''){
								$themesarray = explode(',', $foundthemes);
							}else{
								$themesarray = array();
							}
							// If the Keywords are not empty
							if($foundkeys!=''){
								$keysarray = explode(',', $foundkeys);
							}else{
								$keysarray = array();
							}
							// Check if the Theme Was Already Added, Else Add
							if(!in_array($theme_id, $themesarray)){
								$themesarray[] = $theme_id;
								$themestring = implode(',', $themesarray);
								// Check if the keyword was already added, else add
								if(!in_array($keyword, $keysarray)){
									$keysarray[] = $keyword;
								}
								$keystring = implode(',', $keysarray);
								$updatesql = "UPDATE industrymentions set theme_id = '$themestring', theme_keywords='$keystring', preflevel=3 WHERE companyid = $companyid AND id = $rowid";
								Yii::app()->db2->createCommand($updatesql)->execute();
							}
						}
					}
				}
			}
		}
	}	
}