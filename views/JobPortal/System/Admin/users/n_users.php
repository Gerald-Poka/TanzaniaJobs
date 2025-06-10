<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'All Users')); ?>

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'User Management', 'title'=>'All Users')); ?>

                    <!-- Flash Messages with Bootstrap Alerts -->
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

                    <?php if (Yii::$app->session->hasFlash('warning')): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-warning alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-alert-line label-icon"></i>
                                <strong>Warning!</strong> <?php echo Yii::$app->session->getFlash('warning'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">All Users (Role: Normal Users)</h5>
                                        
                                        <!-- Status Filter Buttons -->
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm filter-btn active" data-filter="all">
                                                <i class="ri-group-line me-1"></i> All Users
                                                <span class="badge bg-primary ms-1" id="count-all">0</span>
                                            </button>
                                            <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="active">
                                                <i class="ri-check-line me-1"></i> Active
                                                <span class="badge bg-success ms-1" id="count-active">0</span>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm filter-btn" data-filter="banned">
                                                <i class="ri-forbid-line me-1"></i> Banned
                                                <span class="badge bg-danger ms-1" id="count-banned">0</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="users-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 10px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Registration Date</th>
                                                <th>Status</th>
                                                <th>Last Login</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($users) && !empty($users)): ?>
                                                <?php foreach($users as $index => $user): ?>
                                                <tr data-status="<?php echo strtolower($user['status']); ?>">
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input fs-15" type="checkbox" name="userIds[]" value="<?php echo $user['id']; ?>">
                                                        </div>
                                                    </th>
                                                    <td><?php echo $user['id']; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-xs me-3">
                                                                <div class="avatar-title rounded-circle bg-light text-primary fs-16">
                                                                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0"><?php echo htmlspecialchars($user['name']); ?></h6>
                                                                <small class="text-muted"><?php echo htmlspecialchars($user['username'] ?? ''); ?></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                    <td><?php echo date('d M, Y', strtotime($user['created_at'])); ?></td>
                                                    <td>
                                                        <?php if($user['status'] == 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        <?php elseif($user['status'] == 'inactive'): ?>
                                                            <span class="badge bg-warning-subtle text-warning">Inactive</span>
                                                        <?php elseif($user['status'] == 'banned'): ?>
                                                            <span class="badge bg-danger-subtle text-danger">Banned</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary-subtle text-secondary">Unknown</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $user['last_login'] ? date('d M, Y H:i', strtotime($user['last_login'])) : 'Never'; ?></td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a href="<?php echo \yii\helpers\Url::to(['/admin/users/view', 'id' => $user['id']]); ?>" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                <li>
                                                                    <button type="button" class="dropdown-item" style="background: none; border: none; width: 100%; text-align: left;" onclick="showEditRestriction('<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>')">
                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                    </button>
                                                                </li>
                                                                <?php if($user['status'] == 'active'): ?>
                                                                    <li>
                                                                        <button type="button" class="dropdown-item text-danger" style="background: none; border: none; width: 100%; text-align: left;" onclick="confirmBanUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>')">
                                                                            <i class="ri-forbid-line align-bottom me-2"></i> Ban User
                                                                        </button>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li>
                                                                        <button type="button" class="dropdown-item text-success" style="background: none; border: none; width: 100%; text-align: left;" onclick="confirmActivateUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>')">
                                                                            <i class="ri-check-line align-bottom me-2"></i> Activate
                                                                        </button>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li>
                                                                    <button type="button" class="dropdown-item text-danger" style="background: none; border: none; width: 100%; text-align: left;" onclick="confirmDeleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name'], ENT_QUOTES); ?>')">
                                                                        <i class="ri-delete-bin-fill align-bottom me-2"></i> Delete
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No users found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    
                                    <!-- Hidden Forms for Actions -->
                                    <form id="banUserForm" method="POST" style="display: none;">
                                        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                    </form>

                                    <form id="activateUserForm" method="POST" style="display: none;">
                                        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                    </form>

                                    <form id="deleteUserForm" method="POST" style="display: none;">
                                        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                    </form>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        // Global variables
        let usersTable;

        // Check if SweetAlert2 is loaded, if not load it
        if (typeof Swal === 'undefined') {
            console.log('SweetAlert2 not found, loading from CDN...');
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            script.onload = function() {
                console.log('SweetAlert2 loaded successfully');
                initializeAlerts();
            };
            document.head.appendChild(script);
        } else {
            console.log('SweetAlert2 already loaded');
            initializeAlerts();
        }

        function initializeAlerts() {
            // Check if we have flash messages to show using SweetAlert2
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?php echo addslashes(Yii::$app->session->getFlash('success')); ?>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#28a745',
                    timer: 5000,
                    timerProgressBar: true
                });
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '<?php echo addslashes(Yii::$app->session->getFlash('error')); ?>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545',
                    timer: 7000,
                    timerProgressBar: true
                });
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: '<?php echo addslashes(Yii::$app->session->getFlash('warning')); ?>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ffc107',
                    timer: 6000,
                    timerProgressBar: true
                });
            <?php endif; ?>
        }

        // Filter table by status using data-status attribute
        function filterByStatus(status) {
            if (status === 'all') {
                $('#users-table tbody tr').show();
            } else if (status === 'banned') {
                // Show only inactive users (considered banned)
                $('#users-table tbody tr').hide();
                $('#users-table tbody tr[data-status="inactive"]').show();
            } else if (status === 'active') {
                // Show only active users
                $('#users-table tbody tr').hide();
                $('#users-table tbody tr[data-status="active"]').show();
            }
            
            // Trigger DataTable draw to update pagination
            usersTable.draw();
        }

        // Update filter counts using data-status attribute
        function updateFilterCounts() {
            const totalRows = $('#users-table tbody tr[data-status]').length;
            const activeRows = $('#users-table tbody tr[data-status="active"]').length;
            const bannedRows = $('#users-table tbody tr[data-status="inactive"]').length;

            $('#count-all').text(totalRows);
            $('#count-active').text(activeRows);
            $('#count-banned').text(bannedRows);
        }

        function confirmBanUser(userId, userName) {
            // Check if SweetAlert2 is available
            if (typeof Swal === 'undefined') {
                // Fallback to regular confirm if SweetAlert2 is not available
                if (confirm(`Are you sure you want to ban "${userName}"? This user will not be able to access the system.`)) {
                    const form = document.getElementById('banUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['ban']); ?>/' + userId;
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Ban User?',
                html: `
                    <div class="text-start">
                        <div class="alert alert-warning alert-border-left mb-3" role="alert">
                            <i class="ri-alert-line me-2 align-middle fs-16"></i>
                            <strong>Warning:</strong> This action will prevent the user from accessing the system.
                        </div>
                        <p class="mb-2">Are you sure you want to ban <strong>"${userName}"</strong>?</p>
                        <ul class="text-muted small">
                            <li>User will be immediately logged out</li>
                            <li>User won't be able to log in again</li>
                            <li>User status will be changed to inactive</li>
                            <li>This action can be reversed later</li>
                        </ul>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-forbid-line me-1"></i> Yes, Ban User',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-warning',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading with custom styling
                    Swal.fire({
                        title: 'Processing...',
                        html: `
                            <div class="alert alert-info alert-label-icon rounded-label" role="alert">
                                <i class="ri-loader-4-line label-icon"></i>
                                <strong>Please wait</strong> - Banning user "${userName}"
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-popup-custom'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit the form
                    const form = document.getElementById('banUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['ban']); ?>/' + userId;
                    form.submit();
                }
            });
        }

        function confirmActivateUser(userId, userName) {
            // Check if SweetAlert2 is available
            if (typeof Swal === 'undefined') {
                // Fallback to regular confirm if SweetAlert2 is not available
                if (confirm(`Are you sure you want to activate "${userName}"? This user will be able to access the system again.`)) {
                    const form = document.getElementById('activateUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['activate']); ?>/' + userId;
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Activate User?',
                html: `
                    <div class="text-start">
                        <div class="alert alert-success alert-border-left mb-3" role="alert">
                            <i class="ri-check-line me-2 align-middle fs-16"></i>
                            <strong>Activation:</strong> This will restore user access to the system.
                        </div>
                        <p class="mb-2">Are you sure you want to activate <strong>"${userName}"</strong>?</p>
                        <ul class="text-muted small">
                            <li>User will be able to log in again</li>
                            <li>User status will be changed to active</li>
                            <li>All user privileges will be restored</li>
                            <li>User will receive normal access</li>
                        </ul>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-check-line me-1"></i> Yes, Activate User',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        html: `
                            <div class="alert alert-success alert-label-icon rounded-label" role="alert">
                                <i class="ri-loader-4-line label-icon"></i>
                                <strong>Please wait</strong> - Activating user "${userName}"
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-popup-custom'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    const form = document.getElementById('activateUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['activate']); ?>/' + userId;
                    form.submit();
                }
            });
        }

        function confirmDeleteUser(userId, userName) {
            // Check if SweetAlert2 is available
            if (typeof Swal === 'undefined') {
                // Fallback to regular confirm if SweetAlert2 is not available
                if (confirm(`Are you sure you want to permanently delete "${userName}"? This action cannot be undone!`)) {
                    const form = document.getElementById('deleteUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['delete']); ?>/' + userId;
                    form.submit();
                }
                return;
            }

            Swal.fire({
                title: 'Delete User?',
                html: `
                    <div class="text-start">
                        <div class="alert alert-danger alert-border-left mb-3" role="alert">
                            <i class="ri-error-warning-line me-2 align-middle fs-16"></i>
                            <strong>Danger:</strong> This action cannot be undone!
                        </div>
                        <p class="mb-2">Are you sure you want to permanently delete <strong>"${userName}"</strong>?</p>
                        <div class="alert alert-warning alert-additional" role="alert">
                            <div class="alert-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-alert-line fs-16 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1">What will be deleted:</h6>
                                        <ul class="mb-0 small">
                                            <li>User account and profile</li>
                                            <li>CV information and documents</li>
                                            <li>Work experience and qualifications</li>
                                            <li>All related data</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="ri-delete-bin-line me-1"></i> Yes, Delete Permanently',
                cancelButtonText: '<i class="ri-close-line me-1"></i> Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        html: `
                            <div class="alert alert-danger alert-label-icon rounded-label" role="alert">
                                <i class="ri-loader-4-line label-icon"></i>
                                <strong>Please wait</strong> - Deleting user "${userName}" and all related data
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-popup-custom'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    const form = document.getElementById('deleteUserForm');
                    form.action = '<?php echo \yii\helpers\Url::to(['delete']); ?>/' + userId;
                    form.submit();
                }
            });
        }

        function showEditRestriction(userName) {
            // Check if SweetAlert2 is available
            if (typeof Swal === 'undefined') {
                // Fallback to regular alert if SweetAlert2 is not available
                alert(`Edit Restriction: You cannot edit "${userName}"'s details. Only the user can edit their own profile information.`);
                return;
            }

            Swal.fire({
                title: 'Edit Restriction',
                html: `
                    <div class="text-start">
                        <div class="alert alert-info alert-border-left mb-3" role="alert">
                            <i class="ri-information-line me-2 align-middle fs-16"></i>
                            <strong>Information:</strong> User profile editing is restricted for security and privacy reasons.
                        </div>
                        <p class="mb-3">You cannot edit <strong>"${userName}"</strong>'s profile details.</p>
                        <div class="alert alert-warning alert-additional" role="alert">
                            <div class="alert-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-shield-user-line fs-16 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1">Why this restriction exists:</h6>
                                        <ul class="mb-0 small">
                                            <li>Users should control their own personal information</li>
                                            <li>Prevents unauthorized changes to user data</li>
                                            <li>Maintains data privacy and security standards</li>
                                            <li>Complies with user data protection policies</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-light border mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-lightbulb-line me-2 text-primary"></i>
                                <div>
                                    <strong>Alternative:</strong> If changes are needed, please contact the user directly or ask them to update their profile information themselves.
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonColor: '#0ab39c',
                confirmButtonText: '<i class="ri-check-line me-1"></i> I Understand',
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-info'
                },
                buttonsStyling: false,
                width: '520px'
            });
        }

        $(document).ready(function() {
            // Initialize DataTable
            usersTable = $('#users-table').DataTable({
                "responsive": true,
                "autoWidth": false,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'excel', 'pdf', 'print'
                ],
                "pageLength": 25,
                "order": [[1, 'desc']], // Order by ID descending
                "columnDefs": [
                    { "orderable": false, "targets": [0, 7] } // Disable ordering on checkbox and actions columns
                ],
                "initComplete": function() {
                    updateFilterCounts();
                }
            });

            // Handle filter button clicks
            $('.filter-btn').on('click', function() {
                const filterValue = $(this).data('filter');
                
                // Update active button
                $('.filter-btn').removeClass('active btn-primary btn-success btn-danger')
                    .addClass('btn-outline-primary btn-outline-success btn-outline-danger');
                
                $(this).removeClass('btn-outline-primary btn-outline-success btn-outline-danger')
                    .addClass('active');
                
                // Apply appropriate button style based on filter
                if (filterValue === 'all') {
                    $(this).addClass('btn-primary');
                } else if (filterValue === 'active') {
                    $(this).addClass('btn-success');
                } else if (filterValue === 'banned') {
                    $(this).addClass('btn-danger');
                }
                
                // Filter the table
                filterByStatus(filterValue);
            });

            // Handle "Check All" functionality
            $('#checkAll').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('input[name="userIds[]"]').prop('checked', isChecked);
            });

            // Handle individual checkbox changes
            $('input[name="userIds[]"]').on('change', function() {
                var totalCheckboxes = $('input[name="userIds[]"]').length;
                var checkedCheckboxes = $('input[name="userIds[]"]:checked').length;
                
                $('#checkAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });
        });
    </script>

    <!-- Custom CSS for SweetAlert2 with Bootstrap alerts -->
    <style>
    .swal2-popup-custom {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .swal2-popup-custom .alert {
        text-align: left;
        margin-bottom: 1rem;
    }

    .swal2-popup-custom .alert:last-child {
        margin-bottom: 0;
    }

    .swal2-html-container {
        overflow: visible !important;
    }

    /* Custom button styles */
    .swal2-actions .btn {
        margin: 0 0.25rem;
        min-width: 120px;
    }

    /* Animation for loading icon */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .ri-loader-4-line {
        animation: spin 1s linear infinite;
    }

    /* Filter button styles */
    .filter-btn {
        transition: all 0.3s ease;
        border-width: 1px;
        font-weight: 500;
    }

    .filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .filter-btn.active {
        transform: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .filter-btn .badge {
        font-size: 0.7em;
        padding: 0.25em 0.5em;
    }

    /* Responsive filter buttons */
    @media (max-width: 768px) {
        .filter-btn {
            font-size: 0.875rem;
            padding: 0.375rem 0.5rem;
        }
        
        .filter-btn .badge {
            font-size: 0.65em;
        }
    }
    </style>
</body>
</html>