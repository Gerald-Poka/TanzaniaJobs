<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle'=>'Job Application', 'title'=>$pageTitle)); ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Application Form</h4>
                                </div>
                                <div class="card-body">
                                    <?php $form = ActiveForm::begin([
                                        'id' => 'job-application-form',
                                        'options' => ['enctype' => 'multipart/form-data'],
                                        'action' => ['/application/submit', 'job_id' => $job->id]
                                    ]); ?>
                                    
                                    <!-- Cover Letter -->
                                    <?= $form->field($model, 'cover_letter')->textarea([
                                        'rows' => 6, 
                                        'class' => 'form-control',
                                        'placeholder' => 'Write a brief cover letter explaining why you are a good fit for this position...'
                                    ])->label('Cover Letter <span class="text-danger">*</span>') ?>
                                    
                                    <!-- CV Selection - First, select from saved CVs or upload a new one -->
                                    <div class="mb-3">
                                        <label class="form-label">Resume/CV <span class="text-danger">*</span></label>
                                        <div class="cv-selection-tabs">
                                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#saved-cvs" role="tab">
                                                        <i class="ri-file-list-line me-1"></i> Select Saved CV
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#upload-cv" role="tab">
                                                        <i class="ri-upload-line me-1"></i> Upload New CV
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <!-- Tab 1: Select from saved CVs -->
                                            <div class="tab-pane active" id="saved-cvs" role="tabpanel">
                                                <?php if (!empty($savedCvs)): ?>
                                                    <div class="cv-selection">
                                                        <?= $form->field($model, 'selected_cv_id')->radioList(
                                                            \yii\helpers\ArrayHelper::map($savedCvs, 'id', function($cv) {
                                                                // Use correct column 'name' instead of 'title'
                                                                $uploadDate = Yii::$app->formatter->asDate($cv['created_at'], 'php:M d, Y');
                                                                return Html::tag('div', 
                                                                    Html::tag('strong', Html::encode($cv['name'])) . 
                                                                    Html::tag('span', ' - ' . Html::encode($uploadDate), ['class' => 'text-muted']),
                                                                    ['class' => 'cv-item']
                                                                );
                                                            }),
                                                            [
                                                                'item' => function($index, $label, $name, $checked, $value) {
                                                                    $checked = $checked ? 'checked' : '';
                                                                    return "<div class='cv-option'>
                                                                        <input type='radio' id='cv-{$index}' name='{$name}' value='{$value}' {$checked}> 
                                                                        <label for='cv-{$index}'>{$label}</label>
                                                                    </div>";
                                                                }
                                                            ]
                                                        )->label(false); ?>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-info">
                                                        <i class="ri-information-line me-2"></i>
                                                        You don't have any saved CVs. Please upload a new one.
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Tab 2: Upload new CV -->
                                            <div class="tab-pane" id="upload-cv" role="tabpanel">
                                                <?= $form->field($model, 'resume_file')->fileInput([
                                                    'class' => 'form-control',
                                                    'accept' => '.pdf,.doc,.docx'
                                                ])->label(false) ?>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="save-cv" name="save_cv" value="1">
                                                    <label class="form-check-label" for="save-cv">
                                                        Save this CV for future applications
                                                    </label>
                                                </div>
                                                <div class="save-cv-name mt-2" style="display:none;">
                                                    <?= Html::textInput('cv_title', '', [
                                                        'class' => 'form-control',
                                                        'placeholder' => 'Enter a name for this CV (e.g. "Technical Resume 2025")'
                                                    ]) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-text text-muted">
                                            Accepted file types: PDF, DOC, or DOCX. Maximum file size: 5MB.
                                        </div>
                                    </div>
                                    
                                    <!-- Expected Salary -->
                                    <?= $form->field($model, 'expected_salary')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => 'e.g. 50000'
                                    ])->label('Expected Salary <small class="text-muted">(in ' . ($job->salary_currency ?: 'USD') . ')</small>') ?>
                                    
                                    <!-- Availability Date -->
                                    <?= $form->field($model, 'availability_date')->widget(DatePicker::class, [
                                        'options' => ['class' => 'form-control'],
                                        'dateFormat' => 'yyyy-MM-dd',
                                    ])->label('When can you start? <span class="text-danger">*</span>') ?>
                                    
                                    <!-- Additional Notes -->
                                    <?= $form->field($model, 'notes')->textarea([
                                        'rows' => 3, 
                                        'class' => 'form-control',
                                        'placeholder' => 'Any additional information you would like to share...'
                                    ])->label('Additional Notes <small class="text-muted">(optional)</small>') ?>
                                    
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-send-plane-line me-1"></i>Submit Application
                                        </button>
                                        <a href="<?= Url::to(['/jobs/view', 'id' => $job->id]) ?>" class="btn btn-light ms-1">Cancel</a>
                                    </div>
                                    
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <!-- Job Summary -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Job Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <?php if($company && !empty($company->logo)): ?>
                                                <img src="<?= $company->getLogoUrl() ?>" alt="<?= Html::encode($company->name) ?>" class="avatar-md rounded">
                                            <?php else: ?>
                                                <div class="avatar-md rounded bg-primary-subtle text-primary">
                                                    <span class="avatar-title"><?= strtoupper(substr($company->name ?? 'C', 0, 1)) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h5 class="mb-1"><?= Html::encode($job->title) ?></h5>
                                            <p class="mb-0 text-muted">
                                                <?= $company ? Html::encode($company->name) : 'Unknown Company' ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-map-pin-line text-muted me-1"></i>
                                                    <small><?= Html::encode($job->location) ?></small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-briefcase-line text-muted me-1"></i>
                                                    <small><?= ucfirst(str_replace('-', ' ', $job->job_type)) ?></small>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <i class="ri-money-dollar-circle-line text-muted me-1"></i>
                                                    <small>
                                                        <?php 
                                                            $currency = $job->salary_currency ?: 'USD';
                                                            if($job->salary_min && $job->salary_max) {
                                                                echo $currency . ' ' . number_format($job->salary_min) . ' - ' . number_format($job->salary_max);
                                                            } elseif ($job->salary_min) {
                                                                echo $currency . ' ' . number_format($job->salary_min) . '+';
                                                            } elseif ($job->salary_max) {
                                                                echo 'Up to ' . $currency . ' ' . number_format($job->salary_max);
                                                            } else {
                                                                echo 'Negotiable';
                                                            }
                                                        ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mb-0">
                                        <h6 class="alert-heading font-size-14"><i class="ri-information-line me-1 align-middle"></i> Application Tips</h6>
                                        <p class="mb-0">Make sure your resume is up-to-date and your cover letter addresses the specific requirements of this position.</p>
                                    </div>
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
    
    <script>
    $(document).ready(function() {
        // Handle CV selection tabs
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            // If user switched to the "Upload New CV" tab
            if ($(e.target).attr('href') === '#upload-cv') {
                // Unselect any selected CVs
                $('input[name="JobApplication[selected_cv_id]"]').prop('checked', false);
            }
            
            // If user switched to the "Select Saved CV" tab
            if ($(e.target).attr('href') === '#saved-cvs') {
                // Clear the file input
                $('#jobapplication-resume_file').val('');
            }
        });
        
        // Handle "Save this CV" checkbox
        $('#save-cv').on('change', function() {
            if ($(this).is(':checked')) {
                $('.save-cv-name').slideDown(200);
            } else {
                $('.save-cv-name').slideUp(200);
            }
        });
        
        // Style the CV selection options
        $('.cv-option').each(function() {
            $(this).on('click', function() {
                $('.cv-option').removeClass('selected');
                $(this).addClass('selected');
            });
        });
    });
    </script>

    <style>
        .avatar-md {
            height: 3rem;
            width: 3rem;
        }
        
        .avatar-title {
            align-items: center;
            background-color: var(--vz-primary);
            color: #fff;
            display: flex;
            font-weight: 500;
            height: 100%;
            justify-content: center;
            width: 100%;
        }
        
        .cv-option {
            padding: 10px;
            border: 1px solid #e9e9ef;
            border-radius: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cv-option:hover {
            background-color: #f3f6f9;
        }

        .cv-option.selected {
            border-color: #405189;
            background-color: rgba(64, 81, 137, 0.1);
        }

        .cv-option label {
            width: 100%;
            cursor: pointer;
            margin-bottom: 0;
        }

        .cv-option input[type="radio"] {
            margin-right: 10px;
        }
    </style>
</body>
</html>