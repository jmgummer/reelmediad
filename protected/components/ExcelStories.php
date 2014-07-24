<?php
/**
* This Class Is used to Generate Excel Sheets
*/
class ExcelStories{

/**
* This function handles all the heavylifting for Print Stories, fetch story and print out
* NB - Just for the Print Section
*/
public static function PrintStories($client)
{
	if($clientstories = StoryClient::model()->findAllBySql("SELECT story_id FROM story_client WHERE client_id = $client ORDER BY auto_id DESC LIMIT 20")){
		echo ExcelStories::PrintTableHead();
		foreach ($clientstories as $key) {
			if($story = ExcelStories::GetStories($key->story_id)){
				echo ExcelStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE);
			}
		}
		echo ExcelStories::PrintTableEnd();
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
		echo ExcelStories::PrintTableHead();
		foreach ($story as $key) {
			if($story = ExcelStories::GetStories($key->Story_ID)){
				echo ExcelStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			}
		}
		echo ExcelStories::PrintTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
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
		echo ExcelStories::ElectronicTableHead();
		foreach ($story as $key) {
			if($story = ExcelStories::GetStories($key->Story_ID)){
				echo ExcelStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->IndustryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			}
		}
		echo ExcelStories::ElectronicTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
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
		echo ExcelStories::PrintTableHead();
		foreach ($story as $key) {
			if($story = ExcelStories::GetStories($key->Story_ID)){
				echo ExcelStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->Picture,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			}
		}
		echo ExcelStories::PrintTableEnd();
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country_list,$industries)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
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
		echo ExcelStories::ElectronicTableHead();
		foreach ($story as $key) {
			if($story = ExcelStories::GetStories($key->Story_ID)){
				echo ExcelStories::PrintTableBody($story->StoryDate,$story->Story_ID,$story->Publication,$story->journalist,$story->Title,$story->FormatedTime,$story->FormatedDuration,$story->IndustryCategory,$story->Tonality,$story->AVE,$story->Link,$story->Continues);
			}
		}
		echo ExcelStories::ElectronicTableEnd();
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
	return '<table><tr>
	<td style="width:11%;">DATE</td><td>PUBLICATION</td><td>JOURNALIST</td><td>HEADLINE/SUBJECT</td><td>PAGE</td><td>PUBLICATION TYPE</td><td>PICTURE</td><td>EFFECT</td><td style="text-align:right;">AVE(Kshs.)</td>
	</tr>';
}

/*
* Print The Top Section of Every Table
* NB - Just for the Electronic Section
*/
public static function ElectronicTableHead(){
	return '<table><tr>
	<td style="width:11%;">DATE</td><td>STATION</td><td>JOURNALIST</td><td>SUMMARY</td><td>TIME</td><td>DURATION</td><td>CATEGORY</td><td>EFFECT</td><td style="text-align:right;">AVE(Kshs.)</td>
	</tr>';
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
	return '</table>';
}

/*
* Close the Table and Its Bottom section
* NB - Just for the Electronic Section
*/
public static function ElectronicTableEnd(){
	return '</table>';
}

}


?>