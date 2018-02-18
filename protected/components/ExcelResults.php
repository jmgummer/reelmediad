<?php

class ExcelResults
{
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
            ->setCellValue('J5', 'EFFECT')
            ->setCellValue('K5', 'AVE');
            
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
                ->setCellValueExplicit("J$count", $storytonality)
                ->setCellValueExplicit("K$count", $AVE);
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
            ->setCellValue("J$count", 'EFFECT')
            ->setCellValue("K$count", 'AVE');
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
                ->setCellValueExplicit("J$count", $storytonality)
                ->setCellValueExplicit("K$count", $AVE);
                $PHPExcel->getActiveSheet()->getCell("D$count")->getHyperlink()->setUrl($link);
                $PHPExcel->getActiveSheet()->getStyle("D$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
                $count++;
                $rowcount++;
            }
        }

        // if(count($elecmentions)>0){
        //     $PHPExcel->setActiveSheetIndex(0)
        //     ->setCellValue('A5', 'DATE')
        //     ->setCellValue('B5', 'STATION')
        //     ->setCellValue('C5', 'JOURNALIST')
        //     ->setCellValue('D5', 'SUMMARY')
        //     ->setCellValue('E5', 'TIME')
        //     ->setCellValue('F5', 'DURATION')
        //     ->setCellValue('G5', 'CATEGORY')
        //     ->setCellValue('H5', 'CLASSIFICATION')
        //     ->setCellValue('I5', 'EFFECT')
        //     ->setCellValue('J5', 'AVE');
        //     $count = 6;
        //     $rowcount =1;
        //     foreach ($mentionsarray as $keyvalue) {

        //         $StoryDate = $keyvalue['StoryDate'];
        //         $storyid = $keyvalue['storyid'];
        //         $Publication = $keyvalue['Publication'];
        //         $journalist = $keyvalue['journalist'];
        //         $Title = $keyvalue['Title'];
        //         $StoryPage = $keyvalue['StoryPage'];
        //         $PublicationType = $keyvalue['PublicationType'];
        //         $Picture = $keyvalue['Picture'];
        //         $storytonality = $keyvalue['storytonality'];
        //         $AVE = $keyvalue['AVE'];
        //         $Link = $keyvalue['Link'];
        //         $Continues = $keyvalue['Continues'];
        //         $StoryColumn = $keyvalue['StoryColumn'];
        //         $ContinuingAve = $keyvalue['ContinuingAve'];
        //         $uniqueID = $keyvalue['uniqueID'];
        //         $storyclassification = $keyvalue['storyclassification'];

        //         $printplayer = Yii::app()->params['printplayer'];
        //         $link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;

        //         $tabledata = '<tr>
        //         <td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
        //         <td>'.$pub.'</td>
        //         <td>'.$journo.'</td>
        //         <td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
        //         <td>'.$page.'</td>
        //         <td>'.$pubtype.'</td>
        //         <td>'.$pic.'</td>
        //         <td id="classification'.$storyid.'"><a onclick="UpdateClientClassification('.$storyid.');" style="cursor: pointer;">'.$storyclassification.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
        //         if($effect=='N/A'){
        //             $tabledata.= '<td>'.$effect.'</td>';
        //         }else{
        //             $tabledata.='<td id="tonality'.$storyid.'"><a onclick="AddClientTonality('.$storyid.');" style="cursor: pointer;">'.$effect.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
        //         }
        //         $tabledata .= '<td style="text-align:right;">'.number_format($ContinuingAve).'</td>
        //         </tr>';



        //         $id = $keyvalue->id;
        //         $Date = $keyvalue->Date;
        //         $Tonality = $keyvalue->Tonality;
        //         $Title = $keyvalue->Title;
        //         $Link = $keyvalue->permalink;
        //         $Domain = $keyvalue->Domain;
        //         $Authors = $keyvalue->Authors;
        //         $Themes = $keyvalue->Themes;
        //         $Keywords = $keyvalue->Keywords;
        //         $AVE = $keyvalue->AVE;
        //         $OTS = $keyvalue->OTS;

        //         $PHPExcel->getActiveSheet()
        //         ->setCellValue("A$count", $rowcount)
        //         ->setCellValueExplicit("B$count", $Title)
        //         ->setCellValueExplicit("C$count", $Date)
        //         ->setCellValueExplicit("D$count", $Tonality)
        //         ->setCellValueExplicit("E$count", $Domain)
        //         ->setCellValueExplicit("F$count", $Link)
        //         ->setCellValueExplicit("G$count", $Authors)
        //         ->setCellValueExplicit("H$count", $OTS)
        //         ->setCellValueExplicit("I$count", $Themes)
        //         ->setCellValueExplicit("J$count", $Keywords)
        //         ;
        //         $PHPExcel->getActiveSheet()->getCell("B$count")->getHyperlink()->setUrl($Link);
        //         $PHPExcel->getActiveSheet()->getStyle("B$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
        //         $count++;
        //         $rowcount++;
        //     }
        // }
        
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
}