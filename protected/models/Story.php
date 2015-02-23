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
 * @property integer $col
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
 */
class Story extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Story the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

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
			array('link_id, Title, uniqueID, editor, editor1, editor2, input_time_1, entrytime1, entrytime2, entrytime3, journalist, photo_journalist, col, centimeter, pic1, file, page_no, file_path, mentioned, cont_on, cont_from', 'required'),
			array('link_id, headline_flag, analysis_id, footage, subheadings, words, visible, election, program_id, entrytime1, entrytime2, entrytime3, ave, is_repeat, col, centimeter, step1, step2, step3, cont_on, cont_from', 'numerical', 'integerOnly'=>true),
			array('Industry_ID, Client_ID, Category_ID, Media_House_ID, StoryDuration, Elec_Clip_ID, StoryPage', 'length', 'max'=>8),
			array('Image_ID', 'length', 'max'=>6),
			array('Sub_Categ_ID, Positioning', 'length', 'max'=>50),
			array('Media_ID, Is_Advert', 'length', 'max'=>10),
			array('picture, uniqueID', 'length', 'max'=>30),
			array('editor, editor1, editor2', 'length', 'max'=>80),
			array('journalist, photo_journalist, file_path', 'length', 'max'=>100),
			array('pic1, file', 'length', 'max'=>500),
			array('page_no', 'length', 'max'=>5),
			array('csr', 'length', 'max'=>1),
			array('StoryDate, StoryTime, Story, storyEnteredTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('Story_ID, link_id, Industry_ID, Client_ID, Title, Image_ID, Category_ID, Sub_Categ_ID, Media_ID, Media_House_ID, StoryDate, StoryTime, StoryDuration, Story, Elec_Clip_ID, StoryPage, headline_flag, analysis_id, footage, picture, subheadings, uniqueID, words, visible, editor, editor1, editor2, election, program_id, input_time_1, entrytime1, entrytime2, entrytime3, Positioning, journalist, photo_journalist, ave, is_repeat, Is_Advert, col, centimeter, pic1, file, page_no, file_path, step1, step2, step3, mentioned, cont_on, cont_from, csr, storyEnteredTime', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

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
		$criteria->compare('col',$this->col);
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPublication()
	{
		$StoryPage = $this->StoryPage;
		if($publication = Mediahouse::model()->find('Media_House_ID=:a', array(':a'=>$this->Media_House_ID))){
			if(is_numeric($StoryPage)){
				return $publication ->Media_House_List;
			}else{
				if($this->Media_ID!="mp01"){
					return $publication ->Media_House_List;
				}else{
					return $publication ->Media_House_List.' - '.$this->StoryPullout;
				}
			}
		}else{
			return 'Unknown';
		}
	}

	public function getPublicationType()
	{
	  if($newspapertype=NewspaperTypeAssignment::model()->find('Media_House_ID=:a', array(':a'=>$this->Media_House_ID))){
	    return NewspaperType::model()->find('auto_id=:a', array(':a'=>$newspapertype->newspaper_type_id))->newspaper_type;
	  }else{
	    return 'Unknown';
	  }
	}
	
	public function getFormatedTime()
	{
	  return date('H:i',strtotime($this->StoryTime));
	}
	
	public function getFormatedDuration()
	{
	  return gmdate("H:i:s", $this->StoryDuration);
	}
	
	public function getPicture()
	{
	  if($this->picture=='color'){
	    return 'Color';
	  }elseif($this->picture=='black_white'){
	    return 'B/W';
	  }elseif($this->picture=='none'){
	    return 'None';
	  }else{
	    return 'None';
	  }
	}

	public function getTonality()
	{
		if($tonality = MediamapAnalysis::model()->find('story_id=:a AND company_id=:b', array(':a'=>$this->Story_ID, ':b'=>Yii::app()->user->company_id))){
			if($tonality->tonality=='positive'){
			  return 'Positive';
			}elseif($tonality->tonality=='negative'){
			  return 'Negative';
			}elseif($tonality->tonality=='neutral'){
			  return 'Neutral';
			}else{
			  return 'N/A';
			}
		}else{
			return 'N/A';
		}
	}

	public static function ClientTonality($storyid,$company_id)
	{
		if($tonality = MediamapAnalysis::model()->find('story_id=:a AND company_id=:b', array(':a'=>$storyid, ':b'=>$company_id))){
			if($tonality->tonality=='positive'){
			  return 'Positive';
			}elseif($tonality->tonality=='negative'){
			  return 'Negative';
			}elseif($tonality->tonality=='neutral'){
			  return 'Neutral';
			}else{
			  return 'N/A';
			}
		}else{
			return 'N/A';
		}
	}
	
	public function getIndustryCategory()
	{
		$sql = 'SELECT Industry_List, story_id FROM story_industry inner join industry on story_industry.industry_id = industry.industry_id
		INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
		where story_id='.$this->Story_ID.' and company_id = '.Yii::app()->user->company_id;
		$catarray=array();
		if($categories = Industry::model()->findAllBySql($sql)){
			foreach($categories as $cats){
				$catarray[]=$cats->Industry_List;
			}
		}
		$imploded = implode(", ",$catarray);
		return $imploded;
    
	}

	public static function ClientIndustryCategory($storyid,$company_id)
	{
		$sql = 'SELECT Industry_List, story_id FROM story_industry inner join industry on story_industry.industry_id = industry.industry_id
		INNER JOIN industry_subs ON story_industry.industry_id = industry_subs.industry_id
		where story_id='.$storyid.' and company_id = '.$company_id;
		$catarray=array();
		if($categories = Industry::model()->findAllBySql($sql)){
			foreach($categories as $cats){
				$catarray[]=$cats->Industry_List;
			}
		}
		$imploded = implode(", ",$catarray);
		return $imploded;
	}

	public function getLink()
	{
		if($this->link_id!=' '){
			$linkid = $this->link_id;
			if($link = SphLinks::model()->find('link_id=:a', array(':a'=>$linkid))){
				return $this->GetSwf($this->file);
			}else{
				return '#';
			}
		}else{
			return '#';
		}
	}

	public static function GetSwf($link)
	{
		$output  = str_replace('.pdf', '.swf', $link);
		return strtolower($output);
	}

	public function getContinues()
	{
		if($this->cont_on!=0) 
		{ 
			$cont_on = $this->cont_on;
			$sql_cont="select story_id,uniqueID, StoryPage from story where Story_ID='$cont_on'";
			if($cont = Story::model()->findBySql($sql_cont)){
				$storyid = $cont->Story_ID;
				return $link = '<a href="'.Yii::app()->createUrl("swf/view").'/'.$cont_on.'" target="_blank">Continues on Page '.$cont->StoryPage.'</a>';
			}
		}

		if($this->cont_from!=0) 
		{ 
			$cont_from = $this->cont_from;
			$sql_from="select story_id,uniqueID, StoryPage from story where Story_ID='$cont_from'";
			if($from = Story::model()->findBySql($sql_from)){
				$storyid = $from->Story_ID;
				return $link = '<a href="'.Yii::app()->createUrl("swf/view").'/'.$cont_from.'" target="_blank">From Page '.$from->StoryPage.'</a>';
			}
		}
	}

	public function getClient()
	{
		if($this->Client_ID!=0){
			return $client = Company::model()->find('company_id=:a', array(':a'=>$this->Client_ID))->company_name;
		}
	}

	public function getPage()
	{
		if(!empty($this->StoryPage)){
			return ': Page '.$this ->StoryPage;
		}else{
			return '';
		}
	}

	public function getFStoryDate()
	{
		if(!empty($this->StoryDate)){
			return date('d-M-Y', strtotime($this->StoryDate));
		}else{
			return 'Not Set';
		}
	}

	public function getMediaType()
	{
		if(!empty($this->Media_ID)){
			if($this->Media_ID=='mt01'){
				return 'TV';
			}elseif($this->Media_ID=='mr01'){
				return 'Radio';
			}else{
				return 'Print';
			}
		}else{
			return 'Not Set';
		}
	}

	public function getAVE()
	{
		if(!empty($this->Media_House_ID)){
			$Media_House_ID = $this->Media_House_ID;
			$weekday = strtolower(date('D', strtotime($this->StoryDate)));
			$col = $this->col;
			$centimeter = $this->centimeter;
			$StoryDuration=$incantation_length=$this->StoryDuration;
			$StoryTime=$this->StoryTime;
			$this_rate=0;
			if($this->Media_ID=='mp01'){
				$picture = $this->picture;
				if($picture=='color'){
					$color_code = $weekday.'_c';
				}else{
					$color_code = $weekday.'_b';
				}
				if($rate = Ratecard::model()->find('Media_House_ID=:a AND color_code=:b', array(':a'=>$Media_House_ID,':b'=>$color_code))){
					$rate=$rate->rate;
					$rate_cost = $rate*$col*$centimeter;
				}else{
					$rate_cost = 0;
				}
			}else{
			  $sql_electronic_rate='SELECT rate,duration 
			  from forgedb.ratecard_base, reelmedia.anvil_match 
			  where ratecard_base.station_id=anvil_match.station_id and anvil_match.Media_House_ID='.$Media_House_ID.' 
			  and forgedb.ratecard_base.weekday="'.$weekday.'" and forgedb.ratecard_base.time_start<="'.$StoryTime.'" 
			  order by forgedb.ratecard_base.duration,  ratecard_base.date_start desc,ratecard_base.time_start desc, forgedb.ratecard_base.time_end asc limit 1';
			  $incantation_length=str_replace("sec","",$incantation_length);
			  $this_rate_det = RatecardBase::model()->findBySql($sql_electronic_rate);
			  if(isset($this_rate_det->rate) && isset($this_rate_det->duration)){
			    $this_rate = $this_rate_det->rate;
			    $this_duration = $this_rate_det->duration;
				if($rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1)==60){
					$rate_cost = 0;
				}else{
					$rate_cost = round(($incantation_length * $this_rate)/$this_duration,-1);
				}
			  }else{
			    $rate_cost = 0;
			  }
			  // $rate_cost = ($this_rate*$this_duration)/$incantation_length;
			  
			}
		}else{
			$rate_cost = 0;
		}
		
		return $rate_cost;
	}

	public function getCompanyMentions()
	{
		if($mentions = StoryMention::model()->findAll('story_id=:a', array(':a'=>$this->Story_ID))){
			$companies = '';
			foreach ($mentions as $key) {
				$companies.=$key->Client.' , ';
			}
			return $companies;
		}else{
			return ' ';
		}
	}

	public function getClassification()
	{

	}

	public static function AgencyPRValue($agency_pr_rate,$this_rate)
	{
		$this_agency_pr_rate=number_format( ($this_rate+0)*$agency_pr_rate,0);
		return $this_agency_pr_rate;
	}

	public function getStoryCategory()
	{
		$this_category_id = $this->Category_ID;
		$sql_category_name="select distinct Category_List from category where Category_ID='$this_category_id'";
		if($category_name=Category::model()->findBySql($sql_category_name)){
			return $category_name->Category_List;
		}else{
			return 'Uncategorized';
		}
	}

	public function getStoryPullout()
	{
		$Media_House_ID = $this->Media_House_ID;
		$StoryPage = $this->StoryPage;
		if(!is_numeric($StoryPage)){
			$letter= substr($StoryPage, 0,1); 
			$sql_po="select pullout_name from mediahouse,mediahouse_pullouts where mediahouse.Media_House_ID='$Media_House_ID' and mediahouse_pullouts.media_house_id=mediahouse.Media_House_ID and pullout_code = '$letter';";
			if($pullout = MediahousePullouts::model()->findBySql($sql_po)){
				$pullout = $pullout->pullout_name;
			}else{
				$pullout = 'Unknown Pullout';
			}
			return $pullout;
		}else{
			return $this->Publication;
		}

	}

	public static function StoryIndustry($storyid,$agency_client_co_id)
	{
		$sql_ind="select Industry_List from story_industry,industry, industry_company where story_industry.industry_id=industry. Industry_ID 
		and story_industry.story_id=$storyid and industry_company.company_id=$agency_client_co_id and industry_company.industry_id=story_industry.industry_id";
		if($industry_name=Industry::model()->findBySql($sql_ind)){
			return $industry_name->Industry_List;
		}else{
			return 'No Industry Set';
		}
	}

	public function getStorySummary()
	{
		return $this->Story;
	}

	public function getPhotoJournalist()
	{
		return $photo_journalist = ucwords(strtolower($this->photo_journalist));
	}

	public function getStoryColumn()
	{
		$colcm = 0;
		$cont_on=$this->cont_on;
		if($cont_on!=0) {
			$cont_col=Story::ColumnContinuation($this->Story_ID);
			$colcm+=$cont_col;
		}else{
			$colcm = $this->col*$this->centimeter;
		}
		return $colcm;
	}

	public static function ColumnContinuation($id) 
	{
		$my_continuation = 0;
		if(is_numeric($id)){
			$sql="select Media_House_ID,cont_on, cont_from, picture,col, centimeter , Media_ID from story where story_id=$id";
			if($ContStory = Story::model()->findBySql($sql)){
				$storyid = $ContStory->Story_ID;
				$col=$ContStory->col;
				$centimeter = $ContStory->centimeter;
				$colcm = $col*$centimeter;
				$cont_on=$ContStory->cont_on;

				if($cont_on!=0) {
					$my_continuation=Story::ColumnContinuation($storyid);
				}
				$colcm+=$my_continuation;
			}else{
				$colcm = 0;
			}
		}else{
			$colcm = 0;
		}
		return $colcm;
	}

	public function getContinuingAve()
	{
		$colcm = 0;
		$weekday = strtolower(date('D', strtotime($this->StoryDate)));
		$Media_House_ID = $this->Media_House_ID;
		$picture = $this->picture;
		$col = $this->col;
		$centimeter = $this->centimeter;

		if($picture=='color'){
			$color_code = $weekday.'_c';
		}else{
			$color_code = $weekday.'_b';
		}

		if($rate = Ratecard::model()->find('Media_House_ID=:a AND color_code=:b', array(':a'=>$Media_House_ID,':b'=>$color_code))){
			$rate=$rate->rate;
			$rate_cost = $rate*$col*$centimeter;
		}else{
			$rate_cost = 0;
		}
		$this_rate=$rate_cost;
		
		if($this->cont_on!=0) {
			$cont_rate=RateContinuation($cont_on);
			$this_rate+=$cont_rate;
		}
		return $this_rate;
	}

	public static function RateContinuation($id) 
	{
		$this_rate=0;
		$my_continuation = 0;
		$sql="select Media_House_ID,cont_on, cont_from, picture,col, centimeter , Media_ID from story where story_id=$id";
		if($ContStory = Story::model()->findBySql($sql)){
			$StoryDate=$ContStory->StoryDate;
			$Media_House_ID=$ContStory->Media_House_ID;
			$Media_ID =$ContStory->Media_ID;
			$picture=$ContStory->picture;
			$col=$ContStory->col;
			$centimeter=$ContStory->centimeter;

			$cont_on=$ContStory->cont_on;
			$cont_from=$ContStory->cont_from;	 

			$weekday = strtolower(date('D', strtotime($StoryDate)));

			if($picture=='color'){
				$color_code = $weekday.'_c';
			}else{
				$color_code = $weekday.'_b';
			}

			if($rate = Ratecard::model()->find('Media_House_ID=:a AND color_code=:b', array(':a'=>$Media_House_ID,':b'=>$color_code))){
				$rate=$rate->rate;
				$rate_cost = $rate*$col*$centimeter;
			}else{
				$rate_cost = 0;
			}

			if($cont_on!=0) {
				$my_continuation=RateContinuation($cont_on);
			}
			$this_rate+=$my_continuation;
		}
		return $this_rate;
	}

	
}