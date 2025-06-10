<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "job_skills".
 *
 * @property int $id
 * @property int $job_id
 * @property int $skill_id
 *
 * @property Job $job
 * @property Skill $skill
 */
class JobSkill extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job_skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job_id', 'skill_id'], 'required'],
            [['job_id', 'skill_id'], 'integer'],
            [['job_id', 'skill_id'], 'unique', 'targetAttribute' => ['job_id', 'skill_id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Job::class, 'targetAttribute' => ['job_id' => 'id']],
            [['skill_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skill::class, 'targetAttribute' => ['skill_id' => 'id']],
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
            'skill_id' => 'Skill',
        ];
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::class, ['id' => 'job_id']);
    }

    /**
     * Gets query for [[Skill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::class, ['id' => 'skill_id']);
    }
}