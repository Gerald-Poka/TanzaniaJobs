<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for the "professional_qualifications" table.
 */
class ProfessionalQualification extends ActiveRecord
{
    // Virtual properties for form fields (month/year inputs)
    public $issued_month;
    public $issued_year;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professional_qualifications';
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
                'updatedAtAttribute' => false,
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
            [['user_id', 'certificate_name', 'organization'], 'required'],
            [['user_id'], 'integer'],
            [['issued_date', 'created_at'], 'safe'],
            [['description'], 'string'],
            [['certificate_name', 'organization'], 'string', 'max' => 255],
            [['issued_month'], 'string', 'max' => 2],
            [['issued_year'], 'string', 'max' => 4],
            [['issued_month', 'issued_year'], 'required'],
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
            'certificate_name' => 'Certificate Name',
            'organization' => 'Issuing Organization',
            'issued_date' => 'Issued Date',
            'issued_month' => 'Issued Month',
            'issued_year' => 'Issued Year',
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

    // Getters for attributes
    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function getUserId()
    {
        return $this->getAttribute('user_id');
    }

    public function getCertificateName()
    {
        return $this->getAttribute('certificate_name');
    }

    public function getOrganization()
    {
        return $this->getAttribute('organization');
    }

    public function getIssuedDate()
    {
        return $this->getAttribute('issued_date');
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
            if ($this->issued_month && $this->issued_year) {
                $this->issued_date = $this->issued_year . '-' . str_pad($this->issued_month, 2, '0', STR_PAD_LEFT) . '-01';
            }
            
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        
        // Convert date format to month/year for form display
        if ($this->issued_date) {
            $issuedDate = new \DateTime($this->issued_date);
            $this->issued_month = $issuedDate->format('m');
            $this->issued_year = $issuedDate->format('Y');
        }
    }

    public function getFormattedDate()
    {
        if ($this->issued_date) {
            return date('F Y', strtotime($this->issued_date));
        }
        return '';
    }
}