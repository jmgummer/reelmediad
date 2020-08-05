<?php

/**
 * This is the model class for table "counties".
 *
 * The followings are the available columns in table 'counties':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $registered_voters
 * @property string $city
 * @property string $latitude
 * @property string $longitude
 * @property string $jsonfile
 */
class Counties extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'counties';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, registered_voters, city, latitude, longitude, jsonfile', 'required'),
			array('registered_voters', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('city, latitude, longitude, jsonfile', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, registered_voters, city, latitude, longitude, jsonfile', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'registered_voters' => 'Registered Voters',
			'city' => 'City',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'jsonfile' => 'Jsonfile',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('registered_voters',$this->registered_voters);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('jsonfile',$this->jsonfile,true);

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
	 * @return Counties the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function CountiesListNames()
	{
		return CHtml::listData(Counties::model()->findAll(),'name','name');
	}
}
