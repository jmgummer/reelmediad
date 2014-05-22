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


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('search_text', 'required'),
			array('country', 'numerical', 'integerOnly'=>true),
			array('create_sheet', 'numerical', 'integerOnly'=>true),
			array('create_pdf', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			// 'rememberMe'=>'Remember me next time',
			'searchtext'=>'Search Text',
			'startdate'=>'Beginning',
			'enddate'=>'Ending',
			'country'=>'Select Country(default Kenya)',
			'storytype'=>'Type of Story',
			'storycategory'=>'Category of Story',
			'create_pdf'=>'Create PDF Report',
			'create_sheet'=>'Create Spreadsheet'
		);
	}
}
