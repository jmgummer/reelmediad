<?php 
include_once("../authfile.php") ;
include_once("../include_settings.php");
include("../visitor_tracking.php");

//$itemid="7515";
//$encryptid="z1j26xvwksnmpq783tdbg95yrh0f4c";

$mysselect="SELECT * FROM story WHERE Story_ID='$itemid' ";
//and uniqueID='$encryptid'";

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

	$download_clip=$clip;
	$clip=str_replace("../","",$clip);
	if(substr($clip,-3)=="mpg") {
	$flash_clip= "/reelmedia/" . str_replace(" ", "_", strtolower(str_replace("mpg", "flv", $clip)));
	$clip_type="Video";
	} else {
	$flash_clip= "/reelmedia/" . str_replace(" ", "_", strtolower(str_replace("mp3", "flv", $clip)));
	$clip_type="Audio";
	}


 ?>
 <html>
<head>
<title>Reelforge : Media Monitoring</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="Keywords" content="media monitoring, press cuttings, media evaluation, electronic media monitoring, Africa, Kenya, Uganda, Tanzania, South Africa, reelforge, proof-of-flight reports on ,spot ads and promotions ,DJ mentions">
<meta name="Description" content="media monitoring, press cuttings, media evaluation, electronic media monitoring, Africa, Kenya, Uganada, Tanzania, South Africa, reelforge, proof-of-flight reports on ,spot ads and promotions ,DJ mentions"><title>Reelforge - Media Monitoring</title>
<link href="../text.css" rel="stylesheet" type="text/css">
<link href="/reelmedia/css/template_css.css" rel="stylesheet" media="all"  type="text/css" />

</head>


<?php include("visitor_tracking.php"); ?>
<body>
<!-- ImageReady Slices (index.psd) -->
<div align="center">
<table border="0" cellpadding="0" cellspacing="0" class="topwrap" align="center">
	  <tr>
		  <td>
			  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="header">
				  <tr valign="top"><td>
					  <table border="0" cellpadding="0" cellspacing="0" width="100%" class="menu_bar">
						<tr>
						  <td>&nbsp;</td>
						  <td></td>
						</tr>
					</table>
		
				  </td></tr>
				  <tr valign="top">
				    <td>&nbsp;</td>
				  </tr>				
			  </table>
		  </td>
	  </tr>
	  <tr>
		  <td>
		  </td>
	  </tr>			
  </table>
   
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="topwrap">
	<tr>
	  <td valign="top">  
 
 <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" class="content_box">

  <tr valign="top" height="10">
    <td colspan="2" ><div align="left"><span class="storyTitle"><? echo $title ?></span></div></td>
</tr>


  <tr valign="top">
    <!--Start of the left section of the website -->
    <td width="18%" class="left_column" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="storyTitle"><img src="images/spacer.gif" width="1" height="5"></td>
      </tr>
      <tr class="storyMain">
        <td><span class="storySubtitle"><strong><br>
                <br>
                <br>
                Station : <? echo $story1["Media_House_List"]; ?></strong>
				<br>
          <? //echo $story["StoryDate"];
			 $dt=$story["StoryDate"];  
			 $dt_inparts= explode("-", $dt);

			echo date ("l, F d Y", mktime (0,0,0,$dt_inparts[1],$dt_inparts[2],$dt_inparts[0]));

 ?>
        </span> </td>
      </tr>

      <tr>
        <td class="storySubtitle">Time: <? echo substr($StoryTime, 0,4); ?> hrs<? echo $ampm; ?></td>
      </tr>
      <tr>
        <td class="storySubtitle2"><span class="storySubtitle">Length: <? echo $StoryDuration ?> </span></td>
      </tr>
      <tr>
        <td class="storySubtitle2"><span class="storySubtitle">Type: <? echo $clip_type; ?> </span></td>
      </tr>	 
 
      <tr>
        <td class="storySubtitle2"><span class="storySubtitle"><br><strong>Summary</strong> </span></td>
      </tr>	
      <tr>
        <td class="storySubtitle2"><span class="storySubtitle"><? echo html_entity_decode($story["Story"]); ?> </span><br><br></td>
      </tr>		  
 
	  
	  	  <tr>
        <td class="storySubtitle2"><span class="storySubtitle">
Having trouble playing the clip? <br>
You can<a href="<? echo $download_clip ?>" target="_blank"> Download </a>it instead.
		</span></td>
      </tr>
      <tr>
        <td class="storySubtitle2"><p><img src="images/spacer.gif" width="1" height="10"></p>
          <p>&nbsp;</p></td>
      </tr>
	  
      <tr>
        <td class="storySubtitle2">&nbsp;</td>
      </tr>
    </table></td>
    <!--Start of the content section of the website -->
    <td width="82%" class="main_column">
	
	<table width="300" border="0" align="left" cellpadding="0" cellspacing="0" class="text12">
      <tr>
        <td valign="top">		
		
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,24" width="500" height="400">
<param name="movie" value="vid.swf?vidPath=http://www.reelforge.com<?php echo $flash_clip; ?>">
<param name="quality" value="high">

<embed src="vid.swf?vidPath=http://www.reelforge.com<?php echo $flash_clip; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="500" height="400"></embed>


</object>




</td>
      </tr>
    </table></td>
  </tr>
</table>



</td>
	</tr>	
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
				<tr>
				  <td> </td>
				</tr>
			</table>
		</td>
	</tr>		
	<tr>
		<td>
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="copyright">
				<tr>
				  <td><a class="copyright_content" href="http://www.corporateart.co.ke">a Corporate Art design </a></td>
				</tr>
			</table>
		</td>
	</tr>			
</table>
</div>
<!-- End ImageReady Slices -->
</body>
</html>

<?php } ?> 

 <script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-1042104-3");
pageTracker._trackPageview();
</script>