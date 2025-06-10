<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for the "referees" table.
 */
class Referee extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referees';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'position', 'company', 'email', 'phone'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'position', 'company', 'email', 'phone'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Full Name',
            'position' => 'Position/Title',
            'company' => 'Company/Organization',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // Getters for attributes
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUserId()
    {
        return $this->getAttribute('user_id');
    }

    public function getName()
    {
        return $this->getAttribute('name');
    }

    public function getPosition()
    {
        return $this->getAttribute('position');
    }

    public function getCompany()
    {
        return $this->getAttribute('company');
    }

    public function getEmail()
    {
        return $this->getAttribute('email');
    }

    public function getPhone()
    {
        return $this->getAttribute('phone');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }
}