<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/user/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <i class="ri-briefcase-4-fill text-primary fs-4"></i>
            </span>
            <span class="logo-lg">
                <span class="fw-bold text-dark">TanzaniaJobs</span>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/user/dashboard" class="logo logo-light">
            <span class="logo-sm">
                <i class="ri-briefcase-4-fill text-primary fs-4"></i>
            </span>
            <span class="logo-lg">
                <span class="fw-bold text-white">TanzaniaJobs</span>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                
                <!-- Dashboard -->
                <li class="menu-title"><span data-key="t-menu">Dashboard</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/user/dashboard">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <!-- Job Management -->
                <li class="menu-title"><i class="ri-briefcase-line"></i> <span data-key="t-jobs">Job Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarJobs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarJobs">
                        <i class="ri-search-line"></i> <span data-key="t-job-search">Job Search</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarJobs">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/jobs/browse" class="nav-link" data-key="t-browse-jobs">Browse Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/jobs/categories" class="nav-link" data-key="t-job-categories">Job Categories</a>
                            </li>
                            <li class="nav-item">
                                <a href="/jobs/saved" class="nav-link" data-key="t-saved-jobs">Saved Jobs</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApplications" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApplications">
                        <i class="ri-file-text-line"></i> <span data-key="t-applications">My Applications</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApplications">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user-applications/active']) ?>" class="nav-link" data-key="t-active-applications">Active Applications</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user-applications/pending']) ?>" class="nav-link" data-key="t-pending-applications">Pending Applications</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user-applications/interviews']) ?>" class="nav-link" data-key="t-interviews">Interview Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user-applications/history']) ?>" class="nav-link" data-key="t-application-history">Application History</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Profile & CV -->
                <li class="menu-title"><i class="ri-user-line"></i> <span data-key="t-profile">Profile & CV</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarProfile" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProfile">
                        <i class="ri-user-settings-line"></i> <span data-key="t-my-profile">My Profile</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarProfile">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user/profile']) ?>" class="nav-link" data-key="t-view-profile">View Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= \yii\helpers\Url::to(['/user/profile-edit']) ?>" class="nav-link" data-key="t-edit-profile">Edit Profile</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCV" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCV">
                        <i class="ri-file-user-line"></i> <span data-key="t-cv-resume">CV & Resume</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCV">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/cv/builder" class="nav-link" data-key="t-cv-builder">CV Builder</a>
                            </li>
                            <li class="nav-item">
                                <a href="/cv/templates" class="nav-link" data-key="t-cv-templates">CV Templates</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- AI Features -->
                <li class="menu-title"><i class="ri-robot-line"></i> <span data-key="t-ai-features">AI Features</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/ai/job-matching">
                        <i class="ri-magic-line"></i> <span data-key="t-ai-job-matching">AI Job Matching</span>
                        <span class="badge badge-pill bg-primary">AI</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/ai/skills-assessment">
                        <i class="ri-brain-line"></i> <span data-key="t-skills-assessment">Skills Assessment</span>
                        <span class="badge badge-pill bg-success">New</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?= \yii\helpers\Url::to(['/ai/career-recommendations']) ?>">
                        <i class="ri-lightbulb-line"></i> <span data-key="t-career-advice">Career Recommendations</span>
                    </a>
                </li>

                <!-- Communication -->
                <li class="menu-title"><i class="ri-message-line"></i> <span data-key="t-communication">Communication</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/messages">
                        <i class="ri-chat-3-line"></i> <span data-key="t-messages">Messages</span>
                        <span class="badge badge-pill bg-danger">3</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/notifications">
                        <i class="ri-notification-line"></i> <span data-key="t-notifications">Notifications</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>