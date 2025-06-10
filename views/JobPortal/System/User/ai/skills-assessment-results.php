<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="skills-assessment-results">
    <!-- Overall Score -->
    <div class="text-center mb-4">
        <div class="avatar-xl mx-auto mb-3">
            <div class="avatar-title bg-light rounded-circle">
                <div class="progress-ring" data-progress="<?= $results['overall_score'] ?>">
                    <svg width="120" height="120" viewBox="0 0 120 120">
                        <circle class="progress-ring-circle-bg" stroke="#e9ecef" stroke-width="8" fill="transparent" r="50" cx="60" cy="60"/>
                        <circle class="progress-ring-circle" 
                                stroke="<?= $results['overall_score'] >= 80 ? '#0ab39c' : ($results['overall_score'] >= 60 ? '#0d6efd' : '#f7b84b') ?>" 
                                stroke-width="8" 
                                fill="transparent" 
                                r="50" 
                                cx="60" 
                                cy="60"
                                stroke-dasharray="314.16"
                                stroke-dashoffset="<?= 314.16 - (314.16 * $results['overall_score'] / 100) ?>"/>
                    </svg>
                    <div class="progress-ring-text fs-1 fw-bold">
                        <?= $results['overall_score'] ?>%
                    </div>
                </div>
            </div>
        </div>
        <h4 class="mb-1">Overall Assessment Score</h4>
        <p class="text-muted mb-0">
            <?php if ($results['overall_score'] >= 80): ?>
                Excellent! You have strong skills across multiple areas.
            <?php elseif ($results['overall_score'] >= 60): ?>
                Good job! You have a solid foundation of skills.
            <?php else: ?>
                You have potential to grow in several skill areas.
            <?php endif; ?>
        </p>
    </div>

    <!-- Category Scores -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Category Scores</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($results['category_scores'] as $categoryId => $category): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border shadow-none h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded-circle bg-<?= $category['color'] ?>-subtle text-<?= $category['color'] ?>">
                                            <i class="<?= $category['icon'] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0"><?= Html::encode($category['name']) ?></h5>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-<?= $category['score'] >= 80 ? 'success' : ($category['score'] >= 60 ? 'primary' : 'warning') ?> rounded-pill">
                                        <?= $category['score'] ?>%
                                    </span>
                                </div>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-<?= $category['score'] >= 80 ? 'success' : ($category['score'] >= 60 ? 'primary' : 'warning') ?>" 
                                     role="progressbar" 
                                     style="width: <?= $category['score'] ?>%;" 
                                     aria-valuenow="<?= $category['score'] ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="text-<?= $category['score'] >= 80 ? 'success' : ($category['score'] >= 60 ? 'primary' : 'warning') ?> fw-medium">
                                    <?php if ($category['score'] >= 80): ?>
                                        <i class="ri-star-fill me-1"></i> Excellent
                                    <?php elseif ($category['score'] >= 60): ?>
                                        <i class="ri-check-double-line me-1"></i> Good
                                    <?php else: ?>
                                        <i class="ri-arrow-up-line me-1"></i> Needs Improvement
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Strengths and Areas for Improvement -->
    <div class="row mb-4">
        <!-- Strengths -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-award-line me-2 text-success"></i> Your Strengths
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['strengths'])): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($results['strengths'] as $strength): ?>
                                <li class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <span class="avatar-xs bg-success-subtle text-success rounded-circle">
                                                <i class="ri-check-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fs-14"><?= Html::encode($strength) ?></h6>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <div class="avatar-md mx-auto mb-3">
                                <div class="avatar-title bg-light text-primary rounded-circle">
                                    <i class="ri-information-line fs-24"></i>
                                </div>
                            </div>
                            <h6 class="text-muted mb-0">No significant strengths identified yet</h6>
                            <p class="text-muted small mt-2">Continue developing your skills to identify your strengths</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Areas for Improvement -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-focus-3-line me-2 text-warning"></i> Areas for Improvement
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($results['improvement_areas'])): ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($results['improvement_areas'] as $area): ?>
                                <li class="list-group-item px-0 py-2 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <span class="avatar-xs bg-warning-subtle text-warning rounded-circle">
                                                <i class="ri-arrow-up-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fs-14"><?= Html::encode($area) ?></h6>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <div class="avatar-md mx-auto mb-3">
                                <div class="avatar-title bg-light text-success rounded-circle">
                                    <i class="ri-thumb-up-line fs-24"></i>
                                </div>
                            </div>
                            <h6 class="text-muted mb-0">No significant improvement areas identified</h6>
                            <p class="text-muted small mt-2">You're doing well across all assessed categories</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recommendations -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-lightbulb-flash-line me-2 text-primary"></i> Personalized Recommendations
            </h5>
        </div>
        <div class="card-body">
            <?php if (!empty($results['recommendations'])): ?>
                <div class="row">
                    <?php foreach ($results['recommendations'] as $index => $recommendation): ?>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <div class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                            <?= $index + 1 ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-muted mb-0"><?= Html::encode($recommendation) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-3">
                    <div class="avatar-md mx-auto mb-3">
                        <div class="avatar-title bg-light text-primary rounded-circle">
                            <i class="ri-information-line fs-24"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-0">No recommendations available</h6>
                    <p class="text-muted small mt-2">Complete more assessments to get personalized recommendations</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Next Steps -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="ri-road-map-line me-2 text-info"></i> Next Steps
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border shadow-none mb-0">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-3">
                                <div class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                    <i class="ri-lightbulb-line"></i>
                                </div>
                            </div>
                            <h5 class="fs-15 mb-3">Career Recommendations</h5>
                            <p class="text-muted mb-3">Discover career paths that match your skills and interests</p>
                            <a href="<?= Url::to(['/ai/career-recommendations']) ?>" class="btn btn-info btn-sm">
                                <i class="ri-arrow-right-line me-1"></i> Explore Careers
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border shadow-none mb-0">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-3">
                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                    <i class="ri-briefcase-line"></i>
                                </div>
                            </div>
                            <h5 class="fs-15 mb-3">Job Matching</h5>
                            <p class="text-muted mb-3">Find job opportunities that align with your skills profile</p>
                            <a href="<?= Url::to(['/ai/job-matching']) ?>" class="btn btn-primary btn-sm">
                                <i class="ri-arrow-right-line me-1"></i> Find Jobs
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border shadow-none mb-0">
                        <div class="card-body text-center">
                            <div class="avatar-sm mx-auto mb-3">
                                <div class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                    <i class="ri-book-open-line"></i>
                                </div>
                            </div>
                            <h5 class="fs-15 mb-3">Learning Resources</h5>
                            <p class="text-muted mb-3">Access courses and materials to improve your skills</p>
                            <a href="#" class="btn btn-success btn-sm" onclick="showLearningResourcesModal()">
                                <i class="ri-arrow-right-line me-1"></i> View Resources
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize progress ring animation
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript needed for the results page here
        
        // Example: Animate the progress ring on load
        const progressCircle = document.querySelector('.progress-ring-circle');
        if (progressCircle) {
            const length = progressCircle.getTotalLength();
            progressCircle.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
        }
    });
    
    function showLearningResourcesModal() {
        // This function would show a modal with learning resources
        // You can implement this with SweetAlert2 or Bootstrap modal
        Swal.fire({
            title: 'Learning Resources',
            html: `
                <div class="text-start">
                    <h6 class="mb-3">Recommended for your skill development:</h6>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="ri-global-line me-2 text-primary"></i>
                            <span>Online courses on platforms like Coursera, Udemy, or LinkedIn Learning</span>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="ri-book-2-line me-2 text-primary"></i>
                            <span>Books and documentation for in-depth knowledge</span>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="ri-community-line me-2 text-primary"></i>
                            <span>Community forums and professional groups</span>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="ri-video-line me-2 text-primary"></i>
                            <span>Tutorial videos and webinars</span>
                        </li>
                        <li class="list-group-item px-0 py-2 d-flex align-items-center">
                            <i class="ri-user-star-line me-2 text-primary"></i>
                            <span>Mentorship and coaching programs</span>
                        </li>
                    </ul>
                </div>
            `,
            width: '600px',
            confirmButtonText: 'Close',
            confirmButtonColor: '#0d6efd'
        });
    }
</script>

<style>
    .progress-ring {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 120px;
    }
    
    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
    
    .progress-ring-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #495057;
    }
</style>

