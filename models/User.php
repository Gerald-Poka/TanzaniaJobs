<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property int $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BANNED = 0;      // Banned user
    const STATUS_ACTIVE = 10;     // Active user
    
    const ROLE_USER = 1;
    const ROLE_ADMIN = 10;

    public $password; // For form input, not stored in database

    // Add virtual properties for form fields that don't exist in database
    public $first_name;  // Map to firstname in afterFind and beforeSave
    public $last_name;   // Map to lastname in afterFind and beforeSave
    public $phone;       // New virtual property for phone
    public $location;    // New virtual property for location
    public $date_of_birth; // New virtual property for date of birth
    public $gender;      // New virtual property for gender
    public $nationality; // New virtual property for nationality

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BANNED]],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN]],

            // Rules for virtual form properties
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name', 'phone', 'location', 'nationality'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 50],
            [['date_of_birth'], 'safe'],
        ];
    }

    /**
     * Map virtual properties to DB fields after finding record
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->first_name = $this->firstname;
        $this->last_name = $this->lastname;
    }

    /**
     * Map virtual properties to DB fields before saving
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Map first_name to firstname if set
            if (!empty($this->first_name)) {
                $this->firstname = $this->first_name;
            }
            
            // Map last_name to lastname if set
            if (!empty($this->last_name)) {
                $this->lastname = $this->last_name;
            }
            
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Gets user's full name
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
    
    /**
     * Checks if user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == 10; // Assuming role 10 is admin
    }
    
    /**
     * Checks if user is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }
    
    /**
     * Checks if user is banned
     *
     * @return bool
     */
    public function isBanned()
    {
        return $this->status == self::STATUS_BANNED;
    }

    /**
     * Creates a new user
     * 
     * @param array $attributes
     * @return User|null the saved model or null if saving fails
     */
    public static function signup($attributes)
    {
        $user = new User();
        $user->firstname = $attributes['firstname'];
        $user->lastname = $attributes['lastname'];
        $user->email = $attributes['email'];
        $user->setPassword($attributes['password']);
        $user->generateAuthKey();
        $user->status = self::STATUS_ACTIVE;
        $user->role = self::ROLE_USER;
        $user->created_at = time();
        $user->updated_at = time();
        
        // Validate the model first
        if ($user->validate()) {
            if ($user->save(false)) { // Skip validation since we already validated
                return $user;
            } else {
                \Yii::error('User save failed after validation passed');
                return null;
            }
        } else {
            // Log validation errors for debugging
            \Yii::error('User signup validation failed: ' . json_encode($user->getErrors()));
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            // Labels for virtual form properties
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone Number',
            'location' => 'Location',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'nationality' => 'Nationality',
        ];
    }

    /**
     * Gets query for [[CvProfile]].
     */
    public function getCvProfile()
    {
        return $this->hasOne(CVProfile::class, ['user_id' => 'id']);
    }
}
