<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>
    
    <!-- Select2 -->
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

                    <form method="POST" id="jobForm">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        
                        <div class="row">
                            <!-- Main Content -->
                            <div class="col-lg-8">
                                <!-- Basic Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-information-line me-2"></i>Basic Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="company_id" class="form-label">Company</label>
                                                    <select class="form-select" id="company_id" name="company_id">
                                                        <option value="">Select Company</option>
                                                        <?php foreach($companies as $company): ?>
                                                            <option value="<?php echo $company['id']; ?>"><?php echo htmlspecialchars($company['name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="category_id" class="form-label">Category</label>
                                                    <select class="form-select" id="category_id" name="category_id">
                                                        <option value="">Select Category</option>
                                                        <?php foreach($categories as $category): ?>
                                                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="short_description" class="form-label">Short Description</label>
                                                    <textarea class="form-control" id="short_description" name="short_description" rows="2" placeholder="Brief job summary"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Job Description <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="description" name="description" rows="8" required placeholder="Detailed job description"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="requirements" class="form-label">Requirements</label>
                                                    <textarea class="form-control" id="requirements" name="requirements" rows="5" placeholder="Job requirements"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="benefits" class="form-label">Benefits & Perks</label>
                                                    <textarea class="form-control" id="benefits" name="benefits" rows="4" placeholder="Benefits and perks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Details -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-settings-line me-2"></i>Job Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="job_type" class="form-label">Job Type <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="job_type" name="job_type" required>
                                                        <option value="">Select Job Type</option>
                                                        <option value="full-time">Full Time</option>
                                                        <option value="part-time">Part Time</option>
                                                        <option value="contract">Contract</option>
                                                        <option value="freelance">Freelance</option>
                                                        <option value="internship">Internship</option>
                                                        <option value="temporary">Temporary</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="location_type" class="form-label">Work Type <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="location_type" name="location_type" required>
                                                        <option value="">Select Work Type</option>
                                                        <option value="onsite">On-site</option>
                                                        <option value="remote">Remote</option>
                                                        <option value="hybrid">Hybrid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="experience_level" class="form-label">Experience Level <span class="text-danger">*</span></label>
                                                    <select class="form-select" id="experience_level" name="experience_level" required>
                                                        <option value="">Select Experience Level</option>
                                                        <option value="entry">Entry Level</option>
                                                        <option value="junior">Junior</option>
                                                        <option value="mid">Mid Level</option>
                                                        <option value="senior">Senior</option>
                                                        <option value="lead">Lead</option>
                                                        <option value="executive">Executive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="education_level" class="form-label">Education Level</label>
                                                    <select class="form-select" id="education_level" name="education_level">
                                                        <option value="high-school">High School</option>
                                                        <option value="diploma">Diploma</option>
                                                        <option value="bachelor" selected>Bachelor's Degree</option>
                                                        <option value="master">Master's Degree</option>
                                                        <option value="phd">PhD</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Job Location</label>
                                                    <input type="text" class="form-control" id="location" name="location" placeholder="e.g. New York, NY or Remote">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-lg-4">
                                <!-- Salary Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-money-dollar-line me-2"></i>Salary Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="salary_currency" class="form-label">Currency</label>
                                                    <select class="form-select" id="salary_currency" name="salary_currency">
                                                        <option value="USD" selected>USD ($)</option>
                                                        <option value="EUR">Tsh ($)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="salary_min" class="form-label">Min Salary</label>
                                                    <input type="number" class="form-control" id="salary_min" name="salary_min" placeholder="50000">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="salary_max" class="form-label">Max Salary</label>
                                                    <input type="number" class="form-control" id="salary_max" name="salary_max" placeholder="80000">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="salary_period" class="form-label">Pay Period</label>
                                                    <select class="form-select" id="salary_period" name="salary_period">
                                                        <option value="hourly">Hourly</option>
                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly" selected>Monthly</option>
                                                        <option value="yearly">Yearly</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Settings -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-settings-2-line me-2"></i>Job Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <div class="status-selector">
                                                <div class="btn-group w-100" role="group" aria-label="Job status options">
                                                    <input type="radio" class="btn-check" name="status" id="status-draft" value="draft" autocomplete="off">
                                                    <label class="btn btn-outline-secondary" for="status-draft">
                                                        <i class="ri-draft-line me-1"></i> Draft
                                                    </label>
                                                    
                                                    <input type="radio" class="btn-check" name="status" id="status-pending" value="pending" checked autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="status-pending">
                                                        <i class="ri-time-line me-1"></i> Pending Review
                                                    </label>
                                                    
                                                    <input type="radio" class="btn-check" name="status" id="status-published" value="published" autocomplete="off">
                                                    <label class="btn btn-outline-success" for="status-published">
                                                        <i class="ri-check-double-line me-1"></i> Published
                                                    </label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted mt-2">Select the publication status for this job listing</small>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="expires_at" class="form-label">Expiry Date</label>
                                            <input type="datetime-local" class="form-control" id="expires_at" name="expires_at">
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="featured" name="featured">
                                            <label class="form-check-label" for="featured">
                                                Featured Job
                                            </label>
                                            <small class="form-text text-muted">Featured jobs appear at the top of listings</small>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="urgent" name="urgent">
                                            <label class="form-check-label" for="urgent">
                                                Urgent Hiring
                                            </label>
                                            <small class="form-text text-muted">Mark as urgent for faster hiring</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ri-save-line me-1"></i>Create Job
                                            </button>
                                            <a href="/admin/jobs/all" class="btn btn-outline-secondary">
                                                <i class="ri-arrow-left-line me-1"></i>Back to Jobs
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

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

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#company_id, #category_id').select2({
                theme: 'bootstrap-5',
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: true
            });

            // Form validation
            $('#jobForm').on('submit', function(e) {
                let isValid = true;
                const requiredFields = ['title', 'description', 'job_type', 'location_type', 'experience_level'];
                
                requiredFields.forEach(function(field) {
                    const $field = $(`#${field}`);
                    if (!$field.val()) {
                        $field.addClass('is-invalid');
                        isValid = false;
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields'
                    });
                }
            });

            // Remove validation errors on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
</body>
</html>