<?php
/**
 * Professional Qualification Model
 * 
 * This model represents professional qualifications and certifications of users
 */
class ProfessionalQualification {
    // Primary key
    private $id;
    
    // Foreign key to user
    private $user_id;
    
    // Professional qualification details
    private $certificate_name;
    private $organization;
    private $issued_date;
    private $description; // optional
    
    // Record timestamp
    private $created_at;
    
    /**
     * Constructor
     */
    public function __construct($data = null) {
        if (is_array($data)) {
            $this->id = $data['id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->certificate_name = $data['certificate_name'] ?? null;
            $this->organization = $data['organization'] ?? null;
            $this->issued_date = $data['issued_date'] ?? null;
            $this->description = $data['description'] ?? null;
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
    
    public function getCertificateName() {
        return $this->certificate_name;
    }
    
    public function setCertificateName($certificate_name) {
        $this->certificate_name = $certificate_name;
        return $this;
    }
    
    public function getOrganization() {
        return $this->organization;
    }
    
    public function setOrganization($organization) {
        $this->organization = $organization;
        return $this;
    }
    
    public function getIssuedDate() {
        return $this->issued_date;
    }
    
    public function setIssuedDate($issued_date) {
        $this->issued_date = $issued_date;
        return $this;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    // Database operations would go here based on your framework/database access pattern
}