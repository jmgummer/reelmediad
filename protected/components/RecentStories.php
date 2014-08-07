<?php
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
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE);
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
	if(!empty($industries)){
	  $q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID 
	  FROM story
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
	  $q2 = 'SELECT distinct story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID 
			FROM story
  	inner join story_mention on story.Story_ID=story_mention.story_id
  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
  	order by Media_House_List asc, StoryDate desc, page_no asc';
	}
	
	if($story = Story::model()->findAllBySql($q2)){
		echo RecentStories::PrintTableHead();
		foreach ($story as $key) {
			echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,$key->Tonality,$key->AVE,$key->Link,$key->Continues);
			// if($story = RecentStories::GetStories($key->Story_ID)){
			// 	echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			// }
		}
		echo RecentStories::PrintTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID from story,story_mention,mediahouse
	where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
	and story.Media_ID!="mp01" and story.step3=1
	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
	order by Media_House_List asc, StoryDate desc';
	if($story = Story::model()->findAllBySql($q2)){
		echo RecentStories::ElectronicTableHead();
		foreach ($story as $key) {
			echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,$key->IndustryCategory,$key->Tonality,$key->AVE,$key->Link,$key->Continues);
			// if($story = RecentStories::GetStories($key->Story_ID)){
			// 	echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->IndustryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			// }
		}
		echo RecentStories::ElectronicTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID
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
		echo RecentStories::PrintTableHead();
		foreach ($story as $key) {
			echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->StoryPage,$key->PublicationType,$key->Picture,$key->Tonality,$key->AVE,$key->Link,$key->Continues);
			// if($story = RecentStories::GetStories($key->Story_ID)){
			// 	echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			// }
		}
		echo RecentStories::PrintTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID
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
		echo RecentStories::ElectronicTableHead();
		foreach ($story as $key) {
			echo RecentStories::PrintTableBody($key->StoryDate,$key->Story_ID,$key->Publication,$key->journalist,$key->Title,$key->FormatedTime,$key->FormatedDuration,$key->IndustryCategory,$key->Tonality,$key->AVE,$key->Link,$key->Continues);
			// if($story = RecentStories::GetStories($key->Story_ID)){key
			// 	echo RecentStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->IndustryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			// }
		}
		echo RecentStories::ElectronicTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function getClientPrint($client_id)
{
	/* Using Sammy's Query - Simple and Clean, but adding Joins */
	// $mainsql = "select * from story,story_mention, mediahouse where story_mention.client_id=".$client_id." and story.Story_ID=story_mention.story_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc, page_no asc"
	$mainsql = "select * from story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id=".$client_id." and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-05-29' order by Media_House_List asc, StoryDate desc, page_no asc";
}

public static function getClientIndustry()
{
	$inda = "select distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (select story_id from story_mention where client_id='1') and story.story_id=story_industry.story_id and industry_subs.company_id='' and story_industry.industry_id=industry_subs.industry_id and story.Media_ID='mp01' and story.step3=1 and StoryDate ='2014-06-03' and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc";
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
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE(Kshs.)</th>
	</thead>';
}

/*
* Print The Top Section of Every Table
* NB - Just for the Electronic Section
*/
public static function ElectronicTableHead(){
	return '<div class="widget-body">
	<div>
	<table id="dt_basic" class="table table-striped table-bordered table-hover">
	<thead>
	<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>EFFECT</th><th style="text-align:right;">AVE(Kshs.)</th>
	</thead>';
}
/*
* Print The Body of the Table This function may be called recursively
* NB - Just for the Print Section
*/
public static function PrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont){
	return '<tr>
	<td><a href="'.Yii::app()->createUrl("swf/view").'/'.$storyid.'" target="_blank">'.$date.'</a></td>
	<td>'.$pub.'</td>
	<td>'.$journo.'</td>
	<td><a href="'.Yii::app()->createUrl("swf/view").'/'.$storyid.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
	<td>'.$page.'</td>
	<td>'.$pubtype.'</td>
	<td>'.$pic.'</td>
	<td>'.$effect.'</td>
	<td style="text-align:right;">'.number_format($ave).'</td>
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