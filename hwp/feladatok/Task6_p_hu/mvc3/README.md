# MVC3 (Minimal MVC with Routing + PDO) — Subfolder-safe

This is a small teaching example of MVC in PHP with:
- Front Controller (`public/index.php`)
- Pretty URLs via `.htaccess` (Apache + mod_rewrite)
- Minimal Router: `/controller/action/param`
- PDO (MySQL) data access via a tiny `Database` helper
- Sample entity: Books (list, details, create)
- Subfolder support via `base_path` + a global `url()` helper

## Requirements
- PHP 8.1+ recommended
- Apache with `mod_rewrite` enabled (XAMPP works)
- MySQL/MariaDB

## Setup
1. Create the database and table using `database.sql`
2. Update `config/config.php` if needed
3. Deploy either:
   - Recommended: set your web server DocumentRoot to the `public/` folder
   - Or: keep it in a subfolder and set `base_path`

## base_path
If your URL is like:
`http://localhost/nwp_2025/11/mvc3/public/book/index`

Set:
`'base_path' => '/nwp_2025/11/mvc3/public'`

Then all links and redirects will work automatically.

## Routes
- `/home/index`
- `/book/index`
- `/book/show/1`
- `/book/create`  (GET form)
- `/book/store`   (POST insert)

## Folder map
- `public/`  – entry point + .htaccess
- `app/`     – router, core, controllers, models, views
- `config/`  – configuration
