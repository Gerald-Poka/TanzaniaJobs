<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use app\models\SavedJob;
use app\models\Company;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $short_description
 * @property string|null $requirements
 * @property string|null $benefits
 * @property int|null $company_id
 * @property int|null $category_id
 * @property int|null $posted_by
 * @property string $job_type
 * @property string $location_type
 * @property string|null $location
 * @property decimal|null $salary_min
 * @property decimal|null $salary_max
 * @property string|null $salary_currency
 * @property string|null $salary_period
 * @property string|null $experience_level
 * @property string|null $education_level
 * @property string $status
 * @property int $featured
 * @property int $urgent
 * @property int $views_count
 * @property int $applications_count
 * @property string|null $expires_at
 * @property string|null $rejection_reason
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Company $company
 * @property JobCategory $category
 * @property User $postedBy
 * @property JobApplication[] $applications
 * @property SavedJob[] $savedJobs
 * @property JobSkill[] $jobSkills
 * @property Skill[] $skills
 */
class Job extends ActiveRecord
{
    // Job type constants
    const TYPE_FULL_TIME = 'full-time';
    const TYPE_PART_TIME = 'part-time';
    const TYPE_CONTRACT = 'contract';
    const TYPE_FREELANCE = 'freelance';
    const TYPE_INTERNSHIP = 'internship';

    // Location type constants
    const LOCATION_ONSITE = 'onsite';
    const LOCATION_REMOTE = 'remote';
    const LOCATION_HYBRID = 'hybrid';

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    const STATUS_EXPIRED = 'expired';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REPORTED = 'reported';

    // Experience level constants
    const EXPERIENCE_ENTRY = 'entry';
    const EXPERIENCE_JUNIOR = 'junior';
    const EXPERIENCE_MID = 'mid';
    const EXPERIENCE_SENIOR = 'senior';
    const EXPERIENCE_LEAD = 'lead';
    const EXPERIENCE_EXECUTIVE = 'executive';

    // Education level constants
    const EDUCATION_HIGH_SCHOOL = 'high-school';
    const EDUCATION_DIPLOMA = 'diploma';
    const EDUCATION_BACHELOR = 'bachelor';
    const EDUCATION_MASTER = 'master';
    const EDUCATION_PHD = 'phd';

    // Salary period constants
    const SALARY_HOURLY = 'hourly';
    const SALARY_DAILY = 'daily';
    const SALARY_WEEKLY = 'weekly';
    const SALARY_MONTHLY = 'monthly';
    const SALARY_YEARLY = 'yearly';

