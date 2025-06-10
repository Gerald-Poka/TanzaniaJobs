<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Career Recommendations';

// If $careerCategories is not passed from controller, use default data
if (!isset($careerCategories)) {
    $careerCategories = [
        [
            'id' => 1,
            'name' => 'Software Development',
            'icon' => 'ri-code-s-slash-line',
            'color' => 'primary',
            'description' => 'Build applications, websites, and software solutions',
            'skills' => ['Programming Languages', 'Problem Solving', 'Database Management', 'Version Control'],
            'qualifications' => ['Computer Science Degree', 'Coding Bootcamp', 'Self-taught with Portfolio'],
            'experience' => 'Entry to Senior Level',
            'salary_range' => 'TSh 800,000 - 5,000,000',
            'growth_rate' => '22%',
            'job_count' => 45,
            'recommendations' => [
                'Learn popular programming languages like JavaScript, Python, or Java',
                'Build a strong portfolio with personal projects',
                'Contribute to open-source projects on GitHub',
                'Stay updated with latest frameworks and technologies',
                'Practice coding challenges on platforms like LeetCode'
            ]
        ],
        [
            'id' => 2,
            'name' => 'Digital Marketing',
            'icon' => 'ri-megaphone-line',
            'color' => 'success',
            'description' => 'Promote brands and products through digital channels',
            'skills' => ['SEO/SEM', 'Social Media Management', 'Content Creation', 'Analytics'],
            'qualifications' => ['Marketing Degree', 'Digital Marketing Certification', 'Business Related Field'],
            'experience' => 'Entry to Senior Level',
            'salary_range' => 'TSh 600,000 - 3,500,000',
            'growth_rate' => '18%',
            'job_count' => 32,
            'recommendations' => [
                'Get certified in Google Ads and Google Analytics',
                'Learn social media advertising on Facebook, Instagram, LinkedIn',
                'Develop content creation and copywriting skills',
                'Understand data analysis and reporting tools',
                'Build a personal brand and online presence'
            ]
        ],
        [
            'id' => 3,
            'name' => 'Data Science',
            'icon' => 'ri-bar-chart-line',
            'color' => 'info',
            'description' => 'Analyze data to derive insights and make predictions',
            'skills' => ['Python/R', 'Statistics', 'Machine Learning', 'Data Visualization'],
            'qualifications' => ['Mathematics/Statistics Degree', 'Computer Science', 'Data Science Bootcamp'],
            'experience' => 'Junior to Senior Level',
            'salary_range' => 'TSh 1,200,000 - 6,000,000',
            'growth_rate' => '25%',
            'job_count' => 28,
            'recommendations' => [
                'Master Python or R programming languages',
                'Learn SQL for database querying',
                'Understand statistics and probability concepts',
                'Practice with real datasets on Kaggle',
                'Build end-to-end data science projects'
            ]
        ],
        [
            'id' => 4,
            'name' => 'Project Management',
            'icon' => 'ri-task-line',
            'color' => 'warning',
            'description' => 'Lead teams and deliver projects successfully',
            'skills' => ['Leadership', 'Communication', 'Risk Management', 'Agile/Scrum'],
            'qualifications' => ['PMP Certification', 'Business Degree', 'Agile Certification'],
            'experience' => 'Mid to Senior Level',
            'salary_range' => 'TSh 1,000,000 - 4,500,000',
            'growth_rate' => '15%',
            'job_count' => 38,
            'recommendations' => [
                'Get PMP or Agile certification',
                'Develop strong communication and leadership skills',
                'Learn project management tools like Jira, Trello',
                'Understand budgeting and resource allocation',
                'Practice stakeholder management'
            ]
        ],
        [
            'id' => 5,
            'name' => 'UI/UX Design',
            'icon' => 'ri-palette-line',
            'color' => 'danger',
            'description' => 'Design user-friendly interfaces and experiences',
            'skills' => ['Design Tools', 'User Research', 'Prototyping', 'Visual Design'],
            'qualifications' => ['Design Degree', 'UX Certification', 'Portfolio-based'],
            'experience' => 'Entry to Senior Level',
            'salary_range' => 'TSh 700,000 - 4,000,000',
            'growth_rate' => '20%',
            'job_count' => 25,
            'recommendations' => [
                'Master design tools like Figma, Adobe XD, Sketch',
                'Learn user research and usability testing',
                'Build a strong design portfolio',
                'Understand design principles and accessibility',
                'Study successful app and website designs'
            ]
        ],
        [
            'id' => 6,
            'name' => 'Cybersecurity',
            'icon' => 'ri-shield-check-line',
            'color' => 'secondary',
            'description' => 'Protect systems and data from security threats',
            'skills' => ['Network Security', 'Ethical Hacking', 'Risk Assessment', 'Compliance'],
            'qualifications' => ['Cybersecurity Degree', 'Security Certifications', 'IT Background'],
            'experience' => 'Junior to Expert Level',
            'salary_range' => 'TSh 1,500,000 - 7,000,000',
            'growth_rate' => '28%',
            'job_count' => 18,
            'recommendations' => [
                'Get certified in CISSP, CEH, or CompTIA Security+',
                'Learn about network protocols and security tools',
                'Practice ethical hacking on platforms like HackTheBox',
                'Understand compliance frameworks like ISO 27001',
                'Stay updated with latest security threats and trends'
            ]
        ]
    ];
}

