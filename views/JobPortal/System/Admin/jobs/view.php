<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <?php echo $this->render('../partials/head-css'); ?>
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>$title)); ?>

                    <!-- Flash Messages -->
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-check-double-line label-icon"></i>
                                <strong>Success!</strong> <?php echo Yii::$app->session->getFlash('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (Yii::$app->session->hasFlash('error')): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-error-warning-line label-icon"></i>
                                <strong>Error!</strong> <?php echo Yii::$app->session->getFlash('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Job Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-primary-subtle">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-lg me-3">
                                                    <div class="avatar-title bg-primary rounded fs-2">
                                                        <i class="ri-briefcase-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h4 class="mb-1"><?php echo htmlspecialchars($job['title']); ?></h4>
                                                    <div class="d-flex align-items-center gap-3 mb-2">
                                                        <?php if(!empty($job['company_name'])): ?>
                                                            <span class="badge bg-primary-subtle text-primary fs-12">
                                                                <i class="ri-building-line me-1"></i><?php echo htmlspecialchars($job['company_name']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($job['category_name'])): ?>
                                                            <span class="badge bg-info-subtle text-info fs-12">
                                                                <i class="ri-folder-line me-1"></i><?php echo htmlspecialchars($job['category_name']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <span class="badge bg-secondary-subtle text-secondary fs-12">
                                                            <i class="ri-time-line me-1"></i><?php echo ucfirst($job['job_type']); ?>
                                                        </span>
                                                        
                                                        <span class="badge bg-success-subtle text-success fs-12">
                                                            <i class="ri-map-pin-line me-1"></i><?php echo ucfirst($job['location_type']); ?>
                                                        </span>
                                                    </div>
                                                    <p class="text-muted mb-0">
                                                        <i class="ri-calendar-line me-1"></i>
                                                        Posted on <?php echo date('F j, Y \a\t g:i A', strtotime($job['created_at'])); ?>
                                                        <?php if(!empty($job['posted_by'])): ?>
                                                            by <strong><?php echo htmlspecialchars($job['posted_by']); ?></strong>
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex gap-2">
                                                <?php
                                                $statusClasses = [
                                                    'published' => 'bg-success text-white',
                                                    'pending' => 'bg-warning text-dark',
                                                    'draft' => 'bg-secondary text-white',
                                                    'expired' => 'bg-danger text-white',
                                                    'rejected' => 'bg-danger text-white',
                                                    'reported' => 'bg-danger text-white'
                                                ];
                                                $statusClass = $statusClasses[$job['status']] ?? 'bg-secondary text-white';
                                                ?>
                                                <span class="badge <?php echo $statusClass; ?> fs-14 px-3 py-2">
                                                    <?php echo ucfirst($job['status']); ?>
                                                </span>
                                                
                                                <?php if($job['featured']): ?>
                                                    <span class="badge bg-warning text-dark fs-14 px-3 py-2">
                                                        <i class="ri-star-line me-1"></i>Featured
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if($job['urgent']): ?>
                                                    <span class="badge bg-danger text-white fs-14 px-3 py-2">
                                                        <i class="ri-alarm-line me-1"></i>Urgent
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Details and Actions -->
                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <!-- Job Description -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>Job Description
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($job['short_description'])): ?>
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">Summary</h6>
                                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($job['short_description'])); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="job-description">
                                        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Requirements -->
                            <?php if(!empty($job['requirements'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-list-check me-2"></i>Requirements
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="requirements">
                                        <?php echo nl2br(htmlspecialchars($job['requirements'])); ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Benefits -->
                            <?php if(!empty($job['benefits'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-gift-line me-2"></i>Benefits & Perks
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="benefits">
                                        <?php echo nl2br(htmlspecialchars($job['benefits'])); ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Skills Required -->
                            <?php if(!empty($skills)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-star-line me-2"></i>Skills Required
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach($skills as $skill): ?>
                                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                                <?php echo htmlspecialchars($skill['name']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Quick Stats -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-bar-chart-line me-2"></i>Job Statistics
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="p-2">
                                                <h4 class="text-primary mb-1"><?php echo number_format($job['views_count']); ?></h4>
                                                <p class="text-muted mb-0 fs-14">Views</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2">
                                                <h4 class="text-success mb-1"><?php echo number_format($job['applications_count']); ?></h4>
                                                <p class="text-muted mb-0 fs-14">Applications</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Job Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Job Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">Job Type:</td>
                                                    <td><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Work Type:</td>
                                                    <td><?php echo ucfirst($job['location_type']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Location:</td>
                                                    <td><?php echo $job['location'] ? htmlspecialchars($job['location']) : 'Not specified'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Experience:</td>
                                                    <td><?php echo ucfirst($job['experience_level']); ?> Level</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Education:</td>
                                                    <td><?php echo ucfirst(str_replace('-', ' ', $job['education_level'])); ?></td>
                                                </tr>
                                                <?php if($job['salary_min'] && $job['salary_max']): ?>
                                                <tr>
                                                    <td class="fw-medium">Salary:</td>
                                                    <td>
                                                        <span class="text-success fw-medium">
                                                            <?php echo $job['salary_currency']; ?> <?php echo number_format($job['salary_min']); ?> - <?php echo number_format($job['salary_max']); ?>
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">per <?php echo $job['salary_period']; ?></small>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                                <?php if($job['expires_at']): ?>
                                                <tr>
                                                    <td class="fw-medium">Expires:</td>
                                                    <td>
                                                        <?php 
                                                        $expiryDate = strtotime($job['expires_at']);
                                                        $isExpired = $expiryDate < time();
                                                        ?>
                                                        <span class="<?php echo $isExpired ? 'text-danger' : 'text-warning'; ?>">
                                                            <?php echo date('M j, Y', $expiryDate); ?>
                                                        </span>
                                                        <?php if($isExpired): ?>
                                                            <br><small class="text-danger">Expired</small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Information -->
                            <?php if(!empty($job['company_name'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-building-line me-2"></i>Company Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded">
                                                <i class="ri-building-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><?php echo htmlspecialchars($job['company_name']); ?></h6>
                                            <?php if(!empty($job['poster_email'])): ?>
                                                <p class="text-muted mb-0 fs-13">
                                                    <i class="ri-mail-line me-1"></i><?php echo htmlspecialchars($job['poster_email']); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <?php if(!empty($job['company_website'])): ?>
                                        <a href="<?php echo htmlspecialchars($job['company_website']); ?>" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="ri-external-link-line me-1"></i>Visit Website
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Application Stats -->
                            <?php if(!empty($applicationStats)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-user-line me-2"></i>Application Statistics
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php foreach($applicationStats as $stat): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-capitalize"><?php echo $stat['status']; ?>:</span>
                                            <span class="badge bg-primary"><?php echo $stat['count']; ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-settings-line me-2"></i>Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/admin/jobs/all" class="btn btn-outline-secondary">
                                            <i class="ri-arrow-left-line me-1"></i>Back to Jobs List
                                        </a>
                                        
                                        <?php if($job['status'] === 'pending'): ?>
                                            <button type="button" class="btn btn-success" onclick="approveJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                                <i class="ri-check-line me-1"></i>Approve Job
                                            </button>
                                            <button type="button" class="btn btn-warning" onclick="rejectJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                                <i class="ri-close-line me-1"></i>Reject Job
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if($job['status'] === 'published'): ?>
                                            <button type="button" class="btn btn-warning" onclick="toggleStatus(<?php echo $job['id']; ?>, 'expired')">
                                                <i class="ri-time-line me-1"></i>Mark as Expired
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if($job['status'] === 'expired'): ?>
                                            <button type="button" class="btn btn-success" onclick="toggleStatus(<?php echo $job['id']; ?>, 'published')">
                                                <i class="ri-refresh-line me-1"></i>Reactivate Job
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button type="button" class="btn btn-danger" onclick="deleteJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                            <i class="ri-delete-bin-line me-1"></i>Delete Job
                                        </button>
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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        // Approve job function
        function approveJob(id, title) {
            Swal.fire({
                title: 'Approve Job?',
                text: `Are you sure you want to approve "${title}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/approve/' + id;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Reject job function
        function rejectJob(id, title) {
            Swal.fire({
                title: 'Reject Job?',
                text: `Please provide a reason for rejecting "${title}":`,
                input: 'textarea',
                inputPlaceholder: 'Enter rejection reason...',
                inputAttributes: {
                    'aria-label': 'Rejection reason'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Reject Job',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to provide a reason for rejection!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/reject/' + id;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = result.value;
                    form.appendChild(reasonInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Toggle status function
        function toggleStatus(id, newStatus) {
            const statusText = newStatus === 'published' ? 'reactivate' : `mark as ${newStatus}`;
            
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${statusText} this job?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${statusText}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/toggle-status/' + id;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = newStatus;
                    form.appendChild(statusInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Delete job function
        function deleteJob(id, title) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete "${title}"? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/delete/' + id;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <style>
        .job-description,
        .requirements,
        .benefits {
            line-height: 1.8;
        }
        
        .job-description p,
        .requirements p,
        .benefits p {
            margin-bottom: 1rem;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .badge {
            font-weight: 500;
        }
        
        .table-borderless td {
            border: none;
            padding: 0.75rem 0;
        }
    </style>
</body>
</html>