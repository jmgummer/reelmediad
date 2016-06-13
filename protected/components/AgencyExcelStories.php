<?php

/**
* AgencyExcelStories Component Class
* This Class Is Used To Return The Agency Stories
* DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
* 
* @package     Reelmedia
* @subpackage  Components
* @category    Reelforge Client Systems
* @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
* @author      Steve Ouma Oyugi - Reelforge Developers Team
* @version 	   v.1.0
* @since       July 2008
*/


class AgencyExcelStories{
	/**
	*
	* @return  Return Excel Sheets
	* @throws  InvalidArgumentException
	* @todo    This function handles all the heavylifting for Print Stories, fetch story and print out
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function GetMainOption($client,$startdate,$enddate,$search,$backdate,$country_list,$industries,$option){
		// Currency Value Based on Country
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}

		// Obtain the Agency ID from Session
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="select agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}

		$PHPExcel = new PHPExcel();
				
		// Set properties
		$PHPExcel->getProperties()->setCreator("Reelforge")
		->setTitle("Reelforge Reports")
		->setSubject("Reelforge Reports")
		->setDescription("Reelforge Reports");

		$PHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(8);

		// Add some data
		if($option==1){
			// My Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */

			//Start from second row

			if(!empty($industries)){
			  	$q2 = 'SELECT distinct story.Story_ID 
			  	FROM story
			    inner join story_mention on story.Story_ID=story_mention.story_id
			    inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			    INNER JOIN story_industry on story_industry.story_id=story.Story_ID
			    INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
			    where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			    and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			    and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			    and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
			    order by StoryDate asc, Media_House_List asc,  page_no asc';
			}else{
			  	$q2 = 'SELECT distinct story.Story_ID 
			  	FROM story
			  	inner join story_mention on story.Story_ID=story_mention.story_id
			  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			  	order by StoryDate asc, Media_House_List asc,  page_no asc';
			}


			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q2)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
			            $PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
			            $PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));


				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
				->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
			// Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Print Stories');
		

			// My Electronic Stories
			$sheetId = 1;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q3 = 'SELECT story.Story_ID,story.StoryDate,story.Title,story.Category_ID,story.Story,story.StoryPage,story.editor,story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , story.StoryDuration,  story.StoryTime,story.picture , story.Media_ID from story,story_mention,mediahouse
			where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
			and story.Media_ID!="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q3)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Electronic Stories');
		
			// Industry Print Stories
			$sheetId = 2;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q4 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id';
			if(!empty($industries)){
			  $q4 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q4 .=' and story.Media_ID="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q4)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Print Stories');
		
			// Industry Electronic Stories
			$sheetId = 3;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q5 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,Category_ID,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id ';
			if(!empty($industries)){
			  $q5 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q5 .='	and story.Media_ID!="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q5)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Electronic Stories');
		
		// Set active sheet index to the right sheet, depending on the options,
		// so Excel opens this as the first sheet
		$PHPExcel->setActiveSheetIndex(0);
			
		// Redirect output to a clients web browser (Excel2003)
		$time = date("Ymdhis");
		header('Content-Type: application/excel');
		header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
		$objWriter->save('php://output');
		}
		if($option==2){
			// My Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */

			//Start from second row

			if(!empty($industries)){
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			    inner join story_mention on story.Story_ID=story_mention.story_id
			    inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			    INNER JOIN story_industry on story_industry.story_id=story.Story_ID
			    INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
			    where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			    and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			    and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			    and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
			    order by StoryDate asc, Media_House_List asc,  page_no asc';
			}else{
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			  	inner join story_mention on story.Story_ID=story_mention.story_id
			  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			  	order by StoryDate asc, Media_House_List asc,  page_no asc';
			}
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q2)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
			// Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Print Stories');
		

			// My Electronic Stories
			$sheetId = 1;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q3 = 'SELECT * from story,story_mention,mediahouse
			where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
			and story.Media_ID!="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q3)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Electronic Stories');
		
			
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==3){
			// Industry Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q4 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id';
			if(!empty($industries)){
			  $q4 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q4 .=' and story.Media_ID="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q4)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Print Stories');
		
			// Industry Electronic Stories
			$sheetId = 1;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q5 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,Category_ID,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id ';
			if(!empty($industries)){
			  $q5 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q5 .='	and story.Media_ID!="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q5)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Electronic Stories');
		
		// Set active sheet index to the right sheet, depending on the options,
		// so Excel opens this as the first sheet
		$PHPExcel->setActiveSheetIndex(0);
			
		// Redirect output to a clients web browser (Excel2003)
		$time = date("Ymdhis");
		header('Content-Type: application/excel');
		header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
		$objWriter->save('php://output');
		}
		if($option==4){
			// My Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */

			//Start from second row

			if(!empty($industries)){
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			    inner join story_mention on story.Story_ID=story_mention.story_id
			    inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			    INNER JOIN story_industry on story_industry.story_id=story.Story_ID
			    INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
			    where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			    and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			    and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			    and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
			    order by StoryDate asc, Media_House_List asc,  page_no asc';
			}else{
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			  	inner join story_mention on story.Story_ID=story_mention.story_id
			  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			  	order by StoryDate asc, Media_House_List asc,  page_no asc';
			}
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q2)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
			// Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Print Stories');
		
			// Industry Print Stories
			$sheetId = 1;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q4 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id';
			if(!empty($industries)){
			  $q4 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q4 .=' and story.Media_ID="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q4)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Print Stories');
		
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==5){
			// My Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */

			//Start from second row

			if(!empty($industries)){
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			    inner join story_mention on story.Story_ID=story_mention.story_id
			    inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			    INNER JOIN story_industry on story_industry.story_id=story.Story_ID
			    INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
			    where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			    and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			    and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			    and industry_subs.company_id ='.$client.' and industry_subs.industry_id IN('.$industries.')
			    order by StoryDate asc, Media_House_List asc,  page_no asc';
			}else{
			  $q2 = 'SELECT distinct story.Story_ID FROM story
			  	inner join story_mention on story.Story_ID=story_mention.story_id
			  	inner join mediahouse on story.Media_House_ID=mediahouse.Media_House_ID
			  	where story_mention.client_id='.$client.' and story.Media_ID="mp01" and story.step3=1
			  	and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			  	and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%"
			  	order by StoryDate asc, Media_House_List asc,  page_no asc';
			}
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q2)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
			// Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Print Stories');

			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==6){
			// Industry Print Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'PUBLICATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', 'PHOTO JOURNALIST')
			->setCellValue('F1', 'PAGE')
			->setCellValue('G1', 'COLCM')
			->setCellValue('H1', 'PICTURE')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q4 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id';
			if(!empty($industries)){
			  $q4 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q4 .=' and story.Media_ID="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q4)){
				$avesum = 0;
				$prvsum = 0;
				foreach ($story as $key) {
					if($story = AgencyExcelStories::GetStories($key->Story_ID)){
						$link = 'http://www.reelforge.com/reelmediad/swf/view/'.$story->Story_ID;
						$PHPExcel->getActiveSheet()
			            ->setCellValue("A$count", date('d-M-Y', strtotime($story->StoryDate)))
			            ->setCellValue("B$count", $story->Publication)
			            ->setCellValue("C$count", $story->Title)
			            ->setCellValue("D$count", $story->journalist)
			            ->setCellValue("E$count", $story->PhotoJournalist)
			            ->setCellValue("F$count", $story->StoryPage)
			            ->setCellValue("G$count", $story->StoryColumn)
			            ->setCellValue("H$count", $story->Picture)
			            ->setCellValue("I$count", $story->StoryCategory)
			            ->setCellValue("J$count", Story::ClientTonality($story->Story_ID,$client))
			            ->setCellValue("K$count", Story::AVEFormatted($story->AVE))
			            ->setCellValue("L$count", Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$story->AVE)))
			            ->setCellValue("M$count", Story::StoryIndustry($story->Story_ID,$client))
			            ->setCellValue("N$count", $story->StorySummary);
			            $PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
						
			            $avesum = $avesum + $story->AVE;
			            $prvsum = $prvsum + $prv;
						
			            $count++;
					}
				}
				$count=$count+1;
		        $PHPExcel->getActiveSheet()
		        ->setCellValue("K$count", Common::ExcelNumberFormat($avesum))
		        ->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Print Stories');
		
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==7){
			// My Electronic Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q3 = 'SELECT * from story,story_mention,mediahouse
			where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
			and story.Media_ID!="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q3)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Electronic Stories');
		
			// Industry Electronic Stories
			$sheetId = 1;
			$PHPExcel->createSheet(NULL, $sheetId);
			$PHPExcel->setActiveSheetIndex($sheetId)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q5 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,Category_ID,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id ';
			if(!empty($industries)){
			  $q5 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q5 .='	and story.Media_ID!="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q5)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Electronic Stories');
		
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==8){
			// My Electronic Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q3 = 'SELECT * from story,story_mention,mediahouse
			where story_mention.client_id='.$client.' and story.Story_ID=story_mention.story_id
			and story.Media_ID!="mp01" and story.step3=1
			and StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and StoryDate between "'.$startdate.'" and "'.$enddate.'" and story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q3)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}
				

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('My Electronic Stories');
		
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		if($option==9){
			// Industry Electronic Stories
			$PHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'DATE')
			->setCellValue('B1', 'STATION')
			->setCellValue('C1', 'HEADLINE/SUBJECT')
			->setCellValue('D1', 'JOURNALIST')
			->setCellValue('E1', ' ')
			->setCellValue('F1', 'TIME')
			->setCellValue('G1', 'DURATION')
			->setCellValue('H1', ' ')
			->setCellValue('I1', 'CATEGORY NAME')
			->setCellValue('J1', 'EFFECT')
			->setCellValue('K1', 'AVE VALUE('.$currency.')')
			->setCellValue('L1', 'PR VALUE('.$currency.')')
			->setCellValue('M1', 'INDUSTRY')
			->setCellValue('N1', 'SUMMARY');

			$PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
			$PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
			$PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
			$PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(80);

			/* Add Values to the Spreadsheet */
			$q5 = 'SELECT distinct(story.story_id) as Story_ID,uniqueID, Title,Category_ID,StoryDate,editor,StoryTime,StoryPage,journalist,story.Media_House_ID,picture,col,centimeter,StoryDuration, file, story.Media_ID, Story
			from story, story_industry, industry_subs, mediahouse
			where story.story_id NOT IN (select story_id from story_mention where client_id='.$client.')
			and story.story_id=story_industry.story_id and industry_subs.company_id='.$client.'
			and story_industry.industry_id=industry_subs.industry_id ';
			if(!empty($industries)){
			  $q5 .= ' and industry_subs.industry_id IN('.$industries.')';
			}
			$q5 .='	and story.Media_ID!="mp01"
			and story.StoryDate>"'.$backdate.'" and mediahouse.country_id IN ("'.$country_list.'")
			and story.step3=1 and StoryDate between "'.$startdate.'" and "'.$enddate.'"
			and story.story like "%'.$search.'%" and story.Media_House_ID=mediahouse.Media_House_ID
			order by StoryDate asc, Media_House_List asc';
			$count = 2;
			$styleArray = array(
			  'font' => array(
			    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
			  )
			);
			if($story = Story::model()->findAllBySql($q5)){
				$electronic_split = ExcelElectronic::AgencyArrayGenerator($story,$client,$agency_pr_rate);

				$tv_section = $electronic_split['tvdata'];
				if(count($tv_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "TV");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($tv_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

			    $radio_section = $electronic_split['radiodata'];
				if(count($radio_section)>0){
					$PHPExcel->getActiveSheet()->setCellValue("A$count", "RADIO");
					$count=$count+1;
					$avesum = 0;
					$prvsum = 0;

					foreach ($radio_section as $key) {
						$link = $key["link"];
						$PHPExcel->getActiveSheet()
						->setCellValue("A$count", $key["date"])
			            ->setCellValue("B$count", $key["publication"])
			            ->setCellValue("C$count", $key["title"])
			            ->setCellValue("D$count", $key["journalist"])
			            ->setCellValue("E$count", '')
			            ->setCellValue("F$count", $key["time"])
			            ->setCellValue("G$count", $key["duration"])
			            ->setCellValue("H$count", '')
			            ->setCellValue("I$count", $key["category"])
			            ->setCellValue("J$count", $key["tonality"])
			            ->setCellValue("K$count", $key["ave"])
			            ->setCellValue("L$count", $key["prv"])
			            ->setCellValue("M$count", $key["industry"])
			            ->setCellValue("N$count", $key["summary"]);
						$PHPExcel->getActiveSheet()->getCell("C$count")->getHyperlink()->setUrl($link);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->applyFromArray($styleArray);
						$PHPExcel->getActiveSheet()->getStyle("C$count")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

						$key["ave"] = str_replace(",", "", $key["ave"]);
						$key["prv"] = str_replace(",", "", $key["prv"]);
						
			            $avesum = $avesum + $key["ave"];
			            $prvsum = $prvsum + $key["prv"];
						
			            $count++;
					}
					$count=$count+1;
			        $PHPExcel->getActiveSheet()->setCellValue("K$count", Common::ExcelNumberFormat($avesum))->setCellValue("L$count", Common::ExcelNumberFormat($prvsum));
			        $count=$count+1;
			    }

				unset($styleArray);
			}else{
				$PHPExcel->getActiveSheet()
		        ->setCellValue("A$count", 'No Records')
				->setCellValue("B$count", 'No Records')
				->setCellValue("C$count", 'No Records')
				->setCellValue("D$count", 'No Records')
				->setCellValue("E$count", 'No Records')
				->setCellValue("F$count", 'No Records')
				->setCellValue("G$count", 'No Records')
				->setCellValue("H$count", 'No Records')
				->setCellValue("I$count", 'No Records')
				->setCellValue("J$count", 'No Records')
				->setCellValue("K$count", 'No Records')
				->setCellValue("L$count", 'No Records')
				->setCellValue("M$count", 'No Records')
				->setCellValue("N$count", 'No Records');
			}

		    // Rename sheet
			$PHPExcel->getActiveSheet()->setTitle('Industry Electronic Stories');
		
			// Set active sheet index to the right sheet, depending on the options,
			// so Excel opens this as the first sheet
			$PHPExcel->setActiveSheetIndex(0);
				
			// Redirect output to a clients web browser (Excel2003)
			$time = date("Ymdhis");
			header('Content-Type: application/excel');
			header("Content-Disposition: attachment;filename=Reelmedia_Stories_Report_".$time.".xls");
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
			
	}


	/*
	* This Function obtains a particular story only
	*/
	public static function GetStories($story_id){
		if($story = Story::model()->find('Story_ID=:a', array(':a'=>$story_id))){
			return $story;
		}
	}
}


?>