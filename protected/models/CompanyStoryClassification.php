<?php

/**
 * This is the model class for table "company_story_classification".
 *
 * The followings are the available columns in table 'company_story_classification':
 * @property integer $classification_id
 * @property integer $classification_order
 * @property integer $company_id
 * @property string $classification_name
 */
class CompanyStoryClassification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company_story_classification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classification_order, company_id, classification_name', 'required'),
			array('classification_order, company_id', 'numerical', 'integerOnly'=>true),
			array('classification_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('classification_id, classification_order, company_id, classification_name', 'safe', 'on'=>'search'),
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
			'classification_id' => 'Classification',
			'classification_order' => 'Classification Order',
			'company_id' => 'Company',
			'classification_name' => 'Classification Name',
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

		$criteria->compare('classification_id',$this->classification_id);
		$criteria->compare('classification_order',$this->classification_order);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('classification_name',$this->classification_name,true);

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
	 * @return CompanyStoryClassification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getClassificationList()
	{
		$clientid = Yii::app()->user->company_id;
		$sql = "SELECT * FROM company_story_classification WHERE company_id = $clientid ORDER BY classification_order";
		return CHtml::listData(CompanyStoryClassification::model()->findAllBySql($sql),'classification_id','classification_name');
	}
}
