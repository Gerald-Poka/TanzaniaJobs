<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', ['title' => 'Application Details']); ?>
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
                    <?php echo $this->render('../partials/page-title', ['pagetitle' => 'Applications', 'title' => 'Application Details']); ?>
                    
                    <div class="row">
                        <div class="col-xl-8">
                            <!-- Application Info -->
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Application Details</h5>
                                    <div>
                                        <?php
                                        $statusClass = [
                                            'pending' => 'bg-warning-subtle text-warning',
                                            'reviewing' => 'bg-info-subtle text-info',
                                            'shortlisted' => 'bg-success-subtle text-success',
                                            'interviewed' => 'bg-primary-subtle text-primary',
                                            'accepted' => 'bg-success-subtle text-success',
                                            'rejected' => 'bg-danger-subtle text-danger',
                                            'withdrawn' => 'bg-secondary-subtle text-secondary',
                                        ];
                                        $class = $statusClass[$application['status']] ?? 'bg-secondary-subtle text-secondary';
                                        $label = $statuses[$application['status']] ?? ucfirst($application['status']);
                                        ?>
                                        <span class="badge <?= $class ?> fs-12">Status: <?= $label ?></span>
                                        <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                                            <i class="ri-edit-line"></i> Change Status
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Job Position</h6>
                                                <h5><?= Html::encode($application['job_title']) ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Company</h6>
                                                <div class="d-flex align-items-center">
                                                    <?php if(!empty($application['company_logo'])): ?>
                                                        <img src="<?= $application['company_logo'] ?>" alt="<?= Html::encode($application['company_name']) ?>" class="avatar-sm rounded me-2">
                                                    <?php else: ?>
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title rounded bg-primary-subtle text-primary">
                                                                <?= strtoupper(substr($application['company_name'], 0, 1)) ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h5 class="mb-0"><?= Html::encode($application['company_name']) ?></h5>
                                                        <?php if($application['company_verified']): ?>
                                                            <span class="badge bg-info-subtle text-info"><i class="ri-check-line me-1"></i>Verified</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Application Date</h6>
                                                <p><?= Yii::$app->formatter->asDatetime($application['applied_at']) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Location</h6>
                                                <p><?= Html::encode($application['job_location']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Job Type</h6>
                                                <p><?= ucfirst(str_replace('-', ' ', $application['job_type'])) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Expected Salary</h6>
                                                <p>
                                                    <?= $application['expected_salary'] ? 
                                                        ($application['salary_currency'] ?? 'USD') . ' ' . number_format($application['expected_salary']) : 
                                                        'Not specified' ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Availability Date</h6>
                                                <p><?= $application['availability_date'] ? Yii::$app->formatter->asDate($application['availability_date']) : 'Not specified' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <h6 class="text-muted fw-medium mb-1">Resume/CV</h6>
                                                <?php if($application['resume_file']): ?>
                                                    <a href="<?= Url::to(['/admin/applications/download-resume', 'id' => $application['id']]) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="ri-download-line me-1"></i>Download Resume
                                                    </a>
                                                <?php elseif($application['cv_document_id']): ?>
                                                    <div class="btn-group">
                                                        <a href="<?= Url::to(['/admin/applications/view-cv', 'id' => $application['cv_document_id']]) ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                                            <i class="ri-eye-line me-1"></i>View CV
                                                        </a>
                                                        <a href="<?= Url::to(['/admin/applications/download-cv', 'id' => $application['cv_document_id']]) ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="ri-download-line me-1"></i>Download CV
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="text-muted">No resume uploaded</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h6 class="text-muted fw-medium mb-1">Cover Letter</h6>
                                        <div class="bg-light p-3 rounded">
                                            <?= nl2br(Html::encode($application['cover_letter'])) ?>
                                        </div>
                                    </div>
                                    
                                    <?php if(!empty($application['notes'])): ?>
                                    <div class="mb-0">
                                        <h6 class="text-muted fw-medium mb-1">Additional Notes</h6>
                                        <div class="bg-light p-3 rounded">
                                            <?= nl2br(Html::encode($application['notes'])) ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-4">
                            <!-- Applicant Info -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Applicant Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <?php if($applicant && !empty($applicant->profile_photo)): ?>
                                            <img src="<?= $applicant->profile_photo ?>" alt="<?= Html::encode($applicant->username) ?>" class="avatar-xl rounded-circle">
                                        <?php else: ?>
                                            <div class="avatar-xl mx-auto">
                                                <span class="avatar-title rounded-circle bg-primary-subtle text-primary fs-24">
                                                    <?= strtoupper(substr($applicant->username ?? 'U', 0, 1)) ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <h5 class="mt-3 mb-1"><?= $applicant ? Html::encode($applicant->firstname . ' ' . $applicant->lastname) : 'Unknown User' ?></h5>
                                        <?php if($applicant && $applicant->email): ?>
                                            <p class="text-muted"><?= Html::encode($applicant->email) ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="mt-4">
                                            <a href="<?= Url::to(['/admin/users/view', 'id' => $application['applicant_id']]) ?>" class="btn btn-primary">
                                                View Full Profile
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="py-3">
                                        <?php if($applicant): ?>
                                            <?php if(!empty($applicant->phone)): ?>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="ri-phone-line text-muted fs-16"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0"><?= Html::encode($applicant->phone) ?></p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if(!empty($applicant->location)): ?>
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="ri-map-pin-line text-muted fs-16"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0"><?= Html::encode($applicant->location) ?></p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <i class="ri-user-add-line text-muted fs-16"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0">Joined <?= Yii::$app->formatter->asDate($applicant->created_at) ?></p>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-muted text-center">User details not available</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Admin Actions -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Admin Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                                            <i class="ri-mail-send-line me-1"></i> Send Message to Applicant
                                        </button>
                                        
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal">
                                            <i class="ri-calendar-event-line me-1"></i> Schedule Interview
                                        </button>
                                        
                                        <a href="<?= Url::to(['/admin/applications/all']) ?>" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i> Back to All Applications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php echo $this->render('../partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
    
    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Change Application Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= Url::to(['/admin/applications/update-status', 'id' => $application['id']]) ?>" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">New Status</label>
                            <?= Html::dropDownList('status', $application['status'], $statuses, [
                                'class' => 'form-select',
                                'id' => 'status-select',
                            ]) ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendMessageModalLabel">Send Message to Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= Url::to(['/admin/applications/send-message', 'id' => $application['id']]) ?>" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Schedule Interview Modal -->
    <div class="modal fade" id="scheduleInterviewModal" tabindex="-1" aria-labelledby="scheduleInterviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleInterviewModalLabel">Schedule Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= Url::to(['/admin/applications/schedule-interview', 'id' => $application['id']]) ?>" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Interview Date & Time</label>
                            <input type="datetime-local" class="form-control" name="interview_datetime" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Location/Platform</label>
                            <input type="text" class="form-control" name="interview_location" placeholder="Office Address or Online Platform (Zoom, Teams)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Interviewer</label>
                            <input type="text" class="form-control" name="interviewer" placeholder="Name and position">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Notes/Instructions</label>
                            <textarea class="form-control" name="interview_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule & Notify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>
</body>
</html>