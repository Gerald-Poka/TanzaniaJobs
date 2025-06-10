<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "job_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $icon
 * @property int $status
 * @property int $display_order
 * @property int $jobs_count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Job[] $jobs
 */
class JobCategory extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['status', 'display_order', 'jobs_count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'icon'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['display_order'], 'default', 'value' => 0],
            [['jobs_count'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Category Name',
            'slug' => 'URL Slug',
            'description' => 'Description',
            'icon' => 'Icon',
            'status' => 'Status',
            'display_order' => 'Display Order',
            'jobs_count' => 'Jobs Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::class, ['category_id' => 'id']);
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        return $this->status == self::STATUS_ACTIVE ? 'Active' : 'Inactive';
    }

    /**
     * Update jobs count
     */
    public function updateJobsCount()
    {
        $this->jobs_count = Job::find()->where(['category_id' => $this->id, 'status' => Job::STATUS_PUBLISHED])->count();
        return $this->save(false);
    }
}