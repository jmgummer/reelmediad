<?php

class ExcelResults{
	public static function OnlineExcel($mentionsarray,$company_name,$reportperiod){
		ini_set('memory_limit', '1024M');
		$PHPExcel = new PHPExcel();
        $title = "Reelforge Online Excel Report";
        $PHPExcel->getProperties()->setCreator("Reelforge Systems")
        ->setTitle("Reelforge Online Excel Report")
        ->setSubject("Reelforge Online Excel Report")
        ->setDescription("Reelforge Online Excel Report");
        $PHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);
        $styleArray = array('font'  => array('bold'  => true));
        $styleArray2 = array('font'  => array('bold'  => true,'width'  => 100),'alignment' => array('wrap'=> false));
        $PHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->mergeCells('A1:Z1');
        $PHPExcel->getActiveSheet()->mergeCells('A2:Z2');
        $PHPExcel->getActiveSheet()->mergeCells('A3:Z3');
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(45);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        // $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $PHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("C5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("D5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("E5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("F5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("G5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
        // $PHPExcel->getActiveSheet()->getStyle("K5")->applyFromArray($styleArray);
        // Electonic Sheet
	    $PHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'Reelforge Online Excel Report')
		->setCellValue('A2', 'Client : '.$company_name)
		->setCellValue('A3', 'Period : '.$reportperiod)
		->setCellValue('A5', '#')
		->setCellValue('B5', 'Title')
		->setCellValue('C5', 'Date')
		->setCellValue('D5', 'Tonality')
		->setCellValue('E5', 'Domain')
		->setCellValue('F5', 'Link')
		->setCellValue('G5', 'Authors')
		->setCellValue('H5', 'OTS')
		->setCellValue('I5', 'Themes')
		->setCellValue('J5', 'Keywords');

		$count = 6;
        $rowcount =1;
		foreach ($mentionsarray as $keyvalue) {
			$id = $keyvalue->id;
			$Date = $keyvalue->Date;
			$Tonality = $keyvalue->Tonality;
			$Title = $keyvalue->Title;
			$Link = $keyvalue->permalink;
			$Domain = $keyvalue->Domain;
			$Authors = $keyvalue->Authors;
			$Themes = $keyvalue->Themes;
			$Keywords = $keyvalue->Keywords;
			$AVE = $keyvalue->AVE;
			$OTS = $keyvalue->OTS;

            $PHPExcel->getActiveSheet()
            ->setCellValue("A$count", $rowcount)
            ->setCellValueExplicit("B$count", $Title)
            ->setCellValueExplicit("C$count", $Date)
            ->setCellValueExplicit("D$count", $Tonality)
            ->setCellValueExplicit("E$count", $Domain)
            ->setCellValueExplicit("F$count", $Link)
            ->setCellValueExplicit("G$count", $Authors)
            ->setCellValueExplicit("H$count", $OTS)
            ->setCellValueExplicit("I$count", $Themes)
            ->setCellValueExplicit("J$count", $Keywords)
            ;
            $PHPExcel->getActiveSheet()->getCell("B$count")->getHyperlink()->setUrl($Link);
            $PHPExcel->getActiveSheet()->getStyle("B$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
            $count++;
            $rowcount++;
        }
        $PHPExcel->getActiveSheet()->setTitle('Online Results');

        $PHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/reelmediad/docs/excel/";
        $filename = str_replace(" ","_",$company_name);
        $filename = $filename.'_online_reports_'.date("Ymdhis").'.xlsx';
        $objWriter->save($upload_path.$filename);
        return $filename;
	}

    public static function ClassifiedExcel($elecmentions,$printmentions,$reportperiod,$company_name){
        ini_set('memory_limit', '1024M');
        $PHPExcel = new PHPExcel();
        $title = "Reelforge Classified Stories Excel Report";
        $PHPExcel->getProperties()->setCreator("Reelforge Systems")
        ->setTitle("Reelforge Classified Stories Excel Report")
        ->setSubject("Reelforge Classified Stories Excel Report")
        ->setDescription("Reelforge Classified Stories Excel Report");
        $PHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);
        $styleArray = array('font'  => array('bold'  => true));
        $styleArray2 = array('font'  => array('bold'  => true,'width'  => 100),'alignment' => array('wrap'=> false));
        $PHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->mergeCells('A1:Z1');
        $PHPExcel->getActiveSheet()->mergeCells('A2:Z2');
        $PHPExcel->getActiveSheet()->mergeCells('A3:Z3');
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $PHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("C5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("D5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("E5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("F5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("G5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("K5")->applyFromArray($styleArray);
        
        $PHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Reelforge Classified Stories Excel Report')
        ->setCellValue('A2', 'Client : '.$company_name)
        ->setCellValue('A3', 'Period : '.$reportperiod);
        $count = 6;
        // Print
        if(count($printmentions)>0){
            $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A5', 'DATE')
            ->setCellValue('B5', 'PUBLICATION')
            ->setCellValue('C5', 'JOURNALIST')
            ->setCellValue('D5', 'HEADLINE/SUBJECT')
            ->setCellValue('E5', 'PAGE')
            ->setCellValue('F5', 'PUBLICATION TYPE')
            ->setCellValue('G5', 'PICTURE')
            ->setCellValue('H5', 'CLASSIFICATION')
            ->setCellValue('I5', 'TECHNICAL AREA')
            ->setCellValue('J5', 'COUNTRY')
            ->setCellValue('K5', 'COUNTY')
            ->setCellValue('L5', 'EFFECT')
            ->setCellValue('M5', 'AVE');
            
            $rowcount =1;
            foreach ($printmentions as $keyvalue) {
                $StoryDate = $keyvalue['StoryDate'];
                $storyid = $keyvalue['storyid'];
                $Publication = $keyvalue['Publication'];
                $journalist = $keyvalue['journalist'];
                $Title = $keyvalue['Title'];
                $StoryPage = $keyvalue['StoryPage'];
                $PublicationType = $keyvalue['PublicationType'];
                $Picture = $keyvalue['Picture'];
                $storytonality = $keyvalue['storytonality'];
                $AVE = $keyvalue['AVE'];
                $Link = $keyvalue['Link'];
                $Continues = $keyvalue['Continues'];
                $StoryColumn = $keyvalue['StoryColumn'];
                $ContinuingAve = $keyvalue['ContinuingAve'];
                $uniqueID = $keyvalue['uniqueID'];
                $storyclassification = $keyvalue['storyclassification'];
                $technicalarea = $keyvalue['technicalarea'];
                $country = $keyvalue['country'];
                $county = $keyvalue['county'];
                $printplayer = Yii::app()->params['printplayer'];
                $link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
                $PHPExcel->getActiveSheet()
                ->setCellValue("A$count", $StoryDate)
                ->setCellValueExplicit("B$count", $Publication)
                ->setCellValueExplicit("C$count", $journalist)
                ->setCellValueExplicit("D$count", $Title)
                ->setCellValueExplicit("E$count", $StoryPage)
                ->setCellValueExplicit("F$count", $PublicationType)
                ->setCellValueExplicit("G$count", $Picture)
                ->setCellValueExplicit("H$count", $storyclassification)
                ->setCellValueExplicit("I$count", $technicalarea)

                ->setCellValueExplicit("J$count", $country)
                ->setCellValueExplicit("K$count", $county)

                ->setCellValueExplicit("L$count", $storytonality)
                ->setCellValueExplicit("M$count", $AVE);
                $PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($link);
                $PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                $count++;
                $rowcount++;
            }
        }
        $count++;

        // Electronic
        if(count($elecmentions)>0){
            $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$count", 'DATE')
            ->setCellValue("B$count", 'STATION')
            ->setCellValue("C$count", 'JOURNALIST')
            ->setCellValue("D$count", 'SUMMARY')
            ->setCellValue("E$count", 'TIME')
            ->setCellValue("F$count", 'DURATION')
            ->setCellValue("G$count", 'CATEGORY')
            ->setCellValue("H$count", 'CLASSIFICATION')
            ->setCellValue("I$count", 'TECHNICAL AREA')
            ->setCellValue("J$count", 'COUNTRY')
            ->setCellValue("K$count", 'COUNTY')
            ->setCellValue("L$count", 'EFFECT')
            ->setCellValue("M$count", 'AVE');
            $PHPExcel->getActiveSheet()->getStyle("A$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("B$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("D$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("E$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("F$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("G$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("H$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("I$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("J$count")->applyFromArray($styleArray);
            $PHPExcel->getActiveSheet()->getStyle("K$count")->applyFromArray($styleArray);
            $count++;
            $rowcount =1;
            foreach ($elecmentions as $keyvalue) {
                $StoryDate = $keyvalue['StoryDate'];
                $storyid = $keyvalue['storyid'];
                $Publication = $keyvalue['Publication'];
                $journalist = $keyvalue['journalist'];
                $Title = $keyvalue['Title'];
                $storytonality = $keyvalue['storytonality'];
                $AVE = $keyvalue['AVE'];
                $Link = $keyvalue['Link'];
                $uniqueID = $keyvalue['uniqueID'];
                $storyclassification = $keyvalue['storyclassification'];
                $technicalarea = $keyvalue['technicalarea'];
                $country = $keyvalue['country'];
                $county = $keyvalue['county'];
                $FormatedTime =  $keyvalue['FormatedTime'];
                $FormatedDuration =  $keyvalue['FormatedDuration'];
                $industrycategory =  $keyvalue['industrycategory'];
                $electronicplayer = Yii::app()->params['electronicplayer'];
                $link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
                $PHPExcel->getActiveSheet()
                ->setCellValue("A$count", $StoryDate)
                ->setCellValueExplicit("B$count", $Publication)
                ->setCellValueExplicit("C$count", $journalist)
                ->setCellValueExplicit("D$count", $Title)
                ->setCellValueExplicit("E$count", $FormatedTime)
                ->setCellValueExplicit("F$count", $FormatedDuration)
                ->setCellValueExplicit("G$count", $industrycategory)
                ->setCellValueExplicit("H$count", $storyclassification)
                ->setCellValueExplicit("I$count", $technicalarea)
                ->setCellValueExplicit("J$count", $country)
                ->setCellValueExplicit("K$count", $county)
                ->setCellValueExplicit("L$count", $storytonality)
                ->setCellValueExplicit("M$count", $AVE);
                $PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($link);
                $PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                $count++;
                $rowcount++;
            }
        }
        
        $count++;
        $PHPExcel->getActiveSheet()->setTitle('Classified Stories');

        $PHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/reelmediad/docs/excel/";
        $filename = str_replace(" ","_",$company_name);
        $filename = $filename.'_classified_reports_'.date("Ymdhis").'.xlsx';
        $objWriter->save($upload_path.$filename);
        return $filename;
    }

    

    public static function Genexcel($results){
        
        date_default_timezone_set('Africa/Nairobi');
        $today = date("Y-m-d H:i:s");
        $generated_date = '$today';
        ini_set('memory_limit', '1024M');
        $PHPExcel = new PHPExcel();
        $title = "Reelforge Media Story Excel Report";
        $PHPExcel->getProperties()->setCreator("Reelforge Media Intelligence")
        ->setTitle("Reelforge Media Story Excel Report")
        ->setSubject("Reelforge Media Story Excel Report")
        ->setDescription("Reelforge Media Story Excel Report");
        $PHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);
        $styleArray = array('font'  => array('bold'  => true));
        $styleArray2 = array('font'  => array('bold'  => true,'width'  => 100),'alignment' => array('wrap'=> false));
        $PHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->getStyle("A3")->applyFromArray($styleArray2);
        $PHPExcel->getActiveSheet()->mergeCells('A1:Z1');
        $PHPExcel->getActiveSheet()->mergeCells('A2:Z2');
        $PHPExcel->getActiveSheet()->mergeCells('A3:Z3');
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(65);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        
        $PHPExcel->getActiveSheet()->getStyle("A5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("C5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("D5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("E5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("F5")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("G5")->applyFromArray($styleArray);
       
        // Electonic Sheet
        $PHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Reelforge Media Story Report')
        ->setCellValue('A2', 'Generated On : '.$generated_date)
        //->setCellValue('A3', 'Period : '.$startdate ."-". $enddate)
        ->setCellValue('A5', '#')
        ->setCellValue('B5', 'Date')
        ->setCellValue('C5', 'JOURNALIST')
        ->setCellValue('D5', 'PUBLICATION')
        ->setCellValue('E5', 'TITLE/HEADER')
        ->setCellValue('F5', 'PAGE')
        ->setCellValue('G5', 'AVE');

        $count = 6;
        $pcount=1;
        foreach ($results as $value) {
            $name = $value['journalist'];
            $stdate = $value['StoryDate'];
            $title = $value['Title'];
            $media = $value['Media_House_ID'];
            $page       = $value['StoryPage'];
            $ave       = $value['ave'];
            $stmedia = $value['Media_ID'];
            $Story_ID = $value['Story_ID'];
            $mediahouse =Mediahouse::model()->getMediahouseName2($media);
            $me = implode("", $mediahouse);

             if ($stmedia == 'mp01') {
         $link = "https://media.reelforge.com/player/index.php?storyid=$Story_ID";
         $page = $page;

         $page_title = "<a href = '$link'>$title</a>";
      } else {
         $link = "https://media.reelforge.com/player/video.php?storyid=$Story_ID";
         $page = '--';
         $page_title = "<a href = '$link'>$title</a>";
      }
           

            $PHPExcel->getActiveSheet()
            ->setCellValue("A$count", $pcount)
            ->setCellValueExplicit("B$count", $stdate)
            ->setCellValueExplicit("C$count", $name)
            ->setCellValueExplicit("D$count", $me)
            ->setCellValueExplicit("E$count", $title)
            ->setCellValueExplicit("F$count", $page)
            ->setCellValueExplicit("G$count", $ave);
            $PHPExcel->getActiveSheet()->getCell("E$count")->getHyperlink()->setUrl($link);
            $PHPExcel->getActiveSheet()->getStyle("E$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
            
            $count++;
            $pcount++;

        }
         

        $PHPExcel->getActiveSheet()->setTitle('Media Story');

        $PHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/reelmediad/docs/excel/";
        $filename = str_replace(" ","_",'Media Story Report');
        $filename = $filename.'_MediaReports_'.date("Ymdhis").'.xlsx';
        $objWriter->save($upload_path.$filename);
        return $filename;
    }
}