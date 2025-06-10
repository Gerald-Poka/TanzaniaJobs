<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />

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

                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">All Companies</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h2 class="fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" data-target="<?php echo $allCompanies; ?>">0</span>
                                            </h2>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-buildings text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Verified</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h2 class="fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" data-target="<?php echo $verifiedCompanies; ?>">0</span>
                                            </h2>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="bx bx-check-shield text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Pending</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h2 class="fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" data-target="<?php echo $pendingCompanies; ?>">0</span>
                                            </h2>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="bx bx-time-five text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Featured</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h2 class="fw-semibold ff-secondary mb-0">
                                                <span class="counter-value" data-target="<?php echo $featuredCompanies; ?>">0</span>
                                            </h2>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="bx bx-star text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-9">
                            <!-- Search and Filter Card -->
                            <div class="card">
                                <div class="card-body">
                                    <form id="filterForm">
                                        <div class="row g-3">
                                            <div class="col-xxl-5 col-sm-6">
                                                <div class="search-box">
                                                    <input type="text" class="form-control search bg-light border-light" id="searchCompany" placeholder="Search for company, industry type..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-sm-6">
                                                <input type="text" class="form-control bg-light border-light flatpickr-input" id="datepicker" data-date-format="d M, Y" placeholder="Select date" value="<?php echo isset($_GET['date']) ? htmlspecialchars($_GET['date']) : ''; ?>" readonly>
                                            </div>
                                            <div class="col-xxl-2 col-sm-4">
                                                <div class="input-light">
                                                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="statusFilter">
                                                        <option value="all" <?php echo (!isset($filter) || $filter === 'all') ? 'selected' : ''; ?>>All Status</option>
                                                        <option value="active" <?php echo (isset($filter) && $filter === 'active') ? 'selected' : ''; ?>>Active</option>
                                                        <option value="verified" <?php echo (isset($filter) && $filter === 'verified') ? 'selected' : ''; ?>>Verified</option>
                                                        <option value="pending" <?php echo (isset($filter) && $filter === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="featured" <?php echo (isset($filter) && $filter === 'featured') ? 'selected' : ''; ?>>Featured</option>
                                                        <option value="inactive" <?php echo (isset($filter) && $filter === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-sm-4">
                                                <button type="button" class="btn btn-primary w-100" onclick="filterData();">
                                                    <i class="ri-equalizer-fill me-1 align-bottom"></i> Filters
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Companies Grid/List -->
                            <?php if(empty($companies)): ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-5">
                                            <div class="avatar-xl mx-auto mb-4">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded">
                                                    <i class="ri-building-line fs-2"></i>
                                                </div>
                                            </div>
                                            <h5 class="text-muted">No companies found</h5>
                                            <p class="text-muted">Get started by creating your first company.</p>
                                            <a href="/admin/companies/create" class="btn btn-success">
                                                <i class="ri-add-line me-1"></i> Create Company
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row job-list-row" id="companies-list">
                                    <?php foreach($companies as $company): ?>
                                    <div class="col-12">
                                        <div class="card card-height-100">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="avatar-md">
                                                        <?php if(!empty($company['logo'])): ?>
                                                            <img src="<?php echo htmlspecialchars($company['logo']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($company['name']); ?>" 
                                                                 class="avatar-md rounded">
                                                        <?php else: ?>
                                                            <div class="avatar-title bg-light rounded">
                                                                <span class="fs-20 text-primary">
                                                                    <?php echo strtoupper(substr($company['name'], 0, 2)); ?>
                                                                </span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ms-3 flex-grow-1">
                                                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                            <div>
                                                                <a href="/admin/companies/view/<?php echo $company['id']; ?>">
                                                                    <h5 class="mb-1"><?php echo htmlspecialchars($company['name']); ?></h5>
                                                                </a>
                                                                <p class="text-muted mb-2"><?php echo $company['industry'] ? htmlspecialchars($company['industry']) : 'Not specified'; ?></p>
                                                            </div>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                <?php
                                                                $statusClasses = [
                                                                    'active' => 'bg-success-subtle text-success',
                                                                    'pending' => 'bg-warning-subtle text-warning',
                                                                    'inactive' => 'bg-secondary-subtle text-secondary',
                                                                    'suspended' => 'bg-danger-subtle text-danger'
                                                                ];
                                                                $statusClass = $statusClasses[$company['status']] ?? 'bg-secondary-subtle text-secondary';
                                                                ?>
                                                                <span class="badge <?php echo $statusClass; ?>">
                                                                    <?php echo ucfirst($company['status']); ?>
                                                                </span>
                                                                
                                                                <?php if($company['verified']): ?>
                                                                    <span class="badge bg-primary-subtle text-primary">
                                                                        <i class="ri-verified-badge-line me-1"></i>Verified
                                                                    </span>
                                                                <?php endif; ?>
                                                                
                                                                <?php if($company['featured']): ?>
                                                                    <span class="badge bg-info-subtle text-info">
                                                                        <i class="ri-star-line me-1"></i>Featured
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-3">
                                                            <div class="col-lg-6">
                                                                <?php if(!empty($company['email'])): ?>
                                                                    <p class="text-muted mb-1">
                                                                        <i class="ri-mail-line me-1"></i><?php echo htmlspecialchars($company['email']); ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                <?php if(!empty($company['phone'])): ?>
                                                                    <p class="text-muted mb-1">
                                                                        <i class="ri-phone-line me-1"></i><?php echo htmlspecialchars($company['phone']); ?>
                                                                    </p>
                                                                <?php endif; ?>
                                                                <?php if(!empty($company['website'])): ?>
                                                                    <p class="text-muted mb-1">
                                                                        <i class="ri-global-line me-1"></i>
                                                                        <a href="<?php echo htmlspecialchars($company['website']); ?>" target="_blank" class="text-decoration-none">
                                                                            <?php echo str_replace(['http://', 'https://'], '', $company['website']); ?>
                                                                        </a>
                                                                    </p>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="d-flex flex-wrap gap-3">
                                                                    <div>
                                                                        <span class="text-muted">Jobs Posted:</span>
                                                                        <span class="fw-semibold"><?php echo number_format($company['jobs_count']); ?></span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="text-muted">Since:</span>
                                                                        <span class="fw-semibold"><?php echo date('M Y', strtotime($company['created_at'])); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                                            <div class="text-muted">
                                                                <small>Created: <?php echo date('M d, Y', strtotime($company['created_at'])); ?></small>
                                                            </div>
                                                            <div class="d-flex gap-2">
                                                                <a href="/admin/companies/view/<?php echo $company['id']; ?>" 
                                                                   class="btn btn-soft-primary btn-sm" 
                                                                   data-bs-toggle="tooltip" 
                                                                   title="View Details">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                                <a href="/admin/companies/edit/<?php echo $company['id']; ?>" 
                                                                   class="btn btn-soft-success btn-sm" 
                                                                   data-bs-toggle="tooltip" 
                                                                   title="Edit">
                                                                    <i class="ri-pencil-line"></i>
                                                                </a>
                                                                <button class="btn btn-soft-danger btn-sm" 
                                                                        onclick="deleteCompany(<?php echo $company['id']; ?>, '<?php echo addslashes($company['name']); ?>')"
                                                                        data-bs-toggle="tooltip" 
                                                                        title="Delete">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Pagination -->
                                <div class="row g-0 justify-content-end mb-4" id="pagination-element">
                                    <div class="col-sm-6">
                                        <div class="pagination-block pagination pagination-separated justify-content-center justify-content-sm-end mb-sm-0">
                                            <div class="page-item">
                                                <a href="javascript:void(0);" class="page-link" id="page-prev">Previous</a>
                                            </div>
                                            <span id="page-num" class="pagination"></span>
                                            <div class="page-item">
                                                <a href="javascript:void(0);" class="page-link" id="page-next">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Company Overview Sidebar -->
                        <div class="col-xxl-3">
                            <div class="card" id="company-overview">
                                <div class="card-body">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title bg-light rounded">
                                            <i class="ri-building-2-line fs-2 text-muted" id="default-company-icon"></i>
                                            <img src="" alt="" class="avatar-sm company-logo d-none" id="company-logo-img">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <a href="#!" id="company-name-link">
                                            <h5 class="overview-companyname" id="overview-company-name">Select a Company</h5>
                                        </a>
                                        <p class="text-muted overview-industryType" id="overview-industry">Click on a company card to view detailed information</p>

                                        <ul class="list-inline mb-0" id="company-actions">
                                            <li class="list-inline-item avatar-xs">
                                                <a href="javascript:void(0);" class="avatar-title bg-success-subtle text-success fs-15 rounded" id="company-website" title="Website">
                                                    <i class="ri-global-line"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item avatar-xs">
                                                <a href="javascript:void(0);" class="avatar-title bg-danger-subtle text-danger fs-15 rounded" id="company-email" title="Email">
                                                    <i class="ri-mail-line"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item avatar-xs">
                                                <a href="javascript:void(0);" class="avatar-title bg-primary-subtle text-primary fs-15 rounded" id="company-phone" title="Phone">
                                                    <i class="ri-phone-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body" id="company-details" style="display: none;">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Company Information</h6>
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Status</td>
                                                    <td id="overview-status">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Industry</td>
                                                    <td id="overview-industry-detail">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Jobs Posted</td>
                                                    <td id="overview-jobs-count">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Created</td>
                                                    <td id="overview-created">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Website</td>
                                                    <td>
                                                        <a href="#" class="link-primary text-decoration-underline" id="overview-website" target="_blank">-</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Email</td>
                                                    <td id="overview-email-detail">-</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-medium" scope="row">Phone</td>
                                                    <td id="overview-phone-detail">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="hstack gap-2 mt-3">
                                        <a href="#" class="btn btn-soft-primary w-100" id="view-company-btn">
                                            <i class="ri-eye-line me-1"></i> View Details
                                        </a>
                                        <a href="#" class="btn btn-soft-success w-100" id="edit-company-btn">
                                            <i class="ri-pencil-line me-1"></i> Edit
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Quick Actions</h6>
                                    <div class="d-grid gap-2">
                                        <a href="/admin/companies/create" class="btn btn-success">
                                            <i class="ri-add-line me-1"></i> Add New Company
                                        </a>
                                        <a href="/admin/companies/export" class="btn btn-outline-primary">
                                            <i class="ri-download-line me-1"></i> Export Data
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                            <i class="ri-refresh-line me-1"></i> Clear Filters
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats Card -->
                            <div class="card overflow-hidden shadow-none card-border-effect-none border-0">
                                <div class="card-body bg-primary-subtle">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-17">
                                                    <i class="ri-building-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="fs-16">Company Overview</h6>
                                            <p class="text-muted mb-0"><?php echo isset($allCompanies) ? $allCompanies : 0; ?> total companies</p>
                                        </div>
                                        <div>
                                            <a href="/admin/companies/all" class="btn btn-primary btn-sm">View All</a>
                                        </div>
                                    </div }
                                </div>
                                <div class="card-body bg-primary-subtle border-top border-primary border-opacity-25 border-top-dashed">
                                    <a href="/admin/companies/analytics" class="d-flex justify-content-between align-items-center text-body">
                                        <span>View Analytics</span>
                                        <i class="ri-arrow-right-s-line fs-18"></i>
                                    </a>
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

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            // Initialize Flatpickr for date picker
            flatpickr("#datepicker", {
                dateFormat: "d M, Y",
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    // Auto-filter when date is selected
                    filterData();
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Live search functionality
            let searchTimeout;
            $('#searchCompany').on('keyup', function() {
                clearTimeout(searchTimeout);
                const searchValue = $(this).val().toLowerCase();
                
                searchTimeout = setTimeout(function() {
                    $('#companies-list .col-12').each(function() {
                        const companyCard = $(this);
                        const companyText = companyCard.text().toLowerCase();
                        
                        if (companyText.indexOf(searchValue) > -1 || searchValue === '') {
                            companyCard.show();
                        } else {
                            companyCard.hide();
                        }
                    });
                    
                    // Update results count
                    updateResultsCount();
                }, 300);
            });

            // Status filter change
            $('#statusFilter').on('change', function() {
                filterData();
            });

            // Company card click to show details in sidebar
            $(document).on('click', '.card-height-100', function() {
                const companyCard = $(this);
                const companyName = companyCard.find('h5').first().text();
                const companyIndustry = companyCard.find('.text-muted').first().text();
                const companyId = companyCard.find('a[href*="/view/"]').attr('href').split('/').pop();
                
                // Extract company data from the card
                const companyData = {
                    id: companyId,
                    name: companyName,
                    industry: companyIndustry,
                    email: companyCard.find('i.ri-mail-line').parent().text().replace(/^\s*\S+\s*/, '').trim(),
                    phone: companyCard.find('i.ri-phone-line').parent().text().replace(/^\s*\S+\s*/, '').trim(),
                    website: companyCard.find('i.ri-global-line').parent().find('a').attr('href') || '',
                    status: companyCard.find('.badge').first().text(),
                    jobsCount: companyCard.find('.fw-semibold').first().text(),
                    created: companyCard.find('small').text().replace('Created: ', ''),
                    logo: companyCard.find('img').attr('src') || ''
                };
                
                updateCompanyOverview(companyData);
            });
        });

        // Update results count
        function updateResultsCount() {
            const visibleCards = $('#companies-list .col-12:visible').length;
            const totalCards = $('#companies-list .col-12').length;
            
            // You can add a results counter here if needed
            console.log(`Showing ${visibleCards} of ${totalCards} companies`);
        }

        // Update company overview sidebar
        function updateCompanyOverview(companyData) {
            // Update company logo
            if (companyData.logo) {
                $('#company-logo-img').attr('src', companyData.logo).removeClass('d-none');
                $('#default-company-icon').addClass('d-none');
            } else {
                $('#company-logo-img').addClass('d-none');
                $('#default-company-icon').removeClass('d-none');
            }
            
            // Update company information
            $('#overview-company-name').text(companyData.name);
            $('#overview-industry').text(companyData.industry || 'Not specified');
            $('#company-name-link').attr('href', `/admin/companies/view/${companyData.id}`);
            
            // Update detail table
            $('#overview-status').html(`<span class="badge bg-success-subtle text-success">${companyData.status}</span>`);
            $('#overview-industry-detail').text(companyData.industry || 'Not specified');
            $('#overview-jobs-count').text(companyData.jobsCount || '0');
            $('#overview-created').text(companyData.created || 'N/A');
            $('#overview-website').attr('href', companyData.website).text(companyData.website.replace(/^https?:\/\//, '') || 'N/A');
            $('#overview-email-detail').text(companyData.email || 'N/A');
            $('#overview-phone-detail').text(companyData.phone || 'N/A');
            
            // Update action buttons
            $('#view-company-btn').attr('href', `/admin/companies/view/${companyData.id}`);
            $('#edit-company-btn').attr('href', `/admin/companies/edit/${companyData.id}`);
            
            // Update contact links
            $('#company-website').attr('href', companyData.website || '#');
            $('#company-email').attr('href', `mailto:${companyData.email}` || '#');
            $('#company-phone').attr('href', `tel:${companyData.phone}` || '#');
            
            // Show company details section
            $('#company-details').show();
        }

        // Clear all filters
        function clearFilters() {
            $('#searchCompany').val('');
            $('#datepicker').val('');
            $('#statusFilter').val('all');
            
            // Trigger change to reset choices.js if used
            if ($('#statusFilter')[0].choices) {
                $('#statusFilter')[0].choices.setChoiceByValue('all');
            }
            
            // Show all cards
            $('#companies-list .col-12').show();
            updateResultsCount();
            
            // Redirect to clear URL parameters
            window.location.href = '/admin/companies/all';
        }

        // Enhanced filter function
        function filterData() {
            const searchValue = $('#searchCompany').val().trim();
            const statusFilter = $('#statusFilter').val();
            const dateFilter = $('#datepicker').val().trim();
            
            // Build URL with filters
            let url = '/admin/companies/all';
            let params = [];
            
            if (statusFilter && statusFilter !== 'all') {
                params.push('status=' + encodeURIComponent(statusFilter));
            }
            
            if (searchValue) {
                params.push('search=' + encodeURIComponent(searchValue));
            }
            
            if (dateFilter) {
                params.push('date=' + encodeURIComponent(dateFilter));
            }
            
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            
            // For immediate client-side filtering (optional)
            if (!dateFilter) { // Only do client-side filtering if no date filter
                let visibleCount = 0;
                $('#companies-list .col-12').each(function() {
                    const card = $(this);
                    const cardText = card.text().toLowerCase();
                    const cardStatus = card.find('.badge').first().text().toLowerCase();
                    
                    let showCard = true;
                    
                    // Search filter
                    if (searchValue && cardText.indexOf(searchValue.toLowerCase()) === -1) {
                        showCard = false;
                    }
                    
                    // Status filter
                    if (statusFilter && statusFilter !== 'all') {
                        if (statusFilter === 'verified' && !card.find('.badge:contains("Verified")').length) {
                            showCard = false;
                        } else if (statusFilter === 'featured' && !card.find('.badge:contains("Featured")').length) {
                            showCard = false;
                        } else if (statusFilter === 'active' && cardStatus !== 'active') {
                            showCard = false;
                        } else if (statusFilter === 'pending' && cardStatus !== 'pending') {
                            showCard = false;
                        } else if (statusFilter === 'inactive' && cardStatus !== 'inactive') {
                            showCard = false;
                        }
                    }
                    
                    if (showCard) {
                        card.show();
                        visibleCount++;
                    } else {
                        card.hide();
                    }
                });
                
                updateResultsCount();
            } else {
                // Redirect to server-side filtering if date is involved
                window.location.href = url;
            }
        }

        // Delete company function (same as before)
        async function deleteCompany(id, name) {
            try {
                const checkResponse = await fetch(`/admin/companies/check-delete/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });
                
                const checkData = await checkResponse.json();
                
                if (!checkData.canDelete) {
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
                            window.location.href = `/admin/jobs/all?company=${id}`;
                        }
                    });
                    return;
                }
                
                Swal.fire({
                    title: 'Delete Company?',
                    html: `
                        <div class="text-start">
                            <p class="mb-3">Are you sure you want to delete <strong>"${name}"</strong>?</p>
                            <div class="alert alert-danger">
                                <i class="ri-error-warning-line me-2"></i>
                                <strong>Warning:</strong> This action cannot be undone. All company data will be permanently removed.
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="ri-delete-bin-line me-1"></i> Yes, Delete',
                    cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'swal2-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Deleting Company...',
                            html: `
                                <div class="text-center">
                                    <div class="spinner-border text-danger mb-3" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted">Please wait while we delete "${name}"</p>
                                </div>
                            `,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal2-lg'
                            }
                        });
                        
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
                
                Swal.fire({
                    title: 'Delete Company?',
                    text: `Are you sure you want to delete "${name}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel'
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
    </script>
</body>
</html>