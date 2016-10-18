<?php

/**
 * This is the model class for table "story_highlight_coods".
 *
 * The followings are the available columns in table 'story_highlight_coods':
 * @property integer $auto_id
 * @property integer $x1
 * @property integer $y1
 * @property integer $width
 * @property integer $height
 * @property integer $orig_img_area
 * @property string $croppedratio
 * @property integer $story_id
 * @property integer $link_id
 * @property string $file_name
 * @property string $file_path
 */
class StoryHighlightCoods extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'story_highlight_coods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('x1, y1, width, height, story_id, link_id, file_name, file_path', 'required'),
			array('x1, y1, width, height, orig_img_area, story_id, link_id', 'numerical', 'integerOnly'=>true),
			array('croppedratio', 'length', 'max'=>20),
			array('file_name', 'length', 'max'=>150),
			array('file_path', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('auto_id, x1, y1, width, height, orig_img_area, croppedratio, story_id, link_id, file_name, file_path', 'safe', 'on'=>'search'),
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
			'x1' => 'X1',
			'y1' => 'Y1',
			'width' => 'Width',
			'height' => 'Height',
			'orig_img_area' => 'Orig Img Area',
			'croppedratio' => 'Croppedratio',
			'story_id' => 'Story',
			'link_id' => 'Link',
			'file_name' => 'File Name',
			'file_path' => 'File Path',
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
		$criteria->compare('x1',$this->x1);
		$criteria->compare('y1',$this->y1);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('orig_img_area',$this->orig_img_area);
		$criteria->compare('croppedratio',$this->croppedratio,true);
		$criteria->compare('story_id',$this->story_id);
		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_path',$this->file_path,true);

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
	 * @return StoryHighlightCoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
