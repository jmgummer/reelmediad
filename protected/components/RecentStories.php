<?php

/**
* RecentStories Component Class
* This Class Is Used To Generate User Stories
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version     v.1.0
* @since       July 2008
*/

/**
* This Class Is used to Populate the Home View of Every Client
*/
class RecentStories{

/**
* This function handles all the heavylifting for Print Stories, fetch story and print out
* NB - Just for the Print Section
*/
public static function PrintStories($client)
{
	if($clientstories = StoryClient::model()->findAllBySql("SELECT story_id FROM story_client WHERE client_id = $client ORDER BY auto_id DESC LIMIT 20")){
		echo RecentStories::PrintTableHead();
		foreach ($clientstories as $key) {
			if($story = RecentStories::GetStories($key->story_id)){
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,Story::ClientTonality($story->Story_ID,$client),$story->AVE);
			}
		}
		echo RecentStories::PrintTableEnd();
	}else{
		return 'No Stories exist';
	}
}

public static function GetClientStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	if(!empty($search)){
		$searchqry = " AND ( (story like '%$search%') OR (title like '%$search%') OR (mentioned like '%$search%') ) ";
	}else{
		$searchqry = " ";
	}
	if(!empty($industries)){
		$q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,
		story.StoryTime,story.picture , story.Media_ID, story.print_rate, story.uniqueID
		FROM story inner join story_mention on story.Story_ID=story_mention.story_id 
		inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
		INNER JOIN story_industry on story_industry.story_id=story.Story_ID 
		INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
		where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		AND story.cont_from = 0 
		and StoryDate between "'.$startdate.'" and "'.$enddate.'"  '.$searchqry.'
		and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
		order by StoryDate asc, Media_House_List asc, page_no asc';
	}else{
		$q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , 
		story.StoryDuration,  story.StoryTime,story.picture ,
		story.Media_ID, story.print_rate, story.uniqueID
		FROM story inner join story_mention on story.Story_ID=story_mention.story_id 
		inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
		where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		AND story.cont_from = 0 
		and StoryDate between "'.$startdate.'" and "'.$enddate.'"  '.$searchqry.'
		order by StoryDate asc, Media_House_List asc, page_no asc';
	}
	// echo $q2;
	if($story = Story::model()->findAllBySql($q2)){
		if(Yii::app()->user->usertype=='agency'){
			echo RecentStories::AgencyPrintTableHead();
			foreach ($story as $key) {
				echo RecentStories::AgencyPrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
			}
			echo RecentStories::PrintTableEnd();
		}else{
			echo RecentStories::PrintTableHead();
			foreach ($story as $key) {
				echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
			}
			echo RecentStories::PrintTableEnd();
		}
	}else{
		echo 'No Records Found';
	}
}

public static function GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	if(!empty($search)){
		$searchqry = " AND ( (story like '%$search%') OR (title like '%$search%') OR (mentioned like '%$search%') ) ";
	}else{
		$searchqry = " ";
	}
	if(!empty($industries)){
		$q2 = 'SELECT DISTINCT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID, story.uniqueID, story.ave
		from story,story_mention,mediahouse,industry_subs,story_industry
		where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
		and story.Media_ID!="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and StoryDate between "'.$startdate.'" and "'.$enddate.'" '.$searchqry.'
		and story_industry.story_id=story.Story_ID and story_industry.industry_id = industry_subs.industry_id
		and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
		and story.Media_House_ID=mediahouse.Media_House_ID
		order by StoryDate asc, Media_House_List asc, StoryTime desc';
	}else{
		$q2 = 'SELECT DISTINCT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID, story.uniqueID, story.ave
		from story,story_mention,mediahouse
		where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
		and story.Media_ID!="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and StoryDate between "'.$startdate.'" and "'.$enddate.'" '.$searchqry.' and story.Media_House_ID=mediahouse.Media_House_ID
		order by StoryDate asc, Media_House_List asc, StoryTime desc';
	}
	// echo $q2;

	if($story = Story::model()->findAllBySql($q2)){
		if(Yii::app()->user->usertype=='agency'){
			$radio_section = "";
			$tv_section = "";
			foreach ($story as $key) {
				if($key->Media_ID=='mr01'){
					$radio_section .= RecentStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}else{
					$tv_section .= RecentStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}
			}
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
			echo RecentStories::AgencyElectronicTableHead();
			echo $radio_section;
			echo RecentStories::ElectronicTableEnd();
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
			echo RecentStories::AgencyElectronicTableHead();
			echo $tv_section;
			echo RecentStories::ElectronicTableEnd();

		}else{

			$radio_section = "";
			$tv_section = "";
			foreach ($story as $key) {
				if($key->Media_ID=='mr01'){
					$radio_section .= RecentStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}else{
					$tv_section .= RecentStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}
			}
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
			echo RecentStories::ElectronicTableHead();
			echo $radio_section;
			echo RecentStories::ElectronicTableEnd();
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
			echo RecentStories::ElectronicTableHead();
			echo $tv_section;
			echo RecentStories::ElectronicTableEnd();
		}
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	if(!empty($search)){
		$searchqry = " AND ( (story.story like '%$search%') OR (story.title like '%$search%') OR (story.mentioned like '%$search%') ) ";
	}else{
		$searchqry = " ";
	}
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
	story.editor,story.Media_House_ID,
	story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
	story.StoryTime,story.picture , story.Media_ID, story.print_rate, story.uniqueID, story.ave
	from story, story_industry, industry_subs, mediahouse
	where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
	and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
	and story_industry.industry_id=industry_subs.industry_id';
	if(!empty($industries)){
	  $q2 .= ' and industry_subs.industry_id IN('.$industries.')';
	}
	$q2 .=' and story.Media_ID="mp01"
	and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
	AND story.cont_from = 0 
	and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
	'.$searchqry.' and story.Media_House_ID=mediahouse.Media_House_ID
	order by StoryDate asc, Media_House_List asc, page_no asc';
	if($story = Story::model()->findAllBySql($q2)){
		if(Yii::app()->user->usertype=='agency'){
			echo RecentStories::AgencyPrintTableHead();
			foreach ($story as $key) {
				echo RecentStories::AgencyPrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
			}
			echo RecentStories::PrintTableEnd();
		}else{
			echo RecentStories::PrintTableHead();
			foreach ($story as $key) {
				echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->StoryColumn,$key->ContinuingAve,$key->uniqueID);
			}
			echo RecentStories::PrintTableEnd();
		}
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	if(!empty($search)){
		$searchqry = " AND ( (story.story like '%$search%') OR (story.title like '%$search%') OR (story.mentioned like '%$search%') ) ";
	}else{
		$searchqry = " ";
	}
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
	story.editor,story.Media_House_ID,
	story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  
	story.StoryTime,story.picture , story.Media_ID, story.uniqueID, story.ave
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
	'.$searchqry.' and story.Media_House_ID=mediahouse.Media_House_ID
	order by StoryDate asc, Media_House_List asc';
	if($story = Story::model()->findAllBySql($q2)){
		if(Yii::app()->user->usertype=='agency'){

			$radio_section = "";
			$tv_section = "";
			
			foreach ($story as $key) {
				if($key->Media_ID=='mr01'){
					$radio_section .= RecentStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}else{
					$tv_section .= RecentStories::AgencyElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}
			}

			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
			echo RecentStories::AgencyElectronicTableHead();
			echo $radio_section;
			echo RecentStories::ElectronicTableEnd();
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
			echo RecentStories::AgencyElectronicTableHead();
			echo $tv_section;
			echo RecentStories::ElectronicTableEnd();

		}else{
			
			$radio_section = "";
			$tv_section = "";
			foreach ($story as $key) {
				if($key->Media_ID=='mr01'){
					$radio_section .= RecentStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}else{
					$tv_section .= RecentStories::ElectronicTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,Story::ClientIndustryCategory($key->Story_ID,$client),Story::ClientTonality($key->Story_ID,$client),$key->AVE,$key->Link,$key->Continues,$key->uniqueID);
				}
			}

			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>RADIO</strong></td></tr></table>';
			echo RecentStories::ElectronicTableHead();
			echo $radio_section;
			echo RecentStories::ElectronicTableEnd();
			echo '<table id="dt_basic" class="table table-striped table-bordered"><tr><td><strong>TV</strong></td></tr></table>';
			echo RecentStories::ElectronicTableHead();
			echo $tv_section;
			echo RecentStories::ElectronicTableEnd();
			
		}
	}else{
		echo 'No Records Found';
	}
}

