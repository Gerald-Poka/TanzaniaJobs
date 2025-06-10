<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'Create Skill')); ?>

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Create New Skill')); ?>

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
                                        <i class="ri-star-line me-2"></i>Create New Skill
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="/admin/skills/create" id="skillForm">
                                        <!-- CSRF Token -->
                                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Skill Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" required placeholder="e.g., JavaScript, Python, Project Management">
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
                                                                    <?php echo (isset($preSelectedCategoryId) && $preSelectedCategoryId == $category['id']) ? 'selected' : ''; ?>>
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
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe this skill, its applications, and requirements..."></textarea>
                                            <div class="form-text">Provide a detailed description of the skill (optional)</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-select" id="status" name="status">
                                                        <option value="active" selected>Active</option>
                                                        <option value="inactive">Inactive</option>
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
                                                                <h6 class="mb-0" id="preview-name">Skill Name</h6>
                                                                <small class="text-muted" id="preview-category">No category</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ri-save-line me-1"></i> Create Skill
                                            </button>
                                            <a href="/admin/skills/list" class="btn btn-light">
                                                <i class="ri-arrow-left-line me-1"></i> Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Help -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-question-line me-2"></i>Need Help?
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <h6>Skill Name Guidelines:</h6>
                                        <ul class="text-muted small mb-0">
                                            <li>Use clear, recognizable skill names</li>
                                            <li>Be specific (e.g., "JavaScript" not "Programming")</li>
                                            <li>Use standard industry terms</li>
                                            <li>Avoid special characters</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <h6>Categories:</h6>
                                        <p class="text-muted small mb-0">
                                            Assign skills to categories for better organization. 
                                            Skills without categories are still valid and searchable.
                                        </p>
                                    </div>

                                    <div>
                                        <h6>Best Practices:</h6>
                                        <ul class="text-muted small mb-0">
                                            <li>Add detailed descriptions</li>
                                            <li>Keep skill names concise</li>
                                            <li>Use consistent naming conventions</li>
                                            <li>Review existing skills before creating duplicates</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Links -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-links-line me-2"></i>Quick Links
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="/admin/skills/list" class="btn btn-outline-primary btn-sm">
                                            <i class="ri-list-check me-2"></i> View All Skills
                                        </a>
                                        <a href="/admin/categories/list" class="btn btn-outline-info btn-sm">
                                            <i class="ri-folder-line me-2"></i> Manage Categories
                                        </a>
                                        <a href="/admin/categories/create" class="btn btn-outline-success btn-sm">
                                            <i class="ri-add-line me-2"></i> Create Category
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Skills -->
                            <?php if(isset($categories) && !empty($categories)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-folder-line me-2"></i>Available Categories
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php foreach(array_slice($categories, 0, 8) as $category): ?>
                                            <span class="badge bg-info-subtle text-info"><?php echo htmlspecialchars($category['name']); ?></span>
                                        <?php endforeach; ?>
                                        <?php if(count($categories) > 8): ?>
                                            <span class="badge bg-light text-muted">+<?php echo count($categories) - 8; ?> more</span>
                                        <?php endif; ?>
                                    </div>
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
                    title: 'Creating Skill...',
                    text: 'Please wait while we create the skill.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            // Auto-fill category if provided in URL
            <?php if(isset($preSelectedCategoryId) && $preSelectedCategoryId): ?>
                $('#category_id').val('<?php echo $preSelectedCategoryId; ?>').trigger('change');
            <?php endif; ?>

            // Category badge click functionality
            $('.badge').on('click', function() {
                if ($(this).hasClass('bg-info-subtle')) {
                    const categoryName = $(this).text();
                    const categoryOption = $('#category_id option').filter(function() {
                        return $(this).text() === categoryName;
                    });
                    
                    if (categoryOption.length) {
                        $('#category_id').val(categoryOption.val()).trigger('change');
                        
                        // Visual feedback
                        $(this).addClass('bg-success-subtle text-success').removeClass('bg-info-subtle text-info');
                        setTimeout(() => {
                            $(this).addClass('bg-info-subtle text-info').removeClass('bg-success-subtle text-success');
                        }, 1000);
                    }
                }
            });
        });
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

    .badge {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    .badge.bg-info-subtle:hover {
        background-color: var(--bs-success-bg-subtle) !important;
        color: var(--bs-success-text-emphasis) !important;
    }
    </style>
</body>
</html>