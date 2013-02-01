<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class User extends CActiveRecord
{
    const TYPE_EDITOR = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>32),
            array('email', 'email'),
			array('lastvisit_at, salt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status', 'safe', 'on'=>'search'),
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
			'profiles' => array(self::HAS_ONE, 'Profiles', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => '用户名',
			'password' => '密码',
			'email' => '电子邮件',
			'activkey' => '激活码',
			'create_at' => '注册时间',
			'lastvisit_at' => '最后访问',
			'superuser' => 'Superuser',
			'status' => '状态',
		);
	}

    public function beforeSave()
    {
        if ( $this->isNewRecord )
        {
            $this->status = 0;
            $this->activkey = $this->GenerateActivkey();
            $this->salt = $this->GenerateSalt();
            $this->superuser = 0;
            $this->create_at = date( 'Y-m-d H:i:s', time() );
            //加密密码
            $this->password = $this->hashPassword($this->password, $this->salt);
        }

        return parent::beforeSave();
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    /**
     * Checks if the given password is correct.
     * @param string the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {
        return $this->hashPassword($password,$this->salt)===$this->password;
    }

    /**
     * Generates the password hash.
     * @param string password
     * @param string salt
     * @return string hash
     */
    public function hashPassword($password,$salt)
    {
        return md5($salt.$password);
    }

    /**
     * 生成一个激活Key
     * @return string
     */
    public function GenerateActivkey()
    {
        return md5(uniqid($this->username.$this->password, true));
    }

    /**
     * 生成一个SALT码
     */
    public function GenerateSalt()
    {
        $seed = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";   //   输出字符集
        for( $i=0; $i<5; $i++)
            $seed = str_shuffle($seed);

        $salt = substr( $seed , 0, 4 );
        return  $salt;
    }
}