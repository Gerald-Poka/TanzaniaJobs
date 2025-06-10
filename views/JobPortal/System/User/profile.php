<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var app\models\CVProfile $cvProfile */
/** @var app\models\AcademicQualification[] $academicQualifications */
/** @var app\models\ProfessionalQualification[] $professionalQualifications */
/** @var app\models\WorkExperience[] $workExperiences */
/** @var app\models\TrainingWorkshop[] $trainingWorkshops */
/** @var app\models\Referee[] $referees */

$this->title = 'My Profile - TanzaniaJobs';
$this->params['breadcrumbs'][] = 'My Profile';

// Calculate profile completion percentage
$totalSections = 7; // Personal info, Skills, Languages, Education, Experience, Certifications, Referees
$completedSections = 1; // Personal info is always available

// Add completed sections based on data presence
if (isset($cvProfile) && !empty($cvProfile->skills)) $completedSections++;
if (isset($cvProfile) && !empty($cvProfile->languages)) $completedSections++;
if (!empty($academicQualifications)) $completedSections++;
if (!empty($workExperiences)) $completedSections++;
if (!empty($professionalQualifications)) $completedSections++;
if (!empty($referees)) $completedSections++;

$completionPercentage = round(($completedSections / $totalSections) * 100);

// Define primary color
$primaryColor = "rgb(72, 38, 104)";
$primaryColorLight = "rgb(103, 62, 145)";
$primaryColorDark = "rgb(56, 30, 81)";
?>

<?php echo $this->render('partials/main'); ?>

