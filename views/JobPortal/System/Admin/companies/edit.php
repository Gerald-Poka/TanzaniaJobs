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

                    <form method="POST" id="companyForm">
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
                                                    <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($company['name']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($company['email']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($company['phone']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="website" class="form-label">Website URL</label>
                                                    <input type="url" class="form-control" id="website" name="website" value="<?php echo htmlspecialchars($company['website']); ?>" placeholder="https://example.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="founded_year" class="form-label">Founded Year</label>
                                                    <input type="number" class="form-control" id="founded_year" name="founded_year" value="<?php echo $company['founded_year']; ?>" min="1800" max="2025">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Company Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Brief description about the company"><?php echo htmlspecialchars($company['description']); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-map-pin-line me-2"></i>Location Information
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <textarea class="form-control" id="address" name="address" rows="2" placeholder="Full company address"><?php echo htmlspecialchars($company['address']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="city" class="form-label">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($company['city']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="country" class="form-label">Country</label>
                                                    <select class="form-select" id="country" name="country">
                                                        <option value="">Select Country</option>
                                                        <option value="US" <?php echo $company['country'] === 'TZ' ? 'selected' : ''; ?>>Tanzanzia</option>
                                                        <option value="CA" <?php echo $company['country'] === 'CA' ? 'selected' : ''; ?>>Canada</option>
                                                        <option value="UK" <?php echo $company['country'] === 'UK' ? 'selected' : ''; ?>>United Kingdom</option>
                                                        <option value="AU" <?php echo $company['country'] === 'AU' ? 'selected' : ''; ?>>Australia</option>
                                                        <option value="DE" <?php echo $company['country'] === 'DE' ? 'selected' : ''; ?>>Germany</option>
                                                        <option value="FR" <?php echo $company['country'] === 'FR' ? 'selected' : ''; ?>>France</option>
                                                        <option value="IN" <?php echo $company['country'] === 'IN' ? 'selected' : ''; ?>>India</option>
                                                        <option value="SG" <?php echo $company['country'] === 'SG' ? 'selected' : ''; ?>>Singapore</option>
                                                        <option value="Other" <?php echo $company['country'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Details -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-building-line me-2"></i>Company Details
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="industry" class="form-label">Industry</label>
                                                    <select class="form-select" id="industry" name="industry">
                                                        <option value="">Select Industry</option>
                                                        <option value="Technology" <?php echo $company['industry'] === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                                                        <option value="Healthcare" <?php echo $company['industry'] === 'Healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                                                        <option value="Finance" <?php echo $company['industry'] === 'Finance' ? 'selected' : ''; ?>>Finance & Banking</option>
                                                        <option value="Education" <?php echo $company['industry'] === 'Education' ? 'selected' : ''; ?>>Education</option>
                                                        <option value="Manufacturing" <?php echo $company['industry'] === 'Manufacturing' ? 'selected' : ''; ?>>Manufacturing</option>
                                                        <option value="Retail" <?php echo $company['industry'] === 'Retail' ? 'selected' : ''; ?>>Retail & E-commerce</option>
                                                        <option value="Marketing" <?php echo $company['industry'] === 'Marketing' ? 'selected' : ''; ?>>Marketing & Advertising</option>
                                                        <option value="Consulting" <?php echo $company['industry'] === 'Consulting' ? 'selected' : ''; ?>>Consulting</option>
                                                        <option value="Real Estate" <?php echo $company['industry'] === 'Real Estate' ? 'selected' : ''; ?>>Real Estate</option>
                                                        <option value="Automotive" <?php echo $company['industry'] === 'Automotive' ? 'selected' : ''; ?>>Automotive</option>
                                                        <option value="Media" <?php echo $company['industry'] === 'Media' ? 'selected' : ''; ?>>Media & Entertainment</option>
                                                        <option value="Non-profit" <?php echo $company['industry'] === 'Non-profit' ? 'selected' : ''; ?>>Non-profit</option>
                                                        <option value="Government" <?php echo $company['industry'] === 'Government' ? 'selected' : ''; ?>>Government</option>
                                                        <option value="Other" <?php echo $company['industry'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="size_range" class="form-label">Company Size</label>
                                                    <select class="form-select" id="size_range" name="size_range">
                                                        <option value="">Select Company Size</option>
                                                        <option value="1-10" <?php echo $company['size_range'] === '1-10' ? 'selected' : ''; ?>>1-10 employees</option>
                                                        <option value="11-50" <?php echo $company['size_range'] === '11-50' ? 'selected' : ''; ?>>11-50 employees</option>
                                                        <option value="51-200" <?php echo $company['size_range'] === '51-200' ? 'selected' : ''; ?>>51-200 employees</option>
                                                        <option value="201-500" <?php echo $company['size_range'] === '201-500' ? 'selected' : ''; ?>>201-500 employees</option>
                                                        <option value="501-1000" <?php echo $company['size_range'] === '501-1000' ? 'selected' : ''; ?>>501-1000 employees</option>
                                                        <option value="1001-5000" <?php echo $company['size_range'] === '1001-5000' ? 'selected' : ''; ?>>1001-5000 employees</option>
                                                        <option value="5000+" <?php echo $company['size_range'] === '5000+' ? 'selected' : ''; ?>>5000+ employees</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="col-lg-4">
                                <!-- Company Status -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-settings-2-line me-2"></i>Company Status
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <label class="form-label d-block mb-3">Status</label>
                                            <div class="status-selector">
                                                <div class="row g-3">
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="status" id="status-active" value="active" autocomplete="off" <?php echo $company['status'] === 'active' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-success w-100 text-start p-3" for="status-active">
                                                            <i class="ri-check-line fs-5 me-2"></i>
                                                            <span class="fw-medium">Active</span>
                                                            <small class="d-block text-muted mt-1">Company is operational</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="status" id="status-pending" value="pending" autocomplete="off" <?php echo $company['status'] === 'pending' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-warning w-100 text-start p-3" for="status-pending">
                                                            <i class="ri-time-line fs-5 me-2"></i>
                                                            <span class="fw-medium">Pending</span>
                                                            <small class="d-block text-muted mt-1">Awaiting review</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="status" id="status-inactive" value="inactive" autocomplete="off" <?php echo $company['status'] === 'inactive' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-secondary w-100 text-start p-3" for="status-inactive">
                                                            <i class="ri-pause-circle-line fs-5 me-2"></i>
                                                            <span class="fw-medium">Inactive</span>
                                                            <small class="d-block text-muted mt-1">Temporarily disabled</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="radio" class="btn-check" name="status" id="status-suspended" value="suspended" autocomplete="off" <?php echo $company['status'] === 'suspended' ? 'checked' : ''; ?>>
                                                        <label class="btn btn-outline-danger w-100 text-start p-3" for="status-suspended">
                                                            <i class="ri-forbid-line fs-5 me-2"></i>
                                                            <span class="fw-medium">Suspended</span>
                                                            <small class="d-block text-muted mt-1">Account suspended</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="verified" name="verified" <?php echo $company['verified'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="verified">
                                                Verified Company
                                            </label>
                                            <small class="form-text text-muted">Mark company as verified</small>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="featured" name="featured" <?php echo $company['featured'] ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="featured">
                                                Featured Company
                                            </label>
                                            <small class="form-text text-muted">Featured companies appear prominently</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo Upload -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-image-line me-2"></i>Company Logo
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">Logo URL</label>
                                            <input type="url" class="form-control" id="logo" name="logo" value="<?php echo htmlspecialchars($company['logo']); ?>" placeholder="https://example.com/logo.png">
                                            <small class="form-text text-muted">Enter a URL to the company logo image</small>
                                        </div>
                                        
                                        <div class="logo-preview mt-3" id="logoPreview" <?php echo !empty($company['logo']) ? '' : 'style="display: none;"'; ?>>
                                            <img src="<?php echo htmlspecialchars($company['logo']); ?>" alt="Logo Preview" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Info -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-information-line me-2"></i>Company Info
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
                                            <span class="fw-medium"><?php echo date('M d, Y', strtotime($company['created_at'])); ?></span>
                                        </div>
                                        
                                        <div class="mb-0">
                                            <small class="text-muted d-block">Last Updated</small>
                                            <span class="fw-medium"><?php echo date('M d, Y', strtotime($company['updated_at'])); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="ri-save-line me-1"></i>Update Company
                                            </button>
                                            <a href="/admin/companies/view/<?php echo $company['id']; ?>" class="btn btn-outline-info">
                                                <i class="ri-eye-line me-1"></i>View Company
                                            </a>
                                            <a href="/admin/companies/all" class="btn btn-outline-secondary">
                                                <i class="ri-arrow-left-line me-1"></i>Back to Companies
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
            $('#country, #industry, #size_range').select2({
                theme: 'bootstrap-5',
                placeholder: function() {
                    return $(this).find('option:first').text();
                },
                allowClear: true
            });

            // Logo preview
            $('#logo').on('input', function() {
                const logoUrl = $(this).val();
                if (logoUrl && isValidUrl(logoUrl)) {
                    $('#logoPreview img').attr('src', logoUrl);
                    $('#logoPreview').show();
                } else {
                    $('#logoPreview').hide();
                }
            });

            // Form validation
            $('#companyForm').on('submit', function(e) {
                let isValid = true;
                const requiredFields = ['name', 'email'];
                
                requiredFields.forEach(function(field) {
                    const $field = $(`#${field}`);
                    if (!$field.val()) {
                        $field.addClass('is-invalid');
                        isValid = false;
                    } else {
                        $field.removeClass('is-invalid');
                    }
                });

                // Validate email format
                const email = $('#email').val();
                if (email && !isValidEmail(email)) {
                    $('#email').addClass('is-invalid');
                    isValid = false;
                }

                // Validate website URL format
                const website = $('#website').val();
                if (website && !isValidUrl(website)) {
                    $('#website').addClass('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields with valid data'
                    });
                }
            });

            // Remove validation errors on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Utility functions
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function isValidUrl(url) {
                try {
                    new URL(url);
                    return true;
                } catch (_) {
                    return false;
                }
            }
        });
    </script>

    <style>
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .logo-preview img {
            object-fit: contain;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .is-invalid {
            border-color: #dc3545;
        }
        
        .form-text {
            font-size: 0.875em;
        }

        .status-selector .btn-check:checked + .btn {
            border-width: 2px;
        }
    </style>
</body>
</html>