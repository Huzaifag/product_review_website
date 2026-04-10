-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 19, 2025 at 12:32 AM
-- Server version: 9.3.0
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trust`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_status` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_reset_tokens`
--

CREATE TABLE `admin_password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint UNSIGNED NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `alias`, `position`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'head_code', 'Head Code', NULL, 0, '2025-05-01 16:56:09', '2025-05-01 19:55:23'),
(2, 'home_page_top', 'Home Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2025-05-01 19:56:06'),
(3, 'home_page_center', 'Home Page (Center)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(4, 'home_page_bottom', 'Home Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(5, 'business_page_top', 'Business Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(6, 'business_page_center', 'Business Page (Center)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(7, 'business_page_bottom', 'Business Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(8, 'business_page_sidebar', 'Business Page Sidebar', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(9, 'categories_page_top', 'Categories Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(10, 'categories_page_bottom', 'Categories Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(11, 'search_page_top', 'Search Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(12, 'search_page_bottom', 'Search Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(13, 'blog_page_top', 'Blog Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(14, 'blog_page_bottom', 'Blog Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(15, 'blog_article_page_top', 'Blog Article Page (Top)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56'),
(16, 'blog_article_page_bottom', 'Blog Article Page (Bottom)', NULL, 0, '2024-04-16 21:20:58', '2024-04-16 16:30:56');

-- --------------------------------------------------------

--
-- Table structure for table `blog_articles`
--

CREATE TABLE `blog_articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `blog_article_id` bigint UNSIGNED NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `address_line_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_trending` tinyint(1) NOT NULL DEFAULT '0',
  `is_best_rating` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `total_reviews` bigint UNSIGNED NOT NULL DEFAULT '0',
  `avg_ratings` decimal(2,1) NOT NULL DEFAULT '0.0',
  `total_views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `current_month_views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `business_owner_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0:Suspended 1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_business_owner`
--

CREATE TABLE `business_business_owner` (
  `id` bigint UNSIGNED NOT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `business_owner_id` bigint UNSIGNED NOT NULL,
  `role` enum('admin','employee') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_employees`
--

CREATE TABLE `business_employees` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','employee') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Pending 2:Active',
  `business_id` bigint UNSIGNED NOT NULL,
  `business_owner_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_notifications`
--

CREATE TABLE `business_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_owners`
--

CREATE TABLE `business_owners` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `microsoft_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vkontakte_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `two_factor_status` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_status` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_owner_login_logs`
--

CREATE TABLE `business_owner_login_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `business_owner_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_owner_password_reset_tokens`
--

CREATE TABLE `business_owner_password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_reviews`
--

CREATE TABLE `business_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience_date` datetime NOT NULL,
  `stars` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `likes` bigint UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Pending 2:Published',
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_review_replies`
--

CREATE TABLE `business_review_replies` (
  `id` bigint UNSIGNED NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_review_id` bigint UNSIGNED NOT NULL,
  `business_owner_id` bigint UNSIGNED NOT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_review_reports`
--

CREATE TABLE `business_review_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `reason` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_review_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_sub_sub_category`
--

CREATE TABLE `business_sub_sub_category` (
  `id` bigint UNSIGNED NOT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `sub_sub_category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_views`
--

CREATE TABLE `business_views` (
  `id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referrer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `captcha_providers`
--

CREATE TABLE `captcha_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `captcha_providers`
--

INSERT INTO `captcha_providers` (`id`, `name`, `alias`, `logo`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Google reCAPTCHA', 'google_recaptcha', 'images/captcha-providers/google-recaptcha.png', '{\"site_key\":null,\"secret_key\":null}', 0, '2024-10-13 17:39:19', '2025-05-17 15:48:11'),
(2, 'hCaptcha', 'hcaptcha', 'images/captcha-providers/hcaptcha.png', '{\"site_key\":null,\"secret_key\":null}', 0, '2024-10-13 17:39:25', '2025-01-01 17:46:08'),
(3, 'Cloudflare Turnstile', 'cloudflare_turnstile', 'images/captcha-providers/cloudflare-turnstile.png', '{\"site_key\":null,\"secret_key\":null}', 0, '2024-10-13 17:39:30', '2024-10-13 17:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `title`, `description`, `keywords`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Business Services', 'business-services', 'images/categories/8Dy6KJ9aeZOInfw_1747614281.png', 'Reviews on service providers and business solutions', 'Discover trusted reviews for professional services, including consulting, marketing, logistics, and more to support your business needs.', 'business services, professional services, consulting, marketing, logistics, trusted providers, business needs, service reviews', 15, '2024-12-25 20:06:34', '2025-05-18 19:24:41'),
(2, 'Health & Wellness', 'health-wellness', 'images/categories/w2Fvz7Ll6ugjAEP_1747614299.png', 'Reviews on health services, wellness products, and fitness centers', 'Find feedback on health products, fitness programs, medical services, and wellness experiences to improve your lifestyle.', 'health and wellness, fitness programs, medical services, health products, wellness experiences, lifestyle improvement, fitness feedback, wellness reviews', 9, '2024-12-25 20:09:02', '2025-05-18 19:24:59'),
(3, 'Technology & Gadgets', 'technology-gadgets', 'images/categories/4DmLnwRHXtZiOej_1747614307.png', 'Reviews on tech products, gadgets, and electronic devices', 'Explore user opinions on the latest devices, software, apps, and tech innovations shaping the future.', 'technology reviews, gadgets, devices, tech innovations, software reviews, apps, user opinions, future technology', 6, '2024-12-25 20:09:54', '2025-05-18 19:25:07'),
(4, 'Travel & Leisure', 'travel-leisure', 'images/categories/1ssi6l5uYMDoua8_1747614315.png', 'Reviews on destinations, hotels, and travel services', 'Read reviews on destinations, accommodations, tours, and leisure activities to plan your perfect getaway.', 'travel reviews, leisure, destinations, accommodations, tours, hotel reviews, vacation planning, travel guides', 3, '2024-12-25 20:10:22', '2025-05-18 19:25:15'),
(5, 'Education & Learning', 'education-learning', 'images/categories/n8U2nD9ETAVOoCA_1747614323.png', 'Reviews on educational platforms, courses, and learning resources', 'Evaluate educational platforms, courses, tutors, and tools designed to boost your knowledge and skills.', 'education reviews, online courses, learning platforms, tutoring services, educational tools, skills development, course feedback, learning experiences', 5, '2024-12-25 20:11:11', '2025-05-18 19:25:23'),
(6, 'Finance & Insurance', 'finance-insurance', 'images/categories/5LhP00mNZlWdt3q_1747614331.png', 'Trusted Finance & Insurance Reviews: Banks, Cards, and Policies', 'Compare reviews on banks, credit cards, investment platforms, and insurance providers to make informed decisions.', 'finance reviews, insurance reviews, credit cards, investment platforms, banking services, financial products, policy reviews, insurance providers', 4, '2024-12-25 20:11:44', '2025-05-18 19:25:31'),
(7, 'Food & Drink', 'food-drink', 'images/categories/mCn98MVjAq7Rmrd_1747614358.png', 'Ratings for restaurants, food products, and beverages', 'Discover top-rated restaurants, recipes, meal kits, and food delivery services to satisfy your cravings.', 'food and drink, restaurant reviews, meal kits, food delivery services, recipe reviews, culinary experiences, dining feedback, restaurant ratings', 6, '2024-12-25 20:12:22', '2025-05-18 19:25:58'),
(8, 'Retail & Shopping', 'retail-shopping', 'images/categories/10ZDMZPPHp2Czxe_1747614365.png', 'Reviews on stores, products, and shopping experiences', 'Check out customer experiences with online stores, boutiques, and shopping apps for a better retail journey.', 'retail reviews, shopping apps, online stores, customer experiences, boutique reviews, retail journey, shopping feedback, online shopping', 6, '2024-12-25 20:12:58', '2025-05-18 19:26:05'),
(9, 'Home & Living', 'home-living', 'images/categories/t7QgCJaTMAJX6dM_1747614373.png', 'Ratings for home goods, furniture, and living essentials', 'Find reviews on home services, furniture, decor, and appliances to enhance your living space.', 'home and living, furniture reviews, home decor, home services, appliances, living space improvement, furniture feedback, home design', 8, '2024-12-25 20:13:52', '2025-05-18 19:26:13'),
(10, 'Automotive & Vehicles', 'automotive-vehicles', 'images/categories/WOmyAc6vXsElObR_1747614380.png', 'Reviews on vehicles, auto services, and automotive products', 'Explore insights into cars, motorcycles, accessories, and maintenance services for your automotive needs.', 'automotive reviews, vehicle reviews, cars, motorcycles, automotive accessories, maintenance services, car reviews, vehicle insights', 6, '2024-12-25 20:14:31', '2025-05-18 19:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `editor_images`
--

CREATE TABLE `editor_images` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `name`, `alias`, `logo`, `credentials`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Google Analytics 4', 'google_analytics', 'images/extensions/google-analytics.png', '{\"measurement_id\":null}', 0, '2024-10-13 17:40:22', '2024-10-13 17:40:25'),
(2, 'Tawk.to', 'tawk_to', 'images/extensions/tawk-to.png', '{\"embed_url\":\"\"}', 0, '2024-10-13 17:40:27', '2024-12-21 17:42:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` bigint NOT NULL DEFAULT '0',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `title`, `body`, `order`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'What is Lorem Ipsum?', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 11, 'en', '2022-07-16 22:58:31', '2025-04-21 23:10:51'),
(2, 'Why do we use it?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 5, 'en', '2022-07-16 22:58:58', '2025-04-21 23:10:51'),
(3, 'Where does it come from?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 4, 'en', '2022-07-16 22:59:17', '2025-04-21 23:10:51'),
(4, 'Where can I get some?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 2, 'en', '2022-07-16 22:59:33', '2025-04-21 23:15:34'),
(5, 'Essential Lorem Ipsum a placeholder odyssey?', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 7, 'en', '2022-07-16 22:58:31', '2025-04-21 23:10:51'),
(6, 'The Lorem Ipsum Chronicles?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 8, 'en', '2022-07-16 22:58:58', '2025-04-21 23:10:51'),
(7, 'Lorem Ipsum Unmasked?', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', 9, 'en', '2022-07-16 22:59:17', '2025-04-21 23:10:51'),
(8, 'Mastering the Art of Lorem Ipsum?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 12, 'en', '2022-07-16 22:59:33', '2025-04-21 22:46:55'),
(9, 'Where can I get some?', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', 6, 'en', '2022-07-16 22:59:33', '2025-04-21 23:10:51'),
(10, 'The Lorem Ipsum Chronicles?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 3, 'en', '2022-07-16 22:58:58', '2025-04-21 23:10:51'),
(11, 'The Lorem Ipsum Chronicles?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 10, 'en', '2022-07-16 22:58:58', '2025-04-21 23:10:51'),
(12, 'Why do we use it?', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 1, 'en', '2022-07-16 22:58:58', '2025-04-21 23:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

CREATE TABLE `footer_links` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` bigint NOT NULL DEFAULT '0',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_links`
--

INSERT INTO `footer_links` (`id`, `name`, `link`, `type`, `parent_id`, `order`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'Company', '/page-example', 1, NULL, 1, 'en', '2023-02-05 13:20:43', '2024-05-03 19:06:33'),
(2, 'About Us', '/page-example', 1, 1, 1, 'en', '2023-02-05 13:21:04', '2024-05-03 19:10:00'),
(3, 'Careers', '/page-example', 1, 1, 2, 'en', '2023-02-05 13:21:21', '2023-02-05 13:32:58'),
(4, 'Legal', '/page-example', 1, NULL, 2, 'en', '2023-02-05 13:21:53', '2025-04-21 23:03:43'),
(5, 'Privacy policy', '/privacy-policy', 1, 4, 1, 'en', '2023-02-05 13:22:03', '2023-02-10 16:47:39'),
(6, 'Terms of use', '/terms-of-use', 1, 4, 2, 'en', '2023-02-05 13:22:16', '2023-02-10 16:47:48'),
(7, 'Copyright Policy', '/page-example', 1, 4, 4, 'en', '2023-02-05 13:22:27', '2023-02-05 13:34:26'),
(8, 'Contact Us', '/contact-us', 1, 1, 3, 'en', '2023-02-05 13:22:53', '2024-05-26 17:12:11'),
(10, 'Press Room', '/page-example', 1, 1, 4, 'en', '2023-02-05 13:33:25', '2023-02-05 13:33:33'),
(11, 'Cookies Policy', '/page-example', 1, 4, 3, 'en', '2023-02-05 13:34:06', '2023-02-05 13:34:11'),
(12, 'Support', '/page-example', 1, NULL, 3, 'en', '2023-02-05 13:34:49', '2025-04-21 23:03:43'),
(13, 'Help Center', '/page-example', 1, 12, 1, 'en', '2023-02-05 13:35:02', '2023-02-05 13:35:22'),
(14, 'Customer Service', '/page-example', 1, 12, 2, 'en', '2023-02-05 13:35:12', '2023-02-05 13:35:22'),
(15, 'Frequently Asked Questions', '/page-example', 1, 12, 3, 'en', '2023-02-05 13:35:28', '2023-02-05 13:35:33'),
(16, 'Report a Problem', '/page-example', 1, 12, 4, 'en', '2023-02-05 13:35:49', '2023-02-05 13:35:53');

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `items_number` int DEFAULT NULL,
  `cache_expiry_time` int UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `sub_category_id` bigint UNSIGNED DEFAULT NULL,
  `sub_sub_category_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `order` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `name`, `alias`, `description`, `items_number`, `cache_expiry_time`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Explore by Category', 'categories', NULL, 10, 1440, NULL, NULL, NULL, 1, 1, '2024-12-25 21:34:33', '2025-04-19 01:09:25'),
(2, 'Frequently Asked Questions', 'faqs', 'Got questions? We\'ve got answers. Delve into our Frequently Asked Questions (FAQs) section to find comprehensive information about your inquiries.', 8, 1440, NULL, NULL, NULL, 1, 9, '2024-12-25 21:34:33', '2025-04-21 22:24:28'),
(3, 'Latest Blog Posts', 'blog_articles', 'Stay informed and inspired with our latest blog posts. Dive into a treasure trove of articles covering a diverse range of topics, from expert insights to practical tips.', 6, 1440, NULL, NULL, NULL, 0, 10, '2024-12-25 21:34:33', '2025-05-13 04:50:04'),
(6, 'Best in Services', NULL, NULL, 4, 1440, 1, NULL, NULL, 1, 4, '2024-12-29 23:09:32', '2025-04-18 21:51:41'),
(8, 'Marketing & Advertising', NULL, NULL, 4, 1440, NULL, 1, NULL, 1, 5, '2025-04-16 15:51:32', '2025-04-18 21:51:41'),
(9, 'Business Strategy', NULL, NULL, 4, 1440, NULL, NULL, 11, 1, 6, '2025-04-16 16:04:28', '2025-04-18 21:51:41'),
(10, 'Trending Businesses', 'trending', NULL, 4, 1440, NULL, NULL, NULL, 1, 2, '2024-12-25 21:34:33', '2025-05-02 02:26:24'),
(11, 'Best Rating Businesses', 'best_rating', NULL, 4, 1440, NULL, NULL, NULL, 1, 3, '2024-12-25 21:34:33', '2025-05-02 02:25:44'),
(12, 'Featured Businesses', 'featured', NULL, 4, 1440, NULL, NULL, NULL, 1, 7, '2024-12-25 21:34:33', '2025-05-02 02:26:35'),
(13, 'Recent Reviews', 'recent_reviews', NULL, 10, 1440, NULL, NULL, NULL, 1, 8, '2024-12-25 21:34:33', '2025-04-21 00:31:53');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc_verifications`
--

CREATE TABLE `kyc_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `document_type` enum('national_id','passport') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `documents` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1:Pending 2:Approved 3:Rejected',
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `business_owner_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('ltr','rtl') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `logo`, `direction`, `sort_id`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 'images/languages/en.png', 'ltr', 1, '2024-10-03 22:51:18', '2025-05-17 20:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortcodes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `name`, `alias`, `group`, `subject`, `body`, `shortcodes`, `status`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'Reset Password', 'password_reset', 'general', 'Reset Your Account Password', '<h2><strong>Hello!</strong></h2><p>You are receiving this email because we received a password reset request for your account, please click on the link below to reset your password.</p><p><a href=\"{{link}}\">{{link}}</a></p><p>This password reset link will expire in <strong>{{expiry_time}}</strong> minutes. If you did not request a password reset, no further action is required.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"link\",\"expiry_time\",\"website_name\"]', 1, 'en', '2024-10-13 17:39:37', '2024-10-13 17:39:40'),
(2, 'Email Verification', 'email_verification', 'general', 'Verify Email Address', '<h2>Hello!</h2><p>Please click on the link below to verify your email address.</p><p><a href=\"{{link}}\">{{link}}</a></p><p>If you did not create an account, no further action is required.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"link\",\"website_name\"]', 1, 'en', '2024-10-13 17:39:42', '2024-10-13 17:44:23'),
(3, 'Employee Invitation', 'business_employee_invitation', 'business', 'You\'re invited to join {{business_name}} on {{website_name}}', '<h2>Hello!</h2><p>You’ve been invited to join the <b>{{business_name}}</b> team on <b>{{website_name}}.&nbsp;</b></p><p>To accept the invitation, please click the link below:</p><p><a href=\"{{invitation_link}}\" title=\"\" target=\"\">{{invitation_link}}</a></p><p>If you weren’t expecting this invitation, feel free to ignore this message.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"business_name\",\"invitation_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-29 21:50:42'),
(4, 'KYC Verification Approved', 'kyc_verification_approved', 'general', 'Your KYC verification has been approved', '<h2>Hi, {{name}}</h2><p>We are pleased to inform you that your Know Your Customer (KYC) verification process has been successfully completed and approved. Your account is now fully verified and ready for use.</p><p>This verification process ensures the security and integrity of our platform, and we appreciate your cooperation throughout this process. With your KYC verification approved, you now have access to all features and functionalities of our platform without any restrictions.</p><p>Should you have any questions or require further assistance, please do not hesitate to contact our customer support team. We are here to help you with any queries you may have.</p><p>Thank you for choosing our platform. We look forward to serving you and providing you with an excellent user experience.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"website_name\"]', 1, 'en', '2025-04-22 16:04:57', '2025-04-22 16:04:57'),
(5, 'KYC Verification Rejected', 'kyc_verification_rejected', 'general', 'Your KYC verification has been rejected', '<h2>Hi, {{name}}</h2><p>We regret to inform you that your recent Know Your Customer (KYC) verification submission has been rejected. After a thorough review, we have determined that we are unable to approve your KYC verification at this time.</p><p>The reason for the rejection is as follows:&nbsp;<br>“ <i>{{rejection_reason}}</i> ”</p><p>We understand that this may be disappointing, and we apologize for any inconvenience this may cause. Please review the reason provided above to understand why your submission was not successful.</p><p>To address this issue and proceed with the verification process, we kindly request that you review the provided reason and take the necessary steps to rectify any discrepancies or issues. Once you have addressed the concerns, you may resubmit your KYC verification documents for further review.</p><p>If you have any questions or require assistance in understanding the rejection reason or the steps to take for resubmission, please don\'t hesitate to reach out to our customer support team. We are here to assist you throughout this process.</p><p>Thank you for your understanding and cooperation.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"rejection_reason\",\"website_name\"]', 1, 'en', '2025-04-22 16:04:57', '2025-04-27 18:37:58'),
(6, 'New KYC Pending', 'admin_kyc_pending', 'admin', 'New KYC Verification Request [#{{kyc_verification_id}}]', '<h2>Hello!</h2><p>You have a new KYC Verification Request submitted by <strong>{{name}} </strong>and the ID is #<strong>{{kyc_verification_id}}</strong></p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"kyc_verification_id\",\"view_link\",\"website_name\"]', 1, 'en', '2025-04-22 16:07:14', '2025-04-29 21:49:39'),
(7, 'New Review', 'business_new_review', 'business', 'You have a new review for {{business_name}} on {{website_name}}', '<h2>Hi,&nbsp;{{name}}</h2><p data-start=\"82\" data-end=\"161\" class=\"\">You’ve received a new review for <strong data-start=\"115\" data-end=\"136\">{{business_name}}</strong> on <strong data-start=\"140\" data-end=\"160\">{{website_name}}</strong>!</p><p>\r\n</p><p data-start=\"163\" data-end=\"316\" class=\"\">We’re excited to let you know that&nbsp;<b>{{reviewer_name}}</b> has shared his experience with your business.<br></p><p data-start=\"82\" data-end=\"161\" class=\"\">You can view the review by following this link:&nbsp;</p><p></p><p data-start=\"163\" data-end=\"316\" class=\"\"><font color=\"#ffb000\"><a href=\"{{review_link}}\" title=\"\" target=\"\">{{review_link}}</a></font></p><p>If you received this email by mistake or weren’t expecting this email, feel free to ignore it.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"reviewer_name\",\"review_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-30 00:05:11'),
(9, 'Review Published', 'user_review_published', 'user', 'Your review for {{business_name}} on {{website_name}} is now published', '<h2>Hi,&nbsp;{{name}}</h2><p><span style=\"font-size: 0.9375rem;\">Your review for </span><strong data-start=\"112\" data-end=\"133\" style=\"font-size: 0.9375rem;\">{{business_name}}</strong><span style=\"font-size: 0.9375rem;\"> has just been published on </span><strong data-start=\"161\" data-end=\"181\" style=\"font-size: 0.9375rem;\">{{website_name}}</strong><span style=\"font-size: 0.9375rem;\">.</span></p><p data-start=\"184\" data-end=\"342\" class=\"\">Thank you for sharing your experience — your feedback helps others make informed decisions and supports businesses like {{business_name}} to grow and improve.</p><p data-start=\"344\" data-end=\"408\" class=\"\">You can view your review by following this link:&nbsp;</p><p data-start=\"344\" data-end=\"408\" class=\"\"><a href=\"{{review_link}}\" title=\"\" target=\"\">{{review_link}}</a></p><p>\r\n\r\n\r\n</p><p data-start=\"410\" data-end=\"472\" class=\"\">Thanks again for being part of the {{website_name}} community!</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"review_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-29 21:46:56'),
(10, 'Review Rejected', 'user_review_rejected', 'user', 'Your review for {{business_name}} on {{website_name}} has been rejected', '<h2>Hi,&nbsp;{{name}}</h2><p data-start=\"91\" data-end=\"202\" class=\"\">We wanted to let you know that your review for <strong data-start=\"138\" data-end=\"159\">{{business_name}}</strong> on <strong data-start=\"163\" data-end=\"183\">{{website_name}}</strong> has been rejected.</p><p data-start=\"204\" data-end=\"405\" class=\"\">After careful evaluation, we found that it did not meet our review guidelines. We encourage you to submit a new review that follows our standards, ensuring it remains helpful, respectful, and relevant.</p><p data-start=\"407\" data-end=\"488\" class=\"\">You can submit a new review by following this link:&nbsp;</p><p data-start=\"407\" data-end=\"488\" class=\"\"><a href=\"{{business_link}}\" title=\"\" target=\"\">{{business_link}}</a></p><p>\r\n\r\n\r\n</p><p data-start=\"490\" data-end=\"571\" class=\"\">Thank you for understanding and for being part of the {{website_name}} community.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"business_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-27 23:59:36'),
(11, 'Review Replied', 'user_review_replied', 'user', '{{business_name}} has replied on your review', '<h2>Hi,&nbsp;{{name}}</h2><p data-start=\"70\" data-end=\"156\" class=\"\"><strong data-start=\"83\" data-end=\"104\">{{business_name}}</strong> has replied to your review on <strong data-start=\"135\" data-end=\"155\">{{website_name}}</strong>.</p><p data-start=\"158\" data-end=\"286\" class=\"\">They appreciate your feedback and would love for you to see their response.&nbsp;</p><p data-start=\"158\" data-end=\"286\" class=\"\">You can view it by following this link:&nbsp;</p><p data-start=\"158\" data-end=\"286\" class=\"\"><span style=\"font-size: 0.9375rem;\"><a href=\"{{review_link}}\" title=\"\" target=\"\">{{review_link}}</a></span></p><p data-start=\"158\" data-end=\"286\" class=\"\"><span style=\"font-size: 0.9375rem;\">Thank you for being an important part of the {{website_name}} community!</span></p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"review_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-29 21:44:57'),
(12, 'Business Suspended', 'business_suspended', 'business', 'Your business {{business_name}} has been suspended', '<h2>Hi,&nbsp;{{name}}</h2><p data-start=\"102\" data-end=\"216\" class=\"\">We’re writing to inform you that <span data-start=\"135\" data-end=\"191\">your business,</span><strong data-start=\"135\" data-end=\"191\"> {{business_name}}, </strong><span data-start=\"135\" data-end=\"191\">has been suspended</span> on <strong data-start=\"195\" data-end=\"215\">{{website_name}}</strong>.</p><p data-start=\"218\" data-end=\"395\" class=\"\">This action was taken due to a violation of our platform’s guidelines or policies.&nbsp;</p><p data-start=\"82\" data-end=\"161\" class=\"\">\r\n\r\n</p><p data-start=\"397\" data-end=\"497\" class=\"\">If you believe this was a mistake or need further assistance, feel free to contact us.</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-29 21:35:26'),
(13, 'Business Activated', 'business_activated', 'business', 'Your business {{business_name}} has been Reactivated', '<h2>Hi,&nbsp;{{name}}</h2><div><p data-start=\"203\" data-end=\"304\" class=\"\">Great news!</p></div><p data-start=\"89\" data-end=\"201\" class=\"\">\r\nYour business <strong data-start=\"117\" data-end=\"138\">{{business_name}}</strong> has been successfully <strong data-start=\"161\" data-end=\"176\">reactivated</strong> on <strong data-start=\"180\" data-end=\"200\">{{website_name}}</strong>.</p><p data-start=\"203\" data-end=\"304\" class=\"\">Your listings are now visible again, and customers can continue engaging with your business as usual.</p><p data-start=\"203\" data-end=\"304\" class=\"\"><a href=\"http://trustbob.viro.com/admin/settings/mail-templates/13/%7B%7Bbusiness_link%7D%7D\" title=\"\" target=\"\" style=\"color: rgb(255, 176, 0);\">{{business_link}}</a></p><p data-start=\"102\" data-end=\"216\" class=\"\">\r\n\r\n</p><p data-start=\"306\" data-end=\"389\" class=\"\">Thank you for resolving the issue. We’re glad to have you back!</p><p>Regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"business_name\",\"business_link\",\"website_name\"]', 1, 'en', '2024-10-13 16:39:42', '2025-04-29 21:43:41'),
(15, 'New Reported Review', 'admin_reported_review', 'admin', 'New Reported Review [#{{report_id}}]', '<h2>Hello!</h2><p>You have a new review reported by <strong>{{name}} </strong>and the ID is #<b>{{report_id}}</b></p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"report_id\",\"view_link\",\"website_name\"]', 1, 'en', '2025-04-22 16:07:14', '2025-04-30 16:04:53'),
(16, 'New Pending Review', 'admin_pending_review', 'admin', 'New Pending Review [#{{review_id}}]', '<h2>Hello!</h2><p>You have a new&nbsp;<span style=\"font-size: 0.9375rem;\">pending&nbsp;</span><span style=\"font-size: 0.9375rem;\">review submitted by </span><strong style=\"font-size: 0.9375rem;\">{{name}} </strong><span style=\"font-size: 0.9375rem;\">and the ID is #</span><b>{{review_id}}</b></p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"review_id\",\"view_link\",\"website_name\"]', 1, 'en', '2025-04-22 16:07:14', '2025-05-01 00:03:44'),
(17, 'Payment Confirmation', 'business_payment_confirmation', 'business', 'Payment Confirmation [#{{transaction_id}}]', '<h2>Hi, {{name}}</h2><p>We hope this email finds you well. We are reaching out to confirm the successful payment for your recent transaction.</p><p><strong><u>Here are the details of your transaction:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total :</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p>Your payment has been processed successfully, and your transaction is now complete. You can view the transaction and print your invoice by clicking on the link below</p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>If you have any questions or require further assistance, please don\'t hesitate to contact us. We are here to help.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"transaction_id\",\"transaction_subtotal\",\"payment_method\",\"transaction_fees\",\"transaction_total\",\"transaction_date\",\"view_link\",\"website_name\"]', 1, 'en', '2025-05-03 20:24:04', '2025-05-03 20:27:37'),
(18, 'Transaction Cancelled', 'business_transaction_cancelled', 'business', 'Your transaction has been canceled [#{{transaction_id}}]', '<h2>Hi, {{name}}</h2><p>We hope this email finds you well. We are reaching out because your recent transaction has been canceled for the following reason:</p><p>--</p><p><i>{{cancellation_reason}}</i></p><p><i>--</i></p><p><strong><u>Here are the details of your transaction:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total:</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p><strong>View Link:</strong> <a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>If you have any questions or require further assistance, please don\'t hesitate to contact us. We are here to help.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"transaction_id\",\"transaction_subtotal\",\"payment_method\",\"transaction_fees\",\"transaction_total\",\"transaction_date\",\"view_link\",\"cancellation_reason\",\"website_name\"]', 1, 'en', '2025-05-05 00:00:13', '2025-05-05 00:03:16'),
(19, 'Subscription About To Expire', 'subscription_about_to_expire', 'business', 'Your subscription is about to expire', '<h2>Hi {{name}},</h2><p>We hope you\'re enjoying your experience on {{website_name}}. We wanted to remind you that your subscription is set to expire on <strong>{{expiry_date}}</strong>.</p><p>Don\'t miss out on continued access to our extensive library of assets and exclusive resources. To renew or upgrade your subscription, simply click the link below:</p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>We look forward to continuing to support you with the best resources and tools.</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"expiry_date\",\"view_link\",\"website_name\"]', 1, 'en', '2025-05-03 18:46:37', '2025-05-03 18:49:14'),
(20, 'Subscription Expired', 'subscription_expired', 'business', 'Your subscription has been expired', '<h2>Hi {{name}},</h2><p>We wanted to inform you that your subscription expired on <strong>{{expiry_date}}</strong>. Unfortunately, you no longer have access to our exclusive library of assets.</p><p>But don\'t worry—you can easily renew or upgrade your subscription to regain access to all the resources you love! Just click the link below to renew:</p><p><a href=\"{{view_link}}\" title=\"\" target=\"\">{{view_link}}</a></p><p>We hope to see you back soon!</p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"expiry_date\",\"view_link\",\"website_name\"]', 1, 'en', '2025-05-03 18:46:37', '2025-05-03 18:49:53'),
(23, 'Admin Transaction Pending', 'admin_transaction_pending', 'admin', 'New Pending Transaction [#{{transaction_id}}]', '<h2>Hello!</h2><p>You have a new pending transaction made by <b>{{name}}</b>.&nbsp;</p><p><strong><u>Here are the details:</u></strong></p><p><strong>Transaction ID:</strong> #{{transaction_id}}</p><p><strong>Payment Method:</strong> {{payment_method}}</p><p><strong>SubTotal:</strong> {{transaction_subtotal}}</p><p><strong>Fees:</strong> {{transaction_fees}}</p><p><strong>Total:</strong> {{transaction_total}}</p><p><strong>Date: </strong>{{transaction_date}}</p><p><strong>Review Link: </strong><a href=\"{{review_link}}\">{{view_link}}</a></p><p>Best regards,<br><strong>{{website_name}}</strong></p>', '[\"name\",\"transaction_id\",\"transaction_subtotal\",\"transaction_fees\",\"transaction_total\",\"payment_method\",\"transaction_date\",\"view_link\",\"website_name\"]', 1, 'en', '2025-05-03 20:24:04', '2025-05-05 15:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_10_01_181637_create_admins_table', 1),
(4, '2024_10_01_194131_create_settings_table', 1),
(6, '2024_10_03_210137_create_captcha_providers_table', 3),
(7, '2024_10_03_211201_create_oauth_providers_table', 4),
(8, '2024_10_03_211815_create_themes_table', 5),
(9, '2024_10_03_211941_create_addons_table', 6),
(11, '2024_10_03_224424_create_languages_table', 8),
(12, '2024_10_03_224435_create_translates_table', 8),
(13, '2024_10_03_230021_create_mail_templates_table', 9),
(14, '2024_10_03_230934_create_extensions_table', 10),
(15, '2024_10_14_011623_create_pages_table', 11),
(16, '2024_10_15_164420_create_navbar_links_table', 12),
(17, '2024_10_15_164433_create_footer_links_table', 12),
(18, '2024_10_17_224601_create_blog_categories_table', 13),
(19, '2024_10_17_224612_create_blog_articles_table', 13),
(20, '2024_10_17_224630_create_blog_comments_table', 13),
(22, '2024_10_20_181944_create_faqs_table', 15),
(25, '2024_10_21_183751_create_taxes_table', 18),
(26, '2024_10_21_193427_create_payment_gateways_table', 19),
(35, '2024_12_12_190946_create_editor_images_table', 22),
(36, '2024_12_25_172812_create_categories_table', 23),
(40, '2024_12_25_222333_create_home_sections_table', 24),
(42, '2024_12_29_180109_create_newsletter_subscribers_table', 25),
(45, '2025_01_03_235147_create_business_owners_table', 26),
(55, '2025_02_24_221937_create_businesses_table', 30),
(71, '2025_05_01_013820_create_advertisements_table', 32),
(72, '2025_05_02_224237_create_plans_table', 33),
(73, '2024_10_03_224434_create_translates_table', 34),
(75, '2025_05_03_164153_create_subscriptions_table', 35),
(76, '2025_05_05_005600_create_transactions_table', 36),
(77, '2025_04_22_160534_create_kyc_verifications_table', 37);

-- --------------------------------------------------------

--
-- Table structure for table `navbar_links`
--

CREATE TABLE `navbar_links` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` bigint NOT NULL DEFAULT '0',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navbar_links`
--

INSERT INTO `navbar_links` (`id`, `name`, `link`, `type`, `parent_id`, `order`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', 1, NULL, 1, 'en', '2024-10-17 18:24:24', '2025-05-13 15:34:47'),
(2, 'Categories', '/categories', 1, NULL, 2, 'en', '2024-10-17 19:00:51', '2025-05-01 22:19:52'),
(3, 'Blog', '/blog', 1, NULL, 4, 'en', '2024-10-17 19:01:03', '2025-04-19 01:27:06'),
(9, 'Businesses', '/businesses', 1, NULL, 3, 'en', '2025-04-19 01:26:59', '2025-05-01 22:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_providers`
--

CREATE TABLE `oauth_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_providers`
--

INSERT INTO `oauth_providers` (`id`, `name`, `alias`, `logo`, `credentials`, `parameters`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'facebook', 'images/oauth/facebook.png', '{\"client_id\":null,\"client_secret\":null}', '[{\"type\": \"route\", \"label\": \"Callback URL\", \"content\": \"oauth/facebook/callback\" }]', 0, '2024-10-13 17:39:57', '2025-05-07 14:52:36'),
(2, 'Google', 'google', 'images/oauth/google.png', '{\"client_id\":null,\"client_secret\":null}', '[{\"type\": \"route\", \"label\": \"Callback URL\", \"content\": \"oauth/google/callback\" }]', 0, '2024-10-13 17:40:02', '2025-05-07 14:54:38'),
(3, 'Microsoft', 'microsoft', 'images/oauth/microsoft.png', '{\"client_id\":null,\"client_secret\":null}', '[{\"type\": \"route\", \"label\": \"Callback URL\", \"content\": \"oauth/microsoft/callback\" }]', 0, '2024-10-13 17:40:07', '2025-05-07 14:54:46'),
(4, 'Vkontakte', 'vkontakte', 'images/oauth/vkontakte.png', '{\"client_id\":null,\"client_secret\":null}', '[{\"type\": \"route\", \"label\": \"Callback URL\", \"content\": \"oauth/vkontakte/callback\" }]', 0, '2024-10-13 17:40:11', '2025-05-07 14:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `body`, `description`, `keywords`, `views`, `lang`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy', 'privacy-policy', '<div style=\"text-align: justify;\"><div><span style=\"text-align: start;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></div><div><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 0.9375rem; font-weight: var(--bs-body-font-weight);\"><br></span></div><div style=\"text-align: start;\"><p><span style=\"font-weight: 600 !important;\">Where does it come from?</span></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><span style=\"font-weight: 600 !important;\">Why do we use it?</span></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><span style=\"font-weight: 600 !important;\">Where can I get some?</span></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div></div>', 'Review our Privacy Policy to learn how we collect, use, and protect your personal information.', 'privacy policy, data protection, personal information, user consent, cookies policy, data collection, data usage, user rights, GDPR compliance, CCPA compliance, third-party services, data sharing, data security', 6, 'en', '2024-10-14 00:33:35', '2025-04-29 00:20:11'),
(3, 'Terms of use', 'terms-of-use', '<div style=\"text-align: justify;\"><div><span style=\"text-align: start;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></div><div><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 0.9375rem; font-weight: var(--bs-body-font-weight);\"><br></span></div><div style=\"text-align: start;\"><p><span style=\"font-weight: 600 !important;\">Where does it come from?</span></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><span style=\"font-weight: 600 !important;\">Why do we use it?</span></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><span style=\"font-weight: 600 !important;\">Where can I get some?</span></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div></div>', 'Read our Terms of Use to understand the rules and guidelines for using our website and services. This policy outlines your rights and responsibilities', 'terms of use, user agreement, service terms, acceptable use, prohibited activities, intellectual property, liability limitations, account responsibilities,user obligations, content ownership', 2, 'en', '2024-10-14 00:33:35', '2025-04-29 00:20:11'),
(4, 'Page Example', 'page-example', '<div style=\"text-align: justify;\"><div><span style=\"text-align: start;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></div><div><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 0.9375rem; font-weight: var(--bs-body-font-weight);\"><br></span></div><div style=\"text-align: start;\"><p><span style=\"font-weight: 600 !important;\">Where does it come from?</span></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><span style=\"font-weight: 600 !important;\">Why do we use it?</span></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><span style=\"font-weight: 600 !important;\">Where can I get some?</span></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div></div>', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'page example, sample page, example content, placeholder text, demo page, webpage layout, content template, design example', 15, 'en', '2024-10-14 00:33:35', '2025-05-01 20:32:57'),
(6, 'GDPR Policy', 'gdpr-policy', '<div style=\"text-align: justify;\"><div><span style=\"text-align: start;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></div><div><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 0.9375rem; font-weight: var(--bs-body-font-weight);\"><br></span></div><div style=\"text-align: start;\"><p><span style=\"font-weight: 600 !important;\">Where does it come from?</span></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><span style=\"font-weight: 600 !important;\">Why do we use it?</span></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><span style=\"font-weight: 600 !important;\">Where can I get some?</span></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div></div>', 'Discover how we use cookies on our website in compliance with GDPR regulations', 'GDPR Compliance, Data Protection, Personal Data, User Rights, Data Processing, Data Security, Data Collection, Consent, Data Retention, Data Subject Rights, Right to Access', 1, 'en', '2024-12-28 00:46:57', '2025-04-29 00:20:11'),
(7, 'Business Terms', 'business-terms', '<div style=\"text-align: justify;\"><span style=\"text-align: start;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></div><div style=\"text-align: justify;\"><span style=\"color: var(--bs-card-color); background-color: var(--bs-card-bg); font-size: 0.9375rem; font-weight: var(--bs-body-font-weight);\"><br></span></div><div><p><span style=\"font-weight: 600 !important;\">Where does it come from?</span></p><p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p><p><span style=\"font-weight: 600 !important;\">Why do we use it?</span></p><p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p><p><span style=\"font-weight: 600 !important;\">Where can I get some?</span></p><p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p></div>', 'Business registration terms and eligibility, requirements, and legal guidelines.', 'Business, Registration, Terms, Conditions, Requirements, Legal, Compliance, Guidelines, Company', 4, 'en', '2025-02-21 00:09:05', '2025-04-29 00:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` int NOT NULL DEFAULT '0',
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,9) DEFAULT NULL,
  `credentials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mode` enum('sandbox','live') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instructions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sort_id` bigint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `name`, `alias`, `logo`, `fees`, `currency`, `rate`, `credentials`, `parameters`, `mode`, `instructions`, `type`, `status`, `sort_id`) VALUES
(1, 'Paypal', 'paypal', 'images/payment-gateways/paypal.png', 0, NULL, NULL, '{\"client_id\":null,\"client_secret\":null,\"webhook_id\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payment.capture.completed\"},\r\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/paypal\" }]', 'sandbox', NULL, 0, 0, 2),
(2, 'Paypal IPN', 'paypal_ipn', 'images/payment-gateways/paypal_ipn.png', 0, NULL, NULL, '{\"email\":null}', '', 'sandbox', NULL, 0, 0, 3),
(3, 'Stripe', 'stripe', 'images/payment-gateways/stripe.png', 0, NULL, NULL, '{\"publishable_key\":null,\"secret_key\":null,\"webhook_secret\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"checkout.session.completed\"},\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/stripe\" }]', NULL, NULL, 0, 0, 4),
(4, 'Razorpay', 'razorpay', 'images/payment-gateways/razorpay.png', 0, NULL, NULL, '{\"key_id\":null,\"key_secret\":null,\"webhook_secret\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payment.captured\"},{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/razorpay\"}]', NULL, NULL, 0, 0, 6),
(5, 'Paystack', 'paystack', 'images/payment-gateways/paystack.png', 0, 'NGN', 1604.060000000, '{\"public_key\":null,\"secret_key\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/paystack\" }]', NULL, NULL, 0, 0, 5),
(6, 'Mollie', 'mollie', 'images/payment-gateways/mollie.png', 0, NULL, NULL, '{\"api_key\":null}', NULL, NULL, NULL, 0, 0, 7),
(7, 'Coinbase', 'coinbase', 'images/payment-gateways/coinbase.png', 0, NULL, NULL, '{\"api_key\":null,\"webhook_shared_secret\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/coinbase\" }]', NULL, NULL, 0, 0, 8),
(8, 'Coingate', 'coingate', 'images/payment-gateways/coingate.png', 0, NULL, NULL, '{\"auth_token\":null}', NULL, NULL, NULL, 0, 0, 9),
(9, 'Flutterwave', 'flutterwave', 'images/payment-gateways/flutterwave.png', 0, NULL, NULL, '{\"public_key\":null,\"secret_key\":null,\"secret_hash\":null}', '[{ \"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/flutterwave\" }]', NULL, NULL, 0, 0, 10),
(10, 'Midtrans', 'midtrans', 'images/payment-gateways/midtrans.png', 0, 'IDR', 16430.400000000, '{\"server_key\":null}', '[{\"type\": \"route\", \"label\": \"Finish URL\", \"content\": \"payments/ipn/midtrans\"},\n{\"type\": \"route\", \"label\": \"Unfinish URL\", \"content\": \"payments/ipn/midtrans\"},\n{\"type\": \"route\", \"label\": \"Error Payment URL\", \"content\":\"payments/ipn/midtrans\"}]', 'sandbox', NULL, 0, 0, 11),
(11, 'Xendit', 'xendit', 'images/payment-gateways/xendit.png', 0, 'IDR', 16430.400000000, '{\"api_secret_key\":null,\"webhook_verification_token\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"invoices.paid\"},\r\n{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/xendit\" }]', NULL, NULL, 0, 0, 12),
(12, 'Iyzico', 'iyzico', 'images/payment-gateways/iyzipay.png', 0, NULL, NULL, '{\"api_key\":null,\"secret_key\":null}', '[{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/iyzipay\" }]', 'sandbox', NULL, 0, 0, 13),
(13, 'Yookassa', 'yookassa', 'images/payment-gateways/yookassa.png', 0, 'RUB', 80.500000000, '{\"shop_id\":null,\"secret_key\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payment.succeeded\"},{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/yookassa\"}]', NULL, NULL, 0, 0, 14),
(14, 'UddoktaPay', 'uddoktapay', 'images/payment-gateways/uddoktapay.png', 0, 'BDT', 121.390000000, '{\"api_key\":null,\"base_url\":null}', NULL, NULL, NULL, 0, 0, 16),
(15, 'NowPayments', 'nowpayments', 'images/payment-gateways/nowpayments.png', 0, NULL, NULL, '{\"api_key\":null,\"ipn_secret_key\":null}', NULL, 'sandbox', NULL, 0, 0, 17),
(16, 'Mercadopago', 'mercadopago', 'images/payment-gateways/mercadopago.png', 0, 'BRL', 5.690000000, '{\"access_token\":null,\"webhook_secret_signature\":null}', '[{\"type\": \"event\", \"label\": \"Webhook Event\", \"content\": \"payments\"},{\"type\": \"route\", \"label\": \"Webhook Endpoint\", \"content\": \"payments/webhooks/mercadopago\"}]', NULL, NULL, 0, 0, 18),
(17, 'Bank Wire', 'bankwire', 'images/payment-gateways/bankwire.png', 0, NULL, NULL, NULL, NULL, NULL, '<p><br></p>', 1, 0, 20);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `interval` enum('week','month','year','lifetime') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `businesses` bigint UNSIGNED DEFAULT NULL,
  `categories` tinyint(1) NOT NULL DEFAULT '1',
  `employees` tinyint(1) NOT NULL DEFAULT '1',
  `custom_features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`) VALUES
(1, 'general', '{\"site_name\":\"Trustbob\",\"site_url\":\"\",\"date_format\":\"10\",\"timezone\":\"America\\/New_York\",\"contact_email\":null}'),
(2, 'actions', '{\"gdpr_cookie\":1,\"force_ssl\":0,\"contact_page\":0,\"blog\":1}'),
(3, 'admin', '{\"colors\":{\"primary_color\":\"#ffb000\",\"secondary_color\":\"#1c1c1c\",\"background_color\":\"#f9fafb\",\"sidebar_background_color\":\"#1c1c1c\",\"navbar_background_color\":\"#ffffff\"}}'),
(4, 'maintenance', '{\"status\":0,\"title\":\"Under Maintenance\",\"body\":\"<p style=\\\"text-align: center;\\\">Our site is currently undergoing scheduled maintenance to enhance your browsing experience. We apologize for any inconvenience and appreciate your patience. Please check back soon!<\\/p>\"}'),
(5, 'smtp', '{\"status\":0,\"mailer\":\"smtp\",\"host\":null,\"port\":null,\"username\":null,\"password\":null,\"encryption\":\"tls\",\"from_email\":null,\"from_name\":null}'),
(6, 'cronjob', '{\"key\":\"\",\"last_execution\":\"\"}'),
(9, 'links', '{\"terms_of_use_link\":\"\\/terms-of-use\",\"gdpr_cookie_policy_link\":\"\\/gdpr-policy\",\"business_terms_link\":\"\\/business-terms\"}'),
(10, 'currency', '{\"code\":\"USD\",\"symbol\":\"$\",\"position\":\"2\"}'),
(13, 'seo', '{\"title\":null,\"description\":null,\"keywords\":null}'),
(14, 'social_links', '{\"facebook\":\"\\/\",\"x\":\"\\/\",\"youtube\":\"\\/\",\"linkedin\":\"\\/\",\"instagram\":\"\\/\",\"pinterest\":\"\\/\"}'),
(15, 'newsletter', '{\"status\":1,\"popup_status\":0,\"footer_status\":1,\"register_new_users\":1,\"popup_image\":\"images\\/newsletter\\/C6WB3bymEDu5Inv_1735494025.jpg\",\"popup_reminder_time\":\"24\"}'),
(16, 'business', '{\"actions\":{\"owners_registration\":1,\"owners_email_verification\":0,\"owners_kyc_required\":1,\"convert_logo_to_webp\":1,\"reviews_require_login\":0,\"reviews_require_reviewing\":0},\"default\":{\"businesses\":\"2\",\"employees\":1,\"categories\":1},\"media\":{\"default_logo\":\"images\\/businesses\\/default-logo.jpg\"},\"trending_number\":\"20\",\"best_rating_number\":\"20\"}'),
(17, 'user', '{\"actions\":{\"registration\":1,\"email_verification\":0,\"kyc_required\":0,\"adding_none_exists_business\":1}}'),
(18, 'kyc', '{\"actions\":{\"status\":1,\"selfie_verification\":1},\"media\":{\"id_front_image\":\"images\\/kyc\\/9VZjc94l68or4Ej_1745331575.svg\",\"id_back_image\":\"images\\/kyc\\/ETx2fq86HF2ynAT_1745331575.svg\",\"passport_image\":\"images\\/kyc\\/NeUp9BEGw1gIXVf_1745331575.svg\",\"selfie_image\":\"images\\/kyc\\/i3pbyVwv0cn0i9U_1745331575.svg\"}}'),
(19, 'subscription', '{\"status\":1,\"data_delete_days\":\"7\",\"before_expiring_reminder_days\":\"3\",\"after_expiring_reminder_days\":\"3\"}');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `business_owner_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `expiry_at` datetime DEFAULT NULL,
  `last_notification_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `name`, `slug`, `title`, `description`, `keywords`, `views`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Marketing & Advertising', 'marketing-advertising', 'Comprehensive Marketing & Advertising Solutions', 'Explore top-notch marketing and advertising services to elevate your brand presence and drive business growth.', 'marketing, advertising, brand promotion, digital marketing, SEO, content marketing, social media, online ads', 17, 1, '2024-12-25 19:15:00', '2025-05-04 12:32:19'),
(2, 'IT Services', 'it-services', 'Reliable IT Services for Your Business', 'Get reliable IT services to optimize your business operations, including network management, software development, and cybersecurity.', 'IT services, software development, network management, cybersecurity, cloud solutions, business IT, tech support, IT consulting', 7, 1, '2024-12-25 19:15:15', '2025-04-29 00:20:25'),
(3, 'Consulting', 'consulting', 'Expert Business Consulting for Growth', 'Benefit from expert consulting services to help improve your business strategy, operational efficiency, and market positioning.', 'consulting, business strategy, operational efficiency, market positioning, management consulting, financial consulting, professional advice, business solutions', 6, 1, '2024-12-25 19:15:30', '2025-05-02 15:45:28'),
(4, 'HR & Recruitment', 'hr-recruitment', 'Efficient HR & Recruitment Services', 'Find the best HR solutions, from recruitment to employee management, designed to streamline your human resources processes.', 'HR services, recruitment, employee management, hiring, staffing, talent acquisition, human resources, workforce solutions', 7, 1, '2024-12-25 19:15:45', '2025-04-29 00:20:25'),
(5, 'Legal Services', 'legal-services', 'Professional Legal Services You Can Trust', 'Access a range of legal services including contract drafting, litigation, and corporate law assistance, provided by professional attorneys.', 'legal services, law firm, legal advice, contract law, corporate law, litigation, attorney, legal consultation', 7, 1, '2024-12-25 19:16:00', '2025-04-29 00:20:24'),
(6, 'Accounting & Bookkeeping', 'accounting-bookkeeping', 'Comprehensive Accounting & Bookkeeping Services', 'Reliable accounting and bookkeeping services to keep your financial records accurate and up-to-date for better business decision-making.', 'accounting services, bookkeeping, financial management, tax services, bookkeeping solutions, business accounting, tax preparation, financial planning', 9, 1, '2024-12-25 19:16:15', '2025-04-29 00:20:24'),
(7, 'Graphic Design', 'graphic-design', 'Creative Graphic Design Services', 'Professional graphic design services to help elevate your brand identity with creative and impactful visual solutions.', 'graphic design, branding, visual design, logo design, creative design, print design, web design, digital design', 9, 1, '2024-12-25 19:16:30', '2025-05-01 20:26:40'),
(8, 'Translation & Localization', 'translation-localization', 'Expert Translation & Localization Services', 'Reach global audiences with expert translation and localization services tailored to your business and market needs.', 'translation services, localization, language services, multilingual content, document translation, business translation, cultural adaptation, global expansion', 7, 1, '2024-12-25 19:16:45', '2025-05-02 15:48:09'),
(9, 'Event Planning', 'event-planning', 'Professional Event Planning Services', 'Plan your next event with ease using our professional event planning services, ensuring every detail is taken care of.', 'event planning, event management, corporate events, wedding planning, party planning, event coordination, event organizers, event services', 7, 1, '2024-12-25 19:17:00', '2025-04-29 00:20:27'),
(10, 'Virtual Assistance', 'virtual-assistance', 'Reliable Virtual Assistance Services', 'Streamline your tasks and increase productivity with our professional virtual assistance services tailored to your needs.', 'virtual assistant, remote assistance, administrative support, virtual office, task management, personal assistant, business support, virtual help', 8, 1, '2024-12-25 19:17:15', '2025-04-29 00:20:27'),
(11, 'Fitness & Personal Training', 'fitness-personal-training', 'Personalized Fitness & Training Programs', 'Achieve your fitness goals with customized personal training programs designed to fit your needs and lifestyle.', 'fitness, personal training, workout plans, fitness goals, strength training, weight loss, fitness coach, personal fitness', 7, 2, '2024-12-25 19:17:30', '2025-04-29 00:20:27'),
(12, 'Nutrition & Diet', 'nutrition-diet', 'Expert Nutrition & Diet Plans', 'Receive expert guidance on nutrition and diet to improve your health, manage weight, and enhance overall wellness.', 'nutrition, diet plans, healthy eating, meal planning, weight management, balanced diet, nutritionist, dietary advice', 1, 2, '2024-12-25 19:17:45', '2025-04-29 00:20:13'),
(13, 'Mental Health', 'mental-health', 'Mental Health Support & Counseling', 'Find professional mental health support, counseling, and resources to improve emotional well-being and mental wellness.', 'mental health, counseling, therapy, mental wellness, emotional support, stress management, depression treatment, mental health services', 1, 2, '2024-12-25 19:18:00', '2025-04-29 00:20:13'),
(14, 'Healthcare Providers', 'healthcare-providers', 'Trusted Healthcare Providers & Services', 'Connect with reliable healthcare providers offering medical services, consultations, and treatments for your well-being.', 'healthcare, medical services, healthcare providers, doctors, medical consultation, health clinics, patient care, medical treatment', 1, 2, '2024-12-25 19:18:15', '2025-04-29 00:20:13'),
(15, 'Supplements', 'supplements', 'High-Quality Supplements for Health', 'Enhance your health with high-quality supplements, including vitamins, minerals, and other dietary products.', 'supplements, vitamins, minerals, health supplements, dietary supplements, wellness products, energy boosters, immune support', 3, 2, '2024-12-25 19:18:30', '2025-05-02 04:10:51'),
(16, 'Spa & Massage', 'spa-massage', 'Relaxing Spa & Massage Treatments', 'Indulge in relaxing spa and massage treatments designed to rejuvenate your body and mind.', 'spa, massage, relaxation, wellness, body treatments, aromatherapy, stress relief, massage therapy, spa services', 1, 2, '2024-12-25 19:18:45', '2025-04-29 00:20:13'),
(17, 'Yoga & Meditation', 'yoga-meditation', 'Yoga & Meditation for Mindfulness', 'Embrace mindfulness through yoga and meditation sessions designed to improve mental clarity, flexibility, and peace.', 'yoga, meditation, mindfulness, relaxation, stress relief, meditation practice, yoga instructor, flexibility, mental clarity', 2, 2, '2024-12-25 19:19:00', '2025-04-29 00:20:13'),
(18, 'Alternative Medicine', 'alternative-medicine', 'Alternative Medicine & Healing Practices', 'Explore alternative medicine and natural healing practices to support your overall health and well-being.', 'alternative medicine, natural healing, holistic health, acupuncture, herbal remedies, wellness, alternative therapies, natural treatments', 1, 2, '2024-12-25 19:19:15', '2025-04-29 00:20:13'),
(19, 'Weight Loss Programs', 'weight-loss-programs', 'Effective Weight Loss Programs', 'Join proven weight loss programs designed to help you shed pounds and adopt a healthier lifestyle.', 'weight loss, weight management, fitness, diet plans, fat loss, healthy lifestyle, weight reduction, nutrition programs', 1, 2, '2024-12-25 19:19:30', '2025-04-29 00:20:13'),
(20, 'Dental Care', 'dental-care', 'Comprehensive Dental Care Services', 'Access top-quality dental care services including cleanings, treatments, and cosmetic dentistry.', 'dental care, oral health, dentistry, teeth cleaning, cosmetic dentistry, dental treatments, oral hygiene, dentist services', 1, 2, '2024-12-25 19:19:45', '2025-04-29 00:20:13'),
(21, 'Smartphones & Accessories', 'smartphones-accessories', 'Top Smartphones & Premium Accessories', 'Discover the latest smartphones and premium accessories to enhance your mobile experience.', 'smartphones, mobile phones, accessories, mobile accessories, phone cases, phone chargers, smartphone gadgets, phone covers', 1, 3, '2024-12-25 19:20:00', '2025-04-29 00:20:13'),
(22, 'Laptops & Computers', 'laptops-computers', 'High-Performance Laptops & Computers', 'Explore high-performance laptops and computers designed for work, gaming, and creativity.', 'laptops, computers, personal computers, workstations, gaming laptops, desktops, PCs, computer accessories, tech devices', 1, 3, '2024-12-25 19:20:15', '2025-04-29 00:20:13'),
(23, 'Wearables', 'wearables', 'Wearable Tech: Smartwatches & More', 'Stay connected and track your health with the latest wearable tech including smartwatches and fitness bands.', 'wearables, smartwatches, fitness bands, health tracking, wearable technology, smart devices, activity trackers, smart bands', 1, 3, '2024-12-25 19:20:30', '2025-04-29 00:20:13'),
(24, 'Home Automation', 'home-automation', 'Smart Home Automation Solutions', 'Transform your home into a smart home with cutting-edge home automation devices and systems.', 'home automation, smart home, home devices, smart technology, home security, automation systems, smart lighting, IoT', 1, 3, '2024-12-25 19:20:45', '2025-04-29 00:20:13'),
(25, 'Audio Equipment', 'audio-equipment', 'Premium Audio Equipment (Headphones, Speakers)', 'Experience superior sound quality with premium headphones, speakers, and audio equipment.', 'audio equipment, headphones, speakers, sound systems, wireless audio, high fidelity, music gear, audio technology', 1, 3, '2024-12-25 19:21:00', '2025-04-29 00:20:13'),
(26, 'Cameras & Photography Gear', 'cameras-photography', 'Advanced Cameras & Photography Gear', 'Capture stunning photos and videos with the latest cameras, lenses, and photography gear.', 'cameras, photography, camera gear, lenses, photography equipment, DSLR, mirrorless cameras, photo accessories, video equipment', 1, 3, '2024-12-25 19:21:15', '2025-04-29 00:20:14'),
(27, 'Gaming Consoles & Accessories', 'gaming-consoles', 'Gaming Consoles & Ultimate Accessories', 'Enjoy the best gaming experience with top gaming consoles and a wide range of gaming accessories.', 'gaming consoles, gaming accessories, gaming gear, PlayStation, Xbox, gaming headsets, controllers, video games', 1, 3, '2024-12-25 19:21:30', '2025-04-29 00:20:14'),
(28, 'Software & Apps', 'software-apps', 'Essential Software & Mobile Apps', 'Find the best software and mobile apps to enhance productivity, creativity, and entertainment.', 'software, apps, productivity software, mobile apps, business apps, entertainment software, desktop apps, app development', 1, 3, '2024-12-25 19:21:45', '2025-04-29 00:20:14'),
(29, 'Virtual Reality', 'virtual-reality', 'Immersive Virtual Reality Experiences', 'Step into the future with immersive virtual reality technology for gaming, education, and more.', 'virtual reality, VR, immersive experiences, VR headsets, gaming, virtual worlds, VR technology, augmented reality, VR gaming', 1, 3, '2024-12-25 19:22:00', '2025-04-29 00:20:14'),
(30, 'Drones', 'drones', 'Cutting-Edge Drones for Photography & Adventure', 'Capture aerial footage and enjoy the thrill of drone flying with advanced drones and accessories.', 'drones, drone photography, aerial drones, quadcopters, drone accessories, drone cameras, flying drones, photography drones', 1, 3, '2024-12-25 19:22:15', '2025-04-29 00:20:14'),
(31, 'Hotels & Accommodations', 'hotels-accommodations', 'Explore Hotels and Accommodation Options', 'Find the best hotels and accommodations for your next trip, from budget options to luxury stays.', 'hotels, accommodations, travel stays, hotel booking, vacation rentals, luxury hotels, budget accommodations, travel lodging', 1, 4, '2024-12-25 19:22:30', '2025-04-29 00:20:14'),
(32, 'Airlines & Flights', 'airlines-flights', 'Book Flights with Leading Airlines', 'Browse flights from top airlines to find the best deals for your next trip.', 'airlines, flights, flight booking, cheap flights, airline tickets, travel flights, flight deals, air travel', 1, 4, '2024-12-25 19:22:45', '2025-04-29 00:20:14'),
(33, 'Tour Operators', 'tour-operators', 'Find Top Tour Operators for Your Vacation', 'Discover the best tour operators offering guided tours and vacation packages to popular destinations.', 'tour operators, guided tours, vacation packages, travel tours, holiday tours, tour companies, travel planning, adventure tours', 1, 4, '2024-12-25 19:23:00', '2025-04-29 00:20:14'),
(34, 'Cruises', 'cruises', 'Plan Your Dream Cruise Vacation', 'Book your next cruise vacation with top cruise lines offering a variety of destinations and experiences.', 'cruises, cruise lines, cruise vacations, vacation cruises, cruise deals, cruise ships, travel cruises, luxury cruises', 1, 4, '2024-12-25 19:23:15', '2025-04-29 00:20:14'),
(35, 'Car Rentals', 'car-rentals', 'Rent a Car for Your Next Adventure', 'Browse car rental options for your next trip, with a wide selection of vehicles to suit your needs.', 'car rentals, rental cars, car hire, vehicle rentals, car booking, car hire deals, travel car rentals, vacation rentals', 1, 4, '2024-12-25 19:23:30', '2025-04-29 00:20:14'),
(36, 'Adventure Travel', 'adventure-travel', 'Experience Thrilling Adventure Travel', 'Find adventure travel packages and tours for exciting outdoor activities and adrenaline-filled experiences.', 'adventure travel, outdoor adventures, travel experiences, adventure tours, thrill-seeking travel, adventure holidays, travel excursions, nature travel', 1, 4, '2024-12-25 19:23:45', '2025-04-29 00:20:14'),
(37, 'Travel Agencies', 'travel-agencies', 'Discover Travel Agencies for Your Next Trip', 'Find the best travel agencies offering personalized services, holiday packages, and travel planning.', 'travel agencies, travel planners, vacation packages, holiday tours, travel deals, personalized travel, travel services, trip planning', 3, 4, '2024-12-25 19:24:00', '2025-04-29 00:20:14'),
(38, 'Travel Gear & Accessories', 'travel-gear', 'Shop for Travel Gear and Accessories', 'Browse a wide range of travel gear and accessories, including luggage, travel bags, and safety essentials.', 'travel gear, travel accessories, luggage, travel bags, packing essentials, travel essentials, backpacks, travel organization', 1, 4, '2024-12-25 19:24:15', '2025-04-29 00:20:15'),
(39, 'Event Tickets', 'event-tickets', 'Find Event Tickets for Popular Shows and Activities', 'Get tickets for your favorite events, concerts, sports games, and more.', 'event tickets, concert tickets, sports tickets, theater tickets, event booking, entertainment tickets, live events, ticket sales', 1, 4, '2024-12-25 19:24:30', '2025-04-29 00:20:15'),
(40, 'Travel Guides & Resources', 'travel-guides', 'Access Travel Guides and Resources for Your Journey', 'Explore comprehensive travel guides and resources to help you plan your next trip.', 'travel guides, travel resources, destination guides, travel planning, vacation planning, travel tips, travel information, tourist resources', 1, 4, '2024-12-25 19:24:45', '2025-04-29 00:20:15'),
(41, 'Online Courses', 'online-courses', 'Explore a Wide Range of Online Courses', 'Explore a variety of online courses, from programming to digital marketing, designed to help you advance your skills and career.', 'online courses, e-learning, skill development, digital marketing, programming, online education, career growth, learning resources', 1, 5, '2024-12-25 19:25:00', '2025-04-29 00:20:15'),
(42, 'Tutoring Services', 'tutoring-services', 'Find Professional Tutoring Services', 'Find professional tutoring services for a range of subjects, helping students of all ages excel in their academic studies.', 'tutoring, academic tutoring, private lessons, online tutoring, educational services, math tutoring, science tutoring, language tutoring', 1, 5, '2024-12-25 19:25:15', '2025-04-29 00:20:15'),
(43, 'Language Learning', 'language-learning', 'Master a New Language with Ease', 'Browse language learning resources, from courses to apps, designed to help you master a new language.', 'language learning, language courses, language apps, learn new languages, bilingual, language skills, language practice, language education', 1, 5, '2024-12-25 19:25:30', '2025-04-29 00:20:15'),
(44, 'Test Preparation', 'test-preparation', 'Prepare for Standardized Tests Successfully', 'Get ready for standardized tests with preparation courses and materials, designed to improve your performance and boost your scores.', 'test preparation, standardized tests, exam prep, SAT, GRE, ACT, study resources, test practice', 1, 5, '2024-12-25 19:25:45', '2025-04-29 00:20:15'),
(45, 'Study Materials', 'study-materials', 'Shop for Essential Study Materials', 'Shop for study materials, including textbooks, practice tests, and study guides, to help you succeed in your academic journey.', 'study materials, textbooks, practice tests, study guides, academic resources, study tools, learning aids, exam preparation', 1, 5, '2024-12-25 19:26:00', '2025-04-29 00:20:15'),
(46, 'Academic Writing', 'academic-writing', 'Improve Your Writing Skills with Resources', 'Explore resources for academic writing, including guides, tools, and courses, to help you improve your writing skills.', 'academic writing, writing guides, writing tools, writing courses, academic papers, research writing, essay writing, writing skills', 1, 5, '2024-12-25 19:26:15', '2025-04-29 00:20:15'),
(47, 'E-Learning Platforms', 'elearning-platforms', 'Find the Best E-Learning Platforms', 'Discover e-learning platforms offering courses in various fields, from tech to business, to enhance your knowledge and career prospects.', 'e-learning platforms, online education, digital learning, learning platforms, online courses, professional development, skill building, distance learning', 1, 5, '2024-12-25 19:26:30', '2025-04-29 00:20:15'),
(48, 'Professional Development', 'professional-development', 'Advance Your Career with Professional Development', 'Find professional development resources, including courses and certifications, to help you advance in your career.', 'professional development, career advancement, job skills, certifications, career growth, skill development, leadership training, career success', 1, 5, '2024-12-25 19:26:45', '2025-04-29 00:20:15'),
(49, 'Certification Programs', 'certification-programs', 'Get Recognized with Certification Programs', 'Browse certification programs across various industries, designed to help you gain recognized credentials and enhance your professional skills.', 'certification programs, professional certifications, career certifications, skills development, industry certifications, job market, credential programs, training courses', 1, 5, '2024-12-25 19:27:00', '2025-04-29 00:20:15'),
(50, 'College & University', 'college-university', 'Discover Colleges and Universities for Education', 'Find information about colleges and universities, from admission requirements to degree programs, to help you choose the right institution for your education.', 'college, university, higher education, degree programs, university admissions, college search, academic institutions, student life', 1, 5, '2024-12-25 19:27:15', '2025-04-29 00:20:15'),
(51, 'Investment & Wealth Management', 'investment-wealth-management', 'Explore Investment and Wealth Management Services', 'Explore investment and wealth management services to help you grow and manage your financial portfolio.', 'investment, wealth management, financial planning, portfolio management, investments, retirement planning, asset management, financial advice', 1, 6, '2024-12-25 19:27:30', '2025-04-29 00:20:15'),
(52, 'Insurance Providers', 'insurance-providers', 'Compare Insurance Providers for Best Coverage', 'Compare insurance providers offering a wide range of coverage options, from health to life insurance, to protect your assets.', 'insurance, health insurance, life insurance, car insurance, insurance providers, auto insurance, home insurance, life coverage', 1, 6, '2024-12-25 19:27:45', '2025-04-29 00:20:16'),
(53, 'Financial Planning', 'financial-planning', 'Plan Your Finances with Expert Financial Planning', 'Find financial planning services to help you set goals, budget effectively, and secure your financial future.', 'financial planning, personal finance, budgeting, retirement planning, financial goals, financial security, investment advice, tax planning', 1, 6, '2024-12-25 19:28:00', '2025-04-29 00:20:16'),
(54, 'Tax Services', 'tax-services', 'Prepare Your Taxes with Professional Tax Services', 'Find tax services to help you prepare and file your taxes, with professional guidance to ensure you get the best return.', 'tax services, tax preparation, tax filing, income tax, tax returns, IRS, tax advice, tax help', 1, 6, '2024-12-25 19:28:15', '2025-04-29 00:20:16'),
(55, 'Loans & Mortgages', 'loans-mortgages', 'Explore Loans and Mortgages for Your Needs', 'Explore loan and mortgage options to help you finance your home, business, or personal projects with favorable terms.', 'loans, mortgages, home loans, business loans, personal loans, mortgage rates, financing options, loan terms', 1, 6, '2024-12-25 19:28:30', '2025-04-29 00:20:16'),
(56, 'Banking & Savings', 'banking-savings', 'Discover the Best Banking and Savings Options', 'Discover banking and savings options to help you manage your finances and earn interest on your savings.', 'banking, savings accounts, interest rates, financial institutions, savings plans, bank accounts, online banking, financial products', 1, 6, '2024-12-25 19:28:45', '2025-04-29 00:20:16'),
(57, 'Credit & Debt Services', 'credit-debt-services', 'Manage Your Credit and Debt with Effective Services', 'Find credit and debt services to help you manage your finances, repair your credit score, and reduce your debt.', 'credit services, debt services, credit repair, debt reduction, credit counseling, financial help, credit score, debt management', 1, 6, '2024-12-25 19:29:00', '2025-04-29 00:20:16'),
(58, 'Financial Software', 'financial-software', 'Browse Financial Software for Effective Management', 'Browse financial software designed to help you manage your money, investments, and taxes with ease.', 'financial software, budgeting software, investment software, accounting software, money management, personal finance, expense tracking, tax software', 1, 6, '2024-12-25 19:29:15', '2025-04-29 00:20:16'),
(59, 'Cryptocurrency', 'cryptocurrency', 'Explore Cryptocurrency Investment Opportunities', 'Learn about cryptocurrency investment and trading opportunities in the digital currency market.', 'cryptocurrency, digital currency, crypto investments, Bitcoin, Ethereum, cryptocurrency trading, blockchain, crypto market', 1, 6, '2024-12-25 19:29:30', '2025-04-29 00:20:16'),
(60, 'Retirement Planning', 'retirement-planning', 'Plan for Your Future with Retirement Planning Resources', 'Find retirement planning resources to help you secure your financial future and plan for life after work.', 'retirement planning, retirement savings, financial planning, pension plans, retirement funds, investment planning, retirement goals, financial security', 1, 6, '2024-12-25 19:29:45', '2025-04-29 00:20:16'),
(61, 'Restaurants & Dining', 'restaurants-dining', 'Explore Top Dining Spots', 'Find the best restaurants and dining options, from fine dining to casual eateries, serving a variety of cuisines.', 'restaurants, dining, food, restaurants near me, fine dining, casual dining, best restaurants', 2, 7, '2024-12-25 19:30:00', '2025-05-17 15:47:51'),
(62, 'Bars & Nightlife', 'bars-nightlife', 'Discover the Best Bars and Clubs', 'Explore bars, nightclubs, and nightlife hotspots for drinks, entertainment, and an unforgettable night out.', 'bars, nightlife, nightclubs, pubs, drinks, clubs, entertainment, best bars', 1, 7, '2024-12-25 19:30:15', '2025-04-29 00:20:16'),
(63, 'Cafes & Coffee Shops', 'cafes-coffee-shops', 'Best Spots for Coffee Lovers', 'Enjoy a cup of coffee or tea at cozy cafes and coffee shops offering unique blends, pastries, and relaxing environments.', 'cafes, coffee shops, coffee, tea, pastries, best cafes, coffee lovers', 1, 7, '2024-12-25 19:30:30', '2025-04-29 00:20:16'),
(64, 'Catering Services', 'catering-services', 'Professional Event Catering', 'Find top-rated catering services for your events, offering delicious menus for weddings, parties, corporate events, and more.', 'catering services, event catering, wedding catering, party catering, corporate catering, food catering', 1, 7, '2024-12-25 19:30:45', '2025-04-29 00:20:16'),
(65, 'Bakeries & Pastry', 'bakeries-pastry', 'Fresh Baked Goods and Desserts', 'Indulge in freshly baked goods, pastries, and desserts from local bakeries, perfect for any occasion.', 'bakeries, pastries, desserts, cakes, fresh baked goods, bakery items', 2, 7, '2024-12-25 19:31:00', '2025-05-01 23:32:38'),
(66, 'Food Delivery', 'food-delivery', 'Order Food Online for Delivery', 'Order food online from the best restaurants near you and enjoy fast delivery of your favorite meals.', 'food delivery, order food, food delivery services, restaurant delivery, online food order', 1, 7, '2024-12-25 19:31:15', '2025-04-29 00:20:16'),
(67, 'Vegan & Vegetarian', 'vegan-vegetarian', 'Healthy Plant-Based Dining', 'Explore vegan and vegetarian dining options, from plant-based restaurants to recipes and healthy eating guides.', 'vegan, vegetarian, plant-based, vegan restaurants, healthy eating, vegetarian meals', 1, 7, '2024-12-25 19:31:30', '2025-04-29 00:20:17'),
(68, 'Fast Food', 'fast-food', 'Quick Meals for Busy Lifestyles', 'Satisfy your hunger with fast food from top chains, offering burgers, fries, pizza, and more for a quick bite.', 'fast food, quick meals, burgers, pizza, fries, fast food restaurants', 1, 7, '2024-12-25 19:31:45', '2025-04-29 00:20:17'),
(69, 'Food Trucks', 'food-trucks', 'Gourmet Meals on the Go', 'Enjoy delicious meals from food trucks offering a wide range of cuisines, from tacos to gourmet sandwiches.', 'food trucks, gourmet food, street food, food truck meals, food trucks near me', 1, 7, '2024-12-25 19:32:00', '2025-04-29 00:20:17'),
(70, 'Wineries & Breweries', 'wineries-breweries', 'Taste the Best Wines and Beers', 'Visit wineries and breweries to sample the finest wines and craft beers, and learn about the production process.', 'wineries, breweries, wine tasting, craft beers, wineries near me, breweries near me', 1, 7, '2024-12-25 19:32:15', '2025-04-29 00:20:17'),
(71, 'Clothing & Apparel', 'clothing-apparel', 'Trendy Fashion for Every Style', 'Browse a wide selection of clothing and apparel for all occasions, including casual wear, formal wear, and accessories.', 'clothing, apparel, fashion, trendy fashion, clothing store, outfits', 1, 8, '2024-12-25 19:32:30', '2025-04-29 00:20:17'),
(72, 'Electronics & Gadgets', 'electronics-gadgets', 'Latest Tech and Innovations', 'Shop the latest electronics, gadgets, and tech products, from smartphones to wearables and home electronics.', 'electronics, gadgets, tech, smartphones, gadgets, tech products, latest electronics', 1, 8, '2024-12-25 19:32:45', '2025-04-29 00:20:17'),
(73, 'Home & Garden', 'home-garden', 'Decor, Furniture and Outdoor Living', 'Find everything for your home and garden, from furniture and decor to outdoor living essentials and gardening supplies.', 'home, garden, furniture, decor, outdoor living, gardening, home improvement', 1, 8, '2024-12-25 19:33:00', '2025-04-29 00:20:17'),
(74, 'Beauty & Personal Care', 'beauty-personal-care', 'Skincare, Haircare and More', 'Explore beauty and personal care products for skincare, haircare, makeup, and grooming for both men and women.', 'beauty, personal care, skincare, haircare, makeup, grooming products', 1, 8, '2024-12-25 19:33:15', '2025-04-29 00:20:17'),
(75, 'Jewelry & Watches', 'jewelry-watches', 'Luxury Accessories for Every Occasion', 'Find elegant jewelry and stylish watches to complement any outfit, including rings, necklaces, bracelets, and more.', 'jewelry, watches, luxury accessories, engagement rings, necklaces, bracelets', 1, 8, '2024-12-25 19:33:30', '2025-04-29 00:20:17'),
(76, 'Furniture', 'furniture', 'Stylish Furniture for Your Home', 'Shop for modern and stylish furniture for every room in your home, from sofas to dining tables and storage solutions.', 'furniture, home furniture, stylish furniture, living room furniture, bedroom furniture', 1, 8, '2024-12-25 19:33:45', '2025-04-29 00:20:17'),
(77, 'Sports & Outdoors', 'sports-outdoors', 'Gear for Adventure and Fitness', 'Find sports equipment, outdoor gear, and fitness accessories for hiking, biking, camping, and more.', 'sports, outdoors, gear, fitness, camping, hiking, outdoor adventure', 1, 8, '2024-12-25 19:34:00', '2025-04-29 00:20:17'),
(78, 'Toys & Games', 'toys-games', 'Fun for Kids and Adults', 'Shop for toys, games, and puzzles for children and adults, offering entertainment for all ages.', 'toys, games, puzzles, kids toys, board games, fun activities', 1, 8, '2024-12-25 19:34:15', '2025-04-29 00:20:17'),
(79, 'Health & Fitness', 'health-fitness', 'Wellness Products and Equipment', 'Browse health and fitness products, from gym equipment to supplements, for improving your well-being.', 'health, fitness, wellness, gym equipment, fitness supplements, healthy living', 1, 8, '2024-12-25 19:34:30', '2025-04-29 00:20:18'),
(80, 'Pet Supplies', 'pet-supplies', 'Everything for Your Pets', 'Shop for pet supplies, including food, toys, grooming products, and accessories for cats, dogs, and other pets.', 'pet supplies, pet food, pet grooming, pet toys, dog supplies, cat supplies', 1, 8, '2024-12-25 19:34:45', '2025-04-29 00:20:18'),
(81, 'Furniture', 'furniture', 'Shop for Stylish Furniture', 'Explore a wide range of furniture pieces for your living room, bedroom, office, and more, with stylish and functional designs.', 'furniture, home furniture, living room furniture, bedroom furniture, office furniture', 1, 9, '2024-12-25 19:35:00', '2025-04-29 00:20:18'),
(82, 'Home Decor', 'home-decor', 'Decorate Your Home with Elegance', 'Find beautiful home decor, from wall art to decorative accessories, to add charm and style to any room in your home.', 'home decor, decorative accessories, wall art, home accents, elegant decor', 1, 9, '2024-12-25 19:35:15', '2025-04-29 00:20:18'),
(83, 'Kitchenware', 'kitchenware', 'Essentials for the Modern Kitchen', 'Shop kitchenware, from cookware to utensils and gadgets, designed to help you cook with ease and efficiency.', 'kitchenware, cookware, utensils, kitchen gadgets, modern kitchen', 1, 9, '2024-12-25 19:35:30', '2025-04-29 00:20:18'),
(84, 'Lighting & Fixtures', 'lighting-fixtures', 'Brighten Your Space with Lighting', 'Browse a variety of lighting options, including fixtures, chandeliers, table lamps, and more to illuminate your home with style.', 'lighting, light fixtures, chandeliers, table lamps, home lighting', 1, 9, '2024-12-25 19:35:45', '2025-04-29 00:20:18'),
(85, 'Bedding & Linens', 'bedding-linens', 'Cozy Bedding and Linens for Comfort', 'Find soft, comfortable bedding and linens to create a peaceful and restful atmosphere in your bedroom.', 'bedding, linens, sheets, comforters, pillowcases, bed sets', 1, 9, '2024-12-25 19:36:00', '2025-04-29 00:20:18'),
(86, 'Storage & Organization', 'storage-organization', 'Organize Your Space with Storage Solutions', 'Explore storage and organization products, from shelves to bins, to help you keep your home tidy and clutter-free.', 'storage, organization, shelves, bins, home organization, storage solutions', 2, 9, '2024-12-25 19:36:15', '2025-04-29 00:20:18'),
(87, 'Appliances', 'appliances', 'Essential Appliances for Your Home', 'Shop for essential home appliances, from refrigerators to washers and dryers, that make everyday tasks easier and more efficient.', 'appliances, home appliances, refrigerators, washers, dryers, kitchen appliances', 1, 9, '2024-12-25 19:36:30', '2025-04-29 00:20:18'),
(88, 'Outdoor Furniture', 'outdoor-furniture', 'Comfortable Outdoor Furniture', 'Discover outdoor furniture designed for relaxation, including patio sets, lounge chairs, and dining furniture for your garden or balcony.', 'outdoor furniture, patio furniture, garden furniture, lounge chairs, outdoor seating', 1, 9, '2024-12-25 19:36:45', '2025-04-29 00:20:18'),
(89, 'Gardening & Landscaping', 'gardening-landscaping', 'Gardening Tools and Supplies', 'Find gardening and landscaping tools, plants, and accessories to beautify your outdoor spaces and grow your own garden.', 'gardening, landscaping, plants, garden tools, outdoor spaces, gardening supplies', 1, 9, '2024-12-25 19:37:00', '2025-04-29 00:20:18'),
(90, 'Home Improvement', 'home-improvement', 'Home Improvement Products', 'Shop for home improvement essentials, from DIY tools to materials, to enhance and upgrade your living space.', 'home improvement, DIY, home renovation, tools, materials, home upgrade', 1, 9, '2024-12-25 19:37:15', '2025-04-29 00:20:18'),
(91, 'Car Dealerships', 'car-dealerships', 'Find Your Ideal Car Dealership', 'Browse car dealerships to find your next vehicle, from new models to certified pre-owned options with great deals.', 'car dealerships, car buying, new cars, pre-owned cars, vehicle sales', 1, 10, '2024-12-25 19:37:30', '2025-04-29 00:20:19'),
(92, 'Car Accessories', 'car-accessories', 'Shop for Car Accessories', 'Browse a wide selection of car accessories to enhance your vehicle, from interior gadgets to exterior upgrades.', 'car accessories, vehicle accessories, car gadgets, car upgrades, interior accessories', 1, 10, '2024-12-25 19:37:45', '2025-04-29 00:20:19'),
(93, 'Auto Repair & Maintenance', 'auto-repair-maintenance', 'Expert Auto Repair and Maintenance', 'Find trusted auto repair and maintenance services to keep your car running smoothly, from oil changes to major repairs.', 'auto repair, car maintenance, car repairs, vehicle service, oil change', 1, 10, '2024-12-25 19:38:00', '2025-04-29 00:20:19'),
(94, 'Motorcycle Dealerships', 'motorcycle-dealerships', 'Shop for New Motorcycles', 'Explore motorcycle dealerships offering new and used motorcycles, from cruisers to sport bikes, for every rider.', 'motorcycle dealerships, motorcycles, new motorcycles, used motorcycles, motorbikes', 1, 10, '2024-12-25 19:38:15', '2025-04-29 00:20:19'),
(95, 'Tires & Wheels', 'tires-wheels', 'Find Tires and Wheels for Your Vehicle', 'Shop for high-quality tires and wheels for your vehicle, offering durability, style, and performance.', 'tires, wheels, vehicle tires, car wheels, tire replacement', 1, 10, '2024-12-25 19:38:30', '2025-04-29 00:20:19'),
(96, 'Vehicle Rentals', 'vehicle-rentals', 'Rent a Vehicle for Your Travels', 'Find vehicle rentals, from cars to SUVs and vans, for your next trip, providing flexibility and convenience on the go.', 'vehicle rentals, car rental, SUV rental, van rental, rental cars', 1, 10, '2024-12-25 19:38:45', '2025-04-29 00:20:19'),
(97, 'Electric Vehicles', 'electric-vehicles', 'Electric Vehicles for the Future', 'Explore electric vehicles, from sedans to SUVs, offering eco-friendly options with advanced technology and great performance.', 'electric vehicles, EV, electric cars, eco-friendly cars, electric SUVs', 1, 10, '2024-12-25 19:39:00', '2025-04-29 00:20:19'),
(98, 'Car Insurance', 'car-insurance', 'Affordable Car Insurance Plans', 'Compare car insurance plans for affordable rates and coverage, helping you find the best deal for your vehicle.', 'car insurance, auto insurance, vehicle insurance, insurance plans, affordable car insurance', 1, 10, '2024-12-25 19:39:15', '2025-04-29 00:20:19'),
(99, 'Auto Financing', 'auto-financing', 'Easy Auto Financing Solutions', 'Find auto financing options, including loans and leases, to help you purchase your next car with ease.', 'auto financing, car loans, vehicle financing, car leases, financing options', 1, 10, '2024-12-25 19:39:30', '2025-04-29 00:20:19'),
(100, 'Vehicle Parts & Supplies', 'vehicle-parts-supplies', 'Car Parts and Supplies for Your Vehicle', 'Shop for car parts and supplies, from engine components to accessories, to keep your vehicle in top condition.', 'car parts, vehicle parts, auto supplies, engine parts, car accessories', 1, 10, '2024-12-25 19:39:45', '2025-04-29 00:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_categories`
--

CREATE TABLE `sub_sub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `sub_category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_sub_categories`
--

INSERT INTO `sub_sub_categories` (`id`, `name`, `slug`, `title`, `description`, `keywords`, `views`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(1, 'Digital Marketing', 'digital-marketing', 'Mastering Digital Marketing Strategies', 'Learn the latest digital marketing techniques, including SEO, PPC, and social media marketing, to grow your online presence.', 'digital marketing, SEO, PPC, social media, online ads', 0, 1, '2025-03-08 23:18:34', '2025-03-08 23:48:31'),
(2, 'Content Marketing', 'content-marketing', 'Creating Engaging Content for Your Audience', 'Discover how to create compelling content that resonates with your audience and drives engagement.', 'content marketing, blogging, storytelling, content creation, audience engagement', 0, 1, '2025-03-08 23:18:34', '2025-03-08 23:48:31'),
(3, 'Social Media Marketing', 'social-media-marketing', 'Maximizing Social Media for Business Growth', 'Leverage social media platforms to build brand awareness and connect with your target audience.', 'social media marketing, Facebook, Instagram, LinkedIn, Twitter', 0, 1, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(4, 'Email Marketing', 'email-marketing', 'Effective Email Marketing Campaigns', 'Learn how to design and execute email marketing campaigns that convert leads into customers.', 'email marketing, newsletters, email campaigns, lead generation, automation', 0, 1, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(5, 'Branding & Identity', 'branding-identity', 'Building a Strong Brand Identity', 'Develop a unique brand identity that sets your business apart and resonates with your audience.', 'branding, brand identity, logo design, brand strategy, visual identity', 0, 1, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(6, 'Software Development', 'software-development', 'Custom Software Solutions for Your Business', 'Get tailored software development services to meet your business needs and streamline operations.', 'software development, custom software, app development, programming, coding', 0, 2, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(7, 'Cybersecurity', 'cybersecurity', 'Protecting Your Business from Cyber Threats', 'Implement robust cybersecurity measures to safeguard your data and systems from cyberattacks.', 'cybersecurity, data protection, network security, cyber threats, IT security', 0, 2, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(8, 'Cloud Computing', 'cloud-computing', 'Scalable Cloud Solutions for Businesses', 'Explore cloud computing services that offer flexibility, scalability, and cost-efficiency for your business.', 'cloud computing, cloud services, AWS, Azure, Google Cloud', 0, 2, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(9, 'IT Support', 'it-support', 'Reliable IT Support for Your Business', 'Access 24/7 IT support services to ensure your systems run smoothly and efficiently.', 'IT support, tech support, helpdesk, IT maintenance, troubleshooting', 0, 2, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(10, 'Data Analytics', 'data-analytics', 'Harnessing Data for Business Insights', 'Use data analytics to make informed decisions and drive business growth.', 'data analytics, big data, business intelligence, data visualization, data mining', 0, 2, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(11, 'Business Strategy', 'business-strategy', 'Developing Winning Business Strategies', 'Get expert advice on creating business strategies that drive growth and profitability.', 'business strategy, strategic planning, market analysis, competitive advantage, business growth', 0, 3, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(12, 'Financial Consulting', 'financial-consulting', 'Optimizing Your Financial Performance', 'Receive guidance on financial planning, budgeting, and investment strategies for your business.', 'financial consulting, financial planning, budgeting, investments, financial analysis', 0, 3, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(13, 'Management Consulting', 'management-consulting', 'Improving Organizational Efficiency', 'Enhance your business operations and management practices with expert consulting services.', 'management consulting, operational efficiency, leadership, organizational development, process improvement', 0, 3, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(14, 'Marketing Consulting', 'marketing-consulting', 'Expert Advice for Marketing Success', 'Get tailored marketing consulting services to boost your brand and reach your target audience.', 'marketing consulting, brand strategy, market research, advertising, customer engagement', 0, 3, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(15, 'HR Consulting', 'hr-consulting', 'Streamlining Your Human Resources', 'Optimize your HR processes with expert consulting services for recruitment, training, and employee management.', 'HR consulting, recruitment, employee training, HR management, workforce planning', 0, 3, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(16, 'Talent Acquisition', 'talent-acquisition', 'Finding the Best Talent for Your Business', 'Discover effective strategies for recruiting top talent to meet your business needs.', 'talent acquisition, recruitment, hiring, talent management, workforce planning', 0, 4, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(17, 'Employee Training', 'employee-training', 'Enhancing Skills Through Training Programs', 'Invest in employee training programs to improve skills and productivity.', 'employee training, skill development, workforce training, professional development, training programs', 0, 4, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(18, 'Performance Management', 'performance-management', 'Optimizing Employee Performance', 'Implement performance management systems to track and improve employee productivity.', 'performance management, employee evaluation, productivity, performance reviews, goal setting', 0, 4, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(19, 'HR Technology', 'hr-technology', 'Leveraging Technology for HR Efficiency', 'Explore HR technology solutions to streamline recruitment, payroll, and employee management.', 'HR technology, HR software, payroll systems, recruitment tools, workforce management', 0, 4, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(20, 'Workplace Diversity', 'workplace-diversity', 'Promoting Diversity and Inclusion', 'Create a diverse and inclusive workplace to foster innovation and employee satisfaction.', 'workplace diversity, inclusion, diversity programs, equal opportunity, cultural diversity', 0, 4, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(21, 'Corporate Law', 'corporate-law', 'Expert Legal Advice for Businesses', 'Get legal guidance on corporate matters, including contracts, mergers, and compliance.', 'corporate law, business law, contracts, mergers, compliance', 0, 5, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(22, 'Intellectual Property', 'intellectual-property', 'Protecting Your Intellectual Property', 'Safeguard your patents, trademarks, and copyrights with expert legal services.', 'intellectual property, patents, trademarks, copyrights, IP law', 0, 5, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(23, 'Litigation', 'litigation', 'Resolving Disputes Through Litigation', 'Access professional litigation services to resolve legal disputes effectively.', 'litigation, legal disputes, court cases, dispute resolution, legal representation', 0, 5, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(24, 'Employment Law', 'employment-law', 'Navigating Employment Legal Matters', 'Get legal advice on employment contracts, workplace policies, and labor laws.', 'employment law, labor laws, workplace policies, employment contracts, employee rights', 0, 5, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(25, 'Real Estate Law', 'real-estate-law', 'Legal Services for Real Estate Transactions', 'Ensure smooth real estate transactions with expert legal guidance.', 'real estate law, property law, real estate transactions, legal contracts, property rights', 0, 5, '2025-03-08 23:18:34', '2025-03-08 23:48:29'),
(26, 'Tax Preparation', 'tax-preparation', 'Expert Tax Preparation Services', 'Get professional tax preparation services to ensure compliance and maximize your returns.', 'tax preparation, tax filing, tax returns, tax compliance, tax planning', 0, 6, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(27, 'Payroll Management', 'payroll-management', 'Efficient Payroll Management Solutions', 'Streamline your payroll processes with accurate and timely payroll management services.', 'payroll management, payroll processing, employee payroll, payroll taxes, payroll software', 0, 6, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(28, 'Financial Reporting', 'financial-reporting', 'Accurate Financial Reporting for Businesses', 'Access detailed financial reports to make informed business decisions and track performance.', 'financial reporting, financial statements, balance sheets, income statements, cash flow', 0, 6, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(29, 'Bookkeeping Services', 'bookkeeping-services', 'Reliable Bookkeeping for Your Business', 'Keep your financial records organized and up-to-date with professional bookkeeping services.', 'bookkeeping, financial records, accounting services, ledger management, expense tracking', 0, 6, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(30, 'Audit & Assurance', 'audit-assurance', 'Comprehensive Audit and Assurance Services', 'Ensure financial transparency and compliance with expert audit and assurance services.', 'audit services, financial audits, compliance, assurance, internal audits', 0, 6, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(31, 'Logo Design', 'logo-design', 'Creative Logo Design Services', 'Get unique and memorable logo designs that represent your brand identity.', 'logo design, branding, brand identity, graphic design, creative logos', 0, 7, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(32, 'Print Design', 'print-design', 'Professional Print Design Solutions', 'Design stunning print materials, including brochures, flyers, and business cards.', 'print design, brochures, flyers, business cards, graphic design', 0, 7, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(33, 'Web Design', 'web-design', 'Modern Web Design for Your Business', 'Create visually appealing and user-friendly websites with expert web design services.', 'web design, website design, UI/UX design, responsive design, graphic design', 0, 7, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(34, 'Branding & Identity', 'branding-identity', 'Building a Strong Brand Identity', 'Develop a cohesive brand identity with custom designs and visual elements.', 'branding, brand identity, visual design, graphic design, brand strategy', 0, 7, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(35, 'Illustration', 'illustration', 'Custom Illustrations for Your Projects', 'Get custom illustrations tailored to your creative needs and branding.', 'illustration, custom art, graphic design, digital art, creative illustrations', 0, 7, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(36, 'Document Translation', 'document-translation', 'Accurate Document Translation Services', 'Translate your documents with precision and professionalism for global audiences.', 'document translation, multilingual content, legal translation, business translation, certified translation', 0, 8, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(37, 'Website Localization', 'website-localization', 'Localize Your Website for Global Reach', 'Adapt your website content to different languages and cultures for international audiences.', 'website localization, multilingual websites, cultural adaptation, global expansion, translation services', 0, 8, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(38, 'Legal Translation', 'legal-translation', 'Expert Legal Translation Services', 'Get accurate translations for legal documents, contracts, and agreements.', 'legal translation, contracts, legal documents, certified translation, multilingual legal', 0, 8, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(39, 'Multilingual SEO', 'multilingual-seo', 'Optimize Your Content for Global Search Engines', 'Improve your website’s visibility in multiple languages with multilingual SEO services.', 'multilingual SEO, global SEO, search engine optimization, translation services, localization', 0, 8, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(40, 'Cultural Adaptation', 'cultural-adaptation', 'Adapting Content for Cultural Relevance', 'Ensure your content resonates with local audiences through cultural adaptation services.', 'cultural adaptation, localization, translation services, global marketing, cultural relevance', 0, 8, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(41, 'Corporate Events', 'corporate-events', 'Professional Corporate Event Planning', 'Plan and execute successful corporate events, from conferences to team-building activities.', 'corporate events, event planning, conferences, team-building, business events', 0, 9, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(42, 'Wedding Planning', 'wedding-planning', 'Memorable Wedding Planning Services', 'Create unforgettable weddings with expert planning and coordination services.', 'wedding planning, weddings, event coordination, bridal services, wedding venues', 0, 9, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(43, 'Party Planning', 'party-planning', 'Fun and Creative Party Planning', 'Organize memorable parties and celebrations with professional planning services.', 'party planning, celebrations, birthday parties, event coordination, party themes', 0, 9, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(44, 'Event Coordination', 'event-coordination', 'Seamless Event Coordination Services', 'Ensure your events run smoothly with expert coordination and management.', 'event coordination, event management, logistics, event planning, on-site coordination', 0, 9, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(45, 'Venue Selection', 'venue-selection', 'Find the Perfect Venue for Your Event', 'Discover the ideal venues for your events, from weddings to corporate gatherings.', 'venue selection, event venues, wedding venues, conference centers, party locations', 0, 9, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(46, 'Administrative Support', 'administrative-support', 'Efficient Administrative Assistance', 'Get reliable administrative support to manage your daily tasks and operations.', 'administrative support, virtual assistant, task management, scheduling, email management', 0, 10, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(47, 'Social Media Management', 'social-media-management', 'Expert Social Media Assistance', 'Manage your social media accounts and grow your online presence with virtual assistance.', 'social media management, virtual assistant, content scheduling, social media strategy, online presence', 0, 10, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(48, 'Customer Support', 'customer-support', 'Professional Customer Support Services', 'Provide excellent customer service with virtual assistance for inquiries and support.', 'customer support, virtual assistant, customer service, helpdesk, client support', 0, 10, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(49, 'Data Entry', 'data-entry', 'Accurate Data Entry Services', 'Outsource your data entry tasks to skilled virtual assistants for efficiency.', 'data entry, virtual assistant, data management, data processing, administrative tasks', 0, 10, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(50, 'Project Management', 'project-management', 'Virtual Project Management Assistance', 'Streamline your projects with virtual assistance for planning, coordination, and execution.', 'project management, virtual assistant, task coordination, project planning, workflow management', 0, 10, '2025-03-08 23:21:05', '2025-03-08 23:48:29'),
(51, 'Personal Training', 'personal-training', 'Customized Personal Training Programs', 'Achieve your fitness goals with one-on-one personal training tailored to your needs.', 'personal training, fitness coach, workout plans, strength training, weight loss', 0, 11, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(52, 'Group Fitness Classes', 'group-fitness-classes', 'Fun and Effective Group Workouts', 'Join group fitness classes for a motivating and social workout experience.', 'group fitness, fitness classes, workout groups, cardio, yoga, HIIT', 0, 11, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(53, 'Strength Training', 'strength-training', 'Build Muscle and Strength', 'Learn proper techniques and programs for effective strength training.', 'strength training, weightlifting, muscle building, resistance training, fitness goals', 0, 11, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(54, 'Weight Loss Programs', 'weight-loss-programs', 'Tailored Weight Loss Plans', 'Get personalized weight loss programs to help you achieve your goals.', 'weight loss, fat loss, fitness plans, diet and exercise, healthy lifestyle', 0, 11, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(55, 'Fitness Coaching', 'fitness-coaching', 'Expert Guidance for Your Fitness Journey', 'Receive professional coaching to stay motivated and on track with your fitness goals.', 'fitness coaching, personal trainer, workout plans, fitness motivation, goal setting', 0, 11, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(56, 'Meal Planning', 'meal-planning', 'Customized Meal Plans for Your Diet', 'Get personalized meal plans to support your nutrition and health goals.', 'meal planning, diet plans, healthy eating, nutrition, meal prep', 0, 12, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(57, 'Weight Management', 'weight-management', 'Effective Weight Management Strategies', 'Learn how to manage your weight through balanced nutrition and lifestyle changes.', 'weight management, healthy eating, diet plans, nutrition, weight loss', 0, 12, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(58, 'Sports Nutrition', 'sports-nutrition', 'Fuel Your Performance with Proper Nutrition', 'Optimize your athletic performance with expert sports nutrition advice.', 'sports nutrition, athletic performance, fitness nutrition, supplements, recovery', 0, 12, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(59, 'Dietary Advice', 'dietary-advice', 'Expert Guidance on Healthy Eating', 'Receive professional advice on maintaining a balanced and healthy diet.', 'dietary advice, nutritionist, healthy eating, balanced diet, food choices', 0, 12, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(60, 'Nutritional Counseling', 'nutritional-counseling', 'Personalized Nutrition Counseling', 'Get one-on-one counseling to improve your diet and overall health.', 'nutritional counseling, dietitian, nutrition advice, health coaching, wellness', 0, 12, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(61, 'Counseling Services', 'counseling-services', 'Professional Counseling for Mental Wellness', 'Access expert counseling services to support your mental and emotional health.', 'counseling, therapy, mental wellness, emotional support, stress management', 0, 13, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(62, 'Stress Management', 'stress-management', 'Effective Stress Management Techniques', 'Learn strategies to manage stress and improve your overall well-being.', 'stress management, relaxation, mindfulness, coping strategies, mental health', 0, 13, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(63, 'Depression Treatment', 'depression-treatment', 'Comprehensive Depression Support', 'Find professional treatment and support for managing depression.', 'depression treatment, mental health, therapy, counseling, emotional support', 0, 13, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(64, 'Anxiety Relief', 'anxiety-relief', 'Solutions for Managing Anxiety', 'Discover techniques and therapies to reduce anxiety and improve mental health.', 'anxiety relief, stress reduction, mindfulness, therapy, mental wellness', 0, 13, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(65, 'Mental Health Workshops', 'mental-health-workshops', 'Educational Workshops for Mental Wellness', 'Participate in workshops to learn about mental health and self-care practices.', 'mental health workshops, wellness education, self-care, mental health resources, emotional well-being', 0, 13, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(66, 'Primary Care Physicians', 'primary-care-physicians', 'Comprehensive Primary Care Services', 'Access trusted primary care physicians for your general health needs.', 'primary care, family doctors, general practitioners, health checkups, medical care', 0, 14, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(67, 'Specialist Consultations', 'specialist-consultations', 'Expert Consultations for Specialized Care', 'Connect with specialists for advanced medical treatments and advice.', 'specialist consultations, medical specialists, healthcare providers, advanced care, treatment plans', 0, 14, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(68, 'Telemedicine Services', 'telemedicine-services', 'Convenient Healthcare Through Telemedicine', 'Get medical consultations and advice from the comfort of your home.', 'telemedicine, online consultations, virtual healthcare, remote medical care, telehealth', 0, 14, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(69, 'Health Checkups', 'health-checkups', 'Routine Health Checkups and Screenings', 'Stay on top of your health with regular checkups and preventive care.', 'health checkups, medical screenings, preventive care, wellness exams, routine tests', 0, 14, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(70, 'Emergency Care', 'emergency-care', '24/7 Emergency Medical Services', 'Access immediate medical care for emergencies and urgent health issues.', 'emergency care, urgent care, medical emergencies, 24/7 healthcare, emergency services', 0, 14, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(71, 'Vitamins & Minerals', 'vitamins-minerals', 'Essential Vitamins and Minerals for Health', 'Boost your health with high-quality vitamins and mineral supplements.', 'vitamins, minerals, dietary supplements, health supplements, wellness products', 0, 15, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(72, 'Protein Supplements', 'protein-supplements', 'High-Quality Protein for Fitness', 'Support your fitness goals with premium protein supplements.', 'protein supplements, fitness nutrition, muscle building, recovery, whey protein', 0, 15, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(73, 'Herbal Supplements', 'herbal-supplements', 'Natural Herbal Supplements for Wellness', 'Enhance your health with natural herbal supplements and remedies.', 'herbal supplements, natural remedies, wellness products, herbal medicine, health supplements', 0, 15, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(74, 'Immune Support', 'immune-support', 'Supplements to Boost Your Immune System', 'Strengthen your immune system with high-quality supplements.', 'immune support, immune boosters, vitamins, wellness products, health supplements', 0, 15, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(75, 'Energy Boosters', 'energy-boosters', 'Supplements for Increased Energy', 'Stay energized and active with effective energy-boosting supplements.', 'energy boosters, energy supplements, wellness products, health supplements, vitality', 0, 15, '2025-03-08 23:22:46', '2025-03-08 23:48:29'),
(76, 'Relaxation Massage', 'relaxation-massage', 'Relaxing Massage for Stress Relief', 'Unwind with a soothing relaxation massage designed to reduce stress and tension.', 'relaxation massage, stress relief, spa treatments, relaxation therapy, wellness', 0, 16, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(77, 'Aromatherapy', 'aromatherapy', 'Healing Through Aromatherapy', 'Experience the benefits of essential oils and aromatherapy for relaxation and rejuvenation.', 'aromatherapy, essential oils, relaxation, spa treatments, wellness', 0, 16, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(78, 'Deep Tissue Massage', 'deep-tissue-massage', 'Targeted Deep Tissue Therapy', 'Relieve muscle tension and pain with deep tissue massage techniques.', 'deep tissue massage, muscle relief, pain management, spa treatments, wellness', 0, 16, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(79, 'Spa Packages', 'spa-packages', 'Luxurious Spa Packages', 'Indulge in curated spa packages for a complete relaxation experience.', 'spa packages, luxury spa, relaxation, wellness, spa treatments', 0, 16, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(80, 'Hot Stone Therapy', 'hot-stone-therapy', 'Relaxing Hot Stone Massage', 'Enjoy the soothing effects of hot stone therapy for deep relaxation.', 'hot stone therapy, spa treatments, relaxation, wellness, massage therapy', 0, 16, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(81, 'Hatha Yoga', 'hatha-yoga', 'Beginner-Friendly Hatha Yoga', 'Learn the basics of yoga with Hatha Yoga, perfect for beginners.', 'hatha yoga, beginner yoga, yoga practice, mindfulness, relaxation', 0, 17, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(82, 'Meditation Sessions', 'meditation-sessions', 'Guided Meditation for Mindfulness', 'Join guided meditation sessions to improve mental clarity and reduce stress.', 'meditation, mindfulness, guided meditation, stress relief, mental clarity', 0, 17, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(83, 'Vinyasa Flow', 'vinyasa-flow', 'Dynamic Vinyasa Yoga', 'Experience the flow of Vinyasa Yoga for strength and flexibility.', 'vinyasa yoga, yoga flow, dynamic yoga, fitness, mindfulness', 0, 17, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(84, 'Yoga Retreats', 'yoga-retreats', 'Relaxing Yoga Retreats', 'Escape to rejuvenating yoga retreats for a holistic wellness experience.', 'yoga retreats, wellness retreats, relaxation, mindfulness, yoga practice', 0, 17, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(85, 'Prenatal Yoga', 'prenatal-yoga', 'Gentle Yoga for Expecting Mothers', 'Stay active and relaxed with prenatal yoga designed for expecting mothers.', 'prenatal yoga, pregnancy yoga, gentle yoga, wellness, relaxation', 0, 17, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(86, 'Acupuncture', 'acupuncture', 'Healing Through Acupuncture', 'Explore the benefits of acupuncture for pain relief and overall wellness.', 'acupuncture, alternative medicine, pain relief, holistic health, wellness', 0, 18, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(87, 'Herbal Remedies', 'herbal-remedies', 'Natural Herbal Solutions', 'Discover the power of herbal remedies for health and healing.', 'herbal remedies, natural healing, alternative medicine, wellness, holistic health', 0, 18, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(88, 'Chiropractic Care', 'chiropractic-care', 'Spinal Health with Chiropractic Care', 'Improve your spinal health and overall well-being with chiropractic treatments.', 'chiropractic care, spinal health, alternative medicine, pain relief, wellness', 0, 18, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(89, 'Homeopathy', 'homeopathy', 'Natural Healing with Homeopathy', 'Explore homeopathic treatments for a holistic approach to health.', 'homeopathy, alternative medicine, natural healing, wellness, holistic health', 0, 18, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(90, 'Reiki Healing', 'reiki-healing', 'Energy Healing with Reiki', 'Experience the calming effects of Reiki for emotional and physical healing.', 'reiki healing, energy healing, alternative medicine, relaxation, wellness', 0, 18, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(91, 'Personalized Diet Plans', 'personalized-diet-plans', 'Customized Weight Loss Diets', 'Get personalized diet plans tailored to your weight loss goals.', 'diet plans, weight loss, personalized diets, nutrition, healthy eating', 0, 19, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(92, 'Fitness for Weight Loss', 'fitness-weight-loss', 'Exercise Programs for Weight Loss', 'Join fitness programs designed to help you lose weight and stay healthy.', 'fitness, weight loss, exercise programs, fat loss, healthy lifestyle', 0, 19, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(93, 'Meal Replacement Plans', 'meal-replacement-plans', 'Convenient Meal Replacement Solutions', 'Explore meal replacement options for effective weight management.', 'meal replacements, weight loss, nutrition, healthy eating, diet plans', 0, 19, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(94, 'Weight Loss Coaching', 'weight-loss-coaching', 'Expert Guidance for Weight Loss', 'Receive professional coaching to achieve your weight loss goals.', 'weight loss coaching, fitness coaching, diet advice, motivation, healthy lifestyle', 0, 19, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(95, 'Healthy Lifestyle Programs', 'healthy-lifestyle-programs', 'Sustainable Weight Loss Solutions', 'Adopt a healthy lifestyle with programs designed for long-term weight management.', 'healthy lifestyle, weight loss, wellness, fitness, nutrition', 0, 19, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(96, 'Teeth Cleaning', 'teeth-cleaning', 'Professional Teeth Cleaning Services', 'Maintain oral health with professional teeth cleaning and checkups.', 'teeth cleaning, dental care, oral hygiene, dental checkups, preventive care', 0, 20, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(97, 'Cosmetic Dentistry', 'cosmetic-dentistry', 'Enhance Your Smile with Cosmetic Dentistry', 'Transform your smile with cosmetic dental treatments like whitening and veneers.', 'cosmetic dentistry, teeth whitening, veneers, smile makeover, dental care', 0, 20, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(98, 'Orthodontics', 'orthodontics', 'Straighten Your Teeth with Orthodontics', 'Correct misaligned teeth with braces and other orthodontic treatments.', 'orthodontics, braces, teeth alignment, dental care, smile correction', 0, 20, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(99, 'Dental Implants', 'dental-implants', 'Restore Your Smile with Dental Implants', 'Replace missing teeth with durable and natural-looking dental implants.', 'dental implants, tooth replacement, dental care, restorative dentistry, oral health', 0, 20, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(100, 'Emergency Dental Care', 'emergency-dental-care', 'Immediate Dental Care for Emergencies', 'Get prompt treatment for dental emergencies like toothaches and injuries.', 'emergency dental care, toothache, dental injuries, urgent care, dental services', 0, 20, '2025-03-08 23:24:11', '2025-03-08 23:48:29'),
(101, 'Latest Smartphones', 'latest-smartphones', 'Explore the Newest Smartphone Models', 'Discover the latest smartphone models with cutting-edge features and technology.', 'smartphones, mobile phones, latest phones, tech gadgets, phone reviews', 0, 21, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(102, 'Phone Cases & Covers', 'phone-cases-covers', 'Protect Your Phone with Stylish Cases', 'Find durable and stylish phone cases and covers for all smartphone models.', 'phone cases, phone covers, smartphone accessories, phone protection, mobile accessories', 0, 21, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(103, 'Chargers & Cables', 'chargers-cables', 'High-Quality Chargers and Cables', 'Keep your devices powered with reliable chargers and cables.', 'chargers, cables, phone accessories, mobile chargers, USB cables', 0, 21, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(104, 'Screen Protectors', 'screen-protectors', 'Protect Your Phone Screen', 'Prevent scratches and cracks with high-quality screen protectors.', 'screen protectors, phone accessories, mobile protection, tempered glass, phone screens', 0, 21, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(105, 'Smartphone Gadgets', 'smartphone-gadgets', 'Enhance Your Mobile Experience', 'Explore innovative smartphone gadgets for added functionality.', 'smartphone gadgets, mobile accessories, tech gadgets, phone tools, mobile enhancements', 0, 21, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(106, 'Gaming Laptops', 'gaming-laptops', 'High-Performance Gaming Laptops', 'Discover powerful gaming laptops for an immersive gaming experience.', 'gaming laptops, gaming PCs, high-performance laptops, gaming tech, gaming gear', 0, 22, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(107, 'Business Laptops', 'business-laptops', 'Reliable Laptops for Professionals', 'Find laptops designed for productivity and business efficiency.', 'business laptops, work laptops, professional laptops, productivity, office laptops', 0, 22, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(108, 'Desktop Computers', 'desktop-computers', 'Powerful Desktop Computers', 'Explore high-performance desktop computers for work and gaming.', 'desktop computers, PCs, workstations, gaming desktops, computer systems', 0, 22, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(109, 'Computer Accessories', 'computer-accessories', 'Essential Accessories for Your Computer', 'Enhance your setup with keyboards, mice, monitors, and more.', 'computer accessories, keyboards, mice, monitors, tech gadgets', 0, 22, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(110, 'Laptop Bags & Cases', 'laptop-bags-cases', 'Protect Your Laptop in Style', 'Find durable and stylish bags and cases for your laptop.', 'laptop bags, laptop cases, laptop protection, tech accessories, laptop gear', 0, 22, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(111, 'Smartwatches', 'smartwatches', 'Stay Connected with Smartwatches', 'Explore the latest smartwatches for fitness tracking and notifications.', 'smartwatches, wearable tech, fitness tracking, smart devices, health monitoring', 0, 23, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(112, 'Fitness Bands', 'fitness-bands', 'Track Your Health with Fitness Bands', 'Monitor your activity and health with advanced fitness bands.', 'fitness bands, activity trackers, health monitoring, wearable tech, fitness gadgets', 0, 23, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(113, 'Smart Glasses', 'smart-glasses', 'Innovative Smart Glasses', 'Experience augmented reality and smart features with smart glasses.', 'smart glasses, wearable tech, augmented reality, smart devices, tech gadgets', 0, 23, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(114, 'Wearable Cameras', 'wearable-cameras', 'Capture Life with Wearable Cameras', 'Record your adventures with compact and wearable cameras.', 'wearable cameras, action cameras, recording devices, tech gadgets, wearable tech', 0, 23, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(115, 'Health Trackers', 'health-trackers', 'Monitor Your Health with Wearables', 'Track your heart rate, sleep, and more with advanced health trackers.', 'health trackers, wearable tech, fitness tracking, health monitoring, smart devices', 0, 23, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(116, 'Smart Lighting', 'smart-lighting', 'Control Your Lights with Smart Technology', 'Transform your home with smart lighting solutions.', 'smart lighting, home automation, smart home, lighting control, IoT', 0, 24, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(117, 'Home Security Systems', 'home-security-systems', 'Secure Your Home with Smart Security', 'Protect your home with advanced smart security systems.', 'home security, smart security, surveillance, home automation, IoT', 0, 24, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(118, 'Smart Thermostats', 'smart-thermostats', 'Efficient Home Temperature Control', 'Optimize your home’s energy usage with smart thermostats.', 'smart thermostats, home automation, temperature control, energy efficiency, IoT', 0, 24, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(119, 'Voice Assistants', 'voice-assistants', 'Control Your Home with Voice Commands', 'Use voice assistants to manage your smart home devices.', 'voice assistants, smart home, home automation, IoT, tech gadgets', 0, 24, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(120, 'Smart Plugs', 'smart-plugs', 'Automate Your Home with Smart Plugs', 'Control your appliances remotely with smart plugs.', 'smart plugs, home automation, IoT, smart devices, tech gadgets', 0, 24, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(121, 'Wireless Headphones', 'wireless-headphones', 'Premium Wireless Headphones', 'Enjoy high-quality sound with wireless headphones.', 'wireless headphones, audio equipment, music gear, sound quality, tech gadgets', 0, 25, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(122, 'Bluetooth Speakers', 'bluetooth-speakers', 'Portable Bluetooth Speakers', 'Take your music anywhere with portable Bluetooth speakers.', 'bluetooth speakers, audio equipment, portable speakers, music gear, tech gadgets', 0, 25, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(123, 'Home Theater Systems', 'home-theater-systems', 'Immersive Home Theater Experience', 'Create a cinematic experience with home theater systems.', 'home theater systems, audio equipment, sound systems, entertainment, tech gadgets', 0, 25, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(124, 'Soundbars', 'soundbars', 'Enhance Your TV Audio with Soundbars', 'Upgrade your TV sound with sleek and powerful soundbars.', 'soundbars, audio equipment, home entertainment, sound quality, tech gadgets', 0, 25, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(125, 'Studio Monitors', 'studio-monitors', 'Professional Audio for Studios', 'Get accurate sound reproduction with studio monitors.', 'studio monitors, audio equipment, music production, sound quality, tech gadgets', 0, 25, '2025-03-08 23:25:44', '2025-03-08 23:48:29'),
(126, 'DSLR Cameras', 'dslr-cameras', 'Professional DSLR Cameras', 'Capture high-quality photos and videos with advanced DSLR cameras.', 'DSLR cameras, photography, camera gear, professional cameras, photo equipment', 0, 26, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(127, 'Mirrorless Cameras', 'mirrorless-cameras', 'Compact Mirrorless Cameras', 'Explore lightweight and versatile mirrorless cameras for photography.', 'mirrorless cameras, photography, camera gear, compact cameras, photo equipment', 0, 26, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(128, 'Camera Lenses', 'camera-lenses', 'High-Quality Camera Lenses', 'Enhance your photography with a variety of camera lenses.', 'camera lenses, photography, lens gear, photo equipment, DSLR lenses', 0, 26, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(129, 'Tripods & Stabilizers', 'tripods-stabilizers', 'Stable Shooting with Tripods', 'Ensure steady shots with tripods and stabilizers for your camera.', 'tripods, stabilizers, camera accessories, photography, photo equipment', 0, 26, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(130, 'Camera Bags & Cases', 'camera-bags-cases', 'Protect Your Camera Gear', 'Keep your photography equipment safe with durable bags and cases.', 'camera bags, camera cases, photography accessories, photo equipment, camera protection', 0, 26, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(131, 'PlayStation Consoles', 'playstation-consoles', 'Explore PlayStation Gaming', 'Discover the latest PlayStation consoles for immersive gaming.', 'PlayStation, gaming consoles, video games, gaming gear, entertainment', 0, 27, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(132, 'Xbox Consoles', 'xbox-consoles', 'Powerful Xbox Gaming', 'Experience high-performance gaming with Xbox consoles.', 'Xbox, gaming consoles, video games, gaming gear, entertainment', 0, 27, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(133, 'Gaming Headsets', 'gaming-headsets', 'Immersive Gaming Audio', 'Enhance your gaming experience with high-quality headsets.', 'gaming headsets, gaming accessories, audio gear, gaming gear, entertainment', 0, 27, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(134, 'Gaming Controllers', 'gaming-controllers', 'Precision Gaming Controllers', 'Take control of your games with advanced gaming controllers.', 'gaming controllers, gaming accessories, gaming gear, video games, entertainment', 0, 27, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(135, 'Gaming Chairs', 'gaming-chairs', 'Comfortable Gaming Chairs', 'Stay comfortable during long gaming sessions with ergonomic chairs.', 'gaming chairs, gaming accessories, gaming gear, comfort, entertainment', 0, 27, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(136, 'Productivity Software', 'productivity-software', 'Boost Your Efficiency', 'Find software tools to enhance productivity and workflow.', 'productivity software, business apps, workflow tools, efficiency, software', 0, 28, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(137, 'Creative Software', 'creative-software', 'Unleash Your Creativity', 'Explore software for graphic design, video editing, and more.', 'creative software, graphic design, video editing, photo editing, software', 0, 28, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(138, 'Mobile Apps', 'mobile-apps', 'Essential Apps for Your Phone', 'Discover must-have mobile apps for productivity and entertainment.', 'mobile apps, productivity apps, entertainment apps, app development, software', 0, 28, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(139, 'Business Software', 'business-software', 'Tools for Business Success', 'Find software solutions to streamline your business operations.', 'business software, productivity tools, business apps, software solutions, efficiency', 0, 28, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(140, 'Entertainment Software', 'entertainment-software', 'Fun and Entertainment Apps', 'Enjoy games, streaming, and more with entertainment software.', 'entertainment software, gaming apps, streaming apps, fun apps, software', 0, 28, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(141, 'VR Headsets', 'vr-headsets', 'Immersive VR Headsets', 'Step into virtual worlds with advanced VR headsets.', 'VR headsets, virtual reality, immersive experiences, gaming, tech gadgets', 0, 29, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(142, 'VR Gaming', 'vr-gaming', 'Virtual Reality Gaming', 'Experience immersive gaming with VR technology.', 'VR gaming, virtual reality, gaming, immersive experiences, entertainment', 0, 29, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(143, 'VR Education', 'vr-education', 'Learning Through Virtual Reality', 'Explore educational applications of VR technology.', 'VR education, virtual reality, learning tools, immersive experiences, tech gadgets', 0, 29, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(144, 'VR Accessories', 'vr-accessories', 'Enhance Your VR Experience', 'Find accessories to complement your VR setup.', 'VR accessories, virtual reality, gaming gear, immersive experiences, tech gadgets', 0, 29, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(145, 'Augmented Reality', 'augmented-reality', 'Blend Real and Virtual Worlds', 'Discover the possibilities of augmented reality technology.', 'augmented reality, AR, immersive experiences, tech gadgets, virtual reality', 0, 29, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(146, 'Aerial Photography Drones', 'aerial-photography-drones', 'Capture Stunning Aerial Shots', 'Explore drones designed for professional aerial photography.', 'aerial photography, drones, photography drones, quadcopters, tech gadgets', 0, 30, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(147, 'Recreational Drones', 'recreational-drones', 'Fun and Easy-to-Fly Drones', 'Enjoy flying drones for fun and recreational purposes.', 'recreational drones, flying drones, quadcopters, tech gadgets, entertainment', 0, 30, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(148, 'Drone Accessories', 'drone-accessories', 'Enhance Your Drone Experience', 'Find accessories to improve your drone’s functionality.', 'drone accessories, drones, quadcopters, tech gadgets, drone gear', 0, 30, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(149, 'Drone Cameras', 'drone-cameras', 'High-Quality Drone Cameras', 'Capture stunning footage with advanced drone cameras.', 'drone cameras, drones, aerial photography, tech gadgets, quadcopters', 0, 30, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(150, 'Drone Repair & Maintenance', 'drone-repair-maintenance', 'Keep Your Drone in Top Shape', 'Learn about repair and maintenance for your drone.', 'drone repair, drone maintenance, drones, tech gadgets, quadcopters', 0, 30, '2025-03-08 23:28:18', '2025-03-08 23:48:29'),
(151, 'Luxury Hotels', 'luxury-hotels', 'Indulge in Luxury Stays', 'Experience world-class luxury hotels with premium amenities.', 'luxury hotels, five-star hotels, premium stays, luxury travel, accommodations', 0, 31, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(152, 'Budget Hotels', 'budget-hotels', 'Affordable Accommodations', 'Find comfortable and affordable hotels for your travels.', 'budget hotels, affordable stays, cheap accommodations, travel lodging, budget travel', 0, 31, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(153, 'Boutique Hotels', 'boutique-hotels', 'Unique Boutique Stays', 'Discover unique and stylish boutique hotels for a memorable experience.', 'boutique hotels, unique stays, stylish accommodations, travel lodging, boutique travel', 0, 31, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(154, 'Resorts', 'resorts', 'Relaxing Resort Getaways', 'Escape to luxurious resorts for a relaxing vacation.', 'resorts, luxury stays, vacation resorts, travel lodging, resort getaways', 0, 31, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(155, 'Vacation Rentals', 'vacation-rentals', 'Home Away from Home', 'Stay in cozy vacation rentals for a personalized travel experience.', 'vacation rentals, holiday homes, travel lodging, vacation stays, rental homes', 0, 31, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(156, 'Domestic Flights', 'domestic-flights', 'Explore Local Destinations', 'Book domestic flights to explore your country’s top destinations.', 'domestic flights, local travel, flight booking, air travel, cheap flights', 0, 32, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(157, 'International Flights', 'international-flights', 'Travel the World', 'Find international flights to popular global destinations.', 'international flights, global travel, flight booking, air travel, cheap flights', 0, 32, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(158, 'Budget Airlines', 'budget-airlines', 'Affordable Air Travel', 'Fly with budget airlines for cost-effective travel options.', 'budget airlines, cheap flights, affordable travel, air travel, flight deals', 0, 32, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(159, 'First-Class Flights', 'first-class-flights', 'Luxury Air Travel', 'Experience premium first-class flights with top airlines.', 'first-class flights, luxury travel, premium flights, air travel, flight booking', 0, 32, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(160, 'Flight Deals', 'flight-deals', 'Find the Best Flight Offers', 'Discover discounted flight deals for your next trip.', 'flight deals, cheap flights, discounted flights, air travel, flight booking', 0, 32, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(161, 'Adventure Tours', 'adventure-tours', 'Thrilling Adventure Experiences', 'Join adventure tours for exciting outdoor activities.', 'adventure tours, outdoor activities, travel tours, adventure travel, guided tours', 0, 33, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(162, 'Cultural Tours', 'cultural-tours', 'Explore Local Cultures', 'Discover the rich heritage of destinations with cultural tours.', 'cultural tours, heritage tours, travel tours, guided tours, cultural travel', 0, 33, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(163, 'Safari Tours', 'safari-tours', 'Wildlife Safari Adventures', 'Experience wildlife safaris in stunning natural habitats.', 'safari tours, wildlife tours, travel tours, guided tours, adventure travel', 0, 33, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(164, 'City Tours', 'city-tours', 'Explore Iconic Cities', 'Take guided city tours to discover famous landmarks and attractions.', 'city tours, urban travel, travel tours, guided tours, city exploration', 0, 33, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(165, 'Customized Tours', 'customized-tours', 'Tailored Travel Experiences', 'Create personalized tours to suit your travel preferences.', 'customized tours, personalized travel, travel tours, guided tours, tailored trips', 0, 33, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(166, 'Luxury Cruises', 'luxury-cruises', 'Premium Cruise Experiences', 'Indulge in luxury cruises with world-class amenities.', 'luxury cruises, premium travel, cruise vacations, cruise lines, luxury travel', 0, 34, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(167, 'Family Cruises', 'family-cruises', 'Fun for the Whole Family', 'Enjoy family-friendly cruises with activities for all ages.', 'family cruises, cruise vacations, family travel, cruise lines, holiday cruises', 0, 34, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(168, 'Adventure Cruises', 'adventure-cruises', 'Explore Remote Destinations', 'Embark on adventure cruises to exotic and remote locations.', 'adventure cruises, cruise vacations, adventure travel, cruise lines, exploration', 0, 34, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(169, 'River Cruises', 'river-cruises', 'Scenic River Journeys', 'Experience the beauty of river cruises through stunning landscapes.', 'river cruises, scenic travel, cruise vacations, cruise lines, river journeys', 0, 34, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(170, 'Cruise Deals', 'cruise-deals', 'Find the Best Cruise Offers', 'Discover discounted cruise deals for your next vacation.', 'cruise deals, discounted cruises, cruise vacations, cruise lines, travel deals', 0, 34, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(171, 'Luxury Car Rentals', 'luxury-car-rentals', 'Rent Premium Vehicles', 'Drive in style with luxury car rentals for your travels.', 'luxury car rentals, premium cars, car hire, travel rentals, luxury travel', 0, 35, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(172, 'Economy Car Rentals', 'economy-car-rentals', 'Affordable Car Rentals', 'Find budget-friendly car rentals for your trip.', 'economy car rentals, budget cars, car hire, travel rentals, affordable travel', 0, 35, '2025-03-08 23:29:44', '2025-03-08 23:48:29');
INSERT INTO `sub_sub_categories` (`id`, `name`, `slug`, `title`, `description`, `keywords`, `views`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(173, 'SUV Rentals', 'suv-rentals', 'Spacious SUV Rentals', 'Rent SUVs for family trips or outdoor adventures.', 'SUV rentals, family cars, car hire, travel rentals, adventure travel', 0, 35, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(174, 'Long-Term Rentals', 'long-term-rentals', 'Extended Car Rentals', 'Get long-term car rentals for extended travel needs.', 'long-term rentals, car hire, travel rentals, extended travel, car booking', 0, 35, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(175, 'Car Rental Deals', 'car-rental-deals', 'Find the Best Car Rental Offers', 'Discover discounted car rental deals for your next trip.', 'car rental deals, discounted rentals, car hire, travel rentals, travel deals', 0, 35, '2025-03-08 23:29:44', '2025-03-08 23:48:29'),
(176, 'Hiking & Trekking', 'hiking-trekking', 'Explore Nature on Foot', 'Discover thrilling hiking and trekking adventures in stunning locations.', 'hiking, trekking, outdoor adventures, nature travel, adventure tours', 0, 36, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(177, 'Scuba Diving', 'scuba-diving', 'Underwater Adventures', 'Dive into the ocean and explore marine life with scuba diving tours.', 'scuba diving, underwater adventures, marine life, adventure travel, water sports', 0, 36, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(178, 'Safari Adventures', 'safari-adventures', 'Wildlife Safari Tours', 'Experience the thrill of wildlife safaris in exotic destinations.', 'safari adventures, wildlife tours, adventure travel, nature travel, guided tours', 0, 36, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(179, 'Mountain Climbing', 'mountain-climbing', 'Conquer the Peaks', 'Challenge yourself with mountain climbing expeditions.', 'mountain climbing, adventure travel, outdoor adventures, climbing tours, extreme sports', 0, 36, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(180, 'Extreme Sports', 'extreme-sports', 'Thrill-Seeking Adventures', 'Engage in adrenaline-pumping extreme sports activities.', 'extreme sports, adventure travel, thrill-seeking, outdoor adventures, adrenaline sports', 0, 36, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(181, 'Custom Travel Packages', 'custom-travel-packages', 'Tailored Travel Experiences', 'Create personalized travel packages with expert travel agencies.', 'custom travel, personalized trips, travel agencies, vacation packages, travel planning', 0, 37, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(182, 'Group Tours', 'group-tours', 'Travel with Like-Minded People', 'Join group tours for a fun and social travel experience.', 'group tours, travel agencies, guided tours, vacation packages, travel planning', 0, 37, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(183, 'Luxury Travel Agencies', 'luxury-travel-agencies', 'Premium Travel Services', 'Access luxury travel agencies for high-end vacation planning.', 'luxury travel, premium travel, travel agencies, vacation packages, travel planning', 0, 37, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(184, 'Budget Travel Agencies', 'budget-travel-agencies', 'Affordable Travel Solutions', 'Find budget-friendly travel agencies for cost-effective trips.', 'budget travel, affordable trips, travel agencies, vacation packages, travel planning', 0, 37, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(185, 'Corporate Travel Services', 'corporate-travel-services', 'Business Travel Solutions', 'Plan business trips with professional corporate travel agencies.', 'corporate travel, business trips, travel agencies, travel planning, corporate services', 0, 37, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(186, 'Luggage & Suitcases', 'luggage-suitcases', 'Durable Travel Luggage', 'Find high-quality luggage and suitcases for your travels.', 'luggage, suitcases, travel gear, travel accessories, packing essentials', 0, 38, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(187, 'Travel Backpacks', 'travel-backpacks', 'Comfortable Travel Backpacks', 'Explore ergonomic backpacks designed for travel convenience.', 'travel backpacks, backpacks, travel gear, travel accessories, packing essentials', 0, 38, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(188, 'Travel Organizers', 'travel-organizers', 'Stay Organized on the Go', 'Keep your belongings tidy with travel organizers and pouches.', 'travel organizers, packing cubes, travel gear, travel accessories, packing essentials', 0, 38, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(189, 'Travel Safety Gear', 'travel-safety-gear', 'Essential Safety Accessories', 'Ensure your safety with travel locks, alarms, and other gear.', 'travel safety, safety gear, travel accessories, travel gear, packing essentials', 0, 38, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(190, 'Travel Tech Gadgets', 'travel-tech-gadgets', 'Tech for Travelers', 'Enhance your travel experience with innovative tech gadgets.', 'travel gadgets, tech accessories, travel gear, travel accessories, packing essentials', 0, 38, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(191, 'Concert Tickets', 'concert-tickets', 'Live Music Experiences', 'Get tickets to your favorite concerts and live music events.', 'concert tickets, live music, event tickets, entertainment, ticket sales', 0, 39, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(192, 'Sports Tickets', 'sports-tickets', 'Cheer for Your Favorite Teams', 'Attend exciting sports events with premium tickets.', 'sports tickets, sports events, event tickets, entertainment, ticket sales', 0, 39, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(193, 'Theater Tickets', 'theater-tickets', 'Enjoy Live Performances', 'Book tickets for theater shows and live performances.', 'theater tickets, live performances, event tickets, entertainment, ticket sales', 0, 39, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(194, 'Festival Tickets', 'festival-tickets', 'Join Exciting Festivals', 'Get tickets to music, food, and cultural festivals.', 'festival tickets, music festivals, event tickets, entertainment, ticket sales', 0, 39, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(195, 'VIP Event Tickets', 'vip-event-tickets', 'Exclusive VIP Experiences', 'Access premium VIP tickets for exclusive events.', 'VIP tickets, event tickets, exclusive events, entertainment, ticket sales', 0, 39, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(196, 'Destination Guides', 'destination-guides', 'Explore Top Travel Destinations', 'Find detailed guides for popular travel destinations.', 'destination guides, travel resources, travel planning, vacation planning, travel tips', 0, 40, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(197, 'Travel Itineraries', 'travel-itineraries', 'Plan Your Perfect Trip', 'Access pre-planned itineraries for seamless travel.', 'travel itineraries, travel resources, travel planning, vacation planning, travel tips', 0, 40, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(198, 'Travel Tips', 'travel-tips', 'Expert Advice for Travelers', 'Get practical tips and advice for hassle-free travel.', 'travel tips, travel resources, travel planning, vacation planning, travel advice', 0, 40, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(199, 'Travel Blogs', 'travel-blogs', 'Insights from Travel Experts', 'Read travel blogs for inspiration and information.', 'travel blogs, travel resources, travel planning, vacation planning, travel tips', 0, 40, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(200, 'Travel Apps', 'travel-apps', 'Essential Apps for Travelers', 'Discover apps to enhance your travel experience.', 'travel apps, travel resources, travel planning, vacation planning, travel tips', 0, 40, '2025-03-08 23:31:09', '2025-03-08 23:48:29'),
(201, 'Programming Courses', 'programming-courses', 'Learn Coding and Development', 'Explore online courses to master programming languages and software development.', 'programming courses, coding, software development, online learning, tech skills', 0, 41, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(202, 'Digital Marketing Courses', 'digital-marketing-courses', 'Master Digital Marketing', 'Learn SEO, social media marketing, and more with online courses.', 'digital marketing, SEO, social media, online courses, marketing skills', 0, 41, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(203, 'Business Courses', 'business-courses', 'Advance Your Business Skills', 'Take online courses in business management, finance, and entrepreneurship.', 'business courses, management, finance, entrepreneurship, online learning', 0, 41, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(204, 'Creative Arts Courses', 'creative-arts-courses', 'Explore Your Creativity', 'Discover online courses in graphic design, photography, and writing.', 'creative arts, graphic design, photography, writing, online courses', 0, 41, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(205, 'Personal Development', 'personal-development', 'Grow Personally and Professionally', 'Enhance your skills with personal development courses.', 'personal development, online courses, self-improvement, career growth, learning resources', 0, 41, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(206, 'Math Tutoring', 'math-tutoring', 'Expert Math Tutoring', 'Get personalized math tutoring for all levels.', 'math tutoring, academic tutoring, private lessons, online tutoring, math help', 0, 42, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(207, 'Science Tutoring', 'science-tutoring', 'Master Science Subjects', 'Receive tutoring in biology, chemistry, physics, and more.', 'science tutoring, biology, chemistry, physics, academic tutoring', 0, 42, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(208, 'Language Tutoring', 'language-tutoring', 'Learn New Languages', 'Improve your language skills with expert tutors.', 'language tutoring, language learning, academic tutoring, online tutoring, language skills', 0, 42, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(209, 'Test Prep Tutoring', 'test-prep-tutoring', 'Ace Your Exams', 'Get tutoring for standardized tests like SAT, GRE, and ACT.', 'test prep tutoring, SAT, GRE, ACT, academic tutoring', 0, 42, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(210, 'Online Tutoring Platforms', 'online-tutoring-platforms', 'Find the Best Tutoring Services', 'Discover top online tutoring platforms for all subjects.', 'online tutoring, tutoring platforms, academic tutoring, private lessons, learning resources', 0, 42, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(211, 'English Language Courses', 'english-language-courses', 'Learn English Online', 'Master English with online courses and resources.', 'English courses, language learning, online learning, language skills, bilingual', 0, 43, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(212, 'Spanish Language Courses', 'spanish-language-courses', 'Learn Spanish Online', 'Explore courses to learn Spanish fluently.', 'Spanish courses, language learning, online learning, language skills, bilingual', 0, 43, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(213, 'French Language Courses', 'french-language-courses', 'Learn French Online', 'Discover online courses to master French.', 'French courses, language learning, online learning, language skills, bilingual', 0, 43, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(214, 'Language Learning Apps', 'language-learning-apps', 'Learn on the Go', 'Use apps to practice and improve your language skills.', 'language apps, language learning, mobile apps, language practice, bilingual', 0, 43, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(215, 'Conversational Practice', 'conversational-practice', 'Practice Speaking Fluently', 'Engage in conversational practice to master a new language.', 'conversational practice, language learning, language skills, bilingual, speaking practice', 0, 43, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(216, 'SAT Prep Courses', 'sat-prep-courses', 'Ace the SAT', 'Prepare for the SAT with comprehensive courses and materials.', 'SAT prep, test preparation, standardized tests, study resources, exam prep', 0, 44, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(217, 'GRE Prep Courses', 'gre-prep-courses', 'Master the GRE', 'Get ready for the GRE with expert preparation courses.', 'GRE prep, test preparation, standardized tests, study resources, exam prep', 0, 44, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(218, 'ACT Prep Courses', 'act-prep-courses', 'Excel on the ACT', 'Prepare for the ACT with tailored courses and practice tests.', 'ACT prep, test preparation, standardized tests, study resources, exam prep', 0, 44, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(219, 'TOEFL Prep Courses', 'toefl-prep-courses', 'Prepare for the TOEFL', 'Improve your English skills for the TOEFL exam.', 'TOEFL prep, test preparation, standardized tests, study resources, exam prep', 0, 44, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(220, 'Test Prep Books', 'test-prep-books', 'Study with Prep Books', 'Find the best test preparation books for your exams.', 'test prep books, study resources, exam prep, standardized tests, learning materials', 0, 44, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(221, 'Textbooks', 'textbooks', 'Essential Academic Textbooks', 'Find textbooks for all subjects and academic levels.', 'textbooks, study materials, academic resources, learning materials, education', 0, 45, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(222, 'Practice Tests', 'practice-tests', 'Prepare with Practice Tests', 'Access practice tests to improve your exam performance.', 'practice tests, study materials, exam prep, learning resources, education', 0, 45, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(223, 'Study Guides', 'study-guides', 'Comprehensive Study Guides', 'Get detailed study guides for various subjects.', 'study guides, study materials, learning resources, exam prep, education', 0, 45, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(224, 'E-Books', 'e-books', 'Digital Learning Resources', 'Explore e-books for convenient and portable studying.', 'e-books, study materials, digital learning, learning resources, education', 0, 45, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(225, 'Flashcards', 'flashcards', 'Effective Study Tools', 'Use flashcards for quick and efficient learning.', 'flashcards, study materials, learning tools, exam prep, education', 0, 45, '2025-03-08 23:32:34', '2025-03-08 23:48:29'),
(226, 'Essay Writing Guides', 'essay-writing-guides', 'Master the Art of Essay Writing', 'Learn how to write compelling essays with expert guides.', 'essay writing, academic writing, writing guides, writing skills, education', 0, 46, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(227, 'Research Writing Tools', 'research-writing-tools', 'Tools for Effective Research Writing', 'Discover tools to streamline your research writing process.', 'research writing, academic writing, writing tools, writing skills, education', 0, 46, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(228, 'Citation Styles', 'citation-styles', 'Learn Proper Citation Techniques', 'Understand APA, MLA, and other citation styles for academic writing.', 'citation styles, academic writing, writing guides, writing skills, education', 0, 46, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(229, 'Academic Writing Courses', 'academic-writing-courses', 'Improve Your Writing Skills', 'Take online courses to enhance your academic writing abilities.', 'academic writing, writing courses, online learning, writing skills, education', 0, 46, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(230, 'Thesis and Dissertation Help', 'thesis-dissertation-help', 'Guidance for Thesis and Dissertation Writing', 'Get resources and tips for writing theses and dissertations.', 'thesis writing, dissertation help, academic writing, writing skills, education', 0, 46, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(231, 'Online Course Platforms', 'online-course-platforms', 'Explore Top E-Learning Platforms', 'Discover platforms offering courses in various fields.', 'e-learning platforms, online courses, digital learning, learning platforms, education', 0, 47, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(232, 'Skill Development Platforms', 'skill-development-platforms', 'Build Skills with Online Learning', 'Find platforms focused on professional and personal skill development.', 'skill development, e-learning platforms, online courses, learning platforms, education', 0, 47, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(233, 'Language Learning Platforms', 'language-learning-platforms', 'Learn New Languages Online', 'Explore platforms for mastering new languages.', 'language learning, e-learning platforms, online courses, learning platforms, education', 0, 47, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(234, 'Tech Skill Platforms', 'tech-skill-platforms', 'Master Tech Skills Online', 'Find platforms offering courses in programming, IT, and more.', 'tech skills, e-learning platforms, online courses, learning platforms, education', 0, 47, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(235, 'Business Learning Platforms', 'business-learning-platforms', 'Advance Your Business Knowledge', 'Discover platforms for business and management courses.', 'business learning, e-learning platforms, online courses, learning platforms, education', 0, 47, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(236, 'Leadership Training', 'leadership-training', 'Develop Leadership Skills', 'Take courses to enhance your leadership abilities.', 'leadership training, professional development, career growth, skill development, education', 0, 48, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(237, 'Career Coaching', 'career-coaching', 'Get Expert Career Guidance', 'Receive coaching to advance your career and achieve your goals.', 'career coaching, professional development, career growth, skill development, education', 0, 48, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(238, 'Soft Skills Development', 'soft-skills-development', 'Improve Your Soft Skills', 'Learn communication, teamwork, and other essential soft skills.', 'soft skills, professional development, career growth, skill development, education', 0, 48, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(239, 'Industry-Specific Training', 'industry-specific-training', 'Training for Your Industry', 'Find professional development courses tailored to your industry.', 'industry training, professional development, career growth, skill development, education', 0, 48, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(240, 'Networking Skills', 'networking-skills', 'Master Professional Networking', 'Learn how to build and maintain professional networks.', 'networking skills, professional development, career growth, skill development, education', 0, 48, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(241, 'IT Certifications', 'it-certifications', 'Certifications for Tech Professionals', 'Get certified in IT fields like cybersecurity, cloud computing, and more.', 'IT certifications, certification programs, tech skills, career growth, education', 0, 49, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(242, 'Business Certifications', 'business-certifications', 'Certifications for Business Professionals', 'Earn certifications in business management, finance, and marketing.', 'business certifications, certification programs, career growth, skill development, education', 0, 49, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(243, 'Healthcare Certifications', 'healthcare-certifications', 'Certifications for Healthcare Careers', 'Advance your healthcare career with recognized certifications.', 'healthcare certifications, certification programs, career growth, skill development, education', 0, 49, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(244, 'Project Management Certifications', 'project-management-certifications', 'Certifications for Project Managers', 'Get certified in project management methodologies like PMP and Agile.', 'project management, certification programs, career growth, skill development, education', 0, 49, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(245, 'Language Certifications', 'language-certifications', 'Certifications for Language Proficiency', 'Earn certifications to prove your language skills.', 'language certifications, certification programs, career growth, skill development, education', 0, 49, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(246, 'Undergraduate Programs', 'undergraduate-programs', 'Explore Bachelor’s Degree Programs', 'Find undergraduate programs in various fields of study.', 'undergraduate programs, college, university, higher education, degree programs', 0, 50, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(247, 'Graduate Programs', 'graduate-programs', 'Advance Your Education with Graduate Studies', 'Discover master’s and PhD programs for further education.', 'graduate programs, college, university, higher education, degree programs', 0, 50, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(248, 'Admission Requirements', 'admission-requirements', 'Understand College Admission Criteria', 'Learn about the requirements for applying to colleges and universities.', 'admission requirements, college, university, higher education, degree programs', 0, 50, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(249, 'Scholarships and Financial Aid', 'scholarships-financial-aid', 'Find Funding for Your Education', 'Explore scholarships and financial aid options for students.', 'scholarships, financial aid, college, university, higher education', 0, 50, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(250, 'Student Life Resources', 'student-life-resources', 'Make the Most of College Life', 'Access resources to enhance your college experience.', 'student life, college, university, higher education, academic resources', 0, 50, '2025-03-08 23:33:55', '2025-03-08 23:48:29'),
(251, 'Portfolio Management', 'portfolio-management', 'Manage Your Investment Portfolio', 'Get expert advice on managing and diversifying your investment portfolio.', 'portfolio management, investment, wealth management, financial planning, asset management', 0, 51, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(252, 'Retirement Planning', 'retirement-planning', 'Secure Your Retirement', 'Plan for a comfortable retirement with tailored investment strategies.', 'retirement planning, investment, wealth management, financial planning, financial security', 0, 51, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(253, 'Stock Market Investments', 'stock-market-investments', 'Invest in the Stock Market', 'Learn how to invest in stocks and build a profitable portfolio.', 'stock market, investment, wealth management, financial planning, stock trading', 0, 51, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(254, 'Real Estate Investments', 'real-estate-investments', 'Invest in Real Estate', 'Explore opportunities to grow your wealth through real estate investments.', 'real estate, investment, wealth management, financial planning, property investment', 0, 51, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(255, 'Wealth Preservation', 'wealth-preservation', 'Protect and Grow Your Wealth', 'Discover strategies to preserve and grow your wealth over time.', 'wealth preservation, investment, wealth management, financial planning, financial security', 0, 51, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(256, 'Health Insurance', 'health-insurance', 'Find the Best Health Insurance', 'Compare health insurance plans to protect your well-being.', 'health insurance, insurance providers, medical coverage, insurance plans, financial security', 0, 52, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(257, 'Life Insurance', 'life-insurance', 'Secure Your Family’s Future', 'Explore life insurance options to provide financial security for your loved ones.', 'life insurance, insurance providers, financial security, life coverage, insurance plans', 0, 52, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(258, 'Auto Insurance', 'auto-insurance', 'Protect Your Vehicle', 'Get auto insurance coverage for your car, truck, or motorcycle.', 'auto insurance, car insurance, insurance providers, vehicle coverage, insurance plans', 0, 52, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(259, 'Home Insurance', 'home-insurance', 'Safeguard Your Home', 'Find home insurance plans to protect your property and belongings.', 'home insurance, insurance providers, property coverage, insurance plans, financial security', 0, 52, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(260, 'Travel Insurance', 'travel-insurance', 'Stay Protected While Traveling', 'Get travel insurance for peace of mind during your trips.', 'travel insurance, insurance providers, travel coverage, insurance plans, financial security', 0, 52, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(261, 'Budgeting Services', 'budgeting-services', 'Create a Financial Plan', 'Get help with budgeting to manage your income and expenses effectively.', 'budgeting, financial planning, personal finance, financial goals, financial security', 0, 53, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(262, 'Debt Management', 'debt-management', 'Manage and Reduce Your Debt', 'Find strategies to manage and pay off your debt efficiently.', 'debt management, financial planning, personal finance, financial goals, financial security', 0, 53, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(263, 'Retirement Planning Services', 'retirement-planning-services', 'Plan for a Secure Retirement', 'Receive expert advice on saving and investing for retirement.', 'retirement planning, financial planning, personal finance, financial goals, financial security', 0, 53, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(264, 'Estate Planning', 'estate-planning', 'Plan Your Estate', 'Ensure your assets are distributed according to your wishes with estate planning.', 'estate planning, financial planning, personal finance, financial goals, financial security', 0, 53, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(265, 'Tax Planning', 'tax-planning', 'Optimize Your Tax Strategy', 'Plan your taxes to minimize liabilities and maximize savings.', 'tax planning, financial planning, personal finance, financial goals, financial security', 0, 53, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(266, 'Tax Preparation Services', 'tax-preparation-services', 'Professional Tax Preparation', 'Get help with preparing and filing your taxes accurately.', 'tax preparation, tax services, tax filing, income tax, tax returns', 0, 54, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(267, 'Tax Consulting', 'tax-consulting', 'Expert Tax Advice', 'Receive professional advice on tax-related matters.', 'tax consulting, tax services, tax advice, financial planning, tax planning', 0, 54, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(268, 'Business Tax Services', 'business-tax-services', 'Tax Solutions for Businesses', 'Find tax services tailored for small and large businesses.', 'business tax, tax services, tax filing, income tax, tax returns', 0, 54, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(269, 'IRS Assistance', 'irs-assistance', 'Help with IRS Matters', 'Get support for IRS audits, disputes, and compliance.', 'IRS assistance, tax services, tax filing, income tax, tax returns', 0, 54, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(270, 'Tax Refund Services', 'tax-refund-services', 'Maximize Your Tax Refund', 'Find services to help you get the maximum tax refund.', 'tax refund, tax services, tax filing, income tax, tax returns', 0, 54, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(271, 'Home Loans', 'home-loans', 'Finance Your Dream Home', 'Explore home loan options to buy or refinance your property.', 'home loans, mortgages, financing options, loan terms, property investment', 0, 55, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(272, 'Personal Loans', 'personal-loans', 'Borrow for Personal Needs', 'Get personal loans for emergencies, travel, or other expenses.', 'personal loans, financing options, loan terms, financial planning, debt management', 0, 55, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(273, 'Business Loans', 'business-loans', 'Grow Your Business with Loans', 'Find business loans to fund your company’s growth and operations.', 'business loans, financing options, loan terms, financial planning, business growth', 0, 55, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(274, 'Mortgage Refinancing', 'mortgage-refinancing', 'Refinance Your Mortgage', 'Lower your interest rates or monthly payments with refinancing.', 'mortgage refinancing, home loans, financing options, loan terms, property investment', 0, 55, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(275, 'Loan Comparison Tools', 'loan-comparison-tools', 'Compare Loan Options', 'Use tools to compare loan rates and terms for the best deal.', 'loan comparison, financing options, loan terms, financial planning, debt management', 0, 55, '2025-03-08 23:35:31', '2025-03-08 23:48:29'),
(276, 'Savings Accounts', 'savings-accounts', 'Grow Your Savings', 'Find high-interest savings accounts to grow your money.', 'savings accounts, banking, interest rates, financial products, savings plans', 0, 56, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(277, 'Online Banking', 'online-banking', 'Convenient Online Banking', 'Manage your finances with user-friendly online banking platforms.', 'online banking, banking, financial institutions, financial products, money management', 0, 56, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(278, 'Certificates of Deposit', 'certificates-of-deposit', 'Secure Investments with CDs', 'Explore certificates of deposit for low-risk savings options.', 'certificates of deposit, banking, interest rates, financial products, savings plans', 0, 56, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(279, 'Checking Accounts', 'checking-accounts', 'Manage Your Daily Finances', 'Find checking accounts with low fees and great features.', 'checking accounts, banking, financial institutions, financial products, money management', 0, 56, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(280, 'High-Yield Savings', 'high-yield-savings', 'Maximize Your Savings', 'Discover high-yield savings accounts for better returns.', 'high-yield savings, banking, interest rates, financial products, savings plans', 0, 56, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(281, 'Credit Repair Services', 'credit-repair-services', 'Improve Your Credit Score', 'Get professional help to repair and improve your credit.', 'credit repair, credit services, credit score, financial help, debt management', 0, 57, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(282, 'Debt Consolidation', 'debt-consolidation', 'Simplify Your Debt Payments', 'Combine your debts into one manageable payment plan.', 'debt consolidation, debt services, debt reduction, financial help, debt management', 0, 57, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(283, 'Credit Counseling', 'credit-counseling', 'Expert Advice for Credit Management', 'Receive guidance on managing your credit and finances.', 'credit counseling, credit services, financial help, debt management, credit score', 0, 57, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(284, 'Debt Settlement', 'debt-settlement', 'Negotiate Your Debt', 'Explore debt settlement options to reduce your debt burden.', 'debt settlement, debt services, debt reduction, financial help, debt management', 0, 57, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(285, 'Credit Monitoring', 'credit-monitoring', 'Track Your Credit Health', 'Monitor your credit score and report for financial security.', 'credit monitoring, credit services, credit score, financial help, debt management', 0, 57, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(286, 'Budgeting Software', 'budgeting-software', 'Manage Your Budget Effectively', 'Find software to track and manage your income and expenses.', 'budgeting software, financial software, money management, personal finance, expense tracking', 0, 58, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(287, 'Investment Software', 'investment-software', 'Track and Manage Your Investments', 'Use software to monitor and optimize your investment portfolio.', 'investment software, financial software, money management, personal finance, investment tracking', 0, 58, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(288, 'Accounting Software', 'accounting-software', 'Simplify Your Accounting', 'Discover software for managing business and personal finances.', 'accounting software, financial software, money management, personal finance, expense tracking', 0, 58, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(289, 'Tax Preparation Software', 'tax-preparation-software', 'File Your Taxes with Ease', 'Use software to prepare and file your taxes accurately.', 'tax software, financial software, tax preparation, personal finance, tax filing', 0, 58, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(290, 'Expense Tracking Tools', 'expense-tracking-tools', 'Track Your Spending', 'Find tools to monitor and analyze your expenses.', 'expense tracking, financial software, money management, personal finance, budgeting tools', 0, 58, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(291, 'Bitcoin Investments', 'bitcoin-investments', 'Invest in Bitcoin', 'Explore opportunities to invest in Bitcoin and other cryptocurrencies.', 'Bitcoin, cryptocurrency, crypto investments, digital currency, blockchain', 0, 59, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(292, 'Ethereum Trading', 'ethereum-trading', 'Trade Ethereum', 'Learn how to trade Ethereum and other altcoins.', 'Ethereum, cryptocurrency, crypto trading, digital currency, blockchain', 0, 59, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(293, 'Crypto Wallets', 'crypto-wallets', 'Secure Your Cryptocurrency', 'Find secure wallets to store your digital assets.', 'crypto wallets, cryptocurrency, digital currency, blockchain, crypto security', 0, 59, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(294, 'Blockchain Technology', 'blockchain-technology', 'Understand Blockchain', 'Learn about blockchain technology and its applications.', 'blockchain, cryptocurrency, digital currency, crypto technology, blockchain applications', 0, 59, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(295, 'Crypto Exchanges', 'crypto-exchanges', 'Trade on Crypto Exchanges', 'Discover platforms for buying and selling cryptocurrencies.', 'crypto exchanges, cryptocurrency, crypto trading, digital currency, blockchain', 0, 59, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(296, '401(k) Plans', '401k-plans', 'Save for Retirement with 401(k)', 'Learn how to maximize your 401(k) savings for retirement.', '401(k), retirement planning, retirement savings, financial planning, pension plans', 0, 60, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(297, 'IRA Accounts', 'ira-accounts', 'Individual Retirement Accounts', 'Explore IRA options for tax-advantaged retirement savings.', 'IRA, retirement planning, retirement savings, financial planning, pension plans', 0, 60, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(298, 'Pension Plans', 'pension-plans', 'Secure Your Future with Pensions', 'Find information about employer-sponsored pension plans.', 'pension plans, retirement planning, retirement savings, financial planning, retirement funds', 0, 60, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(299, 'Retirement Investment Strategies', 'retirement-investment-strategies', 'Plan Your Retirement Investments', 'Discover strategies to grow your retirement savings.', 'retirement investments, retirement planning, financial planning, investment strategies, retirement funds', 0, 60, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(300, 'Social Security Planning', 'social-security-planning', 'Maximize Your Social Security Benefits', 'Learn how to optimize your Social Security for retirement.', 'social security, retirement planning, financial planning, retirement funds, pension plans', 0, 60, '2025-03-08 23:37:00', '2025-03-08 23:48:29'),
(301, 'Fine Dining', 'fine-dining', 'Experience Gourmet Cuisine', 'Discover upscale restaurants offering gourmet dishes and exceptional service.', 'fine dining, restaurants, gourmet food, upscale dining, dining experience', 0, 61, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(302, 'Casual Dining', 'casual-dining', 'Relaxed and Comfortable Eateries', 'Enjoy a laid-back dining experience at casual restaurants.', 'casual dining, restaurants, food, dining experience, relaxed dining', 0, 61, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(303, 'Ethnic Cuisine', 'ethnic-cuisine', 'Explore Global Flavors', 'Try authentic dishes from around the world at ethnic restaurants.', 'ethnic cuisine, restaurants, global food, cultural dining, international cuisine', 0, 61, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(304, 'Fast Food', 'fast-food', 'Quick and Convenient Meals', 'Find fast food options for quick and tasty meals.', 'fast food, restaurants, quick meals, convenience food, dining experience', 0, 61, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(305, 'Vegetarian & Vegan', 'vegetarian-vegan', 'Plant-Based Dining Options', 'Explore restaurants offering vegetarian and vegan dishes.', 'vegetarian, vegan, plant-based food, restaurants, dining experience', 0, 61, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(306, 'Cocktail Bars', 'cocktail-bars', 'Craft Cocktails and Mixology', 'Enjoy expertly crafted cocktails at trendy bars.', 'cocktail bars, bars, nightlife, craft cocktails, mixology', 0, 62, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(307, 'Nightclubs', 'nightclubs', 'Dance the Night Away', 'Experience vibrant nightlife at top nightclubs.', 'nightclubs, bars, nightlife, dancing, entertainment', 0, 62, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(308, 'Live Music Venues', 'live-music-venues', 'Enjoy Live Performances', 'Discover bars and clubs featuring live music.', 'live music, bars, nightlife, entertainment, music venues', 0, 62, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(309, 'Sports Bars', 'sports-bars', 'Watch the Game with Friends', 'Cheer for your favorite teams at sports bars.', 'sports bars, bars, nightlife, sports, entertainment', 0, 62, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(310, 'Wine Bars', 'wine-bars', 'Sip Fine Wines', 'Explore wine bars offering a curated selection of wines.', 'wine bars, bars, nightlife, wine tasting, fine wines', 0, 62, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(311, 'Specialty Coffee', 'specialty-coffee', 'Artisan Coffee Blends', 'Enjoy high-quality, specialty coffee at local cafes.', 'specialty coffee, cafes, coffee shops, artisan coffee, coffee lovers', 0, 63, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(312, 'Tea Houses', 'tea-houses', 'Relax with a Cup of Tea', 'Discover cozy tea houses offering a variety of teas.', 'tea houses, cafes, tea, relaxing, tea lovers', 0, 63, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(313, 'Breakfast Cafes', 'breakfast-cafes', 'Start Your Day Right', 'Find cafes serving delicious breakfast options.', 'breakfast cafes, cafes, coffee shops, breakfast, dining experience', 0, 63, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(314, 'Dessert Cafes', 'dessert-cafes', 'Indulge in Sweet Treats', 'Explore cafes specializing in desserts and pastries.', 'dessert cafes, cafes, coffee shops, desserts, pastries', 0, 63, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(315, 'Cozy Cafes', 'cozy-cafes', 'Relax in a Warm Atmosphere', 'Discover cozy cafes perfect for relaxing and working.', 'cozy cafes, cafes, coffee shops, relaxing, coffee lovers', 0, 63, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(316, 'Wedding Catering', 'wedding-catering', 'Memorable Wedding Menus', 'Find catering services for your wedding day.', 'wedding catering, catering services, event catering, wedding food, dining experience', 0, 64, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(317, 'Corporate Catering', 'corporate-catering', 'Professional Catering for Business Events', 'Get catering for corporate meetings and events.', 'corporate catering, catering services, event catering, business catering, dining experience', 0, 64, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(318, 'Party Catering', 'party-catering', 'Delicious Food for Parties', 'Explore catering options for birthdays and celebrations.', 'party catering, catering services, event catering, party food, dining experience', 0, 64, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(319, 'Buffet Catering', 'buffet-catering', 'Variety for Your Guests', 'Find buffet-style catering for large events.', 'buffet catering, catering services, event catering, buffet food, dining experience', 0, 64, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(320, 'Custom Catering', 'custom-catering', 'Tailored Menus for Your Event', 'Get customized catering services for unique events.', 'custom catering, catering services, event catering, personalized menus, dining experience', 0, 64, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(321, 'Artisan Breads', 'artisan-breads', 'Freshly Baked Breads', 'Discover bakeries specializing in artisan breads.', 'artisan breads, bakeries, pastries, fresh baked goods, bakery items', 0, 65, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(322, 'Cakes & Cupcakes', 'cakes-cupcakes', 'Celebrate with Sweet Treats', 'Find bakeries offering cakes and cupcakes for special occasions.', 'cakes, cupcakes, bakeries, pastries, desserts', 0, 65, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(323, 'Pastries & Desserts', 'pastries-desserts', 'Indulge in Delicious Pastries', 'Explore bakeries with a variety of pastries and desserts.', 'pastries, desserts, bakeries, sweet treats, bakery items', 0, 65, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(324, 'Gluten-Free Bakeries', 'gluten-free-bakeries', 'Baked Goods for Dietary Needs', 'Find bakeries offering gluten-free options.', 'gluten-free, bakeries, pastries, dietary needs, bakery items', 0, 65, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(325, 'Custom Cakes', 'custom-cakes', 'Personalized Cake Designs', 'Order custom cakes for birthdays, weddings, and more.', 'custom cakes, bakeries, pastries, desserts, bakery items', 0, 65, '2025-03-08 23:38:22', '2025-03-08 23:48:29'),
(326, 'Restaurant Delivery', 'restaurant-delivery', 'Order from Local Restaurants', 'Get your favorite meals delivered from nearby restaurants.', 'restaurant delivery, food delivery, order food, online food order, delivery services', 0, 66, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(327, 'Meal Kits', 'meal-kits', 'Cook at Home with Meal Kits', 'Order meal kits with pre-portioned ingredients for easy cooking.', 'meal kits, food delivery, cooking at home, meal prep, delivery services', 0, 66, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(328, 'Grocery Delivery', 'grocery-delivery', 'Get Groceries Delivered', 'Order groceries online and have them delivered to your door.', 'grocery delivery, food delivery, online shopping, delivery services, grocery shopping', 0, 66, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(329, 'Fast Food Delivery', 'fast-food-delivery', 'Quick Bites Delivered', 'Order fast food from popular chains for quick delivery.', 'fast food delivery, food delivery, order food, online food order, delivery services', 0, 66, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(330, 'Subscription Meal Plans', 'subscription-meal-plans', 'Weekly Meal Deliveries', 'Subscribe to meal plans for regular deliveries of fresh meals.', 'meal plans, food delivery, subscription meals, delivery services, meal prep', 0, 66, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(331, 'Vegan Restaurants', 'vegan-restaurants', 'Plant-Based Dining', 'Discover restaurants offering delicious vegan dishes.', 'vegan restaurants, vegan, plant-based, healthy eating, dining experience', 0, 67, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(332, 'Vegetarian Recipes', 'vegetarian-recipes', 'Cook Healthy Meals at Home', 'Explore recipes for tasty vegetarian meals.', 'vegetarian recipes, vegetarian, plant-based, healthy eating, cooking at home', 0, 67, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(333, 'Vegan Meal Kits', 'vegan-meal-kits', 'Easy Vegan Cooking', 'Order meal kits for quick and easy vegan meals.', 'vegan meal kits, vegan, plant-based, meal prep, cooking at home', 0, 67, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(334, 'Vegetarian Snacks', 'vegetarian-snacks', 'Healthy Snacking Options', 'Find vegetarian snacks for on-the-go energy.', 'vegetarian snacks, vegetarian, plant-based, healthy eating, snacks', 0, 67, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(335, 'Vegan Desserts', 'vegan-desserts', 'Indulge in Sweet Treats', 'Explore vegan desserts for guilt-free indulgence.', 'vegan desserts, vegan, plant-based, desserts, healthy eating', 0, 67, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(336, 'Burgers & Fries', 'burgers-fries', 'Classic Fast Food Favorites', 'Enjoy burgers, fries, and other fast food staples.', 'burgers, fries, fast food, quick meals, fast food restaurants', 0, 68, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(337, 'Pizza Delivery', 'pizza-delivery', 'Order Pizza for Delivery', 'Get your favorite pizzas delivered fast.', 'pizza delivery, fast food, quick meals, pizza, delivery services', 0, 68, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(338, 'Fried Chicken', 'fried-chicken', 'Crispy Fried Chicken', 'Satisfy your cravings with fried chicken meals.', 'fried chicken, fast food, quick meals, fried food, fast food restaurants', 0, 68, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(339, 'Tacos & Burritos', 'tacos-burritos', 'Mexican Fast Food', 'Enjoy tacos, burritos, and other Mexican favorites.', 'tacos, burritos, fast food, quick meals, Mexican food', 0, 68, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(340, 'Fast Food Combos', 'fast-food-combos', 'Value Meals and Combos', 'Find great deals on fast food combos.', 'fast food combos, fast food, quick meals, value meals, fast food restaurants', 0, 68, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(341, 'Gourmet Food Trucks', 'gourmet-food-trucks', 'High-Quality Street Food', 'Discover gourmet food trucks offering unique dishes.', 'gourmet food trucks, food trucks, street food, gourmet food, food trucks near me', 0, 69, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(342, 'Taco Trucks', 'taco-trucks', 'Authentic Tacos on Wheels', 'Enjoy tacos from authentic taco trucks.', 'taco trucks, food trucks, street food, tacos, food trucks near me', 0, 69, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(343, 'Dessert Trucks', 'dessert-trucks', 'Sweet Treats on the Go', 'Find food trucks specializing in desserts.', 'dessert trucks, food trucks, street food, desserts, food trucks near me', 0, 69, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(344, 'Vegan Food Trucks', 'vegan-food-trucks', 'Plant-Based Street Food', 'Explore vegan options from food trucks.', 'vegan food trucks, food trucks, street food, vegan, food trucks near me', 0, 69, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(345, 'Food Truck Events', 'food-truck-events', 'Food Truck Festivals and Gatherings', 'Attend events featuring multiple food trucks.', 'food truck events, food trucks, street food, food truck festivals, food trucks near me', 0, 69, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(346, 'Wine Tasting Tours', 'wine-tasting-tours', 'Explore Local Wineries', 'Join wine tasting tours to sample regional wines.', 'wine tasting, wineries, wine tours, wine tasting near me, wineries near me', 0, 70, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(347, 'Craft Beer Breweries', 'craft-beer-breweries', 'Discover Craft Beers', 'Visit breweries offering unique craft beers.', 'craft beer, breweries, beer tasting, breweries near me, craft breweries', 0, 70, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(348, 'Wine Clubs', 'wine-clubs', 'Join Exclusive Wine Clubs', 'Subscribe to wine clubs for regular deliveries of fine wines.', 'wine clubs, wineries, wine tasting, wine delivery, wine subscriptions', 0, 70, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(349, 'Brewery Tours', 'brewery-tours', 'Learn About Beer Making', 'Take brewery tours to see how craft beer is made.', 'brewery tours, breweries, beer tasting, breweries near me, craft beer', 0, 70, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(350, 'Wine and Beer Pairings', 'wine-beer-pairings', 'Perfect Pairings for Your Meal', 'Learn about pairing wines and beers with food.', 'wine pairings, beer pairings, wineries, breweries, food and drink', 0, 70, '2025-03-08 23:39:46', '2025-03-08 23:48:29'),
(351, 'Casual Wear', 'casual-wear', 'Comfortable Everyday Clothing', 'Find trendy and comfortable casual wear for daily use.', 'casual wear, clothing, apparel, fashion, everyday outfits', 0, 71, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(352, 'Formal Wear', 'formal-wear', 'Elegant Outfits for Special Occasions', 'Discover formal wear for events, weddings, and business meetings.', 'formal wear, clothing, apparel, fashion, elegant outfits', 0, 71, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(353, 'Activewear', 'activewear', 'Stylish Workout Clothing', 'Shop for activewear designed for fitness and sports activities.', 'activewear, clothing, apparel, fitness wear, workout outfits', 0, 71, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(354, 'Seasonal Collections', 'seasonal-collections', 'Trendy Seasonal Fashion', 'Explore clothing collections for spring, summer, fall, and winter.', 'seasonal collections, clothing, apparel, fashion, seasonal outfits', 0, 71, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(355, 'Accessories', 'accessories', 'Complete Your Look', 'Find accessories like belts, scarves, and hats to complement your outfits.', 'accessories, clothing, apparel, fashion, outfit styling', 0, 71, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(356, 'Smartphones', 'smartphones', 'Latest Smartphone Models', 'Shop for the newest smartphones with advanced features.', 'smartphones, electronics, gadgets, tech, mobile phones', 0, 72, '2025-03-08 23:41:08', '2025-03-08 23:48:29');
INSERT INTO `sub_sub_categories` (`id`, `name`, `slug`, `title`, `description`, `keywords`, `views`, `sub_category_id`, `created_at`, `updated_at`) VALUES
(357, 'Wearable Tech', 'wearable-tech', 'Smartwatches and Fitness Trackers', 'Explore wearable tech like smartwatches and fitness bands.', 'wearable tech, electronics, gadgets, smartwatches, fitness trackers', 0, 72, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(358, 'Home Electronics', 'home-electronics', 'Tech for Your Home', 'Find home electronics like smart speakers and security systems.', 'home electronics, electronics, gadgets, smart home, tech products', 0, 72, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(359, 'Gaming Gadgets', 'gaming-gadgets', 'Gear for Gamers', 'Discover gaming consoles, accessories, and peripherals.', 'gaming gadgets, electronics, gadgets, gaming consoles, gaming accessories', 0, 72, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(360, 'Audio Devices', 'audio-devices', 'High-Quality Sound Systems', 'Shop for headphones, speakers, and other audio devices.', 'audio devices, electronics, gadgets, headphones, speakers', 0, 72, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(361, 'Furniture', 'furniture', 'Stylish Home Furniture', 'Find furniture for living rooms, bedrooms, and more.', 'furniture, home, garden, home decor, indoor furniture', 0, 73, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(362, 'Home Decor', 'home-decor', 'Decorate Your Space', 'Explore decor items like rugs, lamps, and wall art.', 'home decor, home, garden, interior design, home improvement', 0, 73, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(363, 'Outdoor Living', 'outdoor-living', 'Create Your Outdoor Oasis', 'Shop for outdoor furniture, grills, and garden accessories.', 'outdoor living, home, garden, outdoor furniture, gardening', 0, 73, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(364, 'Gardening Supplies', 'gardening-supplies', 'Tools for Your Garden', 'Find tools and supplies for gardening and landscaping.', 'gardening supplies, home, garden, gardening tools, landscaping', 0, 73, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(365, 'Storage Solutions', 'storage-solutions', 'Organize Your Home', 'Discover storage solutions for every room in your house.', 'storage solutions, home, garden, home organization, storage furniture', 0, 73, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(366, 'Skincare', 'skincare', 'Healthy and Glowing Skin', 'Explore skincare products for all skin types.', 'skincare, beauty, personal care, skincare products, beauty routine', 0, 74, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(367, 'Haircare', 'haircare', 'Stylish and Healthy Hair', 'Find haircare products for styling and maintenance.', 'haircare, beauty, personal care, haircare products, hair styling', 0, 74, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(368, 'Makeup', 'makeup', 'Enhance Your Look', 'Discover makeup products for every occasion.', 'makeup, beauty, personal care, makeup products, beauty routine', 0, 74, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(369, 'Grooming Products', 'grooming-products', 'Personal Care for Men', 'Shop for grooming products like razors and beard care.', 'grooming products, beauty, personal care, men’s grooming, grooming tools', 0, 74, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(370, 'Fragrances', 'fragrances', 'Find Your Signature Scent', 'Explore perfumes and colognes for men and women.', 'fragrances, beauty, personal care, perfumes, colognes', 0, 74, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(371, 'Engagement Rings', 'engagement-rings', 'Symbols of Love and Commitment', 'Find the perfect engagement ring for your partner.', 'engagement rings, jewelry, watches, luxury accessories, wedding rings', 0, 75, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(372, 'Necklaces & Pendants', 'necklaces-pendants', 'Elegant Neckwear', 'Explore necklaces and pendants for any occasion.', 'necklaces, pendants, jewelry, watches, luxury accessories', 0, 75, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(373, 'Watches', 'watches', 'Timeless Timepieces', 'Shop for stylish watches for men and women.', 'watches, jewelry, watches, luxury accessories, timepieces', 0, 75, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(374, 'Bracelets & Bangles', 'bracelets-bangles', 'Adorn Your Wrist', 'Discover bracelets and bangles to complement your style.', 'bracelets, bangles, jewelry, watches, luxury accessories', 0, 75, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(375, 'Earrings', 'earrings', 'Sparkling Ear Accessories', 'Find earrings for casual and formal occasions.', 'earrings, jewelry, watches, luxury accessories, ear jewelry', 0, 75, '2025-03-08 23:41:08', '2025-03-08 23:48:29'),
(376, 'Living Room Furniture', 'living-room-furniture', 'Stylish Sofas and Chairs', 'Find comfortable and stylish furniture for your living room.', 'living room furniture, furniture, sofas, chairs, home decor', 0, 76, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(377, 'Bedroom Furniture', 'bedroom-furniture', 'Cozy Beds and Storage', 'Shop for beds, dressers, and nightstands for your bedroom.', 'bedroom furniture, furniture, beds, dressers, home decor', 0, 76, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(378, 'Dining Room Furniture', 'dining-room-furniture', 'Elegant Dining Sets', 'Discover dining tables and chairs for family meals.', 'dining room furniture, furniture, dining tables, chairs, home decor', 0, 76, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(379, 'Home Office Furniture', 'home-office-furniture', 'Productive Workspaces', 'Find desks, chairs, and storage for your home office.', 'home office furniture, furniture, desks, office chairs, home decor', 0, 76, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(380, 'Outdoor Furniture', 'outdoor-furniture', 'Relax in Your Outdoor Space', 'Shop for patio furniture and outdoor lounging sets.', 'outdoor furniture, furniture, patio furniture, outdoor decor, home decor', 0, 76, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(381, 'Camping Gear', 'camping-gear', 'Essential Camping Equipment', 'Find tents, sleeping bags, and other camping essentials.', 'camping gear, sports, outdoors, camping equipment, outdoor adventure', 0, 77, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(382, 'Fitness Equipment', 'fitness-equipment', 'Gear for Your Workout', 'Shop for gym equipment like weights, treadmills, and yoga mats.', 'fitness equipment, sports, outdoors, gym gear, fitness accessories', 0, 77, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(383, 'Hiking Gear', 'hiking-gear', 'Explore the Great Outdoors', 'Discover backpacks, boots, and hiking accessories.', 'hiking gear, sports, outdoors, hiking equipment, outdoor adventure', 0, 77, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(384, 'Cycling Gear', 'cycling-gear', 'Ride in Style and Safety', 'Find bikes, helmets, and cycling accessories.', 'cycling gear, sports, outdoors, bikes, cycling accessories', 0, 77, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(385, 'Water Sports Gear', 'water-sports-gear', 'Gear for Aquatic Adventures', 'Explore equipment for kayaking, surfing, and more.', 'water sports gear, sports, outdoors, kayaking, surfing equipment', 0, 77, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(386, 'Kids Toys', 'kids-toys', 'Fun for Children', 'Discover toys for kids of all ages.', 'kids toys, toys, games, children’s toys, fun activities', 0, 78, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(387, 'Board Games', 'board-games', 'Family Game Night', 'Find classic and modern board games for all ages.', 'board games, toys, games, family games, fun activities', 0, 78, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(388, 'Puzzles', 'puzzles', 'Challenge Your Mind', 'Shop for jigsaw puzzles and brain teasers.', 'puzzles, toys, games, jigsaw puzzles, brain teasers', 0, 78, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(389, 'Outdoor Toys', 'outdoor-toys', 'Fun in the Sun', 'Explore toys for outdoor play and activities.', 'outdoor toys, toys, games, outdoor play, fun activities', 0, 78, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(390, 'Educational Toys', 'educational-toys', 'Learn Through Play', 'Find toys that combine fun and learning.', 'educational toys, toys, games, learning toys, fun activities', 0, 78, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(391, 'Gym Equipment', 'gym-equipment', 'Build Your Home Gym', 'Shop for weights, machines, and fitness gear.', 'gym equipment, health, fitness, workout gear, fitness accessories', 0, 79, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(392, 'Fitness Trackers', 'fitness-trackers', 'Monitor Your Progress', 'Find wearable devices to track your fitness goals.', 'fitness trackers, health, fitness, wearable tech, fitness accessories', 0, 79, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(393, 'Supplements', 'supplements', 'Boost Your Health', 'Explore vitamins, protein powders, and other supplements.', 'supplements, health, fitness, vitamins, protein powders', 0, 79, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(394, 'Yoga & Pilates', 'yoga-pilates', 'Relax and Strengthen', 'Find mats, blocks, and accessories for yoga and Pilates.', 'yoga, Pilates, health, fitness, yoga accessories', 0, 79, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(395, 'Recovery Tools', 'recovery-tools', 'Recover After Workouts', 'Shop for foam rollers, massage guns, and more.', 'recovery tools, health, fitness, foam rollers, massage guns', 0, 79, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(396, 'Pet Food', 'pet-food', 'Nutritious Meals for Pets', 'Find high-quality food for cats, dogs, and other pets.', 'pet food, pet supplies, dog food, cat food, pet nutrition', 0, 80, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(397, 'Pet Toys', 'pet-toys', 'Fun for Your Furry Friends', 'Discover toys to keep your pets entertained.', 'pet toys, pet supplies, dog toys, cat toys, pet entertainment', 0, 80, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(398, 'Pet Grooming', 'pet-grooming', 'Keep Your Pets Clean', 'Shop for grooming products like brushes and shampoos.', 'pet grooming, pet supplies, grooming tools, pet care, pet hygiene', 0, 80, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(399, 'Pet Accessories', 'pet-accessories', 'Stylish and Functional Items', 'Find collars, leashes, and beds for your pets.', 'pet accessories, pet supplies, collars, leashes, pet beds', 0, 80, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(400, 'Pet Health Products', 'pet-health-products', 'Keep Your Pets Healthy', 'Explore supplements and health products for pets.', 'pet health, pet supplies, pet supplements, pet care, pet wellness', 0, 80, '2025-03-08 23:42:26', '2025-03-08 23:48:29'),
(401, 'Living Room Furniture', 'living-room-furniture', 'Stylish Sofas and Chairs', 'Find comfortable and stylish furniture for your living room.', 'living room furniture, furniture, sofas, chairs, home decor', 0, 81, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(402, 'Bedroom Furniture', 'bedroom-furniture', 'Cozy Beds and Storage', 'Shop for beds, dressers, and nightstands for your bedroom.', 'bedroom furniture, furniture, beds, dressers, home decor', 0, 81, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(403, 'Dining Room Furniture', 'dining-room-furniture', 'Elegant Dining Sets', 'Discover dining tables and chairs for family meals.', 'dining room furniture, furniture, dining tables, chairs, home decor', 0, 81, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(404, 'Home Office Furniture', 'home-office-furniture', 'Productive Workspaces', 'Find desks, chairs, and storage for your home office.', 'home office furniture, furniture, desks, office chairs, home decor', 0, 81, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(405, 'Outdoor Furniture', 'outdoor-furniture', 'Relax in Your Outdoor Space', 'Shop for patio furniture and outdoor lounging sets.', 'outdoor furniture, furniture, patio furniture, outdoor decor, home decor', 0, 81, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(406, 'Wall Art', 'wall-art', 'Decorate Your Walls', 'Find paintings, prints, and wall decor to enhance your space.', 'wall art, home decor, decorative accessories, wall decor, home accents', 0, 82, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(407, 'Decorative Accessories', 'decorative-accessories', 'Add Style to Your Home', 'Explore vases, sculptures, and other decorative items.', 'decorative accessories, home decor, home accents, elegant decor, decorative items', 0, 82, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(408, 'Rugs & Carpets', 'rugs-carpets', 'Soft and Stylish Flooring', 'Shop for rugs and carpets to add warmth to your home.', 'rugs, carpets, home decor, floor decor, home accents', 0, 82, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(409, 'Curtains & Blinds', 'curtains-blinds', 'Window Treatments for Privacy and Style', 'Find curtains and blinds to enhance your windows.', 'curtains, blinds, home decor, window treatments, home accents', 0, 82, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(410, 'Seasonal Decor', 'seasonal-decor', 'Celebrate Every Season', 'Discover decor items for holidays and seasonal themes.', 'seasonal decor, home decor, holiday decor, seasonal themes, home accents', 0, 82, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(411, 'Cookware', 'cookware', 'Essential Pots and Pans', 'Find high-quality cookware for your kitchen.', 'cookware, kitchenware, pots, pans, modern kitchen', 0, 83, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(412, 'Utensils', 'utensils', 'Tools for Cooking and Baking', 'Shop for utensils like spatulas, ladles, and whisks.', 'utensils, kitchenware, cooking tools, baking tools, modern kitchen', 0, 83, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(413, 'Kitchen Gadgets', 'kitchen-gadgets', 'Innovative Tools for Your Kitchen', 'Discover gadgets to make cooking easier and more efficient.', 'kitchen gadgets, kitchenware, cooking tools, modern kitchen, kitchen accessories', 0, 83, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(414, 'Dinnerware', 'dinnerware', 'Stylish Plates and Bowls', 'Find dinnerware sets for everyday use and special occasions.', 'dinnerware, kitchenware, plates, bowls, modern kitchen', 0, 83, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(415, 'Storage Solutions', 'storage-solutions', 'Organize Your Kitchen', 'Explore containers and organizers for your kitchen.', 'storage solutions, kitchenware, kitchen organizers, modern kitchen, kitchen storage', 0, 83, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(416, 'Chandeliers', 'chandeliers', 'Elegant Lighting for Your Home', 'Discover chandeliers to add a touch of luxury.', 'chandeliers, lighting, light fixtures, home lighting, elegant decor', 0, 84, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(417, 'Table Lamps', 'table-lamps', 'Functional and Stylish Lighting', 'Find table lamps for your living room or bedroom.', 'table lamps, lighting, light fixtures, home lighting, decorative lighting', 0, 84, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(418, 'Ceiling Lights', 'ceiling-lights', 'Illuminate Your Space', 'Shop for ceiling lights to brighten any room.', 'ceiling lights, lighting, light fixtures, home lighting, modern lighting', 0, 84, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(419, 'Outdoor Lighting', 'outdoor-lighting', 'Light Up Your Outdoor Spaces', 'Explore lighting options for your garden or patio.', 'outdoor lighting, lighting, light fixtures, home lighting, outdoor decor', 0, 84, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(420, 'Smart Lighting', 'smart-lighting', 'Modern and Convenient Lighting', 'Discover smart lighting solutions for your home.', 'smart lighting, lighting, light fixtures, home lighting, modern technology', 0, 84, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(421, 'Sheets & Pillowcases', 'sheets-pillowcases', 'Soft and Comfortable Bedding', 'Find high-quality sheets and pillowcases for a good night’s sleep.', 'sheets, pillowcases, bedding, linens, bed sets', 0, 85, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(422, 'Comforters & Duvets', 'comforters-duvets', 'Warm and Cozy Bedding', 'Shop for comforters and duvets to keep you warm.', 'comforters, duvets, bedding, linens, bed sets', 0, 85, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(423, 'Blankets & Throws', 'blankets-throws', 'Add Warmth to Your Bed', 'Discover cozy blankets and throws for your bedroom.', 'blankets, throws, bedding, linens, bed sets', 0, 85, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(424, 'Bed Skirts & Valances', 'bed-skirts-valances', 'Complete Your Bed Look', 'Find bed skirts and valances for a polished appearance.', 'bed skirts, valances, bedding, linens, bed sets', 0, 85, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(425, 'Mattress Protectors', 'mattress-protectors', 'Protect Your Mattress', 'Shop for mattress protectors to extend the life of your mattress.', 'mattress protectors, bedding, linens, bed sets, mattress care', 0, 85, '2025-03-08 23:43:55', '2025-03-08 23:48:29'),
(426, 'Shelving Units', 'shelving-units', 'Organize with Shelves', 'Find shelving units for storing and displaying items.', 'shelving units, storage, organization, shelves, home organization', 0, 86, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(427, 'Storage Bins', 'storage-bins', 'Keep Items Neat and Tidy', 'Shop for storage bins to organize your belongings.', 'storage bins, storage, organization, bins, home organization', 0, 86, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(428, 'Closet Organizers', 'closet-organizers', 'Maximize Closet Space', 'Discover organizers to keep your closet clutter-free.', 'closet organizers, storage, organization, home organization, closet storage', 0, 86, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(429, 'Pantry Storage', 'pantry-storage', 'Organize Your Pantry', 'Find solutions for storing food and kitchen supplies.', 'pantry storage, storage, organization, home organization, kitchen storage', 0, 86, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(430, 'Garage Storage', 'garage-storage', 'Declutter Your Garage', 'Explore storage solutions for your garage.', 'garage storage, storage, organization, home organization, garage organization', 0, 86, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(431, 'Refrigerators', 'refrigerators', 'Keep Your Food Fresh', 'Shop for refrigerators in various sizes and styles.', 'refrigerators, appliances, home appliances, kitchen appliances, refrigeration', 0, 87, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(432, 'Washers & Dryers', 'washers-dryers', 'Efficient Laundry Appliances', 'Find washers and dryers for your laundry needs.', 'washers, dryers, appliances, home appliances, laundry appliances', 0, 87, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(433, 'Kitchen Appliances', 'kitchen-appliances', 'Upgrade Your Kitchen', 'Discover essential kitchen appliances like ovens and microwaves.', 'kitchen appliances, appliances, home appliances, ovens, microwaves', 0, 87, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(434, 'Small Appliances', 'small-appliances', 'Convenient Tools for Your Home', 'Find small appliances like blenders and coffee makers.', 'small appliances, appliances, home appliances, blenders, coffee makers', 0, 87, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(435, 'Smart Appliances', 'smart-appliances', 'Modern and Connected Devices', 'Explore smart appliances for a connected home.', 'smart appliances, appliances, home appliances, smart home, modern technology', 0, 87, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(436, 'Patio Sets', 'patio-sets', 'Relax in Your Outdoor Space', 'Find patio sets for dining and lounging outdoors.', 'patio sets, outdoor furniture, garden furniture, outdoor seating, patio furniture', 0, 88, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(437, 'Lounge Chairs', 'lounge-chairs', 'Comfortable Outdoor Seating', 'Shop for lounge chairs for your garden or balcony.', 'lounge chairs, outdoor furniture, garden furniture, outdoor seating, patio furniture', 0, 88, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(438, 'Outdoor Dining Sets', 'outdoor-dining-sets', 'Dine Al Fresco', 'Discover dining sets for outdoor meals.', 'outdoor dining sets, outdoor furniture, garden furniture, outdoor seating, patio furniture', 0, 88, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(439, 'Outdoor Sofas', 'outdoor-sofas', 'Stylish Outdoor Lounging', 'Find sofas designed for outdoor relaxation.', 'outdoor sofas, outdoor furniture, garden furniture, outdoor seating, patio furniture', 0, 88, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(440, 'Outdoor Accessories', 'outdoor-accessories', 'Enhance Your Outdoor Space', 'Explore accessories like umbrellas and cushions.', 'outdoor accessories, outdoor furniture, garden furniture, outdoor seating, patio furniture', 0, 88, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(441, 'Gardening Tools', 'gardening-tools', 'Essential Tools for Gardeners', 'Find tools like shovels, rakes, and pruners.', 'gardening tools, gardening, landscaping, garden tools, outdoor spaces', 0, 89, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(442, 'Plants & Seeds', 'plants-seeds', 'Grow Your Own Garden', 'Shop for plants, seeds, and bulbs for your garden.', 'plants, seeds, gardening, landscaping, garden supplies', 0, 89, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(443, 'Outdoor Decor', 'outdoor-decor', 'Beautify Your Garden', 'Discover decor items like statues and fountains.', 'outdoor decor, gardening, landscaping, garden decor, outdoor spaces', 0, 89, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(444, 'Lawn Care', 'lawn-care', 'Maintain a Healthy Lawn', 'Find products for lawn care and maintenance.', 'lawn care, gardening, landscaping, lawn maintenance, outdoor spaces', 0, 89, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(445, 'Garden Furniture', 'garden-furniture', 'Relax in Your Garden', 'Shop for furniture designed for outdoor spaces.', 'garden furniture, gardening, landscaping, outdoor furniture, outdoor spaces', 0, 89, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(446, 'DIY Tools', 'diy-tools', 'Tools for Home Projects', 'Find tools for DIY home improvement projects.', 'DIY tools, home improvement, tools, home renovation, DIY projects', 0, 90, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(447, 'Building Materials', 'building-materials', 'Materials for Construction', 'Shop for materials like lumber and cement.', 'building materials, home improvement, construction materials, home renovation, DIY projects', 0, 90, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(448, 'Paint & Supplies', 'paint-supplies', 'Refresh Your Home with Paint', 'Find paint and supplies for home improvement.', 'paint, supplies, home improvement, home renovation, DIY projects', 0, 90, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(449, 'Plumbing Supplies', 'plumbing-supplies', 'Fix and Upgrade Plumbing', 'Discover plumbing tools and materials.', 'plumbing supplies, home improvement, plumbing tools, home renovation, DIY projects', 0, 90, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(450, 'Electrical Supplies', 'electrical-supplies', 'Upgrade Your Electrical Systems', 'Find tools and materials for electrical work.', 'electrical supplies, home improvement, electrical tools, home renovation, DIY projects', 0, 90, '2025-03-08 23:45:16', '2025-03-08 23:48:29'),
(451, 'New Cars', 'new-cars', 'Explore New Car Models', 'Find the latest car models from top brands.', 'new cars, car dealerships, car buying, vehicle sales, new car models', 0, 91, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(452, 'Certified Pre-Owned', 'certified-pre-owned', 'Quality Pre-Owned Vehicles', 'Shop for certified pre-owned cars with warranties.', 'certified pre-owned, car dealerships, car buying, vehicle sales, used cars', 0, 91, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(453, 'Luxury Cars', 'luxury-cars', 'High-End Vehicles', 'Discover luxury cars from premium brands.', 'luxury cars, car dealerships, car buying, vehicle sales, premium cars', 0, 91, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(454, 'Electric Vehicles', 'electric-vehicles', 'Eco-Friendly Cars', 'Explore electric and hybrid vehicles.', 'electric vehicles, car dealerships, car buying, vehicle sales, eco-friendly cars', 0, 91, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(455, 'Car Financing', 'car-financing', 'Finance Your Next Car', 'Find financing options for your vehicle purchase.', 'car financing, car dealerships, car buying, vehicle sales, auto loans', 0, 91, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(456, 'Interior Accessories', 'interior-accessories', 'Upgrade Your Car Interior', 'Find accessories like seat covers and organizers.', 'interior accessories, car accessories, vehicle accessories, car gadgets, car upgrades', 0, 92, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(457, 'Exterior Accessories', 'exterior-accessories', 'Enhance Your Car Exterior', 'Shop for accessories like spoilers and roof racks.', 'exterior accessories, car accessories, vehicle accessories, car gadgets, car upgrades', 0, 92, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(458, 'Car Electronics', 'car-electronics', 'Tech for Your Vehicle', 'Discover gadgets like GPS systems and dash cams.', 'car electronics, car accessories, vehicle accessories, car gadgets, car upgrades', 0, 92, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(459, 'Car Care Products', 'car-care-products', 'Keep Your Car Clean', 'Find cleaning and maintenance products.', 'car care products, car accessories, vehicle accessories, car cleaning, car maintenance', 0, 92, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(460, 'Safety Accessories', 'safety-accessories', 'Stay Safe on the Road', 'Explore safety gear like emergency kits and cameras.', 'safety accessories, car accessories, vehicle accessories, car safety, car gadgets', 0, 92, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(461, 'Oil Changes', 'oil-changes', 'Regular Oil Change Services', 'Find services for quick and reliable oil changes.', 'oil changes, auto repair, car maintenance, vehicle service, car repairs', 0, 93, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(462, 'Brake Repairs', 'brake-repairs', 'Expert Brake Services', 'Get your brakes inspected and repaired.', 'brake repairs, auto repair, car maintenance, vehicle service, car repairs', 0, 93, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(463, 'Engine Repairs', 'engine-repairs', 'Fix Engine Issues', 'Find services for engine diagnostics and repairs.', 'engine repairs, auto repair, car maintenance, vehicle service, car repairs', 0, 93, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(464, 'Tire Services', 'tire-services', 'Tire Maintenance and Repairs', 'Shop for tire rotation, balancing, and repairs.', 'tire services, auto repair, car maintenance, vehicle service, car repairs', 0, 93, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(465, 'Car Detailing', 'car-detailing', 'Professional Car Cleaning', 'Discover services for interior and exterior detailing.', 'car detailing, auto repair, car maintenance, vehicle service, car cleaning', 0, 93, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(466, 'Cruiser Motorcycles', 'cruiser-motorcycles', 'Comfortable and Stylish Rides', 'Find cruiser motorcycles for long rides.', 'cruiser motorcycles, motorcycle dealerships, motorcycles, motorbikes, new motorcycles', 0, 94, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(467, 'Sport Bikes', 'sport-bikes', 'High-Performance Motorcycles', 'Explore sport bikes for speed and agility.', 'sport bikes, motorcycle dealerships, motorcycles, motorbikes, new motorcycles', 0, 94, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(468, 'Touring Motorcycles', 'touring-motorcycles', 'Ideal for Long-Distance Travel', 'Discover touring motorcycles for adventure.', 'touring motorcycles, motorcycle dealerships, motorcycles, motorbikes, new motorcycles', 0, 94, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(469, 'Used Motorcycles', 'used-motorcycles', 'Affordable Pre-Owned Bikes', 'Shop for used motorcycles at great prices.', 'used motorcycles, motorcycle dealerships, motorcycles, motorbikes, pre-owned bikes', 0, 94, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(470, 'Motorcycle Financing', 'motorcycle-financing', 'Finance Your Motorcycle Purchase', 'Find financing options for your bike.', 'motorcycle financing, motorcycle dealerships, motorcycles, motorbikes, auto loans', 0, 94, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(471, 'All-Season Tires', 'all-season-tires', 'Versatile Tires for Every Season', 'Find tires designed for year-round use.', 'all-season tires, tires, wheels, vehicle tires, tire replacement', 0, 95, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(472, 'Performance Tires', 'performance-tires', 'High-Performance Tires', 'Shop for tires designed for speed and handling.', 'performance tires, tires, wheels, vehicle tires, tire replacement', 0, 95, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(473, 'Winter Tires', 'winter-tires', 'Tires for Cold Weather', 'Discover tires designed for snow and ice.', 'winter tires, tires, wheels, vehicle tires, tire replacement', 0, 95, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(474, 'Custom Wheels', 'custom-wheels', 'Upgrade Your Wheels', 'Find stylish and durable custom wheels.', 'custom wheels, tires, wheels, vehicle tires, tire replacement', 0, 95, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(475, 'Tire Installation', 'tire-installation', 'Professional Tire Services', 'Get your tires installed and balanced.', 'tire installation, tires, wheels, vehicle tires, tire replacement', 0, 95, '2025-03-08 23:46:42', '2025-03-08 23:48:29'),
(476, 'Car Rentals', 'car-rentals', 'Rent a Car for Your Trip', 'Find car rentals for short-term or long-term use.', 'car rentals, vehicle rentals, rental cars, car hire, travel rentals', 0, 96, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(477, 'SUV Rentals', 'suv-rentals', 'Spacious SUV Rentals', 'Rent SUVs for family trips or group travel.', 'SUV rentals, vehicle rentals, rental cars, car hire, travel rentals', 0, 96, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(478, 'Van Rentals', 'van-rentals', 'Rent a Van for Group Travel', 'Discover van rentals for larger groups or cargo needs.', 'van rentals, vehicle rentals, rental cars, car hire, travel rentals', 0, 96, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(479, 'Luxury Car Rentals', 'luxury-car-rentals', 'Rent Premium Vehicles', 'Explore luxury car rentals for special occasions.', 'luxury car rentals, vehicle rentals, rental cars, car hire, travel rentals', 0, 96, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(480, 'Long-Term Rentals', 'long-term-rentals', 'Extended Vehicle Rentals', 'Find long-term rental options for extended trips.', 'long-term rentals, vehicle rentals, rental cars, car hire, travel rentals', 0, 96, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(481, 'Electric Sedans', 'electric-sedans', 'Eco-Friendly Sedans', 'Explore electric sedans for efficient and stylish driving.', 'electric sedans, electric vehicles, EV, eco-friendly cars, electric cars', 0, 97, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(482, 'Electric SUVs', 'electric-suvs', 'Spacious Electric SUVs', 'Discover electric SUVs for families and long trips.', 'electric SUVs, electric vehicles, EV, eco-friendly cars, electric cars', 0, 97, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(483, 'Hybrid Vehicles', 'hybrid-vehicles', 'Fuel-Efficient Hybrids', 'Find hybrid vehicles combining gas and electric power.', 'hybrid vehicles, electric vehicles, EV, eco-friendly cars, hybrid cars', 0, 97, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(484, 'Charging Stations', 'charging-stations', 'EV Charging Solutions', 'Locate charging stations for electric vehicles.', 'charging stations, electric vehicles, EV, eco-friendly cars, electric cars', 0, 97, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(485, 'EV Accessories', 'ev-accessories', 'Enhance Your Electric Vehicle', 'Shop for accessories designed for electric vehicles.', 'EV accessories, electric vehicles, EV, eco-friendly cars, electric cars', 0, 97, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(486, 'Comprehensive Insurance', 'comprehensive-insurance', 'Full Coverage for Your Car', 'Find comprehensive insurance plans for complete protection.', 'comprehensive insurance, car insurance, auto insurance, vehicle insurance, insurance plans', 0, 98, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(487, 'Liability Insurance', 'liability-insurance', 'Basic Coverage for Accidents', 'Get liability insurance for legal and financial protection.', 'liability insurance, car insurance, auto insurance, vehicle insurance, insurance plans', 0, 98, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(488, 'Collision Insurance', 'collision-insurance', 'Coverage for Collisions', 'Discover collision insurance for accident-related damages.', 'collision insurance, car insurance, auto insurance, vehicle insurance, insurance plans', 0, 98, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(489, 'Insurance Discounts', 'insurance-discounts', 'Save on Car Insurance', 'Find discounts and deals on car insurance plans.', 'insurance discounts, car insurance, auto insurance, vehicle insurance, insurance plans', 0, 98, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(490, 'Insurance Comparison', 'insurance-comparison', 'Compare Insurance Plans', 'Compare car insurance options to find the best deal.', 'insurance comparison, car insurance, auto insurance, vehicle insurance, insurance plans', 0, 98, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(491, 'Car Loans', 'car-loans', 'Finance Your Vehicle Purchase', 'Explore car loans for buying new or used vehicles.', 'car loans, auto financing, vehicle financing, car financing, financing options', 0, 99, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(492, 'Lease Options', 'lease-options', 'Flexible Lease Plans', 'Find lease options for driving a new car.', 'lease options, auto financing, vehicle financing, car leases, financing options', 0, 99, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(493, 'Refinancing', 'refinancing', 'Lower Your Car Payments', 'Refinance your car loan for better rates.', 'refinancing, auto financing, vehicle financing, car loans, financing options', 0, 99, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(494, 'Bad Credit Financing', 'bad-credit-financing', 'Financing for All Credit Scores', 'Get auto financing options for bad credit.', 'bad credit financing, auto financing, vehicle financing, car loans, financing options', 0, 99, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(495, 'Dealer Financing', 'dealer-financing', 'Convenient Financing at Dealerships', 'Explore financing options offered by car dealerships.', 'dealer financing, auto financing, vehicle financing, car loans, financing options', 0, 99, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(496, 'Engine Parts', 'engine-parts', 'Keep Your Engine Running', 'Find engine parts for repairs and maintenance.', 'engine parts, vehicle parts, auto supplies, car parts, car maintenance', 0, 100, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(497, 'Brake Components', 'brake-components', 'Essential Brake Parts', 'Shop for brake pads, rotors, and other components.', 'brake components, vehicle parts, auto supplies, car parts, car maintenance', 0, 100, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(498, 'Exhaust Systems', 'exhaust-systems', 'Upgrade Your Exhaust', 'Discover exhaust systems for better performance.', 'exhaust systems, vehicle parts, auto supplies, car parts, car maintenance', 0, 100, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(499, 'Car Batteries', 'car-batteries', 'Reliable Power for Your Vehicle', 'Find car batteries for reliable starting power.', 'car batteries, vehicle parts, auto supplies, car parts, car maintenance', 0, 100, '2025-03-08 23:48:01', '2025-03-08 23:48:29'),
(500, 'Car Accessories', 'car-accessories', 'Enhance Your Vehicle', 'Shop for accessories like seat covers and floor mats.', 'car accessories, vehicle parts, auto supplies, car parts, car maintenance', 0, 100, '2025-03-08 23:48:01', '2025-03-08 23:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int UNSIGNED NOT NULL,
  `countries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `alias`, `version`, `preview_image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', NULL, 'themes/basic/images/preview.jpg', 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics.', '2024-10-14 22:14:20', '2024-10-14 22:14:20');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `fees` double NOT NULL DEFAULT '0',
  `tax` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `payment_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_proof` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:Unpaid 1:Pending 2:Paid 3:Cancelled',
  `cancellation_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_owner_id` bigint UNSIGNED NOT NULL,
  `plan_id` bigint UNSIGNED NOT NULL,
  `payment_gateway_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translates`
--

CREATE TABLE `translates` (
  `id` bigint UNSIGNED NOT NULL,
  `key` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('dynamic','manual') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dynamic',
  `lang` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translates`
--

INSERT INTO `translates` (`id`, `key`, `value`, `type`, `lang`) VALUES
(2, 'The :attribute field must be accepted.', 'The :attribute field must be accepted.', 'dynamic', 'en'),
(3, 'The :attribute field must be accepted when :other is :value.', 'The :attribute field must be accepted when :other is :value.', 'dynamic', 'en'),
(4, 'The :attribute field must be a valid URL.', 'The :attribute field must be a valid URL.', 'dynamic', 'en'),
(5, 'The :attribute field must be a date after :date.', 'The :attribute field must be a date after :date.', 'dynamic', 'en'),
(6, 'The :attribute field must be a date after or equal to :date.', 'The :attribute field must be a date after or equal to :date.', 'dynamic', 'en'),
(7, 'The :attribute field must only contain letters.', 'The :attribute field must only contain letters.', 'dynamic', 'en'),
(8, 'The :attribute field must only contain letters, numbers, dashes, and underscores.', 'The :attribute field must only contain letters, numbers, dashes, and underscores.', 'dynamic', 'en'),
(9, 'The :attribute field must only contain letters and numbers.', 'The :attribute field must only contain letters and numbers.', 'dynamic', 'en'),
(10, 'The :attribute field must be an array.', 'The :attribute field must be an array.', 'dynamic', 'en'),
(11, 'The :attribute field must only contain single-byte alphanumeric characters and symbols.', 'The :attribute field must only contain single-byte alphanumeric characters and symbols.', 'dynamic', 'en'),
(12, 'The :attribute field must be a date before :date.', 'The :attribute field must be a date before :date.', 'dynamic', 'en'),
(13, 'The :attribute field must be a date before or equal to :date.', 'The :attribute field must be a date before or equal to :date.', 'dynamic', 'en'),
(14, 'The :attribute field must have between :min and :max items.', 'The :attribute field must have between :min and :max items.', 'dynamic', 'en'),
(15, 'The :attribute field must be between :min and :max kilobytes.', 'The :attribute field must be between :min and :max kilobytes.', 'dynamic', 'en'),
(16, 'The :attribute field must be between :min and :max.', 'The :attribute field must be between :min and :max.', 'dynamic', 'en'),
(17, 'The :attribute field must be between :min and :max characters.', 'The :attribute field must be between :min and :max characters.', 'dynamic', 'en'),
(18, 'The :attribute field must be true or false.', 'The :attribute field must be true or false.', 'dynamic', 'en'),
(19, 'The :attribute field contains an unauthorized value.', 'The :attribute field contains an unauthorized value.', 'dynamic', 'en'),
(20, 'The :attribute field confirmation does not match.', 'The :attribute field confirmation does not match.', 'dynamic', 'en'),
(21, 'The :attribute field is missing a required value.', 'The :attribute field is missing a required value.', 'dynamic', 'en'),
(22, 'The password is incorrect.', 'The password is incorrect.', 'dynamic', 'en'),
(23, 'The :attribute field must be a valid date.', 'The :attribute field must be a valid date.', 'dynamic', 'en'),
(24, 'The :attribute field must be a date equal to :date.', 'The :attribute field must be a date equal to :date.', 'dynamic', 'en'),
(25, 'The :attribute field must match the format :format.', 'The :attribute field must match the format :format.', 'dynamic', 'en'),
(26, 'The :attribute field must have :decimal decimal places.', 'The :attribute field must have :decimal decimal places.', 'dynamic', 'en'),
(27, 'The :attribute field must be declined.', 'The :attribute field must be declined.', 'dynamic', 'en'),
(28, 'The :attribute field must be declined when :other is :value.', 'The :attribute field must be declined when :other is :value.', 'dynamic', 'en'),
(29, 'The :attribute field and :other must be different.', 'The :attribute field and :other must be different.', 'dynamic', 'en'),
(30, 'The :attribute field must be :digits digits.', 'The :attribute field must be :digits digits.', 'dynamic', 'en'),
(31, 'The :attribute field must be between :min and :max digits.', 'The :attribute field must be between :min and :max digits.', 'dynamic', 'en'),
(32, 'The :attribute field has invalid image dimensions.', 'The :attribute field has invalid image dimensions.', 'dynamic', 'en'),
(33, 'The :attribute field has a duplicate value.', 'The :attribute field has a duplicate value.', 'dynamic', 'en'),
(34, 'The :attribute field must not end with one of the following: :values.', 'The :attribute field must not end with one of the following: :values.', 'dynamic', 'en'),
(35, 'The :attribute field must not start with one of the following: :values.', 'The :attribute field must not start with one of the following: :values.', 'dynamic', 'en'),
(36, 'The :attribute field must be a valid email address.', 'The :attribute field must be a valid email address.', 'dynamic', 'en'),
(37, 'The :attribute field must end with one of the following: :values.', 'The :attribute field must end with one of the following: :values.', 'dynamic', 'en'),
(38, 'The selected :attribute is invalid.', 'The selected :attribute is invalid.', 'dynamic', 'en'),
(39, 'The :attribute field must have one of the following extensions: :values.', 'The :attribute field must have one of the following extensions: :values.', 'dynamic', 'en'),
(40, 'The :attribute field must be a file.', 'The :attribute field must be a file.', 'dynamic', 'en'),
(41, 'The :attribute field must have a value.', 'The :attribute field must have a value.', 'dynamic', 'en'),
(42, 'The :attribute field must have more than :value items.', 'The :attribute field must have more than :value items.', 'dynamic', 'en'),
(43, 'The :attribute field must be greater than :value kilobytes.', 'The :attribute field must be greater than :value kilobytes.', 'dynamic', 'en'),
(44, 'The :attribute field must be greater than :value.', 'The :attribute field must be greater than :value.', 'dynamic', 'en'),
(45, 'The :attribute field must be greater than :value characters.', 'The :attribute field must be greater than :value characters.', 'dynamic', 'en'),
(46, 'The :attribute field must have :value items or more.', 'The :attribute field must have :value items or more.', 'dynamic', 'en'),
(47, 'The :attribute field must be greater than or equal to :value kilobytes.', 'The :attribute field must be greater than or equal to :value kilobytes.', 'dynamic', 'en'),
(48, 'The :attribute field must be greater than or equal to :value.', 'The :attribute field must be greater than or equal to :value.', 'dynamic', 'en'),
(49, 'The :attribute field must be greater than or equal to :value characters.', 'The :attribute field must be greater than or equal to :value characters.', 'dynamic', 'en'),
(50, 'The :attribute field must be a valid hexadecimal color.', 'The :attribute field must be a valid hexadecimal color.', 'dynamic', 'en'),
(51, 'The :attribute field must be an image.', 'The :attribute field must be an image.', 'dynamic', 'en'),
(52, 'The :attribute field must exist in :other.', 'The :attribute field must exist in :other.', 'dynamic', 'en'),
(53, 'The :attribute field must be an integer.', 'The :attribute field must be an integer.', 'dynamic', 'en'),
(54, 'The :attribute field must be a valid IP address.', 'The :attribute field must be a valid IP address.', 'dynamic', 'en'),
(55, 'The :attribute field must be a valid IPv4 address.', 'The :attribute field must be a valid IPv4 address.', 'dynamic', 'en'),
(56, 'The :attribute field must be a valid IPv6 address.', 'The :attribute field must be a valid IPv6 address.', 'dynamic', 'en'),
(57, 'The :attribute field must be a valid JSON string.', 'The :attribute field must be a valid JSON string.', 'dynamic', 'en'),
(58, 'The :attribute field must be a list.', 'The :attribute field must be a list.', 'dynamic', 'en'),
(59, 'The :attribute field must be lowercase.', 'The :attribute field must be lowercase.', 'dynamic', 'en'),
(60, 'The :attribute field must have less than :value items.', 'The :attribute field must have less than :value items.', 'dynamic', 'en'),
(61, 'The :attribute field must be less than :value kilobytes.', 'The :attribute field must be less than :value kilobytes.', 'dynamic', 'en'),
(62, 'The :attribute field must be less than :value.', 'The :attribute field must be less than :value.', 'dynamic', 'en'),
(63, 'The :attribute field must be less than :value characters.', 'The :attribute field must be less than :value characters.', 'dynamic', 'en'),
(64, 'The :attribute field must not have more than :value items.', 'The :attribute field must not have more than :value items.', 'dynamic', 'en'),
(65, 'The :attribute field must be less than or equal to :value kilobytes.', 'The :attribute field must be less than or equal to :value kilobytes.', 'dynamic', 'en'),
(66, 'The :attribute field must be less than or equal to :value.', 'The :attribute field must be less than or equal to :value.', 'dynamic', 'en'),
(67, 'The :attribute field must be less than or equal to :value characters.', 'The :attribute field must be less than or equal to :value characters.', 'dynamic', 'en'),
(68, 'The :attribute field must be a valid MAC address.', 'The :attribute field must be a valid MAC address.', 'dynamic', 'en'),
(69, 'The :attribute field must not have more than :max items.', 'The :attribute field must not have more than :max items.', 'dynamic', 'en'),
(70, 'The :attribute field must not be greater than :max kilobytes.', 'The :attribute field must not be greater than :max kilobytes.', 'dynamic', 'en'),
(71, 'The :attribute field must not be greater than :max.', 'The :attribute field must not be greater than :max.', 'dynamic', 'en'),
(72, 'The :attribute field must not be greater than :max characters.', 'The :attribute field must not be greater than :max characters.', 'dynamic', 'en'),
(73, 'The :attribute field must not have more than :max digits.', 'The :attribute field must not have more than :max digits.', 'dynamic', 'en'),
(74, 'The :attribute field must be a file of type: :values.', 'The :attribute field must be a file of type: :values.', 'dynamic', 'en'),
(75, 'The :attribute field must have at least :min items.', 'The :attribute field must have at least :min items.', 'dynamic', 'en'),
(76, 'The :attribute field must be at least :min kilobytes.', 'The :attribute field must be at least :min kilobytes.', 'dynamic', 'en'),
(77, 'The :attribute field must be at least :min.', 'The :attribute field must be at least :min.', 'dynamic', 'en'),
(78, 'The :attribute field must be at least :min characters.', 'The :attribute field must be at least :min characters.', 'dynamic', 'en'),
(79, 'The :attribute field must have at least :min digits.', 'The :attribute field must have at least :min digits.', 'dynamic', 'en'),
(80, 'The :attribute field must be missing.', 'The :attribute field must be missing.', 'dynamic', 'en'),
(81, 'The :attribute field must be missing when :other is :value.', 'The :attribute field must be missing when :other is :value.', 'dynamic', 'en'),
(82, 'The :attribute field must be missing unless :other is :value.', 'The :attribute field must be missing unless :other is :value.', 'dynamic', 'en'),
(83, 'The :attribute field must be missing when :values is present.', 'The :attribute field must be missing when :values is present.', 'dynamic', 'en'),
(84, 'The :attribute field must be missing when :values are present.', 'The :attribute field must be missing when :values are present.', 'dynamic', 'en'),
(85, 'The :attribute field must be a multiple of :value.', 'The :attribute field must be a multiple of :value.', 'dynamic', 'en'),
(86, 'The :attribute field format is invalid.', 'The :attribute field format is invalid.', 'dynamic', 'en'),
(87, 'The :attribute field must be a number.', 'The :attribute field must be a number.', 'dynamic', 'en'),
(88, 'The :attribute field must contain at least one letter.', 'The :attribute field must contain at least one letter.', 'dynamic', 'en'),
(89, 'The :attribute field must contain at least one uppercase and one lowercase letter.', 'The :attribute field must contain at least one uppercase and one lowercase letter.', 'dynamic', 'en'),
(90, 'The :attribute field must contain at least one number.', 'The :attribute field must contain at least one number.', 'dynamic', 'en'),
(91, 'The :attribute field must contain at least one symbol.', 'The :attribute field must contain at least one symbol.', 'dynamic', 'en'),
(92, 'The given :attribute has appeared in a data leak. Please choose a different :attribute.', 'The given :attribute has appeared in a data leak. Please choose a different :attribute.', 'dynamic', 'en'),
(93, 'The :attribute field must be present.', 'The :attribute field must be present.', 'dynamic', 'en'),
(94, 'The :attribute field must be present when :other is :value.', 'The :attribute field must be present when :other is :value.', 'dynamic', 'en'),
(95, 'The :attribute field must be present unless :other is :value.', 'The :attribute field must be present unless :other is :value.', 'dynamic', 'en'),
(96, 'The :attribute field must be present when :values is present.', 'The :attribute field must be present when :values is present.', 'dynamic', 'en'),
(97, 'The :attribute field must be present when :values are present.', 'The :attribute field must be present when :values are present.', 'dynamic', 'en'),
(98, 'The :attribute field is prohibited.', 'The :attribute field is prohibited.', 'dynamic', 'en'),
(99, 'The :attribute field is prohibited when :other is :value.', 'The :attribute field is prohibited when :other is :value.', 'dynamic', 'en'),
(100, 'The :attribute field is prohibited unless :other is in :values.', 'The :attribute field is prohibited unless :other is in :values.', 'dynamic', 'en'),
(101, 'The :attribute field prohibits :other from being present.', 'The :attribute field prohibits :other from being present.', 'dynamic', 'en'),
(102, 'The :attribute field is required.', 'The :attribute field is required.', 'dynamic', 'en'),
(103, 'The :attribute field must contain entries for: :values.', 'The :attribute field must contain entries for: :values.', 'dynamic', 'en'),
(104, 'The :attribute field is required when :other is :value.', 'The :attribute field is required when :other is :value.', 'dynamic', 'en'),
(105, 'The :attribute field is required when :other is accepted.', 'The :attribute field is required when :other is accepted.', 'dynamic', 'en'),
(106, 'The :attribute field is required when :other is declined.', 'The :attribute field is required when :other is declined.', 'dynamic', 'en'),
(107, 'The :attribute field is required unless :other is in :values.', 'The :attribute field is required unless :other is in :values.', 'dynamic', 'en'),
(108, 'The :attribute field is required when :values is present.', 'The :attribute field is required when :values is present.', 'dynamic', 'en'),
(109, 'The :attribute field is required when :values are present.', 'The :attribute field is required when :values are present.', 'dynamic', 'en'),
(110, 'The :attribute field is required when :values is not present.', 'The :attribute field is required when :values is not present.', 'dynamic', 'en'),
(111, 'The :attribute field is required when none of :values are present.', 'The :attribute field is required when none of :values are present.', 'dynamic', 'en'),
(112, 'The :attribute field must match :other.', 'The :attribute field must match :other.', 'dynamic', 'en'),
(113, 'The :attribute field must contain :size items.', 'The :attribute field must contain :size items.', 'dynamic', 'en'),
(114, 'The :attribute field must be :size kilobytes.', 'The :attribute field must be :size kilobytes.', 'dynamic', 'en'),
(115, 'The :attribute field must be :size.', 'The :attribute field must be :size.', 'dynamic', 'en'),
(116, 'The :attribute field must be :size characters.', 'The :attribute field must be :size characters.', 'dynamic', 'en'),
(117, 'The :attribute field must start with one of the following: :values.', 'The :attribute field must start with one of the following: :values.', 'dynamic', 'en'),
(118, 'The :attribute field must be a string.', 'The :attribute field must be a string.', 'dynamic', 'en'),
(119, 'The :attribute field must be a valid timezone.', 'The :attribute field must be a valid timezone.', 'dynamic', 'en'),
(120, 'The :attribute has already been taken.', 'The :attribute has already been taken.', 'dynamic', 'en'),
(121, 'The :attribute failed to upload.', 'The :attribute failed to upload.', 'dynamic', 'en'),
(122, 'The :attribute field must be uppercase.', 'The :attribute field must be uppercase.', 'dynamic', 'en'),
(123, 'The :attribute field must be a valid ULID.', 'The :attribute field must be a valid ULID.', 'dynamic', 'en'),
(124, 'The :attribute field must be a valid UUID.', 'The :attribute field must be a valid UUID.', 'dynamic', 'en'),
(125, 'The :attribute field must be a valid username.', 'The :attribute field must be a valid username.', 'dynamic', 'en'),
(126, 'The :attribute contains blocked patterns.', 'The :attribute contains blocked patterns.', 'dynamic', 'en'),
(127, 'The email type are not allowed.', 'The email type are not allowed.', 'dynamic', 'en'),
(128, 'Captcha verification failed.', 'Captcha verification failed.', 'dynamic', 'en'),
(129, 'captcha', 'captcha', 'dynamic', 'en'),
(130, 'terms of service', 'terms of service', 'dynamic', 'en'),
(131, 'These credentials do not match our records.', 'These credentials do not match our records.', 'dynamic', 'en'),
(132, 'The provided password is incorrect.', 'The provided password is incorrect.', 'dynamic', 'en'),
(133, 'Too many login attempts. Please try again in :seconds seconds.', 'Too many login attempts. Please try again in :seconds seconds.', 'dynamic', 'en'),
(134, 'Previous', 'Previous', 'dynamic', 'en'),
(135, 'Next', 'Next', 'dynamic', 'en'),
(136, 'Your password has been reset.', 'Your password has been reset.', 'dynamic', 'en'),
(137, 'We have emailed your password reset link.', 'We have emailed your password reset link.', 'dynamic', 'en'),
(138, 'Please wait before retrying.', 'Please wait before retrying.', 'dynamic', 'en'),
(139, 'This password reset token is invalid.', 'This password reset token is invalid.', 'dynamic', 'en'),
(140, 'We can\'t find a user with that email address.', 'We can\'t find a user with that email address.', 'dynamic', 'en'),
(141, 'Afghanistan', 'Afghanistan', 'dynamic', 'en'),
(142, 'Albania', 'Albania', 'dynamic', 'en'),
(143, 'Algeria', 'Algeria', 'dynamic', 'en'),
(144, 'American Samoa', 'American Samoa', 'dynamic', 'en'),
(145, 'Andorra', 'Andorra', 'dynamic', 'en'),
(146, 'Angola', 'Angola', 'dynamic', 'en'),
(147, 'Anguilla', 'Anguilla', 'dynamic', 'en'),
(148, 'Antarctica', 'Antarctica', 'dynamic', 'en'),
(149, 'Antigua and Barbuda', 'Antigua and Barbuda', 'dynamic', 'en'),
(150, 'Argentina', 'Argentina', 'dynamic', 'en'),
(151, 'Armenia', 'Armenia', 'dynamic', 'en'),
(152, 'Aruba', 'Aruba', 'dynamic', 'en'),
(153, 'Australia', 'Australia', 'dynamic', 'en'),
(154, 'Austria', 'Austria', 'dynamic', 'en'),
(155, 'Azerbaijan', 'Azerbaijan', 'dynamic', 'en'),
(156, 'Bahamas', 'Bahamas', 'dynamic', 'en'),
(157, 'Bahrain', 'Bahrain', 'dynamic', 'en'),
(158, 'Bangladesh', 'Bangladesh', 'dynamic', 'en'),
(159, 'Barbados', 'Barbados', 'dynamic', 'en'),
(160, 'Belarus', 'Belarus', 'dynamic', 'en'),
(161, 'Belgium', 'Belgium', 'dynamic', 'en'),
(162, 'Belize', 'Belize', 'dynamic', 'en'),
(163, 'Benin', 'Benin', 'dynamic', 'en'),
(164, 'Bermuda', 'Bermuda', 'dynamic', 'en'),
(165, 'Bhutan', 'Bhutan', 'dynamic', 'en'),
(166, 'Bolivia', 'Bolivia', 'dynamic', 'en'),
(167, 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'dynamic', 'en'),
(168, 'Botswana', 'Botswana', 'dynamic', 'en'),
(169, 'Bouvet Island', 'Bouvet Island', 'dynamic', 'en'),
(170, 'Brazil', 'Brazil', 'dynamic', 'en'),
(171, 'British Antarctic Territory', 'British Antarctic Territory', 'dynamic', 'en'),
(172, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 'dynamic', 'en'),
(173, 'British Virgin Islands', 'British Virgin Islands', 'dynamic', 'en'),
(174, 'Brunei', 'Brunei', 'dynamic', 'en'),
(175, 'Bulgaria', 'Bulgaria', 'dynamic', 'en'),
(176, 'Burkina Faso', 'Burkina Faso', 'dynamic', 'en'),
(177, 'Burundi', 'Burundi', 'dynamic', 'en'),
(178, 'Cambodia', 'Cambodia', 'dynamic', 'en'),
(179, 'Cameroon', 'Cameroon', 'dynamic', 'en'),
(180, 'Canada', 'Canada', 'dynamic', 'en'),
(181, 'Canton and Enderbury Islands', 'Canton and Enderbury Islands', 'dynamic', 'en'),
(182, 'Cape Verde', 'Cape Verde', 'dynamic', 'en'),
(183, 'Cayman Islands', 'Cayman Islands', 'dynamic', 'en'),
(184, 'Central African Republic', 'Central African Republic', 'dynamic', 'en'),
(185, 'Chad', 'Chad', 'dynamic', 'en'),
(186, 'Chile', 'Chile', 'dynamic', 'en'),
(187, 'China', 'China', 'dynamic', 'en'),
(188, 'Christmas Island', 'Christmas Island', 'dynamic', 'en'),
(189, 'Cocos [Keeling] Islands', 'Cocos [Keeling] Islands', 'dynamic', 'en'),
(190, 'Colombia', 'Colombia', 'dynamic', 'en'),
(191, 'Comoros', 'Comoros', 'dynamic', 'en'),
(192, 'Congo - Brazzaville', 'Congo - Brazzaville', 'dynamic', 'en'),
(193, 'Congo - Kinshasa', 'Congo - Kinshasa', 'dynamic', 'en'),
(194, 'Cook Islands', 'Cook Islands', 'dynamic', 'en'),
(195, 'Costa Rica', 'Costa Rica', 'dynamic', 'en'),
(196, 'Croatia', 'Croatia', 'dynamic', 'en'),
(197, 'Cuba', 'Cuba', 'dynamic', 'en'),
(198, 'Cyprus', 'Cyprus', 'dynamic', 'en'),
(199, 'Czech Republic', 'Czech Republic', 'dynamic', 'en'),
(200, 'Côte d’Ivoire', 'Côte d’Ivoire', 'dynamic', 'en'),
(201, 'Denmark', 'Denmark', 'dynamic', 'en'),
(202, 'Djibouti', 'Djibouti', 'dynamic', 'en'),
(203, 'Dominica', 'Dominica', 'dynamic', 'en'),
(204, 'Dominican Republic', 'Dominican Republic', 'dynamic', 'en'),
(205, 'Dronning Maud Land', 'Dronning Maud Land', 'dynamic', 'en'),
(206, 'East Germany', 'East Germany', 'dynamic', 'en'),
(207, 'Ecuador', 'Ecuador', 'dynamic', 'en'),
(208, 'Egypt', 'Egypt', 'dynamic', 'en'),
(209, 'El Salvador', 'El Salvador', 'dynamic', 'en'),
(210, 'Equatorial Guinea', 'Equatorial Guinea', 'dynamic', 'en'),
(211, 'Eritrea', 'Eritrea', 'dynamic', 'en'),
(212, 'Estonia', 'Estonia', 'dynamic', 'en'),
(213, 'Ethiopia', 'Ethiopia', 'dynamic', 'en'),
(214, 'Falkland Islands', 'Falkland Islands', 'dynamic', 'en'),
(215, 'Faroe Islands', 'Faroe Islands', 'dynamic', 'en'),
(216, 'Fiji', 'Fiji', 'dynamic', 'en'),
(217, 'Finland', 'Finland', 'dynamic', 'en'),
(218, 'France', 'France', 'dynamic', 'en'),
(219, 'French Guiana', 'French Guiana', 'dynamic', 'en'),
(220, 'French Polynesia', 'French Polynesia', 'dynamic', 'en'),
(221, 'French Southern Territories', 'French Southern Territories', 'dynamic', 'en'),
(222, 'French Southern and Antarctic Territories', 'French Southern and Antarctic Territories', 'dynamic', 'en'),
(223, 'Gabon', 'Gabon', 'dynamic', 'en'),
(224, 'Gambia', 'Gambia', 'dynamic', 'en'),
(225, 'Georgia', 'Georgia', 'dynamic', 'en'),
(226, 'Germany', 'Germany', 'dynamic', 'en'),
(227, 'Ghana', 'Ghana', 'dynamic', 'en'),
(228, 'Gibraltar', 'Gibraltar', 'dynamic', 'en'),
(229, 'Greece', 'Greece', 'dynamic', 'en'),
(230, 'Greenland', 'Greenland', 'dynamic', 'en'),
(231, 'Grenada', 'Grenada', 'dynamic', 'en'),
(232, 'Guadeloupe', 'Guadeloupe', 'dynamic', 'en'),
(233, 'Guam', 'Guam', 'dynamic', 'en'),
(234, 'Guatemala', 'Guatemala', 'dynamic', 'en'),
(235, 'Guernsey', 'Guernsey', 'dynamic', 'en'),
(236, 'Guinea', 'Guinea', 'dynamic', 'en'),
(237, 'Guinea-Bissau', 'Guinea-Bissau', 'dynamic', 'en'),
(238, 'Guyana', 'Guyana', 'dynamic', 'en'),
(239, 'Haiti', 'Haiti', 'dynamic', 'en'),
(240, 'Heard Island and McDonald Islands', 'Heard Island and McDonald Islands', 'dynamic', 'en'),
(241, 'Honduras', 'Honduras', 'dynamic', 'en'),
(242, 'Hong Kong SAR China', 'Hong Kong SAR China', 'dynamic', 'en'),
(243, 'Hungary', 'Hungary', 'dynamic', 'en'),
(244, 'Iceland', 'Iceland', 'dynamic', 'en'),
(245, 'India', 'India', 'dynamic', 'en'),
(246, 'Indonesia', 'Indonesia', 'dynamic', 'en'),
(247, 'Iran', 'Iran', 'dynamic', 'en'),
(248, 'Iraq', 'Iraq', 'dynamic', 'en'),
(249, 'Ireland', 'Ireland', 'dynamic', 'en'),
(250, 'Isle of Man', 'Isle of Man', 'dynamic', 'en'),
(251, 'Israel', 'Israel', 'dynamic', 'en'),
(252, 'Italy', 'Italy', 'dynamic', 'en'),
(253, 'Jamaica', 'Jamaica', 'dynamic', 'en'),
(254, 'Japan', 'Japan', 'dynamic', 'en'),
(255, 'Jersey', 'Jersey', 'dynamic', 'en'),
(256, 'Johnston Island', 'Johnston Island', 'dynamic', 'en'),
(257, 'Jordan', 'Jordan', 'dynamic', 'en'),
(258, 'Kazakhstan', 'Kazakhstan', 'dynamic', 'en'),
(259, 'Kenya', 'Kenya', 'dynamic', 'en'),
(260, 'Kiribati', 'Kiribati', 'dynamic', 'en'),
(261, 'Kuwait', 'Kuwait', 'dynamic', 'en'),
(262, 'Kyrgyzstan', 'Kyrgyzstan', 'dynamic', 'en'),
(263, 'Laos', 'Laos', 'dynamic', 'en'),
(264, 'Latvia', 'Latvia', 'dynamic', 'en'),
(265, 'Lebanon', 'Lebanon', 'dynamic', 'en'),
(266, 'Lesotho', 'Lesotho', 'dynamic', 'en'),
(267, 'Liberia', 'Liberia', 'dynamic', 'en'),
(268, 'Libya', 'Libya', 'dynamic', 'en'),
(269, 'Liechtenstein', 'Liechtenstein', 'dynamic', 'en'),
(270, 'Lithuania', 'Lithuania', 'dynamic', 'en'),
(271, 'Luxembourg', 'Luxembourg', 'dynamic', 'en'),
(272, 'Macau SAR China', 'Macau SAR China', 'dynamic', 'en'),
(273, 'Macedonia', 'Macedonia', 'dynamic', 'en'),
(274, 'Madagascar', 'Madagascar', 'dynamic', 'en'),
(275, 'Malawi', 'Malawi', 'dynamic', 'en'),
(276, 'Malaysia', 'Malaysia', 'dynamic', 'en'),
(277, 'Maldives', 'Maldives', 'dynamic', 'en'),
(278, 'Mali', 'Mali', 'dynamic', 'en'),
(279, 'Malta', 'Malta', 'dynamic', 'en'),
(280, 'Marshall Islands', 'Marshall Islands', 'dynamic', 'en'),
(281, 'Martinique', 'Martinique', 'dynamic', 'en'),
(282, 'Mauritania', 'Mauritania', 'dynamic', 'en'),
(283, 'Mauritius', 'Mauritius', 'dynamic', 'en'),
(284, 'Mayotte', 'Mayotte', 'dynamic', 'en'),
(285, 'Metropolitan France', 'Metropolitan France', 'dynamic', 'en'),
(286, 'Mexico', 'Mexico', 'dynamic', 'en'),
(287, 'Micronesia', 'Micronesia', 'dynamic', 'en'),
(288, 'Midway Islands', 'Midway Islands', 'dynamic', 'en'),
(289, 'Moldova', 'Moldova', 'dynamic', 'en'),
(290, 'Monaco', 'Monaco', 'dynamic', 'en'),
(291, 'Mongolia', 'Mongolia', 'dynamic', 'en'),
(292, 'Montenegro', 'Montenegro', 'dynamic', 'en'),
(293, 'Montserrat', 'Montserrat', 'dynamic', 'en'),
(294, 'Morocco', 'Morocco', 'dynamic', 'en'),
(295, 'Mozambique', 'Mozambique', 'dynamic', 'en'),
(296, 'Myanmar [Burma]', 'Myanmar [Burma]', 'dynamic', 'en'),
(297, 'Namibia', 'Namibia', 'dynamic', 'en'),
(298, 'Nauru', 'Nauru', 'dynamic', 'en'),
(299, 'Nepal', 'Nepal', 'dynamic', 'en'),
(300, 'Netherlands', 'Netherlands', 'dynamic', 'en'),
(301, 'Netherlands Antilles', 'Netherlands Antilles', 'dynamic', 'en'),
(302, 'Neutral Zone', 'Neutral Zone', 'dynamic', 'en'),
(303, 'New Caledonia', 'New Caledonia', 'dynamic', 'en'),
(304, 'New Zealand', 'New Zealand', 'dynamic', 'en'),
(305, 'Nicaragua', 'Nicaragua', 'dynamic', 'en'),
(306, 'Niger', 'Niger', 'dynamic', 'en'),
(307, 'Nigeria', 'Nigeria', 'dynamic', 'en'),
(308, 'Niue', 'Niue', 'dynamic', 'en'),
(309, 'Norfolk Island', 'Norfolk Island', 'dynamic', 'en'),
(310, 'North Korea', 'North Korea', 'dynamic', 'en'),
(311, 'North Vietnam', 'North Vietnam', 'dynamic', 'en'),
(312, 'Northern Mariana Islands', 'Northern Mariana Islands', 'dynamic', 'en'),
(313, 'Norway', 'Norway', 'dynamic', 'en'),
(314, 'Oman', 'Oman', 'dynamic', 'en'),
(315, 'Pacific Islands Trust Territory', 'Pacific Islands Trust Territory', 'dynamic', 'en'),
(316, 'Pakistan', 'Pakistan', 'dynamic', 'en'),
(317, 'Palau', 'Palau', 'dynamic', 'en'),
(318, 'Palestinian Territories', 'Palestinian Territories', 'dynamic', 'en'),
(319, 'Panama', 'Panama', 'dynamic', 'en'),
(320, 'Panama Canal Zone', 'Panama Canal Zone', 'dynamic', 'en'),
(321, 'Papua New Guinea', 'Papua New Guinea', 'dynamic', 'en'),
(322, 'Paraguay', 'Paraguay', 'dynamic', 'en'),
(323, 'People\'s Democratic Republic of Yemen', 'People\'s Democratic Republic of Yemen', 'dynamic', 'en'),
(324, 'Peru', 'Peru', 'dynamic', 'en'),
(325, 'Philippines', 'Philippines', 'dynamic', 'en'),
(326, 'Pitcairn Islands', 'Pitcairn Islands', 'dynamic', 'en'),
(327, 'Poland', 'Poland', 'dynamic', 'en'),
(328, 'Portugal', 'Portugal', 'dynamic', 'en'),
(329, 'Puerto Rico', 'Puerto Rico', 'dynamic', 'en'),
(330, 'Qatar', 'Qatar', 'dynamic', 'en'),
(331, 'Romania', 'Romania', 'dynamic', 'en'),
(332, 'Russia', 'Russia', 'dynamic', 'en'),
(333, 'Rwanda', 'Rwanda', 'dynamic', 'en'),
(334, 'Réunion', 'Réunion', 'dynamic', 'en'),
(335, 'Saint Barthélemy', 'Saint Barthélemy', 'dynamic', 'en'),
(336, 'Saint Helena', 'Saint Helena', 'dynamic', 'en'),
(337, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 'dynamic', 'en'),
(338, 'Saint Lucia', 'Saint Lucia', 'dynamic', 'en'),
(339, 'Saint Martin', 'Saint Martin', 'dynamic', 'en'),
(340, 'Saint Pierre and Miquelon', 'Saint Pierre and Miquelon', 'dynamic', 'en'),
(341, 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 'dynamic', 'en'),
(342, 'Samoa', 'Samoa', 'dynamic', 'en'),
(343, 'San Marino', 'San Marino', 'dynamic', 'en'),
(344, 'Saudi Arabia', 'Saudi Arabia', 'dynamic', 'en'),
(345, 'Senegal', 'Senegal', 'dynamic', 'en'),
(346, 'Serbia', 'Serbia', 'dynamic', 'en'),
(347, 'Serbia and Montenegro', 'Serbia and Montenegro', 'dynamic', 'en'),
(348, 'Seychelles', 'Seychelles', 'dynamic', 'en'),
(349, 'Sierra Leone', 'Sierra Leone', 'dynamic', 'en'),
(350, 'Singapore', 'Singapore', 'dynamic', 'en'),
(351, 'Slovakia', 'Slovakia', 'dynamic', 'en'),
(352, 'Slovenia', 'Slovenia', 'dynamic', 'en'),
(353, 'Solomon Islands', 'Solomon Islands', 'dynamic', 'en'),
(354, 'Somalia', 'Somalia', 'dynamic', 'en'),
(355, 'South Africa', 'South Africa', 'dynamic', 'en'),
(356, 'South Georgia and the South Sandwich Islands', 'South Georgia and the South Sandwich Islands', 'dynamic', 'en'),
(357, 'South Korea', 'South Korea', 'dynamic', 'en'),
(358, 'Spain', 'Spain', 'dynamic', 'en'),
(359, 'Sri Lanka', 'Sri Lanka', 'dynamic', 'en'),
(360, 'Sudan', 'Sudan', 'dynamic', 'en'),
(361, 'Suriname', 'Suriname', 'dynamic', 'en'),
(362, 'Svalbard and Jan Mayen', 'Svalbard and Jan Mayen', 'dynamic', 'en'),
(363, 'Swaziland', 'Swaziland', 'dynamic', 'en'),
(364, 'Sweden', 'Sweden', 'dynamic', 'en'),
(365, 'Switzerland', 'Switzerland', 'dynamic', 'en'),
(366, 'Syria', 'Syria', 'dynamic', 'en'),
(367, 'São Tomé and Príncipe', 'São Tomé and Príncipe', 'dynamic', 'en'),
(368, 'Taiwan', 'Taiwan', 'dynamic', 'en'),
(369, 'Tajikistan', 'Tajikistan', 'dynamic', 'en'),
(370, 'Tanzania', 'Tanzania', 'dynamic', 'en'),
(371, 'Thailand', 'Thailand', 'dynamic', 'en'),
(372, 'Timor-Leste', 'Timor-Leste', 'dynamic', 'en'),
(373, 'Togo', 'Togo', 'dynamic', 'en'),
(374, 'Tokelau', 'Tokelau', 'dynamic', 'en'),
(375, 'Tonga', 'Tonga', 'dynamic', 'en'),
(376, 'Trinidad and Tobago', 'Trinidad and Tobago', 'dynamic', 'en'),
(377, 'Tunisia', 'Tunisia', 'dynamic', 'en'),
(378, 'Turkey', 'Turkey', 'dynamic', 'en'),
(379, 'Turkmenistan', 'Turkmenistan', 'dynamic', 'en'),
(380, 'Turks and Caicos Islands', 'Turks and Caicos Islands', 'dynamic', 'en'),
(381, 'Tuvalu', 'Tuvalu', 'dynamic', 'en'),
(382, 'U.S. Minor Outlying Islands', 'U.S. Minor Outlying Islands', 'dynamic', 'en'),
(383, 'U.S. Miscellaneous Pacific Islands', 'U.S. Miscellaneous Pacific Islands', 'dynamic', 'en'),
(384, 'U.S. Virgin Islands', 'U.S. Virgin Islands', 'dynamic', 'en'),
(385, 'Uganda', 'Uganda', 'dynamic', 'en'),
(386, 'Ukraine', 'Ukraine', 'dynamic', 'en'),
(387, 'Union of Soviet Socialist Republics', 'Union of Soviet Socialist Republics', 'dynamic', 'en'),
(388, 'United Arab Emirates', 'United Arab Emirates', 'dynamic', 'en'),
(389, 'United Kingdom', 'United Kingdom', 'dynamic', 'en'),
(390, 'United States', 'United States', 'dynamic', 'en'),
(391, 'Unknown or Invalid Region', 'Unknown or Invalid Region', 'dynamic', 'en'),
(392, 'Uruguay', 'Uruguay', 'dynamic', 'en'),
(393, 'Uzbekistan', 'Uzbekistan', 'dynamic', 'en'),
(394, 'Vanuatu', 'Vanuatu', 'dynamic', 'en'),
(395, 'Vatican City', 'Vatican City', 'dynamic', 'en'),
(396, 'Venezuela', 'Venezuela', 'dynamic', 'en'),
(397, 'Vietnam', 'Vietnam', 'dynamic', 'en'),
(398, 'Wake Island', 'Wake Island', 'dynamic', 'en'),
(399, 'Wallis and Futuna', 'Wallis and Futuna', 'dynamic', 'en'),
(400, 'Western Sahara', 'Western Sahara', 'dynamic', 'en'),
(401, 'Yemen', 'Yemen', 'dynamic', 'en'),
(402, 'Zambia', 'Zambia', 'dynamic', 'en'),
(403, 'Zimbabwe', 'Zimbabwe', 'dynamic', 'en'),
(404, 'Åland Islands', 'Åland Islands', 'dynamic', 'en'),
(405, 'Reviews', 'Reviews', 'dynamic', 'en'),
(406, 'Views', 'Views', 'dynamic', 'en'),
(407, 'Invalid captcha provider', 'Invalid captcha provider', 'dynamic', 'en'),
(408, 'Internal', 'Internal', 'dynamic', 'en'),
(409, 'External', 'External', 'dynamic', 'en'),
(410, 'Pending', 'Pending', 'dynamic', 'en'),
(411, 'Paid', 'Paid', 'dynamic', 'en'),
(412, 'Cancelled', 'Cancelled', 'dynamic', 'en'),
(413, 'Active', 'Active', 'dynamic', 'en'),
(414, 'Disabled', 'Disabled', 'dynamic', 'en'),
(415, 'Unknown', 'Unknown', 'dynamic', 'en'),
(416, 'Verified', 'Verified', 'dynamic', 'en'),
(417, 'Unverified', 'Unverified', 'dynamic', 'en'),
(418, 'Banned', 'Banned', 'dynamic', 'en'),
(419, 'Published', 'Published', 'dynamic', 'en'),
(420, 'Suspended', 'Suspended', 'dynamic', 'en'),
(421, 'Left to Right', 'Left to Right', 'dynamic', 'en'),
(422, 'Right to Left', 'Right to Left', 'dynamic', 'en'),
(423, 'Afar', 'Afar', 'dynamic', 'en'),
(424, 'Abkhazian', 'Abkhazian', 'dynamic', 'en'),
(425, 'Avestan', 'Avestan', 'dynamic', 'en'),
(426, 'Afrikaans', 'Afrikaans', 'dynamic', 'en'),
(427, 'Akan', 'Akan', 'dynamic', 'en'),
(428, 'Amharic', 'Amharic', 'dynamic', 'en'),
(429, 'Aragonese', 'Aragonese', 'dynamic', 'en'),
(431, 'Assamese', 'Assamese', 'dynamic', 'en'),
(432, 'Avaric', 'Avaric', 'dynamic', 'en'),
(433, 'Aymara', 'Aymara', 'dynamic', 'en'),
(434, 'Azerbaijani', 'Azerbaijani', 'dynamic', 'en'),
(435, 'Bashkir', 'Bashkir', 'dynamic', 'en'),
(436, 'Belarusian', 'Belarusian', 'dynamic', 'en'),
(437, 'Bulgarian', 'Bulgarian', 'dynamic', 'en'),
(438, 'Bihari languages', 'Bihari languages', 'dynamic', 'en'),
(439, 'Bislama', 'Bislama', 'dynamic', 'en'),
(440, 'Bambara', 'Bambara', 'dynamic', 'en'),
(441, 'Bengali', 'Bengali', 'dynamic', 'en'),
(442, 'Tibetan', 'Tibetan', 'dynamic', 'en'),
(443, 'Breton', 'Breton', 'dynamic', 'en'),
(444, 'Bosnian', 'Bosnian', 'dynamic', 'en'),
(445, 'Catalan, Valencian', 'Catalan, Valencian', 'dynamic', 'en'),
(446, 'Chechen', 'Chechen', 'dynamic', 'en'),
(447, 'Chamorro', 'Chamorro', 'dynamic', 'en'),
(448, 'Corsican', 'Corsican', 'dynamic', 'en'),
(449, 'Cree', 'Cree', 'dynamic', 'en'),
(450, 'Czech', 'Czech', 'dynamic', 'en'),
(451, 'Church Slavonic, Old Bulgarian, Old Church Slavonic', 'Church Slavonic, Old Bulgarian, Old Church Slavonic', 'dynamic', 'en'),
(452, 'Chuvash', 'Chuvash', 'dynamic', 'en'),
(453, 'Welsh', 'Welsh', 'dynamic', 'en'),
(454, 'Danish', 'Danish', 'dynamic', 'en'),
(455, 'German', 'German', 'dynamic', 'en'),
(456, 'Divehi, Dhivehi, Maldivian', 'Divehi, Dhivehi, Maldivian', 'dynamic', 'en'),
(457, 'Dzongkha', 'Dzongkha', 'dynamic', 'en'),
(458, 'Ewe', 'Ewe', 'dynamic', 'en'),
(459, 'Greek (Modern)', 'Greek (Modern)', 'dynamic', 'en'),
(461, 'Esperanto', 'Esperanto', 'dynamic', 'en'),
(462, 'Spanish, Castilian', 'Spanish, Castilian', 'dynamic', 'en'),
(463, 'Estonian', 'Estonian', 'dynamic', 'en'),
(464, 'Basque', 'Basque', 'dynamic', 'en'),
(465, 'Persian', 'Persian', 'dynamic', 'en'),
(466, 'Fulah', 'Fulah', 'dynamic', 'en'),
(467, 'Finnish', 'Finnish', 'dynamic', 'en'),
(468, 'Fijian', 'Fijian', 'dynamic', 'en'),
(469, 'Faroese', 'Faroese', 'dynamic', 'en'),
(470, 'French', 'French', 'dynamic', 'en'),
(471, 'Western Frisian', 'Western Frisian', 'dynamic', 'en'),
(472, 'Irish', 'Irish', 'dynamic', 'en'),
(473, 'Gaelic, Scottish Gaelic', 'Gaelic, Scottish Gaelic', 'dynamic', 'en'),
(474, 'Galician', 'Galician', 'dynamic', 'en'),
(475, 'Guarani', 'Guarani', 'dynamic', 'en'),
(476, 'Gujarati', 'Gujarati', 'dynamic', 'en'),
(477, 'Manx', 'Manx', 'dynamic', 'en'),
(478, 'Hausa', 'Hausa', 'dynamic', 'en'),
(479, 'Hebrew', 'Hebrew', 'dynamic', 'en'),
(480, 'Hindi', 'Hindi', 'dynamic', 'en'),
(481, 'Hiri Motu', 'Hiri Motu', 'dynamic', 'en'),
(482, 'Croatian', 'Croatian', 'dynamic', 'en'),
(483, 'Haitian, Haitian Creole', 'Haitian, Haitian Creole', 'dynamic', 'en'),
(484, 'Hungarian', 'Hungarian', 'dynamic', 'en'),
(485, 'Armenian', 'Armenian', 'dynamic', 'en'),
(486, 'Herero', 'Herero', 'dynamic', 'en'),
(487, 'Interlingua (International Auxiliary Language Association)', 'Interlingua (International Auxiliary Language Association)', 'dynamic', 'en'),
(488, 'Indonesian', 'Indonesian', 'dynamic', 'en'),
(489, 'Interlingue', 'Interlingue', 'dynamic', 'en'),
(490, 'Igbo', 'Igbo', 'dynamic', 'en'),
(491, 'Nuosu, Sichuan Yi', 'Nuosu, Sichuan Yi', 'dynamic', 'en'),
(492, 'Inupiaq', 'Inupiaq', 'dynamic', 'en'),
(493, 'Ido', 'Ido', 'dynamic', 'en'),
(494, 'Icelandic', 'Icelandic', 'dynamic', 'en'),
(495, 'Italian', 'Italian', 'dynamic', 'en'),
(496, 'Inuktitut', 'Inuktitut', 'dynamic', 'en'),
(497, 'Japanese', 'Japanese', 'dynamic', 'en'),
(498, 'Javanese', 'Javanese', 'dynamic', 'en'),
(499, 'Georgian', 'Georgian', 'dynamic', 'en'),
(500, 'Kongo', 'Kongo', 'dynamic', 'en'),
(501, 'Gikuyu, Kikuyu', 'Gikuyu, Kikuyu', 'dynamic', 'en'),
(502, 'Kwanyama, Kuanyama', 'Kwanyama, Kuanyama', 'dynamic', 'en'),
(503, 'Kazakh', 'Kazakh', 'dynamic', 'en'),
(504, 'Greenlandic, Kalaallisut', 'Greenlandic, Kalaallisut', 'dynamic', 'en'),
(505, 'Central Khmer', 'Central Khmer', 'dynamic', 'en'),
(506, 'Kannada', 'Kannada', 'dynamic', 'en'),
(507, 'Korean', 'Korean', 'dynamic', 'en'),
(508, 'Kanuri', 'Kanuri', 'dynamic', 'en'),
(509, 'Kashmiri', 'Kashmiri', 'dynamic', 'en'),
(510, 'Kurdish', 'Kurdish', 'dynamic', 'en'),
(511, 'Komi', 'Komi', 'dynamic', 'en'),
(512, 'Cornish', 'Cornish', 'dynamic', 'en'),
(513, 'Kyrgyz', 'Kyrgyz', 'dynamic', 'en'),
(514, 'Latin', 'Latin', 'dynamic', 'en'),
(515, 'Letzeburgesch, Luxembourgish', 'Letzeburgesch, Luxembourgish', 'dynamic', 'en'),
(516, 'Ganda', 'Ganda', 'dynamic', 'en'),
(517, 'Limburgish, Limburgan, Limburger', 'Limburgish, Limburgan, Limburger', 'dynamic', 'en'),
(518, 'Lingala', 'Lingala', 'dynamic', 'en'),
(519, 'Lao', 'Lao', 'dynamic', 'en'),
(520, 'Lithuanian', 'Lithuanian', 'dynamic', 'en'),
(521, 'Luba-Katanga', 'Luba-Katanga', 'dynamic', 'en'),
(522, 'Latvian', 'Latvian', 'dynamic', 'en'),
(523, 'Malagasy', 'Malagasy', 'dynamic', 'en'),
(524, 'Marshallese', 'Marshallese', 'dynamic', 'en'),
(525, 'Maori', 'Maori', 'dynamic', 'en'),
(526, 'Macedonian', 'Macedonian', 'dynamic', 'en'),
(527, 'Malayalam', 'Malayalam', 'dynamic', 'en'),
(528, 'Mongolian', 'Mongolian', 'dynamic', 'en'),
(529, 'Marathi', 'Marathi', 'dynamic', 'en'),
(530, 'Malay', 'Malay', 'dynamic', 'en'),
(531, 'Maltese', 'Maltese', 'dynamic', 'en'),
(532, 'Burmese', 'Burmese', 'dynamic', 'en'),
(533, 'Norwegian Bokmål', 'Norwegian Bokmål', 'dynamic', 'en'),
(534, 'Northern Ndebele', 'Northern Ndebele', 'dynamic', 'en'),
(535, 'Nepali', 'Nepali', 'dynamic', 'en'),
(536, 'Ndonga', 'Ndonga', 'dynamic', 'en'),
(537, 'Dutch, Flemish', 'Dutch, Flemish', 'dynamic', 'en'),
(538, 'Norwegian Nynorsk', 'Norwegian Nynorsk', 'dynamic', 'en'),
(539, 'Norwegian', 'Norwegian', 'dynamic', 'en'),
(540, 'South Ndebele', 'South Ndebele', 'dynamic', 'en'),
(541, 'Navajo, Navaho', 'Navajo, Navaho', 'dynamic', 'en'),
(542, 'Chichewa, Chewa, Nyanja', 'Chichewa, Chewa, Nyanja', 'dynamic', 'en'),
(543, 'Occitan (post 1500)', 'Occitan (post 1500)', 'dynamic', 'en'),
(544, 'Ojibwa', 'Ojibwa', 'dynamic', 'en'),
(545, 'Oromo', 'Oromo', 'dynamic', 'en'),
(546, 'Oriya', 'Oriya', 'dynamic', 'en'),
(547, 'Ossetian, Ossetic', 'Ossetian, Ossetic', 'dynamic', 'en'),
(548, 'Panjabi, Punjabi', 'Panjabi, Punjabi', 'dynamic', 'en'),
(549, 'Pali', 'Pali', 'dynamic', 'en'),
(550, 'Polish', 'Polish', 'dynamic', 'en'),
(551, 'Pashto, Pushto', 'Pashto, Pushto', 'dynamic', 'en'),
(552, 'Portuguese', 'Portuguese', 'dynamic', 'en'),
(553, 'Quechua', 'Quechua', 'dynamic', 'en'),
(554, 'Romansh', 'Romansh', 'dynamic', 'en'),
(555, 'Rundi', 'Rundi', 'dynamic', 'en'),
(556, 'Moldovan, Moldavian, Romanian', 'Moldovan, Moldavian, Romanian', 'dynamic', 'en'),
(557, 'Russian', 'Russian', 'dynamic', 'en'),
(558, 'Kinyarwanda', 'Kinyarwanda', 'dynamic', 'en'),
(559, 'Sanskrit', 'Sanskrit', 'dynamic', 'en'),
(560, 'Sardinian', 'Sardinian', 'dynamic', 'en'),
(561, 'Sindhi', 'Sindhi', 'dynamic', 'en'),
(562, 'Northern Sami', 'Northern Sami', 'dynamic', 'en'),
(563, 'Sango', 'Sango', 'dynamic', 'en'),
(564, 'Sinhala, Sinhalese', 'Sinhala, Sinhalese', 'dynamic', 'en'),
(565, 'Slovak', 'Slovak', 'dynamic', 'en'),
(566, 'Slovenian', 'Slovenian', 'dynamic', 'en'),
(567, 'Samoan', 'Samoan', 'dynamic', 'en'),
(568, 'Shona', 'Shona', 'dynamic', 'en'),
(569, 'Somali', 'Somali', 'dynamic', 'en'),
(570, 'Albanian', 'Albanian', 'dynamic', 'en'),
(571, 'Serbian', 'Serbian', 'dynamic', 'en'),
(572, 'Swati', 'Swati', 'dynamic', 'en'),
(573, 'Sotho, Southern', 'Sotho, Southern', 'dynamic', 'en'),
(574, 'Sundanese', 'Sundanese', 'dynamic', 'en'),
(575, 'Swedish', 'Swedish', 'dynamic', 'en'),
(576, 'Swahili', 'Swahili', 'dynamic', 'en'),
(577, 'Tamil', 'Tamil', 'dynamic', 'en'),
(578, 'Telugu', 'Telugu', 'dynamic', 'en'),
(579, 'Tajik', 'Tajik', 'dynamic', 'en'),
(580, 'Thai', 'Thai', 'dynamic', 'en'),
(581, 'Tigrinya', 'Tigrinya', 'dynamic', 'en'),
(582, 'Turkmen', 'Turkmen', 'dynamic', 'en'),
(583, 'Tagalog', 'Tagalog', 'dynamic', 'en'),
(584, 'Tswana', 'Tswana', 'dynamic', 'en'),
(585, 'Tonga (Tonga Islands)', 'Tonga (Tonga Islands)', 'dynamic', 'en'),
(586, 'Turkish', 'Turkish', 'dynamic', 'en'),
(587, 'Tsonga', 'Tsonga', 'dynamic', 'en'),
(588, 'Tatar', 'Tatar', 'dynamic', 'en'),
(589, 'Twi', 'Twi', 'dynamic', 'en'),
(590, 'Tahitian', 'Tahitian', 'dynamic', 'en'),
(591, 'Uighur, Uyghur', 'Uighur, Uyghur', 'dynamic', 'en'),
(592, 'Ukrainian', 'Ukrainian', 'dynamic', 'en'),
(593, 'Urdu', 'Urdu', 'dynamic', 'en'),
(594, 'Uzbek', 'Uzbek', 'dynamic', 'en'),
(595, 'Venda', 'Venda', 'dynamic', 'en'),
(596, 'Vietnamese', 'Vietnamese', 'dynamic', 'en'),
(597, 'Volap_k', 'Volap_k', 'dynamic', 'en'),
(598, 'Walloon', 'Walloon', 'dynamic', 'en'),
(599, 'Wolof', 'Wolof', 'dynamic', 'en'),
(600, 'Xhosa', 'Xhosa', 'dynamic', 'en'),
(601, 'Yiddish', 'Yiddish', 'dynamic', 'en'),
(602, 'Yoruba', 'Yoruba', 'dynamic', 'en'),
(603, 'Zhuang, Chuang', 'Zhuang, Chuang', 'dynamic', 'en'),
(604, 'Chinese', 'Chinese', 'dynamic', 'en'),
(605, 'Zulu', 'Zulu', 'dynamic', 'en'),
(606, 'Before price', 'Before price', 'dynamic', 'en'),
(607, 'After price', 'After price', 'dynamic', 'en'),
(608, 'Weekly', 'Weekly', 'dynamic', 'en'),
(609, 'Monthly', 'Monthly', 'dynamic', 'en'),
(610, 'Yearly', 'Yearly', 'dynamic', 'en'),
(611, 'Lifetime', 'Lifetime', 'dynamic', 'en'),
(612, 'National ID', 'National ID', 'dynamic', 'en'),
(613, 'Passport', 'Passport', 'dynamic', 'en'),
(614, 'Approved', 'Approved', 'dynamic', 'en'),
(615, 'Rejected', 'Rejected', 'dynamic', 'en'),
(616, 'Administrator', 'Administrator', 'dynamic', 'en'),
(617, 'Employee', 'Employee', 'dynamic', 'en'),
(618, 'You have successfully subscribed', 'You have successfully subscribed', 'dynamic', 'en'),
(619, 'Your account has been banned', 'Your account has been banned', 'dynamic', 'en'),
(620, 'Please complete the KYC verification', 'Please complete the KYC verification', 'dynamic', 'en'),
(621, 'Your email address is not verified.', 'Your email address is not verified.', 'dynamic', 'en'),
(622, 'SMTP is not enabled, please enable the smtp from admin settings', 'SMTP is not enabled, please enable the smtp from admin settings', 'dynamic', 'en'),
(623, 'Registration is currently disabled.', 'Registration is currently disabled.', 'dynamic', 'en'),
(624, 'Updated Successfully', 'Updated Successfully', 'dynamic', 'en'),
(625, 'Your current password does not matches with the password you provided', 'Your current password does not matches with the password you provided', 'dynamic', 'en'),
(626, 'New Password cannot be same as your current password. Please choose a different password', 'New Password cannot be same as your current password. Please choose a different password', 'dynamic', 'en'),
(627, 'Invalid OTP code', 'Invalid OTP code', 'dynamic', 'en'),
(628, '2FA Authentication has been enabled successfully', '2FA Authentication has been enabled successfully', 'dynamic', 'en'),
(629, '2FA Authentication has been disabled successfully', '2FA Authentication has been disabled successfully', 'dynamic', 'en'),
(630, 'Your documents has been submitted successfully', 'Your documents has been submitted successfully', 'dynamic', 'en'),
(631, 'Email has been changed successfully', 'Email has been changed successfully', 'dynamic', 'en'),
(632, 'Payment failed', 'Payment failed', 'dynamic', 'en'),
(633, 'Your payment is being processed and you will get email notification when it\'s completed', 'Your payment is being processed and you will get email notification when it\'s completed', 'dynamic', 'en'),
(634, 'Pay Now', 'Pay Now', 'dynamic', 'en'),
(635, 'Payment proof was sent successfully. Our team will review it as soon as possible', 'Payment proof was sent successfully. Our team will review it as soon as possible', 'dynamic', 'en'),
(636, 'An error occurred while calling the API', 'An error occurred while calling the API', 'dynamic', 'en'),
(637, 'All notifications marked as read', 'All notifications marked as read', 'dynamic', 'en'),
(638, 'Read notifications deleted successfully', 'Read notifications deleted successfully', 'dynamic', 'en'),
(639, 'There has been a change in your transaction', 'There has been a change in your transaction', 'dynamic', 'en'),
(640, 'Your reply has been published successfully', 'Your reply has been published successfully', 'dynamic', 'en'),
(641, 'The reply has been updated successfully', 'The reply has been updated successfully', 'dynamic', 'en'),
(642, 'You cannot create more businesses', 'You cannot create more businesses', 'dynamic', 'en'),
(643, 'The business website has already been taken', 'The business website has already been taken', 'dynamic', 'en'),
(644, 'You are in a lifetime plan it cannot be renewed', 'You are in a lifetime plan it cannot be renewed', 'dynamic', 'en'),
(645, 'You have subscribed in this plan already', 'You have subscribed in this plan already', 'dynamic', 'en'),
(646, 'Your free plan has already expired and it cannot be renewed', 'Your free plan has already expired and it cannot be renewed', 'dynamic', 'en'),
(647, 'Your subscription has been cancelled', 'Your subscription has been cancelled', 'dynamic', 'en'),
(648, 'You cannot add that employee', 'You cannot add that employee', 'dynamic', 'en'),
(649, 'The employee is already exists', 'The employee is already exists', 'dynamic', 'en'),
(650, 'The employee has been invited successfully', 'The employee has been invited successfully', 'dynamic', 'en'),
(651, 'The employee has been deleted successfully', 'The employee has been deleted successfully', 'dynamic', 'en'),
(652, 'This subsubcategory has already been added.', 'This subsubcategory has already been added.', 'dynamic', 'en'),
(653, 'The category has been added successfully.', 'The category has been added successfully.', 'dynamic', 'en'),
(654, 'The category has been deleted successfully.', 'The category has been deleted successfully.', 'dynamic', 'en'),
(655, 'Maximum 15 tags allowed', 'Maximum 15 tags allowed', 'dynamic', 'en'),
(656, 'Business details has been updated successfully', 'Business details has been updated successfully', 'dynamic', 'en'),
(657, 'The image dimensions must 512x512 pixels', 'The image dimensions must 512x512 pixels', 'dynamic', 'en'),
(658, 'Business logo has been updated successfully', 'Business logo has been updated successfully', 'dynamic', 'en'),
(659, 'Business social links has been updated successfully', 'Business social links has been updated successfully', 'dynamic', 'en'),
(660, 'Business address has been updated successfully', 'Business address has been updated successfully', 'dynamic', 'en'),
(661, 'Business has been added successfully', 'Business has been added successfully', 'dynamic', 'en'),
(662, 'Your domain verification failed. Please note that some changes to your DNS may take time.', 'Your domain verification failed. Please note that some changes to your DNS may take time.', 'dynamic', 'en'),
(663, 'Your business domain has been verified successfully', 'Your business domain has been verified successfully', 'dynamic', 'en'),
(664, 'Credentials parameter error', 'Credentials parameter error', 'dynamic', 'en'),
(665, 'Failed to sort the table', 'Failed to sort the table', 'dynamic', 'en'),
(666, 'Invalid mode', 'Invalid mode', 'dynamic', 'en'),
(667, 'Currency should be different from website currency or leave it empty', 'Currency should be different from website currency or leave it empty', 'dynamic', 'en'),
(668, 'Credentials error', 'Credentials error', 'dynamic', 'en'),
(669, 'Instructions cannot be empty', 'Instructions cannot be empty', 'dynamic', 'en'),
(670, 'The selected captcha provider is not active', 'The selected captcha provider is not active', 'dynamic', 'en'),
(671, 'The default captcha providers has been updated', 'The default captcha providers has been updated', 'dynamic', 'en'),
(672, 'Invalid Country', 'Invalid Country', 'dynamic', 'en'),
(673, 'Created Successfully', 'Created Successfully', 'dynamic', 'en'),
(674, 'Deleted Successfully', 'Deleted Successfully', 'dynamic', 'en'),
(675, 'Theme has been changed Successfully', 'Theme has been changed Successfully', 'dynamic', 'en'),
(676, 'ZipArchive extension is not enabled', 'ZipArchive extension is not enabled', 'dynamic', 'en'),
(677, 'Invalid purchase code', 'Invalid purchase code', 'dynamic', 'en'),
(678, 'Could not open the theme zip file', 'Could not open the theme zip file', 'dynamic', 'en'),
(679, 'Theme Config is missing', 'Theme Config is missing', 'dynamic', 'en'),
(680, 'Invalid theme files', 'Invalid theme files', 'dynamic', 'en'),
(681, 'Failed to validate the purchase code', 'Failed to validate the purchase code', 'dynamic', 'en'),
(682, 'Invalid action request', 'Invalid action request', 'dynamic', 'en'),
(683, 'The {theme_name} theme require {script_alias} version {script_version} or above', 'The {theme_name} theme require {script_alias} version {script_version} or above', 'dynamic', 'en'),
(684, 'Cannot unprepared the database file', 'Cannot unprepared the database file', 'dynamic', 'en'),
(685, 'Theme uploaded successfully', 'Theme uploaded successfully', 'dynamic', 'en'),
(686, 'Settings file is missing', 'Settings file is missing', 'dynamic', 'en'),
(687, 'SMTP is not enabled', 'SMTP is not enabled', 'dynamic', 'en'),
(688, 'Contact email is required to enable contact page', 'Contact email is required to enable contact page', 'dynamic', 'en'),
(689, 'Updated Error', 'Updated Error', 'dynamic', 'en'),
(690, 'Sent successfully', 'Sent successfully', 'dynamic', 'en'),
(691, 'Sending failed', 'Sending failed', 'dynamic', 'en'),
(692, 'The key is already exists', 'The key is already exists', 'dynamic', 'en'),
(693, 'Added Successfully', 'Added Successfully', 'dynamic', 'en');
INSERT INTO `translates` (`id`, `key`, `value`, `type`, `lang`) VALUES
(694, 'Clear the cache to apply the changes', 'Clear the cache to apply the changes', 'dynamic', 'en'),
(695, 'The default language has been changed successfully', 'The default language has been changed successfully', 'dynamic', 'en'),
(696, 'The default language cannot be deleted', 'The default language cannot be deleted', 'dynamic', 'en'),
(697, 'You cannot delete your current language', 'You cannot delete your current language', 'dynamic', 'en'),
(698, 'Failed to sort the list', 'Failed to sort the list', 'dynamic', 'en'),
(699, 'Published Successfully', 'Published Successfully', 'dynamic', 'en'),
(700, 'Rejected Successfully', 'Rejected Successfully', 'dynamic', 'en'),
(701, 'Users', 'Users', 'dynamic', 'en'),
(702, 'Businesses', 'Businesses', 'dynamic', 'en'),
(703, 'Cache Cleared Successfully', 'Cache Cleared Successfully', 'dynamic', 'en'),
(704, 'Could not open the addon zip file', 'Could not open the addon zip file', 'dynamic', 'en'),
(705, 'Addon Config is missing', 'Addon Config is missing', 'dynamic', 'en'),
(706, 'Invalid addon files', 'Invalid addon files', 'dynamic', 'en'),
(707, 'The addon has been installed successfully', 'The addon has been installed successfully', 'dynamic', 'en'),
(708, 'Cron Job key generated successfully', 'Cron Job key generated successfully', 'dynamic', 'en'),
(709, 'Cron Job key removed successfully', 'Cron Job key removed successfully', 'dynamic', 'en'),
(710, 'Your current password does not matches with the password you provided.', 'Your current password does not matches with the password you provided.', 'dynamic', 'en'),
(711, 'New Password cannot be same as your current password. Please choose a different password.', 'New Password cannot be same as your current password. Please choose a different password.', 'dynamic', 'en'),
(712, 'KYC Verification has been Approved', 'KYC Verification has been Approved', 'dynamic', 'en'),
(713, 'KYC Verification has been Rejected', 'KYC Verification has been Rejected', 'dynamic', 'en'),
(714, 'Cancelled Successfully', 'Cancelled Successfully', 'dynamic', 'en'),
(715, 'The selected category has articles, it cannot be deleted', 'The selected category has articles, it cannot be deleted', 'dynamic', 'en'),
(716, 'This plan has subscriptions it cannot be deleted', 'This plan has subscriptions it cannot be deleted', 'dynamic', 'en'),
(717, 'You do not have any subscribers', 'You do not have any subscribers', 'dynamic', 'en'),
(718, 'The email has been sent successfully', 'The email has been sent successfully', 'dynamic', 'en'),
(719, 'Transaction has been paid successfully', 'Transaction has been paid successfully', 'dynamic', 'en'),
(720, 'Transaction has been cancelled successfully', 'Transaction has been cancelled successfully', 'dynamic', 'en'),
(721, 'The code cannot be empty', 'The code cannot be empty', 'dynamic', 'en'),
(722, 'Sent error', 'Sent error', 'dynamic', 'en'),
(723, 'Two-Factor authentication cannot activated from admin side', 'Two-Factor authentication cannot activated from admin side', 'dynamic', 'en'),
(724, 'Invalid image type, the uploaded image type are not supported.', 'Invalid image type, the uploaded image type are not supported.', 'dynamic', 'en'),
(725, 'Sub Sub category with the same name or slug already exists', 'Sub Sub category with the same name or slug already exists', 'dynamic', 'en'),
(726, 'Sub category with the same name or slug already exists', 'Sub category with the same name or slug already exists', 'dynamic', 'en'),
(727, 'Deleted successfully.', 'Deleted successfully.', 'dynamic', 'en'),
(728, 'The business marked as featured successfully', 'The business marked as featured successfully', 'dynamic', 'en'),
(729, 'The business marked as not featured successfully', 'The business marked as not featured successfully', 'dynamic', 'en'),
(730, 'The business has been activated', 'The business has been activated', 'dynamic', 'en'),
(731, 'The business has been suspended', 'The business has been suspended', 'dynamic', 'en'),
(732, 'Please sing in to your account in order to leave a review', 'Please sing in to your account in order to leave a review', 'dynamic', 'en'),
(733, 'You have a review for this business already', 'You have a review for this business already', 'dynamic', 'en'),
(734, 'Your review submitted and under review. Thank you for sharing your experience', 'Your review submitted and under review. Thank you for sharing your experience', 'dynamic', 'en'),
(735, 'Your review has been successfully published. Thank you for sharing your experience', 'Your review has been successfully published. Thank you for sharing your experience', 'dynamic', 'en'),
(736, 'Your review updated and under review', 'Your review updated and under review', 'dynamic', 'en'),
(737, 'Your review has been updated successfully', 'Your review has been updated successfully', 'dynamic', 'en'),
(738, 'You cannot report your own reviews', 'You cannot report your own reviews', 'dynamic', 'en'),
(739, 'You have reported this review already', 'You have reported this review already', 'dynamic', 'en'),
(740, 'Your report has been received, we will review it and take a necessary action', 'Your report has been received, we will review it and take a necessary action', 'dynamic', 'en'),
(741, 'Your review has been deleted successfully', 'Your review has been deleted successfully', 'dynamic', 'en'),
(742, 'Your message has been sent successfully', 'Your message has been sent successfully', 'dynamic', 'en'),
(743, 'Error on sending', 'Error on sending', 'dynamic', 'en'),
(744, 'New Blog Comment Waiting Review', 'New Blog Comment Waiting Review', 'dynamic', 'en'),
(745, 'Your comment is under review it will be published soon', 'Your comment is under review it will be published soon', 'dynamic', 'en'),
(746, 'Invalid Cron Job Key', 'Invalid Cron Job Key', 'dynamic', 'en'),
(747, 'Cron Job executed successfully', 'Cron Job executed successfully', 'dynamic', 'en'),
(748, 'Choose Image', 'Choose Image', 'dynamic', 'en'),
(749, 'The requested file does not exist.', 'The requested file does not exist.', 'dynamic', 'en'),
(750, '[Hidden In Demo]', '[Hidden In Demo]', 'dynamic', 'en'),
(751, 'Settings', 'Settings', 'dynamic', 'en'),
(752, 'Business', 'Business', 'dynamic', 'en'),
(753, 'Business Settings', 'Business Settings', 'dynamic', 'en'),
(754, 'Actions', 'Actions', 'dynamic', 'en'),
(755, 'Enabled', 'Enabled', 'dynamic', 'en'),
(756, 'Default Settings', 'Default Settings', 'dynamic', 'en'),
(757, 'Total Businesses', 'Total Businesses', 'dynamic', 'en'),
(758, 'Leave the field empty for unlimited businesses.', 'Leave the field empty for unlimited businesses.', 'dynamic', 'en'),
(759, 'Employees', 'Employees', 'dynamic', 'en'),
(760, 'Categories', 'Categories', 'dynamic', 'en'),
(761, 'Trending And Best Rating', 'Trending And Best Rating', 'dynamic', 'en'),
(762, 'Trending Businesses Number', 'Trending Businesses Number', 'dynamic', 'en'),
(763, 'Best Rating Businesses Number', 'Best Rating Businesses Number', 'dynamic', 'en'),
(764, 'You must setup the cron job to refresh the businesses every 24 hours.', 'You must setup the cron job to refresh the businesses every 24 hours.', 'dynamic', 'en'),
(765, 'Setup Cron Job', 'Setup Cron Job', 'dynamic', 'en'),
(766, 'Media', 'Media', 'dynamic', 'en'),
(767, 'General Settings', 'General Settings', 'dynamic', 'en'),
(768, 'Manage general settings for your website.', 'Manage general settings for your website.', 'dynamic', 'en'),
(769, 'Financial Settings', 'Financial Settings', 'dynamic', 'en'),
(770, 'Manage your website financial Settings.', 'Manage your website financial Settings.', 'dynamic', 'en'),
(771, 'SMTP Settings', 'SMTP Settings', 'dynamic', 'en'),
(772, 'Configure your email server settings.', 'Configure your email server settings.', 'dynamic', 'en'),
(773, 'User Settings', 'User Settings', 'dynamic', 'en'),
(774, 'Manage and control the user settings.', 'Manage and control the user settings.', 'dynamic', 'en'),
(775, 'Manage and control the business settings.', 'Manage and control the business settings.', 'dynamic', 'en'),
(776, 'KYC Settings', 'KYC Settings', 'dynamic', 'en'),
(777, 'Manage KYC requirements and settings.', 'Manage KYC requirements and settings.', 'dynamic', 'en'),
(778, 'Subscription Settings', 'Subscription Settings', 'dynamic', 'en'),
(779, 'Manage your subscription settings.', 'Manage your subscription settings.', 'dynamic', 'en'),
(780, 'Languages', 'Languages', 'dynamic', 'en'),
(781, 'Manage language for your website.', 'Manage language for your website.', 'dynamic', 'en'),
(782, 'Mail Templates', 'Mail Templates', 'dynamic', 'en'),
(783, 'Customize email templates for notifications.', 'Customize email templates for notifications.', 'dynamic', 'en'),
(784, 'Themes', 'Themes', 'dynamic', 'en'),
(785, 'Select and manage your website themes.', 'Select and manage your website themes.', 'dynamic', 'en'),
(786, 'Pages', 'Pages', 'dynamic', 'en'),
(787, 'Create and manage website pages.', 'Create and manage website pages.', 'dynamic', 'en'),
(788, 'OAuth Providers', 'OAuth Providers', 'dynamic', 'en'),
(789, 'Manage OAuth providers for social logins.', 'Manage OAuth providers for social logins.', 'dynamic', 'en'),
(790, 'Captcha Providers', 'Captcha Providers', 'dynamic', 'en'),
(791, 'Set up captcha services to prevent bots.', 'Set up captcha services to prevent bots.', 'dynamic', 'en'),
(792, 'Extensions', 'Extensions', 'dynamic', 'en'),
(793, 'Install and manage website extensions.', 'Install and manage website extensions.', 'dynamic', 'en'),
(794, 'Tax Settings', 'Tax Settings', 'dynamic', 'en'),
(795, 'Configure and manage tax rates.', 'Configure and manage tax rates.', 'dynamic', 'en'),
(796, 'Payment Gateways', 'Payment Gateways', 'dynamic', 'en'),
(797, 'Manage payment gateway integrations.', 'Manage payment gateway integrations.', 'dynamic', 'en'),
(798, 'Logo', 'Logo', 'dynamic', 'en'),
(799, 'name', 'name', 'dynamic', 'en'),
(800, 'Status', 'Status', 'dynamic', 'en'),
(801, 'Last Update', 'Last Update', 'dynamic', 'en'),
(802, 'Edit', 'Edit', 'dynamic', 'en'),
(803, 'Edit Captcha Provider', 'Edit Captcha Provider', 'dynamic', 'en'),
(804, 'Parameters', 'Parameters', 'dynamic', 'en'),
(805, 'Credentials', 'Credentials', 'dynamic', 'en'),
(806, 'Subscription', 'Subscription', 'dynamic', 'en'),
(807, 'Before expiring reminder days', 'Before expiring reminder days', 'dynamic', 'en'),
(808, 'Days', 'Days', 'dynamic', 'en'),
(809, 'Number of days before expiration to send a reminder.', 'Number of days before expiration to send a reminder.', 'dynamic', 'en'),
(810, 'After expiring reminder days', 'After expiring reminder days', 'dynamic', 'en'),
(811, 'Number of days after expiration to send a follow-up reminder.', 'Number of days after expiration to send a follow-up reminder.', 'dynamic', 'en'),
(812, 'After expiring data delete days', 'After expiring data delete days', 'dynamic', 'en'),
(813, 'Number of days after expiration to automatically delete the data.', 'Number of days after expiration to automatically delete the data.', 'dynamic', 'en'),
(814, 'General Templates', 'General Templates', 'dynamic', 'en'),
(815, 'User Templates', 'User Templates', 'dynamic', 'en'),
(816, 'Business Templates', 'Business Templates', 'dynamic', 'en'),
(817, 'Admin Templates', 'Admin Templates', 'dynamic', 'en'),
(818, 'Search...', 'Search...', 'dynamic', 'en'),
(819, 'Reset', 'Reset', 'dynamic', 'en'),
(820, 'Edit Mail Template', 'Edit Mail Template', 'dynamic', 'en'),
(821, 'Subject', 'Subject', 'dynamic', 'en'),
(822, 'Body', 'Body', 'dynamic', 'en'),
(823, 'Short Codes', 'Short Codes', 'dynamic', 'en'),
(824, '(Default)', '(Default)', 'dynamic', 'en'),
(825, 'Make Default', 'Make Default', 'dynamic', 'en'),
(826, 'KYC', 'KYC', 'dynamic', 'en'),
(827, 'Fees', 'Fees', 'dynamic', 'en'),
(828, 'Edit Payment Gateway', 'Edit Payment Gateway', 'dynamic', 'en'),
(829, 'Choose Logo', 'Choose Logo', 'dynamic', 'en'),
(830, 'Mode', 'Mode', 'dynamic', 'en'),
(831, 'Currency', 'Currency', 'dynamic', 'en'),
(832, 'Currency Code (USD)', 'Currency Code (USD)', 'dynamic', 'en'),
(833, 'Use this in case you want to charge users with different currency or the gateway does not support your website currency', 'Use this in case you want to charge users with different currency or the gateway does not support your website currency', 'dynamic', 'en'),
(834, 'Instructions', 'Instructions', 'dynamic', 'en'),
(835, 'Edit Extension', 'Edit Extension', 'dynamic', 'en'),
(836, 'Code', 'Code', 'dynamic', 'en'),
(837, 'Direction', 'Direction', 'dynamic', 'en'),
(838, 'Created date', 'Created date', 'dynamic', 'en'),
(839, 'Translates', 'Translates', 'dynamic', 'en'),
(840, 'Delete', 'Delete', 'dynamic', 'en'),
(841, 'Edit Language', 'Edit Language', 'dynamic', 'en'),
(842, 'Important!', 'Important!', 'dynamic', 'en'),
(843, 'You must clear the cache after saving the translations.', 'You must clear the cache after saving the translations.', 'dynamic', 'en'),
(844, 'Dynamic translates are automatically added and they cannot be deleted.', 'Dynamic translates are automatically added and they cannot be deleted.', 'dynamic', 'en'),
(845, 'Manual translates are are the new content you added and they can be deleted.', 'Manual translates are are the new content you added and they can be deleted.', 'dynamic', 'en'),
(846, 'Dynamic Translates', 'Dynamic Translates', 'dynamic', 'en'),
(847, 'Manual Translates', 'Manual Translates', 'dynamic', 'en'),
(848, 'Add New', 'Add New', 'dynamic', 'en'),
(849, 'No data found', 'No data found', 'dynamic', 'en'),
(850, 'Key', 'Key', 'dynamic', 'en'),
(851, 'Value', 'Value', 'dynamic', 'en'),
(852, 'Save', 'Save', 'dynamic', 'en'),
(853, 'Are you sure you want to delete this translation?', 'Are you sure you want to delete this translation?', 'dynamic', 'en'),
(854, 'New Language', 'New Language', 'dynamic', 'en'),
(855, 'SMTP', 'SMTP', 'dynamic', 'en'),
(856, 'SMTP Details', 'SMTP Details', 'dynamic', 'en'),
(857, 'Mail mailer', 'Mail mailer', 'dynamic', 'en'),
(858, 'SENDMAIL', 'SENDMAIL', 'dynamic', 'en'),
(859, 'Mail Host', 'Mail Host', 'dynamic', 'en'),
(860, 'Enter mail host', 'Enter mail host', 'dynamic', 'en'),
(861, 'Mail Port', 'Mail Port', 'dynamic', 'en'),
(862, 'Enter mail port', 'Enter mail port', 'dynamic', 'en'),
(863, 'Mail username', 'Mail username', 'dynamic', 'en'),
(864, 'Enter username', 'Enter username', 'dynamic', 'en'),
(865, 'Mail password', 'Mail password', 'dynamic', 'en'),
(866, 'Enter password', 'Enter password', 'dynamic', 'en'),
(867, 'Mail encryption', 'Mail encryption', 'dynamic', 'en'),
(868, 'TLS', 'TLS', 'dynamic', 'en'),
(869, 'SSL', 'SSL', 'dynamic', 'en'),
(870, 'From email', 'From email', 'dynamic', 'en'),
(871, 'Enter from email', 'Enter from email', 'dynamic', 'en'),
(872, 'From name', 'From name', 'dynamic', 'en'),
(873, 'Enter from name', 'Enter from name', 'dynamic', 'en'),
(874, 'Testing', 'Testing', 'dynamic', 'en'),
(875, 'Email Address', 'Email Address', 'dynamic', 'en'),
(876, 'Send', 'Send', 'dynamic', 'en'),
(877, 'Taxes', 'Taxes', 'dynamic', 'en'),
(878, 'Rate', 'Rate', 'dynamic', 'en'),
(879, 'Countries', 'Countries', 'dynamic', 'en'),
(880, 'Edit Tax', 'Edit Tax', 'dynamic', 'en'),
(881, 'New Tax', 'New Tax', 'dynamic', 'en'),
(882, 'Financial', 'Financial', 'dynamic', 'en'),
(883, 'Currency Code', 'Currency Code', 'dynamic', 'en'),
(884, 'USD', 'USD', 'dynamic', 'en'),
(885, 'Currency Symbol', 'Currency Symbol', 'dynamic', 'en'),
(886, 'Currency position', 'Currency position', 'dynamic', 'en'),
(887, 'General', 'General', 'dynamic', 'en'),
(888, 'General Details', 'General Details', 'dynamic', 'en'),
(889, 'Site Name', 'Site Name', 'dynamic', 'en'),
(890, 'Site URL', 'Site URL', 'dynamic', 'en'),
(891, 'Contact Email', 'Contact Email', 'dynamic', 'en'),
(892, 'This email is required to receive emails from contact page', 'This email is required to receive emails from contact page', 'dynamic', 'en'),
(893, 'Date format', 'Date format', 'dynamic', 'en'),
(894, 'Timezone', 'Timezone', 'dynamic', 'en'),
(895, 'SEO Details (Optional)', 'SEO Details (Optional)', 'dynamic', 'en'),
(896, 'Home title', 'Home title', 'dynamic', 'en'),
(897, 'Description', 'Description', 'dynamic', 'en'),
(898, 'Keywords', 'Keywords', 'dynamic', 'en'),
(899, 'Links', 'Links', 'dynamic', 'en'),
(900, 'Social Media Links', 'Social Media Links', 'dynamic', 'en'),
(901, 'User', 'User', 'dynamic', 'en'),
(902, 'Preview', 'Preview', 'dynamic', 'en'),
(903, 'Edit Page', 'Edit Page', 'dynamic', 'en'),
(904, 'Title', 'Title', 'dynamic', 'en'),
(905, 'Slug', 'Slug', 'dynamic', 'en'),
(906, 'Description (Optional)', 'Description (Optional)', 'dynamic', 'en'),
(907, 'Keywords (Optional)', 'Keywords (Optional)', 'dynamic', 'en'),
(908, 'New Page', 'New Page', 'dynamic', 'en'),
(909, 'Make Active', 'Make Active', 'dynamic', 'en'),
(910, 'Custom CSS', 'Custom CSS', 'dynamic', 'en'),
(911, 'Theme Upload', 'Theme Upload', 'dynamic', 'en'),
(912, 'Make sure you are uploading the correct files.', 'Make sure you are uploading the correct files.', 'dynamic', 'en'),
(913, 'Before uploading a new theme make sure to take a backup of your website files and database.', 'Before uploading a new theme make sure to take a backup of your website files and database.', 'dynamic', 'en'),
(914, 'Theme Purchase Code', 'Theme Purchase Code', 'dynamic', 'en'),
(915, 'Purchase code', 'Purchase code', 'dynamic', 'en'),
(916, 'Theme Files (Zip)', 'Theme Files (Zip)', 'dynamic', 'en'),
(917, 'Close', 'Close', 'dynamic', 'en'),
(918, 'Upload', 'Upload', 'dynamic', 'en'),
(919, 'Sections', 'Sections', 'dynamic', 'en'),
(920, 'FAQs', 'FAQs', 'dynamic', 'en'),
(921, 'Edit FAQ', 'Edit FAQ', 'dynamic', 'en'),
(922, 'New FAQ', 'New FAQ', 'dynamic', 'en'),
(923, 'Home Sections', 'Home Sections', 'dynamic', 'en'),
(924, 'Edit Home Section', 'Edit Home Section', 'dynamic', 'en'),
(925, 'Load content from', 'Load content from', 'dynamic', 'en'),
(926, 'Category', 'Category', 'dynamic', 'en'),
(927, 'Choose', 'Choose', 'dynamic', 'en'),
(928, 'Sub Category', 'Sub Category', 'dynamic', 'en'),
(929, 'Sub Sub Category', 'Sub Sub Category', 'dynamic', 'en'),
(930, 'Items Number', 'Items Number', 'dynamic', 'en'),
(931, 'Between 1 to 100 maximum', 'Between 1 to 100 maximum', 'dynamic', 'en'),
(932, 'Cache Expiry time', 'Cache Expiry time', 'dynamic', 'en'),
(933, 'Minutes', 'Minutes', 'dynamic', 'en'),
(934, 'From 1 to 525600 minutes', 'From 1 to 525600 minutes', 'dynamic', 'en'),
(935, 'You must clear the cache every time you changed the \"Items Number\" or \"Cache Expiry time\"', 'You must clear the cache every time you changed the \"Items Number\" or \"Cache Expiry time\"', 'dynamic', 'en'),
(936, 'New Home Section', 'New Home Section', 'dynamic', 'en'),
(937, 'Verification', 'Verification', 'dynamic', 'en'),
(938, 'Details', 'Details', 'dynamic', 'en'),
(939, 'Rating / Reviews', 'Rating / Reviews', 'dynamic', 'en'),
(940, 'Owner', 'Owner', 'dynamic', 'en'),
(941, 'Added date', 'Added date', 'dynamic', 'en'),
(942, 'Featured', 'Featured', 'dynamic', 'en'),
(943, 'View Details', 'View Details', 'dynamic', 'en'),
(944, 'Remove Featured', 'Remove Featured', 'dynamic', 'en'),
(945, 'Make Featured', 'Make Featured', 'dynamic', 'en'),
(946, 'Suspend', 'Suspend', 'dynamic', 'en'),
(947, 'Activate', 'Activate', 'dynamic', 'en'),
(948, 'Business Reviews', 'Business Reviews', 'dynamic', 'en'),
(949, 'Search', 'Search', 'dynamic', 'en'),
(950, 'Date', 'Date', 'dynamic', 'en'),
(951, 'From Date', 'From Date', 'dynamic', 'en'),
(952, 'To Date', 'To Date', 'dynamic', 'en'),
(953, 'Rating', 'Rating', 'dynamic', 'en'),
(954, 'Excellent', 'Excellent', 'dynamic', 'en'),
(955, 'Great', 'Great', 'dynamic', 'en'),
(956, 'Average', 'Average', 'dynamic', 'en'),
(957, 'Fair', 'Fair', 'dynamic', 'en'),
(958, 'Poor', 'Poor', 'dynamic', 'en'),
(959, 'Statistics', 'Statistics', 'dynamic', 'en'),
(960, 'Business Statistics', 'Business Statistics', 'dynamic', 'en'),
(961, 'Average Rating', 'Average Rating', 'dynamic', 'en'),
(962, 'Total Reviews', 'Total Reviews', 'dynamic', 'en'),
(963, 'Current Month Views', 'Current Month Views', 'dynamic', 'en'),
(964, 'Total Views', 'Total Views', 'dynamic', 'en'),
(965, 'Reviews Statistics', 'Reviews Statistics', 'dynamic', 'en'),
(966, 'Views Statistics', 'Views Statistics', 'dynamic', 'en'),
(967, 'Business Employees', 'Business Employees', 'dynamic', 'en'),
(968, 'Role', 'Role', 'dynamic', 'en'),
(969, 'Business Categories', 'Business Categories', 'dynamic', 'en'),
(970, 'Sub Categories', 'Sub Categories', 'dynamic', 'en'),
(971, 'Business Details', 'Business Details', 'dynamic', 'en'),
(972, 'Business Name', 'Business Name', 'dynamic', 'en'),
(973, 'Website', 'Website', 'dynamic', 'en'),
(974, 'Email', 'Email', 'dynamic', 'en'),
(975, 'Phone Number', 'Phone Number', 'dynamic', 'en'),
(976, 'Short Description', 'Short Description', 'dynamic', 'en'),
(977, 'Full Description', 'Full Description', 'dynamic', 'en'),
(978, 'Tags', 'Tags', 'dynamic', 'en'),
(979, 'No Tags', 'No Tags', 'dynamic', 'en'),
(980, 'Business Logo', 'Business Logo', 'dynamic', 'en'),
(981, 'Business Social Links', 'Business Social Links', 'dynamic', 'en'),
(982, 'Facebook', 'Facebook', 'dynamic', 'en'),
(983, 'X.com', 'X.com', 'dynamic', 'en'),
(984, 'Youtube', 'Youtube', 'dynamic', 'en'),
(985, 'Linkedin', 'Linkedin', 'dynamic', 'en'),
(986, 'Instagram', 'Instagram', 'dynamic', 'en'),
(987, 'Pinterest', 'Pinterest', 'dynamic', 'en'),
(988, 'Business Address', 'Business Address', 'dynamic', 'en'),
(989, 'Address line 1', 'Address line 1', 'dynamic', 'en'),
(990, 'Address line 2', 'Address line 2', 'dynamic', 'en'),
(991, 'City', 'City', 'dynamic', 'en'),
(992, 'State', 'State', 'dynamic', 'en'),
(993, 'Postal code', 'Postal code', 'dynamic', 'en'),
(994, 'Country', 'Country', 'dynamic', 'en'),
(995, 'View Business', 'View Business', 'dynamic', 'en'),
(996, 'Account Settings', 'Account Settings', 'dynamic', 'en'),
(997, 'Account Details', 'Account Details', 'dynamic', 'en'),
(998, 'First Name', 'First Name', 'dynamic', 'en'),
(999, 'Last Name', 'Last Name', 'dynamic', 'en'),
(1000, 'Username', 'Username', 'dynamic', 'en'),
(1001, 'Save Changes', 'Save Changes', 'dynamic', 'en'),
(1002, 'Change Password', 'Change Password', 'dynamic', 'en'),
(1003, 'Password', 'Password', 'dynamic', 'en'),
(1004, 'New Password', 'New Password', 'dynamic', 'en'),
(1005, 'Confirm New Password', 'Confirm New Password', 'dynamic', 'en'),
(1006, 'Two-Factor Authentication', 'Two-Factor Authentication', 'dynamic', 'en'),
(1007, 'Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.', 'Two-factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two-factor authentication protects against phishing, social engineering, and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.', 'dynamic', 'en'),
(1008, 'Enable 2FA Authentication', 'Enable 2FA Authentication', 'dynamic', 'en'),
(1009, 'Disable 2FA Authentication', 'Disable 2FA Authentication', 'dynamic', 'en'),
(1010, 'To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:', 'To use the two factor authentication, you have to install a Google Authenticator compatible app. Here are some that are currently available:', 'dynamic', 'en'),
(1011, 'Google Authenticator for iOS', 'Google Authenticator for iOS', 'dynamic', 'en'),
(1012, 'Google Authenticator for Android', 'Google Authenticator for Android', 'dynamic', 'en'),
(1013, 'Microsoft Authenticator for iOS', 'Microsoft Authenticator for iOS', 'dynamic', 'en'),
(1014, 'Microsoft Authenticator for Android', 'Microsoft Authenticator for Android', 'dynamic', 'en'),
(1015, 'OTP Code', 'OTP Code', 'dynamic', 'en'),
(1016, 'Enable', 'Enable', 'dynamic', 'en'),
(1017, 'Disable', 'Disable', 'dynamic', 'en'),
(1018, 'Pricing plans', 'Pricing plans', 'dynamic', 'en'),
(1019, 'Interval', 'Interval', 'dynamic', 'en'),
(1020, 'Price', 'Price', 'dynamic', 'en'),
(1021, 'Downloads', 'Downloads', 'dynamic', 'en'),
(1022, 'Unlimited', 'Unlimited', 'dynamic', 'en'),
(1023, 'Edit plan', 'Edit plan', 'dynamic', 'en'),
(1024, 'Yes', 'Yes', 'dynamic', 'en'),
(1025, 'No', 'No', 'dynamic', 'en'),
(1026, 'Plan Details', 'Plan Details', 'dynamic', 'en'),
(1027, 'Custom Features', 'Custom Features', 'dynamic', 'en'),
(1028, 'Add custom feature', 'Add custom feature', 'dynamic', 'en'),
(1029, 'New plan', 'New plan', 'dynamic', 'en'),
(1030, 'Admin', 'Admin', 'dynamic', 'en'),
(1031, 'Reset Password', 'Reset Password', 'dynamic', 'en'),
(1032, 'Enter the email address associated with your account and we will send a link to reset your password.', 'Enter the email address associated with your account and we will send a link to reset your password.', 'dynamic', 'en'),
(1033, 'Remember your password', 'Remember your password', 'dynamic', 'en'),
(1034, 'Login', 'Login', 'dynamic', 'en'),
(1035, 'Enter the email address and a new password to start using your account.', 'Enter the email address and a new password to start using your account.', 'dynamic', 'en'),
(1036, 'Confirm Password', 'Confirm Password', 'dynamic', 'en'),
(1037, 'All rights reserved', 'All rights reserved', 'dynamic', 'en'),
(1038, 'Log in to your account to continue.', 'Log in to your account to continue.', 'dynamic', 'en'),
(1039, 'Email or Username', 'Email or Username', 'dynamic', 'en'),
(1040, 'Remember me', 'Remember me', 'dynamic', 'en'),
(1041, 'Forgot password', 'Forgot password', 'dynamic', 'en'),
(1042, '2Fa Verification', '2Fa Verification', 'dynamic', 'en'),
(1043, 'Please enter the OTP code to continue', 'Please enter the OTP code to continue', 'dynamic', 'en'),
(1044, 'Continue', 'Continue', 'dynamic', 'en'),
(1045, 'Notifications', 'Notifications', 'dynamic', 'en'),
(1046, 'Back', 'Back', 'dynamic', 'en'),
(1047, 'Quick Access', 'Quick Access', 'dynamic', 'en'),
(1048, 'Make All as Read', 'Make All as Read', 'dynamic', 'en'),
(1049, 'Delete All Read', 'Delete All Read', 'dynamic', 'en'),
(1050, 'Send Mail', 'Send Mail', 'dynamic', 'en'),
(1051, 'Export All', 'Export All', 'dynamic', 'en'),
(1052, 'Get Help', 'Get Help', 'dynamic', 'en'),
(1053, 'Clear Cache', 'Clear Cache', 'dynamic', 'en'),
(1054, 'Mark All as Read', 'Mark All as Read', 'dynamic', 'en'),
(1055, 'No notifications found', 'No notifications found', 'dynamic', 'en'),
(1056, 'View All', 'View All', 'dynamic', 'en'),
(1057, 'Logout', 'Logout', 'dynamic', 'en'),
(1058, 'All rights reserved.', 'All rights reserved.', 'dynamic', 'en'),
(1059, 'Copied to clipboard', 'Copied to clipboard', 'dynamic', 'en'),
(1060, 'Are you sure?', 'Are you sure?', 'dynamic', 'en'),
(1061, 'No data available in table', 'No data available in table', 'dynamic', 'en'),
(1062, 'Start typing to search...', 'Start typing to search...', 'dynamic', 'en'),
(1063, 'Rows per page _MENU_', 'Rows per page _MENU_', 'dynamic', 'en'),
(1064, 'Showing page _PAGE_ of _PAGES_', 'Showing page _PAGE_ of _PAGES_', 'dynamic', 'en'),
(1065, 'Showing 0 to 0 of 0 entries', 'Showing 0 to 0 of 0 entries', 'dynamic', 'en'),
(1066, '(filtered from _MAX_ total entries)', '(filtered from _MAX_ total entries)', 'dynamic', 'en'),
(1067, 'No matching records found', 'No matching records found', 'dynamic', 'en'),
(1068, 'First', 'First', 'dynamic', 'en'),
(1069, 'Last', 'Last', 'dynamic', 'en'),
(1070, 'Nothing selected', 'Nothing selected', 'dynamic', 'en'),
(1071, 'No results match', 'No results match', 'dynamic', 'en'),
(1072, '{0} of {1} selected', '{0} of {1} selected', 'dynamic', 'en'),
(1073, 'Dashboard', 'Dashboard', 'dynamic', 'en'),
(1074, 'Members', 'Members', 'dynamic', 'en'),
(1075, 'Admins', 'Admins', 'dynamic', 'en'),
(1076, 'Business Owners', 'Business Owners', 'dynamic', 'en'),
(1077, 'Reported', 'Reported', 'dynamic', 'en'),
(1078, 'KYC Verifications', 'KYC Verifications', 'dynamic', 'en'),
(1079, 'Advertisements', 'Advertisements', 'dynamic', 'en'),
(1080, 'Subscriptions', 'Subscriptions', 'dynamic', 'en'),
(1081, 'Transactions', 'Transactions', 'dynamic', 'en'),
(1082, 'Navigation', 'Navigation', 'dynamic', 'en'),
(1083, 'Navbar Links', 'Navbar Links', 'dynamic', 'en'),
(1084, 'Footer Links', 'Footer Links', 'dynamic', 'en'),
(1085, 'Blog', 'Blog', 'dynamic', 'en'),
(1086, 'Articles', 'Articles', 'dynamic', 'en'),
(1087, 'Comments', 'Comments', 'dynamic', 'en'),
(1088, 'Newsletter', 'Newsletter', 'dynamic', 'en'),
(1089, 'Subscribers', 'Subscribers', 'dynamic', 'en'),
(1090, 'System', 'System', 'dynamic', 'en'),
(1091, 'Edit Navbar Link', 'Edit Navbar Link', 'dynamic', 'en'),
(1092, 'Link', 'Link', 'dynamic', 'en'),
(1093, 'Type', 'Type', 'dynamic', 'en'),
(1094, 'New Navbar Link', 'New Navbar Link', 'dynamic', 'en'),
(1095, 'Edit Footer Link', 'Edit Footer Link', 'dynamic', 'en'),
(1096, 'New Footer Link', 'New Footer Link', 'dynamic', 'en'),
(1097, 'Pending Reviews', 'Pending Reviews', 'dynamic', 'en'),
(1098, 'Submitted by', 'Submitted by', 'dynamic', 'en'),
(1099, 'Submitted date', 'Submitted date', 'dynamic', 'en'),
(1100, 'Pending Review', 'Pending Review', 'dynamic', 'en'),
(1101, 'Take Action', 'Take Action', 'dynamic', 'en'),
(1102, 'Publish', 'Publish', 'dynamic', 'en'),
(1103, 'Reject', 'Reject', 'dynamic', 'en'),
(1104, 'Blog Comments', 'Blog Comments', 'dynamic', 'en'),
(1105, 'Posted by', 'Posted by', 'dynamic', 'en'),
(1106, 'Article', 'Article', 'dynamic', 'en'),
(1107, 'Posted date', 'Posted date', 'dynamic', 'en'),
(1108, 'View', 'View', 'dynamic', 'en'),
(1109, 'View Article', 'View Article', 'dynamic', 'en'),
(1110, 'Article:', 'Article:', 'dynamic', 'en'),
(1111, 'Comment:', 'Comment:', 'dynamic', 'en'),
(1112, 'Blog Articles', 'Blog Articles', 'dynamic', 'en'),
(1113, 'Published date', 'Published date', 'dynamic', 'en'),
(1114, 'Edit Blog Article', 'Edit Blog Article', 'dynamic', 'en'),
(1115, 'New Blog Article', 'New Blog Article', 'dynamic', 'en'),
(1116, 'Blog Categories', 'Blog Categories', 'dynamic', 'en'),
(1117, 'Edit Blog Category', 'Edit Blog Category', 'dynamic', 'en'),
(1118, 'Title (Optional)', 'Title (Optional)', 'dynamic', 'en'),
(1119, 'New Blog Category', 'New Blog Category', 'dynamic', 'en'),
(1120, 'Plan', 'Plan', 'dynamic', 'en'),
(1121, 'Business Owner', 'Business Owner', 'dynamic', 'en'),
(1122, 'Expiry date', 'Expiry date', 'dynamic', 'en'),
(1123, 'New subscription', 'New subscription', 'dynamic', 'en'),
(1124, 'Subscription Details', 'Subscription Details', 'dynamic', 'en'),
(1125, 'Subscription ID', 'Subscription ID', 'dynamic', 'en'),
(1126, 'Cancel Subscription', 'Cancel Subscription', 'dynamic', 'en'),
(1127, 'System Information', 'System Information', 'dynamic', 'en'),
(1128, 'View details about your system environment.', 'View details about your system environment.', 'dynamic', 'en'),
(1129, 'Maintenance Mode', 'Maintenance Mode', 'dynamic', 'en'),
(1130, 'Enable or disable maintenance mode.', 'Enable or disable maintenance mode.', 'dynamic', 'en'),
(1131, 'Addons', 'Addons', 'dynamic', 'en'),
(1132, 'Manage and install additional features.', 'Manage and install additional features.', 'dynamic', 'en'),
(1133, 'Admin Panel Style', 'Admin Panel Style', 'dynamic', 'en'),
(1134, 'Customize the appearance of the admin panel.', 'Customize the appearance of the admin panel.', 'dynamic', 'en'),
(1135, 'Editor Images', 'Editor Images', 'dynamic', 'en'),
(1136, 'Manage the uploaded images from the editor.', 'Manage the uploaded images from the editor.', 'dynamic', 'en'),
(1137, 'Cron Job', 'Cron Job', 'dynamic', 'en'),
(1138, 'Schedule automated tasks for your system.', 'Schedule automated tasks for your system.', 'dynamic', 'en'),
(1139, 'Information', 'Information', 'dynamic', 'en'),
(1140, 'Application', 'Application', 'dynamic', 'en'),
(1141, 'Version', 'Version', 'dynamic', 'en'),
(1142, 'v:version\', [\'version\' => config(\'system.item.version', 'v:version\', [\'version\' => config(\'system.item.version', 'dynamic', 'en'),
(1143, 'Laravel Version', 'Laravel Version', 'dynamic', 'en'),
(1144, 'Server Details', 'Server Details', 'dynamic', 'en'),
(1145, 'Software', 'Software', 'dynamic', 'en'),
(1146, 'PHP Version', 'PHP Version', 'dynamic', 'en'),
(1147, 'IP Address', 'IP Address', 'dynamic', 'en'),
(1148, 'Protocol', 'Protocol', 'dynamic', 'en'),
(1149, 'HTTP Host', 'HTTP Host', 'dynamic', 'en'),
(1150, 'Port', 'Port', 'dynamic', 'en'),
(1151, 'System Cache', 'System Cache', 'dynamic', 'en'),
(1152, 'Compiled views will be cleared', 'Compiled views will be cleared', 'dynamic', 'en'),
(1153, 'Application cache will be cleared', 'Application cache will be cleared', 'dynamic', 'en'),
(1154, 'Route cache will be cleared', 'Route cache will be cleared', 'dynamic', 'en'),
(1155, 'Configuration cache will be cleared', 'Configuration cache will be cleared', 'dynamic', 'en'),
(1156, 'All Other Caches will be cleared', 'All Other Caches will be cleared', 'dynamic', 'en'),
(1157, 'Error logs file will be cleared', 'Error logs file will be cleared', 'dynamic', 'en'),
(1158, 'Addon Upload', 'Addon Upload', 'dynamic', 'en'),
(1159, 'Before uploading a new addon make sure to take a backup of your website files and database.', 'Before uploading a new addon make sure to take a backup of your website files and database.', 'dynamic', 'en'),
(1160, 'Addon Purchase Code', 'Addon Purchase Code', 'dynamic', 'en'),
(1161, 'Addon Files (Zip)', 'Addon Files (Zip)', 'dynamic', 'en'),
(1162, 'ID', 'ID', 'dynamic', 'en'),
(1163, 'Uploaded Date', 'Uploaded Date', 'dynamic', 'en'),
(1164, 'Action', 'Action', 'dynamic', 'en'),
(1165, 'System Cron Job', 'System Cron Job', 'dynamic', 'en'),
(1166, 'Command', 'Command', 'dynamic', 'en'),
(1167, 'Last Execution: :date\', [\'date\' => dateFormat(config(\'settings.cronjob.last_execution', 'Last Execution: :date\', [\'date\' => dateFormat(config(\'settings.cronjob.last_execution', 'dynamic', 'en'),
(1168, 'The cron job command must be set to run every minute', 'The cron job command must be set to run every minute', 'dynamic', 'en'),
(1169, 'Generate Key', 'Generate Key', 'dynamic', 'en'),
(1170, 'Remove Key', 'Remove Key', 'dynamic', 'en'),
(1171, 'Maintenance', 'Maintenance', 'dynamic', 'en'),
(1172, 'System Maintenance', 'System Maintenance', 'dynamic', 'en'),
(1173, 'Note!', 'Note!', 'dynamic', 'en'),
(1174, 'As an admin, you can still view and control your website but the visitors will redirect to the maintenance page.', 'As an admin, you can still view and control your website but the visitors will redirect to the maintenance page.', 'dynamic', 'en'),
(1175, 'Colors', 'Colors', 'dynamic', 'en'),
(1176, 'Cron Job Not Working', 'Cron Job Not Working', 'dynamic', 'en'),
(1177, 'It seems that your Cron Job isn\'t set up correctly, which might be causing it not to work as expected. Please double-check and ensure that your Cron Job is properly configured.', 'It seems that your Cron Job isn\'t set up correctly, which might be causing it not to work as expected. Please double-check and ensure that your Cron Job is properly configured.', 'dynamic', 'en'),
(1178, 'Cron Job is required by multiple things to be run (Emails, Refresh businesses, Cache, Sitemap, etc...)', 'Cron Job is required by multiple things to be run (Emails, Refresh businesses, Cache, Sitemap, etc...)', 'dynamic', 'en'),
(1179, 'SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.', 'SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.', 'dynamic', 'en'),
(1180, 'Setup SMTP', 'Setup SMTP', 'dynamic', 'en'),
(1181, 'Earnings', 'Earnings', 'dynamic', 'en'),
(1182, 'Reported Reviews', 'Reported Reviews', 'dynamic', 'en'),
(1183, 'KYC Pending', 'KYC Pending', 'dynamic', 'en'),
(1184, 'Users Statistics For This Month', 'Users Statistics For This Month', 'dynamic', 'en'),
(1185, 'Recently registered users', 'Recently registered users', 'dynamic', 'en'),
(1186, 'Recently added businesses', 'Recently added businesses', 'dynamic', 'en'),
(1187, 'Businesses Statistics For This Month', 'Businesses Statistics For This Month', 'dynamic', 'en'),
(1188, 'Reviews Statistics For This Month', 'Reviews Statistics For This Month', 'dynamic', 'en'),
(1189, 'Payment Method', 'Payment Method', 'dynamic', 'en'),
(1190, 'SubTotal', 'SubTotal', 'dynamic', 'en'),
(1191, 'Tax', 'Tax', 'dynamic', 'en'),
(1192, 'Total', 'Total', 'dynamic', 'en'),
(1193, 'Cancel', 'Cancel', 'dynamic', 'en'),
(1194, 'Cancellation Reason', 'Cancellation Reason', 'dynamic', 'en'),
(1195, 'Send Email Notification', 'Send Email Notification', 'dynamic', 'en'),
(1196, 'Submit', 'Submit', 'dynamic', 'en'),
(1197, 'View Payment Proof', 'View Payment Proof', 'dynamic', 'en'),
(1198, 'Transaction ID', 'Transaction ID', 'dynamic', 'en'),
(1199, 'Transaction Date', 'Transaction Date', 'dynamic', 'en'),
(1200, 'Transaction Status', 'Transaction Status', 'dynamic', 'en'),
(1201, 'Payment Gateway', 'Payment Gateway', 'dynamic', 'en'),
(1202, 'Go to Dashboard', 'Go to Dashboard', 'dynamic', 'en'),
(1203, 'Document Type', 'Document Type', 'dynamic', 'en'),
(1204, 'Document Number', 'Document Number', 'dynamic', 'en'),
(1205, 'Request Approved', 'Request Approved', 'dynamic', 'en'),
(1206, 'This request has been approved and the KYC status is verified', 'This request has been approved and the KYC status is verified', 'dynamic', 'en'),
(1207, 'Request Rejected', 'Request Rejected', 'dynamic', 'en'),
(1208, 'This request has been rejected because of the reason below', 'This request has been rejected because of the reason below', 'dynamic', 'en'),
(1209, 'Approve', 'Approve', 'dynamic', 'en'),
(1210, 'Rejection Reason', 'Rejection Reason', 'dynamic', 'en'),
(1211, 'E-mail Address', 'E-mail Address', 'dynamic', 'en'),
(1212, 'View full details', 'View full details', 'dynamic', 'en'),
(1213, 'Documents', 'Documents', 'dynamic', 'en'),
(1214, 'View Document', 'View Document', 'dynamic', 'en'),
(1215, 'Download', 'Download', 'dynamic', 'en'),
(1216, 'Review ID', 'Review ID', 'dynamic', 'en'),
(1217, 'Reported by', 'Reported by', 'dynamic', 'en'),
(1218, 'Reason', 'Reason', 'dynamic', 'en'),
(1219, 'Report date', 'Report date', 'dynamic', 'en'),
(1220, 'View Review', 'View Review', 'dynamic', 'en'),
(1221, 'Delete Review', 'Delete Review', 'dynamic', 'en'),
(1222, 'Reported Review', 'Reported Review', 'dynamic', 'en'),
(1223, 'Report Reason', 'Report Reason', 'dynamic', 'en'),
(1224, 'Delete Report', 'Delete Report', 'dynamic', 'en'),
(1225, 'Position', 'Position', 'dynamic', 'en'),
(1226, 'Edit Advertisement', 'Edit Advertisement', 'dynamic', 'en'),
(1227, 'Email Verified', 'Email Verified', 'dynamic', 'en'),
(1228, 'Email Unverified', 'Email Unverified', 'dynamic', 'en'),
(1229, 'KYC Verified', 'KYC Verified', 'dynamic', 'en'),
(1230, 'KYC Unverified', 'KYC Unverified', 'dynamic', 'en'),
(1231, 'Email Status', 'Email Status', 'dynamic', 'en'),
(1232, 'KYC Status', 'KYC Status', 'dynamic', 'en'),
(1233, 'Account Status', 'Account Status', 'dynamic', 'en'),
(1234, 'Registered Date', 'Registered Date', 'dynamic', 'en'),
(1235, 'Edit details', 'Edit details', 'dynamic', 'en'),
(1236, 'Login as Business', 'Login as Business', 'dynamic', 'en'),
(1237, 'Businesses employed at', 'Businesses employed at', 'dynamic', 'en'),
(1238, 'Quick Actions', 'Quick Actions', 'dynamic', 'en'),
(1239, 'Employed At', 'Employed At', 'dynamic', 'en'),
(1240, 'Login logs', 'Login logs', 'dynamic', 'en'),
(1241, 'IP', 'IP', 'dynamic', 'en'),
(1242, 'Location', 'Location', 'dynamic', 'en'),
(1243, 'Browser', 'Browser', 'dynamic', 'en'),
(1244, 'OS', 'OS', 'dynamic', 'en'),
(1245, 'Reply to', 'Reply to', 'dynamic', 'en'),
(1246, 'Message', 'Message', 'dynamic', 'en'),
(1247, 'New Business Owner', 'New Business Owner', 'dynamic', 'en'),
(1248, 'Generate', 'Generate', 'dynamic', 'en'),
(1249, 'Registred Date', 'Registred Date', 'dynamic', 'en'),
(1250, 'New Admin', 'New Admin', 'dynamic', 'en'),
(1251, 'View Profile', 'View Profile', 'dynamic', 'en'),
(1252, 'Login as user', 'Login as user', 'dynamic', 'en'),
(1253, 'New User', 'New User', 'dynamic', 'en'),
(1254, 'Newsletter Subscribers', 'Newsletter Subscribers', 'dynamic', 'en'),
(1255, 'Newsletter Settings', 'Newsletter Settings', 'dynamic', 'en'),
(1256, 'Newsletter Status', 'Newsletter Status', 'dynamic', 'en'),
(1257, 'Show Popup', 'Show Popup', 'dynamic', 'en'),
(1258, 'Show Form In Footer', 'Show Form In Footer', 'dynamic', 'en'),
(1259, 'Register New Users', 'Register New Users', 'dynamic', 'en'),
(1260, 'Popup', 'Popup', 'dynamic', 'en'),
(1261, 'PopUp Image', 'PopUp Image', 'dynamic', 'en'),
(1262, 'PopUp Reminder After', 'PopUp Reminder After', 'dynamic', 'en'),
(1263, 'Hours', 'Hours', 'dynamic', 'en'),
(1264, 'Newsletter Send Mail', 'Newsletter Send Mail', 'dynamic', 'en'),
(1265, 'Main Categories', 'Main Categories', 'dynamic', 'en'),
(1266, 'Sub Sub Categories', 'Sub Sub Categories', 'dynamic', 'en'),
(1267, 'Main Category', 'Main Category', 'dynamic', 'en'),
(1268, 'Edit Sub Category', 'Edit Sub Category', 'dynamic', 'en'),
(1269, 'New Sub Category', 'New Sub Category', 'dynamic', 'en'),
(1270, 'Edit Main Category', 'Edit Main Category', 'dynamic', 'en'),
(1271, 'Edit Sub Sub Category', 'Edit Sub Sub Category', 'dynamic', 'en'),
(1272, 'New Sub Sub Category', 'New Sub Sub Category', 'dynamic', 'en'),
(1273, 'New Main Category', 'New Main Category', 'dynamic', 'en'),
(1274, 'Identity Verified', 'Identity Verified', 'dynamic', 'en'),
(1275, 'Guest', 'Guest', 'dynamic', 'en'),
(1276, 'Date of experience', 'Date of experience', 'dynamic', 'en'),
(1277, 'Delete Reply', 'Delete Reply', 'dynamic', 'en'),
(1278, 'It seems that the section you’re looking at is currently empty, or perhaps your search didn’t yield any results', 'It seems that the section you’re looking at is currently empty, or perhaps your search didn’t yield any results', 'dynamic', 'en'),
(1279, 'Explore high rated businesses', 'Explore high rated businesses', 'dynamic', 'en'),
(1280, 'Discover top-rated businesses trusted by customers for quality and service', 'Discover top-rated businesses trusted by customers for quality and service', 'dynamic', 'en'),
(1281, 'Top-rated, trusted, businesses, reviews, quality service, customer satisfaction, best-rated, popular, highly recommended, local businesses, verified ratings, user reviews', 'Top-rated, trusted, businesses, reviews, quality service, customer satisfaction, best-rated, popular, highly recommended, local businesses, verified ratings, user reviews', 'dynamic', 'en'),
(1282, 'Your search results', 'Your search results', 'dynamic', 'en'),
(1283, 'All Businesses', 'All Businesses', 'dynamic', 'en'),
(1284, 'Visit Website', 'Visit Website', 'dynamic', 'en'),
(1285, 'Write a review', 'Write a review', 'dynamic', 'en'),
(1286, 'How would you rate your experience?', 'How would you rate your experience?', 'dynamic', 'en'),
(1287, 'What stood out during your experience?', 'What stood out during your experience?', 'dynamic', 'en'),
(1288, 'Share your thoughts, what you liked or disliked...', 'Share your thoughts, what you liked or disliked...', 'dynamic', 'en'),
(1289, 'Give your review a short title', 'Give your review a short title', 'dynamic', 'en'),
(1290, 'Summarize your experience in a few words', 'Summarize your experience in a few words', 'dynamic', 'en'),
(1291, 'When did this experience take place?', 'When did this experience take place?', 'dynamic', 'en'),
(1292, 'By submitting your review, you confirm it\'s honest, based on your own experience, and not influenced by any rewards or incentives.', 'By submitting your review, you confirm it\'s honest, based on your own experience, and not influenced by any rewards or incentives.', 'dynamic', 'en'),
(1293, 'Your Name', 'Your Name', 'dynamic', 'en'),
(1294, 'Enter your name', 'Enter your name', 'dynamic', 'en'),
(1295, 'Your Email Address', 'Your Email Address', 'dynamic', 'en'),
(1296, 'Enter your email address', 'Enter your email address', 'dynamic', 'en'),
(1297, 'Filtered Reviews', 'Filtered Reviews', 'dynamic', 'en'),
(1298, 'All Reviews', 'All Reviews', 'dynamic', 'en'),
(1299, 'More Filters', 'More Filters', 'dynamic', 'en'),
(1300, 'Filter Reviews', 'Filter Reviews', 'dynamic', 'en'),
(1301, 'All', 'All', 'dynamic', 'en'),
(1302, 'Review Time', 'Review Time', 'dynamic', 'en'),
(1303, 'Any time', 'Any time', 'dynamic', 'en'),
(1304, 'This month', 'This month', 'dynamic', 'en'),
(1305, 'Last month', 'Last month', 'dynamic', 'en'),
(1306, 'This year', 'This year', 'dynamic', 'en'),
(1307, 'Last year', 'Last year', 'dynamic', 'en'),
(1308, 'No Reviews Found', 'No Reviews Found', 'dynamic', 'en'),
(1309, 'No reviews have been submitted for this business or no matches for your search', 'No reviews have been submitted for this business or no matches for your search', 'dynamic', 'en'),
(1310, 'Phone', 'Phone', 'dynamic', 'en'),
(1311, 'Similar Businesses', 'Similar Businesses', 'dynamic', 'en'),
(1312, 'Frequently Asked Questions', 'Frequently Asked Questions', 'dynamic', 'en'),
(1313, 'Complete Details', 'Complete Details', 'dynamic', 'en'),
(1314, 'You need to complete some basic details required to log in next time', 'You need to complete some basic details required to log in next time', 'dynamic', 'en'),
(1315, 'I agree to the', 'I agree to the', 'dynamic', 'en'),
(1316, 'Sign Up', 'Sign Up', 'dynamic', 'en'),
(1317, 'Enter your details to create an account.', 'Enter your details to create an account.', 'dynamic', 'en'),
(1318, 'You an account already?', 'You an account already?', 'dynamic', 'en'),
(1319, 'Sign In', 'Sign In', 'dynamic', 'en'),
(1320, 'You will receive an email with a link to reset your password', 'You will receive an email with a link to reset your password', 'dynamic', 'en'),
(1321, 'You remembered the password?', 'You remembered the password?', 'dynamic', 'en'),
(1322, 'Enter a new password to continue.', 'Enter a new password to continue.', 'dynamic', 'en'),
(1323, 'Link has been resend Successfully', 'Link has been resend Successfully', 'dynamic', 'en'),
(1324, 'Verify Your Email Address', 'Verify Your Email Address', 'dynamic', 'en'),
(1325, 'Please verify your email, simply click on the verification link that has been sent to your email address. If you haven\'t received the verification email, please check your spam or junk folder, or request a new verification email to be sent.', 'Please verify your email, simply click on the verification link that has been sent to your email address. If you haven\'t received the verification email, please check your spam or junk folder, or request a new verification email to be sent.', 'dynamic', 'en'),
(1326, 'Resend', 'Resend', 'dynamic', 'en'),
(1327, 'Change Email', 'Change Email', 'dynamic', 'en'),
(1328, 'Enter your account details to sign in', 'Enter your account details to sign in', 'dynamic', 'en'),
(1329, 'Forgot Your Password?', 'Forgot Your Password?', 'dynamic', 'en'),
(1330, 'You don\'t have an account?', 'You don\'t have an account?', 'dynamic', 'en'),
(1331, 'Checkout', 'Checkout', 'dynamic', 'en'),
(1332, 'Complete the payment', 'Complete the payment', 'dynamic', 'en'),
(1333, 'Payment details', 'Payment details', 'dynamic', 'en'),
(1334, 'Payment proof', 'Payment proof', 'dynamic', 'en'),
(1335, 'Choose payment Proof (Receipt, Bank statement, etc..), allowed file types (jpg, jpeg, png, pdf) in max size 2MB.', 'Choose payment Proof (Receipt, Bank statement, etc..), allowed file types (jpg, jpeg, png, pdf) in max size 2MB.', 'dynamic', 'en'),
(1336, 'Cancel Payment', 'Cancel Payment', 'dynamic', 'en'),
(1337, 'Reply', 'Reply', 'dynamic', 'en'),
(1338, 'Your reply', 'Your reply', 'dynamic', 'en'),
(1339, 'Complete your information', 'Complete your information', 'dynamic', 'en'),
(1340, 'You need to complete some basic information required to log in next time', 'You need to complete some basic information required to log in next time', 'dynamic', 'en'),
(1341, 'I read and I agree to the', 'I read and I agree to the', 'dynamic', 'en'),
(1342, 'Business terms', 'Business terms', 'dynamic', 'en'),
(1343, 'Setup Your Business', 'Setup Your Business', 'dynamic', 'en'),
(1344, 'Provide your business details to begin your journey.', 'Provide your business details to begin your journey.', 'dynamic', 'en'),
(1345, 'Select Category', 'Select Category', 'dynamic', 'en'),
(1346, 'Between 30 to 60 character', 'Between 30 to 60 character', 'dynamic', 'en'),
(1347, 'Get Started', 'Get Started', 'dynamic', 'en'),
(1348, 'Welcome back', 'Welcome back', 'dynamic', 'en'),
(1349, 'Invoice', 'Invoice', 'dynamic', 'en'),
(1350, 'Replied', 'Replied', 'dynamic', 'en'),
(1351, 'Not replied', 'Not replied', 'dynamic', 'en'),
(1352, 'Sort', 'Sort', 'dynamic', 'en'),
(1353, 'Recent Reviews', 'Recent Reviews', 'dynamic', 'en'),
(1354, 'Oldest Reviews', 'Oldest Reviews', 'dynamic', 'en'),
(1355, 'Reset All', 'Reset All', 'dynamic', 'en'),
(1356, 'View All Notifications', 'View All Notifications', 'dynamic', 'en'),
(1357, 'Integration', 'Integration', 'dynamic', 'en'),
(1358, 'Add Business', 'Add Business', 'dynamic', 'en'),
(1359, 'Upgrade', 'Upgrade', 'dynamic', 'en'),
(1360, 'Your business writing a review link', 'Your business writing a review link', 'dynamic', 'en'),
(1361, 'Your customers can use it to write a review for your business. You can copy and share this URL to collect feedback and boost your credibility.', 'Your customers can use it to write a review for your business. You can copy and share this URL to collect feedback and boost your credibility.', 'dynamic', 'en'),
(1362, 'Copy to clipboard', 'Copy to clipboard', 'dynamic', 'en'),
(1363, 'Ready made widgets', 'Ready made widgets', 'dynamic', 'en'),
(1364, ':website_name Widget\', [\'website_name\' => m_trans(config(\'settings.general.site_name', ':website_name Widget\', [\'website_name\' => m_trans(config(\'settings.general.site_name', 'dynamic', 'en'),
(1365, 'Renew', 'Renew', 'dynamic', 'en'),
(1366, 'You are not subscribed', 'You are not subscribed', 'dynamic', 'en'),
(1367, 'You are not subscribed to any plan, you can subscribe by clicking on the button below', 'You are not subscribed to any plan, you can subscribe by clicking on the button below', 'dynamic', 'en'),
(1368, 'Subscribe', 'Subscribe', 'dynamic', 'en'),
(1369, 'Choose your plan', 'Choose your plan', 'dynamic', 'en'),
(1370, 'Number', 'Number', 'dynamic', 'en'),
(1371, 'Billed to', 'Billed to', 'dynamic', 'en'),
(1372, 'Item', 'Item', 'dynamic', 'en'),
(1373, 'Print', 'Print', 'dynamic', 'en'),
(1374, 'Total Visitors', 'Total Visitors', 'dynamic', 'en'),
(1375, 'Latest Reviews', 'Latest Reviews', 'dynamic', 'en'),
(1376, 'Between 30 to 60 characters', 'Between 30 to 60 characters', 'dynamic', 'en');
INSERT INTO `translates` (`id`, `key`, `value`, `type`, `lang`) VALUES
(1377, 'Max 1500 characters', 'Max 1500 characters', 'dynamic', 'en'),
(1378, 'Add relevant tags to help improve search visibility and make it easier for people to find your business quickly', 'Add relevant tags to help improve search visibility and make it easier for people to find your business quickly', 'dynamic', 'en'),
(1379, 'Supported types: JPEG, JPG, and PNG. Image dimensions must 512x512 pixels and not exceed 2MB.', 'Supported types: JPEG, JPG, and PNG. Image dimensions must 512x512 pixels and not exceed 2MB.', 'dynamic', 'en'),
(1380, 'Business Deletion', 'Business Deletion', 'dynamic', 'en'),
(1381, 'After deleting your business, you will lose all your reviews and settings and will not be able to restore them', 'After deleting your business, you will lose all your reviews and settings and will not be able to restore them', 'dynamic', 'en'),
(1382, 'Delete business', 'Delete business', 'dynamic', 'en'),
(1383, 'Back to home', 'Back to home', 'dynamic', 'en'),
(1384, 'Payment Completed', 'Payment Completed', 'dynamic', 'en'),
(1385, 'Payment has been completed and your subscription has been created successfully.', 'Payment has been completed and your subscription has been created successfully.', 'dynamic', 'en'),
(1386, 'View My Subscription', 'View My Subscription', 'dynamic', 'en'),
(1387, 'Add New Employee', 'Add New Employee', 'dynamic', 'en'),
(1388, 'Note:', 'Note:', 'dynamic', 'en'),
(1389, 'An invitation link will be sent to the employee\'s email. They must accept the invitation and join the platform.', 'An invitation link will be sent to the employee\'s email. They must accept the invitation and join the platform.', 'dynamic', 'en'),
(1390, 'Roles Overview:', 'Roles Overview:', 'dynamic', 'en'),
(1391, 'Admin:', 'Admin:', 'dynamic', 'en'),
(1392, 'Full access to all business settings and reviews.', 'Full access to all business settings and reviews.', 'dynamic', 'en'),
(1393, 'Employee:', 'Employee:', 'dynamic', 'en'),
(1394, 'Can manage reviews only and reply to them.', 'Can manage reviews only and reply to them.', 'dynamic', 'en'),
(1395, 'Add', 'Add', 'dynamic', 'en'),
(1396, 'Add New Category', 'Add New Category', 'dynamic', 'en'),
(1397, 'Select Sub Categories', 'Select Sub Categories', 'dynamic', 'en'),
(1398, 'Choose Avatar', 'Choose Avatar', 'dynamic', 'en'),
(1399, '2FA Authentication', '2FA Authentication', 'dynamic', 'en'),
(1400, 'KYC Verification', 'KYC Verification', 'dynamic', 'en'),
(1401, 'ID Verification', 'ID Verification', 'dynamic', 'en'),
(1402, 'Upload a clear, legible image and Ensure that all relevant details, such as your name, photo, and ID number, are visible. the image must be type of .JPG or .PNG', 'Upload a clear, legible image and Ensure that all relevant details, such as your name, photo, and ID number, are visible. the image must be type of .JPG or .PNG', 'dynamic', 'en'),
(1403, 'National ID Number', 'National ID Number', 'dynamic', 'en'),
(1404, 'Passport Number', 'Passport Number', 'dynamic', 'en'),
(1405, 'Front Of ID', 'Front Of ID', 'dynamic', 'en'),
(1406, 'Back Of ID', 'Back Of ID', 'dynamic', 'en'),
(1407, 'Selfie Verification', 'Selfie Verification', 'dynamic', 'en'),
(1408, 'Upload a clear selfie and Ensure it\'s well-lit and visible. the image must be type of.JPG or .PNG', 'Upload a clear selfie and Ensure it\'s well-lit and visible. the image must be type of.JPG or .PNG', 'dynamic', 'en'),
(1409, '2Factor Authentication', '2Factor Authentication', 'dynamic', 'en'),
(1410, 'Unlimited businesses', 'Unlimited businesses', 'dynamic', 'en'),
(1411, 'Category management', 'Category management', 'dynamic', 'en'),
(1412, 'Employee management', 'Employee management', 'dynamic', 'en'),
(1413, 'Subscribed', 'Subscribed', 'dynamic', 'en'),
(1414, 'Downgrade', 'Downgrade', 'dynamic', 'en'),
(1415, 'Switch Plan', 'Switch Plan', 'dynamic', 'en'),
(1416, 'Start Now', 'Start Now', 'dynamic', 'en'),
(1417, 'Or', 'Or', 'dynamic', 'en'),
(1418, 'Complete your business details', 'Complete your business details', 'dynamic', 'en'),
(1419, 'Complete your business details to help potential customers find you more easily and build trust in your brand.', 'Complete your business details to help potential customers find you more easily and build trust in your brand.', 'dynamic', 'en'),
(1420, 'Verify your domain ownership', 'Verify your domain ownership', 'dynamic', 'en'),
(1421, 'Verifying your domain helps build trust and ensures your business appears more credible to visitors.', 'Verifying your domain helps build trust and ensures your business appears more credible to visitors.', 'dynamic', 'en'),
(1422, 'To verify your domain, follow these steps:', 'To verify your domain, follow these steps:', 'dynamic', 'en'),
(1423, 'Go to your domain DNS settings.', 'Go to your domain DNS settings.', 'dynamic', 'en'),
(1424, 'Add a new TXT record with the following details:', 'Add a new TXT record with the following details:', 'dynamic', 'en'),
(1425, 'Type:', 'Type:', 'dynamic', 'en'),
(1426, 'Name/Host:', 'Name/Host:', 'dynamic', 'en'),
(1427, 'Value:', 'Value:', 'dynamic', 'en'),
(1428, 'Once added, click verify now to check and please note that it may take a few minutes for changes to propagate', 'Once added, click verify now to check and please note that it may take a few minutes for changes to propagate', 'dynamic', 'en'),
(1429, 'Verify Now', 'Verify Now', 'dynamic', 'en'),
(1430, 'Need Help?', 'Need Help?', 'dynamic', 'en'),
(1431, 'For Businesses', 'For Businesses', 'dynamic', 'en'),
(1432, 'Profile', 'Profile', 'dynamic', 'en'),
(1433, 'Follow Us:', 'Follow Us:', 'dynamic', 'en'),
(1434, 'This user hasn\'t reviewed any businesses yet. Their reviews will appear here once submitted', 'This user hasn\'t reviewed any businesses yet. Their reviews will appear here once submitted', 'dynamic', 'en'),
(1435, 'No blog articles found', 'No blog articles found', 'dynamic', 'en'),
(1436, 'Leave a comment', 'Leave a comment', 'dynamic', 'en'),
(1437, 'Your comment', 'Your comment', 'dynamic', 'en'),
(1438, 'Login or create account to leave comments', 'Login or create account to leave comments', 'dynamic', 'en'),
(1439, 'We use cookies to personalize your experience. By continuing to visit this website you agree to our use of cookies', 'We use cookies to personalize your experience. By continuing to visit this website you agree to our use of cookies', 'dynamic', 'en'),
(1440, 'Got it', 'Got it', 'dynamic', 'en'),
(1441, 'More', 'More', 'dynamic', 'en'),
(1442, 'Or With', 'Or With', 'dynamic', 'en'),
(1443, 'Payments Method', 'Payments Method', 'dynamic', 'en'),
(1444, 'Billing address', 'Billing address', 'dynamic', 'en'),
(1445, 'SSL Secure Payment', 'SSL Secure Payment', 'dynamic', 'en'),
(1446, 'Your information is protected by 256-bit SSL encryption', 'Your information is protected by 256-bit SSL encryption', 'dynamic', 'en'),
(1447, 'Order Summary', 'Order Summary', 'dynamic', 'en'),
(1448, 'Subscribe to Our Newsletter', 'Subscribe to Our Newsletter', 'dynamic', 'en'),
(1449, 'Stay tuned for the latest news, updates and best rated businesses, delivered right to your inbox!', 'Stay tuned for the latest news, updates and best rated businesses, delivered right to your inbox!', 'dynamic', 'en'),
(1450, 'Your Email', 'Your Email', 'dynamic', 'en'),
(1451, 'Remind me later', 'Remind me later', 'dynamic', 'en'),
(1452, 'We\'ll keep you updated with the latest news and updates.', 'We\'ll keep you updated with the latest news and updates.', 'dynamic', 'en'),
(1453, 'Enter your email', 'Enter your email', 'dynamic', 'en'),
(1454, 'View Businesses', 'View Businesses', 'dynamic', 'en'),
(1455, 'Related Categories', 'Related Categories', 'dynamic', 'en'),
(1456, 'Popular searches', 'Popular searches', 'dynamic', 'en'),
(1457, 'Share', 'Share', 'dynamic', 'en'),
(1458, 'Report reason?', 'Report reason?', 'dynamic', 'en'),
(1459, 'No results available', 'No results available', 'dynamic', 'en'),
(1460, 'No results available. This may be due to an empty section or no matches for your search.', 'No results available. This may be due to an empty section or no matches for your search.', 'dynamic', 'en'),
(1461, 'KYC Verification Pending', 'KYC Verification Pending', 'dynamic', 'en'),
(1462, 'Your KYC verification is currently pending. We are processing your information, and you will be notified once the verification is complete.', 'Your KYC verification is currently pending. We are processing your information, and you will be notified once the verification is complete.', 'dynamic', 'en'),
(1463, 'View KYC Status', 'View KYC Status', 'dynamic', 'en'),
(1464, 'KYC Verification Required', 'KYC Verification Required', 'dynamic', 'en'),
(1465, 'Your KYC verification is required to continue using our platform. Please complete the verification process as soon as possible.', 'Your KYC verification is required to continue using our platform. Please complete the verification process as soon as possible.', 'dynamic', 'en'),
(1466, 'Complete KYC', 'Complete KYC', 'dynamic', 'en'),
(1467, 'Filters', 'Filters', 'dynamic', 'en'),
(1468, '[Read more...]', '[Read more...]', 'dynamic', 'en'),
(1469, 'City or ZIP code', 'City or ZIP code', 'dynamic', 'en'),
(1470, 'Trending', 'Trending', 'dynamic', 'en'),
(1471, 'Best Rating', 'Best Rating', 'dynamic', 'en'),
(1472, 'KYC Verification Completed', 'KYC Verification Completed', 'dynamic', 'en'),
(1473, 'Congratulations! Your KYC verification has been successfully completed. You can now fully access our platform without any restrictions.', 'Congratulations! Your KYC verification has been successfully completed. You can now fully access our platform without any restrictions.', 'dynamic', 'en'),
(1474, 'Rate and Find Trusted Businesses', 'Rate and Find Trusted Businesses', 'dynamic', 'en'),
(1475, 'Rate and review businesses based on your experiences, and explore trusted businesses to make informed decisions', 'Rate and review businesses based on your experiences, and explore trusted businesses to make informed decisions', 'dynamic', 'en'),
(1476, 'No results found', 'No results found', 'dynamic', 'en'),
(1477, 'Contact US', 'Contact US', 'dynamic', 'en'),
(1478, 'Page Not Found', 'Page Not Found', 'dynamic', 'en'),
(1479, 'Server Error', 'Server Error', 'dynamic', 'en'),
(1480, 'Forbidden', 'Forbidden', 'dynamic', 'en'),
(1481, 'Too Many Requests', 'Too Many Requests', 'dynamic', 'en'),
(1482, 'Page Expired', 'Page Expired', 'dynamic', 'en'),
(1483, 'Unauthorized', 'Unauthorized', 'dynamic', 'en'),
(1484, 'Service Unavailable', 'Service Unavailable', 'dynamic', 'en'),
(1485, 'Purchase code is required', 'Purchase code is required', 'dynamic', 'en'),
(1486, 'Connection error, please try again later', 'Connection error, please try again later', 'dynamic', 'en'),
(1487, 'Database details cannot contain a hashtag #', 'Database details cannot contain a hashtag #', 'dynamic', 'en'),
(1488, 'CURL does not exist in server', 'CURL does not exist in server', 'dynamic', 'en'),
(1489, '.env file is not writable', '.env file is not writable', 'dynamic', 'en'),
(1490, 'Incorrect database details', 'Incorrect database details', 'dynamic', 'en'),
(1491, 'SQL file is missing', 'SQL file is missing', 'dynamic', 'en'),
(1492, 'Could not find the database. Please check your configuration.', 'Could not find the database. Please check your configuration.', 'dynamic', 'en'),
(1493, 'Website URL cannot contain a hashtag #', 'Website URL cannot contain a hashtag #', 'dynamic', 'en'),
(1494, 'Failed to update general settings', 'Failed to update general settings', 'dynamic', 'en'),
(1495, 'Import', 'Import', 'dynamic', 'en'),
(1496, 'Import your database, some servers may not support this feature or have problems, so we recommend using manual Import if you encounter a problem with automatic Import.', 'Import your database, some servers may not support this feature or have problems, so we recommend using manual Import if you encounter a problem with automatic Import.', 'dynamic', 'en'),
(1497, 'Auto Import', 'Auto Import', 'dynamic', 'en'),
(1498, 'Manual Import', 'Manual Import', 'dynamic', 'en'),
(1499, 'Importing your database automatically, click import now', 'Importing your database automatically, click import now', 'dynamic', 'en'),
(1500, 'Import Now', 'Import Now', 'dynamic', 'en'),
(1501, 'Important Notice !', 'Important Notice !', 'dynamic', 'en'),
(1502, 'Auto import is not supported on some servers, if you click import and you get 500 Error that means your server does not support it, please use the manual import.', 'Auto import is not supported on some servers, if you click import and you get 500 Error that means your server does not support it, please use the manual import.', 'dynamic', 'en'),
(1503, 'Importing your database Manually, follow the steps', 'Importing your database Manually, follow the steps', 'dynamic', 'en'),
(1504, '1 - Download the SQL file', '1 - Download the SQL file', 'dynamic', 'en'),
(1505, 'Download SQL file', 'Download SQL file', 'dynamic', 'en'),
(1506, '2 - Follow this steps', '2 - Follow this steps', 'dynamic', 'en'),
(1507, 'Check this video to know how you can import the database', 'Check this video to know how you can import the database', 'dynamic', 'en'),
(1508, '3 - After importing the database, click Skip to the next step', '3 - After importing the database, click Skip to the next step', 'dynamic', 'en'),
(1509, 'Skip to next step', 'Skip to next step', 'dynamic', 'en'),
(1510, 'Make sure you import the database before clicking skip to next step', 'Make sure you import the database before clicking skip to next step', 'dynamic', 'en'),
(1511, 'Database', 'Database', 'dynamic', 'en'),
(1512, 'Enter your database details. You can read the docs included with the script files to learn how to create the database, please do not use the hashtag \"#\" or spaces on the database details.', 'Enter your database details. You can read the docs included with the script files to learn how to create the database, please do not use the hashtag \"#\" or spaces on the database details.', 'dynamic', 'en'),
(1513, 'Database host', 'Database host', 'dynamic', 'en'),
(1514, 'Enter database host', 'Enter database host', 'dynamic', 'en'),
(1515, 'Database name', 'Database name', 'dynamic', 'en'),
(1516, 'Enter database name', 'Enter database name', 'dynamic', 'en'),
(1517, 'Database username', 'Database username', 'dynamic', 'en'),
(1518, 'Enter database username', 'Enter database username', 'dynamic', 'en'),
(1519, 'Database password', 'Database password', 'dynamic', 'en'),
(1520, 'Enter database password', 'Enter database password', 'dynamic', 'en'),
(1521, 'License', 'License', 'dynamic', 'en'),
(1522, 'As part of protecting our products we are building our systems to validate the license for every customer, the license means your purchase code.', 'As part of protecting our products we are building our systems to validate the license for every customer, the license means your purchase code.', 'dynamic', 'en'),
(1523, 'Enter your purchase code', 'Enter your purchase code', 'dynamic', 'en'),
(1524, 'Follow the links below to learn more about licenses and how you can get it', 'Follow the links below to learn more about licenses and how you can get it', 'dynamic', 'en'),
(1525, 'What The License Mean', 'What The License Mean', 'dynamic', 'en'),
(1526, 'Where Is My Purchase Code', 'Where Is My Purchase Code', 'dynamic', 'en'),
(1527, 'Where I Can Bought a License', 'Where I Can Bought a License', 'dynamic', 'en'),
(1528, 'Complete', 'Complete', 'dynamic', 'en'),
(1529, 'Enter your website and admin access details, make sure you remember the admin access path.', 'Enter your website and admin access details, make sure you remember the admin access path.', 'dynamic', 'en'),
(1530, 'Website name', 'Website name', 'dynamic', 'en'),
(1531, 'Website URL', 'Website URL', 'dynamic', 'en'),
(1532, 'Business path', 'Business path', 'dynamic', 'en'),
(1533, 'Letters and numbers only', 'Letters and numbers only', 'dynamic', 'en'),
(1534, 'Admin panel path', 'Admin panel path', 'dynamic', 'en'),
(1535, 'Admin Username', 'Admin Username', 'dynamic', 'en'),
(1536, 'Admin email', 'Admin email', 'dynamic', 'en'),
(1537, 'Admin password', 'Admin password', 'dynamic', 'en'),
(1538, 'Confirm admin password', 'Confirm admin password', 'dynamic', 'en'),
(1539, 'Finish', 'Finish', 'dynamic', 'en'),
(1540, 'Permissions', 'Permissions', 'dynamic', 'en'),
(1541, 'All permissions are enabled you can continue to next step', 'All permissions are enabled you can continue to next step', 'dynamic', 'en'),
(1542, 'Some permissions are missing please give 0775 permission to all files above.', 'Some permissions are missing please give 0775 permission to all files above.', 'dynamic', 'en'),
(1543, 'Vironeer Installer', 'Vironeer Installer', 'dynamic', 'en'),
(1544, 'Requirements', 'Requirements', 'dynamic', 'en'),
(1545, 'Completed', 'Completed', 'dynamic', 'en'),
(1546, 'Vironeer', 'Vironeer', 'dynamic', 'en'),
(1547, 'Envato', 'Envato', 'dynamic', 'en'),
(1548, 'All extensions are enabled you can continue to next step', 'All extensions are enabled you can continue to next step', 'dynamic', 'en'),
(1549, 'Some extensions are required please enable them before you can continue.', 'Some extensions are required please enable them before you can continue.', 'dynamic', 'en'),
(1550, 'Home', 'Home', 'dynamic', 'en'),
(1551, 'Review', 'Review', 'dynamic', 'en'),
(1552, 'Transaction', 'Transaction', 'dynamic', 'en'),
(1553, ':language translates', ':language translates', 'dynamic', 'en'),
(1554, 'There are some words that should not be translated that start with some tags or are inside a tag like :tags etc...', 'There are some words that should not be translated that start with some tags or are inside a tag like :tags etc...', 'dynamic', 'en'),
(1555, 'Notifications (:count)', 'Notifications (:count)', 'dynamic', 'en'),
(1556, ':app_name v:version', ':app_name v:version', 'dynamic', 'en'),
(1557, ':count Business|:count Businesses', ':count Business|:count Businesses', 'dynamic', 'en'),
(1558, ':count Review|:count Reviews', ':count Review|:count Reviews', 'dynamic', 'en'),
(1559, ':website_name Widget', ':website_name Widget', 'dynamic', 'en'),
(1560, ':number Star', ':number Star', 'dynamic', 'en'),
(1561, 'Sorry, the page you are looking for could not be found. It may have been moved,renamed, or deleted. Please check the URL and try again, or back to the homepage', 'Sorry, the page you are looking for could not be found. It may have been moved, renamed, or deleted. Please check the URL and try again, or back to the homepage', 'dynamic', 'en'),
(1562, 'Edit Business Owner :name', 'Edit Business Owner :name', 'dynamic', 'en'),
(1563, ':business_name Details', ':business_name Details', 'dynamic', 'en'),
(1564, ':business_name Categories', ':business_name Categories', 'dynamic', 'en'),
(1565, ':business_name Employees', ':business_name Employees', 'dynamic', 'en'),
(1566, ':business_name Reviews', ':business_name Reviews', 'dynamic', 'en'),
(1567, 'Sorry, there was an internal server error, and we were unable to fulfill your request. Please try again later.', 'Sorry, there was an internal server error, and we were unable to fulfill your request. Please try again later.', 'dynamic', 'en'),
(1568, 'Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.', 'Sorry, you are not authorized to access this resource. Please make sure you have the necessary permissions to view this page.', 'dynamic', 'en'),
(1569, 'Sorry, you have exceeded the rate limit for accessing this resource. Please wait a few minutes and try again.', 'Sorry, you have exceeded the rate limit for accessing this resource. Please wait a few minutes and try again.', 'dynamic', 'en'),
(1570, 'Sorry, your session has expired, or the form has become invalid. Please refresh the page and try again.', 'Sorry, your session has expired, or the form has become invalid. Please refresh the page and try again.', 'dynamic', 'en'),
(1571, 'Sorry, the server is currently unavailable, and we are unable to fulfill your request. Please try again later.', 'Sorry, the server is currently unavailable, and we are unable to fulfill your request. Please try again later.', 'dynamic', 'en'),
(1572, 'Head Code', 'Head Code', 'dynamic', 'en'),
(1573, 'Home Page (Top)', 'Home Page (Top)', 'dynamic', 'en'),
(1574, 'Home Page (Center)', 'Home Page (Center)', 'dynamic', 'en'),
(1575, 'Home Page (Bottom)', 'Home Page (Bottom)', 'dynamic', 'en'),
(1576, 'Business Page (Top)', 'Business Page (Top)', 'dynamic', 'en'),
(1577, 'Business Page (Center)', 'Business Page (Center)', 'dynamic', 'en'),
(1578, 'Business Page (Bottom)', 'Business Page (Bottom)', 'dynamic', 'en'),
(1579, 'Business Page Sidebar', 'Business Page Sidebar', 'dynamic', 'en'),
(1580, 'Categories Page (Top)', 'Categories Page (Top)', 'dynamic', 'en'),
(1581, 'Categories Page (Bottom)', 'Categories Page (Bottom)', 'dynamic', 'en'),
(1582, 'Search Page (Top)', 'Search Page (Top)', 'dynamic', 'en'),
(1583, 'Search Page (Bottom)', 'Search Page (Bottom)', 'dynamic', 'en'),
(1584, 'Blog Page (Top)', 'Blog Page (Top)', 'dynamic', 'en'),
(1585, 'Blog Page (Bottom)', 'Blog Page (Bottom)', 'dynamic', 'en'),
(1586, 'Blog Article Page (Top)', 'Blog Article Page (Top)', 'dynamic', 'en'),
(1587, 'Blog Article Page (Bottom)', 'Blog Article Page (Bottom)', 'dynamic', 'en'),
(1588, 'Supported Types (:types)', 'Supported Types (:types)', 'dynamic', 'en'),
(1589, ':count Countries', ':count Countries', 'dynamic', 'en'),
(1590, 'v:version', 'v:version', 'dynamic', 'en'),
(1591, ':theme_name Theme Custom CSS', ':theme_name Theme Custom CSS', 'dynamic', 'en'),
(1592, ':theme_name Theme Settings', ':theme_name Theme Settings', 'dynamic', 'en'),
(1593, ':business_name Statistics', ':business_name Statistics', 'dynamic', 'en'),
(1594, 'Pending Review #:review_id', 'Pending Review #:review_id', 'dynamic', 'en'),
(1595, 'Comment #:comment_id', 'Comment #:comment_id', 'dynamic', 'en'),
(1596, ':plan_name (:plan_interval)', ':plan_name (:plan_interval)', 'dynamic', 'en'),
(1597, 'Subscription #:subscription_id', 'Subscription #:subscription_id', 'dynamic', 'en'),
(1598, 'Version: :version', 'Version: :version', 'dynamic', 'en'),
(1599, 'Last Execution: :date', 'Last Execution: :date', 'dynamic', 'en'),
(1600, 'Transaction #:transaction_id', 'Transaction #:transaction_id', 'dynamic', 'en'),
(1601, ':tax_name (:tax_rate%)', ':tax_name (:tax_rate%)', 'dynamic', 'en'),
(1602, ':payment_gateway Fees (:percentage%)', ':payment_gateway Fees (:percentage%)', 'dynamic', 'en'),
(1603, 'KYC Verification #:kyc_verification_id', 'KYC Verification #:kyc_verification_id', 'dynamic', 'en'),
(1604, 'Reported Review #:report_id', 'Reported Review #:report_id', 'dynamic', 'en'),
(1605, 'Send Mail To :email', 'Send Mail To :email', 'dynamic', 'en'),
(1606, 'Edit Admin :name', 'Edit Admin :name', 'dynamic', 'en'),
(1607, 'Edit User :name', 'Edit User :name', 'dynamic', 'en'),
(1608, 'Rate :business_name', 'Rate :business_name', 'dynamic', 'en'),
(1609, ':business_name Review', ':business_name Review', 'dynamic', 'en'),
(1610, ':business_name Reviews - Read Reviews About :business_domain', ':business_name Reviews - Read Reviews About :business_domain', 'dynamic', 'en'),
(1611, 'Transaction #:number', 'Transaction #:number', 'dynamic', 'en'),
(1612, 'Invoice #:number', 'Invoice #:number', 'dynamic', 'en'),
(1613, '* This transaction was processed by :payment_method', '* This transaction was processed by :payment_method', 'dynamic', 'en'),
(1614, ':username Profile', ':username Profile', 'dynamic', 'en'),
(1615, 'Useful (:likes)', 'Useful (:likes)', 'dynamic', 'en'),
(1616, 'Your search results for the \":name\" category', 'Your search results for the \":name\" category', 'dynamic', 'en'),
(1617, 'All results for the \":name\" category', 'All results for the \":name\" category', 'dynamic', 'en'),
(1618, 'Review of :business_name', 'Review of :business_name', 'dynamic', 'en'),
(1619, ':username has registered', ':username has registered', 'dynamic', 'en'),
(1620, 'Payment for subscription #:number', 'Payment for subscription #:number', 'dynamic', 'en'),
(1621, 'New Business Added (:business_name)', 'New Business Added (:business_name)', 'dynamic', 'en'),
(1622, 'You business \":business_name\" has been deleted successfully', 'You business \":business_name\" has been deleted successfully', 'dynamic', 'en'),
(1623, ':key cannot be empty', ':key cannot be empty', 'dynamic', 'en'),
(1624, ':country is already exists', ':country is already exists', 'dynamic', 'en'),
(1625, 'The :theme_name theme is already exists.', 'The :theme_name theme is already exists.', 'dynamic', 'en'),
(1626, 'The {theme_name} is not exists to make the update.', 'The {theme_name} is not exists to make the update.', 'dynamic', 'en'),
(1627, 'Failed to update :label', 'Failed to update :label', 'dynamic', 'en'),
(1628, 'The :addon_name addon require :script_name version :script_version or above', 'The :addon_name addon require :script_name version :script_version or above', 'dynamic', 'en'),
(1629, 'New Pending Review [#:review_id]', 'New Pending Review [#:review_id]', 'dynamic', 'en'),
(1630, 'New Pending Transaction [#:transaction_id]', 'New Pending Transaction [#:transaction_id]', 'dynamic', 'en'),
(1631, 'New Reported Review [#:report_id]', 'New Reported Review [#:report_id]', 'dynamic', 'en'),
(1632, 'KYC Verification Request [#:kyc_verification_id]', 'KYC Verification Request [#:kyc_verification_id]', 'dynamic', 'en'),
(1633, 'New Review From (:name)', 'New Review From (:name)', 'dynamic', 'en'),
(1634, 'Owners registration', 'Owners registration', 'dynamic', 'en'),
(1635, 'Owners email verification', 'Owners email verification', 'dynamic', 'en'),
(1636, 'Owners kyc required', 'Owners kyc required', 'dynamic', 'en'),
(1638, 'Convert logo to webp', 'Convert logo to webp', 'dynamic', 'en'),
(1639, 'Reviews require login', 'Reviews require login', 'dynamic', 'en'),
(1640, 'Reviews require reviewing', 'Reviews require reviewing', 'dynamic', 'en'),
(1641, 'Default logo', 'Default logo', 'dynamic', 'en'),
(1642, 'plans', 'plans', 'dynamic', 'en'),
(1643, ':avg_ratings from :total_reviews Review and Rating|:avg_ratings from :total_reviews Reviews and Ratings', ':avg_ratings from :total_reviews Review and Rating|:avg_ratings from :total_reviews Reviews and Ratings', 'dynamic', 'en'),
(1644, 'Google', 'Google', 'dynamic', 'en'),
(1645, 'Microsoft', 'Microsoft', 'dynamic', 'en'),
(1646, 'Vkontakte', 'Vkontakte', 'dynamic', 'en'),
(1647, 'Callback URL', 'Callback URL', 'dynamic', 'en'),
(1648, 'client id', 'client id', 'dynamic', 'en'),
(1649, 'client secret', 'client secret', 'dynamic', 'en'),
(1650, 'Google reCAPTCHA', 'Google reCAPTCHA', 'dynamic', 'en'),
(1651, 'hCaptcha', 'hCaptcha', 'dynamic', 'en'),
(1652, 'Cloudflare Turnstile', 'Cloudflare Turnstile', 'dynamic', 'en'),
(1653, 'site key', 'site key', 'dynamic', 'en'),
(1654, 'secret key', 'secret key', 'dynamic', 'en'),
(1655, 'Account', 'Account', 'dynamic', 'en'),
(1656, 'My Account', 'My Account', 'dynamic', 'en'),
(1657, 'create', 'create', 'dynamic', 'en'),
(3314, 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics.', 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics.', 'dynamic', 'en'),
(3315, 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics.', 'Basic theme offers a sleek and modern design, prioritizing user-friendly navigation and aesthetics.', 'dynamic', 'en'),
(3316, 'stars', 'stars', 'dynamic', 'en'),
(3317, 'stars', 'stars', 'dynamic', 'en'),
(3318, 'home page', 'home page', 'dynamic', 'en'),
(3319, 'home page', 'home page', 'dynamic', 'en'),
(3320, 'footer', 'footer', 'dynamic', 'en'),
(3321, 'footer', 'footer', 'dynamic', 'en'),
(3322, 'extra codes', 'extra codes', 'dynamic', 'en'),
(3323, 'extra codes', 'extra codes', 'dynamic', 'en'),
(3324, 'Logo dark', 'Logo dark', 'dynamic', 'en'),
(3325, 'Logo dark', 'Logo dark', 'dynamic', 'en'),
(3326, 'Logo light', 'Logo light', 'dynamic', 'en'),
(3327, 'Logo light', 'Logo light', 'dynamic', 'en'),
(3328, 'Business Logo dark', 'Business Logo dark', 'dynamic', 'en'),
(3329, 'Business Logo dark', 'Business Logo dark', 'dynamic', 'en'),
(3330, 'Business Logo light', 'Business Logo light', 'dynamic', 'en'),
(3331, 'Business Logo light', 'Business Logo light', 'dynamic', 'en'),
(3332, 'Favicon', 'Favicon', 'dynamic', 'en'),
(3333, 'Favicon', 'Favicon', 'dynamic', 'en'),
(3334, 'Social Image', 'Social Image', 'dynamic', 'en'),
(3335, 'Social Image', 'Social Image', 'dynamic', 'en'),
(3336, 'theme settings', 'theme settings', 'dynamic', 'en'),
(3337, 'theme settings', 'theme settings', 'dynamic', 'en'),
(3338, 'Header Background', 'Header Background', 'dynamic', 'en'),
(3339, 'Header Background', 'Header Background', 'dynamic', 'en'),
(3340, 'X', 'X', 'dynamic', 'en'),
(3341, 'X', 'X', 'dynamic', 'en'),
(3342, 'Terms of use link', 'Terms of use link', 'dynamic', 'en'),
(3343, 'Terms of use link', 'Terms of use link', 'dynamic', 'en'),
(3344, 'Gdpr cookie policy link', 'Gdpr cookie policy link', 'dynamic', 'en'),
(3345, 'Gdpr cookie policy link', 'Gdpr cookie policy link', 'dynamic', 'en'),
(3346, 'Business terms link', 'Business terms link', 'dynamic', 'en'),
(3347, 'Business terms link', 'Business terms link', 'dynamic', 'en'),
(3348, 'Gdpr cookie', 'Gdpr cookie', 'dynamic', 'en'),
(3349, 'Gdpr cookie', 'Gdpr cookie', 'dynamic', 'en'),
(3350, 'Force ssl', 'Force ssl', 'dynamic', 'en'),
(3351, 'Force ssl', 'Force ssl', 'dynamic', 'en'),
(3352, 'Contact page', 'Contact page', 'dynamic', 'en'),
(3353, 'Contact page', 'Contact page', 'dynamic', 'en'),
(3354, 'Webhook Event', 'Webhook Event', 'dynamic', 'en'),
(3355, 'Webhook Endpoint', 'Webhook Endpoint', 'dynamic', 'en'),
(3356, 'access token', 'access token', 'dynamic', 'en'),
(3357, 'webhook secret signature', 'webhook secret signature', 'dynamic', 'en'),
(3358, 'api key', 'api key', 'dynamic', 'en'),
(3359, 'base url', 'base url', 'dynamic', 'en'),
(3360, 'Primary Color', 'Primary Color', 'dynamic', 'en'),
(3361, 'Secondary Color', 'Secondary Color', 'dynamic', 'en'),
(3362, 'Background Color', 'Background Color', 'dynamic', 'en'),
(3363, 'Border Color', 'Border Color', 'dynamic', 'en'),
(3364, 'Text Color', 'Text Color', 'dynamic', 'en'),
(3365, 'Text Muted Color', 'Text Muted Color', 'dynamic', 'en'),
(3366, 'Elements Background Color', 'Elements Background Color', 'dynamic', 'en'),
(3367, 'Inner Background Color', 'Inner Background Color', 'dynamic', 'en'),
(3368, 'Elements Inner Background Color', 'Elements Inner Background Color', 'dynamic', 'en'),
(3369, 'Inner border Color', 'Inner border Color', 'dynamic', 'en'),
(3370, 'Navbar Background Color', 'Navbar Background Color', 'dynamic', 'en'),
(3371, 'Business Button Color', 'Business Button Color', 'dynamic', 'en'),
(3372, 'Verified Badge Color', 'Verified Badge Color', 'dynamic', 'en'),
(3373, 'Star Color', 'Star Color', 'dynamic', 'en'),
(3374, 'Star Fill Color', 'Star Fill Color', 'dynamic', 'en'),
(3375, 'Footer Background Color', 'Footer Background Color', 'dynamic', 'en'),
(3376, 'Footer Heading Color', 'Footer Heading Color', 'dynamic', 'en'),
(3377, 'Footer Text Color', 'Footer Text Color', 'dynamic', 'en'),
(3378, 'Footer Border Color', 'Footer Border Color', 'dynamic', 'en'),
(3379, 'cronjob', 'cronjob', 'dynamic', 'en');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `microsoft_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vkontakte_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `two_factor_status` tinyint(1) NOT NULL DEFAULT '0',
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_reviews` bigint UNSIGNED NOT NULL DEFAULT '0',
  `kyc_status` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_logs`
--

CREATE TABLE `user_login_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `addons_alias_unique` (`alias`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_reset_tokens`
--
ALTER TABLE `admin_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_articles_slug_unique` (`slug`),
  ADD KEY `blog_articles_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_articles_lang_foreign` (`lang`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_categories_slug_unique` (`slug`),
  ADD KEY `blog_categories_lang_foreign` (`lang`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_comments_user_id_foreign` (`user_id`),
  ADD KEY `blog_comments_blog_article_id_foreign` (`blog_article_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `businesses_website_unique` (`website`),
  ADD UNIQUE KEY `businesses_domain_unique` (`domain`) USING BTREE,
  ADD KEY `businesses_business_owner_id_foreign` (`business_owner_id`),
  ADD KEY `businesses_category_id_foreign` (`category_id`);

--
-- Indexes for table `business_business_owner`
--
ALTER TABLE `business_business_owner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_business_owner_business_id_foreign` (`business_id`),
  ADD KEY `business_business_owner_business_owner_id_foreign` (`business_owner_id`);

--
-- Indexes for table `business_employees`
--
ALTER TABLE `business_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `business_employees_token_unique` (`token`),
  ADD KEY `business_employees_business_id_foreign` (`business_id`),
  ADD KEY `business_employees_business_owner_id_foreign` (`business_owner_id`);

--
-- Indexes for table `business_notifications`
--
ALTER TABLE `business_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_notifications_business_id_foreign` (`business_id`);

--
-- Indexes for table `business_owners`
--
ALTER TABLE `business_owners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `business_owners_username_unique` (`username`),
  ADD UNIQUE KEY `business_owners_email_unique` (`email`),
  ADD UNIQUE KEY `business_owners_facebook_id_unique` (`facebook_id`),
  ADD UNIQUE KEY `business_owners_google_id_unique` (`google_id`),
  ADD UNIQUE KEY `business_owners_microsoft_id_unique` (`microsoft_id`),
  ADD UNIQUE KEY `business_owners_vkontakte_id_unique` (`vkontakte_id`);

--
-- Indexes for table `business_owner_login_logs`
--
ALTER TABLE `business_owner_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_owner_login_logs_business_owner_id_foreign` (`business_owner_id`);

--
-- Indexes for table `business_owner_password_reset_tokens`
--
ALTER TABLE `business_owner_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `business_reviews`
--
ALTER TABLE `business_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_reviews_user_id_foreign` (`user_id`),
  ADD KEY `business_reviews_business_id_foreign` (`business_id`);

--
-- Indexes for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_review_replies_business_review_id_foreign` (`business_review_id`),
  ADD KEY `business_review_replies_business_owner_id_foreign` (`business_owner_id`),
  ADD KEY `business_review_replies_business_id_foreign` (`business_id`);

--
-- Indexes for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_review_reports_business_review_id_foreign` (`business_review_id`),
  ADD KEY `business_review_reports_user_id_foreign` (`user_id`),
  ADD KEY `business_review_reports_business_id_foreign` (`business_id`);

--
-- Indexes for table `business_sub_sub_category`
--
ALTER TABLE `business_sub_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_sub_sub_category_business_id_foreign` (`business_id`),
  ADD KEY `business_sub_sub_category_sub_sub_category_id_foreign` (`sub_sub_category_id`);

--
-- Indexes for table `business_views`
--
ALTER TABLE `business_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `business_views_business_id_foreign` (`business_id`);

--
-- Indexes for table `captcha_providers`
--
ALTER TABLE `captcha_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `editor_images`
--
ALTER TABLE `editor_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_lang_foreign` (`lang`);

--
-- Indexes for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_links_parent_id_foreign` (`parent_id`),
  ADD KEY `footer_links_lang_foreign` (`lang`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `home_sections_category_id_foreign` (`category_id`),
  ADD KEY `home_sections_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `home_sections_sub_sub_category_id_foreign` (`sub_sub_category_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kyc_verifications_business_owner_id_foreign` (`business_owner_id`),
  ADD KEY `kyc_verifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_templates_lang_foreign` (`lang`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navbar_links`
--
ALTER TABLE `navbar_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navbar_links_parent_id_foreign` (`parent_id`),
  ADD KEY `navbar_links_lang_foreign` (`lang`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`);

--
-- Indexes for table `oauth_providers`
--
ALTER TABLE `oauth_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_lang_foreign` (`lang`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_gateways_alias_unique` (`alias`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_business_owner_id_foreign` (`business_owner_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_sub_categories_sub_category_id_foreign` (`sub_category_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `themes_alias_unique` (`alias`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_business_owner_id_foreign` (`business_owner_id`),
  ADD KEY `transactions_plan_id_foreign` (`plan_id`),
  ADD KEY `transactions_payment_gateway_id_foreign` (`payment_gateway_id`);

--
-- Indexes for table `translates`
--
ALTER TABLE `translates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translates_lang_foreign` (`lang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_facebook_id_unique` (`facebook_id`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD UNIQUE KEY `users_microsoft_id_unique` (`microsoft_id`),
  ADD UNIQUE KEY `users_vkontakte_id_unique` (`vkontakte_id`);

--
-- Indexes for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_logs_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `blog_articles`
--
ALTER TABLE `blog_articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `business_business_owner`
--
ALTER TABLE `business_business_owner`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_employees`
--
ALTER TABLE `business_employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_notifications`
--
ALTER TABLE `business_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_owners`
--
ALTER TABLE `business_owners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_owner_login_logs`
--
ALTER TABLE `business_owner_login_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_reviews`
--
ALTER TABLE `business_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `business_sub_sub_category`
--
ALTER TABLE `business_sub_sub_category`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `business_views`
--
ALTER TABLE `business_views`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `captcha_providers`
--
ALTER TABLE `captcha_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `editor_images`
--
ALTER TABLE `editor_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `footer_links`
--
ALTER TABLE `footer_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `navbar_links`
--
ALTER TABLE `navbar_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_providers`
--
ALTER TABLE `oauth_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

--
-- AUTO_INCREMENT for table `translates`
--
ALTER TABLE `translates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5104;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD CONSTRAINT `blog_articles_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_articles_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD CONSTRAINT `blog_categories_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_blog_article_id_foreign` FOREIGN KEY (`blog_article_id`) REFERENCES `blog_articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `businesses`
--
ALTER TABLE `businesses`
  ADD CONSTRAINT `businesses_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `businesses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `business_business_owner`
--
ALTER TABLE `business_business_owner`
  ADD CONSTRAINT `business_business_owner_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_business_owner_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_employees`
--
ALTER TABLE `business_employees`
  ADD CONSTRAINT `business_employees_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_employees_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_notifications`
--
ALTER TABLE `business_notifications`
  ADD CONSTRAINT `business_notifications_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_owner_login_logs`
--
ALTER TABLE `business_owner_login_logs`
  ADD CONSTRAINT `business_owner_login_logs_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_reviews`
--
ALTER TABLE `business_reviews`
  ADD CONSTRAINT `business_reviews_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_review_replies`
--
ALTER TABLE `business_review_replies`
  ADD CONSTRAINT `business_review_replies_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_replies_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_replies_business_review_id_foreign` FOREIGN KEY (`business_review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_review_reports`
--
ALTER TABLE `business_review_reports`
  ADD CONSTRAINT `business_review_reports_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_reports_business_review_id_foreign` FOREIGN KEY (`business_review_id`) REFERENCES `business_reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_review_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_sub_sub_category`
--
ALTER TABLE `business_sub_sub_category`
  ADD CONSTRAINT `business_sub_sub_category_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `business_sub_sub_category_sub_sub_category_id_foreign` FOREIGN KEY (`sub_sub_category_id`) REFERENCES `sub_sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `business_views`
--
ALTER TABLE `business_views`
  ADD CONSTRAINT `business_views_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `footer_links`
--
ALTER TABLE `footer_links`
  ADD CONSTRAINT `footer_links_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE,
  ADD CONSTRAINT `footer_links_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `footer_links` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD CONSTRAINT `home_sections_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `home_sections_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `home_sections_sub_sub_category_id_foreign` FOREIGN KEY (`sub_sub_category_id`) REFERENCES `sub_sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kyc_verifications`
--
ALTER TABLE `kyc_verifications`
  ADD CONSTRAINT `kyc_verifications_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kyc_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD CONSTRAINT `mail_templates_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `navbar_links`
--
ALTER TABLE `navbar_links`
  ADD CONSTRAINT `navbar_links_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE,
  ADD CONSTRAINT `navbar_links_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `navbar_links` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_sub_categories`
--
ALTER TABLE `sub_sub_categories`
  ADD CONSTRAINT `sub_sub_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_business_owner_id_foreign` FOREIGN KEY (`business_owner_id`) REFERENCES `business_owners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `payment_gateways` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `translates`
--
ALTER TABLE `translates`
  ADD CONSTRAINT `translates_lang_foreign` FOREIGN KEY (`lang`) REFERENCES `languages` (`code`) ON DELETE CASCADE;

--
-- Constraints for table `user_login_logs`
--
ALTER TABLE `user_login_logs`
  ADD CONSTRAINT `user_login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
