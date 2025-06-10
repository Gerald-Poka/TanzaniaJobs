-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 11:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_qualifications`
--

CREATE TABLE `academic_qualifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `institution_name` varchar(255) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `field_of_study` varchar(255) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  `grade` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_qualifications`
--

INSERT INTO `academic_qualifications` (`id`, `user_id`, `institution_name`, `degree`, `field_of_study`, `start_year`, `end_year`, `grade`, `created_at`) VALUES
(2, 2, 'University of Dar es salaam', 'Bachelor of science in information system', 'Computer Programming ', 2020, 3, '3.3', '2025-06-02 11:57:40');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `size_range` varchar(50) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `founded_year` int(11) DEFAULT NULL,
  `status` enum('active','inactive','pending','suspended') DEFAULT 'pending',
  `verified` tinyint(1) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `slug`, `description`, `logo`, `website`, `email`, `phone`, `address`, `city`, `country`, `size_range`, `industry`, `founded_year`, `status`, `verified`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'TechCorp Ltd', 'techcorp-ltd', 'Leading technology company specializing in software development and innovation.', '', 'https://example.co.tz', 'tech@example.com', '0673128464', 'Dar es salaam\r\nDar es salaam', 'Dar es salaam', 'TZ', '501-1000', 'Technology', 2015, 'active', 1, 0, '2025-06-06 05:13:02', '2025-06-06 07:33:23'),
(2, 'StartupVenture Inc', 'startupventure-inc', 'Innovative startup company focused on disruptive technologies.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 1, 0, '2025-06-06 05:13:02', '2025-06-06 05:13:02'),
(3, 'Global Solutions', 'global-solutions', 'International consulting firm providing business solutions worldwide.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pending', 0, 0, '2025-06-06 05:13:02', '2025-06-06 05:13:02'),
(4, 'Digital Agency Pro', 'digital-agency-pro', 'Full-service digital marketing and web development agency.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 1, 0, '2025-06-06 05:13:02', '2025-06-06 05:13:02'),
(5, 'Enterprise Corp', 'enterprise-corp', 'Large enterprise corporation with multiple business units.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 1, 0, '2025-06-06 05:13:02', '2025-06-06 05:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `cv_documents`
--

CREATE TABLE `cv_documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` longtext NOT NULL COMMENT 'JSON data of CV content',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cv_documents`
--

