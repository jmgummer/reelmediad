<?php

class PdfCreator{
	public static function CreatePdf($file){
		if(file_exists($pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file)){

		}
		// $qry_pdf = "select url from sph_links where link_id = (select link_id from story where Story_ID = '$story_id')";
                       // $qry = mysql_query($qry_pdf);
                       // while($row = mysql_fetch_assoc($qry)) { $url = $row['url'];}

                      // $url = 'http://www.reelforge.com/reelmedia/files/pdf/'.$file;
                       $pdf_file =  substr($file, 11);
                       // $pdf_path = str_replace('http://www.reelforge.com/', '/home/srv/www/htdocs/reelmedia/files/pdf/', $file);
                       // $pdf_path = '/home/srv/www/htdocs/reelmedia/files/pdf/'.$file;





                       // $png_file = 'final_'.$story_id."_".substr($pdf_file, 0,-3).'png';
                       // $png_path = '/home/srv/www/htdocs/reelapp/rf_droid/files/'.$png_file;
                       // $cmd_conv_pdf = "/usr/bin/convert  -flatten -density 150 " .$pdf_path. " " .$png_path;
                       // $cmd_resize = "convert $png_path  -resize 50% $png_path";

                       // system($cmd_conv_pdf);
                       // //$final_file_path['url'] = str_replace('/home/srv/www/htdocs/', 'http://www.reelforge.com/', $png);
                       // $final_file_path['url'] = "http://reelapp.reelforge.com/rf_droid/view/view.php?id=".$story_id."&img=".$png_file;
		// $pdf_file   = 'demo.pdf';
		// $save_to    = 'demo.jpg';
		 
		// $img = new imagick($pdf_file);
		 
		// //set new format
		// $img->setImageFormat('jpg');
		 
		// //save image file
		// $img->writeImage($save_to);
	}
}