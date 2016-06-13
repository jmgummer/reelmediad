<?php

/**
* CompileHTML Component Class
* This Class Is Used To Return HTML for Stories
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

class CompileHTML{

	/**
	*
	* @return  Return HTML Body
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

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