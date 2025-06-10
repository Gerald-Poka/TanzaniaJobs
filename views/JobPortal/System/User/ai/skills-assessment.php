<?php
use yii\helpers\Html;
use yii\helpers\Url;

// Mock data for testing - replace this with actual backend data
$mockCategories = [
    [
        'id' => 1,
        'name' => 'Web Development',
        'description' => 'Frontend and Backend development skills',
        'icon' => 'ri-code-line',
        'color' => 'primary',
        'questions' => [
            'HTML/CSS proficiency',
            'JavaScript knowledge',
            'Responsive design skills',
            'Version control (Git)',
            'API integration experience'
        ]
    ],
    [
        'id' => 2,
        'name' => 'Data Analysis',
        'description' => 'Data processing and analysis capabilities',
        'icon' => 'ri-bar-chart-line',
        'color' => 'success',
        'questions' => [
            'Excel/Spreadsheet skills',
            'SQL knowledge',
            'Data visualization',
            'Statistical analysis',
            'Report writing'
        ]
    ],
    [
        'id' => 3,
        'name' => 'Digital Marketing',
        'description' => 'Online marketing and promotion skills',
        'icon' => 'ri-megaphone-line',
        'color' => 'warning',
        'questions' => [
            'Social media marketing',
            'SEO knowledge',
            'Content creation',
            'Email marketing',
            'Analytics tracking'
        ]
    ],
    [
        'id' => 4,
        'name' => 'Project Management',
        'description' => 'Planning and coordination abilities',
        'icon' => 'ri-task-line',
        'color' => 'info',
        'questions' => [
            'Team coordination',
            'Timeline management',
            'Risk assessment',
            'Communication skills',
            'Problem solving'
        ]
    ]
];

$availableCategories = $mockCategories;
?>

<?php echo $this->render('../partials/main'); ?>

