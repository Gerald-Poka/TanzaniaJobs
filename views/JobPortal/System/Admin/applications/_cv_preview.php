<?php
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .cv-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        .cv-header {
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
            color: #495057;
        }
        .download-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="cv-container">
        <div class="cv-header">
            <h1><?= Html::encode($document->user->firstname . ' ' . $document->user->lastname) ?></h1>
            <p class="text-muted"><?= Html::encode($document->user->email) ?></p>
            <?php if (!empty($document->user->phone)): ?>
                <p><?= Html::encode($document->user->phone) ?></p>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($document->content)): ?>
            <?= $document->content ?>
        <?php else: ?>
            <div class="section">
                <h3 class="section-title">Professional Summary</h3>
                <p><?= Html::encode($document->summary ?? 'No summary available') ?></p>
            </div>
            
            <?php if (!empty($document->experience)): ?>
                <div class="section">
                    <h3 class="section-title">Work Experience</h3>
                    <?= $document->experience ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($document->education)): ?>
                <div class="section">
                    <h3 class="section-title">Education</h3>
                    <?= $document->education ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($document->skills)): ?>
                <div class="section">
                    <h3 class="section-title">Skills</h3>
                    <?= $document->skills ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <a href="<?= \yii\helpers\Url::to(['/admin/applications/download-cv', 'id' => $document->id]) ?>" class="btn btn-primary download-btn">
        <i class="ri-download-line me-1"></i> Download CV
    </a>
</body>
</html>