<?php

class JournalistStory extends CFormModel
{
	public $firstname;
	public $Media_House_List;
	public $Media_ID;
	public $industry_List;
	public $startdate;
	public $enddate;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('industry_List,startdate,enddate', 'required'),
			array('firstname,Media_House_List,industry_List,startdate,enddate,Media_ID', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'firstname'=>'firstname',
			'Media_House_List'=>'Media_House_List',
			'industry_List'	=>'industry_List',
			'startdate'	=>'startdate',
			'enddate'	=>'enddate',
		);
	}

	public function getStory($firstname){
		$sql = "SELECT * from story where story_id IN('SELECT story_id from journalist_story where journalist_id=$firstname') ";
		return CHtml::listData(story::model()->findAllBySql($sql),'Story_ID','Story');

	}

	
}
