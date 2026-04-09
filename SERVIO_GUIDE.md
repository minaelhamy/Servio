# Servio Guide

## What Servio is

Servio is a Laravel-based multi-tenant marketplace and storefront builder for service businesses. Conceptually, it is closer to "Shopify for services" than a single booking website.

The platform supports:

- a central platform site and landing page
- admin control of plans, vendors, themes, settings, and content
- vendor storefronts where merchants sell services through bookings
- customer accounts, booking history, favorites, wallet flows, and reviews
- optional e-commerce style features such as products, media, banners, and promotional content
- API endpoints for mobile apps or external frontends

In production, the intended public topology is:

- platform: `https://servio.hatchers.ai`
- tenant storefronts: `https://{store}.servio.hatchers.ai`
- optional fallback path routing: `https://servio.hatchers.ai/{store}`
- optional custom domains later

## Current project status

This codebase has already been prepared for launch in a simplified production mode:

- the installer flow was removed
- license gating was removed
- the app now boots directly from `.env`
- storefront routing was adjusted to work on the platform host, wildcard subdomains, and future custom domains
- deployment was adapted for Namecheap shared hosting

This means Servio is now intended to be run like a normal Laravel application with a real `.env`, a real database import, and normal Composer-based deployment.

## Core business model

Servio has three main user layers:

### 1. Platform admin

The platform admin manages the SaaS itself:

- vendor accounts
- subscription plans
- taxes, payment methods, settings
- landing page and marketing content
- themes and platform-wide assets
- store categories, location data, reports, transactions

Admin routes live under `/admin`.

### 2. Vendor or merchant

A vendor creates and manages a store. A vendor can:

- configure store identity and branding
- choose themes
- manage services
- manage categories
- manage bookings and orders
- upload media
- configure social links and store settings
- subscribe to plans

### 3. Customer

A customer visits a vendor storefront and can:

- browse services
- book appointments
- manage favorites
- view bookings and orders
- log in and manage profile data
- use coupons, wallet, and checkout flows where enabled

## Application architecture

## Technology stack

Servio is built on:

- PHP 8.1+
- Laravel 10
- Blade views
- Eloquent ORM
- Laravel middleware and route groups
- Laravel Sanctum for API auth context
- multiple payment and add-on integrations

Main dependency signals from [`composer.json`](/Users/minaelhamy/Downloads/Servio/composer.json):

- `laravel/framework`
- `laravel/sanctum`
- `laravel/socialite`
- `maatwebsite/excel`
- `barryvdh/laravel-dompdf`
- `intervention/image`
- payment SDKs such as Stripe, Mollie, MyFatoorah, PayPal, Xendit

## High-level code layout

### Application code

[`app`](/Users/minaelhamy/Downloads/Servio/app) contains the Laravel application logic:

- [`app/Http/Controllers`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers): web and API controllers
- [`app/Http/Middleware`](/Users/minaelhamy/Downloads/Servio/app/Http/Middleware): request guards and tenant resolution behavior
- [`app/Models`](/Users/minaelhamy/Downloads/Servio/app/Models): Eloquent models for vendors, services, bookings, plans, settings, media, etc.
- [`app/helper/helper.php`](/Users/minaelhamy/Downloads/Servio/app/helper/helper.php): a large utility layer used across routing, tenant resolution, settings lookup, image URLs, payments, email helpers, and formatting
- [`app/helper/whatsapp_helper.php`](/Users/minaelhamy/Downloads/Servio/app/helper/whatsapp_helper.php): WhatsApp-specific helper logic

### Views

[`resources/views`](/Users/minaelhamy/Downloads/Servio/resources/views) is split into:

- [`resources/views/admin`](/Users/minaelhamy/Downloads/Servio/resources/views/admin): admin and vendor dashboard UI
- [`resources/views/front`](/Users/minaelhamy/Downloads/Servio/resources/views/front): tenant storefront UI
- [`resources/views/landing`](/Users/minaelhamy/Downloads/Servio/resources/views/landing): platform marketing site
- [`resources/views/email`](/Users/minaelhamy/Downloads/Servio/resources/views/email): outgoing transactional emails
- [`resources/views/errors`](/Users/minaelhamy/Downloads/Servio/resources/views/errors): error and maintenance pages

There are many storefront themes, for example:

- [`resources/views/front/theme-1`](/Users/minaelhamy/Downloads/Servio/resources/views/front/theme-1)
- [`resources/views/front/theme-17`](/Users/minaelhamy/Downloads/Servio/resources/views/front/theme-17)

