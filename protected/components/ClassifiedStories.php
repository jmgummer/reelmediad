<?php

/**
* This class provides classified stories
*/
class ClassifiedStories
{
	public static function GetClientStories($client,$startdate,$enddate,$search,$backdate,$country_list,$storytype,$classification)
	{
		$clientid = Yii::app()->user->company_id;
		$c_sql = "SELECT * FROM company WHERE company_id=$clientid";
		if($company_words = Company::model()->findBySql($c_sql)){
			$rmcompanyname = $company_words->company_name;
		}
		$companyname = $rmcompanyname;
		if(!empty($search)){
			$searchqry = " AND ( (story like '%$search%') OR (title like '%$search%') OR (mentioned like '%$search%') ) ";
		}else{
			$searchqry = " ";
		}
		if($storytype==1){
			$mediaidqry = "";
		}
		if($storytype==2){
			$mediaidqry = " AND story.Media_ID='mp01' ";
		}
		if($storytype==3){
			$mediaidqry = " AND story.Media_ID IN ('mr01','mt01') ";
		}
		if(is_array($classification)){
			$cls_list = implode(',', $classification);
		}else{
			$cls_list = $classification;
		}
		$reportperiod = $startdate." - ".$enddate;
		$sql = "SELECT DISTINCT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , 
		story.StoryDuration,  story.StoryTime,story.picture ,
		story.Media_ID, story.print_rate, story.uniqueID, story.ave,story_classification.classification_id
		FROM story 
		INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID
		INNER JOIN story_classification ON story.Story_ID = story_classification.story_id
		WHERE story.step3=1 
		AND StoryDate>'$backdate' AND story_classification.classification_id IN ($cls_list)
		AND story.cont_from = 0 
		AND StoryDate between '$startdate' AND '$enddate'  $searchqry $mediaidqry
		order by StoryDate asc, Media_House_List asc, page_no asc";
		$completehtml = "";
		$printhtml = "";
		$elechtml = "";
		$excel_print_array = array();
		$excel_elec_array = array();
		if($story = Story::model()->findAllBySql($sql)){
			foreach ($story as $key) {
				$storyid = $key->Story_ID;
				$tarea = Story::TechicalArea($storyid,$client);
				
				$storyclassification = Story::Classification($storyid,$client);
				$technicalarea = $tarea['technical_area_name'];
				$tcountry = $tarea['country'];
				$tcounty = $tarea['county'];

				$storytonality = Story::ClientTonality($key->Story_ID,$client);
				$industrycategory = Story::ClientIndustryCategory($key->Story_ID,$client);
				$StoryDate = $key->StoryDate;
				$Story_ID = $key->Story_ID;
				$Publication = $key->Publication;
				$journalist = $key->journalist;
				$Title = $key->Title;
				$StoryPage = $key->StoryPage;
				$PublicationType = $key->PublicationType;
				$Picture = $key->Picture;
				$AVE = $key->AVE;
				$Link = $key->Link;
				$Continues = $key->Continues;
				$StoryColumn = $key->StoryColumn;
				$ContinuingAve = $key->ContinuingAve;
				$uniqueID = $key->uniqueID;
				$FormatedTime = $key->FormatedTime;
				$FormatedDuration = $key->FormatedDuration;
				if($key->Media_ID=='mp01'){
					$excel_print_array[] = array('StoryDate'=>$StoryDate,'storyid'=>$storyid,'Publication'=>$Publication,'journalist'=>$journalist,'Title'=>$Title,'StoryPage'=>$StoryPage,'PublicationType'=>$PublicationType,'Picture'=>$Picture,'storytonality'=>$storytonality,'AVE'=>$AVE,'Link'=>$Link,'Continues'=>$Continues,'StoryColumn'=>$StoryColumn,'ContinuingAve'=>$ContinuingAve,'uniqueID'=>$uniqueID,'storyclassification'=>$storyclassification,'technicalarea'=>$technicalarea,'country'=>$tcountry,'county'=>$tcounty);
					$printhtml.= ClassifiedStories::PrintTableBody($StoryDate,$storyid,$Publication,$journalist,$Title,$StoryPage,$PublicationType,$Picture,$storytonality,$AVE,$Link,$Continues,$StoryColumn,$ContinuingAve,$uniqueID,$storyclassification,$technicalarea);
				}else{
					$excel_elec_array[] = array('StoryDate'=>$StoryDate,'storyid'=>$storyid,'Publication'=>$Publication,'journalist'=>$journalist,'Title'=>$Title,'FormatedTime'=>$FormatedTime,'FormatedDuration'=>$FormatedDuration,'industrycategory'=>$industrycategory,'storytonality'=>$storytonality,'AVE'=>$AVE,'Link'=>$Link,'Continues'=>$Continues,'uniqueID'=>$uniqueID,'storyclassification'=>$storyclassification,'technicalarea'=>$technicalarea,'country'=>$tcountry,'county'=>$tcounty);
					$elechtml.= ClassifiedStories::ElectronicTableBody($StoryDate,$storyid,$Publication,$journalist,$Title,$FormatedTime,$FormatedDuration,$industrycategory,$storytonality,$AVE,$Link,$Continues,$uniqueID,$storyclassification,$technicalarea);
				}
			}
			$recordcount = count($excel_elec_array)+count($excel_print_array);
		    echo "[$recordcount] Records Found<br>";
		    $excelfile = ExcelResults::ClassifiedExcel($excel_elec_array,$excel_print_array,$reportperiod,$companyname);
		    echo '<p><strong><a href="'.Yii::app()->request->baseUrl . '/docs/excel/'.$excelfile.'"><i class="fa fa-file-excel-o"></i> Download Excel File</a></strong></p>';
			if($printhtml!=''){
				echo "<p><strong>Print Stories</strong></p>";
				echo ClassifiedStories::PrintTableHead();
				echo $printhtml;
				echo ClassifiedStories::TableEnd();
			}

			if($elechtml!=''){
				echo "<p><strong>Electronic Stories</strong></p>";
				echo ClassifiedStories::ElectronicTableHead();
				echo $elechtml;
				echo ClassifiedStories::TableEnd();
			}
			
		}else{
			echo 'No Records Found';
		}
	}

