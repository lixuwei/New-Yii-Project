<?php

/**
 * This is the model class for table "{{vote}}".
 *
 * The followings are the available columns in table '{{vote}}':
 * @property string $id
 * @property string $subject_id
 * @property string $project_id
 * @property string $cnt
 * @property integer $extra
 */
class Vote extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vote}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject_id, project_id, cnt, user_id', 'required'),
			// Please remove those attributes that should not be searched.
			array('id, subject_id, project_id, cnt, extra', 'safe', 'on'=>'search'),
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
			'subject_id' => 'Subject',
			'project_id' => 'Project',
			'cnt' => 'Cnt',
			'extra' => 'Extra',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('subject_id',$this->subject_id,true);
		$criteria->compare('project_id',$this->project_id,true);
		$criteria->compare('cnt',$this->cnt,true);
		$criteria->compare('extra',$this->extra);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 获取单元素中对指定专题中项目的投票次数
     * @return mixed
     */
    public function getProjectVoteCnt($vote)
    {
        return self::model()->count(
            '`subject_id`= :sid AND `project_id`= :pid AND `user_id` = :uid',
            array(
                'sid' => $vote['sid'],
                'pid' => $vote['pid'],
                'uid' => Yii::app()->user->id,
            )
        );
    }

    public function doVote($vote)
    {
        $this->attributes = array(
            'user_id' => 1 ,
            'subject_id' => $vote['sid'] ,
            'project_id' => $vote['pid'] ,
            'cnt' => 1 ,
        );
        return $this->save();
/*        if( !$this->save() )
        {
            print_r($this->getErrors());
            return false;
        }else{
            return true;
        }*/
    }
}