public static function getClientPrint($client_id)
{
	/* Using Sammy's Query - Simple and Clean, but adding Joins */
	$mainsql = "SELECT * from story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id=".$client_id." and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' order by Media_House_List asc, StoryDate desc, page_no asc";
}

public static function getClientIndustry()
{
	$inda = "SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (SELECT story_id from story_mention where client_id='1') and story.story_id=story_industry.story_id and industry_subs.company_id='' and story_industry.industry_id=industry_subs.industry_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-06-03' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc";
}
/*
* This Function obtains a particular story only
*/
public static function GetStories($story_id){
	if($story = Story::model()->find('Story_ID=:a', array(':a'=>$story_id))){
		return $story;
	}
}

/*
* Print The Top Section of Every Table
* NB - Just for the Print Section
*/
public static function PrintTableHead(){
	$country = Yii::app()->user->country_id;
	if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
		$currency = $currency->currency;
	}else{
		$currency = 'KES';
	}
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
	</thead>';
}

public static function AgencyPrintTableHead(){
	$country = Yii::app()->user->country_id;
	if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
		$currency = $currency->currency;
	}else{
		$currency = 'KES';
	}
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th><th style="text-align:right;">PRV('.$currency.')</th>
	</thead>';
}

/*
* Print The Top Section of Every Table
* NB - Just for the Electronic Section
*/
public static function ElectronicTableHead(){
	$country = Yii::app()->user->country_id;
	if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
		$currency = $currency->currency;
	}else{
		$currency = 'KES';
	}
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
	</thead>';
}

public static function AgencyElectronicTableHead(){
	$country = Yii::app()->user->country_id;
	if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
		$currency = $currency->currency;
	}else{
		$currency = 'KES';
	}
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th><th style="text-align:right;">PRV('.$currency.')</th>
	</thead>';
}
/*
* Print The Body of the Table This function may be called recursively
* NB - Just for the Print Section
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

public static function AgencyPrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$StoryColum,$ContinuingAve,$uniqueID){
	// Obtain the Agency ID from Session
	$printplayer = Yii::app()->params['printplayer'];
	$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
	$agency_id = Yii::app()->user->company_id;
	$sql_agency_pr="SELECT agency_pr_rate  from agency where agency_id=$agency_id";
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

/*
* Print The Body of the Table This function may be called recursively
* NB - Just for the Electronic Section
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

public static function AgencyElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID){
	// Obtain the Agency ID from Session
	$electronicplayer = Yii::app()->params['electronicplayer'];
	$link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
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

/*
* Close the Table and Its Bottom section
* NB - Just for the Print Section
*/
public static function PrintTableEnd(){
	return '</table></div></div>';
}

/*
* Close the Table and Its Bottom section
* NB - Just for the Electronic Section
*/
public static function ElectronicTableEnd(){
	return '</table></div></div>';
}

}


?>