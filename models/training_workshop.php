<?php
/**
 * Training Workshop Model
 * 
 * This model represents training workshops and courses attended by users
 */
class TrainingWorkshop {
    // Primary key
    private $id;
    
    // Foreign key to user
    private $user_id;
    
    // Training workshop details
    private $title;
    private $institution;
    private $location;
    private $start_date;
    private $end_date;
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
            $this->title = $data['title'] ?? null;
            $this->institution = $data['institution'] ?? null;
            $this->location = $data['location'] ?? null;
            $this->start_date = $data['start_date'] ?? null;
            $this->end_date = $data['end_date'] ?? null;
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
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    public function getInstitution() {
        return $this->institution;
    }
    
    public function setInstitution($institution) {
        $this->institution = $institution;
        return $this;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }
    
    public function getStartDate() {
        return $this->start_date;
    }
    
    public function setStartDate($start_date) {
        $this->start_date = $start_date;
        return $this;
    }
    
    public function getEndDate() {
        return $this->end_date;
    }
    
    public function setEndDate($end_date) {
        $this->end_date = $end_date;
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