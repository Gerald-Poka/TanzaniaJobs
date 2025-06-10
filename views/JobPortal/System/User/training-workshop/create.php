<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TrainingWorkshop $model */

$this->title = 'Add Training/Workshop';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['/user/profile']];
$this->params['breadcrumbs'][] = ['label' => 'Edit Profile', 'url' => ['/user/profile-edit']];
$this->params['breadcrumbs'][] = $this->title;

// Use the JobPortal layout (same as academic qualification)
echo $this->render('/JobPortal/System/User/partials/main');
?>

<head>
    <?php echo $this->render('/JobPortal/System/User/partials/title-meta', array('title' => 'Add Training/Workshop')); ?>
    <?php echo $this->render('/JobPortal/System/User/partials/head-css'); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <style>
        .form-section {
            border-radius: 0.25rem;
            margin-bottom: 1.5rem;
        }

        .form-section-header {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }

        .form-section-header i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .form-section-body {
            padding: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        
        <?php echo $this->render('/JobPortal/System/User/partials/menu'); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- start page title -->
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
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-8">
                            <?php $form = ActiveForm::begin([
                                'id' => 'training-workshop-form',
                                'options' => ['class' => 'needs-validation', 'novalidate' => true]
                            ]); ?>

                            <!-- Basic Information -->
                            <div class="form-section card">
                                <div class="form-section-header card-header">
                                    <i class="ri-presentation-line text-primary"></i>
                                    <h5 class="mb-0">Training/Workshop Information</h5>
                                </div>
                                <div class="form-section-body card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'title')->textInput([
                                                'placeholder' => 'e.g., Digital Marketing Training',
                                                'class' => 'form-control'
                                            ]) ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'institution')->textInput([
                                                'placeholder' => 'e.g., Training Institute Ltd',
                                                'class' => 'form-control'
                                            ]) ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'location')->textInput([
                                                'placeholder' => 'e.g., Dar es Salaam, Tanzania or Online',
                                                'class' => 'form-control'
                                            ]) ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'start_month')->dropDownList([
                                                '' => 'Month',
                                                '01' => 'January', '02' => 'February', '03' => 'March',
                                                '04' => 'April', '05' => 'May', '06' => 'June',
                                                '07' => 'July', '08' => 'August', '09' => 'September',
                                                '10' => 'October', '11' => 'November', '12' => 'December'
                                            ], ['class' => 'form-control']) ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'start_year')->dropDownList(
                                                array_combine(
                                                    range(date('Y'), 1980),
                                                    range(date('Y'), 1980)
                                                ),
                                                ['prompt' => 'Year', 'class' => 'form-control']
                                            ) ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'end_month')->dropDownList([
                                                '' => 'Month',
                                                '01' => 'January', '02' => 'February', '03' => 'March',
                                                '04' => 'April', '05' => 'May', '06' => 'June',
                                                '07' => 'July', '08' => 'August', '09' => 'September',
                                                '10' => 'October', '11' => 'November', '12' => 'December'
                                            ], [
                                                'class' => 'form-control',
                                                'id' => 'end-month'
                                            ]) ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($model, 'end_year')->dropDownList(
                                                array_combine(
                                                    range(date('Y'), 1980),
                                                    range(date('Y'), 1980)
                                                ),
                                                [
                                                    'prompt' => 'Year',
                                                    'class' => 'form-control',
                                                    'id' => 'end-year'
                                                ]
                                            ) ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check mb-3">
                                                <?= $form->field($model, 'is_ongoing')->checkbox([
                                                    'class' => 'form-check-input',
                                                    'id' => 'is-ongoing'
                                                ])->label('This training is ongoing', ['class' => 'form-check-label']) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <?= $form->field($model, 'description')->textarea([
                                                'rows' => 4,
                                                'placeholder' => 'Describe what you learned, key topics covered, and skills gained...',
                                                'class' => 'form-control'
                                            ])->hint('Describe the content and skills you gained from this training.') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-section card">
                                <div class="form-section-body card-body">
                                    <div class="d-flex justify-content-between">
                                        <a href="<?= Url::to(['/user/profile-edit#training']) ?>" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i> Cancel
                                        </a>
                                        <?= Html::submitButton('<i class="ri-save-line me-1"></i> Save Training/Workshop', [
                                            'class' => 'btn btn-primary',
                                            'id' => 'submit-btn'
                                        ]) ?>
                                    </div>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>

                        <!-- Help Section -->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-lightbulb-line text-warning me-2"></i>Tips for Training/Workshop
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">What to include:</h6>
                                        <ul class="mb-0">
                                            <li>Professional development courses</li>
                                            <li>Skills-based workshops</li>
                                            <li>Industry certifications</li>
                                            <li>Online courses (Coursera, Udemy, etc.)</li>
                                            <li>Conferences and seminars</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="alert alert-success">
                                        <h6 class="alert-heading">Pro Tips:</h6>
                                        <ul class="mb-0">
                                            <li>Include relevant skills gained</li>
                                            <li>Mention specific tools or technologies learned</li>
                                            <li>Add measurable outcomes if possible</li>
                                            <li>List recent trainings first</li>
                                        </ul>
                                    </div>
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

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle ongoing training checkbox
        const isOngoingCheckbox = document.getElementById('is-ongoing');
        const endMonth = document.getElementById('end-month');
        const endYear = document.getElementById('end-year');

        if (isOngoingCheckbox) {
            isOngoingCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endMonth.disabled = true;
                    endYear.disabled = true;
                    endMonth.value = '';
                    endYear.value = '';
                } else {
                    endMonth.disabled = false;
                    endYear.disabled = false;
                }
            });
        }

        // Form submission handling
        const form = document.getElementById('training-workshop-form');
        const submitBtn = document.getElementById('submit-btn');

        if (form) {
            form.addEventListener('submit', function(e) {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="ri-loader-2-line me-1 spinner-border spinner-border-sm"></i> Saving...';
                }
            });
        }

        // Success/Error message handling
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= Yii::$app->session->getFlash('success') ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= Yii::$app->session->getFlash('error') ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    });
    </script>

    <!-- App js -->
    <script src="/js/app.js"></script>
</body>
</html>