<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $website
 * @property string|null $logo
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $country
 * @property int|null $owner_id
 * @property int $status
 * @property int $verified
 * @property int $featured
 * @property string|null $founded_year
 * @property string|null $industry
 * @property int|null $employees_count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $owner
 * @property Job[] $jobs
 */
class Company extends ActiveRecord
{
    // Status constants
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    // Upload constants
    public $logoFile;
    const UPLOAD_FOLDER = 'uploads/companies/logos/';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
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
                'ensureUnique' => true
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
            [['owner_id', 'status', 'verified', 'featured', 'employees_count'], 'integer'],
            [['founded_year', 'created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'website', 'logo', 'email', 'address', 'city', 'country', 'industry'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
            [['email'], 'email'],
            [['website'], 'url', 'defaultScheme' => 'http'],
            [['slug'], 'unique'],
            [['logoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Company Name',
            'slug' => 'URL Slug',
            'description' => 'Company Description',
            'website' => 'Website',
            'logo' => 'Logo',
            'logoFile' => 'Upload Logo',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'city' => 'City',
            'country' => 'Country',
            'owner_id' => 'Owner',
            'status' => 'Status',
            'verified' => 'Verified',
            'featured' => 'Featured',
            'founded_year' => 'Founded Year',
            'industry' => 'Industry',
            'employees_count' => 'Employees Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Jobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(Job::class, ['company_id' => 'id']);
    }

    /**
     * Get status label
     */
    public function getStatusLabel()
    {
        $statusLabels = [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PENDING => 'Pending',
        ];
        
        return isset($statusLabels[$this->status]) ? $statusLabels[$this->status] : 'Unknown';
    }

    /**
     * Get logo URL
     */
    public function getLogoUrl()
    {
        return $this->logo ? '/' . self::UPLOAD_FOLDER . $this->logo : '/img/default-company.png';
    }

    /**
     * Check if company is active
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}