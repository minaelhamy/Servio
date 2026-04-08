-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2026 at 01:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookingdo_addon`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_services`
--

CREATE TABLE `additional_services` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `age_verification`
--

CREATE TABLE `age_verification` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `age_verification_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `popup_type` varchar(255) DEFAULT NULL,
  `min_age` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `android_link` varchar(255) NOT NULL,
  `ios_link` varchar(255) NOT NULL,
  `mobile_app_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bank_account_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type_of_account` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1=category,2=service',
  `banner_title` varchar(255) DEFAULT NULL,
  `banner_subtitle` varchar(255) DEFAULT NULL,
  `link_text` varchar(255) DEFAULT NULL,
  `section` int(11) NOT NULL DEFAULT 1 COMMENT '1=banner1,2=banner2,3=banner3',
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_number` varchar(255) NOT NULL,
  `booking_number_digit` int(11) NOT NULL,
  `order_number_start` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `staff_id` varchar(255) DEFAULT NULL,
  `service_image` varchar(255) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` longtext DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` varchar(255) NOT NULL,
  `booking_endtime` varchar(255) NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `offer_amount` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `commission` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `tax_name` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) NOT NULL,
  `tips` varchar(255) DEFAULT '0',
  `additional_service_id` varchar(255) DEFAULT NULL,
  `additional_service_image` text DEFAULT NULL,
  `additional_service_name` varchar(255) DEFAULT NULL,
  `additional_service_price` varchar(255) DEFAULT NULL,
  `payment_status` int(11) NOT NULL COMMENT '1=Pending,2=for paid',
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL COMMENT '1=cod,\r\n2=Razor Pay,\r\n3=Stripe,\r\n4=Flutterwave,\r\n5=Paystack,\r\n7= Mercado Pago,\r\n8= PayPal,\r\n9= MyFatoorah,\r\n10=toyyibpay\r\n',
  `status` int(11) DEFAULT NULL COMMENT '1=Pending,2=Accept,3=Reject-byadmin,4=Reject-byuser,5=Complete',
  `status_type` int(11) DEFAULT NULL COMMENT '1=default,2=process,3=complete,4=cancel',
  `booking_notes` longtext DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `is_notification` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Unread , 2 = Read',
  `booking_type` varchar(255) DEFAULT NULL,
  `vendor_note` varchar(255) DEFAULT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `session_id` text DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `tax` varchar(255) DEFAULT NULL,
  `product_price` double NOT NULL,
  `buynow` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1--> yes, 2-->No',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1--> yes, 2-->No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `currency_symbol` text NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no\r\n',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`, `code`, `currency_symbol`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 'USD', 'usd', '$', 1, '2025-07-29 07:30:20', '2025-07-29 10:55:31');

-- --------------------------------------------------------

--
-- Table structure for table `currency_settings`
--

CREATE TABLE `currency_settings` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `exchange_rate` float NOT NULL,
  `currency_position` varchar(255) NOT NULL DEFAULT '1' COMMENT '1=left, 2=right',
  `currency_space` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `currency_formate` int(11) NOT NULL,
  `decimal_separator` int(11) NOT NULL DEFAULT 1 COMMENT '1=dot,2=no',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no	',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_settings`
--

