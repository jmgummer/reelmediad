<?php

$agency_client_co_id = 'all';

$year_start='2012';
$year_end='2013';
$month_start='08';
$month_end='08';
$this_i_date = '2008-02-02';
$this_backdate_sql = '2008-02-02';
// $agency_client_co_id = 2;
$industry_query ='';
$query = '';

$elements = '';
$tables = '';
$where = '';

// echo $sql_industry = 'select ';
if($agency_client_co_id=='all') {

	for ($x=$year_start;$x<=$year_end;$x++)
	{
	    if($x==$year_start) { $month_start_count=$month_start; } else { $month_start_count='1';}
	    if($x==$year_end) { $month_end_count=$month_end; } else { $month_end_count='12';}

	    $month_start_count=$month_start_count+0;

	    for ($y=$month_start_count;$y<=$month_end_count;$y++)
	    {
	        if($y<10) { $my_month='0'.$y;   } else {  $my_month=$y; }
	        $storytable = 'story_'.$x."_".$my_month.'<br>';
	        $elements .= " $storytable.Story_ID, Story, uniqueID, Title, StoryDate, editor, StoryTime, StoryPage, journalist, photo_journalist, mediahouse.Media_ID, picture, col, centimeter, StoryDuration, Story, Story, Category_ID ,cont_on, cont_from ";
	        $tables .= $storytable;
	        $where .= " $storytable.Story_ID=story_mention.story_id 
			and $storytable.Media_ID='mp01' and cont_from='' 
			and $storytable.step3=1 " . $this_i_date . $this_backdate_sql ." 
			and $storytable.Media_House_ID=mediahouse.Media_House_ID 
			and $storytable.story_id=story_industry.story_id";
	    }
	}
}
$tables .= "story_mention, mediahouse ,story_industry";
$close = "and story_mention.client_id ='$agency_client_co_id'";
echo 'SELECT '.$elements.' FROM '.$tables;
// echo $build = $elements.' from '.$tables.' where '.$where.' '.$close;

// $sql_industry .= "and story_mention.client_id ='$agency_client_co_id'";
// // $sql_industry .= "and story_industry.industry_id in (select industry_id  from industry_company  where company_id='$agency_client_co_id' ) $industry_query $query ";
// echo '<br> ---------------------------- <br>';
// echo $sql_industry;
// echo '<br> ---------------------------- <br>';

// $sql="select company.company_id, company_name from company, agency_user_client, agency_users, agency_client
// where agency_users.username='$username' and
// agency_users.agency_users_id=agency_user_client.agency_users_id and
// agency_user_client.company_id=company.company_id  and
// agency_client.company_id=agency_user_client.company_id
// order by company_name asc";
// $my_query = mysql_query($sql,$db);
// while ($myrow = mysql_fetch_array($my_query)) {
// $agency_client_co_id=$myrow["company_id"];
// $this_company_name=$myrow["company_name"];



// $my_companies=substr($my_companies,0,-1);


// $sql_industry="select  distinct(story.Story_ID), Story,uniqueID,Title,StoryDate,editor,StoryTime,StoryPage,journalist,photo_journalist,mediahouse.Media_ID,picture,col,centimeter,StoryDuration,Story,Story,Category_ID ,cont_on, cont_from  
// from story,story_mention, mediahouse ,story_industry where 

// story_mention.client_id ='$agency_client_co_id'  and story.Story_ID=story_mention.story_id and
// story.Media_ID='mp01' and cont_from='' and
// story.step3=1 " . $this_i_date . $this_backdate_sql ." and story.Media_House_ID=mediahouse.Media_House_ID and
// story.story_id=story_industry.story_id and story_industry.industry_id in (select industry_id  from industry_company  where company_id='$agency_client_co_id' ) $industry_query $query ";





// if($mysearch){
// 	$sql_industry.=$search;
// }
// $sql_industry.= "   order by StoryDate asc,Media_House_List asc,  page_no asc";

// //echo $sql_industry . "<hr>";
// // $query_query=mysql_query($sql_industry, $db);
// // $this_num_results=mysql_num_rows($query_query);

// 	if($this_num_results > 0){
// 	// $link=1;
// 	// $story_type= "$this_company_name Print Stories ";
// 	// $spread_sheet_title=strtoupper($this_company_name). " PRINT";
// 	// $show_pr=1;
// 	// if($pdf) {      $body.=PageTitle($story_type);  }
// 	// $lines=0;
// 	// $section="1"; include("results_display_table_print.php");
// 	// $show_pr=0;
// 	// if($pdf) { $body.="</table>"; }
// 	} // if
// }
?>