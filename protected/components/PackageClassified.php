<?php

/**
 * Used for Packaging Custom Classified Stories
 */
class PackageClassified
{
	private $querykey;
	private $tabledata;
	private $companyid;
	private $startdate;
	private $enddate;
	
	public function __construct($querykey,$startdate,$enddate,$companyid){
		$this->querykey =  $querykey;
		$this->companyid = $companyid;
		$this->startdate = date('Y-m-d', strtotime($startdate));
        $this->enddate = date('Y-m-d', strtotime($enddate));
	}

	public function GetMentions(){
		$querykey =  $this->querykey;
    	$foundkeyarray = array();
    	$tabletitles = "";
    	$tablerows = "";
    	$startdate = $this->startdate;
    	$enddate = $this->enddate;

    	$printplayer = Yii::app()->params['printplayer'];
    	$electronicplayer = Yii::app()->params['electronicplayer'];
    	$currency = Yii::app()->params['country_currency'];

    	 // = date('Y-m-d', strtotime($startdate));
		/*
		** Get the available indexed themes for the client query
		*/
		$themesql = "SELECT DISTINCT industrymentions.theme_id, themes.theme_name FROM industrymentions INNER JOIN themes ON themes.id = industrymentions.theme_id WHERE theme_id !='' AND querykey='$querykey' ORDER BY theme_name;";
		if($query = Yii::app()->db2->createCommand($themesql)->queryAll()){
			foreach ($query as $themerow) {
				$themekey = trim($themerow['theme_name']);
				$themeid = $themerow['theme_id'];
				$themestories = "";
				$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;' id='$themekey'><td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'><font style='color:#505050;font-weight:bold;'>$themekey</font></td></tr>";
				if($startdate==date("Y-m-d", strtotime("-1 day"))){
					// Get Yesterdays Electronic Stories
					$themementions = "SELECT DISTINCT Story_ID, Title, ave, print_rate, Media_ID, Media_House_List, StoryDate, StoryTime, StoryPage, uniqueID, summary AS Story, mentioned FROM industrymentions WHERE theme_id ='$themeid' AND StoryDate='$startdate' AND Media_ID!='mp01' AND querykey='$querykey'  ORDER BY StoryDate,StoryPage,StoryTime";
					if($themedata = Yii::app()->db2->createCommand($themementions)->queryAll()){
						foreach ($themedata as $themevalues) {
							$mediahouse = $themevalues['Media_House_List'];
							$Story_ID = $themevalues['Story_ID'];
							$title = $themevalues['Title'];
							$StoryDate = date("d M Y",strtotime($themevalues['StoryDate']));
							$Story = $themevalues['Story'];
							$ave = number_format($themevalues['ave']);
							$print_rate = number_format($themevalues['print_rate']);
							$encriptdid = $themevalues['uniqueID'];
							$mentioned = $themevalues['mentioned'];
							if($themevalues['Media_ID']=='mp01'){
								$extra = "Page: ".$themevalues['StoryPage'];
								$url = $printplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $print_rate</em>";
							}else{
								$extra = "Time: ".$themevalues['StoryTime'];
								$url = $electronicplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $ave</em>";
							}
							$themestories .= "<tr style='color: #98a7b9;line-height: 21px;'>";
							$themestories .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'>";
							$themestories .= "<a href='$url' style='color: #336699;font-weight: normal;text-decoration: underline;' target='_blank'>$title</a> <font style='color:#505050;'><em>($mediahouse, $StoryDate - $extra)</em></font>";
							$themestories .= "<br><font style='color:#505050;'>$Story<br></font>$storymeta";
							$themestories .= "</td>";
							$themestories .= "</tr>";
						}
					}
					// Get Todays Print Stories
					$themementions = "SELECT DISTINCT Story_ID, Title, ave, print_rate, Media_ID, Media_House_List, StoryDate, StoryTime, StoryPage, uniqueID, summary AS Story, mentioned FROM industrymentions WHERE theme_id ='$themeid' AND StoryDate='$enddate' AND Media_ID='mp01' AND querykey='$querykey'  ORDER BY StoryDate,StoryPage,StoryTime";
					if($themedata = Yii::app()->db2->createCommand($themementions)->queryAll()){
						foreach ($themedata as $themevalues) {
							$mediahouse = $themevalues['Media_House_List'];
							$Story_ID = $themevalues['Story_ID'];
							$title = $themevalues['Title'];
							$StoryDate = date("d M Y",strtotime($themevalues['StoryDate']));
							$Story = $themevalues['Story'];
							$ave = number_format($themevalues['ave']);
							$print_rate = number_format($themevalues['print_rate']);
							$encriptdid = $themevalues['uniqueID'];
							$mentioned = $themevalues['mentioned'];
							if($themevalues['Media_ID']=='mp01'){
								$extra = "Page: ".$themevalues['StoryPage'];
								$url = $printplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $print_rate</em>";
							}else{
								$extra = "Time: ".$themevalues['StoryTime'];
								$url = $electronicplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $ave</em>";
							}
							$themestories .= "<tr style='color: #98a7b9;line-height: 21px;'>";
							$themestories .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'>";
							$themestories .= "<a href='$url' style='color: #336699;font-weight: normal;text-decoration: underline;' target='_blank'>$title</a> <font style='color:#505050;'><em>($mediahouse, $StoryDate - $extra)</em></font>";
							$themestories .= "<br><font style='color:#505050;'>$Story<br></font>$storymeta";
							$themestories .= "</td>";
							$themestories .= "</tr>";
						}
					}
					if($themestories!=""){
						$tablerows .= $themestories;
					}else{
						$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;' id='$themekey'><td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'><em>No Mentions Found for ($themekey)</em></td></tr>";
					}
				}else{
					// Get the Theme stories
					$themementions = "SELECT DISTINCT Story_ID, Title, ave, print_rate, Media_ID, Media_House_List, StoryDate, StoryTime, StoryPage, uniqueID, summary AS Story, mentioned FROM industrymentions WHERE theme_id ='$themeid' AND querykey='$querykey'  ORDER BY StoryDate,StoryPage,StoryTime";
					if($themedata = Yii::app()->db2->createCommand($themementions)->queryAll()){
						foreach ($themedata as $themevalues) {
							$mediahouse = $themevalues['Media_House_List'];
							$Story_ID = $themevalues['Story_ID'];
							$title = $themevalues['Title'];
							$StoryDate = date("d M Y",strtotime($themevalues['StoryDate']));
							$Story = $themevalues['Story'];
							$ave = number_format($themevalues['ave']);
							$print_rate = number_format($themevalues['print_rate']);
							$encriptdid = $themevalues['uniqueID'];
							$mentioned = $themevalues['mentioned'];
							if($themevalues['Media_ID']=='mp01'){
								$extra = "Page: ".$themevalues['StoryPage'];
								$url = $printplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $print_rate</em>";
							}else{
								$extra = "Time: ".$themevalues['StoryTime'];
								$url = $electronicplayer."storyid=$Story_ID&encriptdid=$encriptdid";
								$storymeta = "<em style='color:#505050;'>AVE - $currency $ave</em>";
							}
							
							$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;'>";
							$tablerows .= "<td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'>";
							$tablerows .= "<a href='$url' style='color: #336699;font-weight: normal;text-decoration: underline;' target='_blank'>$title</a> <font style='color:#505050;'><em>($mediahouse, $StoryDate - $extra)</em></font>";
							$tablerows .= "<br><font style='color:#505050;'>$Story<br></font>$storymeta";
							$tablerows .= "</td>";
							$tablerows .= "</tr>";
						}
					}else{
						$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;' id='$themekey'><td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'><em>No Mentions Found for ($themekey)</em></td></tr>";
					}
				}
			}
		}else{
			$tablerows .= "<tr style='color: #98a7b9;line-height: 21px;'><td style='padding: 8px;line-height: 1.42857143;vertical-align: top;'><font style='color:#505050;font-weight:bold;'>Could not get themes</font></td></tr>";
		}
		$this->tabledata = $tablerows;
		return TRUE;
    }

