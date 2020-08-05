<?php

/**
 * This is the model class for table "story".
 *
 * The followings are the available columns in table 'story':
 * @property integer $Story_ID
 * @property integer $link_id
 * @property string $Industry_ID
 * @property string $Client_ID
 * @property string $Title
 * @property string $Image_ID
 * @property string $Category_ID
 * @property string $Sub_Categ_ID
 * @property string $Media_ID
 * @property string $Media_House_ID
 * @property string $StoryDate
 * @property string $StoryTime
 * @property string $StoryDuration
 * @property string $Story
 * @property string $Elec_Clip_ID
 * @property string $StoryPage
 * @property integer $headline_flag
 * @property integer $analysis_id
 * @property integer $footage
 * @property string $picture
 * @property integer $subheadings
 * @property string $uniqueID
 * @property integer $words
 * @property integer $visible
 * @property string $editor
 * @property string $editor1
 * @property string $editor2
 * @property integer $election
 * @property integer $program_id
 * @property string $input_time_1
 * @property integer $entrytime1
 * @property integer $entrytime2
 * @property integer $entrytime3
 * @property string $Positioning
 * @property string $journalist
 * @property string $photo_journalist
 * @property integer $ave
 * @property integer $is_repeat
 * @property string $Is_Advert
 * @property string $col
 * @property integer $centimeter
 * @property string $pic1
 * @property string $file
 * @property string $page_no
 * @property string $file_path
 * @property integer $step1
 * @property integer $step2
 * @property integer $step3
 * @property string $mentioned
 * @property integer $cont_on
 * @property integer $cont_from
 * @property string $csr
 * @property string $storyEnteredTime
 * @property integer $print_rate
 * @property string $public_url
 * @property integer $file_available
 */
