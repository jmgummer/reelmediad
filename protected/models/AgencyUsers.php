<?php

/**
 * This is the model class for table "agency_users".
 * @package     Reelmedia
 * @subpackage  Models
 * @category    Reelforge Client Systems
 * @license     Licensed to Reelforge, Copying and Modification without prior permission is not allowed and can result in legal proceedings
 * @author      Steve Ouma Oyugi - Reelforge Developers Team
 * @version 	   v.1.0
 * @since       July 2008
 *
 * The followings are the available columns in table 'agency_users':
 * @property integer $agency_users_id
 * @property string $username
 * @property string $surname
 * @property string $firstname
 * @property string $password
 * @property integer $agency_id
 * @property string $email
 * @property string $user_status
 * @property string $user_level
 * @property string $email_alert
 * @property integer $intranet_id
 */
class AgencyUsers extends CActiveRecord
{
	/* Included A Few Extra For Changing Passwords */
	public $dummypass;
	public $dummypass2;
	public $dummypass3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agency_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('username, surname, firstname, password, agency_id, email, user_status, user_level, email_alert, intranet_id', 'required'),
			array('agency_id, intranet_id', 'numerical', 'integerOnly'=>true),
			array('username, surname, firstname, password, email', 'length', 'max'=>50),
			array('user_status, user_level, email_alert', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('agency_users_id, username, surname, firstname, password, agency_id, email, user_status, user_level, email_alert, intranet_id', 'safe', 'on'=>'search'),
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
			'agency_users_id' => 'Agency Users',
			'username' => 'Username',
			'surname' => 'Surname',
			'firstname' => 'Firstname',
			'password' => 'Password',
			'agency_id' => 'Agency',
			'email' => 'Email',
			'user_status' => 'User Status',
			'user_level' => 'User Level',
			'email_alert' => 'Email Alert',
			'intranet_id' => 'Intranet',
			'dummypass'=>'Current Password',
			'dummypass2'=>'New Password',
			'dummypass3'=>'Confirm Password'
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

		$criteria->compare('agency_users_id',$this->agency_users_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('agency_id',$this->agency_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('user_status',$this->user_status,true);
		$criteria->compare('user_level',$this->user_level,true);
		$criteria->compare('email_alert',$this->email_alert,true);
		$criteria->compare('intranet_id',$this->intranet_id);

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
	 * @return AgencyUsers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getUserName()
	{
		return ucfirst($this->firstname).' '.ucfirst($this->surname);
	}

	public function getAgencyName()
	{
		if($agency = Agency::model()->find('agency_id=:a', array(':a'=>$this->agency_id))){
			return $agency->agency_name;
		}else{
			return 'Agency Name Unset';
		}
	}

	public function getAlerts()
	{
		if($this->email_alert==1){
			return 'Yes';
		}else{
			return 'No';
		}
	}

	public function getLevel()
	{
		if($this->user_level==1){
			return 'Admin';
		}else{
			return 'User';
		}
	}

	public function getStatus()
	{
		if($this->user_status==1){
			return 'Active';
		}else{
			return 'Inactive';
		}
	}
}
