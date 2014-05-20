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
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality);
			}
		}
		echo RecentStories::PrintTableEnd();
	}else{
		return 'No Stories exist';
	}
	
}

public static function GetClientStory($client)
{
	$todays = date('Y-m-d');
	$startdate = '2014-05-19';
	$enddate = $todays;
	//echo $query = 'select * from story_client inner join story on story_client.story_id = story.Story_ID where story_client.client_id='.$client.' and story.storydate between "'.$startdate.'" and "'.$enddate.'" order by story.Story_ID desc limit 70';
	echo $q2 = 'SELECT * FROM story_client inner join story on story_client.story_id = story.Story_ID where story_client.client_id=1  order by story.storydate desc limit 50';
	// $story = Story::model()->find('Story_ID=:a AND StoryDate=:b', array(':a'=>$story_id, ':b'=>$todays))
	echo count($story = Story::model()->findAllBySql($q2));
	if($story = Story::model()->findAllBySql($q2)){
		echo RecentStories::PrintTableHead();
		foreach ($story as $key) {
			if($story = RecentStories::GetStories($key->Story_ID)){
				echo RecentStories::PrintTableBody($story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality);
			}
		}
		echo RecentStories::PrintTableEnd();
	}else{
		echo 'niet';
	}
	// if($story = Story::model()->findAllBySql("SELECT story_id FROM story_client WHERE story_client.client_id = $client and story_client.story_id in(Select story_id from story where storydate between '$startdate' and '$enddate')")){
	// 	echo 'buss';
	// 	print_r($story);
	// 	echo RecentStories::PrintTableHead();
	// 	foreach ($story as $key) {
	// 		if($story = RecentStories::GetStories($key->story_id)){
	// 			echo RecentStories::PrintTableBody($story->StoryDate,$story->Publication,$story->journalist,$story->Title,$story->StoryPage,$story->PublicationType,$story->picture,$story->Tonality,$story->Tonality);
	// 		}
	// 	}
	// 	echo RecentStories::PrintTableEnd();
	// }else{
	// 	return 'No Stories Exist';
	// }
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
	<th style="width:10%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th>AVE(Kshs.)</th>
	</thead>';
}
/*
* Print The Body of the Table This function may be called recursively
* NB - Just for the Print Section
*/
public static function PrintTableBody($date,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave){
	return '<tr>
	<td><a href="#">'.$date.'</a></td>
	<td>'.$pub.'</td>
	<td>'.$journo.'</td>
	<td><a href="#">'.$head.'</a><br><font size="1">Descriptions</font></td>
	<td>'.$page.'</td>
	<td>'.$pubtype.'</td>
	<td>'.$pic.'</td>
	<td>'.$effect.'</td>
	<td>'.$ave.'</td>
	</tr>';
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