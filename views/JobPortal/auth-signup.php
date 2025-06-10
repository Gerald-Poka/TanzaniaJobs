<?php echo $this->render('partials/main'); ?>

<head>
    <?php echo $this->render('partials/title-meta', array('title'=>'Sign Up')); ?>
    <?php echo $this->render('partials/head-css'); ?>
    
    <!-- Sweet Alert css-->
    <link href="/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
                        <div class="card overflow-hidden m-0 card-bg-fill border-0 card-border-effect-none">
                            <div class="row justify-content-center g-0">
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
                                                            <p class="fs-15 fst-italic">" Creating my profile on TanzaniaJobs was simple and the AI matched me with jobs I never would have found otherwise! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" As a recent graduate, the career insights and job recommendations helped me find my first professional role in Dar es Salaam. "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" TanzaniaJobs helped me identify skill gaps and connect with training opportunities to advance my career in the tech sector. "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Create Your Account</h5>
                                            <p class="text-muted">Join Tanzania's premier AI-powered job matching platform</p>
                                        </div>

                                        <div class="mt-4">
                                            <form class="needs-validation" novalidate id="signupForm" method="post">
                                                <?= \yii\helpers\Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                                                
                                                <div class="mb-3">
                                                    <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" required>
                                                    <div class="invalid-feedback">
                                                        Please enter your first name
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter your last name" required>
                                                    <div class="invalid-feedback">
                                                        Please enter your last name
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="useremail" name="email" placeholder="Enter your email address" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a valid email
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" name="password" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter password
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label" for="confirm-password-input">Confirm Password <span class="text-danger">*</span></label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input" 
                                                                onpaste="return false" 
                                                                placeholder="Confirm password" 
                                                                id="confirm-password-input" 
                                                                name="confirm-password" 
                                                                required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please confirm your password
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the TanzaniaJobs <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Service</a> and <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-primary text-decoration-underline fst-normal fw-medium">Privacy Policy</a></p>
                                                </div>

                                                <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                    <h5 class="fs-13">Password must contain:</h5>
                                                    <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                                    <p id="pass-lower" class="invalid fs-12 mb-2">At least one <b>lowercase</b> letter (a-z)</p>
                                                    <p id="pass-upper" class="invalid fs-12 mb-2">At least one <b>uppercase</b> letter (A-Z)</p>
                                                    <p id="pass-number" class="invalid fs-12 mb-0">At least one <b>number</b> (0-9)</p>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit" id="signup-button">Create Account</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account? <a href="/auth-signin" class="fw-semibold text-primary text-decoration-underline">Sign In</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
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

    <!-- validation init -->
    <script src="/js/pages/form-validation.init.js"></script>

    <!-- password create init -->
    <script src="/js/pages/passowrd-create.init.js"></script>
    
    <!-- Signup handling script -->
    <script src="/js/JobPortal/signup-up.js"></script>

    <!-- Terms of Service Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="termsModalLabel">TanzaniaJobs Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    <h4>TanzaniaJobs Portal - Terms of Service</h4>
                    <p class="text-muted">Last updated: May 29, 2025</p>
                    
                    <h5>1. Platform Overview</h5>
                    <p>TanzaniaJobs is an AI-powered job matching platform designed specifically for the Tanzanian job market. Our services include job listings, resume/CV matching, skills assessment, interview preparation, and career guidance.</p>
                    
                    <h5>2. User Accounts</h5>
                    <p>When creating an account on TanzaniaJobs, you must provide accurate and complete information. You are responsible for maintaining the confidentiality of your password and account information. You may not share your account credentials with others.</p>
                    
                    <h5>3. Job Seeker Responsibilities</h5>
                    <p>As a job seeker using our platform, you agree to:</p>
                    <ul>
                        <li>Provide accurate information about your skills, experience, and qualifications</li>
                        <li>Only apply for positions for which you are genuinely qualified and interested</li>
                        <li>Respect the privacy and confidentiality of employers' information</li>
                        <li>Attend scheduled interviews or provide timely notice of cancellation</li>
                    </ul>
                    
                    <h5>4. Employer Responsibilities</h5>
                    <p>As an employer using our platform, you agree to:</p>
                    <ul>
                        <li>Provide accurate job descriptions and requirements</li>
                        <li>Comply with all Tanzanian labor laws and regulations</li>
                        <li>Respect candidates' privacy and data protection rights</li>
                        <li>Provide timely responses to applicants</li>
                        <li>Not discriminate against applicants based on gender, religion, disability, or other protected characteristics</li>
                    </ul>
                    
                    <h5>5. AI Matching System</h5>
                    <p>Our platform uses artificial intelligence to match job seekers with suitable positions. While we strive for accuracy, we do not guarantee that all matches will be perfect. The AI system is designed to supplement, not replace, human decision-making in the hiring process.</p>
                    
                    <h5>6. Data Usage and Retention</h5>
                    <p>We retain user data in accordance with our Privacy Policy. Job seeker profiles remain active until explicitly deleted by the user or after 24 months of inactivity.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="privacyModalLabel">TanzaniaJobs Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="privacy-content">
                    <h4>TanzaniaJobs Portal - Privacy Policy</h4>
                    <p class="text-muted">Last updated: May 29, 2025</p>
                    
                    <h5>1. Information We Collect</h5>
                    <p>When you use TanzaniaJobs, we collect:</p>
                    <ul>
                        <li><strong>Account information:</strong> Name, email, password, and contact details</li>
                        <li><strong>Professional information:</strong> Work experience, education, skills, certifications</li>
                        <li><strong>Usage data:</strong> How you interact with our platform, including job applications, searches, and features used</li>
                        <li><strong>Device information:</strong> IP address, browser type, device type</li>
                    </ul>
                    
                    <h5>2. How We Use Your Information</h5>
                    <p>Your data helps us:</p>
                    <ul>
                        <li>Match you with appropriate job opportunities using our AI system</li>
                        <li>Improve our platform and services</li>
                        <li>Communicate important updates about your account or applications</li>
                        <li>Generate anonymized labor market insights for Tanzania</li>
                    </ul>
                    
                    <h5>3. Data Security</h5>
                    <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or disclosure. Your data is stored on secure servers located within Tanzania and complies with local data protection regulations.</p>
                    
                    <h5>4. Information Sharing</h5>
                    <p>We may share your information with:</p>
                    <ul>
                        <li><strong>Employers:</strong> When you apply for positions, your profile information is shared with the employer</li>
                        <li><strong>Service providers:</strong> Companies that help us operate our platform</li>
                        <li><strong>Legal requirements:</strong> When required by Tanzanian law or to protect our rights</li>
                    </ul>
                    
                    <h5>5. Your Rights</h5>
                    <p>As a user, you have the right to:</p>
                    <ul>
                        <li>Access your personal information</li>
                        <li>Correct inaccurate data</li>
                        <li>Delete your account and associated data</li>
                        <li>Export your information in a portable format</li>
                        <li>Opt out of certain data processing activities</li>
                    </ul>
                    
                    <h5>6. Contact Us</h5>
                    <p>If you have questions about our privacy practices, please contact our Data Protection Officer at privacy@tanzaniajobs.co.tz</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission with Velzon-style SweetAlert
        const signupForm = document.getElementById('signupForm');
        
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Client-side validation
            if (!signupForm.checkValidity()) {
                e.stopPropagation();
                signupForm.classList.add('was-validated');
                return;
            }
            
            // Password confirmation check
            const password = document.getElementById('password-input').value;
            const confirmPassword = document.getElementById('confirm-password-input').value;
            
            if (password !== confirmPassword) {
                // Custom styled error alert like the one in the example
                Swal.fire({
                    title: 'Error!',
                    text: 'Passwords do not match!',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs mt-2',
                    },
                    buttonsStyling: false
                });
                return;
            }
            
            // Disable button to prevent multiple submissions
            const submitButton = document.getElementById('signup-button');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating account...';
            
            // Get form data
            const formData = new FormData(signupForm);
            
            // Send AJAX request
            fetch('/auth-signup', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show styled success message like in the examples
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your account has been created successfully!',
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Login Now',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs',
                        },
                        buttonsStyling: false
                    }).then(function() {
                        // Redirect to login page
                        window.location.href = '/auth-signin';
                    });
                } else {
                    // Show styled error message
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        customClass: {
                            confirmButton: 'btn btn-primary w-xs',
                        },
                        buttonsStyling: false
                    });
                    
                    // Re-enable button
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Create Account';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Show styled error message
                Swal.fire({
                    title: 'Error!',
                    text: 'There was a problem connecting to the server. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    customClass: {
                        confirmButton: 'btn btn-primary w-xs',
                    },
                    buttonsStyling: false
                });
                
                // Re-enable button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Create Account';
            });
        });
    });
    </script> -->
</body>
</html>
