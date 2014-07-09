<div class="swf-table">
  <?php echo Swfviewer::GetSwfHeader($model); ?>
  <?php $swffile = Swfviewer::GetSwfFile($model->Link); ?>
</div>

<?php //echo $swffile;  ?>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/swfobject/swfobject.js'; ?>"></script>
<script type="text/javascript">
                var flashvars = {
                  doc_url: "<?php echo 'http://192.168.0.60/reelmedia/files/pdf/'.$model->Link;  ?>",
                };
                var params = {
                  menu: "false",
                  //bgcolor: '#efefef',
                bgcolor: '#efefef',
                  allowFullScreen: 'true'
                };
                var attributes = {
                        id: 'website'
                };
                swfobject.embedSWF('<?php echo Yii::app()->request->baseUrl; ?>/swfobject/zviewer.swf?r=11', 'website', '700', '600', '10.0.45',
                '<?php echo Yii::app()->request->baseUrl; ?>/swfobject/expressinstall.swf', flashvars, params, attributes);

</script>
<table width='100%'><tr>
<td width="100%" valign=top><div align=center><div id="website">
<p align="center" class="style1">In order to view this page you need Flash Player 9+ support!</p>
<p align="center"><a href="http://www.adobe.com/go/getflashplayer">
<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
</a></p></div></div></td></tr></table>
<style type="text/css">
.swf-table{
  width: 700px;
  margin: 10px auto;
}
.swf-table a,.swf-table a:hover{
  text-decoration: none;
}
.swf-table h3{
  margin-top: 5px;
  margin-bottom: 5px;
  font-weight: bold;
}
.cmention{
  font-style: italic;
}
.joe .minion {
  display: block;
  color: #00b050;
  border: 6px solid #00b050;
  padding: 52px 52.5px;
  width: 52px;
  height: 52px;
  margin: 0 auto;
  border-radius: 50%;
  -moz-border-radius: 50%;
  -webkit-border-radius: 50%;
  -webkit-transition: all 0.4s ease-in-out;
  -moz-transition: all 0.4s ease-in-out;
  -o-transition: all 0.4s ease-in-out;
  transition: all 0.4s ease-in-out;
  transform: rotate(0deg);
  -ms-transform: rotate(0deg); 
  -webkit-transform: rotate(0deg); 
  -o-transform: rotate(0deg);
  -moz-transform: rotate(0deg); 
}
.joe .col-md-4:hover .minion{
  color: #fff;
  border-color: #fff;
  background-color: #00b050;
  -webkit-transform: scale(1.1);
  transform: rotate(359deg);
  -ms-transform: rotate(359deg); 
  -webkit-transform: rotate(359deg); 
  -o-transform: rotate(359deg);
  -moz-transform: rotate(359deg);
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.28);
}
</style>