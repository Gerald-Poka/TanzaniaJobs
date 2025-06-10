<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\UploadedFile;

/**
 * This is the model class for the "cv_profiles" table.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $location
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $nationality
 * @property string|null $job_title
 * @property string|null $years_of_experience
 * @property string|null $profile_picture
 * @property string|null $summary
 * @property string|null $skills
 * @property string|null $languages
 * @property string|null $linkedin_url
 * @property string|null $github_url
 * @property string|null $website_url
 * @property string|null $twitter_url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class CVProfile extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $profilePictureFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cv_profiles}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
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
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['summary', 'skills', 'languages'], 'string'],
            [['location', 'nationality', 'job_title', 'years_of_experience', 'profile_picture', 'linkedin_url', 'github_url', 'website_url', 'twitter_url'], 'string', 'max' => 255],
            
            // Gender validation with custom validation method
            [['gender'], 'string', 'max' => 50],
            [['gender'], 'validateGender'],
            
            [['profilePictureFile'], 'file', 
                'skipOnEmpty' => true, 
                'extensions' => 'png, jpg, jpeg, gif', 
                'maxSize' => 1024*1024*2, // 2MB max
                'tooBig' => 'File size must be less than 2MB.',
                'wrongExtension' => 'Only JPG, JPEG, PNG, and GIF files are allowed.'
            ],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * Custom gender validation method
     */
    public function validateGender($attribute, $params)
    {
        if (!empty($this->$attribute)) {
            $validGenders = ['Male', 'Female'];
            if (!in_array($this->$attribute, $validGenders)) {
                $this->addError($attribute, 'Gender must be one of: ' . implode(', ', $validGenders));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'location' => 'Location',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'nationality' => 'Nationality',
            'job_title' => 'Job Title',
            'years_of_experience' => 'Years of Experience',
            'profile_picture' => 'Profile Picture',
            'summary' => 'Professional Summary',
            'skills' => 'Skills',
            'languages' => 'Languages',
            'linkedin_url' => 'LinkedIn Profile URL',
            'github_url' => 'GitHub Profile URL',
            'website_url' => 'Personal Website URL',
            'twitter_url' => 'Twitter/X Profile URL',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'profilePictureFile' => 'Profile Picture',
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

    public function getLocation()
    {
        return $this->getAttribute('location');
    }

    public function getDateOfBirth()
    {
        return $this->getAttribute('date_of_birth');
    }

    public function getGender()
    {
        return $this->getAttribute('gender');
    }

    public function getNationality()
    {
        return $this->getAttribute('nationality');
    }

    public function getJobTitle()
    {
        return $this->getAttribute('job_title');
    }

    public function getYearsOfExperience()
    {
        return $this->getAttribute('years_of_experience');
    }

    public function getSummary()
    {
        return $this->getAttribute('summary');
    }

    public function getSkills()
    {
        return $this->getAttribute('skills');
    }

    public function getLanguages()
    {
        return $this->getAttribute('languages');
    }

    public function getProfilePicture()
    {
        return $this->getAttribute('profile_picture');
    }

    public function getLinkedinUrl()
    {
        return $this->getAttribute('linkedin_url');
    }

    public function getGithubUrl()
    {
        return $this->getAttribute('github_url');
    }

    public function getWebsiteUrl()
    {
        return $this->getAttribute('website_url');
    }

    public function getTwitterUrl()
    {
        return $this->getAttribute('twitter_url');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->getAttribute('updated_at');
    }
}