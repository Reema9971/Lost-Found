# Lost & Found Portal

A PHP and MySQL web application for reporting, browsing, and managing lost or found items in a college community.

## Features

- User registration and login
- Create lost and found item reports with optional image uploads
- Browse all reported items and view item details
- Personal dashboard for editing and deleting your reports
- CSRF protection for state-changing requests
- Image upload validation for JPEG, PNG, GIF, and WebP files
- Responsive, modern interface

## Requirements

- PHP 8.0 or newer with the PDO MySQL and Fileinfo extensions
- MySQL or MariaDB
- Apache or another PHP-capable web server
- XAMPP is recommended for local Windows development

## Local setup with XAMPP

1. Copy this project into `C:\xampp\htdocs\Lost-Found`.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Create a database named `lost_found`.
5. Import the SQL schema for the `users` and `items` tables, if you have one.
6. Check the database values in `includes/config.php`.
7. Visit `http://localhost/Lost-Found/`.

## Database configuration

Edit `includes/config.php` to use your MySQL details:

```php
$host = 'localhost';
$dbname = 'lost_found';
$username = 'your_database_user';
$password = 'your_strong_password';
```

Do not use the XAMPP `root` account or an empty password in production.

## Deployment

1. Export the local `lost_found` database from phpMyAdmin as an SQL file.
2. Create a MySQL database and user through your hosting control panel.
3. Import the SQL file using the host's phpMyAdmin.
4. Upload the project contents to the domain's web root, usually `public_html`.
5. Update `includes/config.php` with the production database credentials.
6. Ensure `uploads/` is writable by PHP.
7. Enable HTTPS for the domain.

When deploying to the web root, use a relative stylesheet reference (`style.css`) in `includes/header.php`. This works both locally and in production.

## Security notes

- Keep `uploads/.htaccess` in place to block execution of uploaded scripts.
- Use a unique database password and avoid committing production credentials.
- Keep PHP, MySQL, and Apache updated.
- Back up the database and uploaded images regularly.

## Project structure

```text
includes/       Shared configuration, authentication, header, and footer
uploads/        User-uploaded item images
dashboard.php   User report management
report.php      New report form
process-report.php
                Report creation and image upload handling
items.php       Community item listing
item-details.php
                Individual item details
style.css       Responsive site styling
```
