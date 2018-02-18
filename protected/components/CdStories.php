<?php

/**
* CdStories Component Class
* This Class Is Used To Return The Users/Company Zip Archive
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

class CdStories{

	/**
	*
	* @return  Return Client Stories
	* @throws  InvalidArgumentException
	* @todo    This Generates all the client Stories
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries,$cd_name)
	{
		$client_data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		if(!empty($industries)){
		  $q2 = 'SELECT distinct story.Story_ID FROM story
	    inner join story_mention on story.Story_ID=story_mention.story_id
	    inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
	    INNER JOIN story_industry on story_industry.story_id=story.Story_ID
	    INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
	    where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
	    and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
	    and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
	    and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
	    order by Media_House_List asc, StoryDate desc, page_no asc';
		}else{
		  $q2 = 'SELECT distinct story.Story_ID FROM story
	  	inner join story_mention on story.Story_ID=story_mention.story_id
	  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
	  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
	  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
	  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
	  	order by Media_House_List asc, StoryDate desc, page_no asc';
		}
		
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$client_data.= CdStories::AgencyPrintTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data.= CdStories::AgencyPrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story);
					}
				}
			}else{
				$client_data.= CdStories::PrintTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data.= CdStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story);
					}
				}
			}
			$client_data.= CdStories::PrintTableEnd();
		}else{
			$client_data.= 'No Records Found';
		}
		return $client_data;
	}

	/**
	*
	* @return  Return Client Electronic Stories
	* @throws  InvalidArgumentException
	* @todo    This Generates all the client Stories
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries,$cd_name)
	{
		$client_data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT * from story,story_mention,mediahouse
		where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
		and story.Media_ID!="mp01" and story.step3=1
		and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
		and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
		order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$client_data .= CdStories::AgencyElectronicTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::AgencyElectronicTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->StoryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story,$story->file_path);
					}
				}
			}else{
				$client_data .= CdStories::ElectronicTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::ElectronicTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->StoryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story,$story->file_path);
					}
				}
			}
			$client_data .= CdStories::ElectronicTableEnd();
		}else{
			$client_data = 'No Records Found';
		}
		return $client_data;
	}

	/**
	*
	* @return  Return Client Industry Stories
	* @throws  InvalidArgumentException
	* @todo    This Generates all the client Stories
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries,$cd_name)
	{
		$client_data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story, story.ave
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
		order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$client_data .= CdStories::AgencyPrintTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::AgencyPrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story);
					}
				}
			}else{
				$client_data .= CdStories::PrintTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story);
					}
				}
			}
			$client_data .= CdStories::PrintTableEnd();
		}else{
			$client_data = 'No Records Found';
		}
		return $client_data;
	}

	/**
	*
	* @return  Return Client Industry Electronic Stories
	* @throws  InvalidArgumentException
	* @todo    This Generates all the client Stories
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries,$cd_name)
	{
		$client_data = '';
		$month = date('m');
		$year = date('Y');
		$story_month = 'story_'.$year.'_'.$month;
		$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story, story.ave
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
		order by Media_House_List asc, StoryDate desc';
		if($story = Story::model()->findAllBySql($q2)){
			if(Yii::app()->user->usertype=='agency'){
				$client_data .= CdStories::AgencyElectronicTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::AgencyElectronicTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->StoryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story,$story->file_path);
					}
				}
			}else{
				$client_data .= CdStories::ElectronicTableHead();
				foreach ($story as $key) {
					if($story = CdStories::GetStories($key->Story_ID)){
						$client_data .= CdStories::ElectronicTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->StoryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues,$story->file,$cd_name,$story->Story,$story->file_path);
					}
				}
			}
			$client_data .= CdStories::ElectronicTableEnd();
		}else{
			$client_data = 'No Records Found';
		}
		return $client_data;
	}

	public static function getClientPrint($client_id){
		/* Using Sammy's Query - Simple and Clean, but adding Joins */
		// $mainsql = "select * from story,story_mention, mediahouse where story_mention.client_id=".$client_id." and story.Story_ID=story_mention.story_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc, page_no asc"
		$mainsql = "select * from story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id=".$client_id." and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' order by Media_House_List asc, StoryDate desc, page_no asc";
	}

	public static function getClientIndustry(){
		$inda = "select distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (select story_id from story_mention where client_id='1') and story.story_id=story_industry.story_id and industry_subs.company_id='' and story_industry.industry_id=industry_subs.industry_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-06-03' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc";
	}

	/**
	*
	* @return  Return Particular Story based on ID
	* @throws  InvalidArgumentException
	* @todo    This Generates all the client Stories
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
	* @return  Return The Top Section of Every Table
	* @throws  InvalidArgumentException
	* @todo    Print The Top Section of Every Table
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
		return '<table class="table table-striped table-bordered table-hover"><thead>
		<th style="width:7%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	/**
	*
	* @return  Return The Top Section of Every Table, For Agencies
	* @throws  InvalidArgumentException
	* @todo    Print The Top Section of Every Table
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
		return '<table class="table table-striped table-bordered table-hover"><thead>
		<th style="width:7%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th><th style="text-align:right;">PRV('.$currency.')</th>
		</thead>';
	}

	/**
	*
	* @return  Return The Top Section of Every Table, For Electronic Stories
	* @throws  InvalidArgumentException
	* @todo    Print The Top Section of Every Table
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
		return '<table class="table table-striped table-bordered table-hover"><thead>
		<th style="width:7%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	/**
	*
	* @return  Return The Top Section of Every Table, For Electronic Stories, For Agencies
	* @throws  InvalidArgumentException
	* @todo    Print The Top Section of Every Table
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
		return '<table class="table table-striped table-bordered table-hover"><thead>
		<th style="width:7%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th><th style="text-align:right;">PRV('.$currency.')</th>
		</thead>';
	}

	/**
	*
	* @return  Return The Body Section of Every Table
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function PrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$file,$cd_name,$summary)
	{
		/* Create a Copy of Print Files */
		$copy_files = CompileCD::MovePrintFile($file,$date,$cd_name);

		/* Create the HTML Files, Individually */
		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/view/';
		$filename_html=$path. $storyid . ".html";
		$crunch = CompileCD::PrintBody($head,$pub,$date,$pubtype,$journo,$page,$ave,$summary,$link);
		$filecontent = $crunch;
		$file = $storyid.'.html';
		if (!$handle = fopen($filename_html, 'w')) {
			echo "Cannot open file ($filename_html')";
		}else{
			if (fwrite($handle, $filecontent) === FALSE) 
			{
				echo "Cannot write to file ($filename_html)";
			}
			fclose($handle);
		}

		/* Return The Table Row */
		return '<tr>
		<td><a href="view/'.$file.'" target="_blank" >'.$date.'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="view/'.$file.'" target="_blank" >'.$head.'</a></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ave).'</td>
		</tr>';
	}

	/**
	*
	* @return  Return The Body Section of Every Table, For Agencies
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function AgencyPrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$file,$cd_name,$summary)
	{
		/* Obtain the Agency ID from Session */
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="select agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}

		/* Create a Copy of Print Files */
		$copy_files = CompileCD::MovePrintFile($file,$date,$cd_name);

		/* Create the HTML Files, Individually */
		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/view/';
		$filename_html=$path. $storyid . ".html";
		$crunch = CompileCD::PrintBody($head,$pub,$date,$pubtype,$journo,$page,$ave,$summary,$link);
		$filecontent = $crunch;
		$file = $storyid.'.html';
		if (!$handle = fopen($filename_html, 'w')) {
			echo "Cannot open file ($filename_html')";
		}else{
			if (fwrite($handle, $filecontent) === FALSE) 
			{
				echo "Cannot write to file ($filename_html)";
			}
			fclose($handle);
		}

		/* Return The Table Row */
		return '<tr>
		<td><a href="view/'.$file.'" target="_blank" >'.$date.'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="view/'.$file.'" target="_blank" >'.$head.'</a></td>
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
	* @return  Return The Body Section of Every Table, For Electronic Stories
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$file,$cd_name,$summary,$filepath)
	{
		
		// Create the HTML Files, Individually

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/view/';
		$filename_html=$path. $storyid . ".html";
		$crunch = CompileCD::ElectronicBody($head,$pub,$date,$pubtype,$journo,$page,$ave,$summary,$link,$filepath);
		$filecontent = $crunch;
		$html_file = $storyid.'.html';
		if (!$handle = fopen($filename_html, 'w')) {
			echo "Cannot open file ($filename_html')";
		}else{
			if (fwrite($handle, $filecontent) === FALSE) 
			{
				echo "Cannot write to file ($filename_html)";
			}
			fclose($handle);
		}

		/* Create a Copy of Print Files */
		$copy_files = CompileCD::MoveElectronicFile($file,$date,$cd_name,$filepath);

		// Return The Table Row

		return '<tr>
		<td><a href="view/'.$html_file.'" target="_blank" >'.$date.'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="view/'.$html_file.'" target="_blank" >'.$head.'</a></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ave).'</td>
		</tr>';
	}

	/**
	*
	* @return  Return The Body Section of Every Table, For Electronic Stories, For Agencies
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function AgencyElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$file,$cd_name,$summary,$filepath)
	{
		
		// Obtain the Agency ID from Session
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="select agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}

		// Create the HTML Files, Individually

		$path=$_SERVER['DOCUMENT_ROOT'].'/reelmediad/cd/'.$cd_name.'/view/';
		$filename_html=$path. $storyid . ".html";
		$crunch = CompileCD::ElectronicBody($head,$pub,$date,$pubtype,$journo,$page,$ave,$summary,$link,$filepath);
		$filecontent = $crunch;
		$html_file = $storyid.'.html';
		if (!$handle = fopen($filename_html, 'w')) {
			echo "Cannot open file ($filename_html')";
		}else{
			if (fwrite($handle, $filecontent) === FALSE) 
			{
				echo "Cannot write to file ($filename_html)";
			}
			fclose($handle);
		}

		/* Create a Copy of Print Files */
		$copy_files = CompileCD::MoveElectronicFile($file,$date,$cd_name,$filepath);

		// Return The Table Row

		return '<tr>
		<td><a href="view/'.$html_file.'" target="_blank" >'.$date.'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="view/'.$html_file.'" target="_blank" >'.$head.'</a></td>
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
	* @return  Return The End Section of Every Table
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	* 	NB - Just for the Print Section
	*/

	/*
	* Close the Table and Its Bottom section
	*/
	public static function PrintTableEnd(){
		return '</table>';
	}

	/**
	*
	* @return  Return The End Section of Every Table
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	* 	NB - Just for the Print Section
	*/

	/*
	* Close the Table and Its Bottom section
	* NB - Just for the Electronic Section
	*/
	public static function ElectronicTableEnd(){
		return '</table>';
	}

}


?>