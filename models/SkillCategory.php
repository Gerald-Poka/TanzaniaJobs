<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "skill_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string $status
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Skill[] $skills
 */
class SkillCategory extends ActiveRecord
{
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static function tableName()
    {
        return 'skill_categories';
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
            [['description'], 'string'],
            [['sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['slug'], 'unique'],
            [['sort_order'], 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Category Name',
            'slug' => 'URL Slug',
            'description' => 'Description',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSkills()
    {
        return $this->hasMany(Skill::class, ['category_id' => 'id']);
    }

    public function getActiveSkills()
    {
        return $this->hasMany(Skill::class, ['category_id' => 'id'])
                    ->where(['status' => Skill::STATUS_ACTIVE]);
    }

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
}