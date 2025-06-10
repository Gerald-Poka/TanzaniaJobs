<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title'=>'User Details')); ?>
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'User Management', 'title'=>'User Details')); ?>

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

                    <?php if (Yii::$app->session->hasFlash('info')): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                <i class="ri-information-line label-icon"></i>
                                <strong>Info!</strong> <?php echo Yii::$app->session->getFlash('info'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- User Basic Information -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title mb-0 flex-grow-1">User Information</h5>
                                        <div class="flex-shrink-0">
                                            <a href="<?php echo Url::to(['all']); ?>" class="btn btn-primary btn-sm">
                                                <i class="ri-arrow-left-line align-middle me-1"></i> Back to Users
                                            </a>
                                            <a href="<?php echo Url::to(['edit', 'id' => $user['id']]); ?>" class="btn btn-success btn-sm">
                                                <i class="ri-pencil-line align-middle me-1"></i> Edit User
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- User Avatar and Basic Info -->
                                        <div class="col-lg-4">
                                            <div class="text-center">
                                                <div class="avatar-lg mx-auto mb-3">
                                                    <div class="avatar-title rounded-circle bg-light text-primary fs-24">
                                                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                                    </div>
                                                </div>
                                                <h5 class="mb-1"><?php echo Html::encode($user['name']); ?></h5>
                                                <p class="text-muted mb-2"><?php echo Html::encode($user['email']); ?></p>
                                                <span class="badge bg-<?php echo $user['status_class']; ?>-subtle text-<?php echo $user['status_class']; ?> mb-3">
                                                    <?php echo $user['status_text']; ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- User Details -->
                                        <div class="col-lg-8">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row" style="width: 200px;">User ID:</th>
                                                            <td><?php echo Html::encode($user['id']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">First Name:</th>
                                                            <td><?php echo Html::encode($user['firstname']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Last Name:</th>
                                                            <td><?php echo Html::encode($user['lastname']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email Address:</th>
                                                            <td><?php echo Html::encode($user['email']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Role:</th>
                                                            <td>
                                                                <span class="badge bg-info-subtle text-info">Normal User</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Status:</th>
                                                            <td>
                                                                <span class="badge bg-<?php echo $user['status_class']; ?>-subtle text-<?php echo $user['status_class']; ?>">
                                                                    <?php echo $user['status_text']; ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Registration Date:</th>
                                                            <td><?php echo date('d M, Y H:i:s', strtotime($user['created_at'])); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Last Updated:</th>
                                                            <td><?php echo date('d M, Y H:i:s', strtotime($user['updated_at'])); ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CV Profile Information -->
                    <?php if (isset($cvProfile) && $cvProfile): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">CV Profile Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Address:</strong> <?php echo Html::encode($cvProfile['address'] ?? 'N/A'); ?></p>
                                            <p><strong>Date of Birth:</strong> <?php echo $cvProfile['date_of_birth'] ? date('d M, Y', strtotime($cvProfile['date_of_birth'])) : 'N/A'; ?></p>
                                            <p><strong>Gender:</strong> <?php echo Html::encode($cvProfile['gender'] ?? 'N/A'); ?></p>
                                            <p><strong>Nationality:</strong> <?php echo Html::encode($cvProfile['nationality'] ?? 'N/A'); ?></p>
                                            <p><strong>Job Title:</strong> <?php echo Html::encode($cvProfile['job_title'] ?? 'N/A'); ?></p>
                                            <p><strong>Years of Experience:</strong> <?php echo Html::encode($cvProfile['years_of_experience'] ?? 'N/A'); ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Skills:</strong> <?php echo Html::encode($cvProfile['skills'] ?? 'N/A'); ?></p>
                                            <p><strong>Languages:</strong> <?php echo Html::encode($cvProfile['languages'] ?? 'N/A'); ?></p>
                                            <?php if (!empty($cvProfile['linkedin_url'])): ?>
                                            <p><strong>LinkedIn:</strong> <a href="<?php echo Html::encode($cvProfile['linkedin_url']); ?>" target="_blank"><?php echo Html::encode($cvProfile['linkedin_url']); ?></a></p>
                                            <?php endif; ?>
                                            <?php if (!empty($cvProfile['github_url'])): ?>
                                            <p><strong>GitHub:</strong> <a href="<?php echo Html::encode($cvProfile['github_url']); ?>" target="_blank"><?php echo Html::encode($cvProfile['github_url']); ?></a></p>
                                            <?php endif; ?>
                                            <?php if (!empty($cvProfile['website_url'])): ?>
                                            <p><strong>Website:</strong> <a href="<?php echo Html::encode($cvProfile['website_url']); ?>" target="_blank"><?php echo Html::encode($cvProfile['website_url']); ?></a></p>
                                            <?php endif; ?>
                                            <?php if (!empty($cvProfile['twitter_url'])): ?>
                                            <p><strong>Twitter:</strong> <a href="<?php echo Html::encode($cvProfile['twitter_url']); ?>" target="_blank"><?php echo Html::encode($cvProfile['twitter_url']); ?></a></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($cvProfile['summary'])): ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6>Professional Summary:</h6>
                                            <p><?php echo Html::encode($cvProfile['summary']); ?></p>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($cvProfile['profile_picture'])): ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6>Profile Picture:</h6>
                                            <img src="<?php echo Html::encode($cvProfile['profile_picture']); ?>" alt="Profile Picture" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-profile-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No CV Profile Information</h5>
                                    <p class="text-muted">This user hasn't created a CV profile yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Academic Qualifications -->
                    <?php if (isset($academicQualifications) && !empty($academicQualifications)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Academic Qualifications (<?php echo count($academicQualifications); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Institution</th>
                                                    <th>Qualification</th>
                                                    <th>Field of Study</th>
                                                    <th>Period</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($academicQualifications as $qualification): ?>
                                                <tr>
                                                    <td><?php echo Html::encode($qualification['institution_name'] ?? $qualification['school'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <?php 
                                                        echo Html::encode(
                                                            $qualification['qualification_level'] ?? 
                                                            $qualification['degree'] ?? 
                                                            $qualification['qualification'] ?? 
                                                            'N/A'
                                                        ); 
                                                        ?>
                                                    </td>
                                                    <td><?php echo Html::encode($qualification['field_of_study'] ?? $qualification['major'] ?? $qualification['subject'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <?php 
                                                        $startYear = $qualification['start_year'] ?? 'N/A';
                                                        $endYear = $qualification['end_year'] ?? 'N/A';
                                                        echo $startYear . ' - ' . $endYear; 
                                                        ?>
                                                    </td>
                                                    <td><?php echo Html::encode($qualification['grade'] ?? $qualification['gpa'] ?? $qualification['result'] ?? 'N/A'); ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-graduation-cap-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Academic Qualifications</h5>
                                    <p class="text-muted">This user hasn't added any academic qualifications yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Professional Qualifications -->
                    <?php if (isset($professionalQualifications) && !empty($professionalQualifications)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Professional Certifications (<?php echo count($professionalQualifications); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Certificate Name</th>
                                                    <th>Organization</th>
                                                    <th>Issue Date</th>
                                                    <th>Description</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($professionalQualifications as $cert): ?>
                                                <tr>
                                                    <td><?php echo Html::encode($cert['certificate_name'] ?? 'N/A'); ?></td>
                                                    <td><?php echo Html::encode($cert['organization'] ?? 'N/A'); ?></td>
                                                    <td><?php echo $cert['issued_date'] ? date('d M, Y', strtotime($cert['issued_date'])) : 'N/A'; ?></td>
                                                    <td><?php echo Html::encode($cert['description'] ?? 'N/A'); ?></td>
                                                    <td><?php echo $cert['created_at'] ? date('d M, Y H:i', strtotime($cert['created_at'])) : 'N/A'; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-award-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Professional Certifications</h5>
                                    <p class="text-muted">This user hasn't added any professional certifications yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Work Experience -->
                    <?php if (isset($workExperiences) && !empty($workExperiences)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Work Experience (<?php echo count($workExperiences); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($workExperiences as $experience): ?>
                                    <div class="border-bottom mb-3 pb-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6 class="mb-1"><?php echo Html::encode($experience['job_title'] ?? 'N/A'); ?></h6>
                                                <p class="text-muted mb-1"><?php echo Html::encode($experience['company_name'] ?? 'N/A'); ?></p>
                                                <p class="text-muted mb-2">
                                                    <i class="ri-calendar-line me-1"></i>
                                                    <?php echo $experience['start_date'] ? date('M Y', strtotime($experience['start_date'])) : 'N/A'; ?> - 
                                                    <?php echo $experience['end_date'] ? date('M Y', strtotime($experience['end_date'])) : 'Present'; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="badge bg-primary-subtle text-primary"><?php echo Html::encode($experience['employment_type'] ?? 'Full-time'); ?></span>
                                            </div>
                                        </div>
                                        <?php if (!empty($experience['job_description'])): ?>
                                        <div class="mt-2">
                                            <p class="mb-0"><?php echo Html::encode($experience['job_description']); ?></p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-briefcase-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Work Experience</h5>
                                    <p class="text-muted">This user hasn't added any work experience yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Training & Workshops -->
                    <?php if (isset($trainingWorkshops) && !empty($trainingWorkshops)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Training & Workshops (<?php echo count($trainingWorkshops); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Organizer</th>
                                                    <th>Duration</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($trainingWorkshops as $training): ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                        echo Html::encode(
                                                            $training['title'] ?? 
                                                            $training['name'] ?? 
                                                            $training['workshop_title'] ?? 
                                                            $training['training_title'] ?? 
                                                            'N/A'
                                                        ); 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        echo Html::encode(
                                                            $training['organizer'] ?? 
                                                            $training['organization'] ?? 
                                                            $training['provider'] ?? 
                                                            $training['institution'] ?? 
                                                            $training['company'] ?? 
                                                            'N/A'
                                                        ); 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $startDate = $training['start_date'] ?? $training['date_start'] ?? null;
                                                        $endDate = $training['end_date'] ?? $training['date_end'] ?? null;
                                                        
                                                        if ($startDate && $endDate) {
                                                            echo date('d M, Y', strtotime($startDate)) . ' - ' . date('d M, Y', strtotime($endDate));
                                                        } elseif ($startDate) {
                                                            echo date('d M, Y', strtotime($startDate));
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        echo Html::encode(
                                                            $training['location'] ?? 
                                                            $training['venue'] ?? 
                                                            $training['place'] ?? 
                                                            'N/A'
                                                        ); 
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-book-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Training & Workshops</h5>
                                    <p class="text-muted">This user hasn't added any training or workshops yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Referees -->
                    <?php if (isset($referees) && !empty($referees)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Referees (<?php echo count($referees); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach ($referees as $referee): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded p-3">
                                                <h6 class="mb-1">
                                                    <?php 
                                                    echo Html::encode(
                                                        $referee['name'] ?? 
                                                        $referee['full_name'] ?? 
                                                        $referee['referee_name'] ?? 
                                                        'N/A'
                                                    ); 
                                                    ?>
                                                </h6>
                                                <p class="text-muted mb-1">
                                                    <?php 
                                                    echo Html::encode(
                                                        $referee['position'] ?? 
                                                        $referee['job_title'] ?? 
                                                        $referee['title'] ?? 
                                                        'N/A'
                                                    ); 
                                                    ?>
                                                </p>
                                                <p class="text-muted mb-1">
                                                    <?php 
                                                    echo Html::encode(
                                                        $referee['organization'] ?? 
                                                        $referee['company'] ?? 
                                                        $referee['institution'] ?? 
                                                        'N/A'
                                                    ); 
                                                    ?>
                                                </p>
                                                <p class="mb-1">
                                                    <i class="ri-phone-line me-1"></i> 
                                                    <?php 
                                                    echo Html::encode(
                                                        $referee['phone'] ?? 
                                                        $referee['phone_number'] ?? 
                                                        $referee['contact'] ?? 
                                                        'N/A'
                                                    ); 
                                                    ?>
                                                </p>
                                                <p class="mb-0">
                                                    <i class="ri-mail-line me-1"></i> 
                                                    <?php 
                                                    echo Html::encode(
                                                        $referee['email'] ?? 
                                                        $referee['email_address'] ?? 
                                                        'N/A'
                                                    ); 
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-user-search-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Referees</h5>
                                    <p class="text-muted">This user hasn't added any referees yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Saved CVs -->
                    <?php if (isset($savedCVs) && !empty($savedCVs)): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Saved CVs (<?php echo count($savedCVs); ?>)</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>CV Name</th>
                                                    <th>Created Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($savedCVs as $cv): ?>
                                                <tr>
                                                    <td><?php echo Html::encode($cv['name']); ?></td>
                                                    <td><?php echo date('d M, Y H:i', strtotime($cv['created_at'])); ?></td>
                                                    <td>
                                                        <?php if ($cv['is_active']): ?>
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary-subtle text-secondary">Saved</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="ri-file-list-line fs-48 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Saved CVs</h5>
                                    <p class="text-muted">This user hasn't saved any CVs yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- User Actions Card -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">User Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="<?php echo Url::to(['edit', 'id' => $user['id']]); ?>" class="btn btn-success">
                                            <i class="ri-pencil-line align-middle me-1"></i> Edit User
                                        </a>
                                        
                                        <?php if($user['status'] == 10): ?>
                                            <button type="button" class="btn btn-warning" onclick="confirmBanUser(<?php echo $user['id']; ?>, '<?php echo Html::encode($user['name']); ?>')">
                                                <i class="ri-forbid-line align-middle me-1"></i> Ban User
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-success" onclick="confirmActivateUser(<?php echo $user['id']; ?>, '<?php echo Html::encode($user['name']); ?>')">
                                                <i class="ri-check-line align-middle me-1"></i> Activate User
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button type="button" class="btn btn-danger" onclick="confirmDeleteUser(<?php echo $user['id']; ?>, '<?php echo Html::encode($user['name']); ?>')">
                                            <i class="ri-delete-bin-line align-middle me-1"></i> Delete User
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Forms for Actions -->
                    <form id="banUserForm" method="POST" style="display: none;">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    </form>

                    <form id="activateUserForm" method="POST" style="display: none;">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    </form>

                    <form id="deleteUserForm" method="POST" style="display: none;">
                        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
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

    <!-- App js -->
    <script src="/js/app.js"></script>
    <script>
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
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
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

    function confirmBanUser(userId, userName) {
        // Check if SweetAlert2 is available
        if (typeof Swal === 'undefined') {
            // Fallback to regular confirm if SweetAlert2 is not available
            if (confirm(`Are you sure you want to ban "${userName}"? This user will not be able to access the system.`)) {
                const form = document.getElementById('banUserForm');
                form.action = '<?php echo Url::to(['ban']); ?>/' + userId;
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
                form.action = '<?php echo Url::to(['ban']); ?>/' + userId;
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
                form.action = '<?php echo Url::to(['activate']); ?>/' + userId;
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
                form.action = '<?php echo Url::to(['activate']); ?>/' + userId;
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
                form.action = '<?php echo Url::to(['delete']); ?>/' + userId;
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
                form.action = '<?php echo Url::to(['delete']); ?>/' + userId;
                form.submit();
            }
        });
    }

    // Initialize everything when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, checking SweetAlert2...');
        
        // Initialize alerts immediately if SweetAlert2 is already loaded
        if (typeof Swal !== 'undefined') {
            initializeAlerts();
        }
        // If not loaded, the script loading mechanism above will handle it
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
    </style>
</body>
</html>