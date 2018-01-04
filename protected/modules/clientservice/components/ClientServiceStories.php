<?php
/**
* This Class Is used to Populate the Home View of Every Client
*/
class ClientServiceStories{

/**
* This function handles all the heavylifting for Print Stories, fetch story and print out
* NB - Just for the Print Section
*/

public static function GetClientStory($client,$startdate,$enddate,$search)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT * FROM story inner join story_mention on story.Story_ID=story_mention.story_id inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID  where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" order by Media_House_List asc, StoryDate desc, page_no asc';
	if($story = Story::model()->findAllBySql($q2)){
		foreach ($story as $key) {
			if($story = RecentStories::GetStories($key->Story_ID)){
				$st_tonality = Story::getTonalityID($key->Story_ID,$client);
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$st_tonality,$st_tonality,$story->Link,$story->Continues,$story->StoryImage);
			}
		}
	}else{
		echo 'No Records Found';
	}
}

public static function GetClientIndustryStory($client,$startdate,$enddate,$search)
{
	$month = date('m');
	$year = date('Y');
	$story_month = 'story_'.$year.'_'.$month;
	$q2 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story from story, story_industry, industry_subs, mediahouse where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.') and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.' and story_industry.industry_id=industry_subs.industry_id and story.Media_ID="mp01" and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID order by Media_House_List asc, StoryDate desc';
	if($story = Story::model()->findAllBySql($q2)){
		echo RecentStories::PrintTableHead();
		foreach ($story as $key) {
			if($story = RecentStories::GetStories($key->Story_ID)){
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality,$story->Link,$story->Continues);
			}
		}
		echo RecentStories::PrintTableEnd();
	}else{
		echo 'No Records Found';
	}
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
	<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th>
	</thead>';
}

/*
* Print The Body of the Table This function may be called recursively
* NB - Just for the Print Section
*/
public static function PrintTableBody($date,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$image){
	return '<div class="paper_container">
			<div class="paper_header">'.$pubtype.'Page'.$page.'<br>'.$date.'<br>'.$head.'<br></div>
			<div class="paper_content"><img src="'.$image.'" /></div>
			<div class="paper_footer"></div>
			</div>';
}
/*
* Close the Table and Its Bottom section
* NB - Just for the Print Section
*/
public static function PrintTableEnd(){
	return '</table></div></div>';
}

}
?>