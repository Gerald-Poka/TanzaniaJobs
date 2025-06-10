<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/admin/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <i class="ri-briefcase-4-fill text-primary fs-4"></i>
            </span>
            <span class="logo-lg">
                <span class="fw-bold text-dark">TanzaniaJobs</span>
                <small class="text-muted ms-2">Admin</small>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/admin/dashboard" class="logo logo-light">
            <span class="logo-sm">
                <i class="ri-briefcase-4-fill text-primary fs-4"></i>
            </span>
            <span class="logo-lg">
                <span class="fw-bold text-white">TanzaniaJobs</span>
                <small class="text-light ms-2">Admin</small>
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
                <li class="menu-title"><span data-key="t-dashboard">Dashboard</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/admin/dashboard">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-main-dashboard">Main Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/admin/analytics">
                        <i class="ri-line-chart-line"></i> <span data-key="t-analytics">Analytics & Reports</span>
                    </a>
                </li>

                <!-- User Management -->
                <li class="menu-title"><i class="ri-user-line"></i> <span data-key="t-user-management">User Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUsers">
                        <i class="ri-group-line"></i> <span data-key="t-users">Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/users/all" class="nav-link" data-key="t-all-users">All Users</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAdmins" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdmins">
                        <i class="ri-admin-line"></i> <span data-key="t-admin-users">Admin Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAdmins">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/admins/list" class="nav-link" data-key="t-admin-list">Admin List</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/admins/create" class="nav-link" data-key="t-create-admin">Create Admin</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/roles/permissions" class="nav-link" data-key="t-roles-permissions">Roles & Permissions</a>
                            </li>
                        </ul>
                    </div>
                </li> -->

                <!-- Job Management -->
                <li class="menu-title"><i class="ri-briefcase-line"></i> <span data-key="t-job-management">Job Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarJobs" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarJobs">
                        <i class="ri-file-text-line"></i> <span data-key="t-job-listings">Job Listings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarJobs">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/jobs/all" class="nav-link" data-key="t-all-jobs">All Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/jobs/active" class="nav-link" data-key="t-active-jobs">Active Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/jobs/pending" class="nav-link" data-key="t-pending-approval">Pending Approval</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/jobs/expired" class="nav-link" data-key="t-expired-jobs">Expired Jobs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/jobs/reported" class="nav-link" data-key="t-reported-jobs">Reported Jobs</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarJobCategories" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarJobCategories">
                        <i class="ri-folders-line"></i> <span data-key="t-job-categories">Job Categories & Skills</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarJobCategories">
                        <ul class="nav nav-sm flex-column">
                            <!-- Categories Section -->
                            <li class="nav-item">
                                <small class="text-muted ps-3 fw-bold">CATEGORIES</small>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/categories/list" class="nav-link" data-key="t-category-list">
                                    <i class="ri-list-check me-1"></i> Category List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/categories/create" class="nav-link" data-key="t-create-category">
                                    <i class="ri-add-line me-1"></i> Create Category
                                </a>
                            </li>
                            
                            <!-- Skills Section -->
                            <li class="nav-item mt-2">
                                <small class="text-muted ps-3 fw-bold">SKILLS</small>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/skills/list" class="nav-link" data-key="t-manage-skills">
                                    <i class="ri-star-line me-1"></i> Skills List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/skills/create" class="nav-link" data-key="t-create-skill">
                                    <i class="ri-add-line me-1"></i> Create Skill
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarApplications" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApplications">
                        <i class="ri-file-copy-line"></i> <span data-key="t-applications">Applications</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarApplications">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/applications/all" class="nav-link" data-key="t-all-applications">
                                    <i class="ri-file-list-3-line me-1"></i> All Applications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/pending" class="nav-link" data-key="t-pending-applications">
                                    <i class="ri-time-line me-1"></i> Pending Review
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/approved" class="nav-link" data-key="t-approved-applications">
                                    <i class="ri-check-line me-1"></i> Approved
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/rejected" class="nav-link" data-key="t-rejected-applications">
                                    <i class="ri-close-line me-1"></i> Rejected
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/shortlisted" class="nav-link" data-key="t-shortlisted-applications">
                                    <i class="ri-star-line me-1"></i> Shortlisted
                                </a>
                            </li>
                            <li class="nav-item">
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/analytics" class="nav-link" data-key="t-application-analytics">
                                    <i class="ri-bar-chart-line me-1"></i> Application Analytics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/applications/trends" class="nav-link" data-key="t-hiring-trends">
                                    <i class="ri-line-chart-line me-1"></i> Hiring Trends
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Company Management -->
                <li class="menu-title"><i class="ri-building-line"></i> <span data-key="t-company-management">Company Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCompanies" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCompanies">
                        <i class="ri-building-2-line"></i> <span data-key="t-companies">Companies</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCompanies">
                        <ul class="nav nav-sm flex-column">
                            <!-- ADD CREATE COMPANY OPTION -->
                            <li class="nav-item">
                                <a href="/admin/companies/create" class="nav-link" data-key="t-create-company">
                                    <i class="ri-add-line me-1"></i> Create Company
                                </a>
                            </li>
                            <li class="nav-item">
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li class="nav-item">
                                <a href="/admin/companies/all" class="nav-link" data-key="t-all-companies">All Companies</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/companies/verified" class="nav-link" data-key="t-verified-companies">Verified Companies</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/companies/pending" class="nav-link" data-key="t-pending-verification">Pending Verification</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/companies/featured" class="nav-link" data-key="t-featured-companies">Featured Companies</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- AI & ML Management -->
                <li class="menu-title"><i class="ri-robot-line"></i> <span data-key="t-ai-management">AI & ML Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAI">
                        <i class="ri-brain-line"></i> <span data-key="t-ai-features">AI Features</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAI">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/ai/job-matching" class="nav-link" data-key="t-job-matching-config">Job Matching Config</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/ai/skills-assessment" class="nav-link" data-key="t-skills-assessment">Skills Assessment</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/ai/training-data" class="nav-link" data-key="t-training-data">Training Data</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/ai/performance" class="nav-link" data-key="t-ai-performance">AI Performance</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Content Management -->
                <li class="menu-title"><i class="ri-file-text-line"></i> <span data-key="t-content-management">Content Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarContent" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarContent">
                        <i class="ri-article-line"></i> <span data-key="t-content">Content</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarContent">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/content/pages" class="nav-link" data-key="t-manage-pages">Manage Pages</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/content/blog" class="nav-link" data-key="t-blog-posts">Blog Posts</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/content/faqs" class="nav-link" data-key="t-faqs">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/content/announcements" class="nav-link" data-key="t-announcements">Announcements</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMedia" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMedia">
                        <i class="ri-image-line"></i> <span data-key="t-media">Media</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMedia">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/media/files" class="nav-link" data-key="t-file-manager">File Manager</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/media/uploads" class="nav-link" data-key="t-uploaded-files">Uploaded Files</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/media/cleanup" class="nav-link" data-key="t-cleanup">Cleanup</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Communication -->
                <li class="menu-title"><i class="ri-message-line"></i> <span data-key="t-communication">Communication</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarCommunication" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCommunication">
                        <i class="ri-mail-line"></i> <span data-key="t-messaging">Messaging</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarCommunication">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/messages/inbox" class="nav-link" data-key="t-inbox">Inbox</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/messages/notifications" class="nav-link" data-key="t-notifications">Notifications</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/messages/email-templates" class="nav-link" data-key="t-email-templates">Email Templates</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/messages/broadcast" class="nav-link" data-key="t-broadcast">Broadcast Messages</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSupport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSupport">
                        <i class="ri-customer-service-line"></i> <span data-key="t-support">Support System</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSupport">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/support/tickets" class="nav-link" data-key="t-support-tickets">Support Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/support/live-chat" class="nav-link" data-key="t-live-chat">Live Chat</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/support/knowledge-base" class="nav-link" data-key="t-knowledge-base">Knowledge Base</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Financial Management -->
                <li class="menu-title"><i class="ri-money-dollar-circle-line"></i> <span data-key="t-financial">Financial Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarFinancial" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarFinancial">
                        <i class="ri-bill-line"></i> <span data-key="t-billing">Billing & Payments</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarFinancial">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/billing/subscriptions" class="nav-link" data-key="t-subscriptions">Subscriptions</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/billing/invoices" class="nav-link" data-key="t-invoices">Invoices</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/billing/pricing" class="nav-link" data-key="t-pricing-plans">Pricing Plans</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/billing/revenue" class="nav-link" data-key="t-revenue-reports">Revenue Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- System Settings -->
                <li class="menu-title"><i class="ri-settings-line"></i> <span data-key="t-system">System Management</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSettings">
                        <i class="ri-settings-2-line"></i> <span data-key="t-settings">Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/settings/general" class="nav-link" data-key="t-general-settings">General Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/settings/email" class="nav-link" data-key="t-email-settings">Email Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/settings/payment" class="nav-link" data-key="t-payment-settings">Payment Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/settings/api" class="nav-link" data-key="t-api-settings">API Settings</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMaintenance" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaintenance">
                        <i class="ri-tools-line"></i> <span data-key="t-maintenance">Maintenance</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMaintenance">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/maintenance/database" class="nav-link" data-key="t-database">Database</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/maintenance/cache" class="nav-link" data-key="t-cache-management">Cache Management</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/maintenance/backups" class="nav-link" data-key="t-backups">Backups</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/maintenance/logs" class="nav-link" data-key="t-system-logs">System Logs</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSecurity" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSecurity">
                        <i class="ri-shield-check-line"></i> <span data-key="t-security">Security</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSecurity">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/admin/security/activity-logs" class="nav-link" data-key="t-activity-logs">Activity Logs</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/security/login-attempts" class="nav-link" data-key="t-login-attempts">Login Attempts</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/security/firewall" class="nav-link" data-key="t-firewall">Firewall Settings</a>
                            </li>
                            <li class="nav-item">
                                <a href="/admin/security/ssl" class="nav-link" data-key="t-ssl-certificates">SSL Certificates</a>
                            </li>
                        </ul>
                    </div>
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