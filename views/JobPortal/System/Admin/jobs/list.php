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

                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-xl-2 col-md-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">All Jobs</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $allJobs; ?>">0</span></h4>
                                            <a href="/admin/jobs/all" class="text-decoration-underline <?php echo $filter === 'all' ? 'fw-bold' : ''; ?>">View All</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="bx bx-briefcase text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Active</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $activeJobs; ?>">0</span></h4>
                                            <a href="/admin/jobs/active" class="text-decoration-underline <?php echo $filter === 'active' ? 'fw-bold' : ''; ?>">View Active</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-check-circle text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Pending</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-warning fs-14 mb-0">
                                                <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $pendingJobs; ?>">0</span></h4>
                                            <a href="/admin/jobs/pending" class="text-decoration-underline <?php echo $filter === 'pending' ? 'fw-bold' : ''; ?>">View Pending</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="bx bx-time text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Expired</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-danger fs-14 mb-0">
                                                <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $expiredJobs; ?>">0</span></h4>
                                            <a href="/admin/jobs/expired" class="text-decoration-underline <?php echo $filter === 'expired' ? 'fw-bold' : ''; ?>">View Expired</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                <i class="bx bx-x-circle text-danger"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-4">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="text-uppercase fw-medium text-muted mb-0">Reported</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-danger fs-14 mb-0">
                                                <i class="ri-alert-line fs-13 align-middle"></i>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-2">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?php echo $reportedJobs; ?>">0</span></h4>
                                            <a href="/admin/jobs/reported" class="text-decoration-underline <?php echo $filter === 'reported' ? 'fw-bold' : ''; ?>">View Reported</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                <i class="bx bx-error text-danger"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h4 class="card-title mb-0"><?php echo $title; ?></h4>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex gap-2 align-items-center">
                                                <!-- ADD CREATE BUTTON HERE -->
                                                <a href="/admin/jobs/create" class="btn btn-success btn-sm">
                                                    <i class="ri-add-line align-bottom me-1"></i> Create Job
                                                </a>
                                                
                                                <!-- Filter Buttons -->
                                                <div class="btn-group" role="group" aria-label="Job filters">
                                                    <a href="/admin/jobs/all" class="btn <?php echo $filter === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?> btn-sm">
                                                        All <span class="badge <?php echo $filter === 'all' ? 'bg-white text-primary' : 'bg-primary'; ?> ms-1"><?php echo $allJobs; ?></span>
                                                    </a>
                                                    <a href="/admin/jobs/active" class="btn <?php echo $filter === 'active' ? 'btn-success' : 'btn-outline-success'; ?> btn-sm">
                                                        Active <span class="badge <?php echo $filter === 'active' ? 'bg-white text-success' : 'bg-success'; ?> ms-1"><?php echo $activeJobs; ?></span>
                                                    </a>
                                                    <a href="/admin/jobs/pending" class="btn <?php echo $filter === 'pending' ? 'btn-warning' : 'btn-outline-warning'; ?> btn-sm">
                                                        Pending <span class="badge <?php echo $filter === 'pending' ? 'bg-white text-warning' : 'bg-warning'; ?> ms-1"><?php echo $pendingJobs; ?></span>
                                                    </a>
                                                    <a href="/admin/jobs/expired" class="btn <?php echo $filter === 'expired' ? 'btn-danger' : 'btn-outline-danger'; ?> btn-sm">
                                                        Expired <span class="badge <?php echo $filter === 'expired' ? 'bg-white text-danger' : 'bg-danger'; ?> ms-1"><?php echo $expiredJobs; ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="jobs-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                    </div>
                                                </th>
                                                <th>Job Title</th>
                                                <th>Company</th>
                                                <th>Category</th>
                                                <th>Type</th>
                                                <th>Location</th>
                                                <th>Salary</th>
                                                <th>Status</th>
                                                <th>Applications</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($jobs) && !empty($jobs)): ?>
                                                <?php foreach($jobs as $index => $job): ?>
                                                <tr data-status="<?php echo strtolower($job['status']); ?>">
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input fs-15" type="checkbox" name="jobIds[]" value="<?php echo $job['id']; ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0">
                                                                    <a href="/admin/jobs/view/<?php echo $job['id']; ?>" class="text-decoration-none">
                                                                        <?php echo htmlspecialchars($job['title']); ?>
                                                                    </a>
                                                                    <?php if($job['featured']): ?>
                                                                        <span class="badge bg-warning-subtle text-warning ms-1">Featured</span>
                                                                    <?php endif; ?>
                                                                </h6>
                                                                <small class="text-muted"><?php echo htmlspecialchars($job['slug']); ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($job['company_name'])): ?>
                                                            <span class="text-primary"><?php echo htmlspecialchars($job['company_name']); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">No Company</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($job['category_name'])): ?>
                                                            <span class="badge bg-info-subtle text-info"><?php echo htmlspecialchars($job['category_name']); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">Uncategorized</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary-subtle text-secondary"><?php echo ucfirst($job['job_type']); ?></span>
                                                        <br>
                                                        <small class="text-muted"><?php echo ucfirst($job['location_type']); ?></small>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($job['location'])): ?>
                                                            <i class="ri-map-pin-line me-1"></i><?php echo htmlspecialchars($job['location']); ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Not specified</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($job['salary_min'] && $job['salary_max']): ?>
                                                            <span class="fw-medium">
                                                                <?php echo $job['salary_currency']; ?> <?php echo number_format($job['salary_min']); ?> - <?php echo number_format($job['salary_max']); ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">Negotiable</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $statusClasses = [
                                                            'published' => 'bg-success-subtle text-success',
                                                            'pending' => 'bg-warning-subtle text-warning',
                                                            'draft' => 'bg-secondary-subtle text-secondary',
                                                            'expired' => 'bg-danger-subtle text-danger',
                                                            'rejected' => 'bg-danger-subtle text-danger',
                                                            'reported' => 'bg-danger-subtle text-danger'
                                                        ];
                                                        $statusClass = $statusClasses[$job['status']] ?? 'bg-secondary-subtle text-secondary';
                                                        ?>
                                                        <span class="badge <?php echo $statusClass; ?>">
                                                            <?php echo ucfirst($job['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary-subtle text-primary me-1">
                                                                <?php echo $job['applications_count']; ?>
                                                            </span>
                                                            <small class="text-muted">applications</small>
                                                        </div>
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="ri-eye-line me-1"></i><?php echo number_format($job['views_count']); ?> views
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <?php echo date('M d, Y', strtotime($job['created_at'])); ?>
                                                        </div>
                                                        <small class="text-muted"><?php echo date('H:i', strtotime($job['created_at'])); ?></small>
                                                        <?php if($job['expires_at']): ?>
                                                            <br><small class="text-warning">
                                                                Expires: <?php echo date('M d', strtotime($job['expires_at'])); ?>
                                                            </small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item" href="/admin/jobs/view/<?php echo $job['id']; ?>">
                                                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                    </a>
                                                                </li>
                                                                
                                                                <?php if($job['status'] === 'pending'): ?>
                                                                <li>
                                                                    <a class="dropdown-item text-success" href="#" onclick="approveJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                                                        <i class="ri-check-line align-bottom me-2 text-muted"></i> Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item text-warning" href="#" onclick="rejectJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                                                        <i class="ri-close-line align-bottom me-2 text-muted"></i> Reject
                                                                    </a>
                                                                </li>
                                                                <?php endif; ?>
                                                                
                                                                <?php if($job['status'] === 'published'): ?>
                                                                <li>
                                                                    <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $job['id']; ?>, 'expired')">
                                                                        <i class="ri-time-line align-bottom me-2 text-muted"></i> Mark Expired
                                                                    </a>
                                                                </li>
                                                                <?php endif; ?>
                                                                
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteJob(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="11" class="text-center py-4">
                                                        <div class="mb-3">
                                                            <i class="ri-briefcase-line display-4 text-muted"></i>
                                                        </div>
                                                        <h6>No Jobs Found</h6>
                                                        <p class="text-muted">No <?php echo $filter === 'all' ? '' : $filter; ?> jobs found.</p>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
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
            // Initialize DataTable
            const table = $('#jobs-table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[9, 'desc']], // Sort by created date
                columnDefs: [
                    { orderable: false, targets: [0, 10] }
                ]
            });

            // Check all functionality
            $('#checkAll').on('change', function() {
                const isChecked = this.checked;
                table.rows({ search: 'applied' }).nodes().to$().find('input[name="jobIds[]"]').prop('checked', isChecked);
            });

            // Counter animation
            $('.counter-value').each(function() {
                const target = $(this).data('target');
                const $this = $(this);
                $({ counter: 0 }).animate({ counter: target }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.ceil(this.counter));
                    }
                });
            });
        });

        // Approve job function
        function approveJob(id, title) {
            Swal.fire({
                title: 'Approve Job?',
                text: `Are you sure you want to approve "${title}"?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/approve/' + id;
                    
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

        // Reject job function
        function rejectJob(id, title) {
            Swal.fire({
                title: 'Reject Job?',
                text: `Please provide a reason for rejecting "${title}":`,
                input: 'textarea',
                inputPlaceholder: 'Enter rejection reason...',
                inputAttributes: {
                    'aria-label': 'Rejection reason'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Reject Job',
                inputValidator: (value) => {
                    if (!value) {
                        return 'You need to provide a reason for rejection!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/reject/' + id;
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= Yii::$app->request->csrfParam ?>';
                    csrfInput.value = '<?= Yii::$app->request->csrfToken ?>';
                    form.appendChild(csrfInput);
                    
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = result.value;
                    form.appendChild(reasonInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Toggle status function
        function toggleStatus(id, newStatus) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to change this job status to ${newStatus}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, change to ${newStatus}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/toggle-status/' + id;
                    
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

        // Delete job function
        function deleteJob(id, title) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete "${title}"? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/jobs/delete/' + id;
                    
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