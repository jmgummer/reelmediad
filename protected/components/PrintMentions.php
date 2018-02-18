<?php

class PrintMentions{

	public static function Packager($datatable){
		$htmldata = "";
		$sql = "SELECT * FROM $datatable WHERE Media_ID='mp01'";
		if($stored_data = Yii::app()->db2->createCommand($sql)->queryAll()){
			$storycount = count($stored_data);
			$htmldata .= "<p>$storycount Stories Found</p>";
			if(Yii::app()->user->usertype=='agency'){
				$htmldata .= PrintMentions::AgencyPrintTableHead();
				foreach ($stored_data as $key) {
					$key['Picture'] 		= PrintMentions::Picture($key['picture']);
					$key['PublicationType'] = PrintMentions::PublicationType($key['Media_House_ID']);
					$key['Continues'] 		= PrintMentions::Continues($key['cont_on'],$key['cont_from']);
					$key['StoryColumn'] 	= PrintMentions::StoryColumn($key['cont_on'],$key['cont_from']);
					$key['AVE'] 			= PrintMentions::AVE($key['print_rate'],$key['cont_on']);
					$htmldata .= PrintMentions::AgencyPrintTableBody($key['StoryDate'],$key['Story_ID'],$key['Media_House_List'],$key['journalist'],$key['Title'],$key['StoryPage'],$key['PublicationType'],$key['Picture'],$key['tonality'],$key['AVE'],$key['Continues'],$key['StoryColumn'],$key['uniqueID']);
				}
				$htmldata .= PrintMentions::PrintTableEnd();
			}else{
				$htmldata .= PrintMentions::PrintTableHead();
				foreach ($data as $key) {
					$htmldata .= PrintMentions::PrintTableBody($key['StoryDate'],$key['Story_ID'],$key['Media_House_List'],$key['journalist'],$key['Title'],$key['StoryPage'],$key['PublicationType'],$key['Picture'],$key['tonality'],$key['AVE'],$key['Continues'],$key['StoryColumn'],$key['uniqueID']);
				}
				$htmldata .= PrintMentions::PrintTableEnd();
			}

		}else{
			$htmldata = "<p><strong>No Print Stories Found</strong></p>";
		}

		return $htmldata;
	}

	public static function AVE($print_rate,$cont_on)
	{
		if($cont_on==0){
			$rate_cost = $print_rate;
		}else{
			if($nextstory = Story::model()->findByPk($cont_on)){
				$rate_cost = $print_rate+$nextstory->AVE;
			}else{
				$rate_cost = $print_rate;
			}
		}
		if($rate_cost==0){
			$rate_cost = 0;
		}else{
			$rate_cost = intval(trim($rate_cost, "'"));
		}
		
		return $rate_cost;
	}

	public static function StoryColumn($Story_ID)
	{
		// This is a constant, should not change, ever
		$totalcolumncentimeter = 198;
		$Story_ID = $Story_ID;
		$sql = "SELECT * FROM story_highlight_coods WHERE story_id = $Story_ID";
		if($coordinates = StoryHighlightCoods::model()->findBySql($sql)){
			$ratio = $coordinates->croppedratio;
			$colcm = $ratio*$totalcolumncentimeter;
		}else{
			$colcm = '-';
		}
		return $colcm;
	}

