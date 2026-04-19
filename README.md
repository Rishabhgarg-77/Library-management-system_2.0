# Library Management System (PHP)

## Setup
1. Install XAMPP and start Apache + MySQL.
2. Place this project in `C:\xampp\htdocs\Librarymanagement_system`.
3. Open `http://localhost/phpmyadmin`.
4. Import `database_setup.sql` to create `library_db`, `users`, `books`.

## Run
- In browser: `http://localhost/Librarymanagement_system/index.html`.

## Check PHP CLI
- Ensure PHP is in PATH or use `C:\xampp\php\php.exe`.
- Example: `php -v` or `C:\xampp\php\php.exe -v`.

## Tools
- Lint files:
  - `C:\xampp\php\php.exe -l php/index.php`
  - `... php/login.php ...` etc.

## Use
1. Register with new user.
2. Log in.
3. Add books on Dashboard.
4. Search books on `Search Books`.
5. See Recommendations + Book details.

## Common fix when not working
- Check `php.ini` extensions: `pdo_mysql` enabled.
- Confirm `database_setup.sql` ran without errors.
- Check file permissions for `db_connect.php`.
- For relative path issues with built-in server, use XAMPP path as above.
