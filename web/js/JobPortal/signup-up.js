document.addEventListener('DOMContentLoaded', function() {
    // Get references to the password fields
    const passwordField = document.getElementById('password-input');
    const confirmPasswordField = document.getElementById('confirm-password-input');
    
    // Add custom validation to confirm password field
    confirmPasswordField.addEventListener('input', function() {
        if (passwordField.value === confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('');
        } else {
            confirmPasswordField.setCustomValidity('Passwords do not match');
        }
    });
    
    // Also check when password field changes
    passwordField.addEventListener('input', function() {
        if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Passwords do not match');
        } else {
            confirmPasswordField.setCustomValidity('');
        }
    });
    
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
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        
        if (password !== confirmPassword) {
            // Custom styled error alert like the one in the example
            Swal.fire({
                title: 'Error!',
                text: 'Passwords do not match!',
                icon: 'error',
                confirmButtonText: 'Try Again',
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
                    confirmButton: 'btn btn-primary w-xs',
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
        
        // Send AJAX request with proper URL
        fetch(window.location.pathname, {  // Use current page URL instead of hardcoded path
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
                // Show styled success message like in the examples
                Swal.fire({
                    title: 'Success!',
                    text: 'Your account has been created successfully!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Login Now',
                    position: 'center',
                    backdrop: true,
                    allowOutsideClick: false,
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
                    position: 'center',
                    backdrop: true,
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'swal2-popup-custom',
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
                position: 'center',
                backdrop: true,
                allowOutsideClick: false,
                customClass: {
                    popup: 'swal2-popup-custom',
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