<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Company Management', 'title'=>$title)); ?>

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

                    <div class="row">
                        <!-- Company Details -->
                        <div class="col-lg-8">
                            <!-- Company Header -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar-lg me-4">
                                            <?php if(!empty($company['logo'])): ?>
                                                <img src="<?php echo htmlspecialchars($company['logo']); ?>" 
                                                     alt="<?php echo htmlspecialchars($company['name']); ?>" 
                                                     class="img-thumbnail rounded">
                                            <?php else: ?>
                                                <div class="avatar-title bg-primary text-white rounded fs-2">
                                                    <?php echo strtoupper(substr($company['name'], 0, 2)); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4 class="fw-semibold mb-2"><?php echo htmlspecialchars($company['name']); ?></h4>
                                                    
                                                    <div class="d-flex gap-2 mb-3">
                                                        <?php
                                                        $statusClasses = [
                                                            'active' => 'bg-success text-white',
                                                            'pending' => 'bg-warning text-dark',
                                                            'inactive' => 'bg-secondary text-white',
                                                            'suspended' => 'bg-danger text-white'
                                                        ];
                                                        $statusClass = $statusClasses[$company['status']] ?? 'bg-secondary text-white';
                                                        ?>
                                                        <span class="badge <?php echo $statusClass; ?>">
                                                            <?php echo ucfirst($company['status']); ?>
                                                        </span>
                                                        
                                                        <?php if($company['verified']): ?>
                                                            <span class="badge bg-primary text-white">
                                                                <i class="ri-verified-badge-line me-1"></i>Verified
                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if($company['featured']): ?>
                                                            <span class="badge bg-info text-white">
                                                                <i class="ri-star-line me-1"></i>Featured
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="d-flex flex-wrap gap-3 text-muted">
                                                        <?php if(!empty($company['industry'])): ?>
                                                            <span><i class="ri-building-line me-1"></i><?php echo htmlspecialchars($company['industry']); ?></span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($company['size_range'])): ?>
                                                            <span><i class="ri-team-line me-1"></i><?php echo htmlspecialchars($company['size_range']); ?> employees</span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($company['founded_year'])): ?>
                                                            <span><i class="ri-calendar-line me-1"></i>Founded <?php echo $company['founded_year']; ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex gap-2">
                                                    <a href="/admin/companies/edit/<?php echo $company['id']; ?>" class="btn btn-success btn-sm">
                                                        <i class="ri-pencil-line me-1"></i>Edit
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteCompany(<?php echo $company['id']; ?>, '<?php echo addslashes($company['name']); ?>')">
                                                        <i class="ri-delete-bin-line me-1"></i>Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Company Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($company['description'])): ?>
                                        <div class="mb-4">
                                            <h6 class="text-muted fw-medium mb-2">About Company</h6>
                                            <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($company['description'])); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="text-muted fw-medium mb-2">Contact Information</h6>
                                                <div class="d-flex flex-column gap-2">
                                                    <?php if(!empty($company['email'])): ?>
                                                        <div>
                                                            <i class="ri-mail-line me-2 text-primary"></i>
                                                            <a href="mailto:<?php echo htmlspecialchars($company['email']); ?>" class="text-decoration-none">
                                                                <?php echo htmlspecialchars($company['email']); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(!empty($company['phone'])): ?>
                                                        <div>
                                                            <i class="ri-phone-line me-2 text-primary"></i>
                                                            <a href="tel:<?php echo htmlspecialchars($company['phone']); ?>" class="text-decoration-none">
                                                                <?php echo htmlspecialchars($company['phone']); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if(!empty($company['website'])): ?>
                                                        <div>
                                                            <i class="ri-global-line me-2 text-primary"></i>
                                                            <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank" class="text-decoration-none">
                                                                <?php echo str_replace(['http://', 'https://'], '', $company['website']); ?>
                                                                <i class="ri-external-link-line ms-1"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <?php if(!empty($company['address']) || !empty($company['city']) || !empty($company['country'])): ?>
                                                <div class="mb-3">
                                                    <h6 class="text-muted fw-medium mb-2">Location</h6>
                                                    <div>
                                                        <i class="ri-map-pin-line me-2 text-primary"></i>
                                                        <span>
                                                            <?php 
                                                            $location = [];
                                                            if (!empty($company['address'])) $location[] = $company['address'];
                                                            if (!empty($company['city'])) $location[] = $company['city'];
                                                            if (!empty($company['country'])) $location[] = $company['country'];
                                                            echo htmlspecialchars(implode(', ', $location));
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Jobs -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-briefcase-line me-2"></i>Recent Jobs
                                        </h5>
                                        <a href="/admin/jobs/all?company=<?php echo $company['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            View All Jobs
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if(empty($recentJobs)): ?>
                                        <div class="text-center py-4">
                                            <div class="avatar-md mx-auto mb-3">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                                    <i class="ri-briefcase-line fs-2"></i>
                                                </div>
                                            </div>
                                            <h6 class="text-muted">No jobs posted yet</h6>
                                            <p class="text-muted mb-0">This company hasn't posted any jobs yet.</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-nowrap mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Job Title</th>
                                                        <th>Status</th>
                                                        <th>Posted Date</th>
                                                        <th>Views</th>
                                                        <th>Applications</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($recentJobs as $job): ?>
                                                    <tr>
                                                        <td>
                                                            <a href="/admin/jobs/view/<?php echo $job['id']; ?>" class="text-decoration-none fw-medium">
                                                                <?php echo htmlspecialchars($job['title']); ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $jobStatusClasses = [
                                                                'published' => 'bg-success text-white',
                                                                'pending' => 'bg-warning text-dark',
                                                                'draft' => 'bg-secondary text-white',
                                                                'expired' => 'bg-danger text-white'
                                                            ];
                                                            $jobStatusClass = $jobStatusClasses[$job['status']] ?? 'bg-secondary text-white';
                                                            ?>
                                                            <span class="badge <?php echo $jobStatusClass; ?>">
                                                                <?php echo ucfirst($job['status']); ?>
                                                            </span>
                                                        </td>
                                                        <td><?php echo date('M d, Y', strtotime($job['created_at'])); ?></td>
                                                        <td>
                                                            <span class="badge bg-primary-subtle text-primary">
                                                                <?php echo number_format($job['views_count'] ?? 0); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-info-subtle text-info">
                                                                <?php echo number_format($job['applications_count'] ?? 0); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="/admin/jobs/view/<?php echo $job['id']; ?>" 
                                                               class="btn btn-sm btn-outline-primary">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Statistics -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-bar-chart-line me-2"></i>Statistics
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Total Jobs</span>
                                        <span class="fw-semibold fs-5"><?php echo number_format($company['total_jobs']); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Active Jobs</span>
                                        <span class="fw-semibold fs-5 text-success"><?php echo number_format($company['active_jobs']); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Pending Jobs</span>
                                        <span class="fw-semibold fs-5 text-warning"><?php echo number_format($company['pending_jobs']); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Member Since</span>
                                        <span class="fw-semibold"><?php echo date('M Y', strtotime($company['created_at'])); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-settings-line me-2"></i>Quick Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/admin/companies/edit/<?php echo $company['id']; ?>" class="btn btn-outline-success">
                                            <i class="ri-pencil-line me-2"></i>Edit Company
                                        </a>
                                        
                                        <?php if($company['status'] === 'pending'): ?>
                                            <button class="btn btn-outline-primary" onclick="approveCompany(<?php echo $company['id']; ?>)">
                                                <i class="ri-check-line me-2"></i>Approve Company
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if(!$company['verified']): ?>
                                            <button class="btn btn-outline-info" onclick="verifyCompany(<?php echo $company['id']; ?>)">
                                                <i class="ri-verified-badge-line me-2"></i>Verify Company
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if(!$company['featured']): ?>
                                            <button class="btn btn-outline-warning" onclick="featureCompany(<?php echo $company['id']; ?>)">
                                                <i class="ri-star-line me-2"></i>Feature Company
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button class="btn btn-outline-danger" onclick="deleteCompany(<?php echo $company['id']; ?>, '<?php echo addslashes($company['name']); ?>')">
                                            <i class="ri-delete-bin-line me-2"></i>Delete Company
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Details -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Company ID</small>
                                        <span class="fw-medium">#<?php echo $company['id']; ?></span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Company Slug</small>
                                        <span class="fw-medium"><?php echo htmlspecialchars($company['slug']); ?></span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <small class="text-muted d-block">Created Date</small>
                                        <span class="fw-medium"><?php echo date('M d, Y \a\t H:i', strtotime($company['created_at'])); ?></span>
                                    </div>
                                    
                                    <div class="mb-0">
                                        <small class="text-muted d-block">Last Updated</small>
                                        <span class="fw-medium"><?php echo date('M d, Y \a\t H:i', strtotime($company['updated_at'])); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/admin/companies/all" class="btn btn-outline-secondary">
                                            <i class="ri-arrow-left-line me-2"></i>Back to Companies
                                        </a>
                                        <a href="/admin/jobs/all?company=<?php echo $company['id']; ?>" class="btn btn-outline-primary">
                                            <i class="ri-briefcase-line me-2"></i>View All Jobs
                                        </a>
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
        // Professional delete company function with dependency checking
        async function deleteCompany(id, name) {
            try {
                // First, check if company can be deleted
                const checkResponse = await fetch(`/admin/companies/check-delete/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                
                const checkData = await checkResponse.json();
                
                if (!checkData.canDelete) {
                    // Show professional error modal
                    Swal.fire({
                        icon: 'error',
                        title: 'Cannot Delete Company',
                        html: `
                            <div class="text-start">
                                <p class="mb-3">Cannot delete <strong>"${name}"</strong> because it has associated data:</p>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="ri-briefcase-line text-primary me-2"></i>
                                        <strong>${checkData.jobCount}</strong> job posting${checkData.jobCount !== 1 ? 's' : ''}
                                    </li>
                                    ${checkData.applicationCount ? `
                                    <li class="mb-2">
                                        <i class="ri-user-line text-info me-2"></i>
                                        <strong>${checkData.applicationCount}</strong> job application${checkData.applicationCount !== 1 ? 's' : ''}
                                    </li>
                                    ` : ''}
                                </ul>
                                <div class="alert alert-warning mt-3">
                                    <i class="ri-information-line me-2"></i>
                                    <strong>What to do:</strong> Delete all associated jobs first, then try deleting the company again.
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: '<i class="ri-briefcase-line me-1"></i> View Company Jobs',
                        cancelButtonText: '<i class="ri-close-line me-1"></i> Close',
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d',
                        customClass: {
                            popup: 'swal2-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to company's jobs
                            window.location.href = `/admin/jobs/all?company=${id}`;
                        }
                    });
                    return;
                }
                
                // If can delete, show confirmation
                Swal.fire({
                    title: 'Delete Company?',
                    html: `
                        <div class="text-start">
                            <p class="mb-3">Are you sure you want to delete <strong>"${name}"</strong>?</p>
                            <div class="alert alert-danger">
                                <i class="ri-error-warning-line me-2"></i>
                                <strong>Warning:</strong> This action cannot be undone. All company data will be permanently removed.
                            </div>
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2"></i>
                                <strong>Note:</strong> You will be redirected to the companies list after deletion.
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="ri-delete-bin-line me-1"></i> Yes, Delete Company',
                    cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'swal2-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Deleting Company...',
                            html: `
                                <div class="text-center">
                                    <div class="spinner-border text-danger mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted">Please wait while we delete "${name}"</p>
                                    <small class="text-muted">This may take a moment...</small>
                                </div>
                            `,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal2-lg'
                            }
                        });
                        
                        // Submit form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/companies/delete/' + id;
                        
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                        csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                        form.appendChild(csrfInput);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
                
            } catch (error) {
                console.error('Error checking delete permission:', error);
                
                // Fallback to original confirmation
                Swal.fire({
                    title: 'Delete Company?',
                    html: `
                        <div class="text-start">
                            <p class="mb-3">Are you sure you want to delete <strong>"${name}"</strong>?</p>
                            <div class="alert alert-warning">
                                <i class="ri-error-warning-line me-2"></i>
                                <strong>Warning:</strong> Unable to check for dependencies. Please ensure this company has no associated jobs before proceeding.
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="ri-delete-bin-line me-1"></i> Delete Anyway',
                    cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                    customClass: {
                        popup: 'swal2-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/companies/delete/' + id;
                        
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
        }

        // Enhanced approve company function
        function approveCompany(id) {
            Swal.fire({
                title: 'Approve Company?',
                html: `
                    <div class="text-start">
                        <p class="mb-3">This will change the company status to <strong class="text-success">Active</strong>.</p>
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>What happens next:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Company status becomes "Active"</li>
                                <li>Company can post new jobs</li>
                                <li>Company profile becomes visible</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-check-line me-1"></i> Yes, Approve Company',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                customClass: {
                    popup: 'swal2-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Approving Company...',
                        text: 'Please wait while we update the company status.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    window.location.href = '/admin/companies/approve/' + id;
                }
            });
        }

        // Enhanced verify company function
        function verifyCompany(id) {
            Swal.fire({
                title: 'Verify Company?',
                html: `
                    <div class="text-start">
                        <p class="mb-3">This will mark the company as <strong class="text-primary">Verified</strong>.</p>
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>Verification benefits:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Displays verification badge</li>
                                <li>Increases company credibility</li>
                                <li>Improves search ranking</li>
                                <li>Builds user trust</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-verified-badge-line me-1"></i> Yes, Verify Company',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                customClass: {
                    popup: 'swal2-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Verifying Company...',
                        text: 'Please wait while we update the verification status.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    window.location.href = '/admin/companies/verify/' + id;
                }
            });
        }

        // Enhanced feature company function
        function featureCompany(id) {
            Swal.fire({
                title: 'Feature Company?',
                html: `
                    <div class="text-start">
                        <p class="mb-3">This will mark the company as <strong class="text-warning">Featured</strong>.</p>
                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>Featured benefits:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Appears in featured listings</li>
                                <li>Gets priority in search results</li>
                                <li>Displays featured badge</li>
                                <li>Increased visibility to job seekers</li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-star-line me-1"></i> Yes, Feature Company',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                customClass: {
                    popup: 'swal2-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Featuring Company...',
                        text: 'Please wait while we update the featured status.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    window.location.href = '/admin/companies/feature/' + id;
                }
            });
        }

        // Auto-dismiss flash messages after 10 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 10000);
        });
    </script>

    <style>
        .avatar-lg {
            height: 5rem;
            width: 5rem;
        }
        
        .avatar-lg .img-thumbnail {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }
        
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 1.5rem;
        }
        
        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            color: #495057;
        }
        
        .badge {
            font-size: 0.75rem;
        }
    </style>
</body>
</html>