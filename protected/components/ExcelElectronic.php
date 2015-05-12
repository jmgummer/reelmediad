<?php

class ExcelElectronic
{
	public static function ArrayGenerator($array,$client){
		$tv_array=array();
		$radio_array = array();
		$tvarraycount = 0;
		$radioarraycount = 0;
		foreach ($array as $key) {
			/* If Radio Data, Add to Radio Array */
			if($key->Media_ID=='mr01'){

				$link 			= 'http://www.reelforge.com/reelmediad/video/'.$key->Story_ID;
				$date 			= $key->StoryDate;
				$publication 	= $key->Publication;
				$journalist 	= $key->journalist;
				$title 			= $key->Title;
				$time 			= $key->FormatedTime;
				$duration 		= $key->FormatedDuration;
				$category 		= Story::ClientIndustryCategory($key->Story_ID,$client);
				$tonality 		= Story::ClientTonality($key->Story_ID,$client);
				$ave 			= Common::ExcelNumberFormat($key->AVE);

				$radio_array[$radioarraycount]['link']=$link;
				$radio_array[$radioarraycount]['date']=$date;
				$radio_array[$radioarraycount]['publication']=$publication;
				$radio_array[$radioarraycount]['journalist']=$journalist;
				$radio_array[$radioarraycount]['title']=$title;
				$radio_array[$radioarraycount]['time']=$time;
				$radio_array[$radioarraycount]['duration']=$duration;
				$radio_array[$radioarraycount]['category']=$category;
				$radio_array[$radioarraycount]['tonality']=$tonality;
				$radio_array[$radioarraycount]['ave']=$ave;

				$radioarraycount++;
			}
			/* If TV Data, Add to TV Array */
			else{
				$link 			= 'http://www.reelforge.com/reelmediad/video/'.$key->Story_ID;
				$date 			= $key->StoryDate;
				$publication 	= $key->Publication;
				$journalist 	= $key->journalist;
				$title 			= $key->Title;
				$time 			= $key->FormatedTime;
				$duration 		= $key->FormatedDuration;
				$category 		= Story::ClientIndustryCategory($key->Story_ID,$client);
				$tonality 		= Story::ClientTonality($key->Story_ID,$client);
				$ave 			= Common::ExcelNumberFormat($key->AVE);

				$tv_array[$tvarraycount]['link']=$link;
				$tv_array[$tvarraycount]['date']=$date;
				$tv_array[$tvarraycount]['publication']=$publication;
				$tv_array[$tvarraycount]['journalist']=$journalist;
				$tv_array[$tvarraycount]['title']=$title;
				$tv_array[$tvarraycount]['time']=$time;
				$tv_array[$tvarraycount]['duration']=$duration;
				$tv_array[$tvarraycount]['category']=$category;
				$tv_array[$tvarraycount]['tonality']=$tonality;
				$tv_array[$tvarraycount]['ave']=$ave;

				$tvarraycount++;
			}
		}
		$return_array['tvdata'] = $tv_array;
		$return_array['radiodata'] = $radio_array;
		return $return_array;
	}

	public static function AgencyArrayGenerator($array,$client,$agency_pr_rate){
		$tv_array=array();
		$radio_array = array();
		$tvarraycount = 0;
		$radioarraycount = 0;
		foreach ($array as $key) {
			/* If Radio Data, Add to Radio Array */
			if($key->Media_ID=='mr01'){

				$link 			= 'http://www.reelforge.com/reelmediad/video/'.$key->Story_ID;
				$date 			= date('d-M-Y', strtotime($key->StoryDate));
				$publication 	= $key->Publication;
				$journalist 	= $key->journalist;
				$title 			= $key->Title;
				$time 			= $key->FormatedTime;
				$duration 		= $key->FormatedDuration;
				$category 		= $key->StoryCategory;
				$tonality 		= Story::ClientTonality($key->Story_ID,$client);
				$ave 			= Story::AVEFormatted($key->AVE);
				$prv 			= Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$key->AVE));
				$industry 		= Story::ClientIndustryCategory($key->Story_ID,$client);
				$summary 		= $key->StorySummary;

				$radio_array[$radioarraycount]['link']=$link;
				$radio_array[$radioarraycount]['date']=$date;
				$radio_array[$radioarraycount]['publication']=$publication;
				$radio_array[$radioarraycount]['journalist']=$journalist;
				$radio_array[$radioarraycount]['title']=$title;
				$radio_array[$radioarraycount]['time']=$time;
				$radio_array[$radioarraycount]['duration']=$duration;
				$radio_array[$radioarraycount]['category']=$category;
				$radio_array[$radioarraycount]['tonality']=$tonality;
				$radio_array[$radioarraycount]['ave']=$ave;
				$radio_array[$radioarraycount]['prv']=$prv;
				$radio_array[$radioarraycount]['industry']=$industry;
				$radio_array[$radioarraycount]['summary']=$summary;

				$radioarraycount++;
			}
			/* If TV Data, Add to TV Array */
			else{
				$link 			= 'http://www.reelforge.com/reelmediad/video/'.$key->Story_ID;
				$date 			= date('d-M-Y', strtotime($key->StoryDate));
				$publication 	= $key->Publication;
				$journalist 	= $key->journalist;
				$title 			= $key->Title;
				$time 			= $key->FormatedTime;
				$duration 		= $key->FormatedDuration;
				$category 		= $key->StoryCategory;
				$tonality 		= Story::ClientTonality($key->Story_ID,$client);
				$ave 			= Story::AVEFormatted($key->AVE);
				$prv 			= Story::AVEFormatted($prv = Story::AgencyPRValue($agency_pr_rate,$key->AVE));
				$industry 		= Story::ClientIndustryCategory($key->Story_ID,$client);
				$summary 		= $key->StorySummary;

				$tv_array[$tvarraycount]['link']=$link;
				$tv_array[$tvarraycount]['date']=$date;
				$tv_array[$tvarraycount]['publication']=$publication;
				$tv_array[$tvarraycount]['journalist']=$journalist;
				$tv_array[$tvarraycount]['title']=$title;
				$tv_array[$tvarraycount]['time']=$time;
				$tv_array[$tvarraycount]['duration']=$duration;
				$tv_array[$tvarraycount]['category']=$category;
				$tv_array[$tvarraycount]['tonality']=$tonality;
				$tv_array[$tvarraycount]['ave']=$ave;
				$tv_array[$tvarraycount]['prv']=$prv;
				$tv_array[$tvarraycount]['industry']=$industry;
				$tv_array[$tvarraycount]['summary']=$summary;

				$tvarraycount++;
			}
		}
		$return_array['tvdata'] = $tv_array;
		$return_array['radiodata'] = $radio_array;
		return $return_array;
	}
}