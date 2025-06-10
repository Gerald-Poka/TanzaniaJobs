<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\JobApplication;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', ['title' => 'Approved Applications']); ?>
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
                    
                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Approved Applications</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><?= Html::a('Dashboard', ['/admin/dashboard']) ?></li>
                                        <li class="breadcrumb-item active">Approved Applications</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Applications Table -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Approved Applications Management</h4>
                                </div>
                                <div class="card-body">
                                    <?php Pjax::begin(['id' => 'applications-pjax']); ?>
                                    
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'tableOptions' => ['class' => 'table table-striped table-hover'],
                                        'columns' => [
                                            [
                                                'attribute' => 'id',
                                                'headerOptions' => ['style' => 'width: 80px'],
                                            ],
                                            [
                                                'label' => 'Applicant',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return '<div>
                                                        <strong>' . Html::encode($model->applicant->firstname . ' ' . $model->applicant->lastname ?? 'N/A') . '</strong><br>
                                                        <small class="text-muted">' . Html::encode($model->applicant->email ?? 'N/A') . '</small>
                                                    </div>';
                                                },
                                            ],
                                            [
                                                'label' => 'Job Title',
                                                'value' => function ($model) {
                                                    return $model->job ? $model->job->title : 'N/A';
                                                },
                                            ],
                                            [
                                                'label' => 'Company',
                                                'value' => function ($model) {
                                                    return $model->job && $model->job->company ? $model->job->company->name : 'N/A';
                                                },
                                            ],
                                            [
                                                'attribute' => 'applied_at',
                                                'format' => ['date', 'M d, Y'],
                                                'headerOptions' => ['style' => 'width: 120px'],
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'template' => '{view} {update-status}',
                                                'buttons' => [
                                                    'view' => function ($url, $model, $key) {
                                                        return Html::a(
                                                            '<i class="ri-eye-line"></i> View',
                                                            ['/admin/applications/view', 'id' => $model->id],
                                                            ['class' => 'btn btn-sm btn-outline-primary me-1']
                                                        );
                                                    },
                                                    'update-status' => function ($url, $model, $key) {
                                                        return Html::button(
                                                            '<i class="ri-edit-line"></i> Status',
                                                            [
                                                                'class' => 'btn btn-sm btn-outline-secondary update-status',
                                                                'data-bs-toggle' => 'modal',
                                                                'data-bs-target' => '#statusModal',
                                                                'data-id' => $model->id,
                                                                'data-status' => $model->status,
                                                            ]
                                                        );
                                                    },
                                                ],
                                                'headerOptions' => ['style' => 'width: 150px'],
                                            ],
                                        ],
                                        'summary' => 'Showing {begin}-{end} of {totalCount} approved applications',
                                        'emptyText' => '<div class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-file-list-3-line fs-1 mb-3 d-block"></i>
                                                No approved applications found
                                            </div>
                                        </div>',
                                    ]); ?>
                                    
                                    <?php Pjax::end(); ?>
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
    
    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Application Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?= Html::beginForm('', 'post', ['id' => 'status-form']) ?>
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Status</label>
                        <?= Html::dropDownList('status', '', $statuses, [
                            'class' => 'form-select',
                            'id' => 'status-select',
                        ]) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>


    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php
    // Register the JavaScript code after jQuery has been loaded
    $script = <<<JS
        jQuery(document).ready(function() {
            // Handle status update modal
            jQuery('.update-status').on('click', function() {
                var id = jQuery(this).data('id');
                var status = jQuery(this).data('status');
                
                jQuery('#status-select').val(status);
                jQuery('#status-form').attr('action', '<?= Url::to(['/admin/applications/update-status']) ?>/' + id);
            });
        });
    JS;
    $this->registerJs($script);
    ?>
</body>
</html>