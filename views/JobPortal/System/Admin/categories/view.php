<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'View Category')); ?>

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Category Details')); ?>

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

                    <!-- Category Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-lg me-4">
                                                <div class="avatar-title rounded-circle bg-light text-primary fs-24">
                                                    <i class="<?php echo $category['icon'] ?? 'ri-folder-line'; ?>"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="mb-1"><?php echo htmlspecialchars($category['name']); ?></h4>
                                                <p class="text-muted mb-2">
                                                    <strong>Slug:</strong> <code><?php echo htmlspecialchars($category['slug']); ?></code>
                                                    <?php if(!empty($category['parent_name'])): ?>
                                                        | <strong>Parent:</strong> <?php echo htmlspecialchars($category['parent_name']); ?>
                                                    <?php endif; ?>
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <?php if($category['status'] === 'active'): ?>
                                                        <span class="badge bg-success-subtle text-success">
                                                            <i class="ri-check-line me-1"></i>Active
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger-subtle text-danger">
                                                            <i class="ri-close-line me-1"></i>Inactive
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="badge bg-info-subtle text-info">
                                                        <i class="ri-briefcase-line me-1"></i><?php echo $jobsCount; ?> Jobs
                                                    </span>
                                                    <span class="badge bg-warning-subtle text-warning">
                                                        <i class="ri-star-line me-1"></i><?php echo count($skills); ?> Skills
                                                    </span>
                                                    <span class="badge bg-primary-subtle text-primary">
                                                        <i class="ri-folder-line me-1"></i><?php echo count($subcategories); ?> Subcategories
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="/admin/categories/edit/<?php echo $category['id']; ?>" class="btn btn-primary">
                                                <i class="ri-edit-line me-1"></i> Edit Category
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-line"></i> Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $category['id']; ?>, '<?php echo $category['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                                            <?php if($category['status'] === 'active'): ?>
                                                                <i class="ri-close-circle-line me-2"></i> Deactivate
                                                            <?php else: ?>
                                                                <i class="ri-check-circle-line me-2"></i> Activate
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="deleteCategory(<?php echo $category['id']; ?>, '<?php echo addslashes($category['name']); ?>')">
                                                            <i class="ri-delete-bin-line me-2"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="/admin/categories/list" class="btn btn-light">
                                                <i class="ri-arrow-left-line me-1"></i> Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Details -->
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Description -->
                            <?php if(!empty($category['description'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>Description
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($category['description'])); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Subcategories -->
                            <?php if(!empty($subcategories)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-folder-2-line me-2"></i>Subcategories (<?php echo count($subcategories); ?>)
                                        </h5>
                                        <a href="/admin/categories/create?parent_id=<?php echo $category['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="ri-add-line me-1"></i> Add Subcategory
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach($subcategories as $sub): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center p-3 border rounded">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                                        <i class="<?php echo $sub['icon'] ?? 'ri-folder-line'; ?>"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">
                                                        <a href="/admin/categories/view/<?php echo $sub['id']; ?>" class="text-decoration-none">
                                                            <?php echo htmlspecialchars($sub['name']); ?>
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted"><?php echo htmlspecialchars($sub['slug']); ?></small>
                                                    <div class="mt-1">
                                                        <?php if($sub['status'] === 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success badge-sm">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger badge-sm">Inactive</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Skills -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-star-line me-2"></i>Skills (<?php echo count($skills); ?>)
                                        </h5>
                                        <a href="/admin/skills/create?category_id=<?php echo $category['id']; ?>" class="btn btn-sm btn-success">
                                            <i class="ri-add-line me-1"></i> Add Skill
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($skills)): ?>
                                        <table id="skills-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Skill Name</th>
                                                    <th>Slug</th>
                                                    <th>Status</th>
                                                    <th>Sort Order</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($skills as $skill): ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0"><?php echo htmlspecialchars($skill['name']); ?></h6>
                                                                <?php if(!empty($skill['description'])): ?>
                                                                    <small class="text-muted"><?php echo htmlspecialchars(substr($skill['description'], 0, 50)) . (strlen($skill['description']) > 50 ? '...' : ''); ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><code><?php echo htmlspecialchars($skill['slug']); ?></code></td>
                                                    <td>
                                                        <?php if($skill['status'] === 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $skill['sort_order']; ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item" href="/admin/skills/view/<?php echo $skill['id']; ?>">
                                                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="/admin/skills/edit/<?php echo $skill['id']; ?>">
                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteSkill(<?php echo $skill['id']; ?>, '<?php echo addslashes($skill['name']); ?>')">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <div class="mb-3">
                                                <i class="ri-star-line display-4 text-muted"></i>
                                            </div>
                                            <h6>No Skills Found</h6>
                                            <p class="text-muted">This category doesn't have any skills yet.</p>
                                            <a href="/admin/skills/create?category_id=<?php echo $category['id']; ?>" class="btn btn-success">
                                                <i class="ri-add-line me-1"></i> Add First Skill
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Category Information -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Category Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium">ID:</td>
                                                    <td><?php echo $category['id']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Name:</td>
                                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Slug:</td>
                                                    <td><code><?php echo htmlspecialchars($category['slug']); ?></code></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Icon:</td>
                                                    <td>
                                                        <i class="<?php echo $category['icon'] ?? 'ri-folder-line'; ?> me-1"></i>
                                                        <code><?php echo $category['icon'] ?? 'ri-folder-line'; ?></code>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Status:</td>
                                                    <td>
                                                        <?php if($category['status'] === 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Sort Order:</td>
                                                    <td><?php echo $category['sort_order']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Parent:</td>
                                                    <td>
                                                        <?php if(!empty($category['parent_name'])): ?>
                                                            <?php echo htmlspecialchars($category['parent_name']); ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">None (Main Category)</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Created:</td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($category['created_at'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium">Updated:</td>
                                                    <td><?php echo date('M d, Y H:i', strtotime($category['updated_at'])); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Information -->
                            <?php if(!empty($category['meta_title']) || !empty($category['meta_description'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-seo-line me-2"></i>SEO Information
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($category['meta_title'])): ?>
                                        <div class="mb-3">
                                            <label class="form-label fw-medium">Meta Title:</label>
                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($category['meta_title']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty($category['meta_description'])): ?>
                                        <div class="mb-0">
                                            <label class="form-label fw-medium">Meta Description:</label>
                                            <p class="text-muted mb-0"><?php echo htmlspecialchars($category['meta_description']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Quick Stats -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-bar-chart-line me-2"></i>Quick Stats
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                    <i class="ri-briefcase-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-medium">Jobs</p>
                                                <small class="text-muted">Total jobs in this category</small>
                                            </div>
                                        </div>
                                        <h5 class="mb-0"><?php echo $jobsCount; ?></h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title rounded-circle bg-success-subtle text-success">
                                                    <i class="ri-star-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-medium">Skills</p>
                                                <small class="text-muted">Skills in this category</small>
                                            </div>
                                        </div>
                                        <h5 class="mb-0"><?php echo count($skills); ?></h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title rounded-circle bg-warning-subtle text-warning">
                                                    <i class="ri-folder-2-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0 fw-medium">Subcategories</p>
                                                <small class="text-muted">Child categories</small>
                                            </div>
                                        </div>
                                        <h5 class="mb-0"><?php echo count($subcategories); ?></h5>
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

    <!-- Datatables js -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable for skills
            $('#skills-table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[3, 'asc']], // Sort by sort_order
                columnDefs: [
                    { orderable: false, targets: [4] } // Disable sorting on action column
                ]
            });
        });

        // Toggle status function with SweetAlert
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${newStatus} this category?`,
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
                        text: 'Please wait while we update the category status.',
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
                    form.action = '/admin/categories/toggle-status/' + id;
                    
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

        // Delete category function with SweetAlert
        function deleteCategory(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete the category "${name}"? This action cannot be undone!`,
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
                        text: 'Please wait while we delete the category.',
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
                    form.action = '/admin/categories/delete/' + id;
                    
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

        // Delete skill function with SweetAlert
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
    .badge-sm {
        font-size: 0.75em;
    }

    .avatar-title {
        transition: all 0.3s ease;
    }

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
    </style>
</body>
</html>