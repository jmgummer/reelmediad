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
        file: "<?php echo Yii::app()->request->baseUrl; ?>/videos/test.flv",
        width: 640,
        height: 360
    });
</script>