<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>
    <?php echo $this->render('../partials/head-css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Details', 'title'=>$pageTitle)); ?>

                    <!-- Job Details -->
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Job Header -->
                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center mb-3 mb-sm-0">
                                            <div class="flex-shrink-0 me-3">
                                                <?php if($company && !empty($company->logo)): ?>
                                                    <img src="<?= $company->getLogoUrl() ?>" alt="<?= Html::encode($company->name) ?>" class="avatar-md rounded">
                                                <?php else: ?>
                                                    <div class="avatar-md rounded bg-primary-subtle text-primary">
                                                        <span class="avatar-title"><?= strtoupper(substr($company->name ?? 'C', 0, 1)) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h4 class="mb-1"><?= Html::encode($job->title) ?></h4>
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 me-3">
                                                        <i class="ri-building-line me-1"></i>
                                                        <?= $company ? Html::encode($company->name) : 'Unknown Company' ?>
                                                    </p>
                                                    <?php if($company && $company->verified): ?>
                                                        <span class="badge bg-info-subtle text-info">
                                                            <i class="ri-check-line me-1"></i>Verified
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <!-- Save Job Button -->
                                            <button type="button" class="btn btn-ghost-primary" 
                                                    onclick="toggleSaveJob(<?= $job->id ?>, this)"
                                                    data-saved="<?= $isSaved ? '1' : '0' ?>">
                                                <i class="<?= $isSaved ? 'ri-bookmark-fill' : 'ri-bookmark-line' ?> me-1"></i>
                                                <?= $isSaved ? 'Saved' : 'Save' ?>
                                            </button>
                                            
                                            <!-- Apply Button -->
                                            <?php if(!$hasApplied): ?>
                                                <a href="<?= Url::to(['/application/form', 'job_id' => $job->id]) ?>" class="btn btn-primary">
                                                    <i class="ri-send-plane-line me-1"></i>Apply Now
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-success" disabled>
                                                    <i class="ri-check-line me-1"></i>Applied
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Job Highlights -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-sm-6 col-md-3">
                                            <div class="p-3 rounded bg-light-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-map-pin-line text-primary fs-24"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-1">Location</p>
                                                        <h6 class="mb-0"><?= Html::encode($job->location) ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="p-3 rounded bg-light-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-briefcase-line text-primary fs-24"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-1">Job Type</p>
                                                        <h6 class="mb-0"><?= ucfirst(str_replace('-', ' ', $job->job_type)) ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="p-3 rounded bg-light-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-money-dollar-circle-line text-primary fs-24"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-1">Salary</p>
                                                        <h6 class="mb-0">
                                                            <?php 
                                                                $currency = $job->salary_currency ?: 'USD';
                                                                if($job->salary_min && $job->salary_max) {
                                                                    echo $currency . ' ' . number_format($job->salary_min) . ' - ' . number_format($job->salary_max);
                                                                } elseif ($job->salary_min) {
                                                                    echo $currency . ' ' . number_format($job->salary_min) . '+';
                                                                } elseif ($job->salary_max) {
                                                                    echo 'Up to ' . $currency . ' ' . number_format($job->salary_max);
                                                                } else {
                                                                    echo 'Negotiable';
                                                                }
                                                                
                                                                if(!empty($job->salary_period)) {
                                                                    echo ' / ' . ucfirst($job->salary_period);
                                                                }
                                                            ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-3">
                                            <div class="p-3 rounded bg-light-subtle">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="ri-user-star-line text-primary fs-24"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-muted mb-1">Experience</p>
                                                        <h6 class="mb-0"><?= ucfirst($job->experience_level) ?> Level</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Job Description -->
                                    <div class="mb-5">
                                        <h5 class="mb-3">Job Description</h5>
                                        <div class="job-description">
                                            <?= nl2br(Html::encode($job->description)) ?>
                                        </div>
                                    </div>

                                    <!-- Job Requirements -->
                                    <?php if(!empty($job->requirements)): ?>
                                    <div class="mb-5">
                                        <h5 class="mb-3">Requirements</h5>
                                        <div class="job-requirements">
                                            <?= nl2br(Html::encode($job->requirements)) ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Job Benefits -->
                                    <?php if(!empty($job->benefits)): ?>
                                    <div class="mb-5">
                                        <h5 class="mb-3">Benefits</h5>
                                        <div class="job-benefits">
                                            <?= nl2br(Html::encode($job->benefits)) ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Call to Action -->
                                    <div class="mt-5 text-center">
                                        <?php if(!$hasApplied): ?>
                                            <a href="<?= Url::to(['/application/form', 'job_id' => $job->id]) ?>" class="btn btn-lg btn-primary">
                                                <i class="ri-send-plane-line me-1"></i>Apply for This Position
                                            </a>
                                        <?php else: ?>
                                            <div class="alert alert-success">
                                                <h5 class="mb-1"><i class="ri-check-line me-2"></i>You've already applied for this job!</h5>
                                                <p class="mb-0">You can view your application status in your dashboard.</p>
                                            </div>
                                            <a href="<?= Url::to(['/user-applications/active']) ?>" class="btn btn-outline-primary">
                                                <i class="ri-file-list-3-line me-1"></i>View My Applications
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Job Summary Card -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Job Summary</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        <li class="d-flex mb-3">
                                            <i class="ri-calendar-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Posted Date</p>
                                                <h6><?= Yii::$app->formatter->asDate($job->created_at, 'php:M d, Y') ?></h6>
                                            </div>
                                        </li>
                                        
                                        <li class="d-flex mb-3">
                                            <i class="ri-time-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Expiry Date</p>
                                                <h6><?= $job->expires_at ? Yii::$app->formatter->asDate($job->expires_at, 'php:M d, Y') : 'No Expiry' ?></h6>
                                            </div>
                                        </li>
                                        
                                        <li class="d-flex mb-3">
                                            <i class="ri-user-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Applications</p>
                                                <h6><?= number_format($job->applications_count) ?></h6>
                                            </div>
                                        </li>
                                        
                                        <li class="d-flex mb-3">
                                            <i class="ri-eye-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Views</p>
                                                <h6><?= number_format($job->views_count) ?></h6>
                                            </div>
                                        </li>
                                        
                                        <?php if($category): ?>
                                        <li class="d-flex mb-3">
                                            <i class="ri-bookmark-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Category</p>
                                                <h6><?= Html::encode($category->name) ?></h6>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($job->education_level)): ?>
                                        <li class="d-flex">
                                            <i class="ri-graduation-cap-line text-muted me-2 fs-16"></i>
                                            <div>
                                                <p class="text-muted mb-1">Education Level</p>
                                                <h6><?= ucfirst($job->education_level) ?></h6>
                                            </div>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Company Info Card -->
                            <?php if($company): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Company Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <?php if(!empty($company->logo)): ?>
                                            <img src="<?= $company->getLogoUrl() ?>" alt="<?= Html::encode($company->name) ?>" class="avatar-lg rounded mb-3">
                                        <?php else: ?>
                                            <div class="avatar-lg mx-auto rounded bg-primary-subtle text-primary mb-3">
                                                <span class="avatar-title display-5"><?= strtoupper(substr($company->name ?? 'C', 0, 1)) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <h5><?= Html::encode($company->name) ?></h5>
                                        <?php if($company->verified): ?>
                                            <span class="badge bg-info-subtle text-info">
                                                <i class="ri-check-line me-1"></i>Verified Company
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if(!empty($company->description)): ?>
                                        <p class="text-muted mb-4"><?= Html::encode(substr($company->description, 0, 120) . '...') ?></p>
                                    <?php endif; ?>
                                    
                                    <ul class="list-unstyled mb-0">
                                        <?php if(!empty($company->website)): ?>
                                        <li class="d-flex mb-3">
                                            <i class="ri-global-line text-muted me-2 fs-16"></i>
                                            <a href="<?= Html::encode($company->website) ?>" target="_blank" rel="noopener noreferrer"><?= Html::encode($company->website) ?></a>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($company->location)): ?>
                                        <li class="d-flex mb-3">
                                            <i class="ri-map-pin-line text-muted me-2 fs-16"></i>
                                            <span><?= Html::encode($company->location) ?></span>
                                        </li>
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($company->founded_year)): ?>
                                        <li class="d-flex">
                                            <i class="ri-calendar-line text-muted me-2 fs-16"></i>
                                            <span>Founded <?= Html::encode($company->founded_year) ?></span>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Similar Jobs -->
                            <?php if(!empty($similarJobs)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Similar Jobs</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <?php foreach($similarJobs as $similarJob): ?>
                                        <li class="list-group-item px-0">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">
                                                        <a href="/jobs/view/<?= $similarJob->id ?>"><?= Html::encode($similarJob->title) ?></a>
                                                    </h6>
                                                    <p class="text-muted mb-0">
                                                        <?php if($similarJob->company): ?>
                                                            <?= Html::encode($similarJob->company->name) ?> •
                                                        <?php endif; ?>
                                                        <?= Html::encode($similarJob->location) ?>
                                                    </p>
                                                </div>
                                                <?php if($similarJob->salary_min || $similarJob->salary_max): ?>
                                                <div>
                                                    <span class="badge bg-light text-body">
                                                        <?php
                                                            $currency = $similarJob->salary_currency ?: 'USD';
                                                            if($similarJob->salary_min && $similarJob->salary_max) {
                                                                echo $currency . ' ' . number_format($similarJob->salary_min) . '-' . number_format($similarJob->salary_max);
                                                            } elseif ($similarJob->salary_min) {
                                                                echo $currency . ' ' . number_format($similarJob->salary_min) . '+';
                                                            } elseif ($similarJob->salary_max) {
                                                                echo 'Up to ' . $currency . ' ' . number_format($similarJob->salary_max);
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="card-footer bg-transparent text-center">
                                    <a href="/jobs/browse" class="btn btn-sm btn-link">View All Jobs</a>
                                </div>
                            </div>
                            <?php endif; ?>
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

    <!-- Add jQuery explicitly before other scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <?php echo $this->render('../partials/vendor-scripts'); ?>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        // Toggle save job function
        async function toggleSaveJob(jobId, button) {
            const isCurrentlySaved = $(button).data('saved') == '1';
            const action = isCurrentlySaved ? 'unsave' : 'save';
            
            try {
                // Get CSRF token from meta tag or from Yii
                const csrfToken = $('meta[name="csrf-token"]').attr('content') || '<?= Yii::$app->request->getCsrfToken() ?>';
                
                const response = await fetch(`/jobs/${action}/${jobId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update button state
                    const newSavedState = !isCurrentlySaved;
                    $(button).data('saved', newSavedState ? '1' : '0');
                    
                    // Update icon and text
                    const icon = $(button).find('i');
                    if (newSavedState) {
                        icon.removeClass('ri-bookmark-line').addClass('ri-bookmark-fill');
                        $(button).html('<i class="ri-bookmark-fill me-1"></i>Saved');
                    } else {
                        icon.removeClass('ri-bookmark-fill').addClass('ri-bookmark-line');
                        $(button).html('<i class="ri-bookmark-line me-1"></i>Save');
                    }
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    // If there's a redirect URL, go there (e.g., for login)
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                    
                    // Show more detailed error message
                    let errorMessage = data.message || 'Something went wrong';
                    let errorDetails = '';
                    
                    // If we have debug details and are in development mode, show them
                    if (data.debug) {
                        if (typeof data.debug === 'string') {
                            errorDetails = data.debug;
                        } else if (data.debug.error) {
                            errorDetails = `${data.debug.error} (${data.debug.file}:${data.debug.line})`;
                        }
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        ...(errorDetails ? {footer: `<small class="text-muted">${errorDetails}</small>`} : {})
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        }
    </script>
    
    <style>
        .avatar-md {
            height: 3rem;
            width: 3rem;
        }
        
        .avatar-lg {
            height: 5rem;
            width: 5rem;
        }
        
        .avatar-title {
            align-items: center;
            background-color: var(--vz-primary);
            color: #fff;
            display: flex;
            font-weight: 500;
            height: 100%;
            justify-content: center;
            width: 100%;
        }
        
        .fs-24 {
            font-size: 24px !important;
        }
        
        .job-description, .job-requirements, .job-benefits {
            white-space: pre-line;
        }
    </style>
</body>
</html>