// If $userProfile is not passed from controller, use default data
if (!isset($userProfile)) {
    $userProfile = [
        'name' => 'Guest User',
        'firstname' => 'Guest',
        'lastname' => 'User',
        'skills' => ['JavaScript', 'HTML', 'CSS', 'Communication'],
        'experience_level' => 'Entry Level',
        'education' => 'Computer Science',
        'interests' => ['Technology', 'Web Development', 'Design']
    ];
}

// Calculate match scores for each category if not already calculated
foreach ($careerCategories as &$category) {
    if (!isset($category['match_score'])) {
        // Simple matching algorithm based on user skills
        $matchScore = 0;
        foreach($userProfile['skills'] as $userSkill) {
            foreach($category['skills'] as $categorySkill) {
                if (stripos($categorySkill, $userSkill) !== false || stripos($userSkill, $categorySkill) !== false) {
                    $matchScore += 25;
                }
            }
        }
        $category['match_score'] = min($matchScore, 95); // Cap at 95%
    }
}

// Get user's display name safely
$userName = 'Guest User';
if (isset($userProfile['name'])) {
    $userName = $userProfile['name'];
} elseif (isset($userProfile['firstname'])) {
    $userName = $userProfile['firstname'];
    if (isset($userProfile['lastname'])) {
        $userName .= ' ' . $userProfile['lastname'];
    }
}
?>

<?php echo $this->render('/JobPortal/System/User/partials/main'); ?>

