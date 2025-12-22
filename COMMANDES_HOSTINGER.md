# ⚡ COMMANDES RAPIDES HOSTINGER - HILL HOLDING

## 🔌 CONNEXION

```bash
# SSH Hostinger (remplacer par vos identifiants)
ssh u123456789@votredomaine.com -p 65002

# Aller dans le dossier du projet
cd domains/votredomaine.com/public_html
```

---

## 🚀 DÉPLOIEMENT INITIAL

```bash
# 1. Cloner le projet
git clone https://github.com/votre-username/hill_holding.git .

# 2. Installer dépendances
composer install --no-dev --optimize-autoloader

# 3. Configuration
cp .env.example .env
nano .env  # Éditer DB_*, APP_URL, MAIL_*

# 4. Laravel setup
php artisan key:generate
php artisan storage:link
php artisan migrate --force

# 5. Optimisation
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 6. Permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

---

## 👤 CRÉER ADMIN

```bash
php artisan tinker
```

```php
use App\Models\User;
use Spatie\Permission\Models\Role;

$role = Role::firstOrCreate(['name' => 'Super Admin']);
$admin = User::create([
    'name' => 'Super Admin',
    'email' => 'admin@votredomaine.com',
    'password' => bcrypt('AdminPass123!'),
    'email_verified_at' => now()
]);
$admin->assignRole('Super Admin');
echo "✓ Admin créé !";
exit;
```

---

## 🔄 MISE À JOUR

```bash
# Mode maintenance
php artisan down

# Pull modifications
git pull origin main

# Update dépendances
composer install --no-dev --optimize-autoloader

# Migrations
php artisan migrate --force

# Clear + cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Sortir de maintenance
php artisan up
```

---

## 🗄️ BASE DE DONNÉES

### Via hPanel
```
1. hPanel → Bases de données → Gestion
2. Créer : u123456789_hillholding
3. User : u123456789_hilluser
4. Copier identifiants dans .env
```

### Commandes utiles
```bash
# Backup DB
mysqldump -u u123456789_hilluser -p u123456789_hillholding > backup_$(date +%Y%m%d).sql

# Restore DB
mysql -u u123456789_hilluser -p u123456789_hillholding < backup_20251222.sql

# Reset migrations (⚠️ DANGER)
php artisan migrate:fresh --force
```

---

## 📧 TESTER EMAIL

```bash
php artisan tinker
```

```php
Mail::raw('Test Hostinger', function($msg) {
    $msg->to('votre@email.com')->subject('Test');
});
echo "Email envoyé !";
exit;
```

---

## 🧹 NETTOYAGE CACHE

```bash
# Tout vider
php artisan optimize:clear

# OU individuellement
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Recacher
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📊 LOGS & DEBUG

```bash
# Voir logs Laravel
tail -f storage/logs/laravel.log

# Dernières 50 lignes
tail -50 storage/logs/laravel.log

# Vider logs
> storage/logs/laravel.log
```

---

## 🔐 PERMISSIONS

```bash
# Standard
chmod -R 755 storage bootstrap/cache

# Logs writable
chmod -R 775 storage/logs

# Si problème uploads
chmod -R 775 storage/app/public

# Propriétaire (si nécessaire)
chown -R $USER:$USER storage bootstrap/cache
```

---

## 🔧 DÉPANNAGE

### Erreur 500
```bash
# 1. Activer debug temporairement
nano .env
# Changer: APP_DEBUG=true

# 2. Vérifier logs
tail -50 storage/logs/laravel.log

# 3. Régénérer clé
php artisan key:generate

# 4. Vider caches
php artisan optimize:clear

# 5. Permissions
chmod -R 755 storage bootstrap/cache
```

### Assets non chargés
```bash
# Vérifier APP_URL dans .env
nano .env
# Doit être: APP_URL=https://votredomaine.com

# Recompiler (en local puis uploader)
npm run build

# Permissions
chmod -R 755 public/build
```

### Erreur DB Connection
```bash
# Vérifier .env
nano .env
# DB_HOST doit être: localhost (pas 127.0.0.1)

# Tester connexion
php artisan tinker
DB::connection()->getPdo();
exit;
```

### Class not found
```bash
composer dump-autoload
php artisan optimize:clear
```

---

## 📦 COMPOSER

```bash
# Installer packages
composer require nom/package

# Update
composer update --no-dev

# Autoload
composer dump-autoload
```

---

## 🎨 ASSETS (Si Node.js disponible)

```bash
# Installer npm
npm install

# Development
npm run dev

# Production
npm run build
```

---

## ⏰ CRON JOBS (via hPanel)

### Laravel Scheduler
```
Fréquence: * * * * * (Chaque minute)
Commande:
cd /home/u123456789/domains/votredomaine.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker (optionnel)
```
Fréquence: */5 * * * * (Toutes les 5 min)
Commande:
cd /home/u123456789/domains/votredomaine.com/public_html && php artisan queue:work --stop-when-empty
```

---

## 🔒 SÉCURITÉ

### Vérifier .env protégé
```bash
curl https://votredomaine.com/.env
# Doit retourner 403 Forbidden
```

### Forcer HTTPS
Dans `.env`:
```env
SESSION_SECURE_COOKIE=true
```

Dans `public/.htaccess` (ajouter):
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST%}/$1 [L,R=301]
```

---

## 📋 INFORMATIONS UTILES

### Identifiants Hostinger à noter
```
SSH Username: u123456789
SSH Host: votredomaine.com
SSH Port: 65002
DB Host: localhost
DB Name: u123456789_hillholding
DB User: u123456789_hilluser
SMTP: smtp.hostinger.com:587
```

### Chemins importants
```
Projet: /home/u123456789/domains/votredomaine.com/public_html
Racine web: /home/u123456789/domains/votredomaine.com/public_html/public
Logs: /home/u123456789/domains/votredomaine.com/logs
```

### Fichiers à éditer souvent
```bash
nano .env                    # Configuration
nano public/.htaccess        # Redirections
nano config/app.php          # Config app
```

---

## 🎯 RACCOURCIS ALIAS (optionnel)

Ajouter dans `~/.bashrc`:
```bash
alias hill='cd /home/u123456789/domains/votredomaine.com/public_html'
alias artisan='php artisan'
alias pa='php artisan'
alias tinker='php artisan tinker'
alias logs='tail -f storage/logs/laravel.log'
```

Recharger:
```bash
source ~/.bashrc
```

Utilisation:
```bash
hill              # Va dans le projet
pa cache:clear    # Vide cache
logs              # Affiche logs
```

---

## 📞 SUPPORT RAPIDE

### Vérifier status
```bash
php artisan about
```

### Infos système
```bash
php -v                    # Version PHP
composer --version        # Version Composer
mysql --version          # Version MySQL
```

### Test complet
```bash
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
php artisan optimize && \
echo "✓ Optimisation terminée !"
```

---

**💡 Astuce:** Gardez ce fichier ouvert dans un onglet pour référence rapide !

**📚 Guide complet:** Voir DEPLOIEMENT_HOSTINGER.md
