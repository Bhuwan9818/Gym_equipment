# FITRONFITNESS — Gym Equipment Website

A full PHP-powered e-commerce-style catalogue site with two product categories
(**Indoor Gym Equipment** and **Outdoor Gym Equipment**), 29 product listings,
dynamic category/product pages, an enquiry form, and a password-protected
Admin Panel for managing everything — no database required.

---

## 1. What's inside

```
gym_equipments/
├── index.php              Homepage
├── category.php           Category listing page  (/category/{slug})
├── product.php             Single product page     (/product/{slug})
├── enquire.php             Handles the enquiry / callback forms
├── .htaccess               Pretty URLs (mod_rewrite)
├── data/                   Your "database" — plain JSON files
│   ├── categories.json
│   ├── products.json
│   └── enquiries.json
├── includes/                Shared PHP (config, helpers, header/footer)
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── images/
│       ├── site/                    original site imagery
│       ├── products/indoor/         25 real product photos
│       └── products/outdoor/        4 sample/placeholder illustrations
└── admin/                   Password-protected admin panel
    ├── login.php
    ├── index.php             Dashboard
    ├── categories.php / category-edit.php
    ├── products.php / product-edit.php
    ├── enquiries.php
    └── generate-hash.php     Tool to change the admin password
```

There is **no database to install**. All content (categories, products,
enquiries) lives in the three JSON files under `data/`, read and written by
PHP. This makes the site easy to host anywhere that supports PHP — no MySQL
setup, no migrations.

## 2. Requirements

- **PHP 7.4 or newer** (the admin panel uses modern PHP syntax such as arrow
  functions). PHP 8.x works too.
- **Apache with `mod_rewrite`** is recommended for the clean URLs
  (`/category/indoor-gym-equipment`, `/product/vertical-chest-press`). This is
  enabled by default on almost all shared hosting (cPanel, etc.).
- The web server needs **write permission** on:
  - `data/` (so the admin panel and enquiry form can save changes)
  - `assets/images/products/` and its subfolders (for photo uploads)
  - `assets/images/categories/` (for category image uploads)

  On most shared hosting this works out of the box. If you get a "could not
  save" error in the admin panel, set these folders to permission `755` (or
  `775`) via your host's file manager or FTP client.

## 3. Uploading / deploying

1. Upload the entire `gym_equipments` folder to your web host (e.g. via FTP,
   or your hosting control panel's file manager), so that `index.php` sits
   directly in the folder visitors will hit (e.g. `public_html/` for the
   domain root, or `public_html/shop/` for a sub-folder).
2. That's it — the site **auto-detects** whether it's running at your
   domain root or inside a sub-folder, so CSS, JS, images and links all
   work correctly either way with no editing required. (Under the hood,
   `includes/config.php` compares its own folder against your server's
   document root to work this out automatically.)
   - If you ever hit a host where that detection doesn't work and you see
     broken CSS/images/links, open `includes/config.php` and set
     `SITE_BASE_PATH_OVERRIDE` to a fixed value instead, e.g.:
     ```php
     define('SITE_BASE_PATH_OVERRIDE', '/shop');   // or '' for the domain root
     ```
3. By default the site uses plain links like `category.php?slug=...` and
   `product.php?slug=...`, which work on every server with zero setup. If
   you'd like the nicer clean URLs (`/category/indoor-gym-equipment`,
   `/product/vertical-chest-press`) instead:
   - Visit `/category/indoor-gym-equipment` directly in your browser.
   - If you see the actual category page (with products and styling), it's
     working — open `includes/config.php` and set:
     ```php
     define('USE_PRETTY_URLS', true);
     ```
   - If you instead see a blank/plain "Not Found" page with no styling at
     all, your server isn't applying the rewrite rules in `.htaccess` yet.
     This is extremely common on local **XAMPP/WAMP/MAMP** installs, which
     ship with `.htaccess` overrides disabled by default. To fix it:
     - **XAMPP**: open `apache/conf/httpd.conf`, find the
       `<Directory "C:/xampp/htdocs">` block, change `AllowOverride None`
       to `AllowOverride All`, save, and restart Apache. Make sure
       `LoadModule rewrite_module modules/mod_rewrite.so` is also
       uncommented in the same file.
     - **Shared/cPanel hosting**: this almost always works out of the box;
       if not, ask your host to confirm `mod_rewrite` and `AllowOverride All`
       are enabled for your account.
     - Leave `USE_PRETTY_URLS` as `false` until the plain "visit the URL
       directly" test above actually works.
