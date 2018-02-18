<?php

/**
 * This is the model class for table "themes".
 *
 * The followings are the available columns in table 'themes':
 * @property integer $id
 * @property integer $company_id
 * @property string $theme_name
 * @property integer $creator_id
 * @property string $dateadded
 */
class Themes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'themes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, theme_name, creator_id', 'required'),
			array('company_id, creator_id', 'numerical', 'integerOnly'=>true),
			array('theme_name', 'length', 'max'=>255),
			array('dateadded', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, theme_name, creator_id, dateadded', 'safe', 'on'=>'search'),
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
			'company_id' => 'Company',
			'theme_name' => 'Theme Name',
			'creator_id' => 'Creator',
			'dateadded' => 'Dateadded',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('theme_name',$this->theme_name,true);
		$criteria->compare('creator_id',$this->creator_id);
		$criteria->compare('dateadded',$this->dateadded,true);

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
	 * @return Themes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getThemeName(){
		return $this->theme_name;
	}

	public function getDateAdded(){
		return $this->dateadded;
	}

	public function getKeywords(){
		$link = '<a href="'.Yii::app()->createUrl('companies/themekeys/'.$_GET['id'].'?theme='.$this->id).'" style="color:blue !important;">Keywords</a>';
		echo  $link;
	}

	public function getDelete(){
		$link = '<a href="'.Yii::app()->createUrl('companies/deletetheme/'.$_GET['id'].'?theme='.$this->id).'" style="color:red !important;">Delete</a>';
		echo  $link;
	}

	public function getActions(){
		$link = '<a href="#" onclick="event.preventDefault();ViewSubThemes('.$this->id.');" class="btn btn-xs btn-info">Sub Themes</a>
		<a href="#" onclick="event.preventDefault();ViewThemeKeys('.$this->id.');" class="btn btn-xs btn-primary">Keywords</a>
		<a href="#" onclick="event.preventDefault();DeleteTheme('.$this->id.');" class="btn btn-xs btn-danger">Delete</a>';
		echo  $link;
	}

	public function getCompanyList($companyid)
	{
		$sql = "SELECT * FROM themes WHERE company_id = $companyid ORDER BY theme_name";
		return CHtml::listData(Themes::model()->findAllBySql($sql),'id','theme_name');
	}
}
