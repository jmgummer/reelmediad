<?php
$seconds = 1585; //example

$hours = floor($seconds / 3600);
$mins = floor(($seconds - $hours*3600) / 60);
$s = $seconds - ($hours*3600 + $mins*60);

$mins = ($mins<10?"0".$mins:"".$mins);
$s = ($s<10?"0".$s:"".$s); 

echo $time = ($hours>0?$hours." hr(s) ":"").$mins." min(s) ".$s." sec(s)";

?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/jwplayer/jwplayer.js'; ?>"></script>

<div id="myElement">Loading the player...</div>
<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "http://www.reelforge.com/reelmedia/files/clippings/2014/11/06/ntv_2014-11-06_21:00:00_dv203.flv",
        width: 640,
        height: 360
    });
</script>