<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "saved_jobs".
 *
 * @property int $id
 * @property int $user_id
 * @property int $job_id
 * @property string $created_at
 * @property string $updated_at
 */
class SavedJob extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saved_jobs';
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
            [['user_id', 'job_id'], 'required'],
            [['user_id', 'job_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id', 'job_id'], 'unique', 'targetAttribute' => ['user_id', 'job_id']],
        ];
    }
}