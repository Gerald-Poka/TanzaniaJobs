<?php
/**
 * CV Profile Model
 * 
 * This model represents the CV/resume profile of users
 */
class CVProfile {
    // Primary key
    private $id;
    
    // Foreign key to user
    private $user_id;
    
    // Profile details
    private $profile_picture;
    private $summary;
    private $skills;
    private $languages;
    
    // Record timestamp
    private $created_at;
    
    /**
     * Constructor
     */
    public function __construct($data = null) {
        if (is_array($data)) {
            $this->id = $data['id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->profile_picture = $data['profile_picture'] ?? null;
            $this->summary = $data['summary'] ?? null;
            $this->skills = $data['skills'] ?? null;
            $this->languages = $data['languages'] ?? null;
            $this->created_at = $data['created_at'] ?? null;
        }
    }
    
    // Getters and setters
    public function getId() {
        return $this->id;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
    
    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }
    
    public function getProfilePicture() {
        return $this->profile_picture;
    }
    
    public function setProfilePicture($profile_picture) {
        $this->profile_picture = $profile_picture;
        return $this;
    }
    
    public function getSummary() {
        return $this->summary;
    }
    
    public function setSummary($summary) {
        $this->summary = $summary;
        return $this;
    }
    
    public function getSkills() {
        return $this->skills;
    }
    
    public function setSkills($skills) {
        $this->skills = $skills;
        return $this;
    }
    
    public function getLanguages() {
        return $this->languages;
    }
    
    public function setLanguages($languages) {
        $this->languages = $languages;
        return $this;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    // Database operations would go here based on your framework/database access pattern
}