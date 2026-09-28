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
