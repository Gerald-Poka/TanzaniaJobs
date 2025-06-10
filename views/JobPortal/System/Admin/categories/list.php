<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'Category List')); ?>

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <?php echo $this->render('../partials/head-css'); ?>

    <style>
    .category-card {
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border-color: #405189;
    }

    .category-card .card-body {
        position: relative;
        z-index: 2;
    }

    .category-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 15px;
        transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1);
    }

    .filter-btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        padding: 8px 16px;
    }

    .filter-btn.active {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .search-box {
        position: relative;
    }

    .search-box .search-icon {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #74788d;
    }

    .search-box input {
        padding-left: 40px;
    }

    .bulk-actions {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        backdrop-filter: blur(10px);
    }

    .status-badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(0,0,0,0.1);
    }

    .dropdown-menu {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: 0;
        overflow: hidden;
    }

    .dropdown-item {
        padding: 10px 20px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: translateX(5px);
    }

    .category-grid {
        margin-top: 20px;
    }

    .no-categories {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }

    .view-toggle {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 4px;
    }

    .view-toggle .btn {
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        margin: 0 2px;
    }

    .category-checkbox {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 3;
    }

    .selected-card {
        border-color: #405189 !important;
        box-shadow: 0 0 0 2px rgba(64, 81, 137, 0.2) !important;
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Job Categories')); ?>

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

                    <!-- Header Card with Search and Filters -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-lg-4">
                                            <div class="search-box">
                                                <input type="text" class="form-control search bg-light border-light" id="searchCategories" placeholder="Search for job categories...">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-auto">
                                            <div class="d-flex align-items-center gap-2">
                                                <!-- Filter Buttons -->
                                                <div class="btn-group" role="group" aria-label="Category filters">
                                                    <button type="button" class="btn btn-primary btn-sm filter-btn active" data-filter="all">
                                                        All <span class="badge bg-white text-primary ms-1" id="count-all"><?php echo $totalCategories ?? 0; ?></span>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="active">
                                                        Active <span class="badge bg-success ms-1" id="count-active"><?php echo $activeCategories ?? 0; ?></span>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm filter-btn" data-filter="inactive">
                                                        Inactive <span class="badge bg-danger ms-1" id="count-inactive"><?php echo $inactiveCategories ?? 0; ?></span>
                                                    </button>
                                                </div>

                                                <!-- View Toggle -->
                                                <div class="view-toggle">
                                                    <button type="button" class="btn btn-sm active" id="gridView" title="Grid View">
                                                        <i class="ri-grid-fill"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm" id="listView" title="List View">
                                                        <i class="ri-list-check"></i>
                                                    </button>
                                                </div>

                                                <!-- Actions -->
                                                <a href="/admin/categories/create" class="btn btn-success">
                                                    <i class="ri-add-fill me-1"></i> Add Category
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Actions Bar (Hidden by default) -->
                    <div class="bulk-actions" style="display: none;">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <i class="ri-information-line me-2 fs-16"></i>
                                    <span><strong><span id="selected-count">0</span></strong> categories selected</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-success" onclick="bulkActivate()">
                                        <i class="ri-check-line me-1"></i> Activate
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="bulkDeactivate()">
                                        <i class="ri-close-line me-1"></i> Deactivate
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="bulkDelete()">
                                        <i class="ri-delete-bin-line me-1"></i> Delete
                                    </button>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="deselectAll()">
                                        <i class="ri-close-line me-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Grid -->
                    <?php if(isset($categories) && !empty($categories)): ?>
                        <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 category-grid" id="categoriesGrid">
                            <?php foreach($categories as $index => $category): ?>
                            <div class="col category-item" data-status="<?php echo strtolower($category['status']); ?>" data-name="<?php echo strtolower($category['name']); ?>">
                                <div class="card category-card h-100" data-category-id="<?php echo $category['id']; ?>">
                                    <!-- Selection Checkbox -->
                                    <div class="category-checkbox">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="categoryIds[]" value="<?php echo $category['id']; ?>" id="category_<?php echo $category['id']; ?>">
                                        </div>
                                    </div>

                                    <div class="card-body text-center py-4">
                                        <!-- Category Icon -->
                                        <div class="category-icon bg-primary-subtle text-primary">
                                            <i class="<?php echo $category['icon'] ?? 'ri-folder-line'; ?>"></i>
                                        </div>

                                        <!-- Category Name -->
                                        <a href="/admin/categories/view/<?php echo $category['id']; ?>" class="stretched-link">
                                            <h5 class="mt-3 mb-2"><?php echo htmlspecialchars($category['name']); ?></h5>
                                        </a>

                                        <!-- Category Stats -->
                                        <div class="category-stats">
                                            <div class="text-center">
                                                <small class="text-muted d-block">Jobs</small>
                                                <span class="fw-semibold text-primary"><?php echo $category['jobs_count'] ?? 0; ?></span>
                                            </div>
                                            <div class="text-center">
                                                <small class="text-muted d-block">Skills</small>
                                                <span class="fw-semibold text-success"><?php echo $category['skills_count'] ?? 0; ?></span>
                                            </div>
                                        </div>

                                        <!-- Status Badge -->
                                        <div class="mt-3">
                                            <?php if($category['status'] === 'active'): ?>
                                                <span class="badge bg-success-subtle text-success status-badge">
                                                    <i class="ri-check-line me-1"></i>Active
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger status-badge">
                                                    <i class="ri-close-line me-1"></i>Inactive
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <div class="dropdown" style="position: relative; z-index: 4;">
                                                <button class="btn btn-sm btn-light dropdown-toggle arrow-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.preventDefault(); event.stopPropagation();">
                                                    <i class="ri-more-fill"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="/admin/categories/view/<?php echo $category['id']; ?>" onclick="event.stopPropagation();">
                                                            <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="/admin/categories/edit/<?php echo $category['id']; ?>" onclick="event.stopPropagation();">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="event.stopPropagation(); toggleStatus(<?php echo $category['id']; ?>, '<?php echo $category['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                                            <?php if($category['status'] === 'active'): ?>
                                                                <i class="ri-close-circle-fill align-bottom me-2 text-muted"></i> Deactivate
                                                            <?php else: ?>
                                                                <i class="ri-check-circle-fill align-bottom me-2 text-muted"></i> Activate
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="event.stopPropagation(); deleteCategory(<?php echo $category['id']; ?>, '<?php echo addslashes($category['name']); ?>')">
                                                            <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Info Footer -->
                                    <div class="card-footer bg-light border-top-0 text-center py-2">
                                        <small class="text-muted">
                                            Created: <?php echo date('M d, Y', strtotime($category['created_at'])); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Load More Button -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center mt-4">
                                    <button class="btn btn-link text-secondary" id="loadMore" style="display: none;">
                                        <i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More
                                    </button>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- No Categories Found -->
                        <div class="row">
                            <div class="col-12">
                                <div class="no-categories">
                                    <div class="mb-4">
                                        <i class="ri-folder-open-line" style="font-size: 4rem; color: #74788d;"></i>
                                    </div>
                                    <h4 class="mb-3">No Categories Found</h4>
                                    <p class="text-muted mb-4">Get started by creating your first job category to organize your job listings.</p>
                                    <a href="/admin/categories/create" class="btn btn-primary btn-lg">
                                        <i class="ri-add-line me-2"></i> Create First Category
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php echo $this->render('../partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Scripts -->
    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        $(document).ready(function() {
            let currentFilter = 'all';
            let selectedCategories = new Set();

            // Search functionality
            $('#searchCategories').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();
                filterCategories();
            });

            // Filter functionality
            $('.filter-btn').on('click', function() {
                const filter = $(this).data('filter');
                currentFilter = filter;
                
                // Update button states
                $('.filter-btn').each(function() {
                    const btnFilter = $(this).data('filter');
                    $(this).removeClass('active btn-primary btn-success btn-danger');
                    
                    if (btnFilter === 'all') {
                        $(this).addClass('btn-outline-primary');
                    } else if (btnFilter === 'active') {
                        $(this).addClass('btn-outline-success');
                    } else if (btnFilter === 'inactive') {
                        $(this).addClass('btn-outline-danger');
                    }
                });
                
                // Set active button
                if (filter === 'all') {
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
                } else if (filter === 'active') {
                    $(this).removeClass('btn-outline-success').addClass('btn-success active');
                } else if (filter === 'inactive') {
                    $(this).removeClass('btn-outline-danger').addClass('btn-danger active');
                }
                
                filterCategories();
            });

            // View toggle functionality
            $('#gridView, #listView').on('click', function() {
                $('#gridView, #listView').removeClass('active');
                $(this).addClass('active');
                
                if ($(this).attr('id') === 'listView') {
                    // Convert to list view (you can implement this)
                    // showListView();
                } else {
                    // Convert to grid view
                    // showGridView();
                }
            });

            // Filter categories based on search and status
            function filterCategories() {
                const searchValue = $('#searchCategories').val().toLowerCase();
                let visibleCount = 0;
                let activeCount = 0;
                let inactiveCount = 0;
                let totalCount = 0;

                $('.category-item').each(function() {
                    const categoryName = $(this).data('name');
                    const categoryStatus = $(this).data('status');
                    let showItem = true;

                    // Search filter
                    if (searchValue && categoryName.indexOf(searchValue) === -1) {
                        showItem = false;
                    }

                    // Status filter
                    if (currentFilter !== 'all' && categoryStatus !== currentFilter) {
                        showItem = false;
                    }

                    if (showItem) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }

                    // Count totals
                    totalCount++;
                    if (categoryStatus === 'active') {
                        activeCount++;
                    } else if (categoryStatus === 'inactive') {
                        inactiveCount++;
                    }
                });

                // Update counts
                $('#count-all').text(totalCount);
                $('#count-active').text(activeCount);
                $('#count-inactive').text(inactiveCount);
            }

            // Category card selection
            $('input[name="categoryIds[]"]').on('change', function() {
                const categoryId = $(this).val();
                const isChecked = $(this).prop('checked');
                const card = $(this).closest('.category-card');

                if (isChecked) {
                    selectedCategories.add(categoryId);
                    card.addClass('selected-card');
                } else {
                    selectedCategories.delete(categoryId);
                    card.removeClass('selected-card');
                }

                updateBulkActions();
            });

            // Update bulk actions visibility
            function updateBulkActions() {
                const selectedCount = selectedCategories.size;
                $('#selected-count').text(selectedCount);
                
                if (selectedCount > 0) {
                    $('.bulk-actions').slideDown();
                } else {
                    $('.bulk-actions').slideUp();
                }
            }

            // Select all function
            window.selectAll = function() {
                $('.category-item:visible input[name="categoryIds[]"]').prop('checked', true).trigger('change');
            };

            // Deselect all function
            window.deselectAll = function() {
                $('input[name="categoryIds[]"]').prop('checked', false).trigger('change');
                selectedCategories.clear();
                $('.category-card').removeClass('selected-card');
                updateBulkActions();
            };

            // Initial filter
            filterCategories();
        });

        // Global functions for bulk actions
        function getSelectedIds() {
            return Array.from(document.querySelectorAll('input[name="categoryIds[]"]:checked')).map(cb => cb.value);
        }

        function bulkActivate() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length === 0) {
                Swal.fire('No Selection', 'Please select categories to activate.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Activate Categories',
                text: `Are you sure you want to activate ${selectedIds.length} selected categories?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Yes, activate them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkStatusUpdate(selectedIds, 'active');
                }
            });
        }

        function bulkDeactivate() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length === 0) {
                Swal.fire('No Selection', 'Please select categories to deactivate.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Deactivate Categories',
                text: `Are you sure you want to deactivate ${selectedIds.length} selected categories?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                confirmButtonText: 'Yes, deactivate them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkStatusUpdate(selectedIds, 'inactive');
                }
            });
        }

        function bulkDelete() {
            const selectedIds = getSelectedIds();
            if (selectedIds.length === 0) {
                Swal.fire('No Selection', 'Please select categories to delete.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Delete Categories',
                html: `
                    <div class="text-start">
                        <p class="mb-3">Are you sure you want to delete <strong>${selectedIds.length}</strong> selected categories?</p>
                        <div class="alert alert-danger">
                            <i class="ri-error-warning-line me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone and will remove all associated data.
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    bulkDeleteAction(selectedIds);
                }
            });
        }

        function bulkStatusUpdate(ids, status) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we update the categories.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/categories/bulk-status-update';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
            csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
            form.appendChild(csrfInput);
            
            ids.forEach(id => {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'ids[]';
                idInput.value = id;
                form.appendChild(idInput);
            });
            
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = status;
            form.appendChild(statusInput);
            
            document.body.appendChild(form);
            form.submit();
        }

        function bulkDeleteAction(ids) {
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we delete the categories.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/categories/bulk-delete';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
            csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
            form.appendChild(csrfInput);
            
            ids.forEach(id => {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'ids[]';
                idInput.value = id;
                form.appendChild(idInput);
            });
            
            document.body.appendChild(form);
            form.submit();
        }

        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Confirm Action',
                text: `Do you want to ${newStatus} this category?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: newStatus === 'active' ? '#28a745' : '#dc3545',
                confirmButtonText: `Yes, ${newStatus} it!`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
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

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/categories/toggle-status/' + id;
                    
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

        function deleteCategory(id, name) {
            Swal.fire({
                title: 'Delete Category?',
                html: `
                    <div class="text-start">
                        <p class="mb-3">Are you sure you want to delete <strong>"${name}"</strong>?</p>
                        <div class="alert alert-danger">
                            <i class="ri-error-warning-line me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone and will remove all associated data.
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we delete the category.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/categories/delete/' + id;
                    
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
</body>
</html>