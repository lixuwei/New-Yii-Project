<?php

/**
 * This is the model class for table "{{vote_config}}".
 *
 * The followings are the available columns in table '{{vote_config}}':
 * @property string $id
 * @property integer $subject
 * @property integer $project
 * @property string $extra
 */
class VoteConfig extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VoteConfig the static model class
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
		return '{{vote_config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, project, enabled, extra', 'required'),
			array('subject, project', 'numerical', 'integerOnly'=>true),
			array('extra', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, project, extra', 'safe', 'on'=>'search'),
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
			'subject' => 'Subject',
			'project' => 'Project',
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
		$criteria->compare('subject',$this->subject);
		$criteria->compare('project',$this->project);
		$criteria->compare('extra',$this->extra,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 是否开启投票
     * @param $sid 专题ID
     * @param $pid 项目ID
     * @return bool 默认全部开启
     */
    public function isProjectEnabledVote($sid, $pid=0)
    {
        //如果主题关闭则全部关闭
        $enabled = self::model()->exists(
            '`subject`=:sid AND `enabled`=:enabled',
            array(
                'sid' => $sid,
                'enabled' => 0,
            )
        );
        if( $enabled ) return false;

        //主题下指定项目的关闭
        $enabled = self::model()->exists(
            '`subject`= :sid AND `project`= :pid AND `enabled` = :enable',
            array(
                'sid' => $sid,
                'pid' => $pid,
                'enable' => 0,
            )
        );
        if( $enabled ) return false;

        return true;
    }
}