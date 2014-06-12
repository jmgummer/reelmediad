<?php

/**
 * StorySearch class.
 * StorySearch is the data structure for keeping
 * Story Search form data. It is used by the 'search' action of 'HomeController'.
 */
class StorySearch extends CFormModel
{
	public $search_text;
	public $startdate;
	public $enddate;
	public $country;
	public $storytype;
	public $storycategory;
	public $news_section;
	public $create_sheet;
	public $create_pdf;
	public $industry;
	public $industryreports;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('enddate,startdate', 'required'),
			array('country,create_sheet,create_pdf', 'numerical', 'integerOnly'=>true),
			array('search_text,country,storytype,storycategory,news_section,enddate, startdate,industry,create_pdf,create_sheet,industryreports', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'searchtext'=>'Search Text',
			'startdate'=>'Beginning',
			'enddate'=>'Ending',
			'country'=>'Select Country(default Kenya)',
			'storytype'=>'Type of Story',
			'storycategory'=>'Category of Story',
			'create_pdf'=>'Create PDF Report',
			'create_sheet'=>'Create Spreadsheet',
			'industryreports'=>'Report Type'
		);
	}
}