<head>
    <?php echo $this->render('../partials/title-meta', array('title' => 'Skills Assessment')); ?>
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <?php echo $this->render('../partials/head-css'); ?>
    
    <style>
        .assessment-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .assessment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .skill-rating {
            margin: 15px 0;
        }
        .rating-scale {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 10px;
        }
        .rating-scale input[type="radio"] {
            display: none;
        }
        .rating-scale label {
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 8px;
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            min-width: 45px;
            text-align: center;
        }
        .rating-scale label:hover {
            background: #e9ecef;
            border-color: #0d6efd;
            transform: translateY(-2px);
        }
        .rating-scale input[type="radio"]:checked + label {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
        }
        .progress-indicator {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #0d6efd, #6f42c1);
            transition: width 0.5s ease;
            border-radius: 3px;
        }
        .question-text h6 {
            font-size: 15px;
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .rating-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            font-size: 12px;
            color: #6c757d;
        }
        .category-icon {
            height: 2.5rem;
            width: 2.5rem;
        }
        .category-icon .avatar-title {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .avatar-sm {
            height: 2.5rem;
            width: 2.5rem;
        }
        .avatar-sm .avatar-title {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .avatar-lg {
            height: 4rem;
            width: 4rem;
        }
        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 500;
        }
        #assessmentContainer {
            display: none;
        }
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
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

                    <?php echo $this->render('../partials/page-title', array('pagetitle' => 'AI Tools', 'title' => 'Skills Assessment')); ?>

                    <!-- Assessment Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-gradient-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-lg">
                                                <div class="avatar-title rounded-circle bg-white text-primary">
                                                    <i class="ri-brain-line fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-4">
                                            <h4 class="text-white mb-2">AI-Powered Skills Assessment</h4>
                                            <p class="text-white-75 mb-0 fs-15">
                                                Evaluate your professional skills and get personalized career recommendations
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="d-flex gap-2">
                                                <span class="badge bg-white text-primary fs-12">
                                                    <i class="ri-time-line me-1"></i> ~15 minutes
                                                </span>
                                                <span class="badge bg-success-subtle text-success fs-12">
                                                    <i class="ri-star-line me-1"></i> Free
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Select Assessment Categories</h5>
                                    <p class="text-muted mb-4">Choose the skill categories you want to assess. You can select multiple categories.</p>
                                    
                                    <div class="category-selection">
                                        <select id="categorySelector" class="form-select" multiple>
                                            <?php if (isset($availableCategories) && !empty($availableCategories)): ?>
                                                <?php foreach($availableCategories as $category): ?>
                                                    <option value="<?= $category['id'] ?>" 
                                                            data-icon="<?= $category['icon'] ?>" 
                                                            data-color="<?= $category['color'] ?>"
                                                            data-name="<?= Html::encode($category['name']) ?>"
                                                            data-description="<?= Html::encode($category['description']) ?>"
                                                            data-questions="<?= Html::encode(json_encode($category['questions'])) ?>">
                                                        <?= Html::encode($category['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option disabled>No categories available</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <button type="button" id="loadAssessmentBtn" class="btn btn-primary">
                                            <i class="ri-file-list-3-line me-1"></i> Load Assessment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Container -->
                    <div id="assessmentContainer">
                        <!-- Progress Indicator -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="mb-0">Assessment Progress</h6>
                                            <span class="text-muted" id="progressText">0% Complete</span>
                                        </div>
                                        <div class="progress-indicator">
                                            <div class="progress-fill" id="progressBar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Spinner -->
                        <div id="loadingSpinner" class="loading-spinner" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <!-- Assessment Form -->
                        <form id="skillsAssessmentForm" method="post" action="<?= Url::to(['/ai/skills-assessment']) ?>">
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <input type="hidden" name="selectedCategories" id="selectedCategoriesInput" value="">
                            
                            <div id="assessmentContent" class="row">
                                <!-- Assessment content will be loaded here dynamically -->
                            </div>

                            <!-- Submit Button -->
                            <div class="row" id="submitSection" style="display: none;">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                                <i class="ri-brain-line me-2"></i> Complete Assessment
                                            </button>
                                            <p class="text-muted mt-3 mb-0">
                                                Get your personalized skills report and career recommendations
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

    <!-- Results Modal -->
    <div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultsModalLabel">
                        <i class="ri-award-line me-2 text-warning"></i>
                        Your Skills Assessment Results
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultsContent">
                    <!-- Results will be loaded here -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Processing your assessment...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="viewCareerRecommendations()">
                        <i class="ri-lightbulb-line me-1"></i> View Career Recommendations
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->render('../partials/customizer'); ?>
    <?php echo $this->render('../partials/vendor-scripts'); ?>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#categorySelector').select2({
                theme: 'bootstrap-5',
                placeholder: 'Select skill categories to assess',
                allowClear: true,
                closeOnSelect: false,
                templateResult: formatCategoryOption,
                templateSelection: formatCategorySelection
            });

            // Format category options with icons
            function formatCategoryOption(category) {
                if (!category.id) {
                    return category.text;
                }
                
                const icon = $(category.element).data('icon') || 'ri-briefcase-line';
                const color = $(category.element).data('color') || 'primary';
                
                return $(`
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="${icon} text-${color} me-2"></i>
                        </div>
                        <div class="flex-grow-1">
                            ${category.text}
                        </div>
                    </div>
                `);
            }

            // Format selected categories
            function formatCategorySelection(category) {
                if (!category.id) {
                    return category.text;
                }
                
                const icon = $(category.element).data('icon') || 'ri-briefcase-line';
                return $(`<i class="${icon} me-1"></i> ${category.text}`);
            }

            // Load Assessment button click handler
            $('#loadAssessmentBtn').on('click', function() {
                const selectedCategories = $('#categorySelector').val();
                
                if (!selectedCategories || selectedCategories.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Categories Selected',
                        text: 'Please select at least one skill category to assess.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                
                // Show assessment container and loading spinner
                $('#assessmentContainer').show();
                $('#loadingSpinner').show();
                $('#assessmentContent').empty();
                $('#submitSection').hide();
                
                // Store selected categories in hidden input
                $('#selectedCategoriesInput').val(JSON.stringify(selectedCategories));
                
                // Simulate loading delay for better UX
                setTimeout(() => {
                    loadAssessmentQuestions(selectedCategories);
                }, 1000);
            });

            // Load assessment questions (using mock data)
            function loadAssessmentQuestions(selectedCategoryIds) {
                try {
                    const categories = [];
                    
                    // Get selected categories data
                    selectedCategoryIds.forEach(categoryId => {
                        const option = $(`#categorySelector option[value="${categoryId}"]`);
                        if (option.length) {
                            categories.push({
                                id: categoryId,
                                name: option.data('name'),
                                description: option.data('description'),
                                icon: option.data('icon'),
                                color: option.data('color'),
                                questions: JSON.parse(option.data('questions'))
                            });
                        }
                    });
                    
                    if (categories.length > 0) {
                        $('#loadingSpinner').hide();
                        renderAssessmentQuestions(categories);
                        $('#submitSection').show();
                        
                        // Scroll to assessment content
                        $('html, body').animate({
                            scrollTop: $('#assessmentContainer').offset().top - 100
                        }, 500);
                    } else {
                        throw new Error('No valid categories found');
                    }
                } catch (error) {
                    console.error('Error loading assessment:', error);
                    $('#loadingSpinner').hide();
                    $('#assessmentContainer').hide();
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load assessment questions. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            }

            // Render assessment questions
            function renderAssessmentQuestions(categories) {
                let html = '';
                let totalQuestions = 0;
                
                categories.forEach(function(category) {
                    totalQuestions += category.questions.length;
                    
                    html += `
                    <div class="col-12 mb-4">
                        <div class="card assessment-card">
                            <div class="card-header border-0 pb-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm category-icon">
                                            <div class="avatar-title rounded-circle bg-${category.color || 'primary'}-subtle text-${category.color || 'primary'}">
                                                <i class="${category.icon || 'ri-star-line'}"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1 text-dark">${category.name}</h5>
                                        <p class="text-muted mb-0 fs-14">${category.description || 'Assess your skills in this category'}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-light text-body">
                                            ${category.questions.length} Questions
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                <div class="row">`;
                    
                    category.questions.forEach(function(question, qIndex) {
                        html += `
                        <div class="col-lg-6 mb-4">
                            <div class="skill-rating">
                                <div class="question-text">
                                    <h6>${question}</h6>
                                </div>
                                <div class="rating-scale">`;
                        
                        for (let i = 1; i <= 5; i++) {
                            html += `
                            <input type="radio" 
                                   name="assessment[${category.id}][${qIndex}]" 
                                   value="${i}" 
                                   id="q${category.id}_${qIndex}_${i}" 
                                   required>
                            <label for="q${category.id}_${qIndex}_${i}">${i}</label>`;
                        }
                        
                        html += `
                                </div>
                                <div class="rating-labels">
                                    <small class="text-muted">Beginner</small>
                                    <small class="text-muted">Expert</small>
                                </div>
                            </div>
                        </div>`;
                    });
                    
                    html += `
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                
                $('#assessmentContent').html(html);
                
                // Initialize progress tracking
                initProgressTracking(totalQuestions);
            }
            
            // Initialize progress tracking
            function initProgressTracking(totalQuestions) {
                // Update progress when radio buttons change
                $(document).on('change', 'input[type="radio"]', function() {
                    updateProgress(totalQuestions);
                    
                    // Auto-scroll to next section
                    const currentCard = $(this).closest('.assessment-card');
                    const totalQuestionsInCard = currentCard.find('input[type="radio"]').length / 5;
                    const answeredQuestionsInCard = currentCard.find('input[type="radio"]:checked').length;
                    
                    if (answeredQuestionsInCard === totalQuestionsInCard) {
                        setTimeout(() => scrollToNextSection(currentCard), 300);
                    }
                });
                
                // Initial progress calculation
                updateProgress(totalQuestions);
            }
            
            // Update progress bar and text
            function updateProgress(totalQuestions) {
                const answeredQuestions = $('input[type="radio"]:checked').length;
                const progress = totalQuestions > 0 ? Math.round((answeredQuestions / totalQuestions) * 100) : 0;
                
                $('#progressBar').css('width', progress + '%');
                $('#progressText').text(progress + '% Complete');
                
                // Enable/disable submit button based on completion
                if (progress === 100) {
                    $('#submitBtn').prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
                } else {
                    $('#submitBtn').prop('disabled', true).removeClass('btn-primary').addClass('btn-secondary');
                }
            }

            // Handle form submission
            $('#skillsAssessmentForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = $(this).serialize();
                const submitBtn = $('#submitBtn');
                const originalHtml = submitBtn.html();
                
                // Show loading state
                submitBtn.html('<i class="ri-loader-4-line spin me-2"></i> Processing Assessment...').prop('disabled', true);
                
                // Show modal immediately
                $('#resultsModal').modal('show');
                
                // Simulate assessment processing
                setTimeout(() => {
                    const mockResults = generateMockResults();
                    $('#resultsContent').html(mockResults);
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Assessment Completed!',
                        text: 'Your skills have been evaluated successfully.',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    submitBtn.html(originalHtml).prop('disabled', false);
                }, 2000);
            });

            // Generate mock results
            function generateMockResults() {
                return `
                <div class="row">
                    <div class="col-12">
                        <div class="text-center mb-4">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                    <i class="ri-trophy-line fs-1"></i>
                                </div>
                            </div>
                            <h4 class="text-success mb-2">Assessment Complete!</h4>
                            <p class="text-muted">Your skills have been evaluated across all selected categories.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-2">Overall Score</h6>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: 78%"></div>
                                        </div>
                                    </div>
                                    <span class="text-success fw-bold ms-2">78%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-2">Skill Level</h6>
                                <span class="badge bg-success-subtle text-success fs-12">Intermediate</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
        });

        function viewCareerRecommendations() {
            window.location.href = '<?= Url::to(['/ai/career-recommendations']) ?>';
        }

        // Add smooth scrolling for better UX
        function scrollToNextSection(currentCard) {
            const nextCard = currentCard.next('.assessment-card');
            if (nextCard.length) {
                $('html, body').animate({
                    scrollTop: nextCard.offset().top - 100
                }, 500);
            } else {
                // Scroll to submit button if last card
                $('html, body').animate({
                    scrollTop: $('#submitSection').offset().top - 100
                }, 500);
            }
        }
    </script>
</body>
</html>

