<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>
    
    <!-- Select2 CSS -->
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Search', 'title'=>$title)); ?>

                    <!-- Debug Information -->
                    <?php if (isset($error)): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <h5>Error:</h5>
                                <p><?php echo htmlspecialchars($error); ?></p>
                                <hr>
                                <p><strong>What to do:</strong></p>
                                <ol>
                                    <li>Go to Admin Panel → Jobs → Create Job to add some jobs first</li>
                                    <li>Make sure the jobs are set to "Published" status</li>
                                    <li>Check that the database tables exist</li>
                                </ol>
                                <a href="/admin/jobs/create" class="btn btn-primary">Create Jobs in Admin</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>


                    <!-- Search and Filters -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-search-line me-2"></i>Search Jobs
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" id="jobSearchForm">
                                        <div class="row g-3">
                                            <!-- Search Keywords -->
                                            <div class="col-md-4">
                                                <label class="form-label">Job Title or Keywords</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-search-line"></i></span>
                                                    <input type="text" class="form-control" name="search" 
                                                           value="<?php echo htmlspecialchars($filters['search']); ?>" 
                                                           placeholder="e.g. Software Developer">
                                                </div>
                                            </div>
                                            
                                            <!-- Location -->
                                            <div class="col-md-4">
                                                <label class="form-label">Location</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                                                    <select class="form-select" name="location" id="locationSelect">
                                                        <option value="">All Locations</option>
                                                        <?php foreach($locations as $location): ?>
                                                            <option value="<?php echo htmlspecialchars($location); ?>" 
                                                                    <?php echo $filters['location'] === $location ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($location); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Category -->
                                            <div class="col-md-4">
                                                <label class="form-label">Category</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-bookmark-line"></i></span>
                                                    <select class="form-select" name="category" id="categorySelect">
                                                        <option value="">All Categories</option>
                                                        <?php foreach($categories as $category): ?>
                                                            <option value="<?php echo htmlspecialchars($category['slug']); ?>" 
                                                                    <?php echo $filters['category'] === $category['slug'] ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($category['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Job Type -->
                                            <div class="col-md-3">
                                                <label class="form-label">Job Type</label>
                                                <select class="form-select" name="job_type">
                                                    <option value="">All Types</option>
                                                    <option value="full-time" <?php echo $filters['job_type'] === 'full-time' ? 'selected' : ''; ?>>Full Time</option>
                                                    <option value="part-time" <?php echo $filters['job_type'] === 'part-time' ? 'selected' : ''; ?>>Part Time</option>
                                                    <option value="contract" <?php echo $filters['job_type'] === 'contract' ? 'selected' : ''; ?>>Contract</option>
                                                    <option value="freelance" <?php echo $filters['job_type'] === 'freelance' ? 'selected' : ''; ?>>Freelance</option>
                                                    <option value="internship" <?php echo $filters['job_type'] === 'internship' ? 'selected' : ''; ?>>Internship</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Experience Level -->
                                            <div class="col-md-3">
                                                <label class="form-label">Experience Level</label>
                                                <select class="form-select" name="experience_level">
                                                    <option value="">All Levels</option>
                                                    <option value="entry" <?php echo $filters['experience_level'] === 'entry' ? 'selected' : ''; ?>>Entry Level</option>
                                                    <option value="junior" <?php echo $filters['experience_level'] === 'junior' ? 'selected' : ''; ?>>Junior Level</option>
                                                    <option value="mid" <?php echo $filters['experience_level'] === 'mid' ? 'selected' : ''; ?>>Mid Level</option>
                                                    <option value="senior" <?php echo $filters['experience_level'] === 'senior' ? 'selected' : ''; ?>>Senior Level</option>
                                                    <option value="lead" <?php echo $filters['experience_level'] === 'lead' ? 'selected' : ''; ?>>Lead Level</option>
                                                    <option value="executive" <?php echo $filters['experience_level'] === 'executive' ? 'selected' : ''; ?>>Executive</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Salary Range -->
                                            <div class="col-md-3">
                                                <label class="form-label">Min Salary (TSH)</label>
                                                <input type="number" class="form-control" name="salary_min" 
                                                       value="<?php echo htmlspecialchars($filters['salary_min']); ?>" 
                                                       placeholder="Min">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label class="form-label">Max Salary (TSH)</label>
                                                <input type="number" class="form-control" name="salary_max" 
                                                       value="<?php echo htmlspecialchars($filters['salary_max']); ?>" 
                                                       placeholder="Max">
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ri-search-line me-1"></i>Search Jobs
                                                    </button>
                                                    <a href="/jobs/browse" class="btn btn-outline-secondary">
                                                        <i class="ri-refresh-line me-1"></i>Clear Filters
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Summary -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="mb-1">Found <?php echo number_format($totalCount); ?> Jobs</h5>
                                    <p class="text-muted mb-0">
                                        <?php if ($totalCount > 0): ?>
                                            Showing page <?php echo $pagination->page + 1; ?> of <?php echo $pagination->pageCount; ?>
                                        <?php else: ?>
                                            No jobs available
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <?php if ($totalCount > 0): ?>
                                <div class="d-flex gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="ri-sort-desc me-1"></i>Sort By
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($filters, ['sort' => 'newest'])); ?>">Newest First</a></li>
                                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($filters, ['sort' => 'salary_high'])); ?>">Salary: High to Low</a></li>
                                            <li><a class="dropdown-item" href="?<?php echo http_build_query(array_merge($filters, ['sort' => 'salary_low'])); ?>">Salary: Low to High</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Job Listings -->
                    <div class="row">
                        <?php if(empty($jobs)): ?>
                            <!-- No Jobs Found -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                <i class="ri-briefcase-line fs-1"></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-3">No Jobs Found</h5>
                                        <?php if ($totalCount == 0): ?>
                                            <p class="text-muted mb-4">
                                                No jobs have been posted yet. Please check back later or contact the administrator.
                                            </p>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="/admin/jobs/create" class="btn btn-primary">
                                                    <i class="ri-add-line me-1"></i>Create Jobs (Admin)
                                                </a>
                                                <a href="/admin/jobs/all" class="btn btn-outline-primary">
                                                    <i class="ri-list-check me-1"></i>View All Jobs (Admin)
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted mb-4">
                                                We couldn't find any jobs matching your criteria. Try adjusting your search filters.
                                            </p>
                                            <a href="/jobs/browse" class="btn btn-primary">
                                                <i class="ri-refresh-line me-1"></i>Reset Search
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($jobs as $job): ?>
    <div class="col-lg-6 col-xl-4">
        <div class="card job-card h-100">
            <div class="card-body">
                <!-- Company Info -->
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm me-3">
                        <?php if(!empty($job['company_logo'])): ?>
                            <img src="<?php echo htmlspecialchars($job['company_logo']); ?>" 
                                 alt="<?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?>" 
                                 class="avatar-title rounded">
                        <?php else: ?>
                            <div class="avatar-title bg-secondary-subtle text-secondary rounded">
                                <?php echo strtoupper(substr($job['company_name'] ?? 'C', 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h6 class="mb-1"><?php echo htmlspecialchars($job['company_name'] ?? 'Company'); ?></h6>
                        <div>
                            <?php if(!empty($job['company_verified']) && $job['company_verified'] == 1): ?>
                                <span class="badge bg-info-subtle text-info"><i class="ri-check-line me-1"></i>Verified</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Job Title -->
                <h5 class="job-title mb-2">
                    <a href="/jobs/view/<?php echo htmlspecialchars($job['id']); ?>">
                        <?php echo htmlspecialchars($job['title']); ?>
                    </a>
                </h5>

                <!-- Job Short Description -->
                <p class="text-muted job-description mb-3">
                    <?php echo htmlspecialchars(substr($job['short_description'] ?? $job['description'] ?? '', 0, 100) . '...'); ?>
                </p>

                <!-- Job Meta -->
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <?php if(!empty($job['location'])): ?>
                    <span class="badge bg-light text-body">
                        <i class="ri-map-pin-line me-1"></i><?php echo htmlspecialchars($job['location']); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php if(!empty($job['job_type'])): ?>
                    <span class="badge bg-light text-body">
                        <i class="ri-briefcase-line me-1"></i><?php echo ucfirst(str_replace('-', ' ', $job['job_type'])); ?>
                    </span>
                    <?php endif; ?>
                    
                    <?php if(!empty($job['salary_min']) || !empty($job['salary_max'])): ?>
                    <span class="badge bg-light text-body">
                        <i class="ri-money-dollar-circle-line me-1"></i>
                        <?php 
                            $currency = $job['salary_currency'] ?? 'USD';
                            if(!empty($job['salary_min']) && !empty($job['salary_max'])) {
                                echo $currency . ' ' . number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']);
                            } elseif (!empty($job['salary_min'])) {
                                echo $currency . ' ' . number_format($job['salary_min']) . '+';
                            } elseif (!empty($job['salary_max'])) {
                                echo 'Up to ' . $currency . ' ' . number_format($job['salary_max']);
                            }
                        ?>
                    </span>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/jobs/view/<?php echo $job['id']; ?>" class="btn btn-sm btn-primary">
                        <i class="ri-eye-line me-1"></i>View Details
                    </a>
                    
                    <div>
                        <?php if(!empty($job['featured']) && $job['featured'] == 1): ?>
                        <span class="badge bg-warning-subtle text-warning">
                            <i class="ri-star-line me-1"></i>Featured
                        </span>
                        <?php endif; ?>
                        
                        <?php if(!empty($job['urgent']) && $job['urgent'] == 1): ?>
                        <span class="badge bg-danger-subtle text-danger">
                            <i class="ri-timer-flash-line me-1"></i>Urgent
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <?php if($pagination->pageCount > 1): ?>
                        <div class="row">
                            <div class="col-12">
                                <nav aria-label="Job listings pagination">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Page -->
                                        <?php if($pagination->page > 0): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?<?php echo http_build_query(array_merge($filters, ['page' => $pagination->page - 1])); ?>">
                                                    <i class="ri-arrow-left-line me-1"></i>Previous
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- Page Numbers -->
                                        <?php for($i = max(0, $pagination->page - 2); $i <= min($pagination->pageCount - 1, $pagination->page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $pagination->page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?php echo http_build_query(array_merge($filters, ['page' => $i])); ?>">
                                                    <?php echo $i + 1; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next Page -->
                                        <?php if($pagination->page < $pagination->pageCount - 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?<?php echo http_build_query(array_merge($filters, ['page' => $pagination->page + 1])); ?>">
                                                    Next<i class="ri-arrow-right-line ms-1"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
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

    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#locationSelect, #categorySelect').select2({
                theme: 'bootstrap-5',
                allowClear: true,
                placeholder: function() {
                    return $(this).find('option:first').text();
                }
            });
        });

        // Toggle save job function
        async function toggleSaveJob(jobId, button) {
            const isCurrentlySaved = $(button).data('saved') == '1';
            const action = isCurrentlySaved ? 'unsave' : 'save';
            
            try {
                const response = await fetch(`/jobs/${action}/${jobId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '<?= Yii::$app->request->csrfToken ?>'
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
                        if ($(button).hasClass('dropdown-item')) {
                            $(button).html('<i class="ri-bookmark-fill me-2"></i>Remove from Saved');
                        }
                    } else {
                        icon.removeClass('ri-bookmark-fill').addClass('ri-bookmark-line');
                        if ($(button).hasClass('dropdown-item')) {
                            $(button).html('<i class="ri-bookmark-line me-2"></i>Save Job');
                        }
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
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
        .job-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .avatar-sm {
            height: 2.5rem;
            width: 2.5rem;
        }
        
        .avatar-sm .avatar-title {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .avatar-sm img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }
        
        .badge {
            font-size: 0.75rem;
        }
        
        .btn-ghost-secondary {
            color: #6c757d;
            background-color: transparent;
            border: none;
        }
        
        .btn-ghost-secondary:hover {
            color: #495057;
            background-color: rgba(108, 117, 125, 0.1);
        }
        
        .avatar-lg {
            height: 4rem;
            width: 4rem;
        }
        
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 500;
        }
    </style>
</body>
</html>

