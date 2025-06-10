<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap5\Tabs;
use app\models\ProfessionalQualification;
use app\models\Referee;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var app\models\CVProfile $cvProfile */
/** @var app\models\AcademicQualification[] $academicQualifications */
/** @var app\models\ProfessionalQualification[] $professionalQualifications */
/** @var app\models\WorkExperience[] $workExperiences */
/** @var app\models\TrainingWorkshop[] $trainingWorkshops */
/** @var app\models\Referee[] $referees */
/** @var yii\widgets\ActiveForm $form */

// Add this helper function
function safeEncode($value) {
    if (is_array($value)) {
        return Html::encode(implode(', ', $value));
    }
    if (is_null($value)) {
        return '';
    }
    return Html::encode($value);
}

$this->title = 'Edit Profile - TanzaniaJobs';
$this->params['breadcrumbs'][] = ['label' => 'My Profile', 'url' => ['/user/profile']];
$this->params['breadcrumbs'][] = 'Edit Profile';
?>

<?php echo $this->render('partials/main'); ?>

<head>
    <?php echo $this->render('partials/title-meta', array('title' => 'Edit Profile')); ?>
    <?php echo $this->render('partials/head-css'); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Filepond CSS -->
    <link href="/libs/filepond/filepond.min.css" rel="stylesheet" type="text/css" />
    <link href="/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Custom SweetAlert positioning -->
    <style>
        .swal2-popup-custom {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 9999 !important;
            margin: 0 !important;
        }
        
        .swal2-container {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: 9998 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .swal2-backdrop-show {
            background-color: rgba(0, 0, 0, 0.4) !important;
        }

        .profile-pic-preview {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .profile-pic-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-pic-change {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
            text-align: center;
            padding: 4px;
            color: white;
            cursor: pointer;
            font-size: 12px;
        }

        /* Updated form section styles for dark mode compatibility */
        .form-section {
            border-radius: 0.25rem;
            margin-bottom: 1.5rem;
        }

        .form-section-header {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }

        .form-section-header i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .form-section-body {
            padding: 1.5rem;
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            padding-bottom: 1.5rem;
            border-left: 1px dashed var(--vz-border-color);
            margin-left: 0.5rem;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-item .timeline-icon {
            position: absolute;
            left: -0.65rem;
            top: 0;
            width: 1.3rem;
            height: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.75rem;
        }
        
        .timeline-content {
            padding: 0.5rem 0 0 1rem;
        }
        
        .record-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .nav-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--vz-body-color);
        }
        
        .nav-tabs .nav-link.active {
            color: var(--vz-primary);
            background: transparent;
            border-bottom: 2px solid var(--vz-primary);
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            border-bottom: 2px solid var(--vz-border-color);
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
                <div class="container-fluid">

                    <!-- Page header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Edit Profile</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?= Url::to(['/user/profile']) ?>">My Profile</a></li>
                                        <li class="breadcrumb-item active">Edit Profile</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nav tabs for sections -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <ul class="nav nav-tabs nav-tabs-custom justify-content-center pt-2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active px-3 py-2" data-bs-toggle="tab" href="#personal_info" role="tab">
                                        <i class="ri-user-line me-1 align-middle"></i> Personal Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2" data-bs-toggle="tab" href="#education" role="tab">
                                        <i class="ri-graduation-cap-line me-1 align-middle"></i> Education
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2" data-bs-toggle="tab" href="#experience" role="tab">
                                        <i class="ri-briefcase-line me-1 align-middle"></i> Experience
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2" data-bs-toggle="tab" href="#certificates" role="tab">
                                        <i class="ri-award-line me-1 align-middle"></i> Qualifications
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2" data-bs-toggle="tab" href="#referees" role="tab">
                                        <i class="ri-contacts-line me-1 align-middle"></i> Referees
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab content -->
                    <div class="tab-content">
                        <!-- Personal Info Tab -->
                        <div class="tab-pane active" id="personal_info" role="tabpanel">
                            <?php $form = ActiveForm::begin([
                                'id' => 'profile-form',
                                'options' => [
                                    'enctype' => 'multipart/form-data',
                                    'class' => 'needs-validation',
                                ],
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{hint}\n{error}",
                                    'labelOptions' => ['class' => 'form-label'],
                                    'inputOptions' => ['class' => 'form-control'],
                                    'errorOptions' => ['class' => 'invalid-feedback'],
                                    'options' => ['class' => 'mb-3'],
                                ]
                            ]); ?>

                            <div class="row">
                                <!-- Left Column - Basic Information -->
                                <div class="col-lg-4">
                                    <!-- Profile Picture -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-user-3-line text-primary"></i>
                                            <h5 class="mb-0">Profile Picture</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="profile-pic-preview mx-auto">
                                                <img src="<?= isset($cvProfile) && $cvProfile->profile_picture ? $cvProfile->profile_picture : '/images/users/avatar-1.jpg' ?>" 
                                                    alt="Profile Picture" id="profile-pic-preview">
                                                <div class="profile-pic-change">
                                                    <i class="ri-camera-line me-1"></i> Change
                                                </div>
                                            </div>

                                            <?= $form->field($cvProfile, 'profilePictureFile')->fileInput([
                                                'id' => 'profile-pic-input',
                                                'class' => 'form-control',
                                                'accept' => 'image/*',
                                                'style' => 'display: none;'
                                            ])->label(false) ?>

                                            <div class="text-muted small mt-2">
                                                Recommended: Square image, at least 300x300 pixels
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Settings -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-shield-user-line text-primary"></i>
                                            <h5 class="mb-0">Account Settings</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Email Verification</h6>
                                                    <p class="text-muted mb-0 small">Your email is <?= $user->status == 10 ? 'verified' : 'not verified' ?></p>
                                                </div>
                                                <?php if ($user->status == 10): ?>
                                                    <span class="badge bg-success"><i class="ri-check-line me-1"></i> Verified</span>
                                                <?php else: ?>
                                                    <a href="<?= Url::to(['/user/request-verification']) ?>" class="btn btn-sm btn-outline-primary">
                                                        Verify Now
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Password</h6>
                                                    <p class="text-muted mb-0 small">Last changed: <?= date('M d, Y', $user->updated_at) ?></p>
                                                </div>
                                                <a href="<?= Url::to(['/user/change-password']) ?>" class="btn btn-sm btn-outline-primary">
                                                    Change
                                                </a>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">Account Privacy</h6>
                                                    <p class="text-muted mb-0 small">Manage your profile visibility</p>
                                                </div>
                                                <a href="<?= Url::to(['/user/privacy-settings']) ?>" class="btn btn-sm btn-outline-primary">
                                                    Settings
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - User Details -->
                                <div class="col-lg-8">
                                    <!-- Personal Information -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-user-settings-line text-primary"></i>
                                            <h5 class="mb-0">Personal Information</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $form->field($user, 'first_name')->textInput(['maxlength' => true]) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($user, 'last_name')->textInput(['maxlength' => true]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $form->field($user, 'email')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($user, 'phone')->textInput(['maxlength' => true]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'location')->textInput([
                                                        'placeholder' => 'e.g., Dar es Salaam, Tanzania',
                                                        'class' => 'form-control'
                                                    ]) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'date_of_birth')->textInput([
                                                        'class' => 'form-control',
                                                        'type' => 'date'
                                                    ]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'gender')->dropDownList([
                                                        'Male' => 'Male',
                                                        'Female' => 'Female',
                                                        'Other' => 'Other'
                                                    ], [
                                                        'prompt' => 'Select Gender',
                                                        'class' => 'form-select'
                                                    ]) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'nationality')->textInput([
                                                        'placeholder' => 'e.g., Tanzanian',
                                                        'class' => 'form-control'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Professional Information -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-briefcase-3-line text-primary"></i>
                                            <h5 class="mb-0">Professional Information</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'job_title')->textInput([
                                                        'placeholder' => 'e.g., Software Developer',
                                                        'class' => 'form-control'
                                                    ]) ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($cvProfile, 'years_of_experience')->dropDownList([
                                                        'Less than 1 year' => 'Less than 1 year',
                                                        '1-2 years' => '1-2 years',
                                                        '3-5 years' => '3-5 years',
                                                        '6-10 years' => '6-10 years',
                                                        'More than 10 years' => 'More than 10 years'
                                                    ], [
                                                        'prompt' => 'Select Experience',
                                                        'class' => 'form-select'
                                                    ]) ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <?= $form->field($cvProfile, 'summary')->textarea(['rows' => 4, 'placeholder' => 'Write a brief professional summary about yourself...']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skills and Languages -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-tools-line text-primary"></i>
                                            <h5 class="mb-0">Skills & Languages</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?= $form->field($cvProfile, 'skills')->textarea([
                                                        'rows' => 2, 
                                                        'placeholder' => 'Enter skills separated by commas (e.g., Project Management, Software Development, Data Analysis)'
                                                    ])->hint('Add your key professional skills separated by commas.') ?>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <?= $form->field($cvProfile, 'languages')->textarea([
                                                        'rows' => 2, 
                                                        'placeholder' => 'Enter languages separated by commas (e.g., English (Fluent), Swahili (Native), French (Basic))'
                                                    ])->hint('List languages you speak and your proficiency level.') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Media Links -->
                                    <div class="form-section card">
                                        <div class="form-section-header card-header">
                                            <i class="ri-links-line text-primary"></i>
                                            <h5 class="mb-0">Social & Professional Links</h5>
                                        </div>
                                        <div class="form-section-body card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="ri-linkedin-box-fill text-primary"></i></span>
                                                        <?= $form->field($cvProfile, 'linkedin_url', [
                                                            'template' => "{input}\n{hint}\n{error}",
                                                            'options' => ['class' => ''],
                                                        ])->textInput(['placeholder' => 'LinkedIn Profile URL']) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="ri-github-fill text-dark"></i></span>
                                                        <?= $form->field($cvProfile, 'github_url', [
                                                            'template' => "{input}\n{hint}\n{error}",
                                                            'options' => ['class' => ''],
                                                        ])->textInput(['placeholder' => 'GitHub Profile URL']) ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="ri-global-line text-success"></i></span>
                                                        <?= $form->field($cvProfile, 'website_url', [
                                                            'template' => "{input}\n{hint}\n{error}",
                                                            'options' => ['class' => ''],
                                                        ])->textInput(['placeholder' => 'Personal Website URL']) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="ri-twitter-x-fill text-dark"></i></span>
                                                        <?= $form->field($cvProfile, 'twitter_url', [
                                                            'template' => "{input}\n{hint}\n{error}",
                                                            'options' => ['class' => ''],
                                                        ])->textInput(['placeholder' => 'Twitter/X Profile URL']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section card">
                                        <div class="form-section-body card-body">
                                            <div class="d-flex justify-content-between">
                                                <a href="<?= Url::to(['/user/profile']) ?>" class="btn btn-light">
                                                    <i class="ri-arrow-left-line me-1"></i> Cancel
                                                </a>
                                                <?= Html::submitButton('<i class="ri-save-line me-1"></i> Save Personal Information', ['class' => 'btn btn-primary']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>

                        <!-- Education Tab -->
                        <div class="tab-pane" id="education" role="tabpanel">
                            <!-- Academic Qualifications -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-graduation-cap-line me-2 text-primary"></i>Academic Qualifications
                                            </h5>
                                            <a href="<?= Url::to(['/academic-qualification/create']) ?>" class="btn btn-primary btn-sm">
                                                <i class="ri-add-line me-1"></i> Add Qualification
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($academicQualifications) && !empty($academicQualifications)): ?>
                                                <div class="record-list">
                                                    <?php foreach ($academicQualifications as $index => $qualification): ?>
                                                        <div class="timeline-item">
                                                            <div class="timeline-icon bg-primary text-white">
                                                                <i class="ri-graduation-cap-line"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h5 class="mb-1"><?= safeEncode($qualification->degree) ?> in <?= safeEncode($qualification->field_of_study) ?></h5>
                                                                        <p class="text-muted mb-1"><?= safeEncode($qualification->institution_name) ?></p>
                                                                        <p class="text-muted mb-2">
                                                                            <i class="ri-calendar-line me-1"></i>
                                                                            <?= safeEncode($qualification->start_year) ?> - <?= safeEncode($qualification->end_year ?: 'Present') ?>
                                                                        </p>
                                                                        <?php if ($qualification->grade): ?>
                                                                            <span class="badge bg-success-subtle text-success">Grade: <?= safeEncode($qualification->grade) ?></span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a href="<?= Url::to(['/academic-qualification/update', 'id' => $qualification->id]) ?>" class="btn btn-sm btn-outline-primary">
                                                                            <i class="ri-edit-line"></i>
                                                                        </a>
                                                                        <a href="<?= Url::to(['/academic-qualification/delete', 'id' => $qualification->id]) ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" data-method="post" data-confirm="Are you sure you want to delete this qualification?">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center p-4">
                                                    <div class="avatar-md mx-auto mb-4">
                                                        <div class="avatar-title bg-light rounded-circle text-primary fs-2">
                                                            <i class="ri-graduation-cap-line"></i>
                                                        </div>
                                                    </div>
                                                    <h5>No academic qualifications found</h5>
                                                    <p class="text-muted">Add your educational background to strengthen your profile</p>
                                                    <a href="<?= Url::to(['/academic-qualification/create']) ?>" class="btn btn-primary">
                                                        <i class="ri-add-line me-1"></i> Add Qualification
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Experience Tab -->
                        <div class="tab-pane" id="experience" role="tabpanel">
                            <!-- Work Experience -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-briefcase-line me-2 text-success"></i>Work Experience
                                            </h5>
                                            <a href="<?= Url::to(['/work-experience/create']) ?>" class="btn btn-success btn-sm">
                                                <i class="ri-add-line me-1"></i> Add Experience
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($workExperiences) && !empty($workExperiences)): ?>
                                                <div class="record-list">
                                                    <?php foreach ($workExperiences as $index => $experience): ?>
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
                                                                        <p class="text-muted mb-2">
                                                                            <i class="ri-calendar-line me-1"></i>
                                                                            <?= date('M Y', strtotime($experience->getStartDate())) ?> - 
                                                                            <?= $experience->getEndDate() ? date('M Y', strtotime($experience->getEndDate())) : 'Present' ?>
                                                                        </p>
                                                                        <?php if ($experience->getDescription()): ?>
                                                                            <p class="mb-0 text-muted"><?= Html::encode($experience->getDescription()) ?></p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a href="<?= Url::to(['/work-experience/update', 'id' => $experience->getId()]) ?>" class="btn btn-sm btn-outline-success">
                                                                            <i class="ri-edit-line"></i>
                                                                        </a>
                                                                        <a href="<?= Url::to(['/work-experience/delete', 'id' => $experience->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" data-method="post" data-confirm="Are you sure you want to delete this experience?">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center p-4">
                                                    <div class="avatar-md mx-auto mb-4">
                                                        <div class="avatar-title bg-light rounded-circle text-success fs-2">
                                                            <i class="ri-briefcase-line"></i>
                                                        </div>
                                                    </div>
                                                    <h5>No work experience found</h5>
                                                    <p class="text-muted">Add your work history to enhance your profile</p>
                                                    <a href="<?= Url::to(['/work-experience/create']) ?>" class="btn btn-success">
                                                        <i class="ri-add-line me-1"></i> Add Experience
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Training Workshops -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-lightbulb-line me-2 text-warning"></i>Training & Workshops
                                            </h5>
                                            <a href="<?= Url::to(['/training-workshop/create']) ?>" class="btn btn-warning btn-sm">
                                                <i class="ri-add-line me-1"></i> Add Training
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($trainingWorkshops) && !empty($trainingWorkshops)): ?>
                                                <div class="record-list">
                                                    <?php foreach ($trainingWorkshops as $index => $training): ?>
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
                                                                            <p class="mb-0 text-muted"><?= Html::encode($training->getDescription()) ?></p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <a href="<?= Url::to(['/training-workshop/update', 'id' => $training->getId()]) ?>" class="btn btn-sm btn-outline-warning">
                                                                            <i class="ri-edit-line"></i>
                                                                        </a>
                                                                        <a href="<?= Url::to(['/training-workshop/delete', 'id' => $training->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" data-method="post" data-confirm="Are you sure you want to delete this training?">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center p-4">
                                                    <div class="avatar-md mx-auto mb-4">
                                                        <div class="avatar-title bg-light rounded-circle text-warning fs-2">
                                                            <i class="ri-lightbulb-line"></i>
                                                        </div>
                                                    </div>
                                                    <h5>No training or workshops found</h5>
                                                    <p class="text-muted">Add your professional development activities</p>
                                                    <a href="<?= Url::to(['/training-workshop/create']) ?>" class="btn btn-warning">
                                                        <i class="ri-add-line me-1"></i> Add Training
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certificates Tab -->
                        <div class="tab-pane" id="certificates" role="tabpanel">
                            <!-- Professional Qualifications -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-award-line me-2 text-info"></i>Professional Certifications
                                            </h5>
                                            <a href="<?= Url::to(['/professional-qualification/create']) ?>" class="btn btn-info btn-sm">
                                                <i class="ri-add-line me-1"></i> Add Certification
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($professionalQualifications) && !empty($professionalQualifications)): ?>
                                                <div class="row g-3">
                                                    <?php foreach ($professionalQualifications as $certification): ?>
                                                        <div class="col-md-6">
                                                            <div class="card border h-100">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <h5 class="mb-2"><?= Html::encode($certification->getCertificateName()) ?></h5>
                                                                            <p class="text-muted mb-2">
                                                                                <i class="ri-building-line me-1"></i>
                                                                                <?= Html::encode($certification->getOrganization()) ?>
                                                                            </p>
                                                                            <p class="text-muted mb-2">
                                                                                <i class="ri-calendar-line me-1"></i>
                                                                                <?= date('F Y', strtotime($certification->getIssuedDate())) ?>
                                                                            </p>
                                                                            <?php if ($certification->getDescription()): ?>
                                                                                <p class="small mb-0 text-muted"><?= Html::encode($certification->getDescription()) ?></p>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a href="<?= Url::to(['/professional-qualification/update', 'id' => $certification->getId()]) ?>" class="btn btn-sm btn-outline-info">
                                                                                <i class="ri-edit-line"></i>
                                                                            </a>
                                                                            <a href="<?= Url::to(['/professional-qualification/delete', 'id' => $certification->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" data-method="post" data-confirm="Are you sure you want to delete this certification?">
                                                                                <i class="ri-delete-bin-line"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center p-4">
                                                    <div class="avatar-md mx-auto mb-4">
                                                        <div class="avatar-title bg-light rounded-circle text-info fs-2">
                                                            <i class="ri-award-line"></i>
                                                        </div>
                                                    </div>
                                                    <h5>No professional certifications found</h5>
                                                    <p class="text-muted">Add your certifications to showcase your expertise</p>
                                                    <a href="<?= Url::to(['/professional-qualification/create']) ?>" class="btn btn-info">
                                                        <i class="ri-add-line me-1"></i> Add Certification
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Referees Tab -->
                        <div class="tab-pane" id="referees" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">
                                                <i class="ri-contacts-line me-2 text-danger"></i>References
                                            </h5>
                                            <a href="<?= Url::to(['/referee/create']) ?>" class="btn btn-danger btn-sm">
                                                <i class="ri-add-line me-1"></i> Add Referee
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <?php if (isset($referees) && !empty($referees)): ?>
                                                <div class="row g-3">
                                                    <?php foreach ($referees as $referee): ?>
                                                        <div class="col-md-6">
                                                            <div class="card border h-100">
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div>
                                                                            <h5 class="mb-1"><?= Html::encode($referee->getName()) ?></h5>
                                                                            <p class="text-muted mb-1">
                                                                                <i class="ri-briefcase-line me-1"></i>
                                                                                <?= Html::encode($referee->getPosition()) ?> at <?= Html::encode($referee->getCompany()) ?>
                                                                            </p>
                                                                            <p class="text-muted mb-1">
                                                                                <i class="ri-mail-line me-1"></i>
                                                                                <?= Html::encode($referee->getEmail()) ?>
                                                                            </p>
                                                                            <p class="text-muted mb-0">
                                                                                <i class="ri-phone-line me-1"></i>
                                                                                <?= Html::encode($referee->getPhone()) ?>
                                                                            </p>
                                                                        </div>
                                                                        <div class="btn-group">
                                                                            <a href="<?= Url::to(['/referee/update', 'id' => $referee->getId()]) ?>" class="btn btn-sm btn-outline-danger">
                                                                                <i class="ri-edit-line"></i>
                                                                            </a>
                                                                            <a href="<?= Url::to(['/referee/delete', 'id' => $referee->getId()]) ?>" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-title="Delete" data-method="post" data-confirm="Are you sure you want to delete this referee?">
                                                                                <i class="ri-delete-bin-line"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center p-4">
                                                    <div class="avatar-md mx-auto mb-4">
                                                        <div class="avatar-title bg-light rounded-circle text-danger fs-2">
                                                            <i class="ri-contacts-line"></i>
                                                        </div>
                                                    </div>
                                                    <h5>No referees found</h5>
                                                    <p class="text-muted">Add your professional references to strengthen your profile</p>
                                                    <a href="<?= Url::to(['/referee/create']) ?>" class="btn btn-danger">
                                                        <i class="ri-add-line me-1"></i> Add Referee
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php echo $this->render('partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $this->render('partials/customizer'); ?>
    <?php echo $this->render('partials/vendor-scripts'); ?>

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Existing scripts remain unchanged -->
    <script src="/libs/filepond/filepond.min.js"></script>
    <script src="/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages and show SweetAlert with custom styling
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        Swal.fire({
            title: 'Success!',
            text: '<?= Yii::$app->session->getFlash('success') ?>',
            icon: 'success',
            timer: 3000,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            position: 'center',
            backdrop: true,
            allowOutsideClick: true,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'btn btn-success w-xs',
            },
            buttonsStyling: false,
            didOpen: () => {
                const popup = Swal.getPopup();
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
            }
        });
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        Swal.fire({
            title: 'Error!',
            text: '<?= Yii::$app->session->getFlash('error') ?>',
            icon: 'error',
            showConfirmButton: true,
            confirmButtonText: 'OK',
            position: 'center',
            backdrop: true,
            allowOutsideClick: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'btn btn-danger w-xs',
            },
            buttonsStyling: false,
            didOpen: () => {
                const popup = Swal.getPopup();
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
            }
        });
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('warning')): ?>
        Swal.fire({
            title: 'Warning!',
            text: '<?= Yii::$app->session->getFlash('warning') ?>',
            icon: 'warning',
            showConfirmButton: true,
            confirmButtonText: 'OK',
            position: 'center',
            backdrop: true,
            allowOutsideClick: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'btn btn-warning w-xs',
            },
            buttonsStyling: false,
            didOpen: () => {
                const popup = Swal.getPopup();
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
            }
        });
    <?php endif; ?>

    // Profile picture change functionality
    const profilePicChange = document.querySelector('.profile-pic-change');
    if (profilePicChange) {
        profilePicChange.addEventListener('click', function() {
            document.getElementById('profile-pic-input').click();
        });
    }

    // Handle traditional file input (as backup)
    const profilePicInput = document.getElementById('profile-pic-input');
    if (profilePicInput) {
        profilePicInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-pic-preview').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    // Initialize FilePond only if library is loaded
    if (typeof FilePond !== 'undefined') {
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateSize,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateType
        );

        const inputElement = document.getElementById('profile-pic-input');
        if (inputElement) {
            const pond = FilePond.create(inputElement, {
                allowMultiple: false,
                acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg'],
                imagePreviewHeight: 170,
                labelIdle: 'Drag & drop your picture or <span class="filepond--label-action">Browse</span>',
                stylePanelLayout: 'compact circle',
                styleLoadIndicatorPosition: 'center bottom',
                styleButtonRemoveItemPosition: 'center bottom',
                onaddfile: (error, file) => {
                    if (!error) {
                        // Preview the image
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const previewImg = document.getElementById('profile-pic-preview');
                            if (previewImg) {
                                previewImg.src = e.target.result;
                            }
                        };
                        reader.readAsDataURL(file.file);
                    }
                }
            });
        }
    }

    // Handle tab navigation from URL hash
    let activeTab = window.location.hash;
    if (activeTab) {
        activeTab = activeTab.replace('#', '');
        const tabElement = document.querySelector('.nav-link[href="#' + activeTab + '"]');
        if (tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
        }
    }

    // Handle form submission with loading state
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="ri-loader-2-line me-1 spinner-border spinner-border-sm"></i> Saving...';
            }
        });
    }

    // Handle tab changes and update URL hash
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const targetTab = e.target.getAttribute('href');
            window.location.hash = targetTab;
        });
    });

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});