class JournalistStory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'story';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link_id, Title, uniqueID, editor, editor1, editor2, input_time_1, entrytime1, entrytime2, entrytime3, journalist, photo_journalist, centimeter, pic1, file, page_no, file_path, mentioned, cont_on, cont_from', 'required'),
			array('link_id, headline_flag, analysis_id, footage, subheadings, words, visible, election, program_id, entrytime1, entrytime2, entrytime3, ave, is_repeat, centimeter, step1, step2, step3, cont_on, cont_from, print_rate, file_available', 'numerical', 'integerOnly'=>true),
			array('Industry_ID, Client_ID, Category_ID, Media_House_ID, StoryDuration, Elec_Clip_ID, StoryPage', 'length', 'max'=>8),
			array('Image_ID', 'length', 'max'=>6),
			array('Sub_Categ_ID, Positioning, col', 'length', 'max'=>50),
			array('Media_ID, Is_Advert', 'length', 'max'=>10),
			array('picture, uniqueID', 'length', 'max'=>30),
			array('editor, editor1, editor2', 'length', 'max'=>80),
			array('journalist, photo_journalist, file_path', 'length', 'max'=>100),
			array('pic1, file', 'length', 'max'=>500),
			array('page_no', 'length', 'max'=>5),
			array('csr', 'length', 'max'=>1),
			array('StoryDate, StoryTime, Story, storyEnteredTime, public_url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Story_ID, link_id, Industry_ID, Client_ID, Title, Image_ID, Category_ID, Sub_Categ_ID, Media_ID, Media_House_ID, StoryDate, StoryTime, StoryDuration, Story, Elec_Clip_ID, StoryPage, headline_flag, analysis_id, footage, picture, subheadings, uniqueID, words, visible, editor, editor1, editor2, election, program_id, input_time_1, entrytime1, entrytime2, entrytime3, Positioning, journalist, photo_journalist, ave, is_repeat, Is_Advert, col, centimeter, pic1, file, page_no, file_path, step1, step2, step3, mentioned, cont_on, cont_from, csr, storyEnteredTime, print_rate, public_url, file_available', 'safe', 'on'=>'search'),
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
			'Story_ID' => 'Story',
			'link_id' => 'Link',
			'Industry_ID' => 'Industry',
			'Client_ID' => 'Client',
			'Title' => 'Title',
			'Image_ID' => 'Image',
			'Category_ID' => 'Category',
			'Sub_Categ_ID' => 'Sub Categ',
			'Media_ID' => 'Media',
			'Media_House_ID' => 'Media House',
			'StoryDate' => 'Story Date',
			'StoryTime' => 'Story Time',
			'StoryDuration' => 'Story Duration',
			'Story' => 'Story',
			'Elec_Clip_ID' => 'Elec Clip',
			'StoryPage' => 'Story Page',
			'headline_flag' => 'Headline Flag',
			'analysis_id' => 'Analysis',
			'footage' => 'Footage',
			'picture' => 'Picture',
			'subheadings' => 'Subheadings',
			'uniqueID' => 'Unique',
			'words' => 'Words',
			'visible' => 'Visible',
			'editor' => 'Editor',
			'editor1' => 'Editor1',
			'editor2' => 'Editor2',
			'election' => 'Election',
			'program_id' => 'Program',
			'input_time_1' => 'Input Time 1',
			'entrytime1' => 'Entrytime1',
			'entrytime2' => 'Entrytime2',
			'entrytime3' => 'Entrytime3',
			'Positioning' => 'Positioning',
			'journalist' => 'Journalist',
			'photo_journalist' => 'Photo Journalist',
			'ave' => 'Ave',
			'is_repeat' => 'Is Repeat',
			'Is_Advert' => 'Is Advert',
			'col' => 'Col',
			'centimeter' => 'Centimeter',
			'pic1' => 'Pic1',
			'file' => 'File',
			'page_no' => 'Page No',
			'file_path' => 'File Path',
			'step1' => 'Step1',
			'step2' => 'Step2',
			'step3' => 'Step3',
			'mentioned' => 'Mentioned',
			'cont_on' => 'Cont On',
			'cont_from' => 'Cont From',
			'csr' => 'Csr',
			'storyEnteredTime' => 'Story Entered Time',
			'print_rate' => 'Print Rate',
			'public_url' => 'Public Url',
			'file_available' => 'File Available',
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

		$criteria->compare('Story_ID',$this->Story_ID);
		$criteria->compare('link_id',$this->link_id);
		$criteria->compare('Industry_ID',$this->Industry_ID,true);
		$criteria->compare('Client_ID',$this->Client_ID,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Image_ID',$this->Image_ID,true);
		$criteria->compare('Category_ID',$this->Category_ID,true);
		$criteria->compare('Sub_Categ_ID',$this->Sub_Categ_ID,true);
		$criteria->compare('Media_ID',$this->Media_ID,true);
		$criteria->compare('Media_House_ID',$this->Media_House_ID,true);
		$criteria->compare('StoryDate',$this->StoryDate,true);
		$criteria->compare('StoryTime',$this->StoryTime,true);
		$criteria->compare('StoryDuration',$this->StoryDuration,true);
		$criteria->compare('Story',$this->Story,true);
		$criteria->compare('Elec_Clip_ID',$this->Elec_Clip_ID,true);
		$criteria->compare('StoryPage',$this->StoryPage,true);
		$criteria->compare('headline_flag',$this->headline_flag);
		$criteria->compare('analysis_id',$this->analysis_id);
		$criteria->compare('footage',$this->footage);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('subheadings',$this->subheadings);
		$criteria->compare('uniqueID',$this->uniqueID,true);
		$criteria->compare('words',$this->words);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('editor',$this->editor,true);
		$criteria->compare('editor1',$this->editor1,true);
		$criteria->compare('editor2',$this->editor2,true);
		$criteria->compare('election',$this->election);
		$criteria->compare('program_id',$this->program_id);
		$criteria->compare('input_time_1',$this->input_time_1,true);
		$criteria->compare('entrytime1',$this->entrytime1);
		$criteria->compare('entrytime2',$this->entrytime2);
		$criteria->compare('entrytime3',$this->entrytime3);
		$criteria->compare('Positioning',$this->Positioning,true);
		$criteria->compare('journalist',$this->journalist,true);
		$criteria->compare('photo_journalist',$this->photo_journalist,true);
		$criteria->compare('ave',$this->ave);
		$criteria->compare('is_repeat',$this->is_repeat);
		$criteria->compare('Is_Advert',$this->Is_Advert,true);
		$criteria->compare('col',$this->col,true);
		$criteria->compare('centimeter',$this->centimeter);
		$criteria->compare('pic1',$this->pic1,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('page_no',$this->page_no,true);
		$criteria->compare('file_path',$this->file_path,true);
		$criteria->compare('step1',$this->step1);
		$criteria->compare('step2',$this->step2);
		$criteria->compare('step3',$this->step3);
		$criteria->compare('mentioned',$this->mentioned,true);
		$criteria->compare('cont_on',$this->cont_on);
		$criteria->compare('cont_from',$this->cont_from);
		$criteria->compare('csr',$this->csr,true);
		$criteria->compare('storyEnteredTime',$this->storyEnteredTime,true);
		$criteria->compare('print_rate',$this->print_rate);
		$criteria->compare('public_url',$this->public_url,true);
		$criteria->compare('file_available',$this->file_available);

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
	 * @return JournalistStory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