INSERT INTO `cv_documents` (`id`, `user_id`, `name`, `data`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 2, 'My CV - 2025-06-03 13:56:32', '{\"includePersonalInfo\":true,\"includeSummary\":true,\"includeExperience\":true,\"selectedExperiences\":[\"1\"],\"includeEducation\":true,\"selectedEducation\":[\"2\"],\"includeCertifications\":true,\"selectedCertifications\":[\"1\"],\"includeTraining\":true,\"selectedTraining\":[\"1\"],\"includeSkills\":true,\"includeLanguages\":true,\"includeReferees\":true,\"selectedReferees\":[\"1\"],\"cvPreviewContent\":\"\\n                <div class=\\\"cv-preview-content\\\">\\n                    <!-- Header -->\\n                    <div class=\\\"text-center mb-4\\\">\\n                        <h1>Gerald Ndyamukama<\\/h1>\\n                        <div class=\\\"contact-info\\\">\\n                            <span><i class=\\\"ri-mail-line me-1\\\"><\\/i>geraldndyamukama39@gmail.com<\\/span>\\n                                                                                        <br><span><i class=\\\"ri-map-pin-line me-1\\\"><\\/i>Dar es salaam, Tanzania<\\/span>\\n                                                    <\\/div>\\n                    <\\/div>\\n            \\n                    <div class=\\\"mb-4\\\">\\n                        <h2>Professional Summary<\\/h2>\\n                        <p>Test<\\/p>\\n                    <\\/div>\\n                <h2>Work Experience<\\/h2>\\n                                <div class=\\\"section-item\\\">\\n                                    <h3>Noc Engineer <\\/h3>\\n                                    <div class=\\\"company-period\\\">\\n                                        Yas Mix, Dar es salaam, Tanzania                                        \\u2022 May 2025 - Present                                    <\\/div>\\n                                                                            <div class=\\\"description\\\">web Portal<\\/div>\\n                                                                    <\\/div>\\n                            <h2>Education<\\/h2>\\n                                <div class=\\\"section-item\\\">\\n                                    <h3>Bachelor of science in information system in Computer Programming <\\/h3>\\n                                    <div class=\\\"company-period\\\">\\n                                        University of Dar es salaam                                        \\u2022 2020 - 3                                                                                    \\u2022 Grade: 3.3                                                                            <\\/div>\\n                                <\\/div>\\n                            <h2>Professional Certifications<\\/h2>\\n                                    <div class=\\\"section-item\\\">\\n                                        <h3>Junior Coder in Tanzania <\\/h3>\\n                                        <div class=\\\"company-period\\\">\\n                                            Project Management  Institute                                            \\u2022 April 2024                                        <\\/div>\\n                                                                                    <div class=\\\"description\\\">Testing<\\/div>\\n                                                                            <\\/div>\\n                                <h2>Training &amp; Workshops<\\/h2>\\n                                    <div class=\\\"section-item\\\">\\n                                        <h3>Software developer<\\/h3>\\n                                        <div class=\\\"company-period\\\">\\n                                            UCC                                             \\u2022 Sep 2019 - May 2021                                        <\\/div>\\n                                                                                    <div class=\\\"description\\\">test<\\/div>\\n                                                                            <\\/div>\\n                                \\n                            <h2>Skills<\\/h2>\\n                            <div class=\\\"mb-3\\\">\\n                                <span class=\\\"skill-tag\\\">Test<\\/span>\\n                            <\\/div>\\n                        \\n                            <h2>Languages<\\/h2>\\n                            <div class=\\\"mb-3\\\">\\n                                <span class=\\\"language-tag\\\">Test<\\/span>\\n                            <\\/div>\\n                        <h2>References<\\/h2>\\n                                    <div class=\\\"section-item\\\">\\n                                        <h3>Mr. Obeid Msuya<\\/h3>\\n                                        <div class=\\\"company-period\\\">\\n                                            Senior Developer at University of Dar es Salaam Computer Center                                        <\\/div>\\n                                        <div class=\\\"description\\\">\\n                                            <i class=\\\"ri-mail-line me-1\\\"><\\/i>geraldndyamukama39@gmail.com                                                                                        <br><i class=\\\"ri-phone-line me-1\\\"><\\/i>+255673128464                                                                                    <\\/div>\\n                                    <\\/div>\\n                                <\\/div>\"}', '2025-06-03 14:56:32', '2025-06-03 14:56:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cv_profiles`
--

CREATE TABLE `cv_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `years_of_experience` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `languages` text DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cv_profiles`
--

INSERT INTO `cv_profiles` (`id`, `user_id`, `location`, `date_of_birth`, `gender`, `nationality`, `job_title`, `years_of_experience`, `profile_picture`, `summary`, `skills`, `languages`, `linkedin_url`, `github_url`, `website_url`, `twitter_url`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dar es salaam, Tanzania', '2001-05-18', 'Male', 'Tanzania', 'Software Developer', 'Less than 1 year', '/uploads/profile-pictures/profile_2_1748930272.jpeg', 'Test', 'Programming, Designing, PhP,Laravel,Python', 'Test', '', 'https://github.com/dashboard', '', '', '2025-06-03 05:29:56', '2025-06-10 06:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `job_type` enum('full-time','part-time','contract','freelance','internship','temporary') DEFAULT 'full-time',
  `location_type` enum('onsite','remote','hybrid') DEFAULT 'onsite',
  `location` varchar(255) DEFAULT NULL,
  `salary_min` decimal(12,2) DEFAULT NULL,
  `salary_max` decimal(12,2) DEFAULT NULL,
  `salary_currency` varchar(3) DEFAULT 'USD',
  `salary_period` enum('hourly','daily','weekly','monthly','yearly') DEFAULT 'monthly',
  `experience_level` enum('entry','junior','mid','senior','lead','executive') DEFAULT 'mid',
  `education_level` enum('high-school','diploma','bachelor','master','phd','other') DEFAULT 'bachelor',
  `status` enum('draft','pending','published','expired','rejected','reported') DEFAULT 'pending',
  `featured` tinyint(1) DEFAULT 0,
  `urgent` tinyint(1) DEFAULT 0,
  `views_count` int(11) DEFAULT 0,
  `applications_count` int(11) DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `slug`, `description`, `short_description`, `requirements`, `benefits`, `company_id`, `category_id`, `posted_by`, `job_type`, `location_type`, `location`, `salary_min`, `salary_max`, `salary_currency`, `salary_period`, `experience_level`, `education_level`, `status`, `featured`, `urgent`, `views_count`, `applications_count`, `expires_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 'Senior PHP Developer', 'senior-php-developer-1749190382', 'We are looking for a Senior PHP Developer to join our growing team. You will be responsible for developing and maintaining web applications using PHP, MySQL, and modern frameworks like Yii2 or Laravel. The ideal candidate should have strong problem-solving skills and experience with object-oriented programming.', 'Senior PHP Developer position with competitive salary and benefits', NULL, NULL, 1, 1, NULL, 'full-time', 'hybrid', 'Morogoro', 80000.00, 120000.00, 'USD', 'monthly', 'senior', 'bachelor', 'expired', 1, 0, 156, 23, '2025-07-06 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:50:45'),
(2, 'Frontend React Developer', 'frontend-react-developer-1749190382', 'Join our frontend team as a React Developer. You will work on building modern, responsive web applications using React, Redux, and other cutting-edge technologies. Experience with TypeScript and testing frameworks is a plus.', 'React Developer for modern web applications', NULL, NULL, 2, 1, NULL, 'full-time', 'remote', 'Iringa', 60000.00, 90000.00, 'USD', 'monthly', 'mid', 'bachelor', 'published', 0, 0, 91, 12, '2025-07-21 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:50:55'),
(3, 'DevOps Engineer', 'devops-engineer-1749190382', 'We need a DevOps Engineer to manage our cloud infrastructure and CI/CD pipelines. Experience with AWS, Docker, Kubernetes, and Jenkins is required. You will work closely with development teams to ensure smooth deployments and system reliability.', 'DevOps Engineer for cloud infrastructure management', NULL, NULL, 1, 1, NULL, 'full-time', 'onsite', 'Mwanza', 90000.00, 140000.00, 'USD', 'monthly', 'senior', 'bachelor', 'expired', 0, 0, 234, 45, '2025-06-05 08:13:02', NULL, '2025-05-22 05:13:02', '2025-06-09 18:51:01'),
(4, 'UI/UX Designer', 'ui-ux-designer-1749190382', 'Creative UI/UX Designer needed to design intuitive and beautiful user interfaces. You will work on web and mobile applications, creating wireframes, prototypes, and final designs. Proficiency in Figma, Adobe Creative Suite, and user research methodologies is essential.', 'UI/UX Designer for web and mobile applications', NULL, NULL, 4, 1, NULL, 'part-time', 'hybrid', 'Dar es salaam', 45000.00, 70000.00, 'USD', 'monthly', 'mid', 'bachelor', 'published', 1, 0, 82, 18, '2025-07-01 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:51:09'),
(5, 'Data Scientist', 'data-scientist-1749190382', 'Data Scientist position available for analyzing large datasets and building machine learning models. You will work with Python, R, SQL, and various ML frameworks. Experience with data visualization tools and statistical analysis is required.', 'Data Scientist for machine learning and analytics', NULL, NULL, 5, 1, NULL, 'full-time', 'remote', 'Musoma, Tabora', 95000.00, 130000.00, 'USD', 'monthly', 'senior', 'bachelor', 'published', 1, 0, 206, 32, '2025-06-26 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:51:19'),
(6, 'Junior Web Developer', 'junior-web-developer-1749190382', 'Entry-level position for a Junior Web Developer. Perfect opportunity for recent graduates or career changers. You will learn and work with HTML, CSS, JavaScript, and PHP. Mentorship and training will be provided.', 'Entry-level web developer position with training', NULL, NULL, 2, 1, NULL, 'full-time', 'onsite', 'Arusha', 45000.00, 60000.00, 'USD', 'monthly', 'entry', 'bachelor', 'published', 0, 0, 93, 28, '2025-07-11 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:51:25'),
(7, 'Project Manager', 'project-manager-1749190382', 'Experienced Project Manager needed to lead software development projects. You will coordinate with cross-functional teams, manage timelines, and ensure project deliverables meet quality standards. PMP certification preferred.', 'Project Manager for software development projects', NULL, NULL, 3, 1, NULL, 'full-time', 'hybrid', 'Mtwara', 70000.00, 95000.00, 'USD', 'monthly', 'senior', 'bachelor', 'reported', 0, 0, 45, 8, '2025-07-16 08:13:02', NULL, '2025-06-06 05:13:02', '2025-06-09 18:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_file` varchar(255) DEFAULT NULL,
  `expected_salary` decimal(12,2) DEFAULT NULL,
  `availability_date` date DEFAULT NULL,
  `status` enum('pending','reviewed','shortlisted','interviewed','offered','hired','rejected') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cv_document_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `applicant_id`, `cover_letter`, `resume_file`, `expected_salary`, `availability_date`, `status`, `notes`, `applied_at`, `updated_at`, `cv_document_id`) VALUES
(1, 5, 2, 'Gerald Dionidas Ndyamukama  \r\nPlot No. 25, 26 Ali Hassan Mwinyi Rd  \r\nDar es Salaam, Tanzania  \r\nPhone: 0673128464  \r\nEmail: geraldndyamukama39@gmail.com  \r\n\r\n[Date]\r\n\r\nThe Human Resources Manager  \r\n[Company Name]  \r\nAli Hassan Mwinyi/Kaunda Drive Junction  \r\nP.O. Box 804  \r\nDar es Salaam, Tanzania  \r\n\r\nDear Sir/Madam,\r\n\r\nRE: APPLICATION FOR THE POSITION OF JUNIOR SOFTWARE DEVELOPER\r\n\r\nI am writing to express my interest in the Junior Software Developer position at your organization. I hold a Bachelor’s Degree in Information Systems from the University of Dodoma and have gained strong experience in web and system development using PHP, Yii2, and Laravel frameworks.\r\n\r\nDuring my internship at the University of Dar es Salaam Computing Centre (UCC), I contributed to projects such as the UCC website, an internal helpdesk system, and ARIS integrations. I am confident that my knowledge in both frontend (Bootstrap, Tailwind) and backend technologies (PHP, MySQL) will allow me to add value to your team.\r\n\r\nI am a quick learner, passionate about solving real-world problems using code, and eager to take on new challenges.\r\n\r\nPlease find my attached resume for further details. I am available for an interview at your convenience and look forward to the opportunity to contribute to your team.\r\n\r\nYours sincerely,  \r\nGerald Dionidas Ndyamukama\r\n', 'CV_1', 90000.00, '0000-00-00', 'shortlisted', 'I love my Coding ability', '2025-06-06 14:08:08', '2025-06-09 06:27:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `name`, `slug`, `description`, `icon`, `parent_id`, `status`, `sort_order`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 'information-technology', 'Technology and software development jobs including programming, web development, database administration, and IT support.', 'ri-computer-line', NULL, 'active', 1, 'IT Jobs - Information Technology Careers', 'Find the latest Information Technology jobs including software development, programming, and IT support positions.', '2025-06-05 11:40:19', '2025-06-06 05:33:57'),
(2, 'Healthcare', 'healthcare', 'Medical and healthcare professional jobs including doctors, nurses, medical technicians, and healthcare administration.', 'ri-heart-pulse-line', NULL, 'active', 2, 'Healthcare Jobs - Medical Careers', 'Explore healthcare career opportunities including nursing, medical, and healthcare administration positions.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(3, 'Finance & Banking', 'finance-banking', 'Financial services and banking jobs including accounting, financial analysis, investment banking, and insurance.', 'ri-bank-line', NULL, 'active', 3, 'Finance Jobs - Banking & Financial Services', 'Discover finance and banking career opportunities in accounting, investment, and financial services.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(4, 'Education', 'education', 'Teaching and educational jobs including teachers, professors, educational administrators, and training specialists.', 'ri-book-open-line', NULL, 'active', 4, 'Education Jobs - Teaching Careers', 'Find teaching and education career opportunities in schools, universities, and training organizations.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(5, 'Engineering', 'engineering', 'Engineering and technical jobs including civil, mechanical, electrical, software, and other engineering disciplines.', 'ri-settings-3-line', NULL, 'active', 5, 'Engineering Jobs - Technical Careers', 'Explore engineering career opportunities in various technical and engineering disciplines.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(6, 'Marketing & Sales', 'marketing-sales', 'Marketing, sales and business development jobs including digital marketing, sales representatives, and marketing managers.', 'ri-megaphone-line', NULL, 'active', 6, 'Marketing & Sales Jobs - Business Development', 'Find marketing and sales career opportunities in digital marketing, business development, and sales.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(7, 'Human Resources', 'human-resources', 'HR and recruitment jobs including HR managers, recruiters, training specialists, and employee relations.', 'ri-team-line', NULL, 'active', 7, 'HR Jobs - Human Resources Careers', 'Discover human resources career opportunities in recruitment, training, and employee relations.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(8, 'Construction', 'construction', 'Construction and building jobs including construction workers, project managers, architects, and skilled trades.', 'ri-building-3-line', NULL, 'active', 8, 'Construction Jobs - Building & Trades', 'Find construction and building career opportunities in skilled trades and project management.', '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(9, 'Vibe Coder', 'vibe-coder', 'People Who will be able to code and make user of the AI', 'ri-folder-line', 1, 'active', 9, '', '', '2025-06-05 12:34:46', '2025-06-05 12:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `job_skills`
--

CREATE TABLE `job_skills` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `required` tinyint(1) DEFAULT 1,
  `proficiency_level` enum('basic','intermediate','advanced','expert') DEFAULT 'intermediate',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1748520991),
('m241205_000001_create_job_categories_table', 1749123617),
('m241205_000002_create_skills_table', 1749123619),
('m241205_000003_seed_job_categories_data', 1749123619),
('m241205_000004_seed_skills_data', 1749123620),
('m241206_000000_create_job_portal_tables', 1749190382),
('m250529_115915_create_user_table', 1748520996),
('m250529_135946_update_user_table', 1748527223),
('m250602_063221_create_academic_qualification_table', 1748846747),
('m250602_063236_create_professional_qualification_table', 1748846877),
('m250602_063240_create_work_experience_table', 1748846878),
('m250602_063242_create_training_workshop_table', 1748846879),
('m250602_063406_create_referee_table', 1748846880),
('m250602_063816_create_cv_profile_table', 1748846881);

-- --------------------------------------------------------

--
-- Table structure for table `professional_qualifications`
--

CREATE TABLE `professional_qualifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `certificate_name` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `issued_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professional_qualifications`
--

INSERT INTO `professional_qualifications` (`id`, `user_id`, `certificate_name`, `organization`, `issued_date`, `description`, `created_at`) VALUES
(1, 2, 'Junior Coder in Tanzania ', 'Project Management  Institute', '2024-04-01', 'Testing', '2025-06-02 13:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `referees`
--

CREATE TABLE `referees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `referees`
--

INSERT INTO `referees` (`id`, `user_id`, `name`, `position`, `company`, `email`, `phone`, `created_at`) VALUES
(1, 2, 'Mr. Obeid Msuya', 'Senior Developer', 'University of Dar es Salaam Computer Center', 'geraldndyamukama39@gmail.com', '+255673128464', '2025-06-02 13:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`id`, `user_id`, `job_id`, `created_at`, `updated_at`) VALUES
(2, 2, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `slug`, `category_id`, `description`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'php', 1, 'PHP programming language for web development', 'active', 1, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(2, 'JavaScript', 'javascript', 1, 'JavaScript programming for web applications', 'active', 2, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(3, 'React', 'react', 1, 'React.js framework for building user interfaces', 'active', 3, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(4, 'Node.js', 'nodejs', 1, 'Node.js runtime for server-side JavaScript', 'active', 4, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(5, 'Python', 'python', 1, 'Python programming language', 'active', 5, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(6, 'MySQL', 'mysql', 1, 'MySQL database management', 'active', 6, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(7, 'Docker', 'docker', 1, 'Docker containerization technology', 'active', 7, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(8, 'AWS', 'aws', 1, 'Amazon Web Services cloud platform', 'active', 8, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(9, 'Nursing', 'nursing', 2, 'Professional nursing skills and patient care', 'active', 9, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(10, 'Surgery', 'surgery', 2, 'Surgical procedures and techniques', 'active', 10, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(11, 'Emergency Medicine', 'emergency-medicine', 2, 'Emergency medical care and trauma response', 'active', 11, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(12, 'Radiology', 'radiology', 2, 'Medical imaging and diagnostic radiology', 'active', 12, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(13, 'Accounting', 'accounting', 3, 'Financial accounting and bookkeeping', 'active', 13, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(14, 'Financial Analysis', 'financial-analysis', 3, 'Financial analysis and reporting', 'active', 14, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(15, 'Investment Banking', 'investment-banking', 3, 'Investment banking and securities', 'active', 15, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(16, 'Risk Management', 'risk-management', 3, 'Financial risk assessment and management', 'active', 16, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(17, 'Teaching', 'teaching', 4, 'Teaching and instruction skills', 'active', 17, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(18, 'Curriculum Development', 'curriculum-development', 4, 'Educational curriculum design and development', 'active', 18, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(19, 'Educational Technology', 'educational-technology', 4, 'Technology integration in education', 'active', 19, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(20, 'Civil Engineering', 'civil-engineering', 5, 'Civil engineering and infrastructure', 'active', 20, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(21, 'Mechanical Engineering', 'mechanical-engineering', 5, 'Mechanical systems and design', 'active', 21, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(22, 'Electrical Engineering', 'electrical-engineering', 5, 'Electrical systems and electronics', 'active', 22, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(23, 'Digital Marketing', 'digital-marketing', 6, 'Online marketing and digital campaigns', 'active', 23, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(24, 'SEO', 'seo', 6, 'Search engine optimization', 'active', 24, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(25, 'Social Media Marketing', 'social-media-marketing', 6, 'Social media marketing and management', 'active', 25, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(26, 'Recruitment', 'recruitment', 7, 'Talent acquisition and recruitment', 'active', 26, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(27, 'Employee Relations', 'employee-relations', 7, 'Employee relations and conflict resolution', 'active', 27, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(28, 'Training & Development', 'training-development', 7, 'Employee training and development programs', 'active', 28, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(29, 'Project Management', 'project-management', 8, 'Construction project management', 'active', 29, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(30, 'Carpentry', 'carpentry', 8, 'Carpentry and woodworking skills', 'active', 30, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(31, 'Plumbing', 'plumbing', 8, 'Plumbing installation and repair', 'active', 31, '2025-06-05 11:40:19', '2025-06-05 11:40:19'),
(32, 'AI,UI,UX', 'ai-ui-ux', 9, 'This will help you be the best', 'active', 32, '2025-06-06 04:37:11', '2025-06-06 04:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `training_workshops`
--

CREATE TABLE `training_workshops` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_workshops`
--

INSERT INTO `training_workshops` (`id`, `user_id`, `title`, `institution`, `location`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 2, 'Software developer', 'UCC ', 'Dar es salaam', '2019-09-01', '2021-05-01', 'test', '0000-00-00 00:00:00', '2025-06-05 07:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `role` smallint(6) NOT NULL DEFAULT 1,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password_hash`, `auth_key`, `access_token`, `role`, `status`, `created_at`, `updated_at`, `password_reset_token`) VALUES
(1, 'Admin', 'User', 'admin@tanzaniajobs.co.tz', '$2y$13$rZELUAXGXszFggsmEPPoAOSqpoJcucAIm3vQYzhHJ5hkhgsO65lXW', 'ol54Ix1CUdfUy59D589wSx30rdp1fe4-', NULL, 10, 10, 1748520996, 1748520996, NULL),
(2, 'Gerald', 'Ndyamukama', 'geraldndyamukama39@gmail.com', '$2y$13$rZELUAXGXszFggsmEPPoAOSqpoJcucAIm3vQYzhHJ5hkhgsO65lXW', 'WtsnjGYLmTHYp1MGQupOwY_4hFF7juXc', NULL, 1, 10, 1748524620, 1749122139, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_experiences`
--

CREATE TABLE `work_experiences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `employment_type` varchar(50) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `skills_used` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_experiences`
--

INSERT INTO `work_experiences` (`id`, `user_id`, `job_title`, `company_name`, `location`, `employment_type`, `start_date`, `end_date`, `description`, `salary_range`, `skills_used`, `created_at`, `updated_at`) VALUES
(1, 2, 'Noc Engineer ', 'Yas Mix', 'Dar es salaam, Tanzania', 'Part-time', '2025-05-01', NULL, 'web Portal', '', 'Php', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-academic_qualifications-user_id` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_companies_status` (`status`),
  ADD KEY `idx_companies_verified` (`verified`),
  ADD KEY `idx_companies_featured` (`featured`);

--
-- Indexes for table `cv_documents`
--
ALTER TABLE `cv_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cv_documents_user_id` (`user_id`);

--
-- Indexes for table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-cv_profiles-user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_jobs_status` (`status`),
  ADD KEY `idx_jobs_company_id` (`company_id`),
  ADD KEY `idx_jobs_category_id` (`category_id`),
  ADD KEY `idx_jobs_job_type` (`job_type`),
  ADD KEY `idx_jobs_location_type` (`location_type`),
  ADD KEY `idx_jobs_featured` (`featured`),
  ADD KEY `idx_jobs_expires_at` (`expires_at`),
  ADD KEY `idx_jobs_created_at` (`created_at`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_application` (`job_id`,`applicant_id`),
  ADD KEY `idx_job_applications_job_id` (`job_id`),
  ADD KEY `idx_job_applications_applicant_id` (`applicant_id`),
  ADD KEY `idx_job_applications_status` (`status`),
  ADD KEY `idx_job_applications_applied_at` (`applied_at`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx-job_categories-parent_id` (`parent_id`),
  ADD KEY `idx-job_categories-status` (`status`),
  ADD KEY `idx-job_categories-slug` (`slug`),
  ADD KEY `idx-job_categories-sort_order` (`sort_order`);

--
-- Indexes for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_job_skill` (`job_id`,`skill_id`),
  ADD KEY `idx_job_skills_job_id` (`job_id`),
  ADD KEY `idx_job_skills_skill_id` (`skill_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `professional_qualifications`
--
ALTER TABLE `professional_qualifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-professional_qualifications-user_id` (`user_id`);

--
-- Indexes for table `referees`
--
ALTER TABLE `referees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_referees_user` (`user_id`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_job` (`user_id`,`job_id`),
  ADD KEY `idx_user_job` (`user_id`,`job_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx-skills-category_id` (`category_id`),
  ADD KEY `idx-skills-status` (`status`),
  ADD KEY `idx-skills-slug` (`slug`),
  ADD KEY `idx-skills-sort_order` (`sort_order`);

--
-- Indexes for table `training_workshops`
--
ALTER TABLE `training_workshops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-training_workshops-user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-work_experiences-user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cv_documents`
--
ALTER TABLE `cv_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `job_skills`
--
ALTER TABLE `job_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professional_qualifications`
--
ALTER TABLE `professional_qualifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `referees`
--
ALTER TABLE `referees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `training_workshops`
--
ALTER TABLE `training_workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_experiences`
--
ALTER TABLE `work_experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_qualifications`
--
ALTER TABLE `academic_qualifications`
  ADD CONSTRAINT `fk-academic_qualifications-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cv_documents`
--
ALTER TABLE `cv_documents`
  ADD CONSTRAINT `fk_cv_documents_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cv_profiles`
--
ALTER TABLE `cv_profiles`
  ADD CONSTRAINT `fk-cv_profiles-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_jobs_category_id` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jobs_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `fk_job_applications_job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD CONSTRAINT `fk-job_categories-parent_id` FOREIGN KEY (`parent_id`) REFERENCES `job_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD CONSTRAINT `fk_job_skills_job_id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_job_skills_skill_id` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professional_qualifications`
--
ALTER TABLE `professional_qualifications`
  ADD CONSTRAINT `fk-professional_qualifications-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `referees`
--
ALTER TABLE `referees`
  ADD CONSTRAINT `fk_referees_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk-skills-category_id` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `training_workshops`
--
ALTER TABLE `training_workshops`
  ADD CONSTRAINT `fk-training_workshops-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `work_experiences`
--
ALTER TABLE `work_experiences`
  ADD CONSTRAINT `fk-work_experiences-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
