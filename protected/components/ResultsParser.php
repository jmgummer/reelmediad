<?php

class ResultsParser{
	public function CreateDataTable($mentionsarray){
		$package = $this->TableHeader();
		$package.= $this->TableRows($mentionsarray);
		$package.= "</table>";
		return $package;
	}

	public function TableHeader(){
		$package = '<table id="dt_basic" class="table table-striped table-bordered table-hover">';
		$package.= "<tr><td><strong>Title</strong></td><td style='width:100px !important;'><strong>Date</strong></td><td><strong>Tonality</strong></td>
		<td><strong>Domain</strong></td><td><strong>Authors</strong></td><td><strong>OTS</strong></td><td><strong>Themes</strong></td><td><strong>Keywords</strong></td></tr>";
		return $package;
	}

	public function TableRows($data){
		$package = "";
		$rowcount =1;
		foreach ($data as $keyvalue) {
			$id = $keyvalue->id;
			$Date = $keyvalue->Date;
			$Tonality = $keyvalue->Tonality;
			$Title = $keyvalue->Title;
			$Link = $keyvalue->Link;
			$Domain = $keyvalue->Domain;
			$Authors = $keyvalue->Authors;
			$Themes = $keyvalue->Themes;
			$Keywords = $keyvalue->Keywords;
			$AVE = $keyvalue->AVE;
			$OTS = $keyvalue->OTS;
			$package.= "<tr id='$id'><td>$Link</td><td style='width:100px !important;'>$Date</td><td>$Tonality</td><td>$Domain</td><td>$Authors</td><td>$OTS</td>
				<td>$Themes</td><td>$Keywords</td></tr>";
			$rowcount++;
		}
		return $package;
	}
}