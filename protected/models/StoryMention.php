<?php

/**
 * This is the model class for table "story_mention".
 * @package     Reelmedia
 * @subpackage  Models
 * @category    Reelforge Client Systems
 * @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
 * @author      Steve Ouma Oyugi - Reelforge Developers Team
 * @version 	   v.1.0
 * @since       July 2008
 *
 * The followings are the available columns in table 'story_mention':
 * @property integer $auto_id
 * @property integer $story_id
 * @property integer $client_id
 */
class StoryMention extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoryMention the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'story_mention';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('story_id, client_id', 'required'),
			array('story_id, client_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('auto_id, story_id, client_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'auto_id' => 'Auto',
			'story_id' => 'Story',
			'client_id' => 'Client',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('auto_id',$this->auto_id);
		$criteria->compare('story_id',$this->story_id);
		$criteria->compare('client_id',$this->client_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getClient()
	{
		if($this->client_id!=0){
			return $client = Company::model()->find('company_id=:a', array(':a'=>$this->client_id))->company_name;
		}
	}
}