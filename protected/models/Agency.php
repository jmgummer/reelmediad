<?php

/**
 * This is the model class for table "agency".
 *
 * The followings are the available columns in table 'agency':
 * @property integer $agency_id
 * @property string $agency_name
 * @property integer $agency_pr_rate
 * @property string $agency_contact_person
 * @property string $agency_email
 * @property string $agency_tel
 * @property string $agency_box
 * @property string $agency_status
 * @property string $agency_issue
 * @property string $own_ratecard
 * @property string $consolidated_email
 * @property string $mail_schedule
 * @property string $backdate
 */
class Agency extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agency_name, agency_pr_rate, agency_contact_person, agency_email, agency_tel, agency_box, agency_status, agency_issue, own_ratecard, mail_schedule', 'required'),
			array('agency_pr_rate', 'numerical', 'integerOnly'=>true),
			array('agency_name, agency_contact_person, agency_email, agency_tel, agency_box', 'length', 'max'=>100),
			array('agency_status, agency_issue, own_ratecard, consolidated_email, mail_schedule', 'length', 'max'=>1),
			array('backdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('agency_id, agency_name, agency_pr_rate, agency_contact_person, agency_email, agency_tel, agency_box, agency_status, agency_issue, own_ratecard, consolidated_email, mail_schedule, backdate', 'safe', 'on'=>'search'),
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
			'agency_id' => 'Agency',
			'agency_name' => 'Agency Name',
			'agency_pr_rate' => 'Agency Pr Rate',
			'agency_contact_person' => 'Agency Contact Person',
			'agency_email' => 'Agency Email',
			'agency_tel' => 'Agency Tel',
			'agency_box' => 'Agency Box',
			'agency_status' => 'Agency Status',
			'agency_issue' => 'Agency Issue',
			'own_ratecard' => 'Own Ratecard',
			'consolidated_email' => 'Consolidated Email',
			'mail_schedule' => 'Mail Schedule',
			'backdate' => 'Backdate',
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

		$criteria->compare('agency_id',$this->agency_id);
		$criteria->compare('agency_name',$this->agency_name,true);
		$criteria->compare('agency_pr_rate',$this->agency_pr_rate);
		$criteria->compare('agency_contact_person',$this->agency_contact_person,true);
		$criteria->compare('agency_email',$this->agency_email,true);
		$criteria->compare('agency_tel',$this->agency_tel,true);
		$criteria->compare('agency_box',$this->agency_box,true);
		$criteria->compare('agency_status',$this->agency_status,true);
		$criteria->compare('agency_issue',$this->agency_issue,true);
		$criteria->compare('own_ratecard',$this->own_ratecard,true);
		$criteria->compare('consolidated_email',$this->consolidated_email,true);
		$criteria->compare('mail_schedule',$this->mail_schedule,true);
		$criteria->compare('backdate',$this->backdate,true);

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
	 * @return Agency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