	public static function GetAgencyClientStories($client,$startdate,$enddate,$search,$backdate,$country_list,$storytype,$classification)
	{
		$clientid = Yii::app()->user->company_id;
		$c_sql = "SELECT * FROM company WHERE company_id=$clientid";
		if($company_words = Company::model()->findBySql($c_sql)){
			$rmcompanyname = $company_words->company_name;
		}
		$companyname = $rmcompanyname;
		if(!empty($search)){
			$searchqry = " AND ( (story like '%$search%') OR (title like '%$search%') OR (mentioned like '%$search%') ) ";
		}else{
			$searchqry = " ";
		}
		if($storytype==1){
			$mediaidqry = "";
		}
		if($storytype==2){
			$mediaidqry = " AND story.Media_ID='mp01' ";
		}
		if($storytype==3){
			$mediaidqry = " AND story.Media_ID IN ('mr01','mt01') ";
		}
		if(is_array($classification)){
			$cls_list = implode(',', $classification);
		}else{
			$cls_list = $classification;
		}
		$reportperiod = $startdate." - ".$enddate;
		$sql = "SELECT DISTINCT story.Story_ID,story.StoryDate,story.Title,story.Story,story.StoryPage,
		story.cont_on,story.cont_from,story.editor,
		story.Media_House_ID,story.journalist,story.StoryDate ,story.col ,story.centimeter , 
		story.StoryDuration,  story.StoryTime,story.picture ,
		story.Media_ID, story.print_rate, story.uniqueID, story.ave,story_classification.classification_id
		FROM story 
		INNER JOIN mediahouse ON story.Media_House_ID=mediahouse.Media_House_ID
		INNER JOIN story_classification ON story.Story_ID = story_classification.story_id
		WHERE story.step3=1 
		AND StoryDate>'$backdate' AND story_classification.classification_id IN ($cls_list)
		AND story.cont_from = 0 
		AND StoryDate between '$startdate' AND '$enddate'  $searchqry $mediaidqry
		order by StoryDate asc, Media_House_List asc, page_no asc";
		$completehtml = "";
		$printhtml = "";
		$elechtml = "";
		$excel_print_array = array();
		$excel_elec_array = array();
		if($story = Story::model()->findAllBySql($sql)){
			foreach ($story as $key) {
				$storyid = $key->Story_ID;
				$tarea = Story::TechicalArea($storyid,$client);
				
				$storyclassification = Story::Classification($storyid,$client);
				$technicalarea = $tarea['technical_area_name'];
				$tcountry = $tarea['country'];
				$tcounty = $tarea['county'];

				$storytonality = Story::ClientTonality($key->Story_ID,$client);
				$industrycategory = Story::ClientIndustryCategory($key->Story_ID,$client);
				$StoryDate = $key->StoryDate;
				$Story_ID = $key->Story_ID;
				$Publication = $key->Publication;
				$journalist = $key->journalist;
				$Title = $key->Title;
				$StoryPage = $key->StoryPage;
				$PublicationType = $key->PublicationType;
				$Picture = $key->Picture;
				$AVE = $key->AVE;
				$Link = $key->Link;
				$Continues = $key->Continues;
				$StoryColumn = $key->StoryColumn;
				$ContinuingAve = $key->ContinuingAve;
				$uniqueID = $key->uniqueID;
				$FormatedTime = $key->FormatedTime;
				$FormatedDuration = $key->FormatedDuration;
				if($key->Media_ID=='mp01'){
					$excel_print_array[] = array('StoryDate'=>$StoryDate,'storyid'=>$storyid,'Publication'=>$Publication,'journalist'=>$journalist,'Title'=>$Title,'StoryPage'=>$StoryPage,'PublicationType'=>$PublicationType,'Picture'=>$Picture,'storytonality'=>$storytonality,'AVE'=>$AVE,'Link'=>$Link,'Continues'=>$Continues,'StoryColumn'=>$StoryColumn,'ContinuingAve'=>$ContinuingAve,'uniqueID'=>$uniqueID,'storyclassification'=>$storyclassification,'technicalarea'=>$technicalarea,'country'=>$tcountry,'county'=>$tcounty);
					$printhtml.= ClassifiedStories::AgencyPrintTableBody($StoryDate,$storyid,$Publication,$journalist,$Title,$StoryPage,$PublicationType,$Picture,$storytonality,$AVE,$Link,$Continues,$StoryColumn,$ContinuingAve,$uniqueID,$storyclassification,$technicalarea);
				}else{
					$excel_elec_array[] = array('StoryDate'=>$StoryDate,'storyid'=>$storyid,'Publication'=>$Publication,'journalist'=>$journalist,'Title'=>$Title,'FormatedTime'=>$FormatedTime,'FormatedDuration'=>$FormatedDuration,'industrycategory'=>$industrycategory,'storytonality'=>$storytonality,'AVE'=>$AVE,'Link'=>$Link,'Continues'=>$Continues,'uniqueID'=>$uniqueID,'storyclassification'=>$storyclassification,'technicalarea'=>$technicalarea,'country'=>$tcountry,'county'=>$tcounty);
					$elechtml.= ClassifiedStories::AgencyElectronicTableBody($StoryDate,$storyid,$Publication,$journalist,$Title,$FormatedTime,$FormatedDuration,$industrycategory,$storytonality,$AVE,$Link,$Continues,$uniqueID,$storyclassification,$technicalarea);
				}
			}
			$recordcount = count($excel_elec_array)+count($excel_print_array);
		    echo "[$recordcount] Records Found<br>";
		    $excelfile = ExcelResults::ClassifiedExcel($excel_elec_array,$excel_print_array,$reportperiod,$companyname);
		    echo '<p><strong><a href="'.Yii::app()->request->baseUrl . '/docs/excel/'.$excelfile.'"><i class="fa fa-file-excel-o"></i> Download Excel File</a></strong></p>';
			if($printhtml!=''){
				echo "<p><strong>Print Stories</strong></p>";
				echo ClassifiedStories::AgencyPrintTableHead();
				echo $printhtml;
				echo ClassifiedStories::TableEnd();
			}

			if($elechtml!=''){
				echo "<p><strong>Electronic Stories</strong></p>";
				echo ClassifiedStories::AgencyElectronicTableHead();
				echo $elechtml;
				echo ClassifiedStories::TableEnd();
			}
			
		}else{
			echo 'No Records Found';
		}
	}

