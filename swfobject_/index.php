
<?php /*
$file = str_replace(' ', '_' get_the_title());
$file .= ".swf";
$url = get_joe_theme_path() . "joe_swf/courses_swfs/" . $file;
*/
?>
 <script type="text/javascript" src="swfobject/swfobject.js"></script>
        <script type="text/javascript">
                        var flashvars = {
                          doc_url: "http://localhost/taalumainstitute/wp-content/themes/magzine/joe_swf/courses_swfs/TI_SWA_201T_Intermediate_II_2013.swf",
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
            swfobject.embedSWF('swfobject/zviewer.swf?r=11', 'website', '700', '600', '10.0.45',
                'swfobject/expressinstall.swf', flashvars, params, attributes);

        </script>
<table width='100%'><tr>
<td width="100%" valign=top><div align=center><div id="website">
<p align="center" class="style1">In order to view this page you need Flash Player 9+ support!</p>
<p align="center"><a href="http://www.adobe.com/go/getflashplayer">
<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
</a></p></div></div></td></tr></table>