    public static function tableName()
    {
        return 'jobs';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title', 'job_type', 'location_type', 'status'], 'required'],
            [['description', 'short_description', 'requirements', 'benefits', 'rejection_reason'], 'string'],
            [['company_id', 'category_id', 'posted_by', 'featured', 'urgent', 'views_count', 'applications_count'], 'integer'],
            [['salary_min', 'salary_max'], 'number'],
            [['expires_at', 'created_at', 'updated_at'], 'safe'],
            [['title', 'location'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 255],
            [['salary_currency'], 'string', 'max' => 10],
            [['salary_period', 'experience_level', 'education_level'], 'string', 'max' => 50],
            [['job_type'], 'in', 'range' => [
                self::TYPE_FULL_TIME, self::TYPE_PART_TIME, self::TYPE_CONTRACT, 
                self::TYPE_FREELANCE, self::TYPE_INTERNSHIP
            ]],
            [['location_type'], 'in', 'range' => [
                self::LOCATION_ONSITE, self::LOCATION_REMOTE, self::LOCATION_HYBRID
            ]],
            [['status'], 'in', 'range' => [
                self::STATUS_DRAFT, self::STATUS_PENDING, self::STATUS_PUBLISHED, 
                self::STATUS_EXPIRED, self::STATUS_REJECTED, self::STATUS_REPORTED
            ]],
            [['experience_level'], 'in', 'range' => [
                self::EXPERIENCE_ENTRY, self::EXPERIENCE_JUNIOR, self::EXPERIENCE_MID,
                self::EXPERIENCE_SENIOR, self::EXPERIENCE_LEAD, self::EXPERIENCE_EXECUTIVE
            ]],
            [['education_level'], 'in', 'range' => [
                self::EDUCATION_HIGH_SCHOOL, self::EDUCATION_DIPLOMA, self::EDUCATION_BACHELOR,
                self::EDUCATION_MASTER, self::EDUCATION_PHD
            ]],
            [['salary_period'], 'in', 'range' => [
                self::SALARY_HOURLY, self::SALARY_DAILY, self::SALARY_WEEKLY,
                self::SALARY_MONTHLY, self::SALARY_YEARLY
            ]],
            [['featured', 'urgent'], 'boolean'],
            [['views_count', 'applications_count'], 'default', 'value' => 0],
            [['slug'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Job Title',
            'slug' => 'URL Slug',
            'description' => 'Job Description',
            'short_description' => 'Short Description',
            'requirements' => 'Requirements',
            'benefits' => 'Benefits',
            'company_id' => 'Company',
            'category_id' => 'Category',
            'posted_by' => 'Posted By',
            'job_type' => 'Job Type',
            'location_type' => 'Location Type',
            'location' => 'Location',
            'salary_min' => 'Minimum Salary',
            'salary_max' => 'Maximum Salary',
            'salary_currency' => 'Currency',
            'salary_period' => 'Salary Period',
            'experience_level' => 'Experience Level',
            'education_level' => 'Education Level',
            'status' => 'Status',
            'featured' => 'Featured',
            'urgent' => 'Urgent',
            'views_count' => 'Views',
            'applications_count' => 'Applications',
            'expires_at' => 'Expires At',
            'rejection_reason' => 'Rejection Reason',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // Relationships
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(JobCategory::class, ['id' => 'category_id']);
    }

    public function getPostedBy()
    {
        return $this->hasOne(User::class, ['id' => 'posted_by']);
    }

    public function getApplications()
    {
        return $this->hasMany(JobApplication::class, ['job_id' => 'id']);
    }

    public function getSavedJobs()
    {
        return $this->hasMany(SavedJob::class, ['job_id' => 'id']);
    }

    public function getJobSkills()
    {
        return $this->hasMany(JobSkill::class, ['job_id' => 'id']);
    }

    public function getSkills()
    {
        return $this->hasMany(Skill::class, ['id' => 'skill_id'])
                    ->viaTable('job_skills', ['job_id' => 'id']);
    }

    // Helper methods
    public function getSalaryRange()
    {
        if (!$this->salary_min && !$this->salary_max) {
            return 'Negotiable';
        }
        
        $currency = $this->salary_currency ?: 'TSH';
        $min = $this->salary_min ? number_format((float)$this->salary_min) : 0;
        $max = $this->salary_max ? number_format((float)$this->salary_max) : 0;
        
        if ($this->salary_min && $this->salary_max) {
            return "{$currency} {$min} - {$max}";
        } elseif ($this->salary_min) {
            return "{$currency} {$min}+";
        } else {
            return "{$currency} {$max}";
        }
    }

    public static function getJobTypeOptions()
    {
        return [
            self::TYPE_FULL_TIME => 'Full Time',
            self::TYPE_PART_TIME => 'Part Time',
            self::TYPE_CONTRACT => 'Contract',
            self::TYPE_FREELANCE => 'Freelance',
            self::TYPE_INTERNSHIP => 'Internship',
        ];
    }

    public static function getLocationTypeOptions()
    {
        return [
            self::LOCATION_ONSITE => 'On-site',
            self::LOCATION_REMOTE => 'Remote',
            self::LOCATION_HYBRID => 'Hybrid',
        ];
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PENDING => 'Pending Review',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_EXPIRED => 'Expired',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_REPORTED => 'Reported',
        ];
    }

    public function isExpired()
    {
        return $this->expires_at && strtotime($this->expires_at) < time();
    }

    public function isActive()
    {
        return $this->status === self::STATUS_PUBLISHED && !$this->isExpired();
    }

    public function incrementViewCount()
    {
        $this->updateCounters(['views_count' => 1]);
    }

    public function incrementApplicationCount()
    {
        $this->updateCounters(['applications_count' => 1]);
    }

    public function decrementApplicationCount()
    {
        $this->updateCounters(['applications_count' => -1]);
    }

    public static function getPublished()
    {
        return static::find()
            ->where(['status' => self::STATUS_PUBLISHED])
            ->andWhere(['or', ['expires_at' => null], ['>', 'expires_at', date('Y-m-d H:i:s')]])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}