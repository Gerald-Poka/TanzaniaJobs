// Job Portal Sign In Script
document.addEventListener('DOMContentLoaded', function() {
    const signinForm = document.getElementById('signinForm');
    
    signinForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Client-side validation
        if (!signinForm.checkValidity()) {
            e.stopPropagation();
            signinForm.classList.add('was-validated');
            return;
        }
        
        // Disable button to prevent multiple submissions
        const submitButton = document.getElementById('signin-button');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Signing in...';
        
        // Get form data
        const formData = new FormData(signinForm);
        
        // Send AJAX request
        fetch(window.location.pathname, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server returned ' + response.status + ' ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Show success message centered
                Swal.fire({
                    title: 'Success!',
                    text: `Welcome back, ${data.user_name || 'User'}!`,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    position: 'center',
                    backdrop: true,
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        title: 'swal2-title-custom',
                        content: 'swal2-content-custom'
                    },
                    didOpen: () => {
                        // Ensure the modal is properly centered
                        const popup = Swal.getPopup();
                        popup.style.position = 'fixed';
                        popup.style.top = '50%';
                        popup.style.left = '50%';
                        popup.style.transform = 'translate(-50%, -50%)';
                        popup.style.zIndex = '9999';
                    }
                }).then(function() {
                    // Redirect to appropriate dashboard
                    window.location.href = data.redirectUrl || data.redirect;
                });
            } else {
                // Handle different error types based on the type returned from controller
                handleLoginError(data);
                
                // Re-enable button
                submitButton.disabled = false;
                submitButton.innerHTML = 'Sign In';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Show error message centered
            Swal.fire({
                title: 'Error!',
                text: 'There was a problem connecting to the server. Please try again.',
                icon: 'error',
                confirmButtonText: 'Try Again',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-primary w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
            
            // Re-enable button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Sign In';
        });
    });
});

// New function to handle different login error types
function handleLoginError(data) {
    switch(data.type) {
        case 'account_banned':
            Swal.fire({
                title: 'Account Banned',
                html: `
                    <div class="text-start">
                        <div class="alert alert-danger alert-border-left mb-3" role="alert">
                            <i class="ri-forbid-line me-2 align-middle fs-16"></i>
                            <strong>Account Banned:</strong> Your access has been restricted.
                        </div>
                        <p class="mb-3">Hello <strong>${data.user_name || 'User'}</strong>,</p>
                        <p class="mb-3">Your account has been banned and you cannot access the platform at this time.</p>
                        <div class="alert alert-warning alert-additional" role="alert">
                            <div class="alert-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-customer-service-2-line fs-16 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1">What you can do:</h6>
                                        <ul class="mb-0 small">
                                            <li>Contact our support team for assistance</li>
                                            <li>Review our terms of service</li>
                                            <li>Appeal the ban if you believe it's an error</li>
                                            <li>Check your email for any communication from us</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-light border mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-mail-line me-2 text-primary"></i>
                                <div>
                                    <strong>Support Email:</strong> support@tanzaniajobs.com
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'error',
                confirmButtonText: 'Contact Support',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-danger w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                width: '520px',
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
            break;
            
        case 'account_inactive':
            Swal.fire({
                title: 'Account Not Active',
                html: `
                    <div class="text-start">
                        <div class="alert alert-warning alert-border-left mb-3" role="alert">
                            <i class="ri-alert-line me-2 align-middle fs-16"></i>
                            <strong>Account Inactive:</strong> Your account needs activation.
                        </div>
                        <p class="mb-3">Hello <strong>${data.user_name || 'User'}</strong>,</p>
                        <p class="mb-3">Your account is currently inactive and needs to be activated before you can sign in.</p>
                        <div class="alert alert-info alert-additional" role="alert">
                            <div class="alert-body">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="ri-information-line fs-16 align-middle"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="alert-heading mb-1">Possible reasons:</h6>
                                        <ul class="mb-0 small">
                                            <li>Account is pending approval</li>
                                            <li>Email verification required</li>
                                            <li>Administrative review in progress</li>
                                            <li>Account temporarily suspended</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-light border mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-mail-line me-2 text-primary"></i>
                                <div>
                                    <strong>Support Email:</strong> support@tanzaniajobs.com
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'warning',
                confirmButtonText: 'Contact Support',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-warning w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                width: '520px',
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
            break;
            
        case 'invalid_credentials':
            Swal.fire({
                title: 'Login Failed',
                html: `
                    <div class="text-start">
                        <div class="alert alert-danger alert-border-left mb-3" role="alert">
                            <i class="ri-close-circle-line me-2 align-middle fs-16"></i>
                            <strong>Invalid Credentials:</strong> Please check your login details.
                        </div>
                        <p class="mb-3">The email or password you entered is incorrect.</p>
                        <div class="alert alert-light border mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="ri-key-line me-2 text-primary"></i>
                                <div>
                                    <a href="/auth-pass-reset-cover" class="text-decoration-none">
                                        <strong>Forgot your password?</strong> Click here to reset it.
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'error',
                confirmButtonText: 'Try Again',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-primary w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
            break;
            
        case 'validation_error':
            Swal.fire({
                title: 'Validation Error',
                text: data.message,
                icon: 'warning',
                confirmButtonText: 'OK',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-warning w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
            break;
            
        default:
            // Fallback to your original error handling
            Swal.fire({
                title: 'Error!',
                text: data.message || 'Invalid email or password.',
                icon: 'error',
                confirmButtonText: 'Try Again',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-primary w-xs',
                    title: 'swal2-title-custom',
                    content: 'swal2-content-custom'
                },
                buttonsStyling: false,
                didOpen: () => {
                    // Ensure the modal is properly centered
                    const popup = Swal.getPopup();
                    popup.style.position = 'fixed';
                    popup.style.top = '50%';
                    popup.style.left = '50%';
                    popup.style.transform = 'translate(-50%, -50%)';
                    popup.style.zIndex = '9999';
                }
            });
    }
}