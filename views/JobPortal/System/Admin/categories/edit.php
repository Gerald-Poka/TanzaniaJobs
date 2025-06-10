<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'Edit Category')); ?>

    <!-- Select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Edit Category')); ?>

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
                                        <i class="ri-edit-circle-line me-2"></i>Edit Category: <?php echo htmlspecialchars($category['name']); ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="editCategoryForm">
                                        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                                    <div class="form-text">This will be the display name for the category</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="parent_id" class="form-label">Parent Category</label>
                                                    <select class="form-select" id="parent_id" name="parent_id">
                                                        <option value="">Select Parent Category (Optional)</option>
                                                        <?php if(isset($parentCategories) && !empty($parentCategories)): ?>
                                                            <?php foreach($parentCategories as $parent): ?>
                                                                <option value="<?php echo $parent['id']; ?>" <?php echo ($category['parent_id'] == $parent['id']) ? 'selected' : ''; ?>>
                                                                    <?php echo htmlspecialchars($parent['name']); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                    <div class="form-text">Leave empty for main category</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="icon" class="form-label">Category Icon</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="icon-preview">
                                                            <i class="<?php echo $category['icon'] ?? 'ri-folder-line'; ?>" id="selected-icon"></i>
                                                        </span>
                                                        <input type="text" class="form-control" id="icon" name="icon" placeholder="ri-folder-line" value="<?php echo htmlspecialchars($category['icon'] ?? 'ri-folder-line'); ?>">
                                                        <button class="btn btn-outline-secondary" type="button" id="icon-picker-btn">
                                                            <i class="ri-palette-line"></i> Pick
                                                        </button>
                                                    </div>
                                                    <div class="form-text">Remix Icon class name (e.g., ri-computer-line)</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <div class="d-flex gap-2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" <?php echo ($category['status'] === 'active') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="status_active">
                                                                <span class="badge bg-success-subtle text-success">
                                                                    <i class="ri-check-line me-1"></i> Active
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" <?php echo ($category['status'] === 'inactive') ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="status_inactive">
                                                                <span class="badge bg-danger-subtle text-danger">
                                                                    <i class="ri-close-line me-1"></i> Inactive
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-text">Active categories will be visible to users</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category description..."><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
                                            <div class="form-text">Brief description of what jobs fall under this category</div>
                                        </div>

                                        <!-- SEO Section -->
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="ri-seo-line me-2"></i>SEO Settings (Optional)
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="SEO title for search engines" value="<?php echo htmlspecialchars($category['meta_title'] ?? ''); ?>">
                                                    <div class="form-text">Recommended: 50-60 characters <span id="meta-title-count" class="text-muted">0/60</span></div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="SEO description for search engines"><?php echo htmlspecialchars($category['meta_description'] ?? ''); ?></textarea>
                                                    <div class="form-text">Recommended: 150-160 characters <span id="meta-desc-count" class="text-muted">0/160</span></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Category Information -->
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="ri-information-line me-2"></i>Category Information
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Category ID:</strong> <?php echo $category['id']; ?></p>
                                                        <p class="mb-2"><strong>Slug:</strong> <code><?php echo htmlspecialchars($category['slug']); ?></code></p>
                                                        <p class="mb-2"><strong>Sort Order:</strong> <?php echo $category['sort_order']; ?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Created:</strong> <?php echo date('M d, Y H:i', strtotime($category['created_at'])); ?></p>
                                                        <p class="mb-2"><strong>Updated:</strong> <?php echo date('M d, Y H:i', strtotime($category['updated_at'])); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ri-save-line me-1"></i> Update Category
                                            </button>
                                            <a href="/admin/categories/view/<?php echo $category['id']; ?>" class="btn btn-info ms-2">
                                                <i class="ri-eye-line me-1"></i> View Details
                                            </a>
                                            <a href="/admin/categories/list" class="btn btn-secondary ms-2">
                                                <i class="ri-arrow-left-line me-1"></i> Back to List
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Card -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-eye-line me-2"></i>Preview
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <div class="avatar-title rounded-circle bg-light text-primary fs-24" id="preview-icon">
                                                <i class="<?php echo $category['icon'] ?? 'ri-folder-line'; ?>"></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-1" id="preview-name"><?php echo htmlspecialchars($category['name']); ?></h5>
                                        <p class="text-muted" id="preview-description"><?php echo htmlspecialchars($category['description'] ?? 'Category description will appear here...'); ?></p>
                                        <span class="badge <?php echo ($category['status'] === 'active') ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>" id="preview-status">
                                            <?php if($category['status'] === 'active'): ?>
                                                <i class="ri-check-line me-1"></i>Active
                                            <?php else: ?>
                                                <i class="ri-close-line me-1"></i>Inactive
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Icon Picker -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="ri-palette-line me-2"></i>Popular Icons
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-2" id="popular-icons">
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-computer-line">
                                            <i class="ri-computer-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-heart-pulse-line">
                                            <i class="ri-heart-pulse-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-bank-line">
                                            <i class="ri-bank-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-book-open-line">
                                            <i class="ri-book-open-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-settings-3-line">
                                            <i class="ri-settings-3-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-megaphone-line">
                                            <i class="ri-megaphone-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-team-line">
                                            <i class="ri-team-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-building-3-line">
                                            <i class="ri-building-3-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-car-line">
                                            <i class="ri-car-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-restaurant-line">
                                            <i class="ri-restaurant-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-shopping-bag-line">
                                            <i class="ri-shopping-bag-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm icon-option" data-icon="ri-paint-brush-line">
                                            <i class="ri-paint-brush-line"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-light btn-sm w-100" id="open-icon-modal">
                                            <i class="ri-search-line me-1"></i> Browse More Icons
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Icon Picker Modal -->
                    <div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="iconPickerModalLabel">
                                        <i class="ri-palette-line me-2"></i>Choose Icon
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="icon-search" placeholder="Search icons...">
                                    </div>
                                    <div id="icon-grid" class="d-flex flex-wrap gap-2" style="max-height: 400px; overflow-y: auto;">
                                        <!-- Icons will be populated here -->
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

    <!-- App js -->
    <script src="/js/app.js"></script>

    <!-- Select2 js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Popular Remix Icons list
            const popularIcons = [
                'ri-computer-line', 'ri-heart-pulse-line', 'ri-bank-line', 'ri-book-open-line',
                'ri-settings-3-line', 'ri-megaphone-line', 'ri-team-line', 'ri-building-3-line',
                'ri-car-line', 'ri-restaurant-line', 'ri-shopping-bag-line', 'ri-paint-brush-line',
                'ri-home-line', 'ri-user-line', 'ri-briefcase-line', 'ri-graduation-cap-line',
                'ri-stethoscope-line', 'ri-tools-line', 'ri-camera-line', 'ri-music-line',
                'ri-artboard-line', 'ri-flask-line', 'ri-plant-line', 'ri-truck-line',
                'ri-plane-line', 'ri-ship-line', 'ri-rocket-line', 'ri-earth-line',
                'ri-fire-line', 'ri-lightbulb-line', 'ri-shield-line', 'ri-award-line'
            ];

            // Initialize Select2
            $('#parent_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select Parent Category (Optional)',
                allowClear: true
            });

            // Live preview updates - Name
            $('#name').on('input keyup paste', function() {
                const name = $(this).val().trim() || 'Category Name';
                $('#preview-name').text(name);
            });

            // Live preview updates - Description
            $('#description').on('input keyup paste', function() {
                let description = $(this).val().trim();
                if (description.length === 0) {
                    description = 'Category description will appear here...';
                } else if (description.length > 100) {
                    description = description.substring(0, 100) + '...';
                }
                $('#preview-description').text(description);
            });

            // Status change handler (radio buttons)
            $('input[name="status"]').on('change', function() {
                const status = $(this).val();
                const badge = $('#preview-status');
                
                if (status === 'active') {
                    badge.removeClass('bg-danger-subtle text-danger')
                         .addClass('bg-success-subtle text-success')
                         .html('<i class="ri-check-line me-1"></i>Active');
                } else {
                    badge.removeClass('bg-success-subtle text-success')
                         .addClass('bg-danger-subtle text-danger')
                         .html('<i class="ri-close-line me-1"></i>Inactive');
                }
            });

            // Icon selection and preview
            function updateIcon(iconClass) {
                if (!iconClass || iconClass.trim() === '') {
                    iconClass = 'ri-folder-line';
                }
                
                $('#icon').val(iconClass);
                $('#selected-icon').removeClass().addClass(iconClass);
                $('#preview-icon i').removeClass().addClass(iconClass);
            }

            // Icon input change
            $('#icon').on('input keyup paste', function() {
                const iconClass = $(this).val().trim() || 'ri-folder-line';
                $('#selected-icon').removeClass().addClass(iconClass);
                $('#preview-icon i').removeClass().addClass(iconClass);
                
                // Update active state for popular icons
                $('.icon-option').removeClass('btn-primary').addClass('btn-outline-primary');
                $('.icon-option[data-icon="' + iconClass + '"]').removeClass('btn-outline-primary').addClass('btn-primary');
            });

            // Popular icon buttons
            $(document).on('click', '.icon-option', function(e) {
                e.preventDefault();
                const iconClass = $(this).data('icon');
                updateIcon(iconClass);
                
                // Update active state
                $('.icon-option').removeClass('btn-primary').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            });

            // Icon picker button
            $('#icon-picker-btn').on('click', function(e) {
                e.preventDefault();
                $('#iconPickerModal').modal('show');
                loadIconGrid();
            });

            // Open icon modal button
            $('#open-icon-modal').on('click', function(e) {
                e.preventDefault();
                $('#iconPickerModal').modal('show');
                loadIconGrid();
            });

            // Load icon grid
            function loadIconGrid() {
                const iconGrid = $('#icon-grid');
                iconGrid.empty();
                
                popularIcons.forEach(function(iconClass) {
                    const button = $(`
                        <button type="button" class="btn btn-outline-secondary btn-sm icon-modal-option" data-icon="${iconClass}" style="width: 50px; height: 50px;">
                            <i class="${iconClass}"></i>
                        </button>
                    `);
                    iconGrid.append(button);
                });
            }

            // Modal icon selection
            $(document).on('click', '.icon-modal-option', function(e) {
                e.preventDefault();
                const iconClass = $(this).data('icon');
                updateIcon(iconClass);
                $('#iconPickerModal').modal('hide');
                
                // Update popular icons active state
                $('.icon-option').removeClass('btn-primary').addClass('btn-outline-primary');
                $('.icon-option[data-icon="' + iconClass + '"]').removeClass('btn-outline-primary').addClass('btn-primary');
            });

            // Icon search functionality
            $('#icon-search').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.icon-modal-option').each(function() {
                    const iconClass = $(this).data('icon');
                    if (iconClass.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Character counters
            function updateCharCounter(input, counter, maxLength) {
                input.on('input keyup paste', function() {
                    const currentLength = $(this).val().length;
                    counter.text(currentLength + '/' + maxLength);
                    
                    if (currentLength > maxLength) {
                        counter.removeClass('text-muted text-warning').addClass('text-danger');
                    } else if (currentLength > maxLength * 0.8) {
                        counter.removeClass('text-muted text-danger').addClass('text-warning');
                    } else {
                        counter.removeClass('text-warning text-danger').addClass('text-muted');
                    }
                });
                
                // Initialize counter
                input.trigger('input');
            }

            updateCharCounter($('#meta_title'), $('#meta-title-count'), 60);
            updateCharCounter($('#meta_description'), $('#meta-desc-count'), 160);

            // Set current icon as active
            const currentIcon = $('#icon').val();
            $('.icon-option[data-icon="' + currentIcon + '"]').removeClass('btn-outline-primary').addClass('btn-primary');

            // Form validation and submission
            $('#editCategoryForm').on('submit', function(e) {
                const name = $('#name').val().trim();
                
                if (!name) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Category name is required',
                        confirmButtonColor: '#dc3545'
                    });
                    $('#name').focus();
                    return false;
                }

                // Show loading
                Swal.fire({
                    title: 'Updating Category...',
                    html: 'Please wait while we update the category',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    </script>

    <style>
    .icon-option {
        width: 45px;
        height: 45px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        border-width: 1px;
    }

    .icon-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .icon-option.btn-primary {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .icon-modal-option {
        transition: all 0.2s ease;
    }

    .icon-modal-option:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    #preview-icon {
        transition: all 0.3s ease;
    }

    .avatar-title {
        transition: all 0.3s ease;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .text-warning {
        color: #f39c12 !important;
    }

    .text-danger {
        color: #e74c3c !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    /* Radio button styling */
    .form-check-input[type="radio"] {
        display: none;
    }

    .form-check-label {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-check-label:hover .badge {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-check-input[type="radio"]:checked + .form-check-label .badge {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        font-weight: 600;
    }

    .form-check-input[type="radio"]:not(:checked) + .form-check-label .badge {
        opacity: 0.7;
        filter: grayscale(20%);
    }

    .badge {
        transition: all 0.2s ease;
        padding: 0.5em 1em;
        font-size: 0.875em;
    }

    /* Preview card enhancements */
    #preview-name {
        transition: all 0.3s ease;
        min-height: 1.5rem;
    }

    #preview-description {
        transition: all 0.3s ease;
        min-height: 3rem;
        line-height: 1.5;
    }

    #preview-status {
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