    public function CreateTable(){
    	$table = "<table style='width: 100%;font-family: Arial;font-size: 14px;line-height: 150%;text-align: left;border-spacing: 0;border-collapse: collapse;'>";
    	$table.= $this->tabledata;
    	$table.= "</table>";
    	return $table;
    }

    public function PrintEmailManenos(){
    	$cid = $this->companyid;
    	$cdate = $this->startdate;
    	$cedate = $this->enddate;
    	$externalurl = "http://media.reelforge.com/calert?cid=$cid&cdate=$cdate&cedate=$cedate";
    	$emaildate = date("M d, Y", strtotime($this->enddate));
    	$companylist =  $this->CreateTable();
    	$adlist = "";
    	$chartdata = "";
    	$imgname = 'Competitor_Activity_Report_'.date('d_m_Y_h_i_s').'.png';
		$img = "";
		$finalpath = "http://storage-download.googleapis.com/rppfiles/KENYA/clientfiles/".$imgname;
    	$package = '<div id="mailsub" class="notification" align="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="min-width: 320px;"><tr><td align="center" bgcolor="#eff3f8">
		<table border="0" cellspacing="0" cellpadding="0" class="table_width_100" width="720px" style="max-width: 720px; min-width: 300px;">
		<tr><td>
		<div style="height: 80px; line-height: 80px; font-size: 10px;">&nbsp;</div>
		</td></tr>
		<tr><td align="center" bgcolor="#ffffff">
		<div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
		<table width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="left">
		<div class="mob_center_bl" style="float: left; display: inline-block; width: 115px;">
		<table class="mob_center" width="115" border="0" cellspacing="0" cellpadding="0" align="left" style="border-collapse: collapse;">
		<tr><td align="left" valign="middle">
		<div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
		<table width="115" border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td align="left" valign="top" class="mob_center">
		<a href="https://www.usaid.gov/east-africa-regional" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td>
		<img src="http://www.reelforge.com/reelforge_back/images/reelforge_media_intelligence_logo.png" width="200" height="auto" alt="USAID Logo" border="0" style="display: block;float:left;width: 200;" />
		</td>
		</tr>
		</table>
		</a>
		</td></tr>
		</table>						
		</td></tr>
		</table>
		</div>
		<div class="mob_center_bl" style="float: right; display: inline-block; width: 88px;">
		<table width="88" border="0" cellspacing="0" cellpadding="0" align="right" style="border-collapse: collapse;">
		<tr><td align="right" valign="middle">
		<div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		<tr><td align="right">
		<div class="mob_center_bl" style="width: 88px;">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="30" align="center" style="line-height: 19px;">
		<a href="https://www.facebook.com/pages/Reelforge-Media-Monitoring/129576230404975" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
		<font face="Arial, Helvetica, sans-serif" size="2" color="#596167">
		<img src="http://media.reelforge.com/reelforge_back/images/rf_facebook.png" width="auto" height="auto" alt="Facebook" border="0" style="display: block;" /></font></a>
		</td>
		<td width="39" align="center" style="line-height: 19px;">
		<a href="https://www.twitter.com/Reelforge?lang=en" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
		<font face="Arial, Helvetica, sans-serif" size="2" color="#596167">
		<img src="http://media.reelforge.com/reelforge_back/images/rf_twitter.png" width="auto" height="auto" alt="Twitter" border="0" style="display: block;" /></font></a>
		</td>
		</tr>
		</table>
		</div>
		</td></tr>
		</table>
		</td></tr>
		</table></div></td>
		</tr>
		</table>
		<div style="height: 20px; line-height: 50px; font-size: 10px;">&nbsp;</div>
		</td></tr>
		<tr>
		<td align="center" bgcolor="#fbfcfd">
		
		<table width="90%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="left" width="100%">
		<div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
		<div style="">
		<font face="Arial, Helvetica, sans-serif" size="5" color="#57697e" style="font-size: 34px;">
		<span style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #205493;text-align:left;line-height: 44px;">
		'.$emaildate.'
		</span></font><br>
		<font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;line-height: 24px;">
		<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">
		This daily wrap-up curates news, commentary and resources related to your organization, with a focus on coverage featured in national publications, radio and TV broadcasts in Kenya.
		</span></font>
		</div>
		</td>
		</tr>

		<tr>
		<td align="left">
		<div style=""></div>
		</td>
		</tr>
		<tr><td align="center">
		<div style="line-height: 24px;"></div>
		<div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
		</td></tr>

		</table>
		<img src="http://www.reelforge.com/images/sig_banner2.jpg" width="100%" height="auto" />
		</td></tr>
		<tr><td align="center" bgcolor="#ffffff" style="border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #eff2f4;">
		<table width="94%" border="0" cellspacing="0" cellpadding="0">
		<tr><td align="center">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td align="center">
		<font face="Arial, Helvetica, sans-serif" size="3" color="#57697e" style="font-size: 26px;">
		<span style="font-family: Arial, Helvetica, sans-serif; font-size: 26px; color: #57697e;">
		</span></font>				
		</td></tr>			
		</table>
		<div class="ttables" >
		'.$companylist.'
		</div>						
		</td></tr>
		<tr><td><div style="height: 80px; line-height: 80px; font-size: 10px;">&nbsp;</div></td></tr>
		</table>		
		</td>
		</tr>

		<tr>
		<td class="iage_footer" align="center" bgcolor="#ffffff">
		<div style="height: 80px; line-height: 80px; font-size: 10px;">&nbsp;</div>	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td align="center">
		<font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
		<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
		Reelforge Systems. All Rights Reserved.
		</span></font>				
		</td></tr>			
		</table>
		<div style="height: 30px; line-height: 30px; font-size: 10px;">&nbsp;</div>	
		</td></tr>
		<tr><td>
		<div style="height: 80px; line-height: 80px; font-size: 10px;">&nbsp;</div>
		</td></tr>
		</table>
		</td></tr>
		</table>
		</div>';
		return $package;
    }
}