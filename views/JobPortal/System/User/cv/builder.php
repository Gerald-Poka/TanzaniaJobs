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

$this->title = 'CV Builder - TanzaniaJobs';
$this->params['breadcrumbs'][] = ['label' => 'CV & Resume', 'url' => ['/cv']];
$this->params['breadcrumbs'][] = $this->title;

// Use the JobPortal layout
echo $this->render('../partials/main');
?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title' => 'CV Builder')); ?>
    <?php echo $this->render('../partials/head-css'); ?>
    
    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="<?= Yii::$app->request->getCsrfToken() ?>">
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <style>
        .form-section {
            border-radius: 0.25rem;
            margin-bottom: 1.5rem;
        }

        .form-section-header {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .selectable-item {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .selectable-item:hover {
            border-color: #6366f1;
            background-color: rgba(99, 102, 241, 0.02);
        }

        .selectable-item.selected {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }

        .selectable-item .selection-checkbox {
            float: right;
            margin-top: -5px;
        }

        .cv-preview-container {
            position: sticky;
            top: 100px;
        }

        .cv-preview {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #374151;
            font-size: 14px;
            min-height: 600px;
            padding: 1.5rem;
        }

        .cv-preview h1 {
            color: #1f2937;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .cv-preview h2 {
            color: #4f46e5;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 1.25rem 0 0.75rem 0;
            padding-bottom: 0.375rem;
            border-bottom: 2px solid #4f46e5;
        }

        .cv-preview h3 {
            color: #1f2937;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.375rem;
        }

        .cv-preview .contact-info {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .cv-preview .section-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cv-preview .section-item:last-child {
            border-bottom: none;
        }

        .cv-preview .company-period {
            color: #6b7280;
            font-size: 0.875rem;
            font-style: italic;
        }

        .cv-preview .description {
            color: #4b5563;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .skill-tag, .language-tag {
            display: inline-block;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            padding: 0.25rem 0.75rem;
            border-radius: 1.25rem;
            font-size: 0.75rem;
            margin: 0.125rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 2.5rem 1.25rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .section-toggle {
            cursor: pointer;
        }

        .section-toggle input[type="checkbox"] {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .cv-preview-container {
                position: static;
                margin-top: 1.875rem;
            }
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        
        <?php echo $this->render('../partials/menu'); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">
                                    <i class="ri-file-user-line me-2"></i><?= Html::encode($this->title) ?>
                                </h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="<?= Url::to(['/cv']) ?>">CV & Resume</a></li>
                                        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-8">
                            <form id="cvBuilderForm">
                                <!-- Personal Information -->
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-user-3-line text-primary"></i>
                                            <h5 class="mb-0">Personal Information</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includePersonalInfo" checked disabled>
                                            <label class="form-check-label" for="includePersonalInfo">Include in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" name="firstName" value="<?= Html::encode($user->first_name ?? '') ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" name="lastName" value="<?= Html::encode($user->last_name ?? '') ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" value="<?= Html::encode($user->email) ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone" value="<?= Html::encode($user->phone ?? '') ?>" readonly>
                                                </div>
                                            </div>
                                            <?php if (isset($cvProfile)): ?>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" class="form-control" name="location" value="<?= Html::encode($cvProfile->location ?? '') ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Job Title</label>
                                                    <input type="text" class="form-control" name="job_title" value="<?= Html::encode($cvProfile->job_title ?? '') ?>" readonly>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Professional Summary -->
                                <?php if (isset($cvProfile) && !empty($cvProfile->summary)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-information-line text-info"></i>
                                            <h5 class="mb-0">Professional Summary</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeSummary" checked>
                                            <label class="form-check-label" for="includeSummary">Include in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <textarea class="form-control" name="summary" rows="4" readonly><?= Html::encode($cvProfile->summary) ?></textarea>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Work Experience -->
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-briefcase-4-line text-success"></i>
                                            <h5 class="mb-0">Work Experience</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeExperience" checked>
                                            <label class="form-check-label" for="includeExperience">Include Section in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <?php if (!empty($workExperiences)): ?>
                                            <p class="text-muted mb-3">Select which work experiences to include in your CV:</p>
                                            <?php foreach ($workExperiences as $index => $experience): ?>
                                                <div class="selectable-item" data-item-type="experience" data-item-id="<?= $experience->id ?>">
                                                    <div class="form-check selection-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="selected_experiences[]" value="<?= $experience->id ?>" id="exp_<?= $experience->id ?>" checked>
                                                    </div>
                                                    <h6 class="mb-1"><?= Html::encode($experience->job_title) ?></h6>
                                                    <p class="text-muted mb-1">
                                                        <i class="ri-building-line me-1"></i>
                                                        <?= Html::encode($experience->company_name) ?>, <?= Html::encode($experience->location) ?>
                                                    </p>
                                                    <p class="text-muted mb-2">
                                                        <i class="ri-calendar-line me-1"></i>
                                                        <?= date('M Y', strtotime($experience->start_date)) ?> - 
                                                        <?= $experience->end_date ? date('M Y', strtotime($experience->end_date)) : 'Present' ?>
                                                    </p>
                                                    <?php if ($experience->description): ?>
                                                        <p class="mb-0 small"><?= Html::encode(substr($experience->description, 0, 150)) ?><?= strlen($experience->description) > 150 ? '...' : '' ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center py-4">
                                                <i class="ri-briefcase-line fs-2 text-muted mb-2"></i>
                                                <p class="text-muted mb-3">No work experience found in your profile.</p>
                                                <a href="<?= Url::to(['work-experience/create']) ?>" class="btn btn-sm btn-success">
                                                    <i class="ri-add-line me-1"></i> Add Work Experience
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Education -->
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-graduation-cap-line text-primary"></i>
                                            <h5 class="mb-0">Education</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeEducation" checked>
                                            <label class="form-check-label" for="includeEducation">Include Section in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <?php if (!empty($academicQualifications)): ?>
                                            <p class="text-muted mb-3">Select which educational qualifications to include in your CV:</p>
                                            <?php foreach ($academicQualifications as $education): ?>
                                                <div class="selectable-item" data-item-type="education" data-item-id="<?= $education->id ?>">
                                                    <div class="form-check selection-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="selected_education[]" value="<?= $education->id ?>" id="edu_<?= $education->id ?>" checked>
                                                    </div>
                                                    <h6 class="mb-1"><?= Html::encode($education->degree) ?> in <?= Html::encode($education->field_of_study) ?></h6>
                                                    <p class="text-muted mb-1">
                                                        <i class="ri-building-line me-1"></i>
                                                        <?= Html::encode($education->institution_name) ?>
                                                    </p>
                                                    <p class="text-muted mb-2">
                                                        <i class="ri-calendar-line me-1"></i>
                                                        <?= Html::encode($education->start_year) ?> - <?= Html::encode($education->end_year ?? 'Present') ?>
                                                    </p>
                                                    <?php if ($education->grade): ?>
                                                        <span class="badge bg-success-subtle text-success">
                                                            <i class="ri-medal-line me-1"></i>
                                                            Grade: <?= Html::encode($education->grade) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center py-4">
                                                <i class="ri-graduation-cap-line fs-2 text-muted mb-2"></i>
                                                <p class="text-muted mb-3">No educational qualifications found in your profile.</p>
                                                <a href="<?= Url::to(['academic-qualification/create']) ?>" class="btn btn-sm btn-primary">
                                                    <i class="ri-add-line me-1"></i> Add Education
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Professional Certifications -->
                                <?php if (!empty($professionalQualifications)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-award-line text-info"></i>
                                            <h5 class="mb-0">Professional Certifications</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeCertifications" checked>
                                            <label class="form-check-label" for="includeCertifications">Include Section in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <p class="text-muted mb-3">Select which certifications to include in your CV:</p>
                                        <?php foreach ($professionalQualifications as $cert): ?>
                                            <div class="selectable-item" data-item-type="certification" data-item-id="<?= $cert->id ?>">
                                                <div class="form-check selection-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="selected_certifications[]" value="<?= $cert->id ?>" id="cert_<?= $cert->id ?>" checked>
                                                </div>
                                                <h6 class="mb-1"><?= Html::encode($cert->certificate_name) ?></h6>
                                                <p class="text-muted mb-1">
                                                    <i class="ri-building-line me-1"></i>
                                                    <?= Html::encode($cert->organization) ?>
                                                </p>
                                                <p class="text-muted mb-2">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    <?= date('F Y', strtotime($cert->issued_date)) ?>
                                                </p>
                                                <?php if ($cert->description): ?>
                                                    <p class="mb-0 small"><?= Html::encode(substr($cert->description, 0, 100)) ?><?= strlen($cert->description) > 100 ? '...' : '' ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Training & Workshops -->
                                <?php if (!empty($trainingWorkshops)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-lightbulb-line text-warning"></i>
                                            <h5 class="mb-0">Training & Workshops</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeTraining">
                                            <label class="form-check-label" for="includeTraining">Include Section in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <p class="text-muted mb-3">Select which training/workshops to include in your CV:</p>
                                        <?php foreach ($trainingWorkshops as $training): ?>
                                            <div class="selectable-item" data-item-type="training" data-item-id="<?= $training->id ?>">
                                                <div class="form-check selection-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="selected_training[]" value="<?= $training->id ?>" id="train_<?= $training->id ?>">
                                                </div>
                                                <h6 class="mb-1"><?= Html::encode($training->title) ?></h6>
                                                <p class="text-muted mb-1">
                                                    <i class="ri-building-line me-1"></i>
                                                    <?= Html::encode($training->institution) ?>, <?= Html::encode($training->location) ?>
                                                </p>
                                                <p class="text-muted mb-2">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    <?= date('M Y', strtotime($training->start_date)) ?> - 
                                                    <?= $training->end_date ? date('M Y', strtotime($training->end_date)) : 'Present' ?>
                                                </p>
                                                <?php if ($training->description): ?>
                                                    <p class="mb-0 small"><?= Html::encode(substr($training->description, 0, 100)) ?><?= strlen($training->description) > 100 ? '...' : '' ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Skills -->
                                <?php if (isset($cvProfile) && !empty($cvProfile->skills)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-star-line text-warning"></i>
                                            <h5 class="mb-0">Skills</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeSkills" checked>
                                            <label class="form-check-label" for="includeSkills">Include in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Professional Skills</label>
                                            <textarea class="form-control" name="skills" rows="3" readonly><?= Html::encode(is_array($cvProfile->skills) ? implode(', ', $cvProfile->skills) : $cvProfile->skills) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Languages -->
                                <?php if (isset($cvProfile) && !empty($cvProfile->languages)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-translate-2 text-info"></i>
                                            <h5 class="mb-0">Languages</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeLanguages" checked>
                                            <label class="form-check-label" for="includeLanguages">Include in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Languages</label>
                                            <textarea class="form-control" name="languages" rows="2" readonly><?= Html::encode(is_array($cvProfile->languages) ? implode(', ', $cvProfile->languages) : $cvProfile->languages) ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Referees -->
                                <?php if (!empty($referees)): ?>
                                <div class="form-section card">
                                    <div class="form-section-header card-header">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-contacts-line text-danger"></i>
                                            <h5 class="mb-0">References</h5>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input section-toggle" type="checkbox" id="includeReferees">
                                            <label class="form-check-label" for="includeReferees">Include Section in CV</label>
                                        </div>
                                    </div>
                                    <div class="form-section-body card-body">
                                        <p class="text-muted mb-3">Select which references to include in your CV:</p>
                                        <?php foreach ($referees as $referee): ?>
                                            <div class="selectable-item" data-item-type="referee" data-item-id="<?= $referee->id ?>">
                                                <div class="form-check selection-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="selected_referees[]" value="<?= $referee->id ?>" id="ref_<?= $referee->id ?>">
                                                </div>
                                                <h6 class="mb-1"><?= Html::encode($referee->name) ?></h6>
                                                <p class="text-muted mb-1">
                                                    <i class="ri-briefcase-line me-1"></i>
                                                    <?= Html::encode($referee->position) ?>
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <i class="ri-building-line me-1"></i>
                                                    <?= Html::encode($referee->company) ?>
                                                </p>
                                                <div class="d-flex text-muted small">
                                                    <span class="me-3">
                                                        <i class="ri-mail-line me-1"></i>
                                                        <?= Html::encode($referee->email) ?>
                                                    </span>
                                                    <span>
                                                        <i class="ri-phone-line me-1"></i>
                                                        <?= Html::encode($referee->phone) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Form Actions -->
                                <div class="form-section card">
                                    <div class="form-section-body card-body">
                                        <div class="d-flex justify-content-between">
                                            <a href="<?= Url::to(['/cv']) ?>" class="btn btn-light">
                                                <i class="ri-arrow-left-line me-1"></i> Back to CV Management
                                            </a>
                                            <div>
                                                <button type="button" class="btn btn-primary" id="saveCV">
                                                    <i class="ri-save-line me-1"></i>Save CV
                                                </button>
                                                <button type="button" class="btn btn-secondary me-2" id="showMyCV">
                                                    <i class="ri-eye-line me-1"></i>Show My CV
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- CV Preview Section -->
                        <div class="col-lg-4">
                            <div class="cv-preview-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-eye-line text-primary me-2"></i>Live Preview
                                        </h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="cvPreview" class="cv-preview">
                                            <div class="empty-state">
                                                <i class="ri-file-text-line"></i>
                                                <p>Your CV preview will appear here</p>
                                                <small>Select information to include in your CV</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tips Section -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-lightbulb-line text-warning me-2"></i>CV Building Tips
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">Best Practices:</h6>
                                            <ul class="mb-0 small">
                                                <li>Select relevant experiences for the job</li>
                                                <li>Include recent and important qualifications</li>
                                                <li>Choose skills that match job requirements</li>
                                                <li>Keep it concise (1-2 pages)</li>
                                                <li>Review and proofread before saving</li>
                                            </ul>
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

            <?php echo $this->render('../partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle section toggles
        document.querySelectorAll('.section-toggle').forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                const section = this.closest('.form-section');
                const sectionBody = section.querySelector('.form-section-body');
                
                if (this.checked) {
                    sectionBody.style.display = 'block';
                    section.style.opacity = '1';
                } else {
                    sectionBody.style.display = 'none';
                    section.style.opacity = '0.6';
                }
                updatePreview();
            });
        });

        // Handle item selection
        document.querySelectorAll('.selectable-item').forEach(function(item) {
            const checkbox = item.querySelector('input[type="checkbox"]');
            
            item.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    checkbox.checked = !checkbox.checked;
                    toggleItemSelection(item, checkbox.checked);
                    updatePreview();
                }
            });

            checkbox.addEventListener('change', function() {
                toggleItemSelection(item, this.checked);
                updatePreview();
            });

            // Initialize selection state
            toggleItemSelection(item, checkbox.checked);
        });

        function toggleItemSelection(item, selected) {
            if (selected) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        }

        // FIXED DOWNLOAD PDF BUTTON EVENT LISTENER
        const downloadButton = document.getElementById('downloadPDF');
        if (downloadButton) {
            downloadButton.addEventListener('click', function() {
                const button = this;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="ri-loader-2-line me-1 spinner-border spinner-border-sm"></i>Preparing...';
                
                // Get the CV preview content
                const cvPreview = document.getElementById('cvPreview');
                const cvContent = cvPreview ? cvPreview.innerHTML : '';
                
                // Check if there's content to display
                if (!cvContent || cvContent.includes('empty-state')) {
                    Swal.fire({
                        title: 'No Content',
                        text: 'Please select some information to include in your CV before proceeding.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reset button
                        button.disabled = false;
                        button.innerHTML = originalText;
                    });
                    return;
                }
                
                // Collect selected data to send to controller
                const selectedData = {
                    // Personal info
                    includePersonalInfo: document.getElementById('includePersonalInfo')?.checked || false,
                    
                    // Summary
                    includeSummary: document.getElementById('includeSummary')?.checked || false,
                    
                    // Work Experience
                    includeExperience: document.getElementById('includeExperience')?.checked || false,
                    selectedExperiences: Array.from(document.querySelectorAll('input[name="selected_experiences[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Education
                    includeEducation: document.getElementById('includeEducation')?.checked || false,
                    selectedEducation: Array.from(document.querySelectorAll('input[name="selected_education[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Certifications
                    includeCertifications: document.getElementById('includeCertifications')?.checked || false,
                    selectedCertifications: Array.from(document.querySelectorAll('input[name="selected_certifications[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Training
                    includeTraining: document.getElementById('includeTraining')?.checked || false,
                    selectedTraining: Array.from(document.querySelectorAll('input[name="selected_training[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Skills
                    includeSkills: document.getElementById('includeSkills')?.checked || false,
                    
                    // Languages
                    includeLanguages: document.getElementById('includeLanguages')?.checked || false,
                    
                    // Referees
                    includeReferees: document.getElementById('includeReferees')?.checked || false,
                    selectedReferees: Array.from(document.querySelectorAll('input[name="selected_referees[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // CV Preview Content
                    cvPreviewContent: cvContent
                };
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                
                console.log('Sending data:', selectedData);
                
                // Send data to controller via AJAX
                fetch('/cv/store-builder-data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify(selectedData)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Server response:', data);
                    if (data.success) {
                        // Redirect to templates page with session ID
                        console.log('Redirecting to templates page...');
                        window.location.href = `/cv/templates?session=${data.sessionId}`;
                    } else {
                        throw new Error(data.message || 'Failed to store CV data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to prepare CV data. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    
                    // Reset button
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            });
        } else {
            console.error('Download PDF button not found!');
        }

        // Save CV button handler
        const saveButton = document.getElementById('saveCV');
        if (saveButton) {
            saveButton.addEventListener('click', function() {
                const button = this;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<i class="ri-loader-2-line me-1"></i>Saving...';
                
                // Collect form data
                const formData = {
                    // Personal info
                    includePersonalInfo: document.getElementById('includePersonalInfo')?.checked || false,
                    
                    // Summary
                    includeSummary: document.getElementById('includeSummary')?.checked || false,
                    
                    // Work Experience
                    includeExperience: document.getElementById('includeExperience')?.checked || false,
                    selectedExperiences: Array.from(document.querySelectorAll('input[name="selected_experiences[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Education
                    includeEducation: document.getElementById('includeEducation')?.checked || false,
                    selectedEducation: Array.from(document.querySelectorAll('input[name="selected_education[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Certifications
                    includeCertifications: document.getElementById('includeCertifications')?.checked || false,
                    selectedCertifications: Array.from(document.querySelectorAll('input[name="selected_certifications[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Training
                    includeTraining: document.getElementById('includeTraining')?.checked || false,
                    selectedTraining: Array.from(document.querySelectorAll('input[name="selected_training[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // Skills
                    includeSkills: document.getElementById('includeSkills')?.checked || false,
                    
                    // Languages
                    includeLanguages: document.getElementById('includeLanguages')?.checked || false,
                    
                    // Referees
                    includeReferees: document.getElementById('includeReferees')?.checked || false,
                    selectedReferees: Array.from(document.querySelectorAll('input[name="selected_referees[]"]:checked'))
                        .map(cb => cb.value),
                    
                    // CV Preview Content (if available)
                    cvPreviewContent: document.getElementById('cvPreview')?.innerHTML || ''
                };
                
                // Get CSRF token
                const csrfParam = document.querySelector('meta[name="csrf-param"]')?.getAttribute('content') || '_csrf';
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                
                // Create form data for CSRF
                const postData = new FormData();
                postData.append(csrfParam, csrfToken);
                postData.append('data', JSON.stringify(formData));
                
                // Send data to controller using correct URL format
                fetch('<?= \yii\helpers\Url::to(["/cv/save-cv"]) ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: postData
                })
                .then(response => {
                    // Check if response is ok
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    // Check content type
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server did not return JSON response');
                    }
                    
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Your CV has been saved successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            alert('CV saved successfully!');
                        }
                    } else {
                        throw new Error(data.message || 'Failed to save CV');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to save CV. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Failed to save CV. Please try again.');
                    }
                })
                .finally(() => {
                    // Reset button
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            });
        }

        // Show My CV button handler
        const showMyCVButton = document.getElementById('showMyCV');
        if (showMyCVButton) {
            showMyCVButton.addEventListener('click', function() {
                // Check if user has saved CV data
                fetch('<?= \yii\helpers\Url::to(["/cv/check-saved-cv"]) ?>', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // Check if response is ok
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    // Check content type
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Server did not return JSON response');
                    }
                    
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.hasSavedCV) {
                        // Redirect to view CV page
                        window.location.href = '<?= \yii\helpers\Url::to(["/cv/view-my-cv"]) ?>';
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'No Saved CV',
                                text: 'Please save your CV first before viewing it.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            alert('Please save your CV first before viewing it.');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Unable to check CV status. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Unable to check CV status. Please try again.');
                    }
                });
            });
        }

        function updatePreview() {
            let previewHTML = `
                <div class="cv-preview-content">
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h1><?= Html::encode($user->first_name . ' ' . $user->last_name) ?></h1>
                        <div class="contact-info">
                            <span><i class="ri-mail-line me-1"></i><?= Html::encode($user->email) ?></span>
                            <?php if (isset($user->phone) && $user->phone): ?>
                                <span class="ms-3"><i class="ri-phone-line me-1"></i><?= Html::encode($user->phone) ?></span>
                            <?php endif; ?>
                            <?php if (isset($cvProfile) && $cvProfile && isset($cvProfile->location) && $cvProfile->location): ?>
                                <br><span><i class="ri-map-pin-line me-1"></i><?= Html::encode($cvProfile->location) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
            `;

            // Professional Summary
            if (document.getElementById('includeSummary')?.checked) {
                <?php if (isset($cvProfile) && $cvProfile && !empty($cvProfile->summary)): ?>
                previewHTML += `
                    <div class="mb-4">
                        <h2>Professional Summary</h2>
                        <p><?= Html::encode($cvProfile->summary ?? '') ?></p>
                    </div>
                `;
                <?php endif; ?>
            }

            // Work Experience
            if (document.getElementById('includeExperience')?.checked) {
                const selectedExperiences = Array.from(document.querySelectorAll('input[name="selected_experiences[]"]:checked'));
                if (selectedExperiences.length > 0) {
                    previewHTML += `<h2>Work Experience</h2>`;
                    <?php foreach ($workExperiences as $experience): ?>
                        if (document.getElementById('exp_<?= $experience->id ?>')?.checked) {
                            previewHTML += `
                                <div class="section-item">
                                    <h3><?= Html::encode($experience->job_title) ?></h3>
                                    <div class="company-period">
                                        <?= Html::encode($experience->company_name) ?><?= isset($experience->location) && $experience->location ? ', ' . Html::encode($experience->location) : '' ?>
                                        • <?= date('M Y', strtotime($experience->start_date)) ?> - <?= $experience->end_date ? date('M Y', strtotime($experience->end_date)) : 'Present' ?>
                                    </div>
                                    <?php if (isset($experience->description) && $experience->description): ?>
                                        <div class="description"><?= Html::encode($experience->description) ?></div>
                                    <?php endif; ?>
                                </div>
                            `;
                        }
                    <?php endforeach; ?>
                }
            }

            // Education
            if (document.getElementById('includeEducation')?.checked) {
                const selectedEducation = Array.from(document.querySelectorAll('input[name="selected_education[]"]:checked'));
                if (selectedEducation.length > 0) {
                    previewHTML += `<h2>Education</h2>`;
                    <?php foreach ($academicQualifications as $education): ?>
                        if (document.getElementById('edu_<?= $education->id ?>')?.checked) {
                            previewHTML += `
                                <div class="section-item">
                                    <h3><?= Html::encode($education->degree) ?><?= isset($education->field_of_study) && $education->field_of_study ? ' in ' . Html::encode($education->field_of_study) : '' ?></h3>
                                    <div class="company-period">
                                        <?= Html::encode($education->institution_name) ?>
                                        • <?= Html::encode($education->start_year) ?> - <?= isset($education->end_year) ? Html::encode($education->end_year) : 'Present' ?>
                                        <?php if (isset($education->grade) && $education->grade): ?>
                                            • Grade: <?= Html::encode($education->grade) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            `;
                        }
                    <?php endforeach; ?>
                }
            }

            // Certifications
            if (document.getElementById('includeCertifications')?.checked) {
                const selectedCertifications = Array.from(document.querySelectorAll('input[name="selected_certifications[]"]:checked'));
                if (selectedCertifications.length > 0) {
                    previewHTML += `<h2>Professional Certifications</h2>`;
                    <?php if (!empty($professionalQualifications)): ?>
                        <?php foreach ($professionalQualifications as $cert): ?>
                            if (document.getElementById('cert_<?= $cert->id ?>')?.checked) {
                                previewHTML += `
                                    <div class="section-item">
                                        <h3><?= Html::encode($cert->certificate_name) ?></h3>
                                        <div class="company-period">
                                            <?= Html::encode($cert->organization) ?>
                                            • <?= date('F Y', strtotime($cert->issued_date)) ?>
                                        </div>
                                        <?php if (isset($cert->description) && $cert->description): ?>
                                            <div class="description"><?= Html::encode($cert->description) ?></div>
                                        <?php endif; ?>
                                    </div>
                                `;
                            }
                        <?php endforeach; ?>
                    <?php endif; ?>
                }
            }

            // Training & Workshops
            if (document.getElementById('includeTraining')?.checked) {
                const selectedTraining = Array.from(document.querySelectorAll('input[name="selected_training[]"]:checked'));
                if (selectedTraining.length > 0) {
                    previewHTML += `<h2>Training & Workshops</h2>`;
                    <?php if (!empty($trainingWorkshops)): ?>
                        <?php foreach ($trainingWorkshops as $training): ?>
                            if (document.getElementById('train_<?= $training->id ?>')?.checked) {
                                previewHTML += `
                                    <div class="section-item">
                                        <h3><?= Html::encode($training->title) ?></h3>
                                        <div class="company-period">
                                            <?= Html::encode($training->institution) ?><?= isset($training->location) && $training->location ? ', ' . Html::encode($training->location) : '' ?>
                                            • <?= date('M Y', strtotime($training->start_date)) ?> - <?= $training->end_date ? date('M Y', strtotime($training->end_date)) : 'Present' ?>
                                        </div>
                                        <?php if (isset($training->description) && $training->description): ?>
                                            <div class="description"><?= Html::encode($training->description) ?></div>
                                        <?php endif; ?>
                                    </div>
                                `;
                            }
                        <?php endforeach; ?>
                    <?php endif; ?>
                }
            }

            // Skills
            if (document.getElementById('includeSkills')?.checked) {
                <?php if (isset($cvProfile) && $cvProfile && !empty($cvProfile->skills)): ?>
                    const skillsArray = <?= json_encode(is_array($cvProfile->skills) ? $cvProfile->skills : explode(',', $cvProfile->skills)) ?>;
                    if (skillsArray && skillsArray.length > 0) {
                        previewHTML += `
                            <h2>Skills</h2>
                            <div class="mb-3">
                                ${skillsArray.map(skill => `<span class="skill-tag">${skill.trim()}</span>`).join(' ')}
                            </div>
                        `;
                    }
                <?php endif; ?>
            }

            // Languages
            if (document.getElementById('includeLanguages')?.checked) {
                <?php if (isset($cvProfile) && $cvProfile && !empty($cvProfile->languages)): ?>
                    const languagesArray = <?= json_encode(is_array($cvProfile->languages) ? $cvProfile->languages : explode(',', $cvProfile->languages)) ?>;
                    if (languagesArray && languagesArray.length > 0) {
                        previewHTML += `
                            <h2>Languages</h2>
                            <div class="mb-3">
                                ${languagesArray.map(language => `<span class="language-tag">${language.trim()}</span>`).join(' ')}
                            </div>
                        `;
                    }
                <?php endif; ?>
            }

            // Referees
            if (document.getElementById('includeReferees')?.checked) {
                const selectedReferees = Array.from(document.querySelectorAll('input[name="selected_referees[]"]:checked'));
                if (selectedReferees.length > 0) {
                    previewHTML += `<h2>References</h2>`;
                    <?php if (!empty($referees)): ?>
                        <?php foreach ($referees as $referee): ?>
                            if (document.getElementById('ref_<?= $referee->id ?>')?.checked) {
                                previewHTML += `
                                    <div class="section-item">
                                        <h3><?= Html::encode($referee->name) ?></h3>
                                        <div class="company-period">
                                            <?= Html::encode($referee->position) ?><?= isset($referee->company) && $referee->company ? ' at ' . Html::encode($referee->company) : '' ?>
                                        </div>
                                        <div class="description">
                                            <i class="ri-mail-line me-1"></i><?= Html::encode($referee->email) ?>
                                            <?php if (isset($referee->phone) && $referee->phone): ?>
                                            <br><i class="ri-phone-line me-1"></i><?= Html::encode($referee->phone) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                `;
                            }
                        <?php endforeach; ?>
                    <?php endif; ?>
                }
            }

            previewHTML += `</div>`;
            
            // Update the preview container
            const previewContainer = document.getElementById('cvPreview');
            if (previewContainer) {
                if (previewHTML === '<div class="cv-preview-content"></div>') {
                    previewContainer.innerHTML = `
                        <div class="empty-state text-center py-5">
                            <i class="ri-file-text-line empty-state-icon mb-3"></i>
                            <h4>No content selected</h4>
                            <p class="text-muted">Please select sections and items to include in your CV.</p>
                        </div>
                    `;
                } else {
                    previewContainer.innerHTML = previewHTML;
                }
            }
        }

        // Initialize preview
        updatePreview();
    });
    </script>

    <!-- App js -->
    <script src="/js/app.js"></script>
</body>
</html>