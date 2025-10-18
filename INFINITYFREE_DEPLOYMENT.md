# 🚀 InfinityFree Deployment Guide

## 📋 Prerequisites

1. **InfinityFree Account**: Sign up at [infinityfree.net](https://infinityfree.net)
2. **GitHub Account**: For automatic deployment
3. **FTP Client**: FileZilla or similar (for manual deployment)

---

## 🎯 Quick Setup (Recommended)

### 1. **Automatic Deployment via GitHub Actions**

#### Step 1: Set up GitHub Secrets
1. Go to your GitHub repository
2. Click **Settings** → **Secrets and variables** → **Actions**
3. Add these secrets:
   ```
   FTP_USERNAME: your_infinityfree_username
   FTP_PASSWORD: your_infinityfree_password
   ```

#### Step 2: Push to Deploy
```bash
git add .
git commit -m "Ready for InfinityFree deployment"
git push origin main
```

**✅ That's it!** Your site will be automatically deployed.

---

## 🔧 Manual Setup (Alternative)

### 1. **Create MySQL Database on InfinityFree**

1. **Login to InfinityFree Control Panel**
2. **Go to MySQL Databases**
3. **Create New Database**:
   - Database Name: `if0_12345678_waste_no_more`
   - Username: `if0_12345678`
   - Password: `your_secure_password`

### 2. **Upload Files via FTP**

#### FTP Connection Details:
- **Host**: `ftpupload.net`
- **Port**: `21`
- **Username**: Your InfinityFree username
- **Password**: Your InfinityFree password
- **Directory**: `/htdocs/`

#### Upload Process:
1. **Connect via FTP**
2. **Upload ALL files** from your Laravel project to `/htdocs/`
3. **Set Permissions**:
   - `storage/` → `755`
   - `bootstrap/cache/` → `755`

### 3. **Configure Environment**

1. **Rename `.env.example` to `.env`**
2. **Update database credentials**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=sql212.infinityfree.com
   DB_PORT=3306
   DB_DATABASE=if0_12345678_waste_no_more
   DB_USERNAME=if0_12345678
   DB_PASSWORD=your_mysql_password
   APP_URL=https://your-domain.infinityfree.net
   ```

3. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

### 4. **Run Database Migrations**

**Option A: Via Control Panel (if available)**
- Use InfinityFree's PHP execution feature

**Option B: Via FTP**
- Upload a temporary PHP file to run migrations:
   ```php
   <?php
   require_once 'vendor/autoload.php';
   $app = require_once 'bootstrap/app.php';
   $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
   
   // Run migrations
   Artisan::call('migrate', ['--force' => true]);
   
   // Run seeders
   Artisan::call('db:seed', ['--force' => true]);
   
   echo "Database setup complete!";
   ?>
   ```

---

## ⚙️ Configuration Files

### 📄 `.htaccess` (Root Directory)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 📄 `.env` Configuration
```env
APP_NAME="Waste No More"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.infinityfree.net

DB_CONNECTION=mysql
DB_HOST=sql212.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_12345678_waste_no_more
DB_USERNAME=if0_12345678
DB_PASSWORD=your_mysql_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

GROK_API_KEY=YOUR_GROK_API_KEY_HERE
```

---

## 🔍 Troubleshooting

### ❌ Common Issues

#### 1. **"500 Internal Server Error"**
- **Check**: File permissions (`storage/` and `bootstrap/cache/` should be `755`)
- **Check**: `.env` file exists and has correct database credentials
- **Check**: Application key is generated

#### 2. **"Database Connection Failed"**
- **Verify**: Database credentials in `.env`
- **Check**: Database exists in InfinityFree control panel
- **Test**: Connection via InfinityFree's phpMyAdmin

#### 3. **"Routes Not Working"**
- **Check**: `.htaccess` file is in root directory
- **Verify**: `mod_rewrite` is enabled (should be by default)

#### 4. **"Assets Not Loading"**
- **Check**: `APP_URL` in `.env` matches your domain
- **Verify**: `public/` directory contains CSS/JS files

### 🔧 Debug Mode
To enable debug mode temporarily:
```env
APP_DEBUG=true
APP_ENV=local
```

---

## 📊 Performance Optimization

### 1. **Enable Caching**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. **Optimize Autoloader**
```bash
composer install --optimize-autoloader --no-dev
```

### 3. **Set Proper Permissions**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

---

## 🎉 Success Checklist

- [ ] ✅ Files uploaded to `/htdocs/`
- [ ] ✅ `.env` file configured with correct database credentials
- [ ] ✅ Application key generated
- [ ] ✅ Database migrations run successfully
- [ ] ✅ File permissions set correctly
- [ ] ✅ Website loads without errors
- [ ] ✅ All routes working properly
- [ ] ✅ Database operations functioning

---

## 🆘 Support

### **InfinityFree Resources**
- [Documentation](https://infinityfree.net/support/)
- [Community Forum](https://forum.infinityfree.net/)
- [Knowledge Base](https://infinityfree.net/kb/)

### **Laravel Resources**
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Community](https://laracasts.com/)

---

## 🎯 Final Notes

- **Free Forever**: InfinityFree offers unlimited free hosting
- **MySQL Included**: Perfect for Laravel applications
- **Automatic SSL**: HTTPS enabled by default
- **Custom Domain**: Can be added later if needed
- **No Credit Card**: Completely free service

**Your Laravel application is now ready for InfinityFree deployment!** 🚀
