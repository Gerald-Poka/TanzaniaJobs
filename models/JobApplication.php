<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "job_applications".
 *
 * @property int $id
 * @property int $job_id
 * @property int $applicant_id
 * @property string|null $cover_letter
 * @property string|null $resume_file
 * @property float|null $expected_salary
 * @property string|null $availability_date
 * @property string $status
 * @property string|null $notes
 * @property string|null $applied_at
 * @property string|null $updated_at
 * @property int|null $cv_document_id
 */
class JobApplication extends \yii\db\ActiveRecord
{
    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWING = 'reviewing';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_INTERVIEWED = 'interviewed';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_WITHDRAWN = 'withdrawn';

    // Add this property to handle CV selection
    public $selected_cv_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_applications';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'applied_at',
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
            [['job_id', 'applicant_id', 'cover_letter', 'availability_date'], 'required'],
            [['job_id', 'applicant_id', 'selected_cv_id', 'cv_document_id'], 'integer'],
            [['cover_letter', 'notes'], 'string'],
            [['expected_salary'], 'number'],
            [['availability_date', 'applied_at', 'updated_at'], 'safe'],
            [['resume_file'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['job_id', 'applicant_id'], 'unique', 'targetAttribute' => ['job_id', 'applicant_id'], 'message' => 'You have already applied for this job.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_id' => 'Job',
            'applicant_id' => 'Applicant',
            'cover_letter' => 'Cover Letter',
            'resume_file' => 'Resume',
            'expected_salary' => 'Expected Salary',
            'availability_date' => 'Availability Date',
            'status' => 'Status',
            'notes' => 'Additional Notes',
            'applied_at' => 'Applied At',
            'updated_at' => 'Updated At',
            'cv_document_id' => 'CV Document',
        ];
    }

    /**
     * Gets query for [[Job]].
     */
    public function getJob()
    {
        return $this->hasOne(Job::class, ['id' => 'job_id']);
    }

    /**
     * Gets query for [[Applicant]].
     */
    public function getApplicant()
    {
        return $this->hasOne(User::class, ['id' => 'applicant_id']);
    }

    /**
     * Gets query for [[CvDocument]].
     */
    public function getCvDocument()
    {
        return $this->hasOne(CvDocument::class, ['id' => 'cv_document_id']);
    }

    /**
     * Gets query for [[Applicant]] with CV Profile.
     */
    public function getApplicantProfile()
    {
        return $this->hasOne(CVProfile::class, ['user_id' => 'applicant_id']);
    }

    /**
     * Get a list of possible statuses and their labels
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => 'Pending Review',
            self::STATUS_REVIEWING => 'Under Review',
            self::STATUS_SHORTLISTED => 'Shortlisted', 
            self::STATUS_INTERVIEWED => 'Interview Scheduled',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_REJECTED => 'Not Selected',
            self::STATUS_WITHDRAWN => 'Withdrawn',
        ];
    }
}