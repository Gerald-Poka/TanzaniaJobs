<?php
/**
 * Academic Qualification Model
 * 
 * This model represents academic qualifications of users
 */
class AcademicQualification {
    // Primary key
    private $id;
    
    // Foreign key to user
    private $user_id;
    
    // Academic details
    private $institution_name;
    private $degree;
    private $field_of_study;
    private $start_year;
    private $end_year;
    private $grade;
    
    // Record timestamp
    private $created_at;
    
    /**
     * Constructor
     */
    public function __construct($data = null) {
        if (is_array($data)) {
            $this->id = $data['id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->institution_name = $data['institution_name'] ?? null;
            $this->degree = $data['degree'] ?? null;
            $this->field_of_study = $data['field_of_study'] ?? null;
            $this->start_year = $data['start_year'] ?? null;
            $this->end_year = $data['end_year'] ?? null;
            $this->grade = $data['grade'] ?? null;
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
    
    public function getInstitutionName() {
        return $this->institution_name;
    }
    
    public function setInstitutionName($institution_name) {
        $this->institution_name = $institution_name;
        return $this;
    }
    
    public function getDegree() {
        return $this->degree;
    }
    
    public function setDegree($degree) {
        $this->degree = $degree;
        return $this;
    }
    
    public function getFieldOfStudy() {
        return $this->field_of_study;
    }
    
    public function setFieldOfStudy($field_of_study) {
        $this->field_of_study = $field_of_study;
        return $this;
    }
    
    public function getStartYear() {
        return $this->start_year;
    }
    
    public function setStartYear($start_year) {
        $this->start_year = $start_year;
        return $this;
    }
    
    public function getEndYear() {
        return $this->end_year;
    }
    
    public function setEndYear($end_year) {
        $this->end_year = $end_year;
        return $this;
    }
    
    public function getGrade() {
        return $this->grade;
    }
    
    public function setGrade($grade) {
        $this->grade = $grade;
        return $this;
    }
    
    public function getCreatedAt() {
        return $this->created_at;
    }
    
    // Database operations would go here based on your framework/database access pattern
}