<head>
    <?php echo $this->render('partials/title-meta', array('title'=>'Profile')); ?>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="/libs/swiper/swiper-bundle.min.css">
    <?php echo $this->render('partials/head-css'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.min.css">
    <style>
        :root {
            --primary-color: <?= $primaryColor ?>;
            --primary-color-light: <?= $primaryColorLight ?>;
            --primary-color-dark: <?= $primaryColorDark ?>;
            --primary-color-rgb: 72, 38, 104;
            --success-color: #50cd89;
            --info-color: #3699ff;
            --warning-color: #f1b44c;
            --danger-color: #f46a6a;
        }
        
        /* General Styles */
        body {
            background-color: #f8f9fa;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 16px 20px;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-color-dark);
            border-color: var(--primary-color-dark);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-soft-primary {
            color: var(--primary-color);
            background-color: rgba(var(--primary-color-rgb), 0.1);
            border-color: transparent;
        }
        
        .btn-soft-primary:hover {
            color: #fff;
            background-color: var(--primary-color);
        }
        
        .bg-soft-primary {
            background-color: rgba(var(--primary-color-rgb), 0.15) !important;
        }
        
        /* Hero Section */
        .profile-hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color-dark) 100%);
            padding: 50px 0 70px;
            border-radius: 0 0 25px 25px;
            position: relative;
            margin-bottom: 70px;
        }
        
        /* Profile Avatar Section */
        .profile-avatar-section {
            margin-top: -80px;
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }
        
        .profile-edit-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }
        
        .profile-edit-btn:hover {
            background-color: var(--primary-color-dark);
            transform: scale(1.1);
        }
        
        /* Progress Circle */
        .progress-circle {
            position: relative;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: conic-gradient(var(--success-color) <?= $completionPercentage ?>%, #2e3235 0);
        }
        
        .progress-circle::before {
            content: "";
            position: absolute;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background-color: #1c222f;
        }
        
        .progress-text {
            position: relative;
            z-index: 1;
            font-size: 16px;
            font-weight: bold;
            color: white;
        }
        
        /* Navigation Tabs */
        .profile-nav-tabs {
            border-radius: 40px;
            background-color: #fff;
            padding: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        
        .profile-nav-tabs .nav-link {
            border-radius: 40px;
            padding: 10px 18px;
            margin: 0 4px;
            color: #495057;
            font-weight: 500;
            border: none;
            transition: all 0.2s ease;
        }
        
        .profile-nav-tabs .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(var(--primary-color-rgb), 0.08);
        }
        
        .profile-nav-tabs .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 12px rgba(var(--primary-color-rgb), 0.3);
        }
        
        /* Info Cards */
        .info-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background-color: #fff;
            overflow: hidden;
            margin-bottom: 24px;
        }
        
        .info-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #f9fafb;
        }
        
        .info-card-body {
            padding: 24px;
        }
        
        /* Timeline Items */
        .timeline-item {
            position: relative;
            padding-left: 45px;
            padding-bottom: 32px;
            position: relative;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-item::before {
            content: "";
            position: absolute;
            left: 18px;
            top: 30px;
            bottom: 0;
            width: 2px;
            background-color: rgba(0, 0, 0, 0.08);
        }
        
        .timeline-item:last-child::before {
            display: none;
        }
        
        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }
        
        .timeline-content {
            padding: 16px 20px;
            background-color: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }
        
        /* Action Buttons */
        .action-btn {
            padding: 8px 20px;
            border-radius: 40px;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }
        
        /* Skill Badges */
        .skill-badge {
            display: inline-block;
            padding: 6px 14px;
            background-color: rgba(var(--primary-color-rgb), 0.1);
            color: var(--primary-color);
            border-radius: 40px;
            font-size: 14px;
            margin-bottom: 8px;
            margin-right: 8px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(var(--primary-color-rgb), 0.1);
            transition: all 0.2s;
        }
        
        .skill-badge:hover {
            background-color: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(var(--primary-color-rgb), 0.2);
        }
        
        /* Info Table */
        .info-table th {
            width: 35%;
            font-weight: 500;
            color: #495057;
        }
        
        .info-table td {
            color: #6c757d;
        }
        
        /* Certificates and Cards */
        .cert-card {
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s;
        }
        
        .cert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom section colors */
        .section-education .timeline-icon { background-color: var(--primary-color); }
        .section-education .timeline-content { border-left-color: var(--primary-color); }
        
        .section-experience .timeline-icon { background-color: var(--success-color); }
        .section-experience .timeline-content { border-left-color: var(--success-color); }
        
        .section-training .timeline-icon { background-color: var(--warning-color); }
        .section-training .timeline-content { border-left-color: var(--warning-color); }
        
        .section-certification .cert-card { border-left-color: var(--info-color); }
        
        .section-referee .card { border-left: 4px solid var(--danger-color); }
        
        /* Avatar colors */
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
        }
        
        .progress-bar {
            background-color: var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $this->render('partials/menu'); ?>

        <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
                <!-- Profile Hero Section -->
                <div class="profile-hero-section">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="text-white">
                                    <div class="d-flex align-items-center mb-4">
                                        <i class="ri-user-3-fill fs-1 me-3 opacity-75"></i>
                                        <div>
                                            <h1 class="text-white mb-1 display-6 fw-bold">Welcome, <?= Html::encode($user->getFullName()) ?></h1>
                                            <p class="text-white-50 mb-0 fs-5">Complete your professional profile to attract top employers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-end">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="me-3 text-white text-end">
                                        <h3 class="text-white mb-1"><?= $completionPercentage ?>%</h3>
                                        <small class="text-white-50">Profile Completion</small>
                                    </div>
                                    <div class="progress-circle">
                                        <div class="progress-text"><?= $completionPercentage ?>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Profile Avatar Section -->
                    <div class="profile-avatar-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <div class="row align-items-end">
                                            <!-- Profile Avatar -->
                                            <div class="col-auto">
                                                <div class="position-relative">
                                                    <img src="<?= isset($cvProfile) && $cvProfile->profile_picture ? $cvProfile->profile_picture : '/images/users/avatar-1.jpg' ?>" 
                                                         alt="<?= Html::encode($user->getFullName()) ?>" 
                                                         class="rounded-circle profile-avatar" />
                                                    <div class="profile-edit-btn">
                                                        <i class="ri-camera-fill text-white fs-18"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- User Info -->
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h2 class="mb-2 fw-bold">
                                                            <?= Html::encode($user->getFullName()) ?>
                                                            <?php if ($user->status == 10): ?>
                                                                <i class="ri-verified-badge-fill text-success ms-2" title="Verified Account"></i>
                                                            <?php endif; ?>
                                                        </h2>
                                                        <p class="text-muted fs-5 mb-2">
                                                            <i class="ri-briefcase-4-line me-2"></i>
                                                            <?= $user->isAdmin() ? 'System Administrator' : 'Job Seeker' ?>
                                                        </p>
                                                        <div class="d-flex flex-wrap gap-3 text-muted">
                                                            <span><i class="ri-map-pin-line me-1"></i>Tanzania</span>
                                                            <span><i class="ri-calendar-line me-1"></i>Joined <?= date('M Y', $user->created_at) ?></span>
                                                            <span><i class="ri-mail-line me-1"></i><?= Html::encode($user->email) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 text-end">
                                                        <div class="d-flex gap-2 justify-content-md-end">
                                                            <a href="<?= \yii\helpers\Url::to(['/user/profile-edit']) ?>" class="btn btn-primary action-btn">
                                                                <i class="ri-edit-line me-2"></i>Edit Profile
                                                            </a>
                                                            <button class="btn btn-outline-primary action-btn">
                                                                <i class="ri-download-line me-2"></i>Download CV
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-pills profile-nav-tabs justify-content-center mb-4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                        <i class="ri-eye-line me-2"></i>Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#education-tab" role="tab">
                                        <i class="ri-graduation-cap-line me-2"></i>Education
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#experience-tab" role="tab">
                                        <i class="ri-briefcase-line me-2"></i>Experience
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#certifications-tab" role="tab">
                                        <i class="ri-award-line me-2"></i>Certifications
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#referees-tab" role="tab">
                                        <i class="ri-contacts-line me-2"></i>Referees
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview-tab" role="tabpanel">
                            <div class="row g-4">
                                <!-- Left Sidebar -->
                                <div class="col-lg-4">
                                    <!-- Personal Information -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-user-3-line me-2 text-primary"></i>
                                                Personal Information
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless info-table">
                                                <tbody>
                                                    <tr>
                                                        <th><i class="ri-user-line me-2 text-muted"></i>Full Name</th>
                                                        <td><?= Html::encode($user->getFullName()) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="ri-mail-line me-2 text-muted"></i>Email</th>
                                                        <td>
                                                            <?= Html::encode($user->email) ?>
                                                            <?php if ($user->status == 10): ?>
                                                                <i class="ri-verified-badge-fill text-success ms-1"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="ri-phone-line me-2 text-muted"></i>Phone</th>
                                                        <td><?= Html::encode($user->phone ?? 'Not provided') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="ri-map-pin-line me-2 text-muted"></i>Location</th>
                                                        <td><?= Html::encode($user->location ?? 'Tanzania') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="ri-calendar-line me-2 text-muted"></i>Member Since</th>
                                                        <td><?= date('F d, Y', $user->created_at) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Skills -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">
                                                    <i class="ri-star-line me-2 text-warning"></i>
                                                    Skills
                                                </h5>
                                                <button class="btn btn-sm btn-soft-primary rounded-circle">
                                                    <i class="ri-add-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php if (isset($cvProfile) && !empty($cvProfile->skills)): 
                                                    $skillsArray = is_array($cvProfile->skills) ? $cvProfile->skills : explode(',', $cvProfile->skills);
                                                    foreach ($skillsArray as $skill): ?>
                                                        <span class="skill-badge"><?= Html::encode($skill) ?></span>
                                                    <?php endforeach;
                                                else: ?>
                                                    <div class="d-flex align-items-center w-100">
                                                        <div class="text-center w-100 py-3">
                                                            <i class="ri-add-circle-line fs-2 text-muted mb-2"></i>
                                                            <p class="text-muted mb-0">Add your professional skills to showcase your expertise</p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Languages -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">
                                                    <i class="ri-translate-2 me-2 text-info"></i>
                                                    Languages
                                                </h5>
                                                <button class="btn btn-sm btn-soft-primary rounded-circle">
                                                    <i class="ri-add-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap gap-2">
                                                <?php if (isset($cvProfile) && !empty($cvProfile->languages)): 
                                                    $languagesArray = is_array($cvProfile->languages) ? $cvProfile->languages : explode(',', $cvProfile->languages);
                                                    foreach ($languagesArray as $language): ?>
                                                        <span class="skill-badge"><?= Html::encode($language) ?></span>
                                                    <?php endforeach;
                                                else: ?>
                                                    <div class="d-flex align-items-center w-100">
                                                        <div class="text-center w-100 py-3">
                                                            <i class="ri-translate-2 fs-2 text-muted mb-2"></i>
                                                            <p class="text-muted mb-0">Add languages you speak to enhance your profile</p>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Main Content -->
                                <div class="col-lg-8">
                                    <!-- About Me -->
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0">
                                                    <i class="ri-information-line me-2 text-primary"></i>
                                                    About Me
                                                </h5>
                                                <a href="<?= \yii\helpers\Url::to(['/user/profile-edit']) ?>" class="btn btn-sm btn-soft-primary">
                                                    <i class="ri-edit-line me-1"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($cvProfile) && !empty($cvProfile->summary)): ?>
                                                <p class="text-muted lh-lg mb-0">
                                                    <?= Html::encode($cvProfile->summary) ?>
                                                </p>
                                            <?php else: ?>
                                                <div class="text-center py-4">
                                                    <i class="ri-user-heart-line fs-2 text-muted mb-3"></i>
                                                    <p class="text-muted mb-3">Tell employers about yourself, your skills, and your professional background.</p>
                                                    <a href="<?= Url::to(['/cv-profile/update']) ?>" class="btn btn-sm btn-primary">
                                                        <i class="ri-add-line me-1"></i> Add Summary
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Career Highlights -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-award-line me-2 text-primary"></i>
                                                Career Highlights
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <!-- Education Highlight -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-sm">
                                                        <div class="card-body p-4">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar-sm bg-soft-primary rounded-circle">
                                                                        <span class="avatar-title text-primary">
                                                                            <i class="ri-graduation-cap-line fs-4"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h5 class="mb-1">Education</h5>
                                                                    <p class="text-muted mb-0 small">
                                                                        <?= !empty($academicQualifications) ? count($academicQualifications) . ' Qualifications' : 'No entries yet' ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                            <?php if (!empty($academicQualifications)): 
                                                                $latestEducation = reset($academicQualifications); ?>
                                                                <div class="position-relative ps-4 mb-3">
                                                                    <span class="position-absolute top-0 start-0 translate-middle-y bg-primary text-white rounded-circle p-1 mt-1">
                                                                        <i class="ri-checkbox-blank-circle-fill small"></i>
                                                                    </span>
                                                                    <h6 class="mb-1 text-truncate"><?= Html::encode($latestEducation->getDegree()) ?> in <?= Html::encode($latestEducation->getFieldOfStudy()) ?></h6>
                                                                    <p class="text-muted mb-1 small"><?= Html::encode($latestEducation->getInstitutionName()) ?></p>
                                                                    <small class="text-muted"><?= Html::encode($latestEducation->getStartYear()) ?> - <?= Html::encode($latestEducation->getEndYear() ?? 'Present') ?></small>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-center py-3">
                                                                    <p class="text-muted mb-2 small">No academic qualifications found</p>
                                                                    <a href="<?= Url::to(['academic-qualification/create']) ?>" class="btn btn-sm btn-soft-primary">
                                                                        <i class="ri-add-line me-1"></i> Add Education
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            
                                                            <div class="text-end">
                                                                <a href="#education-tab" data-bs-toggle="tab" class="btn btn-link p-0 text-primary">
                                                                    View All <i class="ri-arrow-right-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Experience Highlight -->
                                                <div class="col-md-6">
                                                    <div class="card border h-100 shadow-sm">
                                                        <div class="card-body p-4">
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar-sm bg-soft-success rounded-circle">
                                                                        <span class="avatar-title text-success">
                                                                            <i class="ri-briefcase-4-line fs-4"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h5 class="mb-1">Experience</h5>
                                                                    <p class="text-muted mb-0 small">
                                                                        <?= !empty($workExperiences) ? count($workExperiences) . ' Positions' : 'No entries yet' ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            
                                                            <?php if (!empty($workExperiences)):
                                                                $latestWork = reset($workExperiences); ?>
                                                                <div class="position-relative ps-4 mb-3">
                                                                    <span class="position-absolute top-0 start-0 translate-middle-y bg-success text-white rounded-circle p-1 mt-1">
                                                                        <i class="ri-checkbox-blank-circle-fill small"></i>
                                                                    </span>
                                                                    <h6 class="mb-1 text-truncate"><?= Html::encode($latestWork->getJobTitle()) ?></h6>
                                                                    <p class="text-muted mb-1 small"><?= Html::encode($latestWork->getCompanyName()) ?>, <?= Html::encode($latestWork->getLocation()) ?></p>
                                                                    <small class="text-muted"><?= date('M Y', strtotime($latestWork->getStartDate())) ?> - <?= $latestWork->getEndDate() ? date('M Y', strtotime($latestWork->getEndDate())) : 'Present' ?></small>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-center py-3">
                                                                    <p class="text-muted mb-2 small">No work experience found</p>
                                                                    <a href="<?= Url::to(['work-experience/create']) ?>" class="btn btn-sm btn-soft-success">
                                                                        <i class="ri-add-line me-1"></i> Add Experience
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            
                                                            <div class="text-end">
                                                                <a href="#experience-tab" data-bs-toggle="tab" class="btn btn-link p-0 text-success">
                                                                    View All <i class="ri-arrow-right-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profile Completion Card -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-check-double-line me-2 text-primary"></i>
                                                Complete Your Profile
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="completion-tracker">
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span>Profile Completion</span>
                                                        <span class="text-primary fw-semibold"><?= $completionPercentage ?>%</span>
                                                    </div>
                                                    <div class="progress" style="height: 10px;">
                                                        <div class="progress-bar" role="progressbar" style="width: <?= $completionPercentage ?>%;" aria-valuenow="<?= $completionPercentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row g-3">
                                                    <!-- Profile Tasks -->
                                                    <?php 
                                                    $tasks = [
                                                        ['icon' => 'ri-user-3-line', 'color' => 'primary', 'title' => 'Personal Information', 'complete' => true],
                                                        ['icon' => 'ri-information-line', 'color' => 'info', 'title' => 'Professional Summary', 'complete' => isset($cvProfile) && !empty($cvProfile->summary)],
                                                        ['icon' => 'ri-star-line', 'color' => 'warning', 'title' => 'Skills', 'complete' => isset($cvProfile) && !empty($cvProfile->skills)],
                                                        ['icon' => 'ri-translate-2', 'color' => 'info', 'title' => 'Languages', 'complete' => isset($cvProfile) && !empty($cvProfile->languages)],
                                                        ['icon' => 'ri-graduation-cap-line', 'color' => 'success', 'title' => 'Education', 'complete' => !empty($academicQualifications)],
                                                        ['icon' => 'ri-briefcase-line', 'color' => 'primary', 'title' => 'Work Experience', 'complete' => !empty($workExperiences)],
                                                        ['icon' => 'ri-award-line', 'color' => 'danger', 'title' => 'Certifications', 'complete' => !empty($professionalQualifications)],
                                                        ['icon' => 'ri-contacts-line', 'color' => 'success', 'title' => 'Referees', 'complete' => !empty($referees)]
                                                    ];
                                                    
                                                    foreach ($tasks as $task): 
                                                    ?>
                                                        <div class="col-md-6">
                                                            <div class="d-flex p-3 border rounded">
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar-sm bg-soft-<?= $task['color'] ?> rounded-circle">
                                                                        <span class="avatar-title text-<?= $task['color'] ?>">
                                                                            <i class="<?= $task['icon'] ?>"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-1"><?= $task['title'] ?></h6>
                                                                    <?php if ($task['complete']): ?>
                                                                        <span class="badge bg-success-subtle text-success">
                                                                            <i class="ri-check-line me-1"></i>Completed
                                                                        </span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-warning-subtle text-warning">
                                                                            <i class="ri-time-line me-1"></i>Pending
                                                                        </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Education Tab - Academic Qualifications -->
                        <div class="tab-pane fade" id="education-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-graduation-cap-line me-2 text-primary"></i>
                                            Academic Qualifications
                                        </h5>
                                        <a href="<?= Url::to(['academic-qualification/create']) ?>" class="btn btn-primary">
                                            <i class="ri-add-line me-1"></i> Add Education
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($academicQualifications)): ?>
                                        <div class="section-education">
                                            <?php foreach ($academicQualifications as $education): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-primary text-white">
                                                        <i class="ri-graduation-cap-line"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h5 class="mb-1"><?= Html::encode($education->getDegree()) ?> in <?= Html::encode($education->getFieldOfStudy()) ?></h5>
                                                                <p class="text-muted mb-1">
                                                                    <i class="ri-building-line me-1"></i>
                                                                    <?= Html::encode($education->getInstitutionName()) ?>
                                                                </p>
                                                                <p class="text-muted mb-2">
                                                                    <i class="ri-calendar-line me-1"></i>
                                                                    <?= Html::encode($education->getStartYear()) ?> - <?= Html::encode($education->getEndYear() ?? 'Present') ?>
                                                                </p>
                                                                <?php if ($education->getGrade()): ?>
                                                                    <span class="badge bg-success-subtle text-success">
                                                                        <i class="ri-medal-line me-1"></i>
                                                                        Grade: <?= Html::encode($education->getGrade()) ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="<?= Url::to(['academic-qualification/update', 'id' => $education->getId()]) ?>" class="btn btn-sm btn-outline-primary">
                                                                    <i class="ri-edit-line"></i>
                                                                </a>
                                                                <a href="<?= Url::to(['academic-qualification/delete', 'id' => $education->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-confirm="Are you sure you want to delete this item?">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <img src="/images/education-empty.svg" alt="No education" class="mb-4" height="120">
                                            <h5 class="text-muted mb-3">No Academic Qualifications Found</h5>
                                            <p class="text-muted mb-4">Add your educational background to complete your profile and showcase your qualifications to employers.</p>
                                            <a href="<?= Url::to(['academic-qualification/create']) ?>" class="btn btn-primary">
                                                <i class="ri-add-line me-1"></i> Add Education
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Experience Tab -->
                        <div class="tab-pane fade" id="experience-tab" role="tabpanel">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-briefcase-line me-2 text-success"></i>
                                            Work Experience
                                        </h5>
                                        <a href="<?= Url::to(['work-experience/create']) ?>" class="btn btn-success">
                                            <i class="ri-add-line me-1"></i> Add Experience
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($workExperiences)): ?>
                                        <div class="section-experience">
                                            <?php foreach ($workExperiences as $experience): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-success text-white">
                                                        <i class="ri-briefcase-line"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h5 class="mb-1"><?= Html::encode($experience->getJobTitle()) ?></h5>
                                                                <p class="text-muted mb-1">
                                                                    <i class="ri-building-line me-1"></i>
                                                                    <?= Html::encode($experience->getCompanyName()) ?>, <?= Html::encode($experience->getLocation()) ?>
                                                                </p>
                                                                <p class="text-muted mb-3">
                                                                    <i class="ri-calendar-line me-1"></i>
                                                                    <?= date('M Y', strtotime($experience->getStartDate())) ?> - 
                                                                    <?= $experience->getEndDate() ? date('M Y', strtotime($experience->getEndDate())) : 'Present' ?>
                                                                    <?php 
                                                                        if ($experience->getEndDate()) {
                                                                            $start = new DateTime($experience->getStartDate());
                                                                            $end = new DateTime($experience->getEndDate());
                                                                            $interval = $start->diff($end);
                                                                            $duration = '';
                                                                            if ($interval->y > 0) {
                                                                                $duration .= $interval->y . ' year' . ($interval->y > 1 ? 's ' : ' ');
                                                                            }
                                                                            if ($interval->m > 0) {
                                                                                $duration .= $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
                                                                            }
                                                                            if ($duration) {
                                                                                echo ' · ' . $duration;
                                                                            }
                                                                        }
                                                                    ?>
                                                                </p>
                                                                <?php if ($experience->getDescription()): ?>
                                                                    <p class="mb-0"><?= Html::encode($experience->getDescription()) ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="<?= Url::to(['work-experience/update', 'id' => $experience->getId()]) ?>" class="btn btn-sm btn-outline-success">
                                                                    <i class="ri-edit-line"></i>
                                                                </a>
                                                                <a href="<?= Url::to(['work-experience/delete', 'id' => $experience->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-confirm="Are you sure you want to delete this item?">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <img src="/images/work-empty.svg" alt="No work experience" class="mb-4" height="120">
                                            <h5 class="text-muted mb-3">No Work Experience Found</h5>
                                            <p class="text-muted mb-4">Add your work history to enhance your profile and showcase your professional background.</p>
                                            <a href="<?= Url::to(['work-experience/create']) ?>" class="btn btn-success">
                                                <i class="ri-add-line me-1"></i> Add Experience
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Training & Workshops Section -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-lightbulb-line me-2 text-warning"></i>
                                            Training & Workshops
                                        </h5>
                                        <a href="<?= Url::to(['training-workshop/create']) ?>" class="btn btn-warning">
                                            <i class="ri-add-line me-1"></i> Add Training
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($trainingWorkshops)): ?>
                                        <div class="section-training">
                                            <?php foreach ($trainingWorkshops as $training): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-icon bg-warning text-white">
                                                        <i class="ri-lightbulb-line"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h5 class="mb-1"><?= Html::encode($training->getTitle()) ?></h5>
                                                                <p class="text-muted mb-1">
                                                                    <i class="ri-building-line me-1"></i>
                                                                    <?= Html::encode($training->getInstitution()) ?>, <?= Html::encode($training->getLocation()) ?>
                                                                </p>
                                                                <p class="text-muted mb-2">
                                                                    <i class="ri-calendar-line me-1"></i>
                                                                    <?= date('M Y', strtotime($training->getStartDate())) ?> - 
                                                                    <?= $training->getEndDate() ? date('M Y', strtotime($training->getEndDate())) : 'Present' ?>
                                                                </p>
                                                                <?php if ($training->getDescription()): ?>
                                                                    <p class="mb-0"><?= Html::encode($training->getDescription()) ?></p>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="btn-group">
                                                                <a href="<?= Url::to(['training-workshop/update', 'id' => $training->getId()]) ?>" class="btn btn-sm btn-outline-warning">
                                                                    <i class="ri-edit-line"></i>
                                                                </a>
                                                                <a href="<?= Url::to(['training-workshop/delete', 'id' => $training->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-confirm="Are you sure you want to delete this item?">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <img src="/images/training-empty.svg" alt="No training" class="mb-4" height="120">
                                            <h5 class="text-muted mb-3">No Training or Workshops Found</h5>
                                            <p class="text-muted mb-4">Add your professional development activities to showcase your continuous learning.</p>
                                            <a href="<?= Url::to(['training-workshop/create']) ?>" class="btn btn-warning">
                                                <i class="ri-add-line me-1"></i> Add Training
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Certifications Tab -->
                        <div class="tab-pane fade" id="certifications-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-award-line me-2 text-info"></i>
                                            Professional Certifications
                                        </h5>
                                        <a href="<?= Url::to(['professional-qualification/create']) ?>" class="btn btn-info">
                                            <i class="ri-add-line me-1"></i> Add Certification
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body section-certification">
                                    <?php if (!empty($professionalQualifications)): ?>
                                        <div class="row g-4">
                                            <?php foreach ($professionalQualifications as $cert): ?>
                                                <div class="col-md-6">
                                                    <div class="card h-100 cert-card">
                                                        <div class="card-body p-4">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div class="mb-3">
                                                                    <div class="d-inline-block p-2 rounded-circle bg-info-subtle text-info mb-3">
                                                                        <i class="ri-award-fill fs-4"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="btn-group">
                                                                    <a href="<?= Url::to(['professional-qualification/update', 'id' => $cert->getId()]) ?>" class="btn btn-sm btn-outline-info">
                                                                        <i class="ri-edit-line"></i>
                                                                    </a>
                                                                    <a href="<?= Url::to(['professional-qualification/delete', 'id' => $cert->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-confirm="Are you sure you want to delete this item?">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            
                                                            <h5 class="mb-2"><?= Html::encode($cert->getCertificateName()) ?></h5>
                                                            <p class="text-muted mb-2">
                                                                <i class="ri-building-line me-1"></i>
                                                                <?= Html::encode($cert->getOrganization()) ?>
                                                            </p>
                                                            <p class="text-muted mb-3">
                                                                <i class="ri-calendar-line me-1"></i>
                                                                <?= date('F Y', strtotime($cert->getIssuedDate())) ?>
                                                            </p>
                                                            <?php if ($cert->getDescription()): ?>
                                                                <p class="small mb-0"><?= Html::encode($cert->getDescription()) ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <img src="/images/certification-empty.svg" alt="No certifications" class="mb-4" height="120">
                                            <h5 class="text-muted mb-3">No Professional Certifications Found</h5>
                                            <p class="text-muted mb-4">Add your certifications to showcase your expertise and skills to potential employers.</p>
                                            <a href="<?= Url::to(['professional-qualification/create']) ?>" class="btn btn-info">
                                                <i class="ri-add-line me-1"></i> Add Certification
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Referees Tab -->
                        <div class="tab-pane fade" id="referees-tab" role="tabpanel">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-contacts-line me-2 text-danger"></i>
                                            References
                                        </h5>
                                        <a href="<?= Url::to(['referee/create']) ?>" class="btn btn-danger">
                                            <i class="ri-add-line me-1"></i> Add Referee
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body section-referee">
                                    <?php if (!empty($referees)): ?>
                                        <div class="row g-4">
                                            <?php foreach ($referees as $referee): ?>
                                                <div class="col-md-6">
                                                    <div class="card h-100">
                                                        <div class="card-body p-4">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-md bg-soft-danger rounded-circle">
                                                                        <span class="avatar-title text-danger fs-4">
                                                                            <?= strtoupper(substr($referee->getName(), 0, 1)) ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <h5 class="mb-1"><?= Html::encode($referee->getName()) ?></h5>
                                                                            <p class="text-muted mb-1">
                                                                                <i class="ri-briefcase-line me-1"></i>
                                                                                <?= Html::encode($referee->getPosition()) ?>
                                                                            </p>
                                                                            <p class="text-muted mb-1">
                                                                                <i class="ri-building-line me-1"></i>
                                                                                <?= Html::encode($referee->getCompany()) ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a href="<?= Url::to(['referee/update', 'id' => $referee->getId()]) ?>" class="btn btn-sm btn-outline-danger">
                                                                                <i class="ri-edit-line"></i>
                                                                            </a>
                                                                            <a href="<?= Url::to(['referee/delete', 'id' => $referee->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-confirm="Are you sure you want to delete this referee?">
                                                                                <i class="ri-delete-bin-line"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <hr class="my-2">
                                                                    <div class="d-flex text-muted small">
                                                                        <div class="me-3">
                                                                            <i class="ri-mail-line me-1"></i>
                                                                            <?= Html::encode($referee->getEmail()) ?>
                                                                        </div>
                                                                        <div>
                                                                            <i class="ri-phone-line me-1"></i>
                                                                            <?= Html::encode($referee->getPhone()) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-5">
                                            <img src="/images/referees-empty.svg" alt="No referees" class="mb-4" height="120">
                                            <h5 class="text-muted mb-3">No Referees Found</h5>
                                            <p class="text-muted mb-4">Add professional references to strengthen your profile and build credibility with potential employers.</p>
                                            <a href="<?= Url::to(['referee/create']) ?>" class="btn btn-danger">
                                                <i class="ri-add-line me-1"></i> Add Referee
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- container-fluid -->
            </div><!-- End Page-content -->

            <?php echo $this->render('partials/footer'); ?>
        </div><!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $this->render('partials/customizer'); ?>
    <?php echo $this->render('partials/vendor-scripts'); ?>

    <!-- swiper js -->
    <script src="/libs/swiper/swiper-bundle.min.js"></script>
    <!-- profile init js -->
    <script src="/js/pages/profile.init.js"></script>
    <!-- App js -->
    <script src="/js/app.js"></script>
</body>
</html>
