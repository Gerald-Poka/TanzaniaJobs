
<?php
echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'Skills List')); ?>

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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Management', 'title'=>'Skills List')); ?>

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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h4 class="card-title mb-0">Skills Management</h4>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex gap-2 align-items-center">
                                                <!-- Filter Buttons -->
                                                <div class="btn-group" role="group" aria-label="Skills filters">
                                                    <button type="button" class="btn btn-primary btn-sm filter-btn active" data-filter="all">
                                                        All <span class="badge bg-white text-primary ms-1" id="count-all"><?php echo $totalSkills ?? 0; ?></span>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btn-sm filter-btn" data-filter="active">
                                                        Active <span class="badge bg-success ms-1" id="count-active"><?php echo $activeSkills ?? 0; ?></span>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm filter-btn" data-filter="inactive">
                                                        Inactive <span class="badge bg-danger ms-1" id="count-inactive"><?php echo $inactiveSkills ?? 0; ?></span>
                                                    </button>
                                                </div>
                                                
                                                <a href="/admin/skills/create" class="btn btn-success btn-sm">
                                                    <i class="ri-add-line me-1"></i> Create Skill
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="skills-table" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Skill Name</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Sort Order</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($skills) && !empty($skills)): ?>
                                                <?php foreach($skills as $index => $skill): ?>
                                                <tr data-status="<?php echo strtolower($skill['status']); ?>">
                                                    <td><?php echo $skill['id']; ?></td>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-0"><?php echo htmlspecialchars($skill['name']); ?></h6>
                                                            <small class="text-muted"><?php echo htmlspecialchars($skill['slug']); ?></small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($skill['category_name'])): ?>
                                                            <span class="badge bg-info-subtle text-info"><?php echo htmlspecialchars($skill['category_name']); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">No Category</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if($skill['status'] === 'active'): ?>
                                                            <span class="badge bg-success-subtle text-success">
                                                                <i class="ri-check-line me-1"></i>Active
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger">
                                                                <i class="ri-close-line me-1"></i>Inactive
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo $skill['sort_order']; ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($skill['created_at'])); ?></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item" href="/admin/skills/view/<?php echo $skill['id']; ?>">
                                                                        <i class="ri-eye-fill align-bottom me-2 text-muted"></i> View
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="/admin/skills/edit/<?php echo $skill['id']; ?>">
                                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#" onclick="toggleStatus(<?php echo $skill['id']; ?>, '<?php echo $skill['status'] === 'active' ? 'inactive' : 'active'; ?>')">
                                                                        <?php if($skill['status'] === 'active'): ?>
                                                                            <i class="ri-close-circle-line align-bottom me-2 text-muted"></i> Deactivate
                                                                        <?php else: ?>
                                                                            <i class="ri-check-circle-line align-bottom me-2 text-muted"></i> Activate
                                                                        <?php endif; ?>
                                                                    </a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="#" onclick="deleteSkill(<?php echo $skill['id']; ?>, '<?php echo addslashes($skill['name']); ?>')">
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
                                                    <td colspan="7" class="text-center py-4">
                                                        <div class="mb-3">
                                                            <i class="ri-star-line display-4 text-muted"></i>
                                                        </div>
                                                        <h6>No Skills Found</h6>
                                                        <p class="text-muted">No skills have been created yet.</p>
                                                        <a href="/admin/skills/create" class="btn btn-success">
                                                            <i class="ri-add-line me-1"></i> Create First Skill
                                                        </a>
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
            const table = $('#skills-table').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [6] }
                ]
            });

            // Filter functionality (same as categories)
            $('.filter-btn').on('click', function() {
                const filter = $(this).data('filter');
                
                $('.filter-btn').removeClass('active btn-primary btn-success btn-danger');
                $('.filter-btn[data-filter="all"]').addClass('btn-outline-primary');
                $('.filter-btn[data-filter="active"]').addClass('btn-outline-success');
                $('.filter-btn[data-filter="inactive"]').addClass('btn-outline-danger');
                
                $.fn.dataTable.ext.search = [];
                
                if (filter === 'all') {
                    $(this).removeClass('btn-outline-primary').addClass('btn-primary active');
                    table.draw();
                } else if (filter === 'active') {
                    $(this).removeClass('btn-outline-success').addClass('btn-success active');
                    
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        const row = table.row(dataIndex).node();
                        return $(row).attr('data-status') === 'active';
                    });
                    table.draw();
                } else if (filter === 'inactive') {
                    $(this).removeClass('btn-outline-danger').addClass('btn-danger active');
                    
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        const row = table.row(dataIndex).node();
                        return $(row).attr('data-status') === 'inactive';
                    });
                    table.draw();
                }
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

        // Delete skill function
        function deleteSkill(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete the skill "${name}"? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/admin/skills/delete/' + id;
                    
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