### Routes

The route system is split across many files.

Primary web routes:

- [`routes/web.php`](/Users/minaelhamy/Downloads/Servio/routes/web.php)

Primary API routes:

- [`routes/api.php`](/Users/minaelhamy/Downloads/Servio/routes/api.php)

Additional feature-specific route files are registered from:

- [`app/Providers/RouteServiceProvider.php`](/Users/minaelhamy/Downloads/Servio/app/Providers/RouteServiceProvider.php)

This modular route registration is important because features like reviews, custom domains, payment gateways, PWA, analytics, customers, and social login are wired in through separate route files rather than one huge monolith.

## Architectural layers

## 1. Platform layer

The platform layer is the Servio SaaS itself.

Responsibilities:

- showing the public landing page
- handling admin authentication
- managing vendors and subscription plans
- controlling platform-level content and settings

Important routes:

- `/`
- `/admin`
- `/admin/dashboard`

The platform landing page is controlled in [`routes/web.php`](/Users/minaelhamy/Downloads/Servio/routes/web.php) under a domain group for the platform host.

## 2. Tenant storefront layer

Tenant storefronts represent vendor shops.

Responsibilities:

- service listings
- service detail pages
- booking flows
- customer auth and profile pages
- gallery, FAQ, contact, legal pages
- payment return flows

This layer is registered through:

- [`App\helper\helper::registerStorefrontRoutes()`](/Users/minaelhamy/Downloads/Servio/app/helper/helper.php)

That helper now builds three route entry modes:

- platform host plus path prefix: `servio.hatchers.ai/{vendor}`
- subdomain host: `{store_subdomain}.servio.hatchers.ai`
- custom domain host: `{custom_domain}`

## 3. API layer

The API exists for vendor and customer use cases and can support mobile apps or external frontends.

Examples from [`routes/api.php`](/Users/minaelhamy/Downloads/Servio/routes/api.php):

- vendor registration and login
- customer registration and login
- service listing and detail
- booking creation
- booking history
- CMS and contact endpoints
- payment request endpoints

This means the product is not only a Blade web app. It also exposes a practical JSON API surface for future app integrations.

## Tenancy and storefront resolution

This is one of the most important parts of Servio.

## Platform host detection

Platform host resolution is centered in [`app/helper/helper.php`](/Users/minaelhamy/Downloads/Servio/app/helper/helper.php) through methods such as:

- `platformHost()`
- `currentHost()`
- `isPlatformHost()`
- `isPlatformSubdomainRequest()`
- `isCustomDomainRequest()`
- `tenantSubdomain()`

The primary production host is driven by:

- `APP_URL`
- `WEBSITE_HOST`

In production we use:

- `APP_URL=https://servio.hatchers.ai`
- `WEBSITE_HOST=servio.hatchers.ai`

## Current store resolution

The currently active store is resolved via:

- `currentStoreUser()`
- `storeinfo()`

The code determines the active store by checking:

- the route vendor slug on platform path routes
- the tenant subdomain
- a connected custom domain record

This is why a single Laravel app can serve both:

- the central platform
- many different merchant storefronts

## Storefront URL generation

Storefront URLs are normalized through helper methods:

- `storefront_base_url()`
- `storefront_url()`
- `storefront_request_is()`

These helpers are important because they prevent broken links when a store is served on:

- a path URL
- a subdomain
- a future custom domain

When `STORE_SUBDOMAIN_ROUTING=true`, tenant links prefer the subdomain style.

## Middleware architecture

Middleware is defined in [`app/Http/Kernel.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Kernel.php).

Important custom middleware:

- `AuthMiddleware`
- `VendorMiddleware`
- `adminmiddleware`
- `frontmiddleware`
- `usermiddleware`
- `landingMiddleware`

### `frontmiddleware`

[`app/Http/Middleware/frontmiddleware.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Middleware/frontmiddleware.php)

Purpose:

- resolves the current vendor for storefront requests
- aborts with `404` when no vendor is found
- sets vendor timezone and language
- blocks maintenance or deleted vendor storefronts
- checks vendor plan status

This middleware is the main gatekeeper for tenant storefront requests.

### `usermiddleware`

