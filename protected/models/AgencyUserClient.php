<?php

/**
 * This is the model class for table "agency_user_client".
 *
 * The followings are the available columns in table 'agency_user_client':
 * @property integer $auto_id
 * @property integer $agency_users_id
 * @property integer $company_id
 * @property string $reelmedia_email
 * @property string $reelonline_email
 */
class AgencyUserClient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agency_user_client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agency_users_id, company_id', 'required'),
			array('agency_users_id, company_id', 'numerical', 'integerOnly'=>true),
			array('reelmedia_email, reelonline_email', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('auto_id, agency_users_id, company_id, reelmedia_email, reelonline_email', 'safe', 'on'=>'search'),
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
			'agency_users_id' => 'Agency Users',
			'company_id' => 'Company',
			'reelmedia_email' => 'Reelmedia Email',
			'reelonline_email' => 'Reelonline Email',
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

		$criteria->compare('auto_id',$this->auto_id);
		$criteria->compare('agency_users_id',$this->agency_users_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('reelmedia_email',$this->reelmedia_email,true);
		$criteria->compare('reelonline_email',$this->reelonline_email,true);

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
	 * @return AgencyUserClient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