// Add delete confirmations and edit button handling
document.addEventListener('click', function(e) {
    // Handle delete confirmations
    if (e.target.closest('a[data-confirm]')) {
        e.preventDefault();
        const link = e.target.closest('a[data-confirm]');
        const message = link.getAttribute('data-confirm');
        
        Swal.fire({
            title: 'Are you sure?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            position: 'center',
            backdrop: true,
            allowOutsideClick: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'btn btn-danger w-xs me-2',
                cancelButton: 'btn btn-secondary w-xs',
            },
            buttonsStyling: false,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            didOpen: () => {
                const popup = Swal.getPopup();
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    position: 'center',
                    customClass: {
                        popup: 'swal2-popup-custom',
                    },
                    didOpen: () => {
                        Swal.showLoading();
                        const popup = Swal.getPopup();
                        popup.style.position = 'fixed';
                        popup.style.top = '50%';
                        popup.style.left = '50%';
                        popup.style.transform = 'translate(-50%, -50%)';
                        popup.style.zIndex = '9999';
                    }
                });

                // Create and submit form for POST request
                if (link.getAttribute('data-method') === 'post') {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = link.href;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    window.location.href = link.href;
                }
            }
        });
    }

    // Handle edit button clicks
    if (e.target.closest('a[href*="/update"]')) {
        const editButton = e.target.closest('a[href*="/update"]');
        
        // Add loading state to edit button
        editButton.innerHTML = '<i class="ri-loader-2-line spinner-border spinner-border-sm"></i>';
        editButton.classList.add('disabled');
        
        // Let the default navigation proceed
        return true;
    }
});
</script>

<!-- App js -->
<script src="/js/app.js"></script>
</body>
</html>