<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'View Skill')); ?>

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Skill Details')); ?>

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

                    <!-- Skill Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg me-4">
                                                <div class="avatar-title rounded-circle bg-light text-primary fs-24">
                                                    <i class="ri-star-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="mb-1"><?php echo htmlspecialchars($skill['name']); ?></h4>
                                                <p class="text-muted mb-2">
                                                    <strong>Slug:</strong> <code><?php echo htmlspecialchars($skill['slug']); ?></code>
                                                    <?php if(!empty($skill['category_name'])): ?>
                                                        | <strong>Category:</strong> <?php echo htmlspecialchars($skill['category_name']); ?>
                                                    <?php endif; ?>
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <?php if($skill['status'] === 'active'): ?>
                                                        <span class="badge bg-success-subtle text-success">
                                                            <i class="ri-check-line me-1"></i>Active
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ri-close-line me-1"></i>Inactive
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="badge bg-info-subtle text-info">
                                                        <i class="ri-hashtag me-1"></i>Sort Order: <?php echo $skill['sort_order']; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="/admin/skills/edit/<?php echo $skill['id']; ?>" class="btn btn-primary">
                                                <i class="ri-edit-line me-1"></i> Edit Skill
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-line"></i> Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $skill['id']; ?>, '<?php echo $skill['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                                            <?php if($skill['status'] === 'active'): ?>
                                                                <i class="ri-close-circle-line me-2"></i> Deactivate
                                                            <?php else: ?>
                                                                <i class="ri-check-circle-line me-2"></i> Activate
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteSkill(<?php echo $skill['id']; ?>, '<?php echo addslashes($skill['name']); ?>')">
                                                            <i class="ri-delete-bin-line me-2"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="/admin/skills/list" class="btn btn-light">
                                                <i class="ri-arrow-left-line me-1"></i> Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skill Details -->
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Description -->
                            <?php if(!empty($skill['description'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>Description
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($skill['description'])); ?></p>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="card">
                                <div class="card-body text-center py-5">
                                    <div class="mb-3">
                                        <i class="ri-file-text-line display-4 text-muted"></i>
                                    </div>
                                    <h6 class="text-muted">No Description Available</h6>
                                    <p class="text-muted mb-3">This skill doesn't have a description yet.</p>
                                    <a href="/admin/skills/edit/<?php echo $skill['id']; ?>" class="btn btn-primary btn-sm">
                                        <i class="ri-edit-line me-1"></i> Add Description
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Related Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-links-line me-2"></i>Related Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 border rounded mb-3">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                                        <i class="ri-folder-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">Category</h6>
                                                    <?php if(!empty($skill['category_name'])): ?>
                                                        <span class="text-muted"><?php echo htmlspecialchars($skill['category_name']); ?></span>
                                                        <br>
                                                        <a href="/admin/categories/view/<?php echo $skill['category_id']; ?>" class="btn btn-sm btn-outline-info mt-2">
                                                            <i class="ri-eye-line me-1"></i> View Category
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No category assigned</span>
                                                        <br>
                                                        <a href="/admin/skills/edit/<?php echo $skill['id']; ?>" class="btn btn-sm btn-outline-primary mt-2">
                                                            <i class="ri-edit-line me-1"></i> Assign Category
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 border rounded mb-3">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title rounded-circle bg-warning-subtle text-warning">
                                                        <i class="ri-briefcase-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">Jobs Using This Skill</h6>
                                                    <span class="text-muted">0 jobs</span>
                                                    <br>
                                                    <small class="text-muted">Jobs that require this skill</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Skill Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Skill Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">ID:</td>
                                                    <td><?php echo $skill['id']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Name:</td>
                                                    <td><?php echo htmlspecialchars($skill['name']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Slug:</td>
                                                    <td><code><?php echo htmlspecialchars($skill['slug']); ?></code></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Status:</td>
                                                    <td>
                                                        <?php if($skill['status'] === 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Sort Order:</td>
                                                    <td><?php echo $skill['sort_order']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Category:</td>
                                                    <td>
                                                        <?php if(!empty($skill['category_name'])): ?>
                                                            <a href="/admin/categories/view/<?php echo $skill['category_id']; ?>" class="text-decoration-none">
                                                                <?php echo htmlspecialchars($skill['category_name']); ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No Category</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Created:</td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($skill['created_at'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Updated:</td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($skill['updated_at'])); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-settings-line me-2"></i>Quick Actions
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/admin/skills/edit/<?php echo $skill['id']; ?>" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line me-2"></i> Edit Skill
                                        </a>
                                        
                                        <button type="button" class="btn btn-<?php echo $skill['status'] === 'active' ? 'warning' : 'success'; ?> btn-sm" 
                                                onclick="toggleStatus(<?php echo $skill['id']; ?>, '<?php echo $skill['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                            <?php if($skill['status'] === 'active'): ?>
                                                <i class="ri-close-circle-line me-2"></i> Deactivate
                                            <?php else: ?>
                                                <i class="ri-check-circle-line me-2"></i> Activate
                                            <?php endif; ?>
                                        </button>
                                        
                                        <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="deleteSkill(<?php echo $skill['id']; ?>, '<?php echo addslashes($skill['name']); ?>')">
                                            <i class="ri-delete-bin-line me-2"></i> Delete Skill
                                        </button>
                                        
                                        <hr class="my-3">
                                        
                                        <a href="/admin/skills/list" class="btn btn-light btn-sm">
                                            <i class="ri-arrow-left-line me-2"></i> Back to Skills List
                                        </a>
                                        
                                        <a href="/admin/skills/create" class="btn btn-outline-success btn-sm">
                                            <i class="ri-add-line me-2"></i> Create New Skill
                                        </a>
                                        
                                        <?php if(!empty($skill['category_id'])): ?>
                                        <a href="/admin/categories/view/<?php echo $skill['category_id']; ?>" class="btn btn-outline-info btn-sm">
                                            <i class="ri-folder-line me-2"></i> View Category
                                        </a>
                                        <?php endif; ?>
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
        // Toggle status function
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${newStatus} this skill?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${newStatus} it!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we update the skill status.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create a form to submit the request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/skills/toggle-status/' + id;
                    
                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    // Add status
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

        // Delete skill function
        function deleteSkill(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete the skill "${name}"? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                dangerMode: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we delete the skill.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create a form to submit the DELETE request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/skills/delete/' + id;
                    
                    // Add CSRF token
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
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .table th {
        font-weight: 600;
        border-top: none;
    }

    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .text-decoration-none:hover {
        text-decoration: underline !important;
    }

    .avatar-title {
        transition: all 0.3s ease;
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }
    </style>
</body>
</html>