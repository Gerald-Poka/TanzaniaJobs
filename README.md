# Tanzania Jobs Portal

## Overview

Tanzania Jobs Portal is a comprehensive web application built with Yii 2 Framework that connects job seekers with employers across Tanzania. The platform provides an intuitive interface for posting, searching, and applying for jobs while offering employers tools to manage their recruitment process efficiently.

## Features

### For Job Seekers
- User registration and profile management
- Resume builder and upload functionality
- Advanced job search with filters (location, industry, job type)
- Job application tracking
- Email notifications for job matches and application updates
- Save favorite jobs for later viewing

### For Employers
- Company profile creation and management
- Job posting with detailed descriptions
- Applicant tracking system
- Candidate filtering and shortlisting
- Interview scheduling tools
- Analytics dashboard for recruitment metrics

### General Features
- Responsive design for mobile and desktop access
- Real-time notifications
- Secure authentication system
- Admin dashboard for platform management
- Industry and location-based categorization

## Technology Stack

- **Framework**: Yii 2 Basic
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap
- **Charts/Visualization**: Chart.js
- **Form Elements**: Choices.js
- **Sliders**: Swiper
- **Database**: MySQL
- **Authentication**: Yii2 built-in authentication

## Directory Structure

```
tanzania-jobs/
      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
          assets/         contains published asset files
          css/            contains CSS files
          js/             contains JavaScript files
          libs/           contains third-party libraries
          images/         contains image files
```

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Web server (Apache/Nginx)
- Modern web browser

## Installation

### Option 1: Install via Composer

1. Install Composer if not already installed:
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

2. Create a new project:
```bash
composer create-project --prefer-dist tanzania-jobs/portal tanzania-jobs
```

3. Navigate to the project directory:
```bash
cd tanzania-jobs
```

4. Update dependencies:
```bash
composer update
```

### Option 2: Manual Installation

1. Clone the repository:
```bash
git clone https://github.com/your-username/tanzania-jobs.git
```

2. Navigate to the project directory:
```bash
cd tanzania-jobs
```

3. Install dependencies:
```bash
composer install
```

### Database Configuration

1. Create a new MySQL database for the application.

2. Configure database connection in `config/db.php`:
```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=tanzania_jobs',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8mb4',
];
```

3. Run migrations to create database tables:
```bash
php yii migrate
```

### Web Server Configuration

#### Apache

Ensure mod_rewrite is enabled and add the following to your Apache configuration or .htaccess file:

```
<IfModule mod_rewrite.c>
    RewriteEngine on
    
    # If a directory or a file exists, use it directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    
    # Otherwise forward it to index.php
    RewriteRule . index.php
</IfModule>
```

#### Nginx

```
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/tanzania-jobs/web;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        try_files $uri =404;
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```

## Usage

### Admin Setup

1. Access the admin setup page at `http://your-domain.com/admin/setup`
2. Create the admin account with required credentials
3. Configure initial system settings

### Job Posting (Employers)

1. Register as an employer
2. Create a company profile
3. Post jobs with detailed descriptions
4. Review applications and manage candidates

### Job Searching (Job Seekers)

1. Register as a job seeker
2. Complete your profile and upload resume
3. Search for jobs using filters
4. Apply for positions and track applications

## Development

### Adding New Features

1. Create necessary models in `models/` directory
2. Implement controllers in `controllers/` directory
3. Create view files in `views/` directory
4. Add routes in `config/web.php` if needed

### Running Tests

```bash
vendor/bin/codecept run
```

## Troubleshooting

### Common Issues

1. **Database Connection Errors**
   - Verify database credentials in `config/db.php`
   - Ensure MySQL service is running

2. **Permission Issues**
   - Make sure `runtime/` and `web/assets/` directories are writable by the web server

3. **404 Errors**
   - Check web server rewrite rules
   - Verify URL manager configuration in `config/web.php`

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

For support or inquiries, please contact:
- Email: geraldndyamukama39@gmail.com
- Website: https://www.tanzaniajobs.com/contact

---

© 2025 Tanzania Jobs Portal. All rights reserved.