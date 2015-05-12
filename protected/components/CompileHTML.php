<?php

class CompileHTML{
	public static function Compiler($client,$startdate,$enddate,$search,$industries,$cat_identifier,$type_identifier)
	{
		$country = Yii::app()->user->country_id;
		$company_words = Company::model()->find('company_id=:a order by keywords', array(':a'=>$client));
		$backdate = $company_words->backdate;
		$html = '';
		$html .=  '<img src="http://reelforge.com/reelmediad/images/reelmedia_header.jpg" width="100%" />';
		if($type_identifier==1){
			if($cat_identifier==1){
				$html .=  '<table><tr><td>My Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>My Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>Industry Print Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==2){
				$html .=  '<table><tr><td>My Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>My Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==3){
				$html .=  '<table><tr><td>Industry Print Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
		}
		if($type_identifier==2){
			if($cat_identifier==1){
				$html .=  '<table><tr><td>My Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==2){
				$html .=  '<table><tr><td>My Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==3){
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
		}
		if($type_identifier==3){
			if($cat_identifier==1){
				$html .=  '<table><tr><td>My Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==2){
				$html .=  '<table><tr><td>My Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetElectronicStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
			}
			if($cat_identifier==3){
				$html .=  '<table><tr><td>Industry Electronic Stories</td></tr></table><br>';
				$html .=  HtmlStories::GetClientElectronicIndustryStory($client,$startdate,$enddate,$search,$backdate,$country,$industries);
				$html .=  '<br>';
				
			}
		}
		$crunched = HtmlStories::FileBody($html);
		return $crunched;
	}
}