	public static function Continues($cont_on,$cont_from)
	{
		$continues = '';
		if($cont_on!=0 && $cont_from==0) 
		{ 
			$cont_on = $cont_on;
			$sql_cont="SELECT story_id,uniqueID, StoryPage from story where Story_ID='$cont_on'";
			if($cont = Story::model()->findBySql($sql_cont)){
				$uniqueID = $cont->uniqueID;
				$storyid = $cont->Story_ID;
				$printplayer = Yii::app()->params['printplayer'];
				$link = $printplayer.'storyid='.$cont_on.'&encryptid='.$uniqueID;
				$continues = '<a href="'.$link.'" style="color:#000;text-decoration:underline;">Continues on Page '.$cont->StoryPage.'</a>';
			}
		}

		if($cont_on!=0 && $cont_from!=0) 
		{ 
			$cont_on = $cont_on;
			$sql_cont="SELECT story_id,uniqueID, StoryPage from story where Story_ID='$cont_on'";
			if($cont = Story::model()->findBySql($sql_cont)){
				$uniqueID = $cont->uniqueID;
				$storyid = $cont->Story_ID;
				$printplayer = Yii::app()->params['printplayer'];
				$link = $printplayer.'storyid='.$cont_on.'&encryptid='.$uniqueID;
				$continues = '<a href="'.$link.'" style="color:#000;text-decoration:underline;">Continues on Page '.$cont->StoryPage.'</a>';
			}
		}

		if($cont_from!=0 && $cont_on==0){ 
			$cont_from = $cont_from;
			$sql_from="SELECT story_id,uniqueID, StoryPage from story where Story_ID='$cont_from'";
			if($from = Story::model()->findBySql($sql_from)){
				$uniqueID = $from->uniqueID;
				$storyid = $from->Story_ID;
				$printplayer = Yii::app()->params['printplayer'];
				$link = $printplayer.'storyid='.$cont_from.'&encryptid='.$uniqueID;
				$continues = '<a href="'.$link.'" style="color:#000;text-decoration:underline;">From Page '.$from->StoryPage.'</a>';
			}
		}
		return $continues;
	}

	public static function Picture($picture){
		if($picture=='color' OR $picture==1){
			return 'Color';
		}elseif($picture=='black_white' OR $picture==2){
			return 'B/W';
		}elseif($picture=='none'  OR $picture==0){
			return 'None';
		}else{
			return 'None';
		}
	}

	public static function PublicationType($Media_House_ID){
		if($newspapertype=NewspaperTypeAssignment::model()->find('Media_House_ID=:a', array(':a'=>$Media_House_ID))){
			return NewspaperType::model()->find('auto_id=:a', array(':a'=>$newspapertype->newspaper_type_id))->newspaper_type;
		}else{
			return 'Unknown';
		}
	}


	public function PrintTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th>
		</thead>';
	}

	public static function AgencyPrintTableHead(){
		$country = Yii::app()->user->country_id;
		if($currency = Country::model()->find('country_id=:a', array(':a'=>$country))){
			$currency = $currency->currency;
		}else{
			$currency = 'KES';
		}
		return '<div class="widget-body">
		<div>
		<table id="dt_basic" class="table table-striped table-bordered table-hover">
		<thead>
		<th style="width:11%;">DATE</th><th>PUBLICATION</th><th>JOURNALIST</th><th>HEADLINE/SUBJECT</th><th>PAGE</th><th>PUBLICATION TYPE</th><th>PICTURE</th><th>EFFECT</th><th style="text-align:right;">AVE('.$currency.')</th><th style="text-align:right;">PRV('.$currency.')</th>
		</thead>';
	}
	public static function PrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$cont,$StoryColum,$uniqueID){
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ave).'</td>
		</tr>';
	}
	public static function AgencyPrintTableBody($date,$storyid,$pub,$journo,$head,$page,$pubtype,$pic,$effect,$ave,$cont,$StoryColum,$uniqueID){
		// Obtain the Agency ID from Session
		$printplayer = Yii::app()->params['printplayer'];
		$link = $printplayer.'storyid='.$storyid.'&encryptid='.$uniqueID;
		$agency_id = Yii::app()->user->company_id;
		$sql_agency_pr="SELECT agency_pr_rate  from agency where agency_id=$agency_id";
		if($agency_pr_rate = Agency::model()->findBySql($sql_agency_pr)){
			$agency_pr_rate = $agency_pr_rate->agency_pr_rate;
		}else{
			$agency_pr_rate = 3;
		}
		return '<tr>
		<td><a href="'.$link.'" target="_blank">'.date('d-M-Y', strtotime($date)).'</a></td>
		<td>'.$pub.'</td>
		<td>'.$journo.'</td>
		<td><a href="'.$link.'" target="_blank">'.$head.'</a><br><font size="1">'.$cont.'</font></td>
		<td>'.$page.'</td>
		<td>'.$pubtype.'</td>
		<td>'.$pic.'</td>
		<td>'.$effect.'</td>
		<td style="text-align:right;">'.number_format($ave).'</td>
		<td style="text-align:right;">'.number_format($ave*$agency_pr_rate).'</td>
		</tr>';
	}
	public static function PrintTableEnd(){
		return '</table></div></div>';
	}
}