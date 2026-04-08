# Servio Deployment

## Target hosts

- Platform app: `https://servio.hatchers.ai`
- Tenant subdomains: `https://{store}.servio.hatchers.ai`
- Repo checkout on Namecheap: `/home/hatchwan/repo/servio.hatchers.ai`
- Live app path: `/home/hatchwan/servio.hatchers.ai`
- Document root: `/home/hatchwan/servio.hatchers.ai/public`

## Shared-hosting notes

- The storefront router now supports:
  - platform path routes on `servio.hatchers.ai/{vendor}`
  - tenant subdomains on `{vendor}.servio.hatchers.ai`
  - custom domains when a connected domain is active and the merchant is entitled
- Wildcard tenant subdomains require:
  - wildcard DNS record for `*.servio.hatchers.ai`
  - wildcard subdomain in cPanel pointed at the same Laravel app
  - wildcard SSL covering `*.servio.hatchers.ai`
- Namecheap shared hosting can serve tenant subdomains this way, but custom domains later will require per-domain DNS pointing at the shared server plus SSL issuance per custom domain.

## Database

- This project includes a bundled schema dump at `storage/app/public/bookingdo_saas.sql`.
- Import that SQL dump with phpMyAdmin for the initial setup.
- Do not assume `php artisan migrate` is the full schema unless you verify it against the dump.

## First deploy steps

1. Create the `servio.hatchers.ai` subdomain in cPanel and point it to `/home/hatchwan/servio.hatchers.ai/public`.
2. Create the repo checkout directory and connect the Git repository in cPanel.
3. Copy `.env.namecheap.example` to `.env` on the live app and fill in the real secrets.
4. Import `storage/app/public/bookingdo_saas.sql` into the production database.
5. Run:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

## Git deploy behavior

- `.cpanel.yml` syncs the checked-out repo into `/home/hatchwan/servio.hatchers.ai`.
- Upload folders are excluded from `rsync --delete` so logos, favicons, banners, and item images are not wiped on redeploy.
- Laravel runtime folders are recreated on every deploy before cache clears run.

## DNS and SSL

- Create:
  - `servio.hatchers.ai`
  - `*.servio.hatchers.ai`
- Install SSL for the base subdomain and a wildcard certificate for tenant storefronts.
- For future custom domains:
  - point the custom domain to the shared server
  - connect it inside Servio admin
  - install SSL for that domain before sending traffic

## Post-deploy checklist

- `https://servio.hatchers.ai`
- `https://servio.hatchers.ai/admin`
- vendor registration
- one tenant storefront on `tenant.servio.hatchers.ai`
- customer registration/login
- booking checkout success flow
- order tracking links in email/WhatsApp
- uploaded assets still present after a redeploy
