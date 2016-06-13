<?php

/**
 * This is the model class for table "mediahouse_pullouts".
 * @package     Reelmedia
 * @subpackage  Models
 * @category    Reelforge Client Systems
 * @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
 * @author      Steve Ouma Oyugi - Reelforge Developers Team
 * @version 	   v.1.0
 * @since       July 2008
 *
 * The followings are the available columns in table 'mediahouse_pullouts':
 * @property integer $pullout_id
 * @property string $pullout_name
 * @property integer $media_house_id
 * @property string $pullout_code
 */
class MediahousePullouts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mediahouse_pullouts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pullout_code', 'required'),
			array('media_house_id', 'numerical', 'integerOnly'=>true),
			array('pullout_name', 'length', 'max'=>100),
			array('pullout_code', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pullout_id, pullout_name, media_house_id, pullout_code', 'safe', 'on'=>'search'),
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
			'pullout_id' => 'Pullout',
			'pullout_name' => 'Pullout Name',
			'media_house_id' => 'Media House',
			'pullout_code' => 'Pullout Code',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pullout_id',$this->pullout_id);
		$criteria->compare('pullout_name',$this->pullout_name,true);
		$criteria->compare('media_house_id',$this->media_house_id);
		$criteria->compare('pullout_code',$this->pullout_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MediahousePullouts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