	/*
	* Print The Top Section of Every Table
	* NB - Just for the Electronic Section
	*/
	public static function ElectronicTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>CLASSIFICATION</th><th>TECH AREA</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	public static function AgencyElectronicTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>STATION</th><th>JOURNALIST</th><th>SUMMARY</th><th>TIME</th><th>DURATION</th><th>CATEGORY</th><th>CLASSIFICATION</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	/*
	* Print The Body of the Table This function may be called recursively
	* NB - Just for the Electronic Section
	*/
	public static function ElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID,$storyclassification,$technicalarea){
		$electronicplayer = Yii::app()->params['electronicplayer'];
		$link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$tabledata = '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td id="classification'.$storyid.'"><a onclick="UpdateClientClassification('.$storyid.');" style="cursor: pointer;">'.$storyclassification.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>
		<td id="techarea'.$storyid.'"><a onclick="UpdateTechnicalArea('.$storyid.');" style="cursor: pointer;">'.$technicalarea.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';

		if($effect=='N/A'){
			$tabledata.= '<td>'.$effect.'</td>';
		}else{
			$tabledata.='<td id="tonality'.$storyid.'"><a onclick="AddClientTonality('.$storyid.');" style="cursor: pointer;">'.$effect.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		}
		$tabledata.='<td style="text-align:right;">'.number_format($ave).'</td></tr>';
		return $tabledata;
	}

	public static function AgencyElectronicTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$uniqueID,$storyclassification,$technicalarea){
		$electronicplayer = Yii::app()->params['electronicplayer'];
		$link = $electronicplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$tabledata = '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td id="classification'.$storyid.'"><a onclick="UpdateClientClassification('.$storyid.');" style="cursor: pointer;">'.$storyclassification.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		if($effect=='N/A'){
			$tabledata.= '<td>'.$effect.'</td>';
		}else{
			$tabledata.='<td id="tonality'.$storyid.'"><a onclick="AddClientTonality('.$storyid.');" style="cursor: pointer;">'.$effect.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		}
		$tabledata.='<td style="text-align:right;">'.number_format($ave).'</td></tr>';
		return $tabledata;
	}

	/*
	* Print The Top Section of Every Table
	* NB - Just for the Print Section
	*/
	public static function PrintTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>CLASSIFICATION</th><th>TECH AREA</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	public static function AgencyPrintTableHead(){
		$currency = Yii::app()->params['country_currency'];
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>CLASSIFICATION</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	/*
	* Print The Body of the Table This function may be called recursively
	* NB - Just for the Print Section
	*/
	public static function PrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$StoryColum,$ContinuingAve,$uniqueID,$storyclassification,$technicalarea){
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$tabledata = '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td id="classification'.$storyid.'"><a onclick="UpdateClientClassification('.$storyid.');" style="cursor: pointer;">'.$storyclassification.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>
		<td id="techarea'.$storyid.'"><a onclick="UpdateTechnicalArea('.$storyid.');" style="cursor: pointer;">'.$technicalarea.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		if($effect=='N/A'){
			$tabledata.= '<td>'.$effect.'</td>';
		}else{
			$tabledata.='<td id="tonality'.$storyid.'"><a onclick="AddClientTonality('.$storyid.');" style="cursor: pointer;">'.$effect.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		}
		$tabledata .= '<td style="text-align:right;">'.number_format($ContinuingAve).'</td>
		</tr>';
		return $tabledata;
	}

	public static function AgencyPrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$link,$cont,$StoryColum,$ContinuingAve,$uniqueID,$storyclassification,$technicalarea){
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$tabledata = '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td id="classification'.$storyid.'"><a onclick="UpdateClientClassification('.$storyid.');" style="cursor: pointer;">'.$storyclassification.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		if($effect=='N/A'){
			$tabledata.= '<td>'.$effect.'</td>';
		}else{
			$tabledata.='<td id="tonality'.$storyid.'"><a onclick="AddClientTonality('.$storyid.');" style="cursor: pointer;">'.$effect.' <sup><i class="fa fa-history" aria-hidden="true"></i></sup></a></td>';
		}
		$tabledata .= '<td style="text-align:right;">'.number_format($ContinuingAve).'</td>
		</tr>';
		return $tabledata;
	}

	/*
	* Close the Table and Its Bottom section
	* NB - Just for the Print Section
	*/
	public static function TableEnd(){
		return '</table></div></div>';
	}
}