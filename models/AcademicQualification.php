<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "academic_qualifications".
 *
 * @property int $id
 * @property int $user_id
 * @property string $institution_name
 * @property string $degree
 * @property string $field_of_study
 * @property string $start_year
 * @property string $end_year
 * @property string $grade
 * @property string $created_at
 *
 * @property User $user
 */
class AcademicQualification extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%academic_qualifications}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false, // No updated_at column in your table
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
            [['user_id', 'institution_name', 'degree'], 'required'],
            [['user_id'], 'integer'],
            [['institution_name', 'degree', 'field_of_study', 'start_year', 'end_year', 'grade'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at'], 'safe'],
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
            'institution_name' => 'Institution Name',
            'degree' => 'Degree',
            'field_of_study' => 'Field of Study',
            'start_year' => 'Start Year',
            'end_year' => 'End Year',
            'grade' => 'Grade/GPA',
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

    // Getters
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUserId()
    {
        return $this->getAttribute('user_id');
    }

    public function getInstitutionName()
    {
        return $this->getAttribute('institution_name');
    }

    public function getDegree()
    {
        return $this->getAttribute('degree');
    }

    public function getFieldOfStudy()
    {
        return $this->getAttribute('field_of_study');
    }

    public function getStartYear()
    {
        return $this->getAttribute('start_year');
    }

    public function getEndYear()
    {
        return $this->getAttribute('end_year');
    }

    public function getGrade()
    {
        return $this->getAttribute('grade');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    // Alias methods for backward compatibility (if your views use these)
    public function getDegreeTitle()
    {
        return $this->getDegree();
    }
}