<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var app\models\CVProfile $cvProfile */
/** @var app\models\CVDocument $selectedCV */
/** @var app\models\CVDocument[] $savedCVs */
/** @var array $cvData */
/** @var app\models\WorkExperience[] $workExperiences */
/** @var app\models\AcademicQualification[] $academicQualifications */
/** @var app\models\ProfessionalQualification[] $professionalQualifications */
/** @var app\models\TrainingWorkshop[] $trainingWorkshops */
/** @var app\models\Referee[] $referees */

$this->title = 'CV Templates - TanzaniaJobs';
$this->params['breadcrumbs'][] = ['label' => 'CV & Resume', 'url' => ['/cv']];
$this->params['breadcrumbs'][] = ['label' => 'CV Builder', 'url' => ['/cv/builder']];
$this->params['breadcrumbs'][] = $this->title;

// Use the JobPortal layout
echo $this->render('../partials/main');
?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title' => 'CV Templates')); ?>
    <?php echo $this->render('../partials/head-css'); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <style>
        .template-card {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .template-card:hover {
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
            transform: translateY(-2px);
        }

        .template-card.selected {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.05);
        }

        .cv-display {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #374151;
            font-size: 14px;
            min-height: 600px;
            padding: 1.5rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            position: relative; /* Added for watermark positioning */
        }

        .cv-display h1 {
            color: #1f2937;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .cv-display h2 {
            color: #4f46e5;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 1.25rem 0 0.75rem 0;
            padding-bottom: 0.375rem;
            border-bottom: 2px solid #4f46e5;
        }

        .cv-display h3 {
            color: #1f2937;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.375rem;
        }

        .cv-display .contact-info {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            text-align: center;
        }

        .cv-display .section-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cv-display .section-item:last-child {
            border-bottom: none;
        }

        .cv-display .company-period {
            color: #6b7280;
            font-size: 0.875rem;
            font-style: italic;
        }

        .cv-display .description {
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

        /* Template Styles */
        .template-classic h2 {
            color: #4f46e5;
            border-bottom-color: #4f46e5;
        }

        .template-modern h2 {
            color: #059669;
            border-bottom-color: #059669;
            border-bottom: none;
            background: linear-gradient(135deg, #059669, #34d399);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .template-modern h1 {
            background: linear-gradient(135deg, #059669, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: left;
            border-left: 4px solid #059669;
            padding-left: 1rem;
        }

        .template-modern .contact-info {
            text-align: left;
            background: #f0fdf4;
            padding: 1rem;
            border-radius: 0.375rem;
            border-left: 4px solid #059669;
            margin-bottom: 1.5rem;
        }

        .template-modern .section-item {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.375rem;
            border: none;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .template-modern .skill-tag, .template-modern .language-tag {
            background: linear-gradient(135deg, #059669, #34d399);
            color: white;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
        }

        .template-modern h3 {
            color: #059669;
            font-weight: 700;
        }

        .template-professional h2 {
            color: #1e40af;
            border-bottom-color: #1e40af;
        }

        /* Professional Template Specific Styles - Enhanced */
        .template-professional {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 0;
            padding: 0 !important;
            min-height: 800px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .template-professional .left-column {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            padding: 2rem 1.5rem;
            color: white;
        }

        .template-professional .right-column {
            padding: 2rem 2.5rem;
            background: white;
        }

        .template-professional .left-column h2 {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            margin-top: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }

        .template-professional .left-column h2:first-child {
            margin-top: 0;
        }

        .template-professional .right-column h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-align: left;
            line-height: 1.2;
        }

        .template-professional .right-column h2 {
            color: #2c3e50;
            font-size: 1.125rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            margin: 2rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #2c3e50;
        }

        .template-professional .current-position {
            color: #7f8c8d;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .template-professional .left-column .contact-item {
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            line-height: 1.5;
            color: rgba(255, 255, 255, 0.9);
        }

        .template-professional .left-column .contact-item i {
            color: #3498db;
            width: 16px;
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .template-professional .skills-section {
            margin-bottom: 1.5rem;
        }

        .template-professional .skills-category {
            margin-bottom: 1rem;
        }

        .template-professional .skills-category h3 {
            color: #3498db;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .template-professional .skill-item {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            line-height: 1.4;
            margin-bottom: 0.25rem;
        }

        .template-professional .language-item {
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .template-professional .language-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .template-professional .language-level {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .template-professional .section-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #ecf0f1;
        }

        .template-professional .section-item:last-child {
            border-bottom: none;
        }

        .template-professional .section-item h3 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .template-professional .company-info {
            color: #3498db;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .template-professional .period-location {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
        }

        .template-professional .description {
            color: #2c3e50;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .template-professional .summary-text {
            color: #2c3e50;
            line-height: 1.7;
            font-size: 0.95rem;
            text-align: justify;
        }

        .template-professional .reference-item {
            margin-bottom: 1rem;
        }

        .template-professional .reference-name {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .template-professional .reference-title {
            color: #3498db;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .template-professional .reference-contact {
            color: #7f8c8d;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        /* Watermark Styles for All Templates */
        .cv-watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
            font-weight: 100;
            color: rgba(0, 0, 0, 0.03);
            z-index: 1;
            pointer-events: none;
            white-space: nowrap;
            user-select: none;
        }

        /* Ensure content appears above watermark */
        .cv-display > * {
            position: relative;
            z-index: 2;
        }

        /* Template-specific watermark adjustments */
        .template-professional .cv-watermark {
            font-size: 5rem;
            color: rgba(44, 62, 80, 0.05);
        }

        .template-modern .cv-watermark {
            font-size: 4.5rem;
            color: rgba(5, 150, 105, 0.04);
        }

        .template-classic .cv-watermark {
            font-size: 4rem;
            color: rgba(79, 70, 229, 0.03);
        }

        /* Professional template specific watermark positioning */
        .template-professional {
            position: relative;
        }

        .template-professional .cv-watermark {
            position: absolute;
            top: 40%;
            left: 60%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.08);
            z-index: 1;
        }

        .template-professional .left-column,
        .template-professional .right-column {
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .template-professional {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .template-professional .left-column {
                order: 2;
            }
            
            .template-professional .right-column {
                order: 1;
            }

            .template-professional .right-column h1 {
                font-size: 2rem;
            }
        }

        @media print {
            .no-print { display: none !important; }
            .cv-display { 
                font-size: 12px; 
                border: none !important;
                padding: 0 !important;
            }
            .cv-watermark {
                font-size: 3rem;
                color: rgba(0, 0, 0, 0.02) !important;
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
                                    <i class="ri-file-text-line me-2"></i>CV Templates - <?= Html::encode($selectedCV->name) ?>
                                </h4>
                                <div class="page-title-right">
                                    <div class="btn-group">
                                        <a href="<?= Url::to(['/cv/builder']) ?>" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Back to Builder
                                        </a>
                                        <button type="button" class="btn btn-success" id="downloadPDF">
                                            <i class="ri-download-line me-1"></i>Download PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <!-- CV Display -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-eye-line text-primary me-2"></i>CV Preview
                                        </h5>
                                        <div class="no-print">
                                            <span class="badge bg-info" id="currentTemplate">Classic Template</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div id="cvDisplay" class="cv-display template-classic">
                                        <!-- CV content will be loaded here -->
                                        <div class="text-center py-5">
                                            <i class="ri-loader-2-line fs-2 text-muted"></i>
                                            <p class="text-muted mt-2">Loading CV...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            
                            <!-- Saved CVs -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-list-line text-success me-2"></i>My Saved CVs
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($savedCVs)): ?>
                                        <?php foreach ($savedCVs as $cv): ?>
                                            <div class="saved-cv-card <?= $cv->id == $selectedCV->id ? 'active' : '' ?>" 
                                                 onclick="loadCV(<?= $cv->id ?>)" 
                                                 data-cv-id="<?= $cv->id ?>">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?= Html::encode($cv->name) ?></h6>
                                                        <small class="text-muted">
                                                            <i class="ri-calendar-line me-1"></i>
                                                            <?= date('M d, Y g:i A', strtotime($cv->updated_at)) ?>
                                                        </small>
                                                    </div>
                                                    <?php if ($cv->id == $selectedCV->id): ?>
                                                        <span class="badge bg-success-subtle text-success">Current</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-3">
                                            <i class="ri-file-text-line fs-2 text-muted"></i>
                                            <p class="text-muted mt-2">No saved CVs found</p>
                                            <a href="<?= Url::to(['/cv/builder']) ?>" class="btn btn-sm btn-primary">
                                                <i class="ri-add-line me-1"></i>Create CV
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Template Selection -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-palette-line text-warning me-2"></i>Choose Template
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Classic Template -->
                                        <div class="col-12">
                                            <div class="template-card card selected" data-template="classic">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="text-primary mb-2">Classic Template</h6>
                                                    <small class="text-muted">Professional and clean design</small>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="template" id="template-classic" value="classic" checked>
                                                        <label class="form-check-label" for="template-classic">
                                                            Select Classic
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modern Template -->
                                        <div class="col-12">
                                            <div class="template-card card" data-template="modern">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="text-success mb-2">Modern Template</h6>
                                                    <small class="text-muted">Contemporary and stylish</small>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="template" id="template-modern" value="modern">
                                                        <label class="form-check-label" for="template-modern">
                                                            Select Modern
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Professional Template -->
                                        <div class="col-12">
                                            <div class="template-card card" data-template="professional">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="text-info mb-2">Professional Template</h6>
                                                    <small class="text-muted">Corporate and formal</small>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="template" id="template-professional" value="professional">
                                                        <label class="form-check-label" for="template-professional">
                                                            Select Professional
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Creative Template -->
                                        <div class="col-12">
                                            <div class="template-card card" data-template="creative">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="text-danger mb-2">Creative Template</h6>
                                                    <small class="text-muted">Bold and artistic</small>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="template" id="template-creative" value="creative">
                                                        <label class="form-check-label" for="template-creative">
                                                            Select Creative
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Minimal Template -->
                                        <div class="col-12">
                                            <div class="template-card card" data-template="minimal">
                                                <div class="card-body text-center py-3">
                                                    <h6 class="text-secondary mb-2">Minimal Template</h6>
                                                    <small class="text-muted">Simple and elegant</small>
                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="radio" name="template" id="template-minimal" value="minimal">
                                                        <label class="form-check-label" for="template-minimal">
                                                            Select Minimal
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Template Info Card -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-information-line text-info me-2"></i>Template Info
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div id="templateInfo">
                                        <h6 class="text-primary">Classic Template</h6>
                                        <p class="text-muted mb-2">A professional and clean design perfect for most industries. Features clear sections and easy-to-read formatting.</p>
                                        <div class="text-muted small">
                                            <i class="ri-check-line text-success me-1"></i>Professional appearance<br>
                                            <i class="ri-check-line text-success me-1"></i>ATS-friendly format<br>
                                            <i class="ri-check-line text-success me-1"></i>Clean typography
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CV Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-info-line text-warning me-2"></i>CV Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td class="text-muted">CV Name:</td>
                                                <td><?= Html::encode($selectedCV->name) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Created:</td>
                                                <td><?= date('M d, Y', strtotime($selectedCV->created_at)) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Last Updated:</td>
                                                <td><?= date('M d, Y', strtotime($selectedCV->updated_at)) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Sections:</td>
                                                <td>
                                                    <?php 
                                                    $sections = [];
                                                    if (isset($cvData['includePersonalInfo']) && $cvData['includePersonalInfo']) $sections[] = 'Personal';
                                                    if (isset($cvData['includeSummary']) && $cvData['includeSummary']) $sections[] = 'Summary';
                                                    if (isset($cvData['includeExperience']) && $cvData['includeExperience']) $sections[] = 'Experience';
                                                    if (isset($cvData['includeEducation']) && $cvData['includeEducation']) $sections[] = 'Education';
                                                    if (isset($cvData['includeCertifications']) && $cvData['includeCertifications']) $sections[] = 'Certifications';
                                                    if (isset($cvData['includeTraining']) && $cvData['includeTraining']) $sections[] = 'Training';
                                                    if (isset($cvData['includeSkills']) && $cvData['includeSkills']) $sections[] = 'Skills';
                                                    if (isset($cvData['includeLanguages']) && $cvData['includeLanguages']) $sections[] = 'Languages';
                                                    if (isset($cvData['includeReferees']) && $cvData['includeReferees']) $sections[] = 'References';
                                                    echo count($sections) . ' sections included';
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
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
        let currentTemplate = 'classic';
        let currentCVId = <?= $selectedCV->id ?>;
        
        // CV Data from PHP
        const cvData = <?= json_encode($cvData) ?>;
        const userData = <?= json_encode([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
        ]) ?>;
        const cvProfile = <?= json_encode($cvProfile ? $cvProfile->attributes : null) ?>;
        
        // Experience data
        const workExperiences = [
            <?php foreach ($workExperiences as $exp): ?>
            {
                id: '<?= $exp->id ?>',
                job_title: '<?= Html::encode($exp->job_title) ?>',
                company_name: '<?= Html::encode($exp->company_name) ?>',
                location: '<?= Html::encode($exp->location ?? '') ?>',
                start_date: '<?= date('M Y', strtotime($exp->start_date)) ?>',
                end_date: '<?= $exp->end_date ? date('M Y', strtotime($exp->end_date)) : 'Present' ?>',
                description: '<?= Html::encode($exp->description ?? '') ?>'
            },
            <?php endforeach; ?>
        ];
        
        // Education data
        const academicQualifications = [
            <?php foreach ($academicQualifications as $edu): ?>
            {
                id: '<?= $edu->id ?>',
                degree: '<?= Html::encode($edu->degree) ?>',
                field_of_study: '<?= Html::encode($edu->field_of_study) ?>',
                institution_name: '<?= Html::encode($edu->institution_name) ?>',
                start_year: '<?= Html::encode($edu->start_year) ?>',
                end_year: '<?= Html::encode($edu->end_year ?? 'Present') ?>',
                grade: '<?= Html::encode($edu->grade ?? '') ?>'
            },
            <?php endforeach; ?>
        ];
        
        // Professional qualifications
        const professionalQualifications = [
            <?php foreach ($professionalQualifications as $cert): ?>
            {
                id: '<?= $cert->id ?>',
                certificate_name: '<?= Html::encode($cert->certificate_name) ?>',
                organization: '<?= Html::encode($cert->organization) ?>',
                issued_date: '<?= date('M Y', strtotime($cert->issued_date)) ?>',
                description: '<?= Html::encode($cert->description ?? '') ?>'
            },
            <?php endforeach; ?>
        ];
        
        // Training workshops
        const trainingWorkshops = [
            <?php foreach ($trainingWorkshops as $training): ?>
            {
                id: '<?= $training->id ?>',
                title: '<?= Html::encode($training->title) ?>',
                institution: '<?= Html::encode($training->institution) ?>',
                start_date: '<?= date('M Y', strtotime($training->start_date)) ?>',
                end_date: '<?= $training->end_date ? date('M Y', strtotime($training->end_date)) : 'Present' ?>',
                description: '<?= Html::encode($training->description ?? '') ?>'
            },
            <?php endforeach; ?>
        ];
        
        // Referees
        const referees = [
            <?php foreach ($referees as $ref): ?>
            {
                id: '<?= $ref->id ?>',
                name: '<?= Html::encode($ref->name) ?>',
                position: '<?= Html::encode($ref->position) ?>',
                company: '<?= Html::encode($ref->company) ?>',
                email: '<?= Html::encode($ref->email) ?>',
                phone: '<?= Html::encode($ref->phone ?? '') ?>'
            },
            <?php endforeach; ?>
        ];

        // Template selection handlers
        document.querySelectorAll('.template-card').forEach(function(card) {
            card.addEventListener('click', function() {
                const template = this.dataset.template;
                selectTemplate(template);
            });
        });

        document.querySelectorAll('input[name="template"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    selectTemplate(this.value);
                }
            });
        });

        function selectTemplate(template) {
            currentTemplate = template;
            
            // Update UI
            document.querySelectorAll('.template-card').forEach(function(card) {
                card.classList.remove('selected');
            });
            const templateCard = document.querySelector(`[data-template="${template}"]`);
            if (templateCard) {
                templateCard.classList.add('selected');
            }
            
            // Update radio button
            const radio = document.getElementById(`template-${template}`);
            if (radio) {
                radio.checked = true;
            }
            
            // Update CV display classes
            const cvDisplay = document.getElementById('cvDisplay');
            if (cvDisplay) {
                cvDisplay.className = `cv-display template-${template}`;
            }
            
            // Update current template badge
            const currentTemplateBadge = document.getElementById('currentTemplate');
            if (currentTemplateBadge) {
                currentTemplateBadge.textContent = template.charAt(0).toUpperCase() + template.slice(1) + ' Template';
            }
            
            // Update template info
            updateTemplateInfo(template);
            
            // Reload CV content with new template
            loadCVContent();
        }

        function loadCVContent() {
            const cvDisplay = document.getElementById('cvDisplay');
            if (!cvDisplay) return;

            let html = '';

            if (currentTemplate === 'modern') {
                html = generateModernTemplate();
            } else if (currentTemplate === 'professional') {
                html = generateProfessionalTemplate();
            } else {
                html = generateClassicTemplate();
            }

            // Update the CV display
            cvDisplay.innerHTML = html;
        }

        function generateClassicTemplate() {
            let html = '';

            // Add watermark
            html += `<div class="cv-watermark">TanzaniaJobs.co.tz</div>`;

            // Personal Information - Classic Style
            if (cvData.includePersonalInfo) {
                html += `
                    <div class="text-center mb-4">
                        <h1>${userData.first_name} ${userData.last_name}</h1>
                        <div class="contact-info">
                            <span><i class="ri-mail-line me-1"></i>${userData.email}</span>
                            ${userData.phone ? `<span class="ms-3"><i class="ri-phone-line me-1"></i>${userData.phone}</span>` : ''}
                            ${cvProfile && cvProfile.location ? `<br><span><i class="ri-map-pin-line me-1"></i>${cvProfile.location}</span>` : ''}
                        </div>
                    </div>
                `;
            }

            // Professional Summary - Classic Style
            if (cvData.includeSummary && cvProfile && cvProfile.summary) {
                html += `
                    <div class="mb-4">
                        <h2>Professional Summary</h2>
                        <p>${cvProfile.summary}</p>
                    </div>
                `;
            }

            // Work Experience - Classic Style
            if (cvData.includeExperience && cvData.selectedExperiences && cvData.selectedExperiences.length > 0) {
                html += `<h2>Work Experience</h2>`;
                workExperiences.forEach(function(exp) {
                    if (cvData.selectedExperiences.includes(exp.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${exp.job_title}</h3>
                                <div class="company-period">
                                    ${exp.company_name}${exp.location ? ', ' + exp.location : ''}
                                    • ${exp.start_date} - ${exp.end_date}
                                </div>
                                ${exp.description ? `<div class="description">${exp.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Education
            if (cvData.includeEducation && cvData.selectedEducation && cvData.selectedEducation.length > 0) {
                html += `<h2>Education</h2>`;
                academicQualifications.forEach(function(edu) {
                    if (cvData.selectedEducation.includes(edu.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${edu.degree} in ${edu.field_of_study}</h3>
                                <div class="company-period">
                                    ${edu.institution_name}
                                    • ${edu.start_year} - ${edu.end_year}
                                    ${edu.grade ? `• Grade: ${edu.grade}` : ''}
                                </div>
                            </div>
                        `;
                    }
                });
            }

            // Professional Certifications
            if (cvData.includeCertifications && cvData.selectedCertifications && cvData.selectedCertifications.length > 0) {
                html += `<h2>Professional Certifications</h2>`;
                professionalQualifications.forEach(function(cert) {
                    if (cvData.selectedCertifications.includes(cert.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${cert.certificate_name}</h3>
                                <div class="company-period">
                                    ${cert.organization} • ${cert.issued_date}
                                </div>
                                ${cert.description ? `<div class="description">${cert.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Training & Workshops
            if (cvData.includeTraining && cvData.selectedTraining && cvData.selectedTraining.length > 0) {
                html += `<h2>Training & Workshops</h2>`;
                trainingWorkshops.forEach(function(training) {
                    if (cvData.selectedTraining.includes(training.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${training.title}</h3>
                                <div class="company-period">
                                    ${training.institution} • ${training.start_date} - ${training.end_date}
                                </div>
                                ${training.description ? `<div class="description">${training.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Skills
            if (cvData.includeSkills && cvProfile && cvProfile.skills) {
                const skillsArray = typeof cvProfile.skills === 'string' ? cvProfile.skills.split(',') : cvProfile.skills;
                if (skillsArray && skillsArray.length > 0) {
                    html += `
                        <h2>Skills</h2>
                        <div class="mb-3">
                            ${skillsArray.map(skill => `<span class="skill-tag">${skill.trim()}</span>`).join(' ')}
                        </div>
                    `;
                }
            }

            // Languages
            if (cvData.includeLanguages && cvProfile && cvProfile.languages) {
                const languagesArray = typeof cvProfile.languages === 'string' ? cvProfile.languages.split(',') : cvProfile.languages;
                if (languagesArray && languagesArray.length > 0) {
                    html += `
                        <h2>Languages</h2>
                        <div class="mb-3">
                            ${languagesArray.map(language => `<span class="language-tag">${language.trim()}</span>`).join(' ')}
                        </div>
                    `;
                }
            }

            // References
            if (cvData.includeReferees && cvData.selectedReferees && cvData.selectedReferees.length > 0) {
                html += `<h2>References</h2>`;
                referees.forEach(function(ref) {
                    if (cvData.selectedReferees.includes(ref.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${ref.name}</h3>
                                <div class="company-period">
                                    ${ref.position} at ${ref.company}
                                </div>
                                <div class="description">
                                    Email: ${ref.email}${ref.phone ? ` • Phone: ${ref.phone}` : ''}
                                </div>
                            </div>
                        `;
                    }
                });
            }

            return html;
        }

        function generateModernTemplate() {
            let html = '';

            // Add watermark
            html += `<div class="cv-watermark">TanzaniaJobs.co.tz</div>`;

            // Personal Information - Modern Style
            if (cvData.includePersonalInfo) {
                html += `
                    <div class="mb-4">
                        <h1>${userData.first_name} ${userData.last_name}</h1>
                        <div class="contact-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="ri-mail-line me-2 text-success"></i>${userData.email}
                                </div>
                                ${userData.phone ? `
                                <div class="col-md-6">
                                    <i class="ri-phone-line me-2 text-success"></i>${userData.phone}
                                </div>
                                ` : ''}
                            </div>
                            ${cvProfile && cvProfile.location ? `
                            <div class="mt-2">
                                <i class="ri-map-pin-line me-2 text-success"></i>${cvProfile.location}
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            }

            // Professional Summary - Modern Style
            if (cvData.includeSummary && cvProfile && cvProfile.summary) {
                html += `
                    <div class="mb-4">
                        <h2><i class="ri-user-line me-2"></i>About Me</h2>
                        <div class="section-item">
                            <p class="mb-0">${cvProfile.summary}</p>
                        </div>
                    </div>
                `;
            }

            // Work Experience - Modern Style
            if (cvData.includeExperience && cvData.selectedExperiences && cvData.selectedExperiences.length > 0) {
                html += `<h2><i class="ri-briefcase-line me-2"></i>Professional Experience</h2>`;
                workExperiences.forEach(function(exp, index) {
                    if (cvData.selectedExperiences.includes(exp.id)) {
                        html += `
                            <div class="section-item">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>${exp.job_title}</h3>
                                        <div class="company-period mb-2">
                                            <strong>${exp.company_name}</strong>${exp.location ? ', ' + exp.location : ''}
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <span class="badge bg-success-subtle text-success">
                                            ${exp.start_date} - ${exp.end_date}
                                        </span>
                                    </div>
                                </div>
                                ${exp.description ? `<div class="description mt-2">${exp.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Add other sections for modern template
            html += generateCommonSections('modern');

            return html;
        }

        function generateCommonSections(templateType) {
            let html = '';

            // Education
            if (cvData.includeEducation && cvData.selectedEducation && cvData.selectedEducation.length > 0) {
                const icon = templateType === 'modern' ? '<i class="ri-graduation-cap-line me-2"></i>' : '';
                html += `<h2>${icon}Education</h2>`;
                
                academicQualifications.forEach(function(edu) {
                    if (cvData.selectedEducation.includes(edu.id)) {
                        if (templateType === 'modern') {
                            html += `
                                <div class="section-item">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3>${edu.degree} in ${edu.field_of_study}</h3>
                                            <div class="company-period">
                                                <strong>${edu.institution_name}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <span class="badge bg-success-subtle text-success">
                                                ${edu.start_year} - ${edu.end_year}
                                            </span>
                                            ${edu.grade ? `<br><small class="text-muted">Grade: ${edu.grade}</small>` : ''}
                                        </div>
                                    </div>
                                </div>
                            `;
                        } else {
                            html += `
                                <div class="section-item">
                                    <h3>${edu.degree} in ${edu.field_of_study}</h3>
                                    <div class="company-period">
                                        ${edu.institution_name}
                                        • ${edu.start_year} - ${edu.end_year}
                                        ${edu.grade ? `• Grade: ${edu.grade}` : ''}
                                    </div>
                                </div>
                            `;
                        }
                    }
                });
            }

            // Professional Certifications
            if (cvData.includeCertifications && cvData.selectedCertifications && cvData.selectedCertifications.length > 0) {
                const icon = templateType === 'modern' ? '<i class="ri-award-line me-2"></i>' : '';
                html += `<h2>${icon}Professional Certifications</h2>`;
                
                professionalQualifications.forEach(function(cert) {
                    if (cvData.selectedCertifications.includes(cert.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${cert.certificate_name}</h3>
                                <div class="company-period">
                                    ${cert.organization} • ${cert.issued_date}
                                </div>
                                ${cert.description ? `<div class="description">${cert.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Training & Workshops
            if (cvData.includeTraining && cvData.selectedTraining && cvData.selectedTraining.length > 0) {
                const icon = templateType === 'modern' ? '<i class="ri-book-line me-2"></i>' : '';
                html += `<h2>${icon}Training & Workshops</h2>`;
                
                trainingWorkshops.forEach(function(training) {
                    if (cvData.selectedTraining.includes(training.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${training.title}</h3>
                                <div class="company-period">
                                    ${training.institution} • ${training.start_date} - ${training.end_date}
                                </div>
                                ${training.description ? `<div class="description">${training.description}</div>` : ''}
                            </div>
                        `;
                    }
                });
            }

            // Skills
            if (cvData.includeSkills && cvProfile && cvProfile.skills) {
                const skillsArray = typeof cvProfile.skills === 'string' ? cvProfile.skills.split(',') : cvProfile.skills;
                if (skillsArray && skillsArray.length > 0) {
                    const icon = templateType === 'modern' ? '<i class="ri-tools-line me-2"></i>' : '';
                    html += `
                        <h2>${icon}Skills</h2>
                        <div class="section-item">
                            ${skillsArray.map(skill => `<span class="skill-tag">${skill.trim()}</span>`).join(' ')}
                        </div>
                    `;
                }
            }

            // Languages
            if (cvData.includeLanguages && cvProfile && cvProfile.languages) {
                const languagesArray = typeof cvProfile.languages === 'string' ? cvProfile.languages.split(',') : cvProfile.languages;
                if (languagesArray && languagesArray.length > 0) {
                    const icon = templateType === 'modern' ? '<i class="ri-global-line me-2"></i>' : '';
                    html += `
                        <h2>${icon}Languages</h2>
                        <div class="section-item">
                            ${languagesArray.map(language => `<span class="language-tag">${language.trim()}</span>`).join(' ')}
                        </div>
                    `;
                }
            }

            // References
            if (cvData.includeReferees && cvData.selectedReferees && cvData.selectedReferees.length > 0) {
                const icon = templateType === 'modern' ? '<i class="ri-contacts-line me-2"></i>' : '';
                html += `<h2>${icon}References</h2>`;
                
                referees.forEach(function(ref) {
                    if (cvData.selectedReferees.includes(ref.id)) {
                        html += `
                            <div class="section-item">
                                <h3>${ref.name}</h3>
                                <div class="company-period">
                                    ${ref.position} at ${ref.company}
                                </div>
                                <div class="description">
                                    Email: ${ref.email}${ref.phone ? ` • Phone: ${ref.phone}` : ''}
                                </div>
                            </div>
                        `;
                    }
                });
            }

            return html;
        }

        // Template info update function
        function updateTemplateInfo(template) {
            const templateInfo = document.getElementById('templateInfo');
            if (!templateInfo) return;

            const templates = {
                classic: {
                    name: 'Classic Template',
                    description: 'A professional and clean design perfect for most industries. Features clear sections and easy-to-read formatting.',
                    features: ['Professional appearance', 'ATS-friendly format', 'Clean typography'],
                    color: 'primary'
                },
                modern: {
                    name: 'Modern Template',
                    description: 'Contemporary and stylish design with a fresh look. Great for creative and tech industries.',
                    features: ['Contemporary design', 'Eye-catching layout', 'Modern typography'],
                    color: 'success'
                },
                professional: {
                    name: 'Professional Template',
                    description: 'Corporate and formal design suitable for executive and management positions.',
                    features: ['Corporate appearance', 'Formal layout', 'Executive style'],
                    color: 'info'
                },
                creative: {
                    name: 'Creative Template',
                    description: 'Bold and artistic design perfect for creative professionals and designers.',
                    features: ['Bold design', 'Artistic layout', 'Creative styling'],
                    color: 'danger'
                },
                minimal: {
                    name: 'Minimal Template',
                    description: 'Simple and elegant design with focus on content. Perfect for any industry.',
                    features: ['Clean design', 'Content-focused', 'Elegant typography'],
                    color: 'secondary'
                }
            };

            const info = templates[template];
            templateInfo.innerHTML = `
                <h6 class="text-${info.color}">${info.name}</h6>
                <p class="text-muted mb-2">${info.description}</p>
                <div class="text-muted small">
                    ${info.features.map(feature => `<i class="ri-check-line text-success me-1"></i>${feature}<br>`).join('')}
                </div>
            `;
        }

        function loadCV(cvId) {
            if (cvId === currentCVId) {
                return;
            }
            
            window.location.href = `<?= Url::to(['/cv/templates']) ?>?id=${cvId}`;
        }

        // Initial load
        loadCVContent();
    });
    </script>

    <!-- App js -->
    <script src="/js/app.js"></script>
</body>
</html>
