<?php

/**
* Csr Component Class
* This Class Is Used To Return The Csr Stories
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

class Csr{

	/**
	*
	* @return  Return Client Print Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/
	
	public static function GetClientStory($client,$startdate,$enddate,$search)
	{
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT * FROM story inner join story_mention on story.Story_ID=story_mention.story_id 
		inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id='.$client.' 
		and story.Media_ID="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" 
		and title like "%'.$search.'%" 
		and story.csr=1 order by Media_House_List asc, StoryDate desc, page_no asc';
		if($story = Story::model()->findAllBySql($q2)){
			echo Csr::PrintTableHead();
			foreach ($story as $key) {
				if($story = Csr::GetStories($key->Story_ID)){
					echo Csr::PrintTableBody($story->Story_ID,$story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,Story::ClientTonality($story->Story_ID,$client),$story->AVE,$story->Link,$story->Continues,$story->uniqueID);
				}
			}
			echo Csr::PrintTableEnd();
		}else{
			echo 'No Records Found';
		}
	}

	/**
	*
	* @return  Return Client Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetElectronicStory($client,$startdate,$enddate,$search)
	{
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT * from story,story_mention,mediahouse where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id 
		and story.Media_ID!="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" 
		and story.Media_House_ID=mediahouse.Media_House_ID 
		and title like "%'.$search.'%" 
		and story.csr=1 order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			echo Csr::ElectronicTableHead();
			foreach ($story as $key) {
				if($story = Csr::GetStories($key->Story_ID)){
					echo Csr::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					// echo Csr::PrintTableBody($story->Story_ID,$story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality,$story->Link,$story->Continues);
				}
			}
			echo Csr::PrintTableEnd();
		}else{
			echo 'No Records Found';
		}
	}

	/**
	*
	* @return  Return Industry Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientIndustryStory($client,$startdate,$enddate,$search)
	{
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story 
		from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.') and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.' 
		and story_industry.industry_id=industry_subs.industry_id and story.Media_ID="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" 
		and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID 
		and story.csr=1 order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			echo Csr::PrintTableHead();
			foreach ($story as $key) {
				if($story = Csr::GetStories($key->Story_ID)){
					echo Csr::PrintTableBody($story->Story_ID,$story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,Story::ClientTonality($story->Story_ID,$client),$story->AVE,$story->Link,$story->Continues,$story->uniqueID);
				}
			}
			echo Csr::PrintTableEnd();
		}else{
			echo 'No Records Found';
		}
	}

	/**
	*
	* @return  Return Industry Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search)
	{
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse 
		where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.') and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.' and story_industry.industry_id=industry_subs.industry_id 
		and story.Media_ID!="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" 
		and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID and story.csr=1 order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			echo Csr::ElectronicTableHead();
			foreach ($story as $key) {
				if($story = Csr::GetStories($key->Story_ID)){
					echo Csr::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					// echo Csr::PrintTableBody($story->Story_ID,$story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality,$story->Link,$story->Continues);
				}
			}
			echo Csr::PrintTableEnd();
		}else{
			echo 'No Records Found';
		}
	}

	/**
	*
	* @return  Return A Particular Story based on Story ID
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetStories($story_id){
		if($story = Story::model()->find('Story_ID=:a', array(':a'=>$story_id))){
			return $story;
		}
	}

	/**
	*
	* @return  Return Table Head for Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}


	/**
	*
	* @return  Return Table Head for Print Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th>AVE('.$currency.')</th>
		</thead>';
	}
	
	/**
	*
	* @return  Return Table Body for Print
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableBody($Story_ID,$date,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID){
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$Story_ID.'&encryptid='.$uniqueID;
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td>'.$ave.'</td>
		</tr>';
	}

	/**
	*
	* @return  Return the Table body for Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID){
		$electronicplayer = Yii::app()->params['electronicplayer'];
		$link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ave).'</td>
		</tr>';
	}
	
	/**
	*
	* @return  Return the Table End
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableEnd(){
		return '</table></div></div>';
	}
}
?>