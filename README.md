# Kencana Form

A Laravel application.

## Prerequisites

- PHP 8.x or higher
- Composer
- Node.js & NPM
- MySQL (or preferred database)

## Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone git@github.com:tudemaha/kencana-form.git
   cd kencana-form
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies & build assets:**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Configuration:**
   Copy the `.env.example` file to create your own `.env` file:
   ```bash
   cp .env.example .env
   ```
   Generate the application key:
   ```bash
   php artisan key:generate
   ```

5. **Database Setup:**
   Update your `.env` file with your database configuration. For example:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kencana_form
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Admin Credentials:**
   Configure the initial admin user credentials in your `.env` file. These will be used during the database seeding step:
   ```env
   ADMIN_USERNAME=your_admin_username
   ADMIN_PASSWORD=your_secure_password
   ```

7. **Link Storage:**
   If your application handles file uploads (e.g., using Filament's file upload fields), you need to create a symbolic link for the storage directory:
   ```bash
   php artisan storage:link
   ```

8. **Run Migrations and Seeders:**
   Migrate your database tables and seed the initial data (including the Super Admin user):
   ```bash
   php artisan migrate --seed
   ```

9. **Start the Application:**
   Run the local development server:
   ```bash
   php artisan serve
   ```
   
   If you need to make changes to frontend assets during development, you can run:
   ```bash
   npm run dev
   ```

   You can now access the application at `http://localhost:8000`.

## Production Optimizations

When deploying to a production server, it is highly recommended to run the following commands to optimize Laravel, Livewire, and Filament for better performance:

```bash
# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimize Filament components
php artisan filament:optimize
```

## Shared Hosting / cPanel Deployment (Split Directory Method)

When deploying to a shared hosting environment like cPanel, it is highly recommended to use the **Split Directory Method** to keep your application code secure outside the public web root while placing public assets where cPanel expects them (`public_html`).

### 1. Structure Your Directories
- Upload all your Laravel project files (except the `public/` folder) to a folder outside of your web root (e.g., `/home/yourusername/kencana-form`).
- Move the **contents** of your Laravel `public/` folder into cPanel's `/home/yourusername/public_html/` directory.

### 2. Update `index.php`
In your `public_html/index.php` file, update the paths so they point to your Laravel app directory:
```php
// Find these lines and update the paths:
require __DIR__.'/../kencana-form/vendor/autoload.php';
$app = require_once __DIR__.'/../kencana-form/bootstrap/app.php';
```

### 3. Change Public Path (`AppServiceProvider`)
Since cPanel uses `public_html` instead of `public`, you need to tell Laravel where your public directory is so that functions like `public_path()` and asset generation work correctly.
   
Open `app/Providers/AppServiceProvider.php` (in your main app directory) and add this to the `register()` method:
```php
public function register(): void
{
    $this->app->usePublicPath(base_path('../public_html'));
}
```

### 4. Create the Storage Symlink (via SSH)
If you've deployed your application outside the `public_html` directory, `php artisan storage:link` won't map correctly to `public_html`. Manually create the symbolic link via your cPanel SSH Terminal:

```bash
# Remove any broken/existing link or folder first
rm -rf ~/public_html/storage

# Create the new symbolic link (adjust 'kencana-form' if you named it differently)
ln -s ~/kencana-form/storage/app/public ~/public_html/storage
```

### 5. Frontend & Filament Assets
If your cPanel does not support running `npm install`, `npm run build`, or Artisan commands, you must upload compiled assets manually:
- **NPM Assets:** Run `npm run build` on your local computer, then upload the generated `public/build/` directory to `public_html/build/`.
- **Filament Assets:** Filament's internal assets are ignored by Git. If you have SSH access, run `php artisan filament:upgrade`. If you do not have SSH access, temporarily remove `/public/css/filament`, `/public/js/filament`, and `/public/fonts/filament` from your local `.gitignore`, run the upgrade command locally, and manually upload those folders to `public_html/`.

### 6. File Permissions (chmod)
Laravel requires specific directories to be writable by the web server, and standard directories should have correct baseline permissions. Update the permissions via your cPanel File Manager or SSH Terminal:

```bash
# Set baseline permissions for the entire application folder
chmod -R 755 ~/kencana-form

# Make sure the storage and bootstrap/cache directories are writable
chmod -R 775 ~/kencana-form/storage ~/kencana-form/bootstrap/cache
```
