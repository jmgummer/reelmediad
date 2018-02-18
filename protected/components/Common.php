<?php

/**
* Common Component Class
* This Class Is Used To Handle Regular/Common Tasks
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

class Common{

	/**
	*
	* @return  Return A clean integer values
	* @throws  InvalidArgumentException
	*
	* @since   2008
	* @author  Steve Ouma Oyugi - Reelforge Development Team
	* @edit    2014-07-08 
	*	DO NOT ALTER UNLESS YOU UNDERSTAND WHAT YOU ARE DOING
	*/

	public static function ExcelNumberFormat($value){
		$formatted = $value;
		$cleaned = str_replace(",", "", $formatted);
		return $cleaned;
	}
	
	public static function PrintStoriesTempTable()
    {
        /* Create Temp table */
        $temp_table	= "rm_stories_temp_" . date("Ymdhis");
        $temp_sql="CREATE TEMPORARY TABLE `$temp_table` (
		`id` INT  AUTO_INCREMENT PRIMARY KEY ,
		`Story_ID` VARCHAR(255),
		`StoryDate` VARCHAR(255),
		`Title` VARCHAR(255),
		`Story` VARCHAR(255),
		`StoryPage` VARCHAR(255),
		`cont_on` VARCHAR(255),
		`cont_from` VARCHAR(255),
		`editor` VARCHAR(255),
		`Media_House_ID` VARCHAR(255),
		`journalist` VARCHAR(255),
		`col` VARCHAR(255),
		`centimeter` VARCHAR(255),
		`StoryDuration` VARCHAR(255),
		`StoryTime` VARCHAR(255),
		`picture` VARCHAR(255),
		`Media_ID` VARCHAR(255),
		`print_rate` VARCHAR(255),
		`uniqueID` VARCHAR(255)
		) ENGINE = MYISAM";
        Yii::app()->db2->createCommand($temp_sql)->execute();
        return $temp_table;
    }
}