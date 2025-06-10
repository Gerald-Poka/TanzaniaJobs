<?php
use yii\helpers\Html;
use yii\helpers\Url;

$title = $title ?? 'Job Categories';
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title' => $title)); ?>
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <?php echo $this->render('../partials/head-css'); ?>
</head>

<body>
    <div id="layout-wrapper">
        <?php echo $this->render('../partials/topbar'); ?>
        <?php echo $this->render('../partials/sidebar'); ?>
        
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= Html::encode($pageTitle ?? 'Job Categories') ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?= Url::to(['/']) ?>">Home</a></li>
                                        <li class="breadcrumb-item"><a href="<?= Url::to(['/jobs/browse']) ?>">Jobs</a></li>
                                        <li class="breadcrumb-item active">Categories</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="card-title mb-1">Explore Job Categories</h5>
                                            <p class="text-muted mb-0">Find jobs by category and discover new opportunities</p>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <div class="d-flex gap-2 justify-content-md-end">
                                                <a href="<?= Url::to(['/jobs/browse']) ?>" class="btn btn-outline-primary">
                                                    <i class="ri-search-line me-1"></i>Browse All Jobs
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Grid -->
                    <div class="row">
                        <?php if(empty($categories)): ?>
                            <!-- No Categories Found -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center py-5">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                <i class="ri-folder-line fs-1"></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-3">No Categories Available</h5>
                                        <p class="text-muted mb-4">
                                            No job categories have been created yet. Please check back later.
                                        </p>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="<?= Url::to(['/admin/categories/create']) ?>" class="btn btn-primary">
                                                <i class="ri-add-line me-1"></i>Create Categories (Admin)
                                            </a>
                                            <a href="<?= Url::to(['/jobs/browse']) ?>" class="btn btn-outline-primary">
                                                <i class="ri-search-line me-1"></i>Browse Jobs
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach($categories as $category): ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="card category-card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="avatar-sm me-3">
                                                    <div class="avatar-title bg-soft-primary text-primary rounded">
                                                        <i class="<?= Html::encode($category['icon'] ?? 'ri-folder-line') ?> fs-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-16 mb-2">
                                                        <a href="<?= Url::to(['/jobs/by-category', 'slug' => $category['slug']]) ?>" 
                                                           class="text-dark text-decoration-none">
                                                            <?= Html::encode($category['name']) ?>
                                                        </a>
                                                    </h5>
                                                    
                                                    <?php if(!empty($category['description'])): ?>
                                                        <p class="text-muted mb-3">
                                                            <?= Html::encode(Yii::$app->formatter->asText($category['description'])) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="text-muted">
                                                            <small>
                                                                <i class="ri-briefcase-line me-1"></i>
                                                                <?= (int)($category['jobs_count'] ?? 0) ?> Jobs Available
                                                            </small>
                                                        </div>
                                                        
                                                        <?php if(isset($category['parent_name']) && !empty($category['parent_name'])): ?>
                                                            <span class="badge bg-soft-secondary text-secondary">
                                                                <?= Html::encode($category['parent_name']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <div class="mt-3">
                                                        <a href="<?= Url::to(['/jobs/by-category', 'slug' => $category['slug']]) ?>" 
                                                           class="btn btn-soft-primary btn-sm w-100">
                                                            <i class="ri-arrow-right-line me-1"></i>View Jobs
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Trending Categories Section -->
                    <?php if(!empty($trendingCategories)): ?>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-fire-line text-danger me-2"></i>Trending Categories
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php foreach($trendingCategories as $trending): ?>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="d-flex align-items-center p-3 border rounded mb-3">
                                                    <div class="avatar-xs me-3">
                                                        <div class="avatar-title bg-soft-danger text-danger rounded">
                                                            <i class="<?= Html::encode($trending['icon'] ?? 'ri-folder-line') ?>"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">
                                                            <a href="<?= Url::to(['/jobs/by-category', 'slug' => $trending['slug']]) ?>" 
                                                               class="text-dark text-decoration-none">
                                                                <?= Html::encode($trending['name']) ?>
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">
                                                            <?= (int)($trending['jobs_count'] ?? 0) ?> jobs
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
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

    <!-- App js -->
    <script src="/js/app.js"></script>

    <style>
        .category-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        
        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .avatar-sm {
            height: 2.5rem;
            width: 2.5rem;
        }
        
        .avatar-xs {
            height: 1.5rem;
            width: 1.5rem;
        }
        
        .avatar-sm .avatar-title,
        .avatar-xs .avatar-title {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .badge {
            font-size: 0.75rem;
        }
        
        .btn-soft-primary {
            color: #556ee6;
            background-color: rgba(85, 110, 230, 0.1);
            border-color: transparent;
        }
        
        .btn-soft-primary:hover {
            color: #fff;
            background-color: #556ee6;
            border-color: #556ee6;
        }
        
        .bg-soft-primary {
            background-color: rgba(85, 110, 230, 0.1) !important;
        }
        
        .bg-soft-secondary {
            background-color: rgba(108, 117, 125, 0.1) !important;
        }
        
        .bg-soft-danger {
            background-color: rgba(244, 106, 106, 0.1) !important;
        }
        
        .text-primary {
            color: #556ee6 !important;
        }
        
        .text-secondary {
            color: #6c757d !important;
        }
        
        .text-danger {
            color: #f46a6a !important;
        }
    </style>
</body>
</html>