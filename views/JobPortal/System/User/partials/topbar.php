<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <i class="ri-briefcase-4-fill text-primary fs-3"></i>
                        </span>
                        <span class="logo-lg">
                            <span class="fw-bold text-dark fs-4">TanzaniaJobs</span>
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <i class="ri-briefcase-4-fill text-white fs-3"></i>
                        </span>
                        <span class="logo-lg">
                            <span class="fw-bold text-white fs-4">TanzaniaJobs</span>
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search jobs, companies, or candidates..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index" class="btn btn-soft-primary btn-sm rounded-pill">software developer <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index" class="btn btn-soft-primary btn-sm rounded-pill">data analyst <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index" class="btn btn-soft-primary btn-sm rounded-pill">marketing manager <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>
                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Quick Access</h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-briefcase-line align-middle fs-18 text-muted me-2"></i>
                                <span>Job Listings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-building-2-line align-middle fs-18 text-muted me-2"></i>
                                <span>Company Profiles</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-line align-middle fs-18 text-muted me-2"></i>
                                <span>Candidate Profiles</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-line-chart-line align-middle fs-18 text-muted me-2"></i>
                                <span>Analytics Dashboard</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Featured Companies</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                                <i class="ri-building-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Vodacom Tanzania</h6>
                                            <span class="fs-11 mb-0 text-muted">Telecommunications</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                <i class="ri-bank-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">CRDB Bank</h6>
                                            <span class="fs-11 mb-0 text-muted">Banking & Finance</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                                <i class="ri-computer-line"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">TechnoServe</h6>
                                            <span class="fs-11 mb-0 text-muted">Technology & Development</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">


                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="/images/users/avatar-1.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">
                                    <?= Yii::$app->user->identity->getFullName() ?>
                                </span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                    <?= Yii::$app->user->identity->isAdmin() ? 'Administrator' : 'User' ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome to TanzaniaJobs, <?= Yii::$app->user->identity->firstname ?>!</h6>
                        <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/user/profile']) ?>">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">My Profile</span>
                        </a>

                        <a class="dropdown-item" href="apps-chat">
                            <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Messages</span>
                        </a>
                        <a class="dropdown-item" href="job-applications">
                            <i class="ri-briefcase-line text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">My Applications</span>
                        </a>
                        <a class="dropdown-item" href="pages-faqs">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Help & Support</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile-settings">
                            <span class="badge bg-success-subtle text-success mt-1 float-end">New</span>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Account Settings</span>
                        </a>

                        <!-- Use a form for logout -->
                        <?= \yii\helpers\Html::beginForm(['/logout'], 'post', ['style' => 'display: inline;']) ?>
                            <button type="submit" class="dropdown-item" style="border: none; background: none; text-align: left; width: 100%; padding: 8px 16px;">
                                <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> 
                                <span class="align-middle" data-key="t-logout">Logout</span>
                            </button>
                        <?= \yii\helpers\Html::endForm() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->