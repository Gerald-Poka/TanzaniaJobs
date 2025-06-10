<?php echo $this->render('partials/main'); ?>

<head>
    <?php echo $this->render('partials/title-meta', array('title'=>'Sign In')); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <?php echo $this->render('partials/head-css'); ?>
    
    <!-- Custom SweetAlert positioning -->
    <style>
        .swal2-popup-custom {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 9999 !important;
            margin: 0 !important;
        }
        
        .swal2-container {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            z-index: 9998 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .swal2-backdrop-show {
            background-color: rgba(0, 0, 0, 0.4) !important;
        }
    </style>

    <!-- Check for logout flash message -->
    <?php if (Yii::$app->session->hasFlash('logout_success')): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Logged Out!',
            text: '<?= Yii::$app->session->getFlash('logout_success') ?>',
            icon: 'success',
            timer: 3000,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            position: 'center',
            backdrop: true,
            allowOutsideClick: true,
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'btn btn-primary w-xs',
            },
            buttonsStyling: false,
            didOpen: () => {
                const popup = Swal.getPopup();
                popup.style.position = 'fixed';
                popup.style.top = '50%';
                popup.style.left = '50%';
                popup.style.transform = 'translate(-50%, -50%)';
                popup.style.zIndex = '9999';
            }
        });
    });
    </script>
    <?php endif; ?>
</head>

<body>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill border-0 card-border-effect-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                        <a class="navbar-brand" href="/">
                                            <div class="d-flex align-items-center">
                                                <i class="ri-briefcase-4-fill text-danger fs-4 me-2"></i>
                                                <h3 class="m-0 fw-bold">TanzaniaJobs</h3>
                                            </div>
                                        </a>
                                            <!-- Rest of the carousel content stays the same -->
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-briefcase-4-line display-4 text-success"></i>
                                                </div>
                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" TanzaniaJobs helped me find opportunities that match my skills perfectly. Their AI matching system is a game-changer for job seekers! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" The skills assessment tool helped me identify areas for improvement and stand out to employers in Tanzania's competitive job market. "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" As an employer, I found qualified candidates within days. The platform's focus on local talent makes recruitment much easier. "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome to TanzaniaJobs!</h5>
                                            <p class="text-muted">Sign in to access Tanzania's premier AI-powered job matching platform.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" novalidate id="signinForm" method="post">
                                                <?= \yii\helpers\Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                                                
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a valid email
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="/auth-pass-reset-cover" class="text-muted">Forgot password?</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" name="password" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter your password
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="auth-remember-check" name="remember">
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100" type="submit" id="signin-button">Sign In</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                                    </div>

                                                    <div>
                                                        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Don't have an account ? <a href="/auth-signup" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> TanzaniaJobs. Connecting talent with opportunity across Tanzania.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <?php echo $this->render('partials/vendor-scripts'); ?>

    <!-- Sweet Alerts js -->
    <script src="/libs/sweetalert2/sweetalert2.min.js"></script>
    
    <!-- password-addon init -->
    <script src="/js/pages/password-addon.init.js"></script>
    
    <!-- Signin handling script -->
    <script src="/js/JobPortal/signin.js"></script>

    <!-- password-addon init -->
    <script src="/js/pages/password-addon.init.js"></script>
</body>
</html>