[`app/Http/Middleware/usermiddleware.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Middleware/usermiddleware.php)

Purpose:

- ensures customer-only pages are accessed by authenticated users of the correct type
- keeps tenant context during customer profile actions
- redirects unauthenticated users back to the right storefront URL

### `landingMiddleware`

This middleware protects platform landing-page behavior and keeps the public marketing site separate from storefront logic.

## Domain and routing model

Servio currently supports three storefront routing styles.

## 1. Platform host with vendor path

Example:

- `https://servio.hatchers.ai/dental-studio`

Useful for:

- fallback routing
- environments where wildcard subdomains are not yet configured

## 2. Wildcard tenant subdomains

Example:

- `https://dental-studio.servio.hatchers.ai`

Useful for:

- cleaner merchant URLs
- SaaS-like storefront identity

Requirements:

- wildcard DNS
- wildcard subdomain in cPanel
- wildcard SSL

## 3. Custom domains

Example:

- `https://www.vendorbrand.com`

This is partially supported by the architecture. The helper layer already includes:

- custom-domain request detection
- custom-domain record lookup
- entitlement checks tied to plan or transaction state

Operationally, this is harder on shared hosting because each merchant domain needs DNS and SSL handling.

## Main product modules

From the route, controller, and model structure, the product is organized around the following modules.

## Vendor and plan management

Main pieces:

- vendor registration
- vendor status control
- vendor login-as capability for platform admin
- subscription plans
- transaction history
- plan purchase flows

Relevant controllers:

- [`AdminController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/AdminController.php)
- [`UserController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/UserController.php)
- [`PlanPricingController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/PlanPricingController.php)
- [`TransactionController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/TransactionController.php)

## Service catalog and booking

This is the heart of Servio.

Relevant models:

- [`Service`](/Users/minaelhamy/Downloads/Servio/app/Models/Service.php)
- [`Booking`](/Users/minaelhamy/Downloads/Servio/app/Models/Booking.php)
- [`AdditionalService`](/Users/minaelhamy/Downloads/Servio/app/Models/AdditionalService.php)
- [`Timing`](/Users/minaelhamy/Downloads/Servio/app/Models/Timing.php)

Relevant controllers:

- [`app/Http/Controllers/admin/ServiceController.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/ServiceController.php)
- [`app/Http/Controllers/front/ServiceController.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/front/ServiceController.php)
- [`app/Http/Controllers/front/BookingController.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/front/BookingController.php)
- [`app/Http/Controllers/admin/BookingsController.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/BookingsController.php)

Capabilities include:

- service CRUD
- additional services
- service images
- working hours
- booking slot logic
- booking creation and status changes
- booking success and payment callbacks

## Product and order modules

Although Servio is service-first, it also contains product and order modules.

Relevant models:

- [`Product`](/Users/minaelhamy/Downloads/Servio/app/Models/Product.php)
- [`Order`](/Users/minaelhamy/Downloads/Servio/app/Models/Order.php)
- [`OrderDetails`](/Users/minaelhamy/Downloads/Servio/app/Models/OrderDetails.php)

This means the platform can support hybrid merchants who sell services and products together.

## Content and marketing modules

Servio includes a large admin-managed content layer:

- blogs
- FAQs
- why choose us
- features
- gallery
- banners
- landing page sections
- legal pages
- footer content

Relevant controllers include:

- [`WebsiteSettingsController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/WebsiteSettingsController.php)
- [`BannerController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/BannerController.php)
- [`FeaturesController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/FeaturesController.php)
- [`GalleryController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/GalleryController.php)
- [`HowItWorkController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/HowItWorkController.php)
- [`WhyChooseUsController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/WhyChooseUsController.php)

## Theme system

Themes are both code and content.

Code side:

- many Blade theme directories in [`resources/views/front`](/Users/minaelhamy/Downloads/Servio/resources/views/front)

Data side:

- [`Theme`](/Users/minaelhamy/Downloads/Servio/app/Models/Theme.php)
- [`ThemeController`](/Users/minaelhamy/Downloads/Servio/app/Http/Controllers/admin/ThemeController.php)

Bundled theme images live in:

- [`storage/app/public/admin-assets/images/theme`](/Users/minaelhamy/Downloads/Servio/storage/app/public/admin-assets/images/theme)

## Payments and add-ons

Servio has a wide add-on pattern visible in both dependencies and route registration.

Examples:

- PayPal
- Stripe
- MyFatoorah
- Mollie
- PayTabs
- MercadoPago
- ToyyibPay
- Xendit
- PhonePe
- Khalti
- Zoom integration
- Social login
- WhatsApp messaging
- Telegram messaging
- reviews
- analytics
- PWA

Many of these are wired through separate route files loaded by [`RouteServiceProvider`](/Users/minaelhamy/Downloads/Servio/app/Providers/RouteServiceProvider.php).

## Data model overview

This is a database-heavy application. The real production schema is not defined solely by migrations.

Important models include:

- `User`
- `Settings`
- `OtherSettings`
- `PricingPlan`
- `Transaction`
- `Service`
- `Booking`
- `Category`
- `StoreCategory`
- `Theme`
- `Banner`
- `Gallery`
- `Features`
- `Testimonials`
- `Blog`
- `Payment`
- `Tax`
- `Customdomain`

## Important note about the database

Servio ships with a bundled SQL dump:

- [`storage/app/public/bookingdo_saas.sql`](/Users/minaelhamy/Downloads/Servio/storage/app/public/bookingdo_saas.sql)

For this project, that SQL dump is the authoritative starting point for first-time setup. Do not assume `php artisan migrate` fully reproduces the production schema.

Recommended initial database process:

1. create the MySQL database in cPanel
2. import `bookingdo_saas.sql` using phpMyAdmin
3. update `.env`
4. only run migrations very carefully if you confirm they are compatible with the imported schema

## Asset architecture

Servio uses a mixed asset model.

## Bundled application assets

These ship with the codebase and must be deployed:

- CSS and JS under `storage/app/public/admin-assets`
- built-in images such as theme thumbnails, login artwork, icons, and shared UI images

## User-uploaded assets

These are changed from the admin panel and should survive deployments:

- logos
- favicons
- OG images
- banners
- gallery images
- blog images
- category images
- service and product images
- screenshots
- contact/auth/store graphics

That is why the current cPanel deploy excludes only specific upload directories rather than excluding the entire `admin-assets/images` folder.

## How Servio uses image paths

A lot of templates build URLs from:

- `ASSETPATHURL`

In production this should be:

- `ASSETPATHURL=storage/app/public/`

If this is missing, pages often render as plain HTML or with broken images because CSS, JS, and media links point to the wrong place.

## Environment configuration

The deployment template is:

- [`.env.namecheap.example`](/Users/minaelhamy/Downloads/Servio/.env.namecheap.example)

Important production variables:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://servio.hatchers.ai`
- `WEBSITE_HOST=servio.hatchers.ai`
- `STORE_SUBDOMAIN_ROUTING=true`
- `ASSETPATHURL=storage/app/public/`
- `DB_*`
- `MAIL_*`

Also required:

- a valid `APP_KEY`

Generate it with:

```bash
php artisan key:generate
```

## How we deployed Servio

## Hosting model

Servio was prepared for Namecheap shared hosting with cPanel Git deployment.

Target paths:

- repo checkout: `/home/hatchwan/repo/servio.hatchers.ai`
- live app: `/home/hatchwan/servio.hatchers.ai`
- served app: `/home/hatchwan/servio.hatchers.ai/public`

## Deployment flow

Deployment is driven by:

- [`.cpanel.yml`](/Users/minaelhamy/Downloads/Servio/.cpanel.yml)

What it does:

1. creates the live directory if needed
2. recreates Laravel runtime directories
3. syncs repository contents into the live path with `rsync --delete`
4. preserves selected upload folders so admin-managed assets are not wiped
5. installs Composer dependencies on the live server
6. resets permissions on `storage` and `bootstrap/cache`
7. clears Laravel caches

## Why the deploy file matters

Two lessons were critical during deployment:

### 1. `vendor/` cannot be assumed

Shared-host Git deployment does not automatically provide Composer dependencies. We updated deployment to run Composer automatically on the live app.

### 2. asset preservation must be selective

If you exclude too much, the app loses bundled UI images and theme thumbnails.

If you exclude too little, `rsync --delete` wipes logos and uploaded media.

The current deploy file balances this by excluding only mutable upload directories.

## Namecheap and cPanel setup

For production, we configured or assumed:

### Base subdomain

- create `servio.hatchers.ai`
- point it to `/home/hatchwan/servio.hatchers.ai/public`

### Wildcard tenant subdomains

- create wildcard DNS: `*.servio.hatchers.ai`
- create wildcard subdomain in cPanel pointing to the same app
- install wildcard SSL

### Database

- create MySQL database and user in cPanel
- import `bookingdo_saas.sql`

### Environment

- create `.env`
- set DB credentials, host settings, mail settings, and `APP_KEY`

## First-time live setup steps

After the code is on the server:

```bash
cd /home/hatchwan/servio.hatchers.ai
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

Then test:

- `https://servio.hatchers.ai`
- `https://servio.hatchers.ai/admin`

## How to use Servio

## Platform admin usage

Typical platform admin workflow:

1. go to `https://servio.hatchers.ai/admin`
2. log in as platform admin
3. configure plans, payment methods, taxes, store categories, and content
4. manage vendor accounts
5. review transactions and reports
6. adjust landing page and platform branding

Typical admin sections are visible in routes under the `/admin` prefix:

- dashboard
- plans
- users
- features
- themes
- store categories
- landing page content
- settings
- transactions

## Vendor usage

Typical vendor workflow:

1. register or be created by the platform
2. log into the admin/vendor dashboard
3. configure branding, social links, and business settings
4. create service categories
5. create services
6. upload service images and other media
7. set working hours and booking constraints
8. publish the store
9. manage bookings and customer interactions

Relevant vendor-facing admin modules include:

- services
- categories
- media
- gallery
- bookings
- orders
- reports
- basic settings
- banner and homepage sections

## Customer usage

Typical customer workflow:

1. open a vendor storefront
2. browse services
3. view service detail and available slots
4. sign in or register if needed
5. complete booking and payment flow
6. receive confirmation and follow-up messages
7. manage bookings from profile pages

Storefront routes support:

- home
- categories
- services
- service detail
- booking detail
- customer auth
- profile
- wallet
- wishlist
- FAQ, gallery, legal pages

## API usage

The API can be used by external clients or future mobile apps.

Example areas in [`routes/api.php`](/Users/minaelhamy/Downloads/Servio/routes/api.php):

- vendor auth
- customer auth
- service listing
- service detail
- booking creation
- booking history
- payment initiation
- CMS content

Before using the API in production, verify:

- auth expectations
- payload shape
- payment callback assumptions
- vendor context requirements

## Operational guidance

## After each deploy

Check:

- platform homepage
- admin login
- one vendor storefront
- service detail page
- booking flow
- uploaded logos and media still exist

Run if needed:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## Common issues

### Plain HTML or missing CSS/JS

Usually means one of these:

- `ASSETPATHURL` missing or wrong
- bundled assets not deployed
- asset path is 404ing

### 500 error with encryption key

Cause:

- missing `APP_KEY`

Fix:

```bash
php artisan key:generate
php artisan config:clear
```

### `vendor/autoload.php` missing

Cause:

- Composer was not run on the live server

Fix:

```bash
composer install --no-dev --optimize-autoloader
```

### Storefront 404 on subdomain

Possible causes:

- wildcard DNS missing
- wildcard cPanel subdomain missing
- SSL missing
- `WEBSITE_HOST` wrong
- vendor slug does not match the subdomain

## Current limitations and cautions

- This codebase is highly helper-driven and route-file-driven, so behavior is spread across many places rather than isolated in a few service classes.
- The SQL dump is operationally important and should be treated carefully.
- Some asset folders mix bundled files and uploads, so deployment exclusions must stay selective.
- Custom domains are architecturally supported but operationally more complex on shared hosting.
- The app contains many add-on route files and gateway integrations, so every new feature change should be tested in the context of both platform and tenant routing.

## Recommended next documentation work

This document is a strong system overview, but the next useful internal docs would be:

- a database schema map of the most important tables
- a vendor lifecycle document
- a payment gateway matrix showing which flows are currently active
- an asset storage map listing exactly which admin settings write to which folders
- a custom-domain operations guide for when that feature is enabled

## File references for further reading

- [`app/helper/helper.php`](/Users/minaelhamy/Downloads/Servio/app/helper/helper.php)
- [`app/Http/Kernel.php`](/Users/minaelhamy/Downloads/Servio/app/Http/Kernel.php)
- [`app/Providers/RouteServiceProvider.php`](/Users/minaelhamy/Downloads/Servio/app/Providers/RouteServiceProvider.php)
- [`routes/web.php`](/Users/minaelhamy/Downloads/Servio/routes/web.php)
- [`routes/api.php`](/Users/minaelhamy/Downloads/Servio/routes/api.php)
- [`DEPLOYMENT.md`](/Users/minaelhamy/Downloads/Servio/DEPLOYMENT.md)
- [`.cpanel.yml`](/Users/minaelhamy/Downloads/Servio/.cpanel.yml)
- [`.env.namecheap.example`](/Users/minaelhamy/Downloads/Servio/.env.namecheap.example)
- [`storage/app/public/bookingdo_saas.sql`](/Users/minaelhamy/Downloads/Servio/storage/app/public/bookingdo_saas.sql)
