<?php

/**
* HtmlStories Component Class
* This Class Is Used To Generate HTML Files for Client Strories
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

class HtmlStories{

	/**
	*
	* @return  Return the Table Header
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function HtmlHeader(){
		$style = '';
		$style = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
		$style.= "<head>";
		$style.= "<title>Reelforge HTML Compilation</title>";
		$style.= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">';
		$style.= '<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">';
		$style.= HtmlStories::Stylesheet();
		$style.= "</head>";
		$style.= "<body>";
		$style.= "<div class='container-fluid'>";
		return $style;
	}

	/**
	*
	* @return  Return HTML Body
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function FileBody($content){
		$body  = '';
		$body .= HtmlStories::HtmlHeader();
		$body .= $content;
		$body .= '</div></body></html>';
		return $body;
	}

	/**
	*
	* @return  Return HTML Print Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintStories($client){
		if($clientstories = StoryClient::model()->findAllBySql("SELECT story_id FROM story_client WHERE client_id = $client ORDER BY auto_id DESC LIMIT 20")){
			echo HtmlStories::PrintTableHead();
			foreach ($clientstories as $key) {
				if($story = HtmlStories::GetStories($key->story_id)){
					echo HtmlStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE);
				}
			}
			echo HtmlStories::PrintTableEnd();
		}else{
			return 'No Stories exist';
		}
	}

	/**
	*
	* @return  Return HTML Print Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries){
		$data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		if(!empty($industries)){
			$q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
			story.cont_on,story.cont_from,story.editor,
			story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
			story.StoryTime,story.picture ,
			story.Media_ID, story.print_rate, story.uniqueID
			FROM story inner join story_mention on story.Story_ID=story_mention.story_id 
			INNER JOIN mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			INNER JOIN story_industry on story_industry.story_id=story.Story_ID 
			INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
			where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
			order by StoryDate asc, Media_House_List asc, page_no asc';
		}else{
			$q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.cont_on,story.cont_from,story.editor,
			story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture ,
			story.Media_ID , story.print_rate, story.uniqueID
			FROM story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			order by StoryDate asc, Media_House_List asc, page_no asc';
		}
		
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$data .= HtmlStories::AgencyPrintTableHead();
				foreach ($story as $key) {
					$data .=  HtmlStories::AgencyPrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
				}
				$data .=  HtmlStories::PrintTableEnd();
			}else{
				$data .=  HtmlStories::PrintTableHead();
				foreach ($story as $key) {
					$data .=  HtmlStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
				}
				$data .=  HtmlStories::PrintTableEnd();
			}
		}else{
			$data .=  'No Records Found';
		}
		return $data;
	}

	/**
	*
	* @return  Return HTML Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries){
		$data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,
		story.Media_House_ID,
		story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
		story.StoryTime,story.picture ,
		story.Media_ID, story.print_rate, story.uniqueID
		from story,story_mention,mediahouse
		where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
		and story.Media_ID!="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" 
		and story.Media_House_ID=mediahouse.Media_House_ID
		order by StoryDate asc, Media_House_List asc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				
				$radio_section = "";
				$tv_section = "";
				
				foreach ($story as $key) {
					if($key->Media_ID=='mr01'){
						$radio_section .= HtmlStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}else{
						$tv_section .= HtmlStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}
				}

				if($radio_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
					$data .=  HtmlStories::AgencyElectronicTableHead();
					$data .=  $radio_section;
					$data .=  HtmlStories::ElectronicTableEnd();
					$data .=  "<br>";
				}
				
				if($tv_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
					$data .=  HtmlStories::AgencyElectronicTableHead();
					$data .=  $tv_section;
					$data .=  HtmlStories::ElectronicTableEnd();
				}

			}else{

				$radio_section = "";
				$tv_section = "";
				foreach ($story as $key) {
					if($key->Media_ID=='mr01'){
						$radio_section .= HtmlStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}else{
						$tv_section .= HtmlStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}
				}

				if($radio_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
					$data .=  HtmlStories::ElectronicTableHead();
					$data .=  $radio_section;
					$data .=  HtmlStories::ElectronicTableEnd();
					$data .=  "<br>";
				}
					
				if($tv_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
					$data .=  HtmlStories::ElectronicTableHead();
					$data .=  $tv_section;
					$data .=  HtmlStories::ElectronicTableEnd();
				}
					
			}
		}else{
			$data .=  'No Records Found';
		}
		return $data;
	}

	/**
	*
	* @return  Return HTML Industry Print Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries){
		$data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
		story.StoryTime,story.picture , story.Media_ID,	story.print_rate, story.uniqueID
		from story, story_industry, industry_subs, mediahouse
		where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
		and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
		and story_industry.industry_id=industry_subs.industry_id';
		if(!empty($industries)){
		  $q2 .= ' and industry_subs.industry_id IN('.$industries.')';
		}
		$q2 .=' and story.Media_ID="mp01"
		and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
		and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
		order by StoryDate asc, Media_House_List asc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$data .=  HtmlStories::AgencyPrintTableHead();
				foreach ($story as $key) {
					$data .=  HtmlStories::AgencyPrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
				}
				$data .=  HtmlStories::PrintTableEnd();
			}else{
				$data .=  HtmlStories::PrintTableHead();
				foreach ($story as $key) {
					$data .=  HtmlStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
				}
				$data .=  HtmlStories::PrintTableEnd();
			}
		}else{
			$data .=  'No Records Found';
		}
		return $data;
	}

	/**
	*
	* @return  Return HTML Electronic Industry Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries){
		$data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
		story.StoryTime,story.picture , story.Media_ID, story.print_rate, story.uniqueID
		from story, story_industry, industry_subs, mediahouse
		where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
		and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
		and story_industry.industry_id=industry_subs.industry_id ';
		if(!empty($industries)){
		  $q2 .= ' and industry_subs.industry_id IN('.$industries.')';
		}
		$q2 .='	and story.Media_ID!="mp01"
		and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
		and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
		order by StoryDate asc, Media_House_List asc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){

				$radio_section = "";
				$tv_section = "";
				
				foreach ($story as $key) {
					if($key->Media_ID=='mr01'){
						$radio_section .= HtmlStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}else{
						$tv_section .= HtmlStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}
				}

				if($radio_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
					$data .=  HtmlStories::AgencyElectronicTableHead();
					$data .=  $radio_section;
					$data .=  HtmlStories::ElectronicTableEnd();
					$data .=  "<br>";
				}

				if($tv_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
					$data .=  HtmlStories::AgencyElectronicTableHead();
					$data .=  $tv_section;
					$data .=  HtmlStories::ElectronicTableEnd();
				}

			}else{
				
				$radio_section = "";
				$tv_section = "";
				foreach ($story as $key) {
					if($key->Media_ID=='mr01'){
						$radio_section .= HtmlStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}else{
						$tv_section .= HtmlStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
					}
				}

				if($radio_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
					$data .=  HtmlStories::ElectronicTableHead();
					$data .=  $radio_section;
					$data .=  HtmlStories::ElectronicTableEnd();
					$data .=  "<br>";
				}

				if($tv_section!=""){
					$data .=  '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
					$data .=  HtmlStories::ElectronicTableHead();
					$data .=  $tv_section;
					$data .=  HtmlStories::ElectronicTableEnd();
				}

				
				
				
			}
		}else{
			$data .=  'No Records Found';
		}
		return $data;
	}

	/**
	*
	* @return  Return Print Story
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function getClientPrint($client_id){
		/* Using Sammy's Query - Simple and Clean, but adding Joins */
		// $mainsql = "select * from story,story_mention, mediahouse where story_mention.client_id=".$client_id." and story.Story_ID=story_mention.story_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc, page_no asc"
		$mainsql = "select * from story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id=".$client_id." and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' order by Media_House_List asc, StoryDate desc, page_no asc";
	}

	/**
	*
	* @return  Return Client Industry
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function getClientIndustry()
	{
		$inda = "select distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (select story_id from story_mention where client_id='1') and story.story_id=story_industry.story_id and industry_subs.company_id='' and story_industry.industry_id=industry_subs.industry_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-06-03' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc";
	}

	/**
	*
	* @return  Return Single Story based on Story ID
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
	* @return  Return HTML Table Head
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/ 

	public static function PrintTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<table class="table table-striped table-condensed table-hover table-bordered"><tr>
		<td style="width:11%;">DATE</td><td>PUBLICATION</td><td>JOURNALIST</td><td>HEADLINE/SUBJECT</td><td>PAGE</td><td>PUBLICATION TYPE</td><td>PICTURE</td><td>EFFECT</td><td style="text-align:right;">AVE('.$currency.')</td>
		</tr>';
	}

	/**
	*
	* @return  Return Print Table Head for Agencies
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function AgencyPrintTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<table class="table table-striped table-condensed table-hover table-bordered"><tr>
		<td style="width:11%;">DATE</td><td>PUBLICATION</td><td>JOURNALIST</td><td>HEADLINE/SUBJECT</td><td>PAGE</td><td>PUBLICATION TYPE</td><td>PICTURE</td><td>EFFECT</td><td style="text-align:right;">AVE('.$currency.')</td><td style="text-align:right;">PRV('.$currency.')</td>
		</tr>';
	}

	/**
	*
	* @return  Return Electronic Table Head
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<table class="table table-striped table-condensed table-hover table-bordered"><tr>
		<td style="width:11%;">DATE</td><td>STATION</td><td>JOURNALIST</td><td>SUMMARY</td><td>TIME</td><td>DURATION</td><td>CATEGORY</td><td>EFFECT</td><td style="text-align:right;">AVE('.$currency.')</td>
		</tr>';
	}

	/**
	*
	* @return  Return Agency Electronic Table Head
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/
	public static function AgencyElectronicTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<table class="table table-striped table-condensed table-hover table-bordered"><tr>
		<td style="width:11%;">DATE</td><td>STATION</td><td>JOURNALIST</td><td>SUMMARY</td><td>TIME</td><td>DURATION</td><td>CATEGORY</td><td>EFFECT</td><td style="text-align:right;">AVE('.$currency.')</td><td style="text-align:right;">PRV('.$currency.')</td>
		</tr>';
	}

	/**
	*
	* @return  Return Print Body Row
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$StoryColum,$ContinuingAve,$uniqueID){
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ContinuingAve).'</td>
		</tr>';
	}

	/**
	*
	* @return  Return Agency Print Body Row
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function AgencyPrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$StoryColum,$ContinuingAve,$uniqueID){
		// Obtain the Agency ID from Session
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="select agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ContinuingAve).'</td>
		<td style="text-align:right;">'.number_format($ContinuingAve*$agency_pr_rate).'</td>
		</tr>';
	}

	/**
	*
	* @return  Return Electronic Table Row
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
	* @return  Return Agency Electronic Table Row
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function AgencyElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID){
		$electronicplayer = Yii::app()->params['electronicplayer'];
		$link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		// Obtain the Agency ID from Session
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="select agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}
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
		<td style="text-align:right;">'.number_format($ave*$agency_pr_rate).'</td>
		</tr>';
	}
	
	/**
	*
	* @return  Return HTML Body End
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableEnd(){
		return '</table>';
	}

	/**
	*
	* @return  Return HTML Body End
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicTableEnd(){
		return '</table>';
	}

	/**
	*
	* @return  Return Stylesheet
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function Stylesheet(){
		$style = '<style type="text/css">';
		$style .= 'body{ font-family: "Open Sans",Arial,Helvetica,Sans-Serif; font-size: 12px !important; }';
		$style .= '</style>';
		return $style;
	}

}


?>