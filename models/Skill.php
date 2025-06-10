<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "skills".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $category_id
 * @property string|null $description
 * @property string $status
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SkillCategory $category
 * @property JobSkill[] $jobSkills
 * @property Job[] $jobs
 */
class Skill extends ActiveRecord
{
    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function tableName()
    {
        return 'skills';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['category_id', 'sort_order'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['slug'], 'unique'],
            [['sort_order'], 'default', 'value' => 0],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Skill Name',
            'slug' => 'URL Slug',
            'category_id' => 'Category',
            'description' => 'Description',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // Relationships
    public function getCategory()
    {
        return $this->hasOne(SkillCategory::class, ['id' => 'category_id']);
    }

    public function getJobSkills()
    {
        return $this->hasMany(JobSkill::class, ['skill_id' => 'id']);
    }

    public function getJobs()
    {
        return $this->hasMany(Job::class, ['id' => 'job_id'])
                    ->viaTable('job_skills', ['skill_id' => 'id']);
    }

    public function getActiveJobs()
    {
        return $this->hasMany(Job::class, ['id' => 'job_id'])
                    ->viaTable('job_skills', ['skill_id' => 'id'])
                    ->where(['jobs.status' => Job::STATUS_PUBLISHED])
                    ->andWhere(['or', ['jobs.expires_at' => null], ['>', 'jobs.expires_at', date('Y-m-d H:i:s')]]);
    }

    // Helper methods
    public static function getActive()
    {
        return static::find()->where(['status' => self::STATUS_ACTIVE]);
    }

    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getJobsCount()
    {
        return $this->getActiveJobs()->count();
    }

    public function isPopular()
    {
        return $this->getJobsCount() >= 5; // Consider skill popular if used in 5+ jobs
    }

    public static function getPopular($limit = 20)
    {
        return static::find()
            ->alias('s')
            ->select(['s.*', 'COUNT(js.id) as jobs_count'])
            ->leftJoin('job_skills js', 's.id = js.skill_id')
            ->leftJoin('jobs j', 'js.job_id = j.id AND j.status = :status', [':status' => Job::STATUS_PUBLISHED])
            ->where(['s.status' => self::STATUS_ACTIVE])
            ->groupBy('s.id')
            ->having(['>', 'jobs_count', 0])
            ->orderBy(['jobs_count' => SORT_DESC, 's.name' => SORT_ASC])
            ->limit($limit);
    }

    public static function searchByName($query)
    {
        return static::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->andWhere(['like', 'name', $query])
            ->orderBy(['name' => SORT_ASC])
            ->limit(20);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            // Delete related job_skills records
            JobSkill::deleteAll(['skill_id' => $this->id]);
            return true;
        }
        return false;
    }
}