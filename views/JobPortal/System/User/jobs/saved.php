<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>$title)); ?>
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Saved Jobs', 'title'=>$pageTitle)); ?>

                    <?php if(!empty($error)): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <h5 class="alert-heading">Error!</h5>
                                <p><?= Html::encode($error) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(empty($savedJobs)): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center p-5">
                                    <div class="avatar-lg mx-auto mt-2">
                                        <div class="avatar-title bg-light text-primary display-3 rounded-circle">
                                            <i class="ri-bookmark-line"></i>
                                        </div>
                                    </div>
                                    <h4 class="mt-4 fw-semibold">No Saved Jobs</h4>
                                    <p class="text-muted mb-4">You haven't saved any jobs yet. Browse available jobs and save the ones that interest you.</p>
                                    <a href="<?= Url::to(['/jobs/browse']) ?>" class="btn btn-primary"><i class="ri-search-line me-1"></i> Browse Jobs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Saved Jobs List -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Your Saved Jobs</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <?php foreach($savedJobs as $savedJob): ?>
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="card job-card h-100">
                                                <div class="card-body">
                                                    <!-- Company Info -->
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="avatar-sm me-3">
                                                            <?php if(!empty($savedJob['company_logo'])): ?>
                                                                <img src="<?php echo htmlspecialchars($savedJob['company_logo']); ?>" 
                                                                     alt="<?php echo htmlspecialchars($savedJob['company_name']); ?>" 
                                                                     class="avatar-title rounded">
                                                            <?php else: ?>
                                                                <div class="avatar-title bg-secondary-subtle text-secondary rounded">
                                                                    <?php echo strtoupper(substr($savedJob['company_name'] ?? 'C', 0, 1)); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1"><?php echo htmlspecialchars($savedJob['company_name']); ?></h6>
                                                            <div>
                                                                <?php if(!empty($savedJob['company_verified'])): ?>
                                                                    <span class="badge bg-info-subtle text-info"><i class="ri-check-line me-1"></i>Verified</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Job Title -->
                                                    <h5 class="job-title mb-2">
                                                        <a href="<?= Url::to(['/jobs/view', 'id' => $savedJob['job_id']]); ?>">
                                                            <?php echo htmlspecialchars($savedJob['title']); ?>
                                                        </a>
                                                    </h5>

                                                    <!-- Job Short Description -->
                                                    <p class="text-muted job-description mb-3">
                                                        <?php echo htmlspecialchars(substr($savedJob['short_description'] ?? '', 0, 100) . '...'); ?>
                                                    </p>

                                                    <!-- Job Meta -->
                                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                                        <?php if(!empty($savedJob['location'])): ?>
                                                        <span class="badge bg-light text-body">
                                                            <i class="ri-map-pin-line me-1"></i><?php echo htmlspecialchars($savedJob['location']); ?>
                                                        </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($savedJob['job_type'])): ?>
                                                        <span class="badge bg-light text-body">
                                                            <i class="ri-briefcase-line me-1"></i><?php echo ucfirst(str_replace('-', ' ', $savedJob['job_type'])); ?>
                                                        </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(!empty($savedJob['salary_min']) || !empty($savedJob['salary_max'])): ?>
                                                        <span class="badge bg-light text-body">
                                                            <i class="ri-money-dollar-circle-line me-1"></i>
                                                            <?php 
                                                                $currency = $savedJob['salary_currency'] ?? 'USD';
                                                                if(!empty($savedJob['salary_min']) && !empty($savedJob['salary_max'])) {
                                                                    echo $currency . ' ' . number_format($savedJob['salary_min']) . ' - ' . number_format($savedJob['salary_max']);
                                                                } elseif (!empty($savedJob['salary_min'])) {
                                                                    echo $currency . ' ' . number_format($savedJob['salary_min']) . '+';
                                                                } elseif (!empty($savedJob['salary_max'])) {
                                                                    echo 'Up to ' . $currency . ' ' . number_format($savedJob['salary_max']);
                                                                }
                                                            ?>
                                                        </span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <a href="<?= Url::to(['/jobs/view', 'id' => $savedJob['job_id']]); ?>" class="btn btn-sm btn-primary">
                                                            <i class="ri-eye-line me-1"></i>View Details
                                                        </a>
                                                        
                                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                onclick="unsaveJob(<?= $savedJob['saved_id'] ?>)">
                                                            <i class="ri-delete-bin-line me-1"></i>Remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <?php if ($pagination->totalCount > $pagination->pageSize): ?>
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-center mt-4">
                                        <?= LinkPager::widget([
                                            'pagination' => $pagination,
                                            'options' => ['class' => 'pagination pagination-separated'],
                                            'linkContainerOptions' => ['class' => 'page-item'],
                                            'linkOptions' => ['class' => 'page-link'],
                                            'disabledListItemSubTagOptions' => ['class' => 'page-link']
                                        ]) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to unsave/remove a job
        function unsaveJob(savedId) {
            Swal.fire({
                title: 'Remove Saved Job?',
                text: 'Are you sure you want to remove this job from your saved list?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Remove it',
                cancelButtonText: 'No, Keep it',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send the request to unsave
                    fetch(`/jobs/unsave-from-list/${savedId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Job Removed',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload page to refresh the list
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to remove job'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again.'
                        });
                    });
                }
            });
        }
    </script>

    <!-- App js -->
    <script src="/js/app.js"></script>
</body>
</html>