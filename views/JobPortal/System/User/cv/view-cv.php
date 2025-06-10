<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My CV - ' . Html::encode($user->first_name . ' ' . $user->last_name);

// Use the JobPortal layout
echo $this->render('../partials/main');
?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title' => 'My CV')); ?>
    <?php echo $this->render('../partials/head-css'); ?>
    
    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="<?= Yii::$app->request->getCsrfToken() ?>">
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <style>
        .cv-container {
            position: sticky;
            top: 100px;
        }
        
        .cv-content {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #374151;
            font-size: 14px;
            min-height: 600px;
            padding: 1.5rem;
        }
        
        .cv-content h1 {
            color: #1f2937;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .cv-content h2 {
            color: #4f46e5;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 1.25rem 0 0.75rem 0;
            padding-bottom: 0.375rem;
            border-bottom: 2px solid #4f46e5;
        }
        
        .cv-content h3 {
            color: #1f2937;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.375rem;
        }
        
        .cv-content .contact-info {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        
        .cv-content .section-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .cv-content .section-item:last-child {
            border-bottom: none;
        }
        
        .cv-content .company-period {
            color: #6b7280;
            font-size: 0.875rem;
            font-style: italic;
        }
        
        .cv-content .description {
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
        
        .saved-cv-item {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
            background-color: #f9fafb;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .saved-cv-item:hover {
            border-color: #6366f1;
            background-color: rgba(99, 102, 241, 0.02);
        }
        
        .saved-cv-item.active {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }
        
        /* Print and PDF specific styles */
        @media print {
            /* Hide everything except CV content */
            body * {
                visibility: hidden;
            }
            
            /* Show only the CV content and its children */
            #cvContainer, #cvContainer * {
                visibility: visible;
            }
            
            /* Position the CV content at the top of the page */
            #cvContainer {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border: none !important;
                background: white !important;
            }
            
            /* Hide unwanted elements even within CV container */
            .page-title-box,
            .btn-group,
            .sidebar,
            .col-lg-4,
            .card:not(#cvContainer),
            .debug-info,
            .cv-save-info {
                display: none !important;
                visibility: hidden !important;
            }
            
            /* Remove card styling for print */
            .cv-content {
                padding: 0 !important;
                margin: 0 !important;
            }
            
            /* Ensure good print layout */
            .cv-content h1 {
                page-break-after: avoid;
            }
            
            .cv-content h2 {
                page-break-after: avoid;
                margin-top: 1rem;
            }
            
            .section-item {
                page-break-inside: avoid;
            }
            
            /* Use all available space */
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-size: 12pt !important;
            }
            
            /* Optimize for A4 paper */
            @page {
                size: A4;
                margin: 2cm;
            }
        }
        
        @media (max-width: 768px) {
            .cv-container {
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
                                    <i class="ri-file-user-line me-2"></i>My CV - <?= Html::encode($cvDocument->name) ?>
                                </h4>
                                <div class="page-title-right">
                                    <div class="btn-group" role="group">
                                        <a href="<?= Url::to(['/cv/builder']) ?>" class="btn btn-light">
                                            <i class="ri-edit-line me-1"></i>Edit CV
                                        </a>
                                        <button type="button" class="btn btn-primary" onclick="window.print()">
                                            <i class="ri-printer-line me-1"></i>Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <!-- Main CV Content -->
                        <div class="col-lg-8">
                            <div class="cv-container">
                                <div class="card" id="cvContainer">
                                    <div class="card-body p-0">
                                        <div class="cv-content">
                                            
                                            <!-- Personal Information -->
                                            <?php if (isset($savedData['includePersonalInfo']) && $savedData['includePersonalInfo']): ?>
                                            <div class="text-center mb-4">
                                                <?php if (isset($user->profile_picture) && $user->profile_picture): ?>
                                                    <img src="<?= Html::encode($user->profile_picture) ?>" 
                                                         alt="Profile Picture" 
                                                         class="rounded-circle mb-3" 
                                                         style="width: 120px; height: 120px; object-fit: cover;">
                                                <?php endif; ?>
                                                <h1><?= Html::encode($user->first_name . ' ' . $user->last_name) ?></h1>
                                                
                                                <?php if ($cvProfile && $cvProfile->job_title): ?>
                                                    <p class="text-muted mb-2" style="font-size: 1.1rem;"><?= Html::encode($cvProfile->job_title) ?></p>
                                                <?php endif; ?>
                                                
                                                <div class="contact-info">
                                                    <span><i class="ri-mail-line me-1"></i><?= Html::encode($user->email) ?></span>
                                                    <?php if ($cvProfile && $cvProfile->location): ?>
                                                        <br><span><i class="ri-map-pin-line me-1"></i><?= Html::encode($cvProfile->location) ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Professional Summary -->
                                            <?php if (isset($savedData['includeSummary']) && $savedData['includeSummary'] && $cvProfile && $cvProfile->summary): ?>
                                            <div class="mb-4">
                                                <h2>Professional Summary</h2>
                                                <p><?= Html::encode($cvProfile->summary) ?></p>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Work Experience -->
                                            <?php if (isset($savedData['includeExperience']) && $savedData['includeExperience'] && !empty($savedData['selectedExperiences'])): ?>
                                            <div class="mb-4">
                                                <h2>Work Experience</h2>
                                                <?php 
                                                $selectedIds = $savedData['selectedExperiences'];
                                                foreach ($workExperiences as $experience): 
                                                    if (in_array((string)$experience->id, $selectedIds)): 
                                                ?>
                                                    <div class="section-item">
                                                        <h3><?= Html::encode($experience->job_title ?? 'Position') ?></h3>
                                                        <div class="company-period">
                                                            <?= Html::encode($experience->company_name ?? 'Company') ?>
                                                            • <?= date('M Y', strtotime($experience->start_date)) ?> - 
                                                            <?= $experience->end_date ? date('M Y', strtotime($experience->end_date)) : 'Present' ?>
                                                        </div>
                                                        <?php if (isset($experience->description) && $experience->description): ?>
                                                            <div class="description"><?= Html::encode($experience->description) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php 
                                                    endif; 
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Education -->
                                            <?php if (isset($savedData['includeEducation']) && $savedData['includeEducation'] && !empty($savedData['selectedEducation'])): ?>
                                            <div class="mb-4">
                                                <h2>Education</h2>
                                                <?php 
                                                $selectedIds = $savedData['selectedEducation'];
                                                foreach ($academicQualifications as $education): 
                                                    if (in_array((string)$education->id, $selectedIds)): 
                                                ?>
                                                    <div class="section-item">
                                                        <h3><?= Html::encode($education->degree ?? 'Qualification') ?><?= isset($education->field_of_study) && $education->field_of_study ? ' in ' . Html::encode($education->field_of_study) : '' ?></h3>
                                                        <div class="company-period">
                                                            <?= Html::encode($education->institution_name ?? 'Institution') ?>
                                                            • <?= Html::encode($education->start_year ?? '') ?> - <?= Html::encode($education->end_year ?? 'Present') ?>
                                                            <?php if (isset($education->grade) && $education->grade): ?>
                                                                • Grade: <?= Html::encode($education->grade) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php 
                                                    endif; 
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Professional Certifications -->
                                            <?php if (isset($savedData['includeCertifications']) && $savedData['includeCertifications'] && !empty($savedData['selectedCertifications'])): ?>
                                            <div class="mb-4">
                                                <h2>Professional Certifications</h2>
                                                <?php 
                                                $selectedIds = $savedData['selectedCertifications'];
                                                foreach ($professionalQualifications as $cert): 
                                                    if (in_array((string)$cert->id, $selectedIds)): 
                                                ?>
                                                    <div class="section-item">
                                                        <h3><?= Html::encode($cert->certificate_name ?? 'Certification') ?></h3>
                                                        <div class="company-period">
                                                            <?= Html::encode($cert->organization ?? 'Organization') ?>
                                                            • <?= date('F Y', strtotime($cert->issued_date)) ?>
                                                        </div>
                                                        <?php if (isset($cert->description) && $cert->description): ?>
                                                            <div class="description"><?= Html::encode($cert->description) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php 
                                                    endif; 
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Training & Workshops -->
                                            <?php if (isset($savedData['includeTraining']) && $savedData['includeTraining'] && !empty($savedData['selectedTraining'])): ?>
                                            <div class="mb-4">
                                                <h2>Training & Workshops</h2>
                                                <?php 
                                                $selectedIds = $savedData['selectedTraining'];
                                                foreach ($trainingWorkshops as $training): 
                                                    if (in_array((string)$training->id, $selectedIds)): 
                                                ?>
                                                    <div class="section-item">
                                                        <h3><?= Html::encode($training->title ?? 'Training') ?></h3>
                                                        <div class="company-period">
                                                            <?= Html::encode($training->institution ?? 'Provider') ?>
                                                            • <?= date('M Y', strtotime($training->start_date)) ?> - 
                                                            <?= $training->end_date ? date('M Y', strtotime($training->end_date)) : 'Present' ?>
                                                        </div>
                                                        <?php if (isset($training->description) && $training->description): ?>
                                                            <div class="description"><?= Html::encode($training->description) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php 
                                                    endif; 
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Skills -->
                                            <?php if (isset($savedData['includeSkills']) && $savedData['includeSkills'] && $cvProfile && $cvProfile->skills): ?>
                                            <div class="mb-4">
                                                <h2>Skills</h2>
                                                <div class="mb-3">
                                                    <?php 
                                                    $skillsArray = is_array($cvProfile->skills) ? $cvProfile->skills : explode(',', $cvProfile->skills);
                                                    foreach ($skillsArray as $skill): 
                                                    ?>
                                                        <span class="skill-tag"><?= Html::encode(trim($skill)) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Languages -->
                                            <?php if (isset($savedData['includeLanguages']) && $savedData['includeLanguages'] && $cvProfile && $cvProfile->languages): ?>
                                            <div class="mb-4">
                                                <h2>Languages</h2>
                                                <div class="mb-3">
                                                    <?php 
                                                    $languagesArray = is_array($cvProfile->languages) ? $cvProfile->languages : explode(',', $cvProfile->languages);
                                                    foreach ($languagesArray as $language): 
                                                    ?>
                                                        <span class="language-tag"><?= Html::encode(trim($language)) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>

                                            <!-- References -->
                                            <?php if (isset($savedData['includeReferees']) && $savedData['includeReferees'] && !empty($savedData['selectedReferees'])): ?>
                                            <div class="mb-4">
                                                <h2>References</h2>
                                                <?php 
                                                $selectedIds = $savedData['selectedReferees'];
                                                foreach ($referees as $referee): 
                                                    if (in_array((string)$referee->id, $selectedIds)): 
                                                ?>
                                                    <div class="section-item">
                                                        <h3><?= Html::encode($referee->name ?? 'Name') ?></h3>
                                                        <div class="company-period">
                                                            <?= Html::encode($referee->position ?? 'Position') ?><?= isset($referee->company) && $referee->company ? ' at ' . Html::encode($referee->company) : '' ?>
                                                        </div>
                                                        <div class="description">
                                                            <i class="ri-mail-line me-1"></i><?= Html::encode($referee->email ?? '') ?>
                                                            <?php if (isset($referee->phone) && $referee->phone): ?>
                                                            <br><i class="ri-phone-line me-1"></i><?= Html::encode($referee->phone) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php 
                                                    endif; 
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>

                                            <!-- CV Save Information (hidden in print) -->
                                            <div class="text-center mt-4 pt-3 cv-save-info" style="border-top: 1px solid #e5e7eb; font-size: 0.75rem; color: #6b7280;">
                                                CV saved on: <?= Html::encode($cvDocument->created_at) ?> | 
                                                Last updated: <?= Html::encode($cvDocument->updated_at) ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <div class="col-lg-4">
                            <div class="cv-container">
                                
                                <!-- Actions Card -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-settings-3-line text-primary me-2"></i>CV Actions
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <a href="<?= Url::to(['/cv/builder']) ?>" class="btn btn-primary">
                                                <i class="ri-edit-line me-1"></i>Edit CV
                                            </a>
                                            <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                                                <i class="ri-printer-line me-1"></i>Print CV
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="shareCV">
                                                <i class="ri-share-line me-1"></i>Share CV
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saved CVs Card -->
                                <?php if (!empty($savedCVs)): ?>
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-file-list-line text-success me-2"></i>My Saved CVs
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($savedCVs as $savedCV): ?>
                                            <div class="saved-cv-item <?= $savedCV->id == $cvDocument->id ? 'active' : '' ?>" 
                                                 onclick="loadCV(<?= $savedCV->id ?>)" 
                                                 data-cv-id="<?= $savedCV->id ?>">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?= Html::encode($savedCV->name) ?></h6>
                                                        <small class="text-muted">
                                                            <i class="ri-calendar-line me-1"></i>
                                                            <?= date('M d, Y', strtotime($savedCV->updated_at)) ?>
                                                        </small>
                                                    </div>
                                                    <?php if ($savedCV->id == $cvDocument->id): ?>
                                                        <span class="badge bg-success-subtle text-success">Current</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        
                                        <div class="text-center mt-3">
                                            <a href="<?= Url::to(['/cv/builder']) ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="ri-add-line me-1"></i>Create New CV
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- CV Info Card -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-information-line text-info me-2"></i>CV Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td class="text-muted">CV Name:</td>
                                                    <td><?= Html::encode($cvDocument->name) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Created:</td>
                                                    <td><?= date('M d, Y g:i A', strtotime($cvDocument->created_at)) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Last Updated:</td>
                                                    <td><?= date('M d, Y g:i A', strtotime($cvDocument->updated_at)) ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Sections:</td>
                                                    <td>
                                                        <?php 
                                                        $sections = [];
                                                        if (isset($savedData['includePersonalInfo']) && $savedData['includePersonalInfo']) $sections[] = 'Personal Info';
                                                        if (isset($savedData['includeSummary']) && $savedData['includeSummary']) $sections[] = 'Summary';
                                                        if (isset($savedData['includeExperience']) && $savedData['includeExperience']) $sections[] = 'Experience';
                                                        if (isset($savedData['includeEducation']) && $savedData['includeEducation']) $sections[] = 'Education';
                                                        if (isset($savedData['includeCertifications']) && $savedData['includeCertifications']) $sections[] = 'Certifications';
                                                        if (isset($savedData['includeTraining']) && $savedData['includeTraining']) $sections[] = 'Training';
                                                        if (isset($savedData['includeSkills']) && $savedData['includeSkills']) $sections[] = 'Skills';
                                                        if (isset($savedData['includeLanguages']) && $savedData['includeLanguages']) $sections[] = 'Languages';
                                                        if (isset($savedData['includeReferees']) && $savedData['includeReferees']) $sections[] = 'References';
                                                        echo count($sections) . ' sections';
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tips Card -->
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-lightbulb-line text-warning me-2"></i>CV Tips
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <ul class="mb-0 small">
                                                <li>Keep your CV updated regularly</li>
                                                <li>Tailor your CV for each job application</li>
                                                <li>Use action verbs to describe achievements</li>
                                                <li>Keep it concise and professional</li>
                                                <li>Proofread before sharing or printing</li>
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

    <?php
$this->registerJs("
document.addEventListener('DOMContentLoaded', function() {
    // Share CV functionality
    const shareBtn = document.getElementById('shareCV');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'My CV - " . Html::encode($user->first_name . ' ' . $user->last_name) . "',
                    text: 'Check out my professional CV',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(function() {
                    Swal.fire({
                        title: 'Link Copied!',
                        text: 'CV link has been copied to clipboard',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            }
        });
    }
});

function downloadCV() {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class=\"ri-loader-2-line me-1\"></i>Preparing...';
    
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    const cvContent = document.getElementById('cvContainer').innerHTML;
    
    const printDocument = '<!DOCTYPE html>' +
        '<html>' +
        '<head>' +
        '<title>CV - " . $user->first_name . " " . $user->last_name . "</title>' +
        '<style>' +
        'body {' +
            'font-family: \"Inter\", Arial, sans-serif;' +
            'line-height: 1.6;' +
            'color: #374151;' +
            'font-size: 14px;' +
            'margin: 0;' +
            'padding: 20px;' +
            'background: white;' +
        '}' +
        'h1 {' +
            'color: #1f2937;' +
            'font-size: 1.75rem;' +
            'font-weight: 700;' +
            'margin-bottom: 0.5rem;' +
            'page-break-after: avoid;' +
        '}' +
        'h2 {' +
            'color: #4f46e5;' +
            'font-size: 1.125rem;' +
            'font-weight: 600;' +
            'margin: 1.25rem 0 0.75rem 0;' +
            'padding-bottom: 0.375rem;' +
            'border-bottom: 2px solid #4f46e5;' +
            'page-break-after: avoid;' +
        '}' +
        'h3 {' +
            'color: #1f2937;' +
            'font-size: 1rem;' +
            'font-weight: 600;' +
            'margin-bottom: 0.375rem;' +
        '}' +
        '.contact-info {' +
            'color: #6b7280;' +
            'font-size: 0.875rem;' +
            'margin-bottom: 1.25rem;' +
        '}' +
        '.section-item {' +
            'margin-bottom: 1rem;' +
            'padding-bottom: 1rem;' +
            'border-bottom: 1px solid #e5e7eb;' +
            'page-break-inside: avoid;' +
        '}' +
        '.section-item:last-child {' +
            'border-bottom: none;' +
        '}' +
        '.company-period {' +
            'color: #6b7280;' +
            'font-size: 0.875rem;' +
            'font-style: italic;' +
        '}' +
        '.description {' +
            'color: #4b5563;' +
            'font-size: 0.875rem;' +
            'margin-top: 0.5rem;' +
        '}' +
        '.skill-tag, .language-tag {' +
            'display: inline-block;' +
            'background: rgba(79, 70, 229, 0.1);' +
            'color: #4f46e5;' +
            'padding: 0.25rem 0.75rem;' +
            'border-radius: 1.25rem;' +
            'font-size: 0.75rem;' +
            'margin: 0.125rem;' +
            'font-weight: 500;' +
        '}' +
        '.text-center { text-align: center; }' +
        '.text-muted { color: #6b7280; }' +
        '.mb-1 { margin-bottom: 0.25rem; }' +
        '.mb-2 { margin-bottom: 0.5rem; }' +
        '.mb-3 { margin-bottom: 1rem; }' +
        '.mb-4 { margin-bottom: 1.5rem; }' +
        '.mt-4 { margin-top: 1.5rem; }' +
        '.pt-3 { padding-top: 1rem; }' +
        '.rounded-circle { border-radius: 50%; }' +
        'img { max-width: 100%; height: auto; }' +
        '.card, .card-body {' +
            'border: none !important;' +
            'box-shadow: none !important;' +
            'background: transparent !important;' +
            'padding: 0 !important;' +
            'margin: 0 !important;' +
        '}' +
        '.cv-save-info { display: none !important; }' +
        '@media print {' +
            '@page { size: A4; margin: 2cm; }' +
            'body { font-size: 12pt; }' +
        '}' +
        '</style>' +
        '</head>' +
        '<body>' +
        '<div class=\"cv-content\">' + cvContent + '</div>' +
        '</body>' +
        '</html>';
    
    printWindow.document.write(printDocument);
    printWindow.document.close();
    
    printWindow.onload = function() {
        printWindow.print();
        printWindow.onafterprint = function() {
            printWindow.close();
        };
    };
    
    setTimeout(function() {
        button.disabled = false;
        button.innerHTML = originalText;
    }, 2000);
}

function loadCV(cvId) {
    if (cvId === " . $cvDocument->id . ") {
        return;
    }
    
    Swal.fire({
        title: 'Loading CV...',
        text: 'Please wait while we load your selected CV',
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });
    
    window.location.href = '" . Url::to(['/cv/view-my-cv']) . "?id=' + cvId;
}

document.addEventListener('click', function(e) {
    if (e.target.closest('button') && e.target.closest('button').getAttribute('onclick') === 'window.print()') {
        e.preventDefault();
        e.stopPropagation();
        downloadCV();
    }
});
", \yii\web\View::POS_END);
?>

<!-- App js -->
<script src="/js/app.js"></script>
</body>
</html>