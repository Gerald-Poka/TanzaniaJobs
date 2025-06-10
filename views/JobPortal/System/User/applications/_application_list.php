<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<!-- No applications case -->
<?php if(empty($applications)): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center p-5">
                <div class="avatar-lg mx-auto mt-2">
                    <div class="avatar-title bg-light text-primary display-3 rounded-circle">
                        <i class="ri-file-text-line"></i>
                    </div>
                </div>
                <h4 class="mt-4 fw-semibold">No Applications Found</h4>
                <p class="text-muted mb-4">You don't have any <?= $type ?> job applications at the moment.</p>
                <a href="<?= Url::to(['/jobs/browse']) ?>" class="btn btn-primary"><i class="ri-search-line me-1"></i> Find Jobs to Apply</a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>

<!-- Applications list -->
<div class="card">
    <div class="card-body">
        <div class="row g-4">
            <?php foreach($applications as $application): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card job-application-card h-100">
                        <div class="card-body">
                            <!-- Status Badge -->
                            <div class="d-flex justify-content-between mb-3">
                                <?php
                                $statusClasses = [
                                    'pending' => 'bg-warning-subtle text-warning',
                                    'reviewing' => 'bg-info-subtle text-info',
                                    'shortlisted' => 'bg-success-subtle text-success',
                                    'interviewed' => 'bg-primary-subtle text-primary',
                                    'accepted' => 'bg-success-subtle text-success',
                                    'rejected' => 'bg-danger-subtle text-danger',
                                    'withdrawn' => 'bg-secondary-subtle text-secondary',
                                ];
                                $statusClass = $statusClasses[$application['status']] ?? 'bg-secondary-subtle text-secondary';
                                
                                $statusLabels = [
                                    'pending' => 'Pending Review',
                                    'reviewing' => 'Under Review',
                                    'shortlisted' => 'Shortlisted',
                                    'interviewed' => 'Interview Scheduled',
                                    'accepted' => 'Accepted',
                                    'rejected' => 'Not Selected',
                                    'withdrawn' => 'Withdrawn',
                                ];
                                $statusLabel = $statusLabels[$application['status']] ?? ucfirst($application['status']);
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                                
                                <!-- Applied Date -->
                                <span class="text-muted small">
                                    <?= Yii::$app->formatter->asRelativeTime($application['applied_at']) ?>
                                </span>
                            </div>
                            
                            <!-- Company Info -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <?php if(!empty($application->company_logo)): ?>
                                        <img src="<?php echo htmlspecialchars($application->company_logo); ?>" 
                                             alt="<?php echo htmlspecialchars($application->company_name); ?>" 
                                             class="avatar-sm rounded">
                                    <?php else: ?>
                                        <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center">
                                            <span><?= strtoupper(substr($application->company_name ?? 'C', 0, 1)) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= Html::encode($application['company_name']) ?></h6>
                                    <?php if($application['company_verified']): ?>
                                        <span class="badge bg-info-subtle text-info"><i class="ri-check-line me-1"></i>Verified</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Job Title -->
                            <h5 class="mb-2"><?= Html::encode($application['job_title']) ?></h5>
                            
                            <!-- Job Meta -->
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <?php if(!empty($application->location)): ?>
                                <span class="badge bg-light text-body">
                                    <i class="ri-map-pin-line me-1"></i><?= Html::encode($application->location) ?>
                                </span>
                                <?php endif; ?>
                                
                                <?php if(!empty($application->job_type)): ?>
                                <span class="badge bg-light text-body">
                                    <i class="ri-briefcase-line me-1"></i><?= ucfirst(str_replace('-', ' ', $application->job_type)) ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="<?= Url::to(['/jobs/view', 'id' => $application['job_id']]) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-eye-line me-1"></i>View Job
                                </a>
                                
                                <?php if($application['status'] == 'pending' || $application['status'] == 'reviewing'): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="withdrawApplication(<?= $application['id'] ?>)">
                                    <i class="ri-close-circle-line me-1"></i>Withdraw
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($pagination->totalCount > $pagination->pageSize): ?>
        <div class="d-flex justify-content-center mt-4">
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'options' => ['class' => 'pagination pagination-separated mb-0'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link']
            ]); ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Withdraw Application Modal -->
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to withdraw this job application? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="withdrawForm" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    <button type="submit" class="btn btn-danger">Confirm Withdrawal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function withdrawApplication(applicationId) {
    const withdrawForm = document.getElementById('withdrawForm');
    withdrawForm.action = '/user-applications/withdraw/' + applicationId;
    
    const withdrawModal = new bootstrap.Modal(document.getElementById('withdrawModal'));
    withdrawModal.show();
}
</script>
<?php endif; ?>