INSERT INTO `currency_settings` (`id`, `code`, `name`, `currency`, `exchange_rate`, `currency_position`, `currency_space`, `currency_formate`, `decimal_separator`, `is_available`, `created_at`, `updated_at`) VALUES
(21, 'usd', 'USD', '$', 1, '1', 2, 2, 1, 1, '2025-07-28 12:01:44', '2025-07-31 05:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `customdomains`
--

CREATE TABLE `customdomains` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` varchar(255) NOT NULL,
  `requested_domain` varchar(255) NOT NULL,
  `current_domain` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=pending ,2=connected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_status`
--

CREATE TABLE `custom_status` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=default,2=process,3=complete,4=cancel',
  `status_use` int(11) NOT NULL COMMENT '1= Booking 2= Order',
  `is_available` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 2,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `custom_status`
--

INSERT INTO `custom_status` (`id`, `reorder_id`, `vendor_id`, `name`, `type`, `status_use`, `is_available`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Booked', 1, 1, 1, 2, '2025-12-11 08:09:34', '2025-12-11 08:09:34'),
(2, 2, 1, 'Processing', 2, 1, 1, 1, '2025-12-11 08:09:34', '2025-12-11 08:09:34'),
(3, 3, 1, 'In Progress', 2, 1, 1, 2, '2025-12-11 08:09:34', '2025-12-11 08:09:34'),
(4, 4, 1, 'Completed', 3, 1, 1, 2, '2025-12-11 08:09:34', '2025-12-11 08:09:34'),
(5, 5, 1, 'Cancelled', 4, 1, 1, 2, '2025-12-11 08:09:34', '2025-12-11 08:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `question` varchar(255) NOT NULL,
  `answer` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footerfeatures`
--

CREATE TABLE `footerfeatures` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fun_fact`
--

CREATE TABLE `fun_fact` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `howitworks`
--

CREATE TABLE `howitworks` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `landing_settings`
--

CREATE TABLE `landing_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `landing_home_banner` varchar(255) DEFAULT NULL,
  `subscribe_image` varchar(255) DEFAULT NULL,
  `faq_image` varchar(255) DEFAULT NULL,
  `primary_color` varchar(255) DEFAULT NULL,
  `secondary_color` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landing_settings`
--

INSERT INTO `landing_settings` (`id`, `vendor_id`, `landing_home_banner`, `subscribe_image`, `faq_image`, `primary_color`, `secondary_color`, `created_at`, `updated_at`) VALUES
(3, 1, 'banner-699437ab08e1a.jpeg', 'subscribe-699437ab09918.jpeg', 'faq-699437ab0a330.jpeg', '#000000', '#3595d5', '2025-11-13 05:19:38', '2026-02-17 09:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `layout` int(11) NOT NULL DEFAULT 1 COMMENT '1=ltr,2=rtl',
  `is_default` int(11) NOT NULL DEFAULT 2 COMMENT '1 = yes , 2 = no',
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=yes,2=no',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `image`, `layout`, `is_default`, `is_available`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'flag-65f136d1cb0b5.webp', 1, 2, 1, 2, '2022-12-13 05:15:46', '2025-07-22 15:10:23'),
(2, 'ar', 'Arabic', 'flag-65f136e6e0b19.png', 2, 2, 1, 2, '2023-03-25 01:47:13', '2025-07-23 15:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `media_use` int(11) NOT NULL COMMENT '1= Service 2= Product',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2022_09_28_105405_create_categories_table', 1),
(13, '2022_09_29_104135_create_services_table', 1),
(14, '2022_09_29_110444_create_service_images_table', 1),
(15, '2022_10_18_121106_create_banners_table', 2),
(16, '2022_10_22_051717_create_blogs_table', 3),
(17, '2022_11_07_073848_create_promocodes_table', 4),
(18, '2022_11_11_050805_create_bookings_table', 5),
(19, '2022_12_06_054503_create_contacts_table', 6),
(20, '2023_01_03_105722_create_customdomains_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `order_number_digit` int(11) DEFAULT NULL,
  `order_number_start` int(11) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `sub_total` double NOT NULL DEFAULT 0,
  `product_price` float DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `offer_amount` double DEFAULT 0,
  `tax_amount` varchar(255) DEFAULT '0',
  `tax_name` varchar(255) DEFAULT NULL,
  `shipping_area` varchar(255) DEFAULT NULL,
  `delivery_charge` double NOT NULL DEFAULT 0,
  `grand_total` double NOT NULL DEFAULT 0,
  `tips` varchar(255) NOT NULL DEFAULT '0',
  `transaction_id` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL DEFAULT '0',
  `payment_status` int(11) NOT NULL COMMENT '1=unpaid,2=paid',
  `status` int(11) NOT NULL,
  `status_type` int(11) NOT NULL COMMENT '1=default,2=process,3=complete,4=cancel	',
  `is_notification` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Unread , 2 = Read',
  `notes` longtext DEFAULT NULL,
  `vendor_note` varchar(255) NOT NULL,
  `screenshot` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` double NOT NULL,
  `product_tax` double DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_settings`
--

CREATE TABLE `other_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `trusted_badge_image_1` text DEFAULT NULL,
  `trusted_badge_image_2` text DEFAULT NULL,
  `trusted_badge_image_3` text DEFAULT NULL,
  `trusted_badge_image_4` text DEFAULT NULL,
  `safe_secure_checkout_payment_selection` varchar(255) DEFAULT NULL,
  `safe_secure_checkout_text` varchar(255) DEFAULT NULL,
  `safe_secure_checkout_text_color` varchar(255) DEFAULT NULL,
  `maintenance_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `maintenance_title` varchar(255) DEFAULT NULL,
  `maintenance_description` text DEFAULT NULL,
  `maintenance_image` text DEFAULT NULL,
  `notice_on_off` int(11) DEFAULT NULL,
  `notice_title` varchar(255) DEFAULT NULL,
  `notice_description` text DEFAULT NULL,
  `tips_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `other_settings`
--

INSERT INTO `other_settings` (`id`, `vendor_id`, `trusted_badge_image_1`, `trusted_badge_image_2`, `trusted_badge_image_3`, `trusted_badge_image_4`, `safe_secure_checkout_payment_selection`, `safe_secure_checkout_text`, `safe_secure_checkout_text_color`, `maintenance_on_off`, `maintenance_title`, `maintenance_description`, `maintenance_image`, `notice_on_off`, `notice_title`, `notice_description`, `tips_on_off`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 'We\'ll be back soon!!', 'Sorry for the inconvenience but we are performing some maintenance at the moment. we will be back online shortly!', 'maintenance_image-69156baf35264.png', 1, '🔔 Attention All Vendors – Scheduled Maintenance Notice', 'Dear Vendors,\r\n\r\nPlease be informed that scheduled maintenance will take place on the BookingDo SaaS Platform.\r\n\r\n🛠️ During this period, access to the vendor dashboard and other related services will be temporarily unavailable.\r\nWe are working to improve performance and ensure a better experience for you.\r\n\r\nWe sincerely apologize for any inconvenience this may cause and greatly appreciate your understanding and patience.\r\n\r\nThank you for being a valued part of the BookingDo community.\r\n\r\nBest regards,\r\nThe BookingDo Team', NULL, '2025-01-02 09:25:48', '2025-11-13 05:25:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `unique_identifier` varchar(255) DEFAULT NULL,
  `environment` int(11) NOT NULL DEFAULT 1 COMMENT '1=sandbox,2=production',
  `payment_name` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `public_key` text DEFAULT NULL,
  `secret_key` text DEFAULT NULL,
  `encryption_key` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_description` longtext DEFAULT NULL,
  `base_url_by_region` text DEFAULT NULL,
  `is_available` int(11) NOT NULL,
  `is_activate` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `vendor_id`, `reorder_id`, `unique_identifier`, `environment`, `payment_name`, `payment_type`, `image`, `currency`, `public_key`, `secret_key`, `encryption_key`, `payment_description`, `base_url_by_region`, `is_available`, `is_activate`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 0, 'COD', 1, 'cod.png', NULL, NULL, NULL, '', '', '', 1, 1, '2020-12-27 17:24:50', '2025-03-10 08:57:04'),
(2, 1, 0, 'razorpay', 1, 'RazorPay', 2, 'razorpay.png', 'USD', 'RAZORPAY_KEY_PLACEHOLDER', 'nys_ty_key', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(3, 1, 2, 'stripe', 1, 'Stripe', 3, 'stripe.png', 'USD', 'STRIPE_PUBLIC_KEY_PLACEHOLDER', 'STRIPE_SECRET_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(4, 1, 3, 'flutterwave', 1, 'Flutterwave', 4, 'flutterwave.png', 'NGN', 'FLUTTERWAVE_PUBLIC_KEY_PLACEHOLDER', 'FLUTTERWAVE_SECRET_KEY_PLACEHOLDER', 'FLUTTERWAVE_ENCRYPTION_KEY_PLACEHOLDER', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(5, 1, 4, 'paystack', 1, 'Paystack', 5, 'paystack.png', 'GHS', 'PAYSTACK_PUBLIC_KEY_PLACEHOLDER', 'PAYSTACK_SECRET_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(6, 1, 5, 'banktransfer', 1, 'BankTransfer', 6, 'banktransfer.png', NULL, NULL, NULL, '', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim. Sed tortor. Curabitur molestie. Duis velit augue,</p>', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(7, 1, 6, 'mercadopago', 1, 'MercadoPago', 7, 'mercadopago.png', 'R$', '', 'MERCADOPAGO_ACCESS_TOKEN_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(8, 1, 7, 'paypal', 1, 'PayPal', 8, 'paypal.png', 'USD', 'PAYPAL_CLIENT_ID_PLACEHOLDER', 'PAYPAL_CLIENT_SECRET_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(9, 1, 8, 'myfatoorah', 1, 'MyFatoorah', 9, 'myfatoorah.png', 'KWT', '', 'MYFATOORAH_API_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(10, 1, 9, 'toyyibpay', 1, 'toyyibpay', 10, 'toyyibpay.png', 'RM', 'TOYYIBPAY_CATEGORY_CODE_PLACEHOLDER', 'TOYYIBPAY_SECRET_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(11, 1, 10, 'paytab', 1, 'Paytab', 12, 'paytab.png', 'INR', 'PAYTABS_PROFILE_ID_PLACEHOLDER', 'PAYTABS_SERVER_KEY_PLACEHOLDER', '', '', 'https://secure-global.paytabs.com/payment/request', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(12, 1, 11, 'phonepe', 1, 'Phonepe', 11, 'phonepe.png', 'INR', 'PHONEPE_MERCHANT_ID_PLACEHOLDER', 'PHONEPE_SALT_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(13, 1, 12, 'mollie', 1, 'mollie', 13, 'mollie.png', 'EUR', '', 'MOLLIE_API_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(14, 1, 13, 'khalti', 1, 'khalti', 14, 'khalti.png', 'INR', '', 'KHALTI_SECRET_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(15, 1, 14, 'xendit', 1, 'xendit', 15, 'xendit.png', 'INR', 'XENDIT_API_KEY_PLACEHOLDER', 'XENDIT_API_KEY_PLACEHOLDER', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04'),
(16, 1, 15, NULL, 1, 'Wallet', 16, 'wallet.png', 'INR', '', '', '', '', '', 1, 1, '2020-12-27 17:15:15', '2025-03-10 08:57:04');

-- --------------------------------------------------------

--
-- Table structure for table `payout`
--

CREATE TABLE `payout` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `payable_amt` int(11) NOT NULL,
  `earning_amt` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pixcel_settings`
--

CREATE TABLE `pixcel_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `twitter_pixcel_id` varchar(255) DEFAULT NULL,
  `facebook_pixcel_id` varchar(255) DEFAULT NULL,
  `linkedin_pixcel_id` varchar(255) DEFAULT NULL,
  `google_tag_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` longtext DEFAULT NULL,
  `features` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` float NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `themes_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_type` int(11) NOT NULL COMMENT '1=fixed,2=custom',
  `duration` varchar(255) DEFAULT NULL COMMENT '1=1 month\r\n2=3 month\r\n3=6 month\r\n4=1 year\r\n5=lifetime\r\n\r\n\r\n\r\n',
  `days` int(11) DEFAULT NULL,
  `order_limit` int(11) NOT NULL,
  `product_order_limit` int(11) DEFAULT NULL,
  `appointment_limit` int(11) NOT NULL,
  `order_appointment_limit` int(11) DEFAULT NULL,
  `custom_domain` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `vendor_app` int(11) NOT NULL,
  `zoom` int(11) NOT NULL DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `calendar` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `google_analytics` int(11) DEFAULT NULL,
  `coupons` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `blogs` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `google_login` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `facebook_login` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `role_management` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `sound_notification` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `whatsapp_message` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `telegram_message` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `customer_app` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `pwa` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `employee` int(11) DEFAULT NULL,
  `vendor_calendar` int(11) DEFAULT NULL,
  `pixel` int(11) NOT NULL,
  `is_available` int(11) DEFAULT 1 COMMENT '1=Yes\r\n2=No\r\n',
  `vendor_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `original_price` float NOT NULL,
  `discount_percentage` float DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `stock_management` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `low_qty` int(11) DEFAULT NULL,
  `min_order` int(11) DEFAULT NULL,
  `max_order` int(11) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `is_imported` int(11) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= Yes,2= No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= Yes 2= No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `image` text NOT NULL,
  `is_imported` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `offer_name` varchar(255) NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `offer_type` int(11) NOT NULL COMMENT '1=fixed,2=percentage',
  `offer_amount` varchar(255) NOT NULL,
  `min_amount` int(11) NOT NULL,
  `usage_type` int(11) DEFAULT NULL COMMENT '1=Limited time\r\n,2=multiple times',
  `usage_limit` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `description` longtext NOT NULL,
  `is_available` int(11) DEFAULT 1 COMMENT '1=Yes\r\n2=No\r\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotionalbanner`
--

CREATE TABLE `promotionalbanner` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `question_answer`
--

CREATE TABLE `question_answer` (
  `id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `add` int(11) NOT NULL,
  `edit` int(11) NOT NULL,
  `delete` int(11) NOT NULL,
  `manage` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_manager`
--

CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `module` longtext NOT NULL,
  `is_available` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL COMMENT '1=yes,2=no',
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `staff_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `original_price` double DEFAULT 0,
  `discount_percentage` double NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `interval_time` int(11) NOT NULL DEFAULT 1,
  `interval_type` int(11) NOT NULL DEFAULT 2,
  `per_slot_limit` int(11) NOT NULL,
  `staff_assign` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `top_deals` int(11) NOT NULL DEFAULT 2 COMMENT '1= Yes 2= No',
  `is_available` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1="yes",2="no"',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1="yes",2="no"',
  `is_imported` int(11) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `additional_services` int(11) DEFAULT NULL COMMENT '1=yes,2=no\r\n\r\n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_images`
--

CREATE TABLE `service_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `is_imported` int(11) DEFAULT 2,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `service_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no\r\n\r\n',
  `shop_on_off` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `vendor_register` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT 'default-logo.png',
  `darklogo` text DEFAULT NULL,
  `favicon` varchar(255) NOT NULL DEFAULT 'default-favicon.png',
  `home_banner` varchar(255) NOT NULL,
  `homepage_title` varchar(255) NOT NULL,
  `homepage_subtitle` varchar(255) NOT NULL,
  `notification_sound` varchar(255) NOT NULL,
  `footer_description` longtext NOT NULL,
  `delivery_type` varchar(10) DEFAULT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Asia/Kolkata',
  `referral_amount` varchar(255) DEFAULT NULL,
  `min_order_amount` varchar(255) DEFAULT NULL,
  `wait_time` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `copyright` varchar(255) NOT NULL DEFAULT 'Copyright © 2021-2022',
  `web_title` varchar(255) NOT NULL DEFAULT 'admin',
  `primary_color` varchar(255) NOT NULL DEFAULT '#000',
  `secondary_color` varchar(255) NOT NULL,
  `landing_website_title` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `whatsapp_widget` longtext DEFAULT NULL,
  `terms_content` longtext DEFAULT NULL,
  `privacy_content` longtext DEFAULT NULL,
  `about_content` longtext DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(255) DEFAULT NULL,
  `custom_domain` text DEFAULT NULL,
  `cname_text` text DEFAULT NULL,
  `cname_title` text DEFAULT NULL,
  `checkout_login_required` int(11) DEFAULT 2 COMMENT '1 = Yes , 2 = No',
  `is_checkout_login_required` int(11) DEFAULT 2 COMMENT '1=yes,2=no',
  `time_format` tinyint(1) DEFAULT NULL COMMENT '1=12 hours,2=24 hours',
  `zoom_api_key` varchar(255) NOT NULL,
  `zoom_api_secret_key` varchar(255) NOT NULL,
  `zoom_email` varchar(255) NOT NULL,
  `theme` int(11) NOT NULL DEFAULT 1,
  `tracking_id` varchar(255) DEFAULT NULL,
  `view_id` varchar(255) DEFAULT NULL,
  `firebase` longtext DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL,
  `frame_color` varchar(255) DEFAULT NULL,
  `frame_secondarycolor` varchar(255) NOT NULL,
  `frame_height` varchar(255) DEFAULT NULL,
  `frame_width` varchar(255) DEFAULT NULL,
  `frame_logo` longtext DEFAULT NULL,
  `recaptcha_version` varchar(255) DEFAULT NULL,
  `google_recaptcha_site_key` varchar(255) DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `score_threshold` varchar(255) DEFAULT NULL,
  `cookie_text` text DEFAULT NULL,
  `cookie_button_text` text DEFAULT NULL,
  `app_title` varchar(255) DEFAULT NULL,
  `app_name` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL,
  `pwa` varchar(255) DEFAULT NULL,
  `app_logo` varchar(255) DEFAULT NULL,
  `google_client_id` varchar(255) DEFAULT '-',
  `google_client_secret` varchar(255) DEFAULT '-',
  `google_redirect_url` varchar(255) DEFAULT 'http://your-domain-url.com/checklogin/google/callback-google	',
  `facebook_client_id` varchar(255) DEFAULT '-',
  `facebook_client_secret` varchar(255) DEFAULT '-',
  `facebook_redirect_url` varchar(255) DEFAULT 'http://your-domain-url.com/checklogin/facebook/callback-facebook	',
  `mail_driver` varchar(255) DEFAULT NULL,
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT NULL,
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` text DEFAULT NULL,
  `mail_encryption` varchar(255) DEFAULT NULL,
  `mail_fromaddress` text DEFAULT NULL,
  `mail_fromname` text DEFAULT NULL,
  `landing_page` int(11) DEFAULT NULL,
  `refund_policy` longtext DEFAULT NULL,
  `why_choose_title` longtext DEFAULT NULL,
  `why_choose_subtitle` longtext DEFAULT NULL,
  `why_choose_image` longtext DEFAULT NULL,
  `contact_image` longtext DEFAULT NULL,
  `auth_image` longtext DEFAULT NULL,
  `admin_auth_image` text DEFAULT NULL,
  `default_language` varchar(255) DEFAULT 'en',
  `languages` varchar(255) DEFAULT 'en',
  `default_currency` text DEFAULT 'usd',
  `currencies` text DEFAULT 'usd',
  `product_ratting_switch` int(11) DEFAULT NULL,
  `online_order` int(11) DEFAULT NULL,
  `google_review` longtext DEFAULT NULL,
  `payment_process_options` int(11) NOT NULL,
  `google_mode` int(11) DEFAULT NULL,
  `facebook_mode` int(11) DEFAULT NULL,
  `order_prefix` longtext DEFAULT NULL,
  `order_number_start` int(11) DEFAULT NULL,
  `product_order_prefix` text DEFAULT NULL,
  `product_order_number_start` int(11) DEFAULT NULL,
  `image_size` float DEFAULT NULL,
  `date_format` longtext DEFAULT NULL,
  `order_success_image` longtext DEFAULT NULL,
  `no_data_image` longtext DEFAULT NULL,
  `store_unavailable_image` longtext DEFAULT NULL,
  `referral_image` text DEFAULT NULL,
  `wizz_chat_settings` text DEFAULT NULL,
  `wizz_chat_on_off` int(11) NOT NULL DEFAULT 1,
  `tawk_widget_id` text DEFAULT NULL,
  `tawk_on_off` int(11) DEFAULT 2,
  `quick_call` int(11) NOT NULL,
  `quick_call_mobile_view_on_off` int(11) DEFAULT NULL,
  `quick_call_name` text DEFAULT NULL,
  `quick_call_description` text DEFAULT NULL,
  `quick_call_mobile` text DEFAULT NULL,
  `quick_call_position` int(11) DEFAULT NULL,
  `quick_call_image` text DEFAULT NULL,
  `fake_sales_notification` int(11) DEFAULT NULL,
  `product_source` int(11) DEFAULT NULL,
  `next_time_popup` int(11) DEFAULT NULL,
  `notification_display_time` int(11) DEFAULT NULL,
  `sales_notification_position` int(11) DEFAULT NULL,
  `product_fake_view` int(11) DEFAULT NULL,
  `service_fake_view_message` text DEFAULT NULL,
  `product_fake_view_message` text DEFAULT NULL,
  `min_view_count` int(11) DEFAULT NULL,
  `max_view_count` int(11) DEFAULT NULL,
  `cart_checkout_countdown` int(11) DEFAULT NULL,
  `countdown_message` text DEFAULT NULL,
  `countdown_expired_message` text DEFAULT NULL,
  `countdown_mins` int(11) DEFAULT NULL,
  `min_order_amount_for_free_shipping` text DEFAULT NULL,
  `shipping_area` int(11) DEFAULT NULL,
  `shipping_charges` text DEFAULT NULL,
  `cart_checkout_progressbar` int(11) DEFAULT NULL,
  `progress_message` text DEFAULT NULL,
  `progress_message_end` text DEFAULT NULL,
  `forget_password_email_message` longtext DEFAULT NULL,
  `delete_account_email_message` longtext DEFAULT NULL,
  `banktransfer_request_email_message` longtext DEFAULT NULL,
  `cod_request_email_message` longtext DEFAULT NULL,
  `subscription_reject_email_message` longtext DEFAULT NULL,
  `subscription_success_email_message` longtext DEFAULT NULL,
  `admin_subscription_request_email_message` longtext DEFAULT NULL,
  `admin_subscription_success_email_message` longtext DEFAULT NULL,
  `vendor_register_email_message` longtext DEFAULT NULL,
  `admin_vendor_register_email_message` longtext DEFAULT NULL,
  `vendor_status_change_email_message` longtext DEFAULT NULL,
  `contact_email_message` longtext DEFAULT NULL,
  `new_order_invoice_email_message` longtext DEFAULT NULL,
  `vendor_new_order_email_message` longtext DEFAULT NULL,
  `order_status_email_message` longtext DEFAULT NULL,
  `new_product_order_invoice_email_message` text DEFAULT NULL,
  `vendor_new_product_order_email_message` text DEFAULT NULL,
  `product_order_status_email_message` text DEFAULT NULL,
  `referral_earning_email_message` longtext DEFAULT NULL,
  `payout_request_email_message` longtext DEFAULT NULL,
  `admin_payout_request_email_message` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `vendor_id`, `service_on_off`, `shop_on_off`, `vendor_register`, `logo`, `darklogo`, `favicon`, `home_banner`, `homepage_title`, `homepage_subtitle`, `notification_sound`, `footer_description`, `delivery_type`, `timezone`, `referral_amount`, `min_order_amount`, `wait_time`, `address`, `mobile`, `email`, `description`, `contact`, `copyright`, `web_title`, `primary_color`, `secondary_color`, `landing_website_title`, `meta_title`, `meta_description`, `og_image`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `whatsapp_widget`, `terms_content`, `privacy_content`, `about_content`, `client_id`, `client_secret`, `redirect_uri`, `custom_domain`, `cname_text`, `cname_title`, `checkout_login_required`, `is_checkout_login_required`, `time_format`, `zoom_api_key`, `zoom_api_secret_key`, `zoom_email`, `theme`, `tracking_id`, `view_id`, `firebase`, `cover_image`, `frame_color`, `frame_secondarycolor`, `frame_height`, `frame_width`, `frame_logo`, `recaptcha_version`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `score_threshold`, `cookie_text`, `cookie_button_text`, `app_title`, `app_name`, `background_color`, `theme_color`, `pwa`, `app_logo`, `google_client_id`, `google_client_secret`, `google_redirect_url`, `facebook_client_id`, `facebook_client_secret`, `facebook_redirect_url`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_encryption`, `mail_fromaddress`, `mail_fromname`, `landing_page`, `refund_policy`, `why_choose_title`, `why_choose_subtitle`, `why_choose_image`, `contact_image`, `auth_image`, `admin_auth_image`, `default_language`, `languages`, `default_currency`, `currencies`, `product_ratting_switch`, `online_order`, `google_review`, `payment_process_options`, `google_mode`, `facebook_mode`, `order_prefix`, `order_number_start`, `product_order_prefix`, `product_order_number_start`, `image_size`, `date_format`, `order_success_image`, `no_data_image`, `store_unavailable_image`, `referral_image`, `wizz_chat_settings`, `wizz_chat_on_off`, `tawk_widget_id`, `tawk_on_off`, `quick_call`, `quick_call_mobile_view_on_off`, `quick_call_name`, `quick_call_description`, `quick_call_mobile`, `quick_call_position`, `quick_call_image`, `fake_sales_notification`, `product_source`, `next_time_popup`, `notification_display_time`, `sales_notification_position`, `product_fake_view`, `service_fake_view_message`, `product_fake_view_message`, `min_view_count`, `max_view_count`, `cart_checkout_countdown`, `countdown_message`, `countdown_expired_message`, `countdown_mins`, `min_order_amount_for_free_shipping`, `shipping_area`, `shipping_charges`, `cart_checkout_progressbar`, `progress_message`, `progress_message_end`, `forget_password_email_message`, `delete_account_email_message`, `banktransfer_request_email_message`, `cod_request_email_message`, `subscription_reject_email_message`, `subscription_success_email_message`, `admin_subscription_request_email_message`, `admin_subscription_success_email_message`, `vendor_register_email_message`, `admin_vendor_register_email_message`, `vendor_status_change_email_message`, `contact_email_message`, `new_order_invoice_email_message`, `vendor_new_order_email_message`, `order_status_email_message`, `new_product_order_invoice_email_message`, `vendor_new_product_order_email_message`, `product_order_status_email_message`, `referral_earning_email_message`, `payout_request_email_message`, `admin_payout_request_email_message`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 2, 'logo-65f439ec3a723.png', 'darklogo-699eef60155e4.png', 'favicon-65d5c8f373130.png', 'homebanner.png\r\n', '', '', '', '', NULL, 'Asia/Kolkata', NULL, NULL, NULL, '248 Cedar Swamp Rd, Jackson, New Mexico - 08527', '', 'paponapp2244@gmail.com', NULL, '+919016996697', 'Copyright © Papon IT Solutions. All Rights Reserved', 'BookingDo SaaS | Multi Business SaaS Appointment, Service Booking Website Builder', '#000000', '#3595d5', NULL, 'BookingDo SaaS - Multi Business SaaS Appointment, Service Booking Website Builder', 'Booking Do is a complete SaaS based multi business service booking software, that gives your users the ability to create and manage bookings, services, customers, etc. Users also can create their own business page, receive online payments from customers and easily keep track of their online business in one platform.', 'og_image-691177a94d63b.png', 'https://www.facebook.com/', 'https://twitter.com/', 'https://www.instagram.com/', 'https://www.linkedin.com/', NULL, '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'GOOGLE_CLIENT_ID_PLACEHOLDER', 'GOOGLE_CLIENT_SECRET_PLACEHOLDER', 'https://bookingdo.paponapps.co.in/admin/bookings/event', '-', 'If you are using cPanel or Plesk then you need to manually add custom domain in your server with the same root directory as the script installation and user need to point their custom domain A record with your server IP. Example : 68.178.145.4', 'Read All Instructions Carefully Before Sending Custom Domain Request', 2, 2, 2, '', '', '', 1, NULL, NULL, 'AAAAlio1OzI:APA91bG85HXcf1TKLW_T8CqOh2HwYPTb58yxLyv93v9e1tRvEojTNFi9Um-sFQHzTZ_O6w6gjy1KNwhKF72hW0wvaHElwJGTrsVKELGAGc_Ff0r1arQBMZwwX9gNXz-mKMMZVigUUl86', '', '', '', NULL, NULL, NULL, 'v2', '6LdffhIrAAAAAEacsaK1wtVu7e8XsVvMvjErnt9E', '6LdffhIrAAAAABCO3w_DRlT0OdzpbC48O6vytJSL', '0.9', 'Your experience on this site will be improved by allowing cookies.', 'Accept', NULL, NULL, NULL, NULL, NULL, NULL, 'GOOGLE_CLIENT_ID_PLACEHOLDER', 'GOOGLE_CLIENT_SECRET_PLACEHOLDER', 'https://bookingdo.paponapps.co.in/checklogin/google/callback-google', '5824705190970928', '62e852fbb48ce4c9c5e7d605f8a436fa', 'https://bookingdo.paponapps.co.in/checklogin/facebook/callback-facebook', 'smtp', 'smtp.gmail.com', '587', 'testgravity777@gmail.com', 'bjktjgxjeeakfsxf', 'tls', 'hello@example.com', 'papon', 1, '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', NULL, NULL, NULL, NULL, NULL, 'auth-699437ab0ab5c.jpeg', 'en', 'en', 'usd', '', NULL, NULL, NULL, 3, 1, 1, NULL, NULL, NULL, NULL, 2, 'd M, Y', NULL, NULL, 'store_unavailable-699437ab0c59c.jpeg', NULL, '<script id=\"chat-init\" src=\"https://app.wizzchat.com/account/js/init.js?id=6505747\"></script>', 1, '<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/65e6e6f89131ed19d9752711/1ho6vcf4t\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->', 1, 1, 2, 'Papon IT Solution', 'Hey there 👋 Need help? I\'m here for you, so just give me a call.', '+919016996697', 2, 'quick-call-67ee254923d7d.png', 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Dear {user},\r\n\r\nYour Temporary Password Is : {password}', 'Dear {vendorname},\r\n\r\nWe hope this message finds you well. We regret to inform you that your account has been deleted', 'Dear {vendorname},\r\n\r\nWe hope this email finds you well. We are writing to confirm that we have received your recent subscription request and payment via bank transfer. We appreciate your business and thank you for choosing our services.\r\n\r\nWe are currently processing your subscription request and will be in touch with you shortly. Depending on the nature of the subscription, you may receive further instructions, access to a service, or confirmation of your subscription.\r\n\r\nIf you have any questions or concerns, please do not hesitate to reach out to us. Our customer support team is available to assist you with any inquiries you may have.\r\n\r\nThank you again for choosing our services. We look forward to providing you with the best possible experience.\r\n\r\nSincerely\r\n{adminname}\r\n{adminemail}', 'Dear {vendorname},\r\n\r\nWe hope this email finds you well. We are writing to confirm that we have received your recent subscription request and payment via COD. We appreciate your business and thank you for choosing our services.\r\n\r\nWe are currently processing your subscription request and will be in touch with you shortly. Depending on the nature of the subscription, you may receive further instructions, access to a service, or confirmation of your subscription.\r\n\r\nIf you have any questions or concerns, please do not hesitate to reach out to us. Our customer support team is available to assist you with any inquiries you may have.\r\n\r\nThank you again for choosing our services. We look forward to providing you with the best possible experience.\r\n\r\nSincerely\r\n{adminname}\r\n{adminemail}', 'Dear {vendorname},\r\n\r\nI am writing to inform you that your recent {payment_type} request has been rejected. After careful review of your account and the transaction, we have identified a some issues.\r\n\r\nHere are the details of your purchase\r\n\r\nSubscription Plans : {plan_name}\r\nPayment Type : {payment_type}\r\n\r\nYou can take benefits of our online payment system\r\n\r\nIf you have any questions or concerns regarding your subscription, please do not hesitate to contact our customer support team. We are always available to assist you with any queries you may have.\r\n\r\nSincerely\r\n{adminname}\r\n{adminemail}', 'Dear {vendorname},\r\n\r\nI hope this email finds you well. I am writing to confirm your recent subscription purchase with our company.\r\n\r\nWe are thrilled to have you as a subscriber and we appreciate your trust in us. Your subscription will provide you access to our premium services, exclusive content and special offers throughout the duration of your subscription period.\r\n\r\nHere are the details of your purchase\r\n\r\nSubscription Plans :  {plan_name}\r\nSubscription Duration : {subscription_duration}\r\nSubscription Cost : {subscription_price}\r\nPayment Type : {payment_type}\r\n\r\nYour subscription is now active and you can start enjoying the benefits of our services right away. You can log in to your account using the email address and password you provided during registration.\r\n\r\nIf you have any questions or concerns regarding your subscription, please do not hesitate to contact our customer support team. We are always available to assist you with any queries you may have.\r\n\r\nThank you once again for choosing us as your preferred service provider. We look forward to providing you with the best experience possible.\r\n\r\nSincerely\r\n{adminname}\r\n{adminemail}', 'Dear {adminname},\r\n\r\nYou have received new subscription request from {vendorname} and the email is {vendoremail}\r\n\r\nLogin to your account and check the details. You may Approve OR Reject\r\n\r\nHere are the details\r\n\r\nSubscription Plans : {plan_name}\r\n\r\nSubscription Duration : {subscription_duration}\r\n\r\nSubscription Cost : {subscription_price}\r\n\r\nPayment Type : {payment_type}', 'Dear {adminname},\r\n\r\nI am writing to inform you that a new subscription has been purchased for our service. The details of the subscription are as follows:\r\n\r\nName of Subscriber : {vendorname}\r\nSubscription Plans : {plan_name}\r\nSubscription Duration : {subscription_duration}\r\nSubscription Cost : {subscription_price}\r\nPayment Type : {payment_type}\r\n\r\nThe payment for the subscription has been successfully processed, and the subscriber is now able to access the features of their subscription.\r\n\r\nBest Regards\r\n{vendorname}\r\n{vendoremail}', 'Dear {vendorname},\r\n\r\nThank you for choosing to join our vibrant community! We\'re thrilled to have you on board and want to extend a warm welcome to you.', 'Dear {adminname},\r\n\r\nI am writing to inform you that new vendor registration has been done successfully.\r\n\r\nName : {vendorname}\r\nEmail : {vendoremail}\r\nMobile : {vendormobile}', 'Dear {vendorname},\r\n\r\nWe hope this message finds you well. We regret to inform you that your account has been suspended', 'Dear {vendorname},\n\nYou have received new inquiry\n\nFull Name : {username}\n\nEmail : {useremail}\n\nMobile : {usermobile}\n\nMessage : {usermessage}', 'Dear {customername},\n\nWe are pleased to confirm that we have received your Booking.\n\nBooking Details\n\nBooking number : #{booking_number}\nBooking Date : {booking_date}\nBooking Time : {booking_starttime} - {booking_endtime}\nGrand Total : {grandtotal}\n\nClick Here : {track_booking_url}\n\nThank you for choosing {vendorname}.\n\nSincerely,\n{vendorname}', 'Dear {vendorname},\n\nWe are writing to confirm that you have received new Booking.\n\nBooking Details\n\nBooking number : #{booking_number}\nBooking Date : {booking_date}\nBooking Time : {booking_starttime} - {booking_endtime}\nGrand Total : {grandtotal}\n\nSincerely,\n{customername}', 'Dear {customername},\n\nI am writing to inform you that {status_message}\n\nSincerely\n{vendorname}', 'Dear {customername},\n\nWe are pleased to confirm that we have received your Order.\n\nOrder details\n\nOrder number : #{order_number}\nOrder Date : {order_date}\nGrand Total : {grandtotal}\n\nClick Here : {track_order_url}\n\nThank you for choosing.\n\nSincerely,\n{vendorname}', 'Dear {vendorname},\n\nWe are writing to confirm that you have received new Order.\n\nOrder details\n\nOrder number : #{order_number}\nOrder Date : {order_date}\nGrand Total : {grandtotal}\n\nSincerely,\n{customername}', 'Dear {customername},\n\nI am writing to inform you that {status_message}\n\nSincerely\n{vendorname}', 'Dear {referral_user},\n\nYour friend {new_user} has used your referral code to register with {company_name}.\nYou have earned {referral_amount} referral amount in your wallet.\n\nNote : Do not reply to this notification message,this message was auto-generated by the sender\'s security system.\n\nAll Rights Reserved.', 'Dear {vendorname},\n\nHere are the details of your payout request\n\nEarning Amount without Tax :  {earning_amt}\nAdmin commission : {commission}\nPayout amount : {payable_amt}\n\nSincerely\n{adminname}\n{adminemail}', 'Dear {vendorname},\n\nHere are the details of your payout request\n\nEarning Amount without Tax :  {earning_amt}\nAdmin commission : {commission}\nPayout amount : {payable_amt}\n\nSincerely\n{adminname}\n{adminemail}', '2022-12-02 10:09:25', '2026-02-25 12:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_area`
--

CREATE TABLE `shipping_area` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `area_name` varchar(255) NOT NULL,
  `delivery_charge` double NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1 = yes, 2 = no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `icon` text NOT NULL,
  `link` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_category`
--

CREATE TABLE `store_category` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_settings`
--

CREATE TABLE `subscription_settings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemaddons`
--

CREATE TABLE `systemaddons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unique_identifier` varchar(255) NOT NULL,
  `version` varchar(20) NOT NULL,
  `activated` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `systemaddons`
--

INSERT INTO `systemaddons` (`id`, `name`, `unique_identifier`, `version`, `activated`, `image`, `type`, `created_at`, `updated_at`) VALUES
(9, 'Blogs', 'blog', '4.3', 1, 'blog.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(11, 'Coupons', 'coupon', '4.3', 1, 'coupons.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(14, 'Language Translation', 'language', '4.3', 1, 'language.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(16, 'Sound Notification', 'notification', '4.3', 1, 'notification.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(17, 'Services Theme', 'theme_1', '4.3', 1, 'theme_1.jpg', 1, '2025-04-10 00:57:19', '2024-07-26 23:17:36'),
(18, 'Personalised Business Link', 'unique_slug', '4.3', 1, 'unique_slug.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(19, 'Whatsapp Message (Manual)', 'whatsapp_message', '4.3', 1, 'whatsapp_message.jpg', 1, '2025-04-10 00:57:19', '2025-01-02 00:54:49'),
(21, 'Subscription Plans', 'subscription', '4.3', 1, 'subscription.jpg', 1, '2025-04-10 00:57:19', '2025-03-31 07:32:50'),
(49, 'Cookie Consent', 'cookie', '4.3', 1, 'cookie.jpg', 1, '2025-04-10 00:57:19', '2024-05-17 00:57:19'),
(58, 'Store Reviews', 'store_reviews', '4.3', 1, 'store_reviews.jpg', 1, '2025-04-10 00:57:19', '2025-01-06 06:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` int(11) NOT NULL,
  `tax` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_available` int(11) NOT NULL DEFAULT 1 COMMENT '1=Yes,2=No',
  `is_deleted` int(11) NOT NULL DEFAULT 2 COMMENT '1=Yes,2=No',
  `tax_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telegram_message`
--

CREATE TABLE `telegram_message` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `item_message` longtext NOT NULL,
  `telegram_message` longtext NOT NULL,
  `order_telegram_message` longtext NOT NULL,
  `order_created` int(11) NOT NULL,
  `product_order_created` int(11) NOT NULL,
  `telegram_access_token` text NOT NULL,
  `telegram_chat_id` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telegram_message`
--

INSERT INTO `telegram_message` (`id`, `vendor_id`, `item_message`, `telegram_message`, `order_telegram_message`, `order_created`, `product_order_created`, `telegram_access_token`, `telegram_chat_id`, `created_at`, `updated_at`) VALUES
(1, 1, '🔵 {item_name} ({item_price} * {qty}) = {total}', 'Hi, \r\nI would like to create booking for {service_name} 👇\r\n---------------------------\r\nBooking Id : {booking_no}\r\n👉 Payment status : {payment_status}\r\n💳 Payment type : {payment_type}\r\n---------------------------\r\n👉 Subtotal : {sub_total}\r\n{total_tax}\r\n👉 Discount ({offer_code}) : - {discount_amount}\r\n---------------------------\r\n📃 Total : {grand_total}\r\n---------------------------\r\n📄 Comment : {message}\r\n✅ Customer Info\r\n---------------------------\r\nCustomer name : {customer_name}\r\nCustomer phone : {customer_mobile}\r\nCustomer email: {customer_email}\r\n---------------------------\r\n📍 Customer address : {address} , {city} , {state} , {country} , {landmark} , {postal_code}.\r\n---------------------------\r\n🗓️ Booking date: {booking_date}\r\n⏱️ Booking time: {start_time}-{end_time}\r\n---------------------------\r\nTrack your booking 👇\r\n{track_booking_url}\r\n\r\nClick here for next booking 👇\r\n{website_url}\r\n\r\nThanks for the booking 🥳', 'Hi, \r\nI would like to place an order 👇\r\n\r\nOrder No: {order_no}\r\n---------------------------\r\n{item_variable}\r\n---------------------------\r\n👉Subtotal : {sub_total}\r\n{total_tax}\r\n👉Delivery charge : {delivery_charge}\r\n👉Discount ({offer_code}) : - {discount_amount}\r\n---------------------------\r\n📃 Total : {grand_total}\r\n---------------------------\r\n📄 Comment : {notes}\r\n✅ Customer Info\r\n---------------------------\r\nCustomer name : {customer_name}\r\nCustomer email: {customer_email}\r\nCustomer phone : {customer_mobile}\r\n---------------------------\r\n📍 Billing Details\r\nAddress : {address}, {landmark}, {postal_code}, {city}, {state}, {country}.\r\n---------------------------\r\n👉 Payment status : {payment_status}\r\n💳 Payment type : {payment_type}\r\n\r\n{store_name} will confirm your order upon receiving the message.\r\n\r\nTrack your order 👇\r\n{track_order_url}\r\n\r\nClick here for next order 👇\r\n{website_url}\r\n\r\nThanks for the Order 🥳', 1, 1, '5500991005:AAE_2nAxls6jkJmVjKoun_IjZd3N6b-NJX0', '756897635', '2025-03-28 06:35:07', '2025-03-28 12:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `star` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `reorder_id`, `vendor_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'All Type Service', 'theme-65af3477c1ef7.webp', '2024-01-23 09:07:27', '2024-11-24 00:55:36'),
(2, 3, 1, 'Events & Entertainment', 'theme-65af3486cf17e.webp', '2024-01-23 09:07:42', '2024-11-24 00:55:36'),
(3, 5, 1, 'Medical & Health', 'theme-65af34964f08a.webp', '2024-01-23 09:07:58', '2024-11-24 00:55:36'),
(4, 6, 1, 'Public & Professional', 'theme-65d5a42f13689.webp', '2024-02-08 13:02:47', '2024-11-24 00:55:36'),
(5, 7, 1, 'Sports & Fitness', 'theme-65d5a4454aa16.webp', '2024-02-21 12:50:37', '2024-11-24 00:55:36'),
(6, 2, 1, 'Spa & Wellness', 'theme-6641e5190bc8d.webp', '2024-05-13 15:32:01', '2024-11-24 00:55:36'),
(7, 8, 1, 'Auto Service', 'theme-6641e52e232e6.webp', '2024-05-13 15:32:22', '2024-10-15 04:35:14'),
(8, 1, 1, 'Pet Care', 'theme-6641e5425aae4.webp', '2024-05-13 15:32:42', '2024-11-24 00:55:36'),
(9, 9, 1, 'Online Caching', 'theme-6641e55c8b17a.webp', '2024-05-13 15:33:08', '2024-06-11 21:01:21'),
(10, 10, 1, 'Barber', 'theme-6641e56ac5a73.webp', '2024-05-13 15:33:22', '2024-06-11 21:01:21'),
(11, 0, 1, 'Dental Service', 'theme-67a45d4e5e386.webp', '2025-02-06 12:27:18', '2025-02-06 12:27:18'),
(12, 0, 1, 'Tailoring Services', 'theme-67a45d6549eeb.webp', '2025-02-06 12:27:41', '2025-02-06 12:27:41'),
(13, 0, 1, 'Wedding Planner', 'theme-67a45d768fc4c.webp', '2025-02-06 12:27:58', '2025-02-06 12:27:58'),
(14, 0, 1, 'Yoga Service', 'theme-67a45d8349be6.webp', '2025-02-06 12:28:11', '2025-02-06 12:28:11'),
(15, 0, 1, 'Home Renovation', 'theme-67a45d910ad4c.webp', '2025-02-06 12:28:25', '2025-02-06 12:28:25'),
(16, 0, 1, 'Taxi Service', 'theme-69118e65445cc.webp', '2025-10-02 15:39:55', '2025-11-10 12:34:05'),
(17, 0, 1, 'Hotel Service', 'theme-69118e7271eba.webp', '2025-10-02 15:40:08', '2025-11-10 12:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `timings`
--

CREATE TABLE `timings` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `day` varchar(50) NOT NULL,
  `open_time` varchar(30) NOT NULL,
  `close_time` varchar(30) NOT NULL,
  `break_start` varchar(255) NOT NULL,
  `break_end` varchar(255) NOT NULL,
  `is_always_close` tinyint(1) NOT NULL COMMENT '1 For Yes, 2 For No',
  `service_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `top_deals`
--

CREATE TABLE `top_deals` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `offer_type` int(11) NOT NULL,
  `deal_type` int(11) NOT NULL COMMENT '1=one time,2=daily',
  `top_deals_switch` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `offer_amount` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `product_type` int(11) DEFAULT NULL COMMENT '1= Booking 2= Order',
  `transaction_type` int(11) DEFAULT NULL COMMENT '1 = added-money-wallet, 2 = order placed (using wallet), 3 = order cancel 4 = referral -earning',
  `transaction_number` varchar(255) DEFAULT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `payment_type` varchar(255) NOT NULL COMMENT '1: cod,\r\n2: RazorPay,\r\n3:Stripe,\r\n4:Flutterwave, \r\n5:Paystack,\r\n7 :Mercado Pago,\r\n8: PayPal, \r\n9: MyFatoorah,\r\n10: toyyibpay ',
  `payment_id` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `grand_total` float NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `offer_amount` float NOT NULL,
  `offer_code` varchar(255) NOT NULL,
  `duration` varchar(255) DEFAULT NULL COMMENT '1=1 Month,\r\n2=3Month\r\n3=6 Month\r\n4=1 Year\r\n5=lifetime\r\n',
  `days` int(11) DEFAULT NULL,
  `purchase_date` varchar(255) NOT NULL,
  `service_limit` varchar(255) NOT NULL,
  `product_limit` varchar(255) DEFAULT NULL,
  `themes_id` varchar(255) NOT NULL,
  `appoinment_limit` varchar(255) NOT NULL,
  `order_appointment_limit` varchar(255) DEFAULT NULL,
  `expire_date` varchar(255) NOT NULL,
  `screenshot` varchar(255) DEFAULT NULL,
  `custom_domain` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `zoom` int(11) NOT NULL DEFAULT 2,
  `calendar` int(11) NOT NULL DEFAULT 2 COMMENT '1=yes,2=no',
  `google_analytics` int(11) NOT NULL DEFAULT 2,
  `status` int(11) NOT NULL COMMENT '1 = pending, 2 = yes/BankTransferAccepted,3=no/BankTransferDeclined',
  `coupons` int(11) DEFAULT NULL,
  `blogs` int(11) DEFAULT NULL,
  `google_login` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `facebook_login` int(11) DEFAULT NULL COMMENT '1=yes,2=no',
  `sound_notification` int(11) DEFAULT NULL,
  `whatsapp_message` int(11) DEFAULT NULL,
  `telegram_message` int(11) DEFAULT NULL,
  `customer_app` int(11) DEFAULT NULL,
  `vendor_app` int(11) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `pwa` int(11) DEFAULT NULL,
  `vendor_calendar` int(11) DEFAULT NULL,
  `pixel` int(11) DEFAULT NULL,
  `tax_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `login_type` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Admin,2=vendor,3=user,4=staff/employee',
  `description` text DEFAULT NULL,
  `token` longtext DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `plan_id` varchar(255) DEFAULT NULL,
  `purchase_amount` varchar(255) DEFAULT NULL,
  `purchase_date` varchar(255) DEFAULT NULL,
  `payment_type` int(11) DEFAULT NULL COMMENT '1=COD,2=Wallet,3=Razorpay,4=stripe,5=Flutterwave,6=paystack',
  `referral_code` varchar(255) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT '0',
  `commission` varchar(255) NOT NULL DEFAULT '0',
  `commission_on_off` int(11) DEFAULT NULL,
  `commission_type` int(11) DEFAULT NULL,
  `commission_amount` varchar(255) DEFAULT NULL,
  `min_amount_for_payout` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `available_on_landing` int(11) DEFAULT NULL COMMENT '1=Yes,2=No',
  `allow_without_subscription` int(11) DEFAULT NULL COMMENT '1=Yes,2=No',
  `is_verified` tinyint(1) NOT NULL COMMENT '1=Yes,2=No',
  `is_available` tinyint(4) NOT NULL COMMENT '1=Yes,2=No	',
  `is_deleted` int(11) DEFAULT 2,
  `remember_token` varchar(100) DEFAULT NULL,
  `license_type` text DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `custom_domain` text DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `role_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reorder_id`, `store_id`, `name`, `slug`, `email`, `mobile`, `image`, `password`, `login_type`, `google_id`, `facebook_id`, `type`, `description`, `token`, `country_id`, `city_id`, `payment_id`, `plan_id`, `purchase_amount`, `purchase_date`, `payment_type`, `referral_code`, `wallet`, `commission`, `commission_on_off`, `commission_type`, `commission_amount`, `min_amount_for_payout`, `otp`, `available_on_landing`, `allow_without_subscription`, `is_verified`, `is_available`, `is_deleted`, `remember_token`, `license_type`, `vendor_id`, `custom_domain`, `role_id`, `role_type`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Admin', '', 'admin@gmail.com', '+1234567890', 'profile-699eef3cb471c.png', '$2y$10$r//xNJf/Mg7qkiXYT7HLeudUM1.IMTS54LKl5D0BsYi28Uvr52ON6', 'normal', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '0', 1, 2, '2', '50', NULL, 0, 0, 1, 1, 2, '2JUQ2rbnRS0qOUHZBNc1KOua1OfmilbEyI2SaTUhwBNzAKadUl00goViBhYD', NULL, 0, NULL, 0, NULL, '2022-09-03 12:54:32', '2026-02-25 12:46:52');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp_message`
--

CREATE TABLE `whatsapp_message` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `item_message` longtext NOT NULL,
  `whatsapp_message` longtext NOT NULL,
  `status_message` longtext NOT NULL,
  `order_whatsapp_message` longtext DEFAULT NULL,
  `order_status_message` longtext DEFAULT NULL,
  `whatsapp_number` varchar(255) NOT NULL,
  `whatsapp_phone_number_id` varchar(255) NOT NULL,
  `whatsapp_access_token` longtext NOT NULL,
  `whatsapp_chat_on_off` int(11) NOT NULL,
  `whatsapp_mobile_view_on_off` int(11) NOT NULL,
  `whatsapp_chat_position` int(11) NOT NULL DEFAULT 1 COMMENT '1=left, 2=right',
  `order_created` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `status_change` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `product_order_created` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `order_status_change` int(11) NOT NULL COMMENT '1 = Yes , 2 = No',
  `message_type` int(11) NOT NULL COMMENT '1 = automatic_using_api , 2 = manually	',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `whatsapp_message`
--

INSERT INTO `whatsapp_message` (`id`, `vendor_id`, `item_message`, `whatsapp_message`, `status_message`, `order_whatsapp_message`, `order_status_message`, `whatsapp_number`, `whatsapp_phone_number_id`, `whatsapp_access_token`, `whatsapp_chat_on_off`, `whatsapp_mobile_view_on_off`, `whatsapp_chat_position`, `order_created`, `status_change`, `product_order_created`, `order_status_change`, `message_type`, `created_at`, `updated_at`) VALUES
(1, 1, '🔵 {item_name} ({item_price} * {qty}) = {total}', 'Hi, \r\nI would like to create booking for {service_name} 👇\r\n---------------------------\r\nBooking Id : {booking_no}\r\n👉 Payment status : {payment_status}\r\n💳 Payment type : {payment_type}\r\n---------------------------\r\n👉 Subtotal : {sub_total}\r\n{total_tax}\r\n👉 Discount ({offer_code}) : - {discount_amount}\r\n---------------------------\r\n📃 Total : {grand_total}\r\n---------------------------\r\n📄 Comment : {message}\r\n✅ Customer Info\r\n---------------------------\r\nCustomer name : {customer_name}\r\nCustomer phone : {customer_mobile}\r\nCustomer email: {customer_email}\r\n---------------------------\r\n📍 Customer address : {address} , {city} , {state} , {country} , {landmark} , {postal_code}.\r\n---------------------------\r\n🗓️ Booking date: {booking_date}\r\n⏱️ Booking time: {start_time}-{end_time}\r\n---------------------------\r\nTrack your booking 👇\r\n{track_booking_url}\r\n\r\nClick here for next booking 👇\r\n{website_url}\r\n\r\nThanks for the booking 🥳', '🛍️ Booking Status Update 📦\r\n\r\nHello {customer_name},\r\n\r\nWe\'re excited to share the latest status of your booking with us. Here are the details:\r\n\r\n📝 Booking Number: #{booking_no}\r\n\r\n📦 **Booking Status**: {status}\r\n\r\n📌 **Tracking Information**:\r\n   - You can track your booking with the tracking number: #{booking_no}.\r\n   - Tracking Link: {track_booking_url}\r\n\r\nIf you have any questions or need assistance, feel free to reply to this message.\r\n\r\nWe appreciate your business and hope you enjoy your purchase.\r\n\r\nBest regards', 'Hi, \r\nI would like to place an order 👇\r\n\r\nOrder No: {order_no}\r\n---------------------------\r\n{item_variable}\r\n---------------------------\r\n👉Subtotal : {sub_total}\r\n{total_tax}\r\n👉Delivery charge : {delivery_charge}\r\n👉Discount ({offer_code}) : - {discount_amount}\r\n---------------------------\r\n📃 Total : {grand_total}\r\n---------------------------\r\n📄 Comment : {notes}\r\n✅ Customer Info\r\n---------------------------\r\nCustomer name : {customer_name}\r\nCustomer email: {customer_email}\r\nCustomer phone : {customer_mobile}\r\n---------------------------\r\n📍 Billing Details\r\nAddress : {address}, {landmark}, {postal_code}, {city}, {state}, {country}.\r\n---------------------------\r\n👉 Payment status : {payment_status}\r\n💳 Payment type : {payment_type}\r\n\r\n{store_name} will confirm your order upon receiving the message.\r\n\r\nTrack your order 👇\r\n{track_order_url}\r\n\r\nClick here for next order 👇\r\n{website_url}\r\n\r\nThanks for the Order 🥳', '🛍️ Order Status Update 📦\r\n\r\nHello {customer_name},\r\n\r\nWe\'re excited to share the latest status of your order with us. Here are the details:\r\n\r\n📝 Order Number: #{order_no}\r\n\r\n📦 **Order Status**: {status}\r\n\r\n📌 **Tracking Information**:\r\n   - You can track your order with the tracking number: #{order_no}.\r\n   - Tracking Link: {track_order_url}\r\n\r\nIf you have any questions or need assistance, feel free to reply to this message.\r\n\r\nWe appreciate your business and hope you enjoy your purchase.\r\n\r\nBest regards', '', '109087992245712', 'WHATSAPP_ACCESS_TOKEN_PLACEHOLDER', 1, 1, 2, 1, 1, 1, 1, 2, '2025-05-30 11:49:38', '2025-05-30 11:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `whychooseus`
--

CREATE TABLE `whychooseus` (
  `id` int(11) NOT NULL,
  `reorder_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_services`
--
ALTER TABLE `additional_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `age_verification`
--
ALTER TABLE `age_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_settings`
--
ALTER TABLE `currency_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customdomains`
--
ALTER TABLE `customdomains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_status`
--
ALTER TABLE `custom_status`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footerfeatures`
--
ALTER TABLE `footerfeatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fun_fact`
--
ALTER TABLE `fun_fact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `howitworks`
--
ALTER TABLE `howitworks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_settings`
--
ALTER TABLE `landing_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_settings`
--
ALTER TABLE `other_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payout`
--
ALTER TABLE `payout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pixcel_settings`
--
ALTER TABLE `pixcel_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotionalbanner`
--
ALTER TABLE `promotionalbanner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_answer`
--
ALTER TABLE `question_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_manager`
--
ALTER TABLE `role_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_images`
--
ALTER TABLE `service_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_area`
--
ALTER TABLE `shipping_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_category`
--
ALTER TABLE `store_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_settings`
--
ALTER TABLE `subscription_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systemaddons`
--
ALTER TABLE `systemaddons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telegram_message`
--
ALTER TABLE `telegram_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timings`
--
ALTER TABLE `timings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_deals`
--
ALTER TABLE `top_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp_message`
--
ALTER TABLE `whatsapp_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whychooseus`
--
ALTER TABLE `whychooseus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_services`
--
ALTER TABLE `additional_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `age_verification`
--
ALTER TABLE `age_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `currency_settings`
--
ALTER TABLE `currency_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `customdomains`
--
ALTER TABLE `customdomains`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `custom_status`
--
ALTER TABLE `custom_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `footerfeatures`
--
ALTER TABLE `footerfeatures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `fun_fact`
--
ALTER TABLE `fun_fact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `howitworks`
--
ALTER TABLE `howitworks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `landing_settings`
--
ALTER TABLE `landing_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `other_settings`
--
ALTER TABLE `other_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT for table `payout`
--
ALTER TABLE `payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pixcel_settings`
--
ALTER TABLE `pixcel_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `promotionalbanner`
--
ALTER TABLE `promotionalbanner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `question_answer`
--
ALTER TABLE `question_answer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=462;

--
-- AUTO_INCREMENT for table `role_manager`
--
ALTER TABLE `role_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `service_images`
--
ALTER TABLE `service_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=717;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `shipping_area`
--
ALTER TABLE `shipping_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `store_category`
--
ALTER TABLE `store_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_settings`
--
ALTER TABLE `subscription_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `systemaddons`
--
ALTER TABLE `systemaddons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `telegram_message`
--
ALTER TABLE `telegram_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `timings`
--
ALTER TABLE `timings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2045;

--
-- AUTO_INCREMENT for table `top_deals`
--
ALTER TABLE `top_deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `whatsapp_message`
--
ALTER TABLE `whatsapp_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `whychooseus`
--
ALTER TABLE `whychooseus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
