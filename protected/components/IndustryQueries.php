<?php

class IndustryQueries{

	public static function GetAllCompanyMentions($startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT story.story_id as number_mentions from story_industry, story where story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.')';
		if($mentions = count(StoryMention::model()->findAllBySql($q1))){
			return $mentions;
		}else{
			return FALSE;
		}
	}

	public static function GetCompanyMentions($client,$startdate,$enddate,$industry,$backdate)
	{
		$q2 = 'SELECT story_mention.story_id as number_my_mentions from story_industry, story_mention, story where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.')';
		if($mentions = count(StoryMention::model()->findAllBySql($q2))){
			return $mentions;
		}else{
			return FALSE;
		}
	}

	public static function GetCompanyAve($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT * from story_industry, story_mention, story, mediahouse where story_mention.client_id='.$client.' and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and mediahouse.Media_House_ID=story.Media_House_ID order by StoryDate asc';
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
					$picture = $key->picture;
					if($picture=='color'){
						$color_code = $weekday.'_c';
					}else{
						$color_code = $weekday.'_b';
					}
					$rate = Ratecard::model()->find('Media_House_ID=:a AND color_code=:b', array(':a'=>$Media_House_ID,':b'=>$color_code))->rate;
					$rate_cost = $rate*$col*$centimeter;
				}else{
					$words = $StoryDuration;
					$StoryPlacement=$StoryTime;
          $Journalist="n/a";

          $incantation_length=str_replace("sec","",$incantation_length);
					$sql_electronic_rate='SELECT rate,duration from forgedb.ratecard_base, reelmedia.anvil_match where ratecard_base.station_id=anvil_match.station_id and anvil_match.Media_House_ID='.$Media_House_ID.' and forgedb.ratecard_base.weekday="'.$weekday.'" and forgedb.ratecard_base.time_start<="'.$StoryTime.'" order by forgedb.ratecard_base.duration,  ratecard_base.date_start desc,ratecard_base.time_start desc, forgedb.ratecard_base.time_end asc limit 1';
					$this_rate_det = RatecardBase::model()->findBySql($sql_electronic_rate);
					if(isset($this_rate_det->rate) && isset($this_rate_det->duration)){
    		    $this_rate = $this_rate_det->rate;
    		    $this_duration = $this_rate_det->duration;
    		  }else{
    		    $this_rate = 1;
    		    $this_duration = 1;
    		  }
    		  if($rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1)==60){
    		    $rate_cost = 0;
    		  }else{
    		    $rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1);
    		  }
				// 	$this_rate = $this_rate_det->rate;
				// 	$this_duration = $this_rate_det->duration;
				// 	$rate_cost=$this_rate=round(($this_rate*(60/$this_duration)) *($incantation_length/60),-1);
				}
				$myTotalRate=$myTotalRate+$rate_cost;
			}
			return $myTotalRate;
		}else{
			return 0;
		}
	}

	public static function GetAllCompanyAve($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT * from story_industry, story_mention, story, mediahouse where story_industry.industry_id = "" and story_mention.client_id!='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_mention.story_id and mediahouse.Media_House_ID=story.Media_House_ID order by StoryDate asc';
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
					$picture = $key->picture;
					if($picture=='color'){
						$color_code = $weekday.'_c';
					}else{
						$color_code = $weekday.'_b';
					}
					$rate = Ratecard::model()->find('Media_House_ID=:a AND color_code=:b', array(':a'=>$Media_House_ID,':b'=>$color_code))->rate;
					$this_rate = $rate*$col*$centimeter;
				}else{
					$words = $StoryDuration;
					$StoryPlacement=$StoryTime;
          $Journalist="n/a";

          $incantation_length=str_replace("sec","",$incantation_length);
					$sql_electronic_rate='SELECT rate,duration from forgedb.ratecard_base, reelmedia.anvil_match
					where ratecard_base.station_id=anvil_match.station_id and anvil_match.Media_House_ID='.$Media_House_ID.'
					and forgedb.ratecard_base.weekday="'.$weekday.'" and forgedb.ratecard_base.time_start<="'.$StoryTime.'"
					order by forgedb.ratecard_base.duration,  ratecard_base.date_start desc,ratecard_base.time_start desc, forgedb.ratecard_base.time_end asc limit 1';
					$this_rate_det = RatecardBase::model()->findBySql($sql_electronic_rate);
					$this_rate = $this_rate_det->rate;
					$this_duration = $this_rate_det->duration;
					$rate_cost=number_format($this_rate=round(($this_rate*(60/$this_duration)) *($incantation_length/60),-1));
				}
				$myTotalRate=$myTotalRate+$this_rate;
			}
			return $myTotalRate;
		}else{
			return 0;
		}
	}

	public static function GetShareVoiceMediaTV($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mt01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	public static function GetShareVoiceMediaRadio($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mr01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	public static function GetShareVoiceMediaPrint($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story.Media_ID= "mp01"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	public static function GetShareVoiceIndustry($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT count(story.story_id) as mentions, company_name, company.company_id, story_mention.client_id from story_industry, story , story_mention, industry_company,company where story_industry.story_id= story_mention.story_id and story_industry.industry_id=industry_company.industry_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and company.company_id!='.$client.' and industry_company.company_id=company.company_id and story_mention.client_id=company.company_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') group by company_name order by mentions desc limit 9';
		return $sq = StoryMention::model()->findAllBySql($q1);
	}

	public static function GetShareVoiceCount($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT story.story_id as mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') ';
		return $sq = count(StoryMention::model()->findAllBySql($q1));
	}

	public static function GetCategories()
	{
		$categories = Category::model()->findAll();
		return $categories;
	}

	public static function GetCatCount($client,$startdate,$enddate,$industry,$cat,$backdate)
	{
		$q1 = 'SELECT story.story_id as number_mentions from story_industry, story , story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and Category_ID="'.$cat.'" and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') ';
		return $sq = count(StoryMention::model()->findAllBySql($q1));
	}

	public static function GetPictures()
	{
		$sql = 'SELECT distinct(picture) from story where picture!=""';
		$pics = Story::model()->findAllBySql($sql);
		return $pics;
	}

	public static function GetPicCount($client,$startdate,$enddate,$industry,$pic,$backdate)
	{
		$q1 = 'SELECT story.picture as number_pictures from story_industry, story, story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and picture="'.$pic.'"';
		return $sq = count(Story::model()->findAllBySql($q1));
	}

	public static function GetTonality($client,$startdate,$enddate,$industry,$backdate)
	{
		$q1 = 'SELECT count(story.story_id) as number_tonality, mediamap_analysis.tonality from story_industry, story,mediamap_analysis, story_mention where story_mention.client_id='.$client.' and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and mediamap_analysis.story_id=story_industry.story_id and mediamap_analysis.company_id='.$client.' group by mediamap_analysis.tonality';
		return $sq = MediamapAnalysis::model()->findAllBySql($q1);
	}

	public static function GetSpTonality($client,$startdate,$enddate,$industry,$tonality,$backdate)
	{
		$q1 = 'SELECT story.story_id as number_tonality, mediamap_analysis.tonality from story_industry, story,mediamap_analysis, story_mention where story_mention.client_id='.$client.'  and story_industry.story_id= story_mention.story_id and story_industry.story_id=story.story_id and story_industry.industry_id IN ('.$industry.') and story.StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.StoryDate>"'.$backdate.'" and story.story_id= story_industry.story_id and mediamap_analysis.story_id=story_industry.story_id and mediamap_analysis.company_id='.$client.' and mediamap_analysis.tonality="'.$tonality.'"';
		return $sq = count(MediamapAnalysis::model()->findAllBySql($q1));
	}
}