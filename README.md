# PHP + MySQL Bus Pass Management System

A beginner-friendly PHP/MySQL CRUD application designed for deployment on AWS EC2.

## Features

- Admin login
- Add bus pass
- View all bus passes
- Edit bus pass
- Delete bus pass
- MySQL database
- Responsive UI
- Apache/PHP compatible
- Ready for AWS EC2

## Project structure

```text
php-bus-pass-management/
├── index.php
├── login.php
├── dashboard.php
├── add_pass.php
├── edit_pass.php
├── delete_pass.php
├── logout.php
├── config.php
├── database.sql
├── assets/
│   └── style.css
└── README.md
```

## Local setup

1. Install XAMPP/WAMP/LAMP.
2. Copy the project into the web root.
3. Create/import `database.sql` in MySQL/phpMyAdmin.
4. Update `config.php`.
5. Open `http://localhost/php_bus_pass_management/`.

Default login:

```text
Username: admin
Password: admin123
```

**Change the default password before using this application publicly.**

## AWS EC2 deployment

### 1. Create an EC2 instance

Recommended for learning:

- Ubuntu 24.04 LTS
- Allow SSH (22) from your IP
- Allow HTTP (80) from anywhere
- Allow HTTPS (443) from anywhere

### 2. Connect by SSH

```bash
ssh -i your-key.pem ubuntu@YOUR_EC2_PUBLIC_IP
```

### 3. Install Apache, PHP, MySQL and extensions

```bash
sudo apt update
sudo apt install apache2 php libapache2-mod-php php-mysql php-curl php-mbstring php-xml php-zip mysql-server unzip -y
```

Check versions:

```bash
php -v
mysql --version
sudo systemctl status apache2
```

### 4. Upload the ZIP

From your Windows machine, you can use SCP:

```bash
scp -i your-key.pem php_bus_pass_management.zip ubuntu@YOUR_EC2_PUBLIC_IP:/home/ubuntu/
```

Then on EC2:

```bash
cd /home/ubuntu
unzip php_bus_pass_management.zip
sudo rm -rf /var/www/html/*
sudo cp -r php_bus_pass_management/* /var/www/html/
```

### 5. Configure MySQL

Open MySQL:

```bash
sudo mysql
```

Run:

```sql
CREATE DATABASE bus_pass_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'buspass_user'@'localhost' IDENTIFIED BY 'CHANGE_ME_TO_A_STRONG_PASSWORD';

GRANT ALL PRIVILEGES ON bus_pass_db.* TO 'buspass_user'@'localhost';

FLUSH PRIVILEGES;
EXIT;
```

Import the tables:

```bash
sudo mysql -u buspass_user -p bus_pass_db < /var/www/html/database.sql
```

### 6. Update PHP database configuration

Edit:

```bash
sudo nano /var/www/html/config.php
```

Use:

```php
$host = "localhost";
$db   = "bus_pass_db";
$user = "buspass_user";
$pass = "YOUR_DATABASE_PASSWORD";
```

Save and exit.

### 7. Set permissions

```bash
sudo chown -R www-data:www-data /var/www/html
sudo find /var/www/html -type d -exec chmod 755 {} \;
sudo find /var/www/html -type f -exec chmod 644 {} \;
```

### 8. Restart Apache

```bash
sudo systemctl enable apache2
sudo systemctl restart apache2
```

### 9. Open the application

Visit:

```text
http://YOUR_EC2_PUBLIC_IP/
```

Login with:

```text
admin
admin123
```

## Important security notes

- Change the default admin password.
- Do not expose MySQL port 3306 publicly unless absolutely necessary.
- Restrict SSH port 22 to your IP address.
- Use HTTPS with a domain and Let's Encrypt for a real production deployment.
- For production, consider Amazon RDS for MySQL instead of running MySQL directly on EC2.
- Never commit real database passwords to GitHub.

## Troubleshooting

### Apache is not serving PHP

```bash
sudo systemctl restart apache2
sudo apache2ctl configtest
```

### Check Apache errors

```bash
sudo tail -f /var/log/apache2/error.log
```

### Check PHP

```bash
php -v
```

### Check MySQL

```bash
sudo systemctl status mysql
```

### Database connection error

Verify the database name, username and password in `config.php`.

## License

For learning and personal projects.
