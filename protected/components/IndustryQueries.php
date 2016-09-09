<?php

/**
* IndustryQueries Component Class
* This Class Is Used To Return handle Industry Queries
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version 	   v.1.0
* @since       July 2008
*/

class IndustryQueries{

	/**
	*
	* @return  Return all mentions
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetAllCompanyMentions($startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT DISTINCT story.story_id as number_mentions from story_industry, story where story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.')';
		if($mentions = count(StoryMention::model()->findAllBySql($q1))){
			return $mentions;
		}else{
			return FALSE;
		}
	}

	/**
	*
	* @return  Return a Single Company's mentions
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetCompanyMentions($client,$startdate,$enddate,$industry,$backdate)
	{
		$q2 = 'SELECT DISTINCT story_mention.story_id as number_my_mentions from story_industry, story_mention, story where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.')';
		if($mentions = count(StoryMention::model()->findAllBySql($q2))){
			return $mentions;
		}else{
			return FALSE;
		}
	}

	/**
	*
	* @return  Return the company's mentions
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetCompanyAve($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,
		story.StoryTime,story.picture , story.Media_ID, story.print_rate, story.uniqueID from story_industry, story_mention, story, mediahouse where story_mention.client_id='.$client.' and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and mediahouse.Media_House_ID=story.Media_House_ID order by StoryDate asc';
		if($ave = Story::model()->findAllBySql($q1)){
			$myTotalRate=0;
			foreach ($ave as $key) {
				$Media_House_ID = $key->Media_House_ID;
				$weekday = strtolower(date('D', strtotime($key->StoryDate)));
				$col = $key->col;
				$centimeter = $key->centimeter;
				$StoryDuration=$incantation_length=$key->StoryDuration;
				$StoryTime=$key->StoryTime;
				$this_rate=0;
				if($key->Media_ID=='mp01'){
					$rate_cost = $key->print_rate;
				}else{
					$words = $StoryDuration;
					$StoryPlacement=$StoryTime;
          			$Journalist="n/a";
          			$anvilstation_id = AnvilMatch::model()->findBySql("SELECT * FROM anvil_match WHERE Media_House_ID=$Media_House_ID");
					if($anvilstation_id){
						$station_id = $anvilstation_id->station_id;
						$sql_electronic_rate = "SELECT rate,duration from forgedb.ratecard_base where ratecard_base.station_id=$station_id and forgedb.ratecard_base.weekday='$weekday' and forgedb.ratecard_base.time_start<='$StoryTime' order by forgedb.ratecard_base.duration,  ratecard_base.date_start desc,ratecard_base.time_start desc, forgedb.ratecard_base.time_end asc limit 1;";
						$incantation_length=str_replace("sec","",$incantation_length);
						$this_rate_det = RatecardBase::model()->findBySql($sql_electronic_rate);
						if(isset($this_rate_det->rate) && isset($this_rate_det->duration)){
							$this_rate = $this_rate_det->rate;
							$this_duration = $this_rate_det->duration;
							if($rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1)==60){
								$rate_cost = 0;
							}else{
								$rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1);
							}
						}else{
							$rate_cost = 0;
						}
					}else{
						$rate_cost =0;
					}
				}
				$myTotalRate=$myTotalRate+$rate_cost;
			}
			return $myTotalRate;
		}else{
			return 0;
		}
	}

	/**
	*
	* @return  Return all company ave
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetAllCompanyAve($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,
		story.StoryTime,story.picture , story.Media_ID, story.print_rate, story.uniqueID from story_industry, story_mention, story, mediahouse where story_industry.industry_id IN ('.$industry.') and story_mention.client_id!='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and mediahouse.Media_House_ID=story.Media_House_ID order by StoryDate asc';
		if($ave = Story::model()->findAllBySql($q1)){
			$myTotalRate=0;
			foreach ($ave as $key) {
				$Media_House_ID = $key->Media_House_ID;
				$weekday = strtolower(date('D', strtotime($key->StoryDate)));
				$col = $key->col;
				$centimeter = $key->centimeter;
				$StoryDuration=$incantation_length=$key->StoryDuration;
				$StoryTime=$key->StoryTime;
				$this_rate=0;
				if($key->Media_ID=='mp01'){
					$rate_cost = $key->print_rate;
				}else{
					$words = $StoryDuration;
					$StoryPlacement=$StoryTime;
          			$Journalist="n/a";
          			$anvilstation_id = AnvilMatch::model()->findBySql("SELECT * FROM anvil_match WHERE Media_House_ID=$Media_House_ID");
					if($anvilstation_id){
						$station_id = $anvilstation_id->station_id;
						$sql_electronic_rate = "SELECT rate,duration from forgedb.ratecard_base where ratecard_base.station_id=$station_id and forgedb.ratecard_base.weekday='$weekday' and forgedb.ratecard_base.time_start<='$StoryTime' order by forgedb.ratecard_base.duration,  ratecard_base.date_start desc,ratecard_base.time_start desc, forgedb.ratecard_base.time_end asc limit 1;";
						$incantation_length=str_replace("sec","",$incantation_length);
						$this_rate_det = RatecardBase::model()->findBySql($sql_electronic_rate);
						if(isset($this_rate_det->rate) && isset($this_rate_det->duration)){
							$this_rate = $this_rate_det->rate;
							$this_duration = $this_rate_det->duration;
							if($rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1)==60){
								$rate_cost = 0;
							}else{
								$rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1);
							}
						}else{
							$rate_cost = 0;
						}
					}else{
						$rate_cost =0;
					}
				}
				$myTotalRate=$myTotalRate+$rate_cost;
			}
			return $myTotalRate;
		}else{
			return 0;
		}
	}

	/**
	*
	* @return  Return a count of share of tv
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetShareVoiceMediaTV($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT DISTINCT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mt01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	/**
	*
	* @return  Return a count of share of radio
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetShareVoiceMediaRadio($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT DISTINCT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mr01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	/**
	*
	* @return  Return a count of share of print
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetShareVoiceMediaPrint($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT DISTINCT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mp01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	/**
	*
	* @return  Return a count of industry share of voice
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT count(DISTINCT story.story_id) as mentions, company_name, company.company_id, story_mention.client_id from story_industry, story , story_mention, industry_company,company where story_industry.story_id= story_mention.story_id and story_industry.industry_id=industry_company.industry_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and company.company_id!='.$client.' and industry_company.company_id=company.company_id and story_mention.client_id=company.company_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') group by company_name order by mentions desc';
		$sq = Yii::app()->db2->createCommand($q1)->queryAll();
		return $sq;
	}

	/**
	*
	* @return  Return a count of overall share of voice
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetShareVoiceCount($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT count(DISTINCT story.story_id) as mentions, company_name, company.company_id, story_mention.client_id from story_industry, story , story_mention, industry_company,company where story_industry.story_id= story_mention.story_id and story_industry.industry_id=industry_company.industry_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and company.company_id='.$client.' and industry_company.company_id=company.company_id and story_mention.client_id=company.company_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') group by company_name order by mentions desc';
		$sq = Yii::app()->db2->createCommand($q1)->queryRow();
		return $sq;
	}

	/**
	*
	* @return Return categories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetCategories()
	{
		$categories = Category::model()->findAll();
		return $categories;
	}

	/**
	*
	* @return  Return a count of categories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetCatCount($client,$startdate,$enddate,$industry,$cat,$backdate)
	{
		$q1 = 'SELECT DISTINCT story.story_id as number_mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and Category_ID="'.$cat.'" and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') ';
		return $sq = count(StoryMention::model()->findAllBySql($q1));
	}

	/**
	*
	* @return  Return count of colored stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetPictures()
	{
		$sql = "SELECT distinct(picture) from story where picture!='' and concat('',picture * 1) != picture";
		$pics = Story::model()->findAllBySql($sql);
		return $pics;
	}

	/**
	*
	* @return  Return a count of colored stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetPicCount($client,$startdate,$enddate,$industry,$pic,$backdate)
	{
		if($pic=='color'){
			$pic_query = " AND (picture = 1 OR picture like '%color%')";
		}elseif ($pic=='black_white') {
			$pic_query = " AND (picture = 2 OR picture like '%black_white%')";
		}else{
			$pic_query = " AND (picture = 0 OR picture like '%none%')";
		}
		$q1 = 'SELECT count(DISTINCT story.story_id) as mentions, story.picture as number_pictures from story_industry, story, story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id '.$pic_query;
		$sq = Yii::app()->db2->createCommand($q1)->queryRow();
		return $sq['mentions'];
	}

	/**
	*
	* @return  Return a count of tonality
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetTonality($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT count(DISTINCT story.story_id) as number_tonality, mediamap_analysis.tonality from story_industry, story,mediamap_analysis, story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and mediamap_analysis.story_id=story_industry.story_id and mediamap_analysis.company_id='.$client.' group by mediamap_analysis.tonality';
		$sq = Yii::app()->db2->createCommand($q1)->queryAll();
		return $sq;
	}

	/**
	*
	* @return  Return a count of tonality
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetSpTonality($client,$startdate,$enddate,$industry,$tonality,$backdate)
	{
		$q1 = 'SELECT story.story_id as number_tonality, mediamap_analysis.tonality from story_industry, story,mediamap_analysis, story_mention where story_mention.client_id='.$client.'  and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and mediamap_analysis.story_id=story_industry.story_id and mediamap_analysis.company_id='.$client.' and mediamap_analysis.tonality="'.$tonality.'"';
		return $sq = count(MediamapAnalysis::model()->findAllBySql($q1));
	}
}