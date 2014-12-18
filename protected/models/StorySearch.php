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
	public $publications;
	public $company;


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
			array('search_text,country,storytype,storycategory,news_section,enddate, startdate,industry,create_pdf,create_sheet,industryreports, publications, company', 'safe'),
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
			'industryreports'=>'Report Type',
			'publications'=>'Publications',
			'company'=>'Company'
		);
	}

	public static function getPrintList($media_id)
	{
		return CHtml::listData(Mediahouse::model()->findAll('Media_ID=:a order by Media_House_List', array(':a'=>$media_id)),'Media_House_ID','Media_House_List');
	}

	public static function getElecList()
	{
		$sql = "SELECT * FROM mediahouse WHERE Media_ID!='mp01'";
		return CHtml::listData(Mediahouse::model()->findAllBySql($sql),'Media_House_ID','Media_House_List');
	}

	public static function AgencyCompanies($username){
		$sql="select distinct company_name, company.company_id from company, agency_user_client, agency_users, agency_client,industry_company  where agency_users.username='$username' and agency_users.agency_users_id=agency_user_client.agency_users_id and agency_user_client.company_id=company.company_id and agency_client.company_id=agency_user_client.company_id and industry_company.company_id = company.company_id and industry_company.Client =1 order by company_name asc";
		return CHtml::listData(Company::model()->findAllBySql($sql),'company_id','company_name');
	}
}
