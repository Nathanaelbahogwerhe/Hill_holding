# 🚀 Déploiement Hill Holding - srv1191613.hstgr.cloud

## ⚠️ AVANT DE COMMENCER

### 1. Créer la base de données MySQL
Dans **hPanel** :
- Allez dans **Bases de données MySQL**
- Cliquez sur **Créer une base de données**
- Nom suggéré : `u123456789_hillholding` (remplacez u123456789 par votre username)
- Créez un utilisateur avec tous les privilèges
- **NOTEZ LES CREDENTIALS** (vous en aurez besoin à l'étape 6)

### 2. Informations nécessaires
Vous devez obtenir dans hPanel → Avancé → SSH Access :
- **Username SSH** : u123456789 (à trouver dans hPanel)
- **Port SSH** : généralement 65002
- **Host** : srv1191613.hstgr.cloud

### 3. Créer un repo Git
Si pas déjà fait :
- Créez un repo GitHub ou GitLab (peut être privé)
- Notez l'URL du repo

---

## 📋 DÉPLOIEMENT EN 10 ÉTAPES

### Étape 1 : Initialiser Git localement (si pas fait)

**Sur votre machine Windows** (dans PowerShell ou Git Bash) :
```bash
cd c:\laragon\www\hill_holding

# Si Git n'est pas encore initialisé
git init
git add .
git commit -m "Initial commit - Hill Holding"

# Lier à votre repo GitHub/GitLab
git remote add origin https://github.com/VOTRE_USERNAME/hill_holding.git
git branch -M main
git push -u origin main
```

---

### Étape 2 : Connexion SSH à Hostinger

```bash
ssh u123456789@srv1191613.hstgr.cloud -p 65002
```

Remplacez `u123456789` par votre vrai username SSH.

---

### Étape 3 : Supprimer le contenu par défaut

```bash
cd ~
rm -rf public_html/*
rm -rf public_html/.??*
```

---

### Étape 4 : Cloner le projet

```bash
git clone https://github.com/VOTRE_USERNAME/hill_holding.git public_html
cd public_html
```

⚠️ Si le repo est privé, utilisez un token :
```bash
git clone https://VOTRE_TOKEN@github.com/VOTRE_USERNAME/hill_holding.git public_html
```

---

### Étape 5 : Installer les dépendances

```bash
composer install --no-dev --optimize-autoloader
```

Si `composer` n'est pas trouvé :
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
alias composer="php ~/composer.phar"
composer install --no-dev --optimize-autoloader
```

---

### Étape 6 : Configurer .env

```bash
cp .env.example .env
nano .env
```

**Modifiez ces lignes** (utilisez les flèches, puis Ctrl+O pour sauver, Ctrl+X pour quitter) :

```env
APP_NAME="Hill Holding"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hill.holding.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_hillholding      # Votre nom de DB
DB_USERNAME=u123456789_hillholding      # Votre username DB
DB_PASSWORD=VOTRE_MOT_DE_PASSE          # Mot de passe DB

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@hill.holding.com
MAIL_PASSWORD=VOTRE_MOT_DE_PASSE_EMAIL
MAIL_FROM_ADDRESS="contact@hill.holding.com"
```

---

### Étape 7 : Configuration Laravel

```bash
# Générer la clé
php artisan key:generate

# Créer le lien symbolique storage
php artisan storage:link

# Migrations
php artisan migrate --force

# Optimisation
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

### Étape 8 : Permissions

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
chown -R $USER:$USER storage bootstrap/cache
```

---

### Étape 9 : Créer l'admin

```bash
php artisan tinker
```

Dans tinker, tapez :
```php
$admin = new App\Models\User();
$admin->name = 'Administrateur';
$admin->email = 'admin@hill.holding.com';
$admin->password = bcrypt('MotDePasseSecure2024!');
$admin->email_verified_at = now();
$admin->save();
$admin->assignRole('super_admin');
exit
```

---

### Étape 10 : Configuration hPanel

#### A. Configurer PHP (version 8.3 recommandée)
1. hPanel → **Website** → **Avancé** → **PHP Configuration**
2. Sélectionnez **PHP 8.3**
3. Extensions requises (cochez-les) :
   - mysqli
   - pdo_mysql
   - mbstring
   - xml
   - ctype
   - json
   - tokenizer
   - openssl
   - bcmath
   - fileinfo
   - gd

#### B. Configurer Document Root
1. hPanel → **Website** → **Avancé** → **Document Root**
2. Changez de `public_html` à `public_html/public`
3. Sauvegardez

#### C. SSL/HTTPS
1. hPanel → **Sécurité** → **SSL/TLS**
2. Activez **Force HTTPS**
3. Le certificat Let's Encrypt se génère automatiquement

#### D. Cron Jobs (pour Laravel Scheduler)
1. hPanel → **Avancé** → **Cron Jobs**
2. Créez un nouveau cron :
   - **Type** : Quotidien ou Chaque minute
   - **Commande** :
   ```bash
   cd /home/u123456789/domains/hill.holding.com/public_html && php artisan schedule:run >> /dev/null 2>&1
   ```

#### E. Queue Worker (optionnel mais recommandé)
Créez un autre cron qui s'exécute chaque minute :
```bash
cd /home/u123456789/domains/hill.holding.com/public_html && php artisan queue:work --stop-when-empty
```

---

## ✅ VÉRIFICATION

Allez sur : **https://hill.holding.com**

Vous devriez voir la page d'accueil ! 🎉

Testez la connexion :
- Email : `admin@hill.holding.com`
- Mot de passe : celui que vous avez défini dans tinker

---

## 🔍 DÉPANNAGE

### Erreur 500
```bash
# Vérifier les logs
tail -50 storage/logs/laravel.log

# Vérifier les permissions
chmod -R 755 storage bootstrap/cache

# Recréer les caches
php artisan optimize:clear
php artisan optimize
```

### "Application key not set"
```bash
php artisan key:generate
php artisan config:cache
```

### Erreur de connexion DB
```bash
# Vérifier les credentials dans .env
nano .env

# Tester la connexion
php artisan tinker
>>> DB::connection()->getPdo();
```

### Page blanche
1. Vérifiez que Document Root = `public_html/public`
2. Vérifiez PHP version = 8.2 ou 8.3
3. Vérifiez les logs : `tail -50 storage/logs/laravel.log`

---

## 📞 BESOIN D'AIDE ?

Contactez-moi avec :
- Le message d'erreur exact
- Le contenu de `storage/logs/laravel.log` (dernières lignes)
- Capture d'écran de l'erreur

---

## 🎯 PROCHAINES ÉTAPES

Une fois en ligne :
1. ✅ Tester toutes les fonctionnalités principales
2. ✅ Nettoyer les données de test
3. ✅ Créer les vrais utilisateurs
4. ✅ Configurer les backups automatiques (hPanel)
5. ✅ Monitorer les logs pendant 24-48h

**Bon déploiement ! 🚀**
