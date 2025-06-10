<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cv_documents".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $data
 * @property int $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class CVDocument extends ActiveRecord
{
    public static function tableName()
    {
        return 'cv_documents';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'data'], 'required'],
            [['user_id', 'is_active'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getDecodedData()
    {
        return json_decode($this->data, true) ?? [];
    }

    public function setEncodedData($data)
    {
        $this->data = json_encode($data);
    }
}