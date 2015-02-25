<?php 
$mysselect="SELECT * FROM story WHERE Story_ID='$itemid' and uniqueID='$encryptid'";

$result=mysql_query($mysselect, $db);
$this_num_rows=mysql_num_rows($result);
if($this_num_rows > 0){
	$story=mysql_fetch_array($result);
	$mediahouse=$story["Media_House_ID"];
	$category=$story["Category_ID"];
	$title=$story["Title"];
	$image=$story["Image_ID"];
	$name=$story["editor"];
	$Journalist=$story["Journalist"];
	$clip= "../" . $story["file"]; 	
	$StoryTime=$story["StoryTime"];
	//if(substr($StoryTime,0,2)<13) { $ampm="am"; } else { $ampm="am"; } 
	$StoryTime=str_replace(":","",$StoryTime);
	$StoryDuration=$story["StoryDuration"];

	$strSQL1="Select * from mediahouse where Media_House_ID = '$mediahouse'";
	$result1=mysql_query($strSQL1, $db) ;
	$story1=mysql_fetch_array($result1);

	$strSQL2="Select * from category where Category_ID = '$category'";
	$result2=mysql_query($strSQL2, $db) ;
	$story2=mysql_fetch_array($result2);
	include('../include_image_resize.php');


	$clip=str_replace("../","",$clip);
	if(substr($clip,-3)=="mpg") {
	$flash_clip= "/reelmedia/" . str_replace(" ", "_", strtolower(str_replace("mpg", "flv", $clip)));
	$clip_type="Video";
	} else {
	$flash_clip= "/reelmedia/" . str_replace(" ", "_", strtolower(str_replace("mp3", "flv", $clip)));
	$clip_type="Audio";
	}

$this_flash_body="";
$this_flash_body.="<html><head><title>Reelforge : Media Monitoring</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<meta name='Keywords' content='media monitoring, press cuttings, media evaluation, electronic media monitoring, Africa, Kenya, Uganda, Tanzania, South Africa, reelforge, proof-of-flight reports on ,spot ads and promotions ,DJ mentions'>
<meta name='Description' content='media monitoring, press cuttings, media evaluation, electronic media monitoring, Africa, Kenya, Uganda, Tanzania, South Africa, reelforge, proof-of-flight reports on ,spot ads and promotions ,DJ mentions'><title>Reelforge - Media Monitoring</title>
<link href='../text.css' rel='stylesheet' type='text/css'>
<link href='/reelmedia/css/template_css.css' rel='stylesheet' media='all' type='text/css' />
</head><body><!-- ImageReady Slices (index.psd) --><div align='center'><table border='0' cellpadding='0' cellspacing='0' class='topwrap' align='center'>
<tr> <td> <table border='0' cellpadding='0' cellspacing='0' width='100%' class='header'> <tr valign='top'><td> <table border='0' cellpadding='0' cellspacing='0' width='100%' class='menu_bar'> <tr> <td>&nbsp;</td> <td></td> </tr> </table>  </td></tr> <tr valign='top'> <td>&nbsp;</td> </tr> </table>
</td> </tr> <tr> <td> </td> </tr>  </table> 
<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' class='topwrap'> <tr> <td valign='top'>  
<table width='100%' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000' class='content_box'> <tr valign='top' height='10'>
<td colspan='2' class='left_column'><span class='storyTitle'>";
 
$this_flash_body.= $title;
$this_flash_body.="</span></td></tr><tr valign='top'> <!--Start of the left section of the website --> <td width='18%' class='left_column' valign='top'><table width='100%' border='0' cellpadding='0' cellspacing='0'> <tr> <td class='storyTitle'><img src='images/spacer.gif' width='1' height='5'></td> </tr> <tr class='storyMain'> <td><span class='storySubtitle'><strong><br> <br> <br> Station :";   
$this_flash_body.= $story1['Media_House_List'];  
$this_flash_body.="</strong><br>";

$dt=$story['StoryDate']; 
$dt_inparts= explode('-', $dt);

$this_flash_body.= date ('l, F d Y', mktime (0,0,0,$dt_inparts[1],$dt_inparts[2],$dt_inparts[0]));
$this_flash_body.="</span> </td></tr><tr><td class='storySubtitle'>Time:";   
$this_flash_body.= substr($StoryTime, 0,4);   
$this_flash_body.="hrs";  
$this_flash_body.= $ampm;  
$this_flash_body.="</td></tr><tr> <td class='storySubtitle2'><span class='storySubtitle'>Length:";   
$this_flash_body.= $StoryDuration;   
$this_flash_body.="</span></td></tr><tr><td class='storySubtitle2'><span class='storySubtitle'>Type:";   
$this_flash_body.= $clip_type;   
$this_flash_body.="</span></td></tr> <tr> <td class='storySubtitle2'><span class='storySubtitle'><br><strong>Summary</strong> </span></td>
 </tr><tr> <td class='storySubtitle2'><span class='storySubtitle'>";  
$this_flash_body.= html_entity_decode($story['Story']);   
$this_flash_body.="</span><br><br></td></tr><tr><td class='storySubtitle2'><span class='storySubtitle'>Having trouble playing the clip? <br>You can<a href='";
$this_flash_body.= $clip;  
$this_flash_body.="' target='_blank'> Download </a>it instead.</span></td></tr><tr><td class='storySubtitle2'><p><img src='images/spacer.gif' width='1' height='10'></p><p>&nbsp;</p></td></tr><tr> <td class='storySubtitle2'>&nbsp;</td></tr></table></td><!--Start of the content section of the website --><td width='82%' class='main_column'><table width='300' border='0' align='left' cellpadding='0' cellspacing='0' class='text12'><tr> <td valign='top'> 
 <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='400' height='300'><param name='movie' value='vid.swf'><param name='quality' value='high'>
<embed src='vid.swf?vidPath=http://www.reelforge.com  echo $flash_clip;  ' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='550' height='400'></embed></object></td></tr></table></td></tr></table>";

$this_flash_body.="</td></tr> <tr><td> <table border='0' cellpadding='0' cellspacing='0' width='100%' class='footer'>
 <tr> <td> </td> </tr> </table> </td> </tr>  <tr> <td> <table border='0' cellpadding='0' cellspacing='0' width='100%' class='copyright'>
 <tr> <td></td> </tr> </table> </td> </tr> </table></div><!-- End ImageReady Slices --></body></html>";

 } 
 ?> 