<head>
    <?php echo $this->render('/JobPortal/System/User/partials/title-meta', ['title' => 'Career Recommendations']); ?>
    <?php echo $this->render('/JobPortal/System/User/partials/head-css'); ?>
    
    <style>
        .career-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .career-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .career-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .skill-tag {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            margin: 2px;
            display: inline-block;
        }
        .recommendation-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .recommendation-item:last-child {
            border-bottom: none;
        }
        .match-score {
            font-size: 24px;
            font-weight: bold;
        }
        .growth-indicator {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .ai-badge {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        <?php echo $this->render('/JobPortal/System/User/partials/menu'); ?>
        
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Career Recommendations</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/user/dashboard">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Career Recommendations</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- AI Recommendations Header -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-gradient-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <div class="avatar-title rounded-circle bg-white text-primary">
                                                    <i class="ri-lightbulb-line fs-4"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-1 fw-bold">AI-Powered Career Guidance</h5>
                                            <p class="mb-0 fw-bold text-black">
                                                Personalized recommendations for <?= Html::encode($userName) ?> based on your skills, experience, and market trends
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="ai-badge">
                                                <i class="ri-robot-line me-1"></i> AI Powered
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Career Categories Grid -->
                    <div class="row">
                        <?php foreach($careerCategories as $category): ?>
                        <div class="col-xl-4 col-lg-6 mb-4">
                            <div class="card career-card h-100">
                                <div class="card-body">
                                    <!-- Header -->
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="career-icon bg-<?= $category['color'] ?>-subtle text-<?= $category['color'] ?>">
                                                <i class="<?= $category['icon'] ?>"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h5 class="mb-1"><?= Html::encode($category['name']) ?></h5>
                                                <p class="text-muted mb-0 small"><?= Html::encode($category['description']) ?></p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="growth-indicator">
                                                <i class="ri-arrow-up-line"></i> <?= $category['growth_rate'] ?>
                                            </div>
                                            <small class="text-muted"><?= $category['job_count'] ?> jobs</small>
                                        </div>
                                    </div>

                                    <!-- Match Score -->
                                    <?php 
                                        $matchScore = $category['match_score'];
                                        $matchClass = $matchScore >= 70 ? 'success' : ($matchScore >= 40 ? 'warning' : 'info');
                                    ?>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="match-score text-<?= $matchClass ?>"><?= $matchScore ?>%</div>
                                                <small class="text-muted">Match Score</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-center">
                                                <div class="match-score text-primary"><?= Html::encode($category['salary_range']) ?></div>
                                                <small class="text-muted">Salary Range</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Required Skills -->
                                    <div class="mb-3">
                                        <h6 class="mb-2">Required Skills:</h6>
                                        <div class="d-flex flex-wrap">
                                            <?php foreach($category['skills'] as $skill): ?>
                                                <span class="skill-tag"><?= Html::encode($skill) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <!-- Qualifications -->
                                    <div class="mb-3">
                                        <h6 class="mb-2">Qualifications:</h6>
                                        <ul class="list-unstyled mb-0">
                                            <?php foreach($category['qualifications'] as $qualification): ?>
                                                <li class="small text-muted mb-1">
                                                    <i class="ri-check-line text-success me-1"></i> <?= Html::encode($qualification) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-auto">
                                        <button type="button" class="btn btn-<?= $category['color'] ?> btn-sm w-100" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#careerModal"
                                                onclick="showCareerDetails(<?= htmlspecialchars(json_encode($category)) ?>)">
                                            <i class="ri-eye-line me-1"></i> View Recommendations
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Quick Tips Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-trophy-line text-warning me-2"></i>
                                        General Career Success Tips
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-success text-white">
                                                            <i class="ri-book-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Continuous Learning</h6>
                                                    <p class="text-muted mb-0 small">Stay updated with industry trends and continuously develop new skills</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-info text-white">
                                                            <i class="ri-team-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Network Building</h6>
                                                    <p class="text-muted mb-0 small">Connect with professionals in your field and attend industry events</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-warning text-white">
                                                            <i class="ri-lightbulb-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Portfolio Development</h6>
                                                    <p class="text-muted mb-0 small">Build a strong portfolio showcasing your skills and achievements</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs">
                                                        <div class="avatar-title rounded-circle bg-danger text-white">
                                                            <i class="ri-target-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1">Goal Setting</h6>
                                                    <p class="text-muted mb-0 small">Set clear career goals and create actionable plans to achieve them</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <?php echo $this->render('/JobPortal/System/User/partials/footer'); ?>
        </div>
    </div>

    <!-- Career Details Modal -->
    <div class="modal fade" id="careerModal" tabindex="-1" aria-labelledby="careerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="careerModalLabel">
                        <i class="ri-lightbulb-line me-2"></i>
                        <span id="modalCareerName">Career Recommendations</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="searchJobs()">
                        <i class="ri-search-line me-1"></i> Search Related Jobs
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->render('/JobPortal/System/User/partials/customizer'); ?>
    <?php echo $this->render('/JobPortal/System/User/partials/vendor-scripts'); ?>

        <!-- App js -->
    <script src="/js/app.js"></script>

    <script>
        let currentCareer = null;
        const userName = <?= json_encode($userName) ?>;

        function showCareerDetails(career) {
            currentCareer = career;
            document.getElementById('modalCareerName').textContent = career.name + ' - Career Path';
            
            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = `
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="career-icon bg-${career.color}-subtle text-${career.color} me-3">
                                <i class="${career.icon}"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">${career.name}</h4>
                                <p class="text-muted mb-0">${career.description}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="text-primary">📈 Market Insights</h6>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <div class="border-end">
                                            <h5 class="text-success">${career.growth_rate}</h5>
                                            <small class="text-muted">Growth Rate</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="text-primary">${career.job_count}</h5>
                                        <small class="text-muted">Available Jobs</small>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <h6 class="text-dark">${career.salary_range}</h6>
                                    <small class="text-muted">Salary Range (Monthly)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="text-primary">🎯 Required Skills</h6>
                                <div class="d-flex flex-wrap">
                                    ${career.skills.map(skill => `<span class="skill-tag me-1 mb-1">${skill}</span>`).join('')}
                                </div>
                                <hr>
                                <h6 class="text-primary">🎓 Qualifications</h6>
                                <ul class="list-unstyled mb-0">
                                    ${career.qualifications.map(qual => `
                                        <li class="small mb-1">
                                            <i class="ri-check-line text-success me-1"></i> ${qual}
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="ri-lightbulb-line me-2"></i>
                                    Personalized Recommendations for ${userName}
                                </h6>
                            </div>
                            <div class="card-body">
                                ${career.recommendations.map((rec, index) => `
                                    <div class="recommendation-item">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xs">
                                                    <div class="avatar-title rounded-circle bg-primary text-white fs-6">
                                                        ${index + 1}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0">${rec}</p>
                                            </div>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function searchJobs() {
            if (currentCareer) {
                window.location.href = '/jobs/browse?category=' + encodeURIComponent(currentCareer.name);
            }
        }
    </script>
</body>
</html>