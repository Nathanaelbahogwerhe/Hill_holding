# 🚀 GUIDE DE DÉPLOIEMENT RAPIDE - HILL HOLDING

## Étape 1 : Préparer le serveur

```bash
# Mettre à jour le système
sudo apt update && sudo apt upgrade -y

# Installer les dépendances
sudo apt install -y php8.3 php8.3-fpm php8.3-mysql php8.3-mbstring \
    php8.3-xml php8.3-bcmath php8.3-curl php8.3-zip php8.3-gd \
    mysql-server nginx git composer

# Vérifier PHP
php -v  # Doit afficher 8.3+
```

## Étape 2 : Cloner/Uploader le projet

```bash
# Créer le répertoire
sudo mkdir -p /var/www/hill_holding
cd /var/www/hill_holding

# Option A : Via Git
git clone votre_repo.git .

# Option B : Via FTP/SFTP
# Uploader tous les fichiers sauf node_modules et vendor
```

## Étape 3 : Configurer les permissions

```bash
sudo chown -R www-data:www-data /var/www/hill_holding
sudo chmod -R 755 storage bootstrap/cache
```

## Étape 4 : Configurer l'environnement

```bash
# Copier .env.example
cp .env.example .env

# Éditer .env
nano .env
```

**Modifier ces valeurs :**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_DATABASE=hill_holding_production
DB_USERNAME=votre_user
DB_PASSWORD=votre_password_securise

MAIL_HOST=smtp.votre-serveur.com
MAIL_USERNAME=votre_email
MAIL_PASSWORD=votre_password_mail
```

## Étape 5 : Installer les dépendances

```bash
# Composer (sans dev)
composer install --optimize-autoloader --no-dev

# NPM (si nécessaire)
npm install
npm run build
```

## Étape 6 : Configurer la base de données

```bash
# Se connecter à MySQL
sudo mysql

# Dans MySQL :
CREATE DATABASE hill_holding_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hilluser'@'localhost' IDENTIFIED BY 'MotDePasseSecurise123!';
GRANT ALL PRIVILEGES ON hill_holding_production.* TO 'hilluser'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Exécuter les migrations
php artisan migrate --force

# Créer le premier utilisateur admin
php artisan tinker
```

**Dans tinker :**
```php
use App\Models\User;
use Spatie\Permission\Models\Role;

$admin = User::create([
    'name' => 'Super Admin',
    'email' => 'admin@hillholding.com',
    'password' => bcrypt('VotreMotDePasse123!'),
    'email_verified_at' => now()
]);

$role = Role::create(['name' => 'Super Admin']);
$admin->assignRole('Super Admin');

echo "Admin créé avec succès !";
exit;
```

## Étape 7 : Optimiser Laravel

```bash
php artisan key:generate
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Étape 8 : Configurer Nginx

```bash
sudo nano /etc/nginx/sites-available/hill_holding
```

**Coller cette configuration :**
```nginx
server {
    listen 80;
    server_name votre-domaine.com www.votre-domaine.com;
    root /var/www/hill_holding/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
```

**Activer le site :**
```bash
sudo ln -s /etc/nginx/sites-available/hill_holding /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## Étape 9 : Installer SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d votre-domaine.com -d www.votre-domaine.com
```

## Étape 10 : Tester l'application

Visitez : `https://votre-domaine.com`

**Connexion admin :**
- Email : `admin@hillholding.com`
- Password : `VotreMotDePasse123!`

---

## 🔧 Commandes utiles

### Vider les caches
```bash
php artisan optimize:clear
```

### Voir les logs en temps réel
```bash
tail -f storage/logs/laravel.log
```

### Redémarrer les services
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
```

### Backup base de données
```bash
mysqldump -u hilluser -p hill_holding_production > backup_$(date +%Y%m%d).sql
```

### Restaurer backup
```bash
mysql -u hilluser -p hill_holding_production < backup_20251222.sql
```

---

## ⚠️ Problèmes courants

### Erreur 500
- Vérifier logs : `storage/logs/laravel.log`
- Vérifier permissions : `sudo chmod -R 755 storage bootstrap/cache`
- Vider caches : `php artisan optimize:clear`

### Page blanche
- Activer debug temporairement : `APP_DEBUG=true` dans .env
- Vérifier Nginx logs : `sudo tail -f /var/log/nginx/error.log`

### Assets non chargés
- Vérifier `APP_URL` dans .env
- Recompiler : `npm run build`
- Vider cache navigateur

### Base de données non connectée
- Vérifier identifiants dans .env
- Tester connexion : `php artisan tinker` puis `DB::connection()->getPdo();`

---

## 📞 Support

En cas de problème, vérifier :
1. Logs Laravel : `storage/logs/laravel.log`
2. Logs Nginx : `/var/log/nginx/error.log`
3. Logs PHP-FPM : `/var/log/php8.3-fpm.log`

**Temps de déploiement estimé : 1-2 heures**
