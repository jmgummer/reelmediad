<?php

/**
* 
*/
class AdvancedSearchFiles
{
	
	public static function ExcelFile($tvmentions,$printmentions,$radiomentions,$reportperiod,$company_name){
        ini_set('memory_limit', '1024M');
        $PHPExcel = new PHPExcel();
        $title = "Advanced Search Excel Report";
        $PHPExcel->getProperties()->setCreator("Reelforge Systems")
        ->setTitle("Advanced Search Excel Report")
        ->setSubject("Advanced Search Excel Report")
        ->setDescription("Advanced Search Excel Report");
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
        $PHPExcel->getActiveSheet()->getStyle("A6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("B6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("C6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("D6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("E6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("F6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("G6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("H6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("I6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("J6")->applyFromArray($styleArray);
        $PHPExcel->getActiveSheet()->getStyle("K6")->applyFromArray($styleArray);
        
        $PHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Advanced Search Excel Report')
        ->setCellValue('A2', 'Client : '.$company_name)
        ->setCellValue('A3', 'Period : '.$reportperiod);
        $PHPExcel->getActiveSheet()->setCellValue("A5", "Print");
        $count = 7;
        // Print
        if(count($printmentions)>0){
            $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A6', 'DATE')
            ->setCellValue('B6', 'PUBLICATION')
            ->setCellValue('C6', 'JOURNALIST')
            ->setCellValue('D6', 'HEADLINE/SUBJECT')
            ->setCellValue('E6', 'PAGE')
            ->setCellValue('F6', 'CLASSIFICATION')
            ->setCellValue('G6', 'SUMMARY')
            ->setCellValue('H6', 'MENTIONED')
            ->setCellValue('I6', 'AVE')
            ->setCellValue('J6', 'URL');
            foreach($printmentions as $keyvalue){
				$StoryDate = $keyvalue['StoryDate'];
				$mediahouse = $keyvalue['mediahouse'];
				$journalist = $keyvalue['journalist'];
				$title = $keyvalue['title'];
				$Story = $keyvalue['Story'];
				$url = $keyvalue['url'];
				$ave = $keyvalue['ave'];
				$customtag = $keyvalue['customtag'];
				$mentioned = $keyvalue['mentioned'];
				$storypage = $keyvalue['storypage'];
				$PHPExcel->getActiveSheet()
				->setCellValue("A$count", $StoryDate)
				->setCellValueExplicit("B$count", $mediahouse)
				->setCellValueExplicit("C$count", $journalist)
				->setCellValueExplicit("D$count", $title)
				->setCellValueExplicit("E$count", $storypage)
				->setCellValueExplicit("F$count", $customtag)
				->setCellValueExplicit("G$count", $Story)
				->setCellValueExplicit("H$count", $mentioned)
				->setCellValueExplicit("I$count", $ave)
				->setCellValueExplicit("J$count", $url);
                $PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($url);
                $PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                $count++;
            }
        }
		$count++;
		$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
		$count++;
        // TV
        if(count($tvmentions)>0){
            $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$count", 'DATE')
            ->setCellValue("B$count", 'STATION')
            ->setCellValue("C$count", 'JOURNALIST')
            ->setCellValue("D$count", 'HEADLINE/SUBJECT')
            ->setCellValue("E$count", 'TIME')
            ->setCellValue("F$count", 'DURATION')
            ->setCellValue("G$count", 'CLASSIFICATION')
            ->setCellValue("H$count", 'SUMMARY')
            ->setCellValue("I$count", 'MENTIONED')
            ->setCellValue("J$count", 'AVE')
            ->setCellValue("K$count", 'URL');
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
            foreach ($tvmentions as $keyvalue) {
            	$StoryDate = $keyvalue['StoryDate'];
				$mediahouse = $keyvalue['mediahouse'];
				$journalist = $keyvalue['journalist'];
				$title = $keyvalue['title'];
				$Story = $keyvalue['Story'];
				$url = $keyvalue['url'];
				$ave = $keyvalue['ave'];
				$customtag = $keyvalue['customtag'];
				$mentioned = $keyvalue['mentioned'];
				$duration = $keyvalue['duration'];
				$storytime = $keyvalue['storytime'];
				$PHPExcel->getActiveSheet()
				->setCellValue("A$count", $StoryDate)
				->setCellValueExplicit("B$count", $mediahouse)
				->setCellValueExplicit("C$count", $journalist)
				->setCellValueExplicit("D$count", $title)
				->setCellValueExplicit("E$count", $storytime)
				->setCellValueExplicit("F$count", $duration)
				->setCellValueExplicit("G$count", $customtag)
				->setCellValueExplicit("H$count", $Story)
				->setCellValueExplicit("I$count", $mentioned)
				->setCellValueExplicit("J$count", $ave)
				->setCellValueExplicit("K$count", $url);
				$PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($url);
				$PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
				$count++;
            }
        }
        $count++;
		$PHPExcel->getActiveSheet()->setCellValue("A$count", "Radio");
		$count++;
        // Radio
        if(count($radiomentions)>0){
            $PHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A$count", 'DATE')
            ->setCellValue("B$count", 'STATION')
            ->setCellValue("C$count", 'JOURNALIST')
            ->setCellValue("D$count", 'HEADLINE/SUBJECT')
            ->setCellValue("E$count", 'TIME')
            ->setCellValue("F$count", 'DURATION')
            ->setCellValue("G$count", 'CLASSIFICATION')
            ->setCellValue("H$count", 'SUMMARY')
            ->setCellValue("I$count", 'MENTIONED')
            ->setCellValue("J$count", 'AVE')
            ->setCellValue("K$count", 'URL');
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
            foreach ($radiomentions as $keyvalue) {
            	$StoryDate = $keyvalue['StoryDate'];
				$mediahouse = $keyvalue['mediahouse'];
				$journalist = $keyvalue['journalist'];
				$title = $keyvalue['title'];
				$Story = $keyvalue['Story'];
				$url = $keyvalue['url'];
				$ave = $keyvalue['ave'];
				$customtag = $keyvalue['customtag'];
				$mentioned = $keyvalue['mentioned'];
				$duration = $keyvalue['duration'];
				$storytime = $keyvalue['storytime'];
				$PHPExcel->getActiveSheet()
				->setCellValue("A$count", $StoryDate)
				->setCellValueExplicit("B$count", $mediahouse)
				->setCellValueExplicit("C$count", $journalist)
				->setCellValueExplicit("D$count", $title)
				->setCellValueExplicit("E$count", $storytime)
				->setCellValueExplicit("F$count", $duration)
				->setCellValueExplicit("G$count", $customtag)
				->setCellValueExplicit("H$count", $Story)
				->setCellValueExplicit("I$count", $mentioned)
				->setCellValueExplicit("J$count", $ave)
				->setCellValueExplicit("K$count", $url);
				$PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($url);
				$PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
				$count++;
            }
        }
        
        $count++;
        $PHPExcel->getActiveSheet()->setTitle('Classified Stories');

        $PHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        $upload_path = $_SERVER['DOCUMENT_ROOT']."/reelmediad/docs/excel/";
        $filename = str_replace(" ","_",$company_name);
        $filename = $filename.'_advanced_reports_'.date("Ymdhis").'.xlsx';
        $objWriter->save($upload_path.$filename);
        return $filename;
    }
}