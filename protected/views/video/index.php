<?php $this->breadcrumbs=array('Videos'=>array('view','id'=>$model->Story_ID),$model->Title); ?>
<?php

/* Media House Data */
$mediahouse=$model->Media_House_ID;
if($mediahouse = Mediahouse::model()->find('Media_House_ID=:a', array(':a'=>$mediahouse))){
	$mediahouse = $mediahouse->Media_House_List;
}else{
	$mediahouse = '';
}
/* Date */
$dt=$model->StoryDate;  
$dt_inparts= explode("-", $dt);
$story_date = date ("l, F d Y", mktime (0,0,0,$dt_inparts[1],$dt_inparts[2],$dt_inparts[0]));

/* Duration */
$duration = $model->StoryDuration;

/* Time */
$StoryTime=$model->StoryTime;
$StoryTime=str_replace(":","",$StoryTime);

/* Story Summary */
$summary = $model->Story;
$summary = html_entity_decode($summary);

/* Get the Companies Mentioned */
$companies_mentioned = '';
$sql_companies_mentioned="select company_name from company, story_mention where  story_mention.client_id=company.company_id and story_mention.story_id='$model->Story_ID' ";
if($query_companies_mentioned=Company::model()->findAllBySql($sql_companies_mentioned)){
	foreach ($query_companies_mentioned as $key) {
		$companies_mentioned.=$key->company_name. ", ";
	}
}
$companies_mentioned=substr($companies_mentioned,0,-2);
$seconds = $duration; //example

$hours = floor($seconds / 3600);
$mins = floor(($seconds - $hours*3600) / 60);
$s = $seconds - ($hours*3600 + $mins*60);

$mins = ($mins<10?"0".$mins:"".$mins);
$s = ($s<10?"0".$s:"".$s); 

$formatedtime = ($hours>0?$hours." hr(s) ":"").$mins." min(s) ".$s." sec(s)";


/* The File Path */
$filepath=$model->file_path;
$clip= "../" . $model->file;
$filepath =trim(str_replace("/home/srv/www/htdocs","",$filepath));
$clip=str_replace("files/","",$clip);
$clip=str_replace("../","",$clip);
if(substr($clip,-3)=="mpg") {
	$download_clip=$filepath .trim(str_replace(" ", "_", $clip));
	$clip_type="Video";
}else{
	$download_clip=$filepath .trim(str_replace(" ", "_", $clip));
	$clip_type="Audio";
} 
$flash_clip=$filepath .$clip;

if(substr($flash_clip,-3)=="mpg") {
	$flash_clip=strtolower(substr($flash_clip,0,-3) ."flv");
}
$download_clip = 'http://www.reelforge.com/'.$download_clip;
$flash_clip ='http://www.reelforge.com/'.$flash_clip;


?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/jwplayer/jwplayer.js'; ?>"></script>
<div class="row-fluid clearfix"><div class="col-md-12"><h3><?php echo $title=$model->Title; ?></h3></div></div>
<div class="row-fluid clearfix">
	<div class="col-md-8">
		<div id="myElement">Loading the player...</div>
		<script type="text/javascript">
		    jwplayer("myElement").setup({
		        file: "<?php echo $flash_clip; ?>",
		        width: 640,
		        height: 360
		    });
		</script>
	</div>
	<div class="col-md-4">
		<p><strong>Station : <?php echo $mediahouse; ?></strong></p>
		<p><?php echo $story_date; ?></p>
		<p>Time : <?php echo substr($StoryTime, 0,4); ?> hrs<?php //echo $ampm; ?></p>
		<p>Length : <?php echo $formatedtime; ?></p>
		<p>Type : <?php echo $clip_type; ?></p>
		<p><strong>Summary </strong><br></p>
		<p><?php echo $summary; ?></p><br>
		<p><strong>Download </strong><br></p>
		<p><a href="<?php echo $download_clip; ?>"><i class="fa fa-download fa-2x"></i></a></p>
	</div>
</div>
<div class="row-fluid clearfix">
	<div class="col-md-12">
		<br>
		<p><strong>Companies Mentioned : </strong></p>
		<p><?php echo $companies_mentioned; ?></p>
	</div>
</div>