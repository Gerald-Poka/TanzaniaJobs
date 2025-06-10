<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AcademicQualification $model */
/** @var yii\widgets\ActiveForm $form */

$currentYear = date('Y');
$years = range(1970, $currentYear);
$yearsList = array_combine($years, $years);
?>

<div class="academic-qualification-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'needs-validation'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{hint}\n{error}",
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback'],
            'options' => ['class' => 'mb-3'],
        ]
    ]); ?>

    <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true, 'placeholder' => 'e.g., University of Dar es Salaam']) ?>

    <?= $form->field($model, 'degree')->textInput(['maxlength' => true, 'placeholder' => 'e.g., Bachelor of Science, High School Diploma']) ?>

    <?= $form->field($model, 'field_of_study')->textInput(['maxlength' => true, 'placeholder' => 'e.g., Computer Science, Business Administration']) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_year')->dropDownList(
                array_reverse($yearsList, true),
                ['prompt' => 'Select Start Year']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end_year')->dropDownList(
                array_merge(['0' => 'Still Studying'], array_reverse($yearsList, true)),
                ['prompt' => 'Select End Year']
            )->hint('Leave blank if still studying') ?>
        </div>
    </div>

    <?= $form->field($model, 'grade')->textInput(['maxlength' => true, 'placeholder' => 'e.g., 3.8 GPA, First Class']) ?>

    <div class="form-group mt-4">
        <?= Html::submitButton('<i class="ri-save-line me-1"></i> Save', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="ri-arrow-left-line me-1"></i> Cancel', ['/user/profile-edit', '#' => 'education'], ['class' => 'btn btn-light ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>