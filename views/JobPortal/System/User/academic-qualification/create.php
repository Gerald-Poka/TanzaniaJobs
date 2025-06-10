<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\AcademicQualification $model */

$this->title = 'Add Academic Qualification';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['/user/profile']];
$this->params['breadcrumbs'][] = ['label' => 'Edit Profile', 'url' => ['/user/profile-edit']];
$this->params['breadcrumbs'][] = $this->title;

// Use the JobPortal layout
echo $this->render('/JobPortal/System/User/partials/main');
?>

<head>
    <?php echo $this->render('/JobPortal/System/User/partials/title-meta', array('title' => 'Add Academic Qualification')); ?>
    <?php echo $this->render('/JobPortal/System/User/partials/head-css'); ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $this->render('/JobPortal/System/User/partials/menu'); ?>

        <!-- Start right Content here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Page header -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= Html::encode($this->title) ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                        <li class="breadcrumb-item"><a href="<?= Url::to(['/user/profile-edit']) ?>">Edit Profile</a></li>
                                        <li class="breadcrumb-item active"><?= Html::encode($this->title) ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-graduation-cap-line me-2 text-primary"></i>
                                        <?= Html::encode($this->title) ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?= $this->render('_form', [
                                        'model' => $model,
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php echo $this->render('/JobPortal/System/User/partials/footer'); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $this->render('/JobPortal/System/User/partials/customizer'); ?>
    <?php echo $this->render('/JobPortal/System/User/partials/vendor-scripts'); ?>
    
    <!-- App js -->
    <script src="/js/app.js"></script>
</body>