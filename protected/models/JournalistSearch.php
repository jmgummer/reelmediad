<?php

// namespace app\models;

// use Yii;
// use yii\base\Model;

class JournalistSearch extends CActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'mediaJournalist';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('firstname, surname, othername, journalistType, mapped_ids', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('journalistID, firstname, surname, othername, journalistType, mapped_ids', 'safe', 'on'=>'search'),
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
            'journalistID' => 'Journalist',
            'firstname' => 'Firstname',
            'surname' => 'Surname',
            'othername' => 'Othername',
            'journalistType' => 'Journalist Type',
            'mapped_ids' => 'Mapped Ids',
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

        $criteria->compare('journalistID',$this->journalistID);
        $criteria->compare('firstname',$this->firstname,true);
        $criteria->compare('surname',$this->surname,true);
        $criteria->compare('othername',$this->othername,true);
        $criteria->compare('journalistType',$this->journalistType,true);
        $criteria->compare('mapped_ids',$this->mapped_ids,true);
        $criteria->order='firstname DESC';

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
     * @return MediaJournalist the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getFullName(){
        return $this->firstname.' '.$this->surname;
    }

   /* public function getJournalistName(){
        // $sql = 'select journalistID, firstname, surname,othername 
        //         from mediaJournalist';
        $journalists = MediaJournalist::model()->findAll(array('order'=>'firstname'));
        $journalists_names = CHtml::listData($journalists,'journalistID',function($journalists) { return $journalists->firstname . ' ' . $journalists->surname . ' ' . $journalists->othername ; });
        return $journalists_names;
    }*/
}