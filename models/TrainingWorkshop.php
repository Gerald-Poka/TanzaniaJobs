<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for the "training_workshops" table.
 */
class TrainingWorkshop extends ActiveRecord
{
    // Virtual properties for form fields (month/year inputs)
    public $start_month;
    public $start_year;
    public $end_month;
    public $end_year;
    public $is_ongoing;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_workshops';
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
                'updatedAtAttribute' => false, // Disable updated_at since it doesn't exist
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
            [['user_id', 'title', 'institution'], 'required'],
            [['user_id', 'is_ongoing'], 'integer'],
            [['start_date', 'end_date', 'created_at'], 'safe'],
            [['description'], 'string'],
            [['title', 'institution', 'location'], 'string', 'max' => 255],
            [['start_month', 'end_month'], 'string', 'max' => 2],
            [['start_year', 'end_year'], 'string', 'max' => 4],
            [['start_month', 'start_year'], 'required'],
            [['end_month', 'end_year'], 'required', 'when' => function($model) {
                return !$model->is_ongoing;
            }, 'message' => 'End date is required unless this training is ongoing.'],
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
            'title' => 'Training/Workshop Title',
            'institution' => 'Institution/Organization',
            'location' => 'Location',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'start_month' => 'Start Month',
            'start_year' => 'Start Year',
            'end_month' => 'End Month',
            'end_year' => 'End Year',
            'is_ongoing' => 'Ongoing',
            'description' => 'Description',
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

    // Add explicit getters for ALL database attributes to avoid magic method issues
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUserId()
    {
        return $this->getAttribute('user_id');
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function getInstitution()
    {
        return $this->getAttribute('institution');
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

    public function getCreatedAt()
    {
        return $this->getAttribute('created_at');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Convert month/year to date format before saving
            if ($this->start_month && $this->start_year) {
                $this->start_date = $this->start_year . '-' . str_pad($this->start_month, 2, '0', STR_PAD_LEFT) . '-01';
            }
            
            if (!$this->is_ongoing && $this->end_month && $this->end_year) {
                $this->end_date = $this->end_year . '-' . str_pad($this->end_month, 2, '0', STR_PAD_LEFT) . '-01';
            } elseif ($this->is_ongoing) {
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
            $this->is_ongoing = 0;
        } else {
            $this->is_ongoing = 1;
        }
    }

    public function getFormattedPeriod()
    {
        if ($this->start_date) {
            $start = date('M Y', strtotime($this->start_date));
            if ($this->is_ongoing || !$this->end_date) {
                return $start . ' - Ongoing';
            }
            $end = date('M Y', strtotime($this->end_date));
            return $start . ' - ' . $end;
        }
        return '';
    }
}