4. To preview locally before uploading, with PHP installed, run from inside
   the `gym_equipments` folder:
   ```
   php -S localhost:8000
   ```
   then open `http://localhost:8000` (pretty URLs won't work with the built-in
   server — set `USE_PRETTY_URLS` to `false` for local testing).

## 4. Logging into the Admin Panel

Go to `/admin/` (e.g. `https://yourdomain.com/admin/`).

```
Username: admin
Password: ChangeMe123!
```

**Change this password immediately:**
1. Log in, then click **🔑 Change Password** in the sidebar.
2. Enter a new username/password and click **Generate Hash**.
3. Copy the two lines it shows you.
4. Edit `includes/config.php` and replace the existing `ADMIN_USERNAME` and
   `ADMIN_PASSWORD_HASH` lines with the ones you copied. Save the file.
5. Log in again with your new password.

(The tool only displays the new hash once — it does not save it for you —
because this site has no database user table to store it in. Editing the one
line in `config.php` is the safe, standard way to rotate the password.)

From the Admin Panel you can:
- **Categories** — add/edit/delete the two top-level categories and their
  subcategory filter tabs, and change category cover/banner images.
- **Products** — add/edit/delete individual products, upload photos, edit the
  specification table, mark a product as **Featured** (shows on the homepage)
  or as a **Sample/placeholder**, search and filter the product list.
- **Enquiries** — see every submission from the site's contact form and
  product "Enquire Now" buttons, mark them read/unread, or delete them.

## 5. About the product data

**Indoor Gym Equipment (25 products)** were extracted directly from the
catalogue PDF you provided — names, model numbers, and full specification
tables (frame, cushion, pulley, handle, weight stack, dimensions, etc.) were
transcribed product-by-product, and a clean product photo was cropped from
each catalogue page onto a plain white background.

**Outdoor Gym Equipment (4 products)** — your catalogue did not include any
outdoor equipment, so this category ships with **4 clearly-labelled sample
placeholder listings** (simple line-art illustrations, not real photos) so
you can see the category working end-to-end. Each one is flagged with a
"Sample" badge on the site and in the admin product list, and the Admin
Dashboard reminds you they're there. Whenever you have real outdoor products,
just edit (or delete and recreate) those four listings from **Products** in
the admin panel — upload a real photo, fill in real specs, and untick "Mark
as sample / placeholder listing."

## 6. Editing site-wide settings

Open `includes/config.php` to change:
- Business name, phone number, WhatsApp number, email, address
- The sub-folder base path and pretty-URL toggle described above

## 7. Troubleshooting

- **500 error on every page** — usually a `.htaccess` directive your host
  doesn't support. Try renaming `.htaccess` temporarily to confirm, then ask
  your host whether `mod_rewrite` is enabled.
- **Clean URLs show a blank/plain "Not Found" page** — this means
  `USE_PRETTY_URLS` is set to `true` but your server isn't applying
  `.htaccess` rewrites (common on XAMPP/WAMP by default). Set it back to
  `false`, or fix `AllowOverride`/`mod_rewrite` as described in step 3 above.
- **"Could not save" in the admin panel** — a file-permission issue; see the
  requirements section above.
- **Uploaded image doesn't appear** — check the file is one of `.jpg .jpeg
  .png .webp .svg` and under 8MB.

---

Built for FITRONFITNESS. No external database, no paid plugins — just PHP and
JSON files you can back up by copying the `data/` folder.
