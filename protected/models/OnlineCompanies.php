<?php

/**
 * This is the model class for table "companies".
 *
 * The followings are the available columns in table 'companies':
 * @property integer $id
 * @property string $company_name
 * @property integer $reelmedia_id
 * @property integer $userstatus
 */
class OnlineCompanies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'companies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_name, userstatus', 'required'),
			array('reelmedia_id, userstatus', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_name, reelmedia_id, userstatus', 'safe', 'on'=>'search'),
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
			'company_name' => 'Company Name',
			'reelmedia_id' => 'Reelmedia',
			'userstatus' => 'Status',
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('reelmedia_id',$this->reelmedia_id);
		$criteria->compare('userstatus',$this->userstatus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db4;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Companies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCompanyName(){
		return $this->company_name;
	}

	public function getStatus(){
		if($this->userstatus==1){
			return 'Active';
		}else{
			return 'Disabled';
		}
	}

	public function getEdit(){
		$link = '<a href="'.Yii::app()->createUrl('companies/edit/'.$this->id).'">Edit</a>';
		echo  $link;
	}

	public function getThemes(){
		$link = '<a href="'.Yii::app()->createUrl('companies/themes/'.$this->id).'">Themes</a>';
		echo  $link;
	}

	public function getTonality(){
		$link = '<a href="'.Yii::app()->createUrl('companies/tonality/'.$this->id).'">Tonality</a>';
		echo  $link;
	}

	public function getAPIS(){
		$link = '<a href="'.Yii::app()->createUrl('companies/apis/'.$this->id).'">API\'s</a>';
		echo  $link;
	}

	public function getKeywords(){
		$link = '<a href="'.Yii::app()->createUrl('companies/keywords/'.$this->id).'">Keywords</a>';
		echo  $link;
	}
	
	public function getDisable(){
		$link = '<a href="'.Yii::app()->createUrl('companies/disable/'.$this->id).'">Disable</a>';
		echo  $link;
	}

	public function getIgnore(){
		$link = '<a href="'.Yii::app()->createUrl('companies/ignore/'.$this->id).'">Ignore</a>';
		echo  $link;
	}

	public function getActions(){
		$link = '<div class="btn-group">
		<button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Action <span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
		<li><a href="'.Yii::app()->createUrl('admin/editcompany/'.$this->id).'">Edit</a></li>
		<li><a href="'.Yii::app()->createUrl('admin/deletecompany/'.$this->id).'">Delete</a></li>
		</ul>
		</div>';
		echo  $link;
	}
}
