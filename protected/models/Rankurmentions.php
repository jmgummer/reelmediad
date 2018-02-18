<?php

/**
 * This is the model class for table "rankurmentions".
 *
 * The followings are the available columns in table 'rankurmentions':
 * @property integer $id
 * @property string $mentionid
 * @property string $title
 * @property string $favicon
 * @property string $mentiondate
 * @property string $permalink
 * @property string $mentiontext
 * @property string $sentiment_stars
 * @property string $author
 * @property string $source
 * @property string $gender
 * @property string $city
 * @property string $country
 * @property string $facebook_likes
 * @property string $facebook_comments
 * @property string $twitter_following
 * @property string $twitter_followers
 * @property integer $mentionmonth
 * @property integer $companyid
 * @property string $tw_time
 * @property string $tw_date
 * @property integer $tonality
 * @property string $keywords
 * @property integer $ignored
 * @property string $theme
 * @property integer $keycount
 * @property integer $preflevel
 * @property integer $sitecleaned
 */
class Rankurmentions extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rankurmentions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mentionid, mentiondate, permalink, mentiontext, sentiment_stars, author, source, gender, city, country, facebook_likes, facebook_comments, twitter_following, twitter_followers, mentionmonth, companyid, tw_time, tw_date, theme', 'required'),
			array('mentionmonth, companyid, tonality, ignored, keycount, preflevel, sitecleaned', 'numerical', 'integerOnly'=>true),
			array('mentionid', 'length', 'max'=>50),
			array('title, permalink, mentiontext', 'length', 'max'=>150),
			array('favicon, author, source, gender', 'length', 'max'=>255),
			array('sentiment_stars', 'length', 'max'=>5),
			array('city, country, facebook_likes, facebook_comments, twitter_following, twitter_followers, theme', 'length', 'max'=>30),
			array('keywords', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mentionid, title, favicon, mentiondate, permalink, mentiontext, sentiment_stars, author, source, gender, city, country, facebook_likes, facebook_comments, twitter_following, twitter_followers, mentionmonth, companyid, tw_time, tw_date, tonality, keywords, ignored, theme, keycount, preflevel, sitecleaned', 'safe', 'on'=>'search'),
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
			'mentionid' => 'Mentionid',
			'title' => 'Title',
			'favicon' => 'Favicon',
			'mentiondate' => 'Mentiondate',
			'permalink' => 'Permalink',
			'mentiontext' => 'Mentiontext',
			'sentiment_stars' => 'Sentiment Stars',
			'author' => 'Author',
			'source' => 'Source',
			'gender' => 'Gender',
			'city' => 'City',
			'country' => 'Country',
			'facebook_likes' => 'Facebook Likes',
			'facebook_comments' => 'Facebook Comments',
			'twitter_following' => 'Twitter Following',
			'twitter_followers' => 'Twitter Followers',
			'mentionmonth' => 'Mentionmonth',
			'companyid' => 'Companyid',
			'tw_time' => 'Tw Time',
			'tw_date' => 'Tw Date',
			'tonality' => 'Tonality',
			'keywords' => 'Keywords',
			'ignored' => 'Ignored',
			'theme' => 'Theme',
			'keycount' => 'Keycount',
			'preflevel' => 'Preflevel',
			'sitecleaned' => 'Sitecleaned',
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
		$criteria->compare('mentionid',$this->mentionid,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('favicon',$this->favicon,true);
		$criteria->compare('mentiondate',$this->mentiondate,true);
		$criteria->compare('permalink',$this->permalink,true);
		$criteria->compare('mentiontext',$this->mentiontext,true);
		$criteria->compare('sentiment_stars',$this->sentiment_stars,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('facebook_likes',$this->facebook_likes,true);
		$criteria->compare('facebook_comments',$this->facebook_comments,true);
		$criteria->compare('twitter_following',$this->twitter_following,true);
		$criteria->compare('twitter_followers',$this->twitter_followers,true);
		$criteria->compare('mentionmonth',$this->mentionmonth);
		$criteria->compare('companyid',$this->companyid);
		$criteria->compare('tw_time',$this->tw_time,true);
		$criteria->compare('tw_date',$this->tw_date,true);
		$criteria->compare('tonality',$this->tonality);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('ignored',$this->ignored);
		$criteria->compare('theme',$this->theme,true);
		$criteria->compare('keycount',$this->keycount);
		$criteria->compare('preflevel',$this->preflevel);
		$criteria->compare('sitecleaned',$this->sitecleaned);

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
	 * @return Rankurmentions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDate(){
		return date('d-m-Y', strtotime($this->mentiondate));
	}
	public function getOTS(){
		if($this->source=='Twitter'){
			return $this->twitter_followers;
		}else{
			return '-';
		}
	}
	public function getTonality(){
		if(isset($this->tonality)){
			if($this->tonality==1){
				return 'Positive';
			}elseif ($this->tonality==2) {
				return 'Negative';
			}else{
				return 'Neutral';
			}
		}
	}
	public function getTitle(){
		if(isset($this->title) && !empty($this->title)){
			return $this->title;
		}else{
			return $this->mentiontext;
		}
	}
	public function getLink(){
		if(isset($this->permalink) && !empty($this->permalink)){
			return "<a href='$this->permalink' target='_blank'>$this->Title</a>";
		}else{
			return $this->permalink;
		}
	}
	public function getDomain(){
		$pieces = parse_url($this->permalink);
		$domain = isset($pieces['host']) ? $pieces['host'] : '';
		if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
			return $regs['domain'];
		}else{
			return false;
		}
	}
	public function getAuthors(){
		if($this->author!=''){
			return $this->author;
		}else{
			return '-';
		}
	}
	public function getThemes(){
		$themedata = "";
		$theme = $this->theme;
		$sql = "SELECT DISTINCT theme_name FROM themes WHERE themes.id =$theme ";
		if($themes = Themes::model()->findAllBySql($sql)){
			foreach ($themes as $key ) {
				$themearr[] = $key->theme_name;
			}
			$themedata = implode(', ', $themearr);
		}else{
			$themedata = "Adhoc Mentions";
		}
		return $themedata;
	}

	public function getKeywords(){
		return $this->keywords;
	}

	public function getAVE(){
		$social_array = array('Twitter','Facebook','Instagram','Gplus','Google+');
		if (in_array($this->source, $social_array)) {
			if($this->source=='Twitter'){
				return ($this->twitter_followers*1.80031005239009);
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
}
