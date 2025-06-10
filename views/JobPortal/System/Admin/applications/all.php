<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\JobApplication;

// Use sample data if no real data provider exists
$applications = isset($dataProvider) && $dataProvider->getModels() ? $dataProvider->getModels() : $sampleApplications;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', ['title' => 'Applications Management']); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <?php echo $this->render('../partials/head-css'); ?>
    
    <!-- Additional CSS for enhanced applications page -->
    <style>
        .app-card {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        .app-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        .status-badge {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.35rem 0.65rem;
        }
        .filter-card {
            background-color: #f8f9fa;
            border-left: 4px solid #0d6efd;
        }
        .app-stats-card {
            border-radius: 0.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .app-stats-card:hover {
            transform: translateY(-3px);
        }
        .app-table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.03rem;
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            margin: 0.15rem;
            border-radius: 0.25rem;
        }
        .applicant-info {
            display: flex;
            align-items: center;
        }
        .applicant-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: 600;
            color: #495057;
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
        .nav-tabs-custom .nav-link {
            border: none;
            border-radius: 0;
            border-bottom: 2px solid transparent;
        }
        .nav-tabs-custom .nav-link.active {
            background-color: transparent;
            border-bottom-color: var(--vz-success);
            color: var(--vz-success);
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
                    
                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Jobs', 'title'=>'Application')); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="applicationList">
                                <div class="card-header border-0">
                                    <div class="d-md-flex align-items-center">
                                        <h5 class="card-title mb-3 mb-md-0 flex-grow-1">Job Applications</h5>
                                        <div class="flex-shrink-0">
                                            <div class="d-flex gap-1 flex-wrap">
                                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                                    <i class="ri-add-line align-bottom me-1"></i> Create Application
                                                </button>
                                                <button type="button" class="btn btn-info">
                                                    <i class="ri-file-download-line align-bottom me-1"></i> Import
                                                </button>
                                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                                    <i class="ri-delete-bin-2-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body border border-dashed border-end-0 border-start-0">
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-xxl-5 col-sm-6">
                                                <div class="search-box">
                                                    <input type="text" class="form-control search" placeholder="Search for application ID, company, designation status or something..." id="searchApplications">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-2 col-sm-6">
                                                <div>
                                                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" id="demo-datepicker" placeholder="Select date">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-2 col-sm-4">
                                                <div>
                                                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idStatus">
                                                        <option value="">Status</option>
                                                        <option value="all" selected>All</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="reviewing">Reviewing</option>
                                                        <option value="shortlisted">Shortlisted</option>
                                                        <option value="interviewed">Interviewed</option>
                                                        <option value="accepted">Accepted</option>
                                                        <option value="rejected">Rejected</option>
                                                        <option value="withdrawn">Withdrawn</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-2 col-sm-4">
                                                <div>
                                                    <select class="form-control" data-choices data-choices-search-false name="choices-single-default" id="idType">
                                                        <option value="">Select Type</option>
                                                        <option value="all" selected>All</option>
                                                        <option value="Full Time">Full Time</option>
                                                        <option value="Part Time">Part Time</option>
                                                        <option value="Contract">Contract</option>
                                                        <option value="Freelance">Freelance</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-1 col-sm-4">
                                                <div>
                                                    <button type="button" class="btn btn-primary w-100" onclick="filterData();">
                                                        <i class="ri-equalizer-fill me-1 align-bottom"></i> Filters
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                
                                <div class="card-body pt-0">
                                    <div>
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active py-3 filter-tab" data-filter="all" href="#all-tab" role="tab" aria-selected="true">
                                                    All Applications <span class="badge bg-primary align-middle ms-1" id="count-all">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-3 filter-tab" data-filter="pending" href="#pending-tab" role="tab" aria-selected="false">
                                                    Pending <span class="badge bg-warning align-middle ms-1" id="count-pending">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-3 filter-tab" data-filter="reviewing" href="#reviewing-tab" role="tab" aria-selected="false">
                                                     Reviewing <span class="badge bg-info align-middle ms-1" id="count-reviewing">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-3 filter-tab" data-filter="shortlisted" href="#shortlisted-tab" role="tab" aria-selected="false">
                                                    Shortlisted <span class="badge bg-primary align-middle ms-1" id="count-shortlisted">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-3 filter-tab" data-filter="accepted" href="#accepted-tab" role="tab" aria-selected="false">
                                                    Accepted <span class="badge bg-success align-middle ms-1" id="count-accepted">0</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link py-3 filter-tab" data-filter="rejected" href="#rejected-tab" role="tab" aria-selected="false">
                                                    Rejected <span class="badge bg-danger align-middle ms-1" id="count-rejected">0</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="table-responsive table-card mb-1">
                                            <table class="table table-nowrap align-middle app-table" id="applicationTable">
                                                <thead class="text-muted table-light">
                                                    <tr class="text-uppercase">
                                                        <th scope="col" style="width: 25px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                                            </div>
                                                        </th>
                                                        <th class="sort" data-sort="id" style="width: 140px;">Application ID</th>
                                                        <th class="sort" data-sort="applicant">Applicant</th>
                                                        <th class="sort" data-sort="company">Company Name</th>
                                                        <th class="sort" data-sort="designation">Designation</th>
                                                        <th class="sort" data-sort="date">Apply Date</th>
                                                        <th class="sort" data-sort="status">Status</th>
                                                        <th class="sort" data-sort="action">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                    <?php if(!empty($applications)): ?>
                                                        <?php foreach($applications as $application): ?>
                                                        <?php
                                                            // Handle both object and array data
                                                            if (is_object($application)) {
                                                                $id = $application->id;
                                                                $status = $application->status;
                                                                $name = $application->applicant->name ?? '';
                                                                $email = $application->applicant->email ?? '';
                                                                $companyName = $application->job && $application->job->company ? $application->job->company->name : 'N/A';
                                                                $jobTitle = $application->job ? $application->job->title : 'N/A';
                                                                $appliedAt = $application->applied_at;
                                                            } else {
                                                                $id = $application['id'];
                                                                $status = $application['status'];
                                                                $name = $application['applicant_name'];
                                                                $email = $application['applicant_email'];
                                                                $companyName = $application['company_name'];
                                                                $jobTitle = $application['job_title'];
                                                                $appliedAt = $application['applied_at'];
                                                            }
                                                            
                                                            // Generate initials
                                                            $nameParts = explode(' ', $name);
                                                            $firstName = $nameParts[0] ?? '';
                                                            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
                                                            
                                                            if (count($nameParts) >= 2) {
                                                                $initials = strtoupper(mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1));
                                                            } else {
                                                                $initials = strtoupper(mb_substr($name, 0, 2));
                                                            }
                                                            
                                                            // Generate color
                                                            $hash = md5($name);
                                                            $hue = hexdec(substr($hash, 0, 2)) % 360;
                                                            $bgColor = "hsl($hue, 65%, 85%)";
                                                            $textColor = "hsl($hue, 80%, 30%)";
                                                            
                                                            // Status colors
                                                            $colors = [
                                                                'pending' => 'warning',
                                                                'reviewing' => 'info',
                                                                'shortlisted' => 'primary',
                                                                'interviewed' => 'info',
                                                                'accepted' => 'success',
                                                                'rejected' => 'danger',
                                                                'withdrawn' => 'secondary',
                                                            ];
                                                            $color = $colors[$status] ?? 'secondary';
                                                        ?>
                                                        <tr data-status="<?= strtolower($status) ?>" data-company="<?= strtolower($companyName) ?>" data-job="<?= strtolower($jobTitle) ?>">
                                                            <th scope="row">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="checkAll" value="<?= $id ?>">
                                                                </div>
                                                            </th>
                                                            <td class="id">
                                                                <a href="/admin/applications/view/<?= $id ?>" class="fw-medium link-primary">
                                                                    #APP<?= str_pad($id, 3, '0', STR_PAD_LEFT) ?>
                                                                </a>
                                                            </td>
                                                            <td class="applicant">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="applicant-avatar" style="background-color: <?= $bgColor ?>; color: <?= $textColor ?>;">
                                                                            <?= $initials ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <h6 class="mb-0"><?= Html::encode($name) ?></h6>
                                                                        <small class="text-muted"><?= Html::encode($email) ?></small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="company">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="/images/companies/img-1.png" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                                    </div>
                                                                    <div class="flex-grow-1 ms-2">
                                                                        <?= Html::encode($companyName) ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="designation"><?= Html::encode($jobTitle) ?></td>
                                                            <td class="date"><?= date('d M, Y', strtotime($appliedAt)) ?></td>
                                                            <td class="status">
                                                                <span class="badge bg-<?= $color ?>-subtle text-<?= $color ?> text-uppercase status-badge">
                                                                    <?= ucfirst($status) ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                                        <a href="/admin/applications/view/<?= $id ?>" class="text-primary d-inline-block">
                                                                            <i class="ri-eye-fill fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                                        <a href="#statusModal" data-bs-toggle="modal" class="text-primary d-inline-block edit-item-btn update-status" 
                                                                           data-id="<?= $id ?>" 
                                                                           data-status="<?= $status ?>"
                                                                           data-applicant="<?= Html::encode($name) ?>"
                                                                           data-job="<?= Html::encode($jobTitle) ?>">
                                                                            <i class="ri-pencil-fill fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Remove">
                                                                        <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal" href="#deleteOrder" data-id="<?= $id ?>">
                                                                            <i class="ri-delete-bin-5-fill fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="8" class="text-center py-5">
                                                                <div class="text-muted">
                                                                    <i class="ri-file-list-3-line fs-1 mb-3 d-block opacity-50"></i>
                                                                    <h5>No applications found</h5>
                                                                    <p class="mb-0">There are no applications matching your criteria</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                            
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#405189,secondary:#0ab39c" style="width:75px;height:75px"></lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted">We've searched more than 150+ applications. We did not find applications for your search.</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <div class="pagination-wrap hstack gap-2">
                                                <a class="page-item pagination-prev disabled" href="#">
                                                    Previous
                                                </a>
                                                <ul class="pagination listjs-pagination mb-0"></ul>
                                                <a class="page-item pagination-next" href="#">
                                                    Next
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php echo $this->render('../partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    
    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="statusModalLabel">
                        <i class="ri-edit-line me-1 text-primary"></i> Update Application Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= Html::beginForm('', 'post', ['id' => 'status-form']) ?>
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div class="modal-body">
                    <div class="application-info mb-3 p-3 bg-light rounded">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-primary text-white fs-4">
                                        <i class="ri-user-line"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="applicant-name mb-1">Applicant Name</h5>
                                <p class="job-title text-muted mb-0">Job Title</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Update Status</label>
                        <?= Html::dropDownList('status', '', [
                            'pending' => 'Pending',
                            'reviewing' => 'Reviewing',
                            'shortlisted' => 'Shortlisted',
                            'interviewed' => 'Interviewed',
                            'accepted' => 'Accepted',
                            'rejected' => 'Rejected',
                            'withdrawn' => 'Withdrawn'
                        ], [
                            'class' => 'form-select form-select-lg status-select',
                            'id' => 'status-select',
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Add Note (Optional)</label>
                        <textarea class="form-control" rows="3" placeholder="Add a note about this status change..." name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-check-line me-1"></i> Update Status
                    </button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade flip" id="deleteOrder" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4>You are about to delete an application?</h4>
                        <p class="text-muted fs-15 mb-4">Deleting this application will remove all information from our database.</p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none" id="deleteRecord-close" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1 align-middle"></i> Close
                            </button>
                            <button class="btn btn-danger" id="delete-record">Yes, Delete It</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        // Global variables
        let currentFilter = 'all';
        let currentSearch = '';
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, initializing filters...');
            
            // Handle status update modal
            document.querySelectorAll('.update-status').forEach(function(element) {
                element.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var status = this.getAttribute('data-status');
                    var applicantName = this.getAttribute('data-applicant');
                    var jobTitle = this.getAttribute('data-job');
                    
                    // Update the modal with applicant and job info
                    document.querySelector('.applicant-name').textContent = applicantName;
                    document.querySelector('.job-title').textContent = jobTitle;
                    
                    document.getElementById('status-select').value = status;
                    document.getElementById('status-form').action = '/admin/applications/update-status/' + id;
                });
            });
            
            // Handle delete modal
            document.querySelectorAll('.remove-item-btn').forEach(function(element) {
                element.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    document.getElementById('delete-record').setAttribute('data-id', id);
                });
            });
            
            document.getElementById('delete-record').addEventListener('click', function() {
                var id = this.getAttribute('data-id');
                console.log('Delete application with ID:', id);
                // Close modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('deleteOrder'));
                if (modal) modal.hide();
            });
            
            // Tab filtering - Fixed implementation with specific selector
            document.querySelectorAll('.filter-tab').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var filter = this.getAttribute('data-filter');
                    
                    if (filter) {
                        currentFilter = filter;
                        console.log('Filtering by:', filter);
                        
                        // Update active tab - only filter tabs
                        document.querySelectorAll('.filter-tab').forEach(function(navLink) {
                            navLink.classList.remove('active');
                        });
                        this.classList.add('active');
                        
                        // Filter table rows
                        filterApplications();
                    }
                });
            });
            
            // Search functionality
            document.getElementById('searchApplications').addEventListener('keyup', function() {
                currentSearch = this.value.toLowerCase();
                console.log('Searching for:', currentSearch);
                filterApplications();
            });
            
            // Dropdown filter functionality
            document.getElementById('idStatus').addEventListener('change', function() {
                var selectedStatus = this.value;
                console.log('Dropdown status selected:', selectedStatus);
                if (selectedStatus && selectedStatus !== 'all') {
                    currentFilter = selectedStatus;
                    
                    // Update active tab to match - only filter tabs
                    document.querySelectorAll('.filter-tab').forEach(function(navLink) {
                        navLink.classList.remove('active');
                    });
                    var matchingTab = document.querySelector('.filter-tab[data-filter="' + selectedStatus + '"]');
                    if (matchingTab) {
                        matchingTab.classList.add('active');
                    }
                    
                    filterApplications();
                } else if (selectedStatus === 'all') {
                    currentFilter = 'all';
                    document.querySelectorAll('.filter-tab').forEach(function(navLink) {
                        navLink.classList.remove('active');
                    });
                    document.querySelector('.filter-tab[data-filter="all"]').classList.add('active');
                    filterApplications();
                }
            });
            
            // Check all functionality
            document.getElementById('checkAll').addEventListener('change', function() {
                var isChecked = this.checked;
                var visibleCheckboxes = document.querySelectorAll('#applicationTable tbody tr:not([style*="display: none"]) input[name="checkAll"]');
                visibleCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
            });
            
            // Individual checkbox handling
            document.addEventListener('change', function(e) {
                if (e.target.name === 'checkAll') {
                    var visibleCheckboxes = document.querySelectorAll('#applicationTable tbody tr:not([style*="display: none"]) input[name="checkAll"]');
                    var checkedCheckboxes = document.querySelectorAll('#applicationTable tbody tr:not([style*="display: none"]) input[name="checkAll"]:checked');
                    var allChecked = visibleCheckboxes.length === checkedCheckboxes.length && visibleCheckboxes.length > 0;
                    document.getElementById('checkAll').checked = allChecked;
                }
            });
            
            // Initial filter to show all and update counts
            filterApplications();
        });
        
        function filterApplications() {
            console.log('Filtering applications. Filter:', currentFilter, 'Search:', currentSearch);
            var visibleCount = 0;
            var hasResults = false;
            
            var rows = document.querySelectorAll('#applicationTable tbody tr');
            rows.forEach(function(row) {
                // Skip the "no data" row
                if (row.querySelector('td[colspan]')) {
                    return;
                }
                
                var rowStatus = row.getAttribute('data-status'); // Use the data-status attribute
                var rowText = row.textContent.toLowerCase();
                
                var showRow = true;
                
                // Status filter
                if (currentFilter !== 'all') {
                    if (rowStatus !== currentFilter) {
                        showRow = false;
                    }
                }
                
                // Search filter
                if (currentSearch && rowText.indexOf(currentSearch) === -1) {
                    showRow = false;
                }
                
                if (showRow) {
                    row.style.display = '';
                    visibleCount++;
                    hasResults = true;
                } else {
                    row.style.display = 'none';
                }
            });
            
            console.log('Visible rows:', visibleCount);
            
            // Show/hide no results message
            var noResultDiv = document.querySelector('.noresult');
            var tableDiv = document.querySelector('.table-responsive');
            
            if (!hasResults) {
                noResultDiv.style.display = 'block';
                tableDiv.style.display = 'none';
            } else {
                noResultDiv.style.display = 'none';
                tableDiv.style.display = 'block';
            }
            
            // Update tab counts
            updateTabCounts();
        }
        
        function updateTabCounts() {
            // Count applications by status
            var counts = {
                all: 0,
                pending: 0,
                reviewing: 0,
                shortlisted: 0,
                accepted: 0,
                rejected: 0,
                withdrawn: 0
            };
            
            var rows = document.querySelectorAll('#applicationTable tbody tr');
            rows.forEach(function(row) {
                if (row.querySelector('td[colspan]')) return;
                
                var status = row.getAttribute('data-status');
                if (counts.hasOwnProperty(status)) {
                    counts[status]++;
                }
                counts.all++;
            });
            
            console.log('Status counts:', counts);
            
            // Update badges in tabs
            Object.keys(counts).forEach(function(status) {
                var badge = document.getElementById('count-' + status);
                if (badge) {
                    badge.textContent = counts[status];
                }
            });
        }
        
        function filterData() {
            var status = document.getElementById('idStatus').value;
            var type = document.getElementById('idType').value;
            var dateRange = document.getElementById('demo-datepicker').value;
            
            console.log('Filter button clicked. Status:', status, 'Type:', type, 'Date:', dateRange);
            
            // Apply status filter if selected
            if (status && status !== 'all') {
                currentFilter = status;
                
                // Update active tab - only filter tabs
                document.querySelectorAll('.filter-tab').forEach(function(navLink) {
                    navLink.classList.remove('active');
                });
                var matchingTab = document.querySelector('.filter-tab[data-filter="' + status + '"]');
                if (matchingTab) {
                    matchingTab.classList.add('active');
                }
                
                filterApplications();
            } else if (status === 'all') {
                currentFilter = 'all';
                document.querySelectorAll('.filter-tab').forEach(function(navLink) {
                    navLink.classList.remove('active');
                });
                document.querySelector('.filter-tab[data-filter="all"]').classList.add('active');
                filterApplications();
            }
        }
        
        function deleteMultiple() {
            var checkedBoxes = document.querySelectorAll('input[name="checkAll"]:checked');
            if (checkedBoxes.length === 0) {
                Swal.fire('No Selection', 'Please select applications to delete.', 'warning');
                return;
            }
            
            Swal.fire({
                title: 'Delete Applications?',
                text: 'Are you sure you want to delete ' + checkedBoxes.length + ' selected applications?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete them!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Add your bulk delete logic here
                    console.log('Bulk delete applications');
                }
            });
        }
    </script>
</body>
</html>