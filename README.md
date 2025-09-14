# Laravel Blog Application

A comprehensive, feature-rich blog application built with Laravel, featuring post management, categories, user authentication, and a responsive design.

## 🚀 Features

- **Blog Post Management**: Create, edit, update, and delete blog posts
- **Category System**: Organize posts into multiple categories
- **User Authentication**: Complete registration and login system
- **Image Uploads**: Featured images for posts with automatic storage handling
- **Responsive Design**: Bootstrap-powered responsive layout
- **Search & Filter**: Filter posts by categories
- **Rich Text Content**: Support for long-form content with proper formatting
- **Pagination**: Efficient loading for large numbers of posts
- **Admin Dashboard**: Simple interface for content management
- **SEO Friendly**: Clean URLs with slugs and meta tags

## 🛠️ Technology Stack

- **Backend**: Laravel 12.28.1
- **Frontend**: Bootstrap 5.3, Blade Templates
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel UI
- **File Storage**: Local filesystem (with S3 compatibility)
- **PHP**: 8.2.4+

## 📋 Prerequisites

Before installation, ensure you have:

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Node.js and npm (for frontend assets)
- Web server (Apache/Nginx) or PHP built-in server

## 🚦 Installation Guide

### 1. Clone the Repository

```bash
git clone [Here](https://github.com/ernesthenry/blog-app)
cd blog-app
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_app
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE blog_app;"
```

### 5. Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

### 6. Install Frontend Dependencies

```bash
npm install
npm run build
```

### 7. Set Up Storage Link

```bash
php artisan storage:link
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🗄️ Database Structure

### Main Tables

- **posts**: Blog posts with title, content, excerpt, featured image
- **categories**: Post categories with name and description
- **category_post**: Many-to-many relationship table
- **users**: User accounts for authentication

### Relationships

- User has many Posts
- Post belongs to User
- Post belongs to many Categories
- Category belongs to many Posts

## 🎨 Frontend Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout template
├── home.blade.php             # Homepage with featured content
├── posts/
│   ├── index.blade.php        # List all posts
│   ├── create.blade.php       # Create new post form
│   ├── edit.blade.php         # Edit post form
│   └── show.blade.php         # Single post view
└── categories/
    ├── index.blade.php        # List all categories
    ├── create.blade.php       # Create category form
    ├── edit.blade.php         # Edit category form
    └── show.blade.php         # Category details with posts
```

## 🔐 Authentication

The application includes full user authentication:

- User registration (`/register`)
- User login (`/login`)
- Password reset functionality
- Protected routes for post management

## 📝 Usage Guide

### Creating a New Post

1. Navigate to `/posts/create`
2. Fill in post details:
   - Title (required)
   - Excerpt (required)
   - Content (required)
   - Featured image (optional)
   - Select categories
   - Publish status
3. Click "Create Post"

### Managing Categories

1. Navigate to `/categories`
2. View all categories with post counts
3. Create new categories with `/categories/create`
4. Edit existing categories
5. View posts by category

### User Registration

1. Navigate to `/register`
2. Fill in name, email, and password
3. Verify email and log in
4. Access post management features

## 🧪 Testing

Run the test suite with:

```bash
php artisan test
```

## 🔧 Configuration

### File Upload Settings

Configure in `config/filesystems.php`:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
    // ...
],
```

### Image Validation

Configure in form requests (`StorePostRequest`, `UpdatePostRequest`):

```php
'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
```

## 📊 Seeding Data

The database seeder includes:

- 1 admin user
- 5 additional users
- 10 categories
- 50 blog posts with category relationships

To reseed:

```bash
php artisan migrate:fresh --seed
```

## 🚀 Deployment

### For Production

1. Update `.env` for production:

```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize the application:

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set proper permissions:

```bash
chmod -R 755 storage bootstrap/cache
```

### Deployment Script

Create `deploy.sh`:

```bash
#!/bin/bash
echo "Deploying Laravel Blog Application..."
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
chmod -R 755 storage bootstrap/cache
echo "Deployment completed!"
```

## 🐛 Troubleshooting

### Common Issues

**Permission Denied Errors**
```bash
chmod -R 755 storage bootstrap/cache
```

**Database Connection Errors**
- Verify database credentials in `.env`
- Ensure MySQL is running

**Page Not Found (404)**
```bash
php artisan route:clear
php artisan cache:clear
```

**Image Upload Issues**
```bash
php artisan storage:link
```

### Logs

Check application logs:

```bash
tail -f storage/logs/laravel.log
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap
- MariaDB/MySQL
- All contributors and testers

## 📞 Support

For support, please open an issue in the GitHub repository or contact the development team.
