<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for the "work_experiences" table.
 */
class WorkExperience extends ActiveRecord
{
    // Virtual properties for form fields (month/year inputs)
    public $start_month;
    public $start_year;
    public $end_month;
    public $end_year;
    public $is_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_experiences';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'job_title', 'company_name'], 'required'],
            [['user_id', 'is_current'], 'integer'],
            [['start_date', 'end_date'], 'date'],
            [['description', 'skills_used'], 'string'],
            [['job_title', 'company_name', 'location', 'salary_range'], 'string', 'max' => 255],
            [['employment_type'], 'string', 'max' => 50],
            [['start_month', 'end_month'], 'string', 'max' => 2],
            [['start_year', 'end_year'], 'string', 'max' => 4],
            [['start_month', 'start_year'], 'required'],
            [['end_month', 'end_year'], 'required', 'when' => function($model) {
                return !$model->is_current;
            }, 'message' => 'End date is required unless this is your current job.'],
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
            'job_title' => 'Job Title',
            'company_name' => 'Company Name',
            'employment_type' => 'Employment Type',
            'location' => 'Location',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'start_month' => 'Start Month',
            'start_year' => 'Start Year',
            'end_month' => 'End Month',
            'end_year' => 'End Year',
            'is_current' => 'Current Job',
            'description' => 'Job Description',
            'salary_range' => 'Salary Range',
            'skills_used' => 'Skills Used',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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

    // Add explicit getters for ALL database attributes to avoid magic method issues
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUserId()
    {
        return $this->getAttribute('user_id');
    }

    public function getJobTitle()
    {
        return $this->getAttribute('job_title');
    }

    public function getCompanyName()
    {
        return $this->getAttribute('company_name');
    }

    public function getEmploymentType()
    {
        return $this->getAttribute('employment_type');
    }

    public function getLocation()
    {
        return $this->getAttribute('location');
    }

    public function getStartDate()
    {
        return $this->getAttribute('start_date');
    }

    public function getEndDate()
    {
        return $this->getAttribute('end_date');
    }

    public function getDescription()
    {
        return $this->getAttribute('description');
    }

    public function getSalaryRange()
    {
        return $this->getAttribute('salary_range');
    }

    public function getSkillsUsed()
    {
        return $this->getAttribute('skills_used');
    }

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt()
    {
        return $this->getAttribute('updated_at');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Convert month/year to date format before saving
            if ($this->start_month && $this->start_year) {
                $this->start_date = $this->start_year . '-' . str_pad($this->start_month, 2, '0', STR_PAD_LEFT) . '-01';
            }
            
            if (!$this->is_current && $this->end_month && $this->end_year) {
                $this->end_date = $this->end_year . '-' . str_pad($this->end_month, 2, '0', STR_PAD_LEFT) . '-01';
            } elseif ($this->is_current) {
                $this->end_date = null;
            }
            
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        
        // Convert date format to month/year for form display
        if ($this->start_date) {
            $startDate = new \DateTime($this->start_date);
            $this->start_month = $startDate->format('m');
            $this->start_year = $startDate->format('Y');
        }
        
        if ($this->end_date) {
            $endDate = new \DateTime($this->end_date);
            $this->end_month = $endDate->format('m');
            $this->end_year = $endDate->format('Y');
            $this->is_current = 0;
        } else {
            $this->is_current = 1;
        }
    }

    public function getFormattedPeriod()
    {
        if ($this->start_date) {
            $start = date('M Y', strtotime($this->start_date));
            if ($this->is_current || !$this->end_date) {
                return $start . ' - Present';
            }
            $end = date('M Y', strtotime($this->end_date));
            return $start . ' - ' . $end;
        }
        return '';
    }
}