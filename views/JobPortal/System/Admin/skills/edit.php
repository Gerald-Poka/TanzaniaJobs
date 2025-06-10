<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'Edit Skill')); ?>

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Edit Skill')); ?>

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
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-edit-line me-2"></i>Edit Skill: <?php echo htmlspecialchars($skill['name']); ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="/admin/skills/edit/<?php echo $skill['id']; ?>" id="skillForm">
                                        <!-- CSRF Token -->
                                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Skill Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" required 
                                                           value="<?php echo htmlspecialchars($skill['name']); ?>" 
                                                           placeholder="e.g., JavaScript, Python, Project Management">
                                                    <div class="form-text">Enter the skill name (required)</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Category</label>
                                                    <select class="form-select" id="category_id" name="category_id">
                                                        <option value="">Select Category (Optional)</option>
                                                        <?php if(isset($categories) && !empty($categories)): ?>
                                                            <?php foreach($categories as $category): ?>
                                                                <option value="<?php echo $category['id']; ?>" 
                                                                    <?php echo ($skill['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                    <div class="form-text">Choose a category for better organization</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" 
                                                      placeholder="Describe this skill, its applications, and requirements..."><?php echo htmlspecialchars($skill['description'] ?? ''); ?></textarea>
                                            <div class="form-text">Provide a detailed description of the skill (optional)</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="active" <?php echo ($skill['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                                        <option value="inactive" <?php echo ($skill['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                    </select>
                                                    <div class="form-text">Set the skill status</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Preview</label>
                                                    <div class="border rounded p-3 bg-light">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-3">
                                                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                                    <i class="ri-star-line"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0" id="preview-name"><?php echo htmlspecialchars($skill['name']); ?></h6>
                                                                <small class="text-muted" id="preview-category">
                                                                    <?php if(!empty($skill['category_id'])): ?>
                                                                        <?php 
                                                                        $currentCategory = array_filter($categories, function($cat) use ($skill) {
                                                                            return $cat['id'] == $skill['category_id'];
                                                                        });
                                                                        echo !empty($currentCategory) ? htmlspecialchars(array_values($currentCategory)[0]['name']) : 'No category';
                                                                        ?>
                                                                    <?php else: ?>
                                                                        No category
                                                                    <?php endif; ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ri-save-line me-1"></i> Update Skill
                                            </button>
                                            <a href="/admin/skills/view/<?php echo $skill['id']; ?>" class="btn btn-light">
                                                <i class="ri-arrow-left-line me-1"></i> Back to View
                                            </a>
                                            <a href="/admin/skills/list" class="btn btn-outline-secondary">
                                                <i class="ri-list-check me-1"></i> Skills List
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Current Skill Info -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-information-line me-2"></i>Current Skill Info
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-borderless">
                                            <tr>
                                                <td class="fw-medium">ID:</td>
                                                <td><?php echo $skill['id']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Slug:</td>
                                                <td><code><?php echo htmlspecialchars($skill['slug']); ?></code></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Created:</td>
                                                <td><?php echo date('M d, Y', strtotime($skill['created_at'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Updated:</td>
                                                <td><?php echo date('M d, Y', strtotime($skill['updated_at'])); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Help -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-question-line me-2"></i>Editing Guidelines
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>Name Changes:</h6>
                                        <ul class="text-muted small mb-0">
                                            <li>Changing the name may update the URL slug</li>
                                            <li>Ensure the new name is unique</li>
                                            <li>Use standard industry terminology</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6>Status Changes:</h6>
                                        <p class="text-muted small mb-0">
                                            Inactive skills won't appear in job postings or searches 
                                            but will retain their data.
                                        </p>
                                    </div>

                                    <div>
                                        <h6>Category Changes:</h6>
                                        <p class="text-muted small mb-0">
                                            You can change or remove the category assignment. 
                                            This affects how the skill is organized and displayed.
                                        </p>
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
                                        <a href="/admin/skills/view/<?php echo $skill['id']; ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="ri-eye-line me-2"></i> View Skill
                                        </a>
                                        
                                        <button type="button" class="btn btn-outline-<?php echo $skill['status'] === 'active' ? 'warning' : 'success'; ?> btn-sm" 
                                                onclick="toggleStatus(<?php echo $skill['id']; ?>, '<?php echo $skill['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                            <?php if($skill['status'] === 'active'): ?>
                                                <i class="ri-close-circle-line me-2"></i> Deactivate
                                            <?php else: ?>
                                                <i class="ri-check-circle-line me-2"></i> Activate
                                            <?php endif; ?>
                                        </button>
                                        
                                        <hr class="my-2">
                                        
                                        <a href="/admin/skills/list" class="btn btn-outline-secondary btn-sm">
                                            <i class="ri-list-check me-2"></i> All Skills
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
        $(document).ready(function() {
            // Live preview updates
            $('#name').on('input', function() {
                const name = $(this).val() || 'Skill Name';
                $('#preview-name').text(name);
            });

            $('#category_id').on('change', function() {
                const categoryText = $(this).find('option:selected').text();
                const category = categoryText === 'Select Category (Optional)' ? 'No category' : categoryText;
                $('#preview-category').text(category);
            });

            // Form validation and submission
            $('#skillForm').on('submit', function(e) {
                const name = $('#name').val().trim();
                
                if (!name) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validation Error',
                        text: 'Please enter a skill name.',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                    $('#name').focus();
                    return false;
                }

                // Show loading state
                Swal.fire({
                    title: 'Updating Skill...',
                    text: 'Please wait while we update the skill.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });

        // Toggle status function
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${newStatus} this skill?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${newStatus} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/skills/toggle-status/' + id;
                    
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
    </script>

    <style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .avatar-title {
        transition: all 0.3s ease;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    #preview-name {
        transition: all 0.3s ease;
    }

    #preview-category {
        transition: all 0.3s ease;
    }

    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }
    </style>
</body>
</html>