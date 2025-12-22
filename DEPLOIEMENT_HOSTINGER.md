# 🚀 GUIDE DE DÉPLOIEMENT HOSTINGER - HILL HOLDING

**Date:** 22 Décembre 2025  
**Plateforme:** Hostinger  
**Temps estimé:** 1-2 heures

---

## 📋 PRÉREQUIS

### Ce dont vous avez besoin :
- ✅ Compte Hostinger actif (Business ou Cloud recommandé)
- ✅ Nom de domaine configuré
- ✅ Accès au hPanel (panneau de contrôle Hostinger)
- ✅ Accès SSH activé (vérifier dans hPanel)
- ✅ Fichiers du projet prêts

### Plans Hostinger recommandés :
- **Business Hosting** - Bon pour démarrer
- **Cloud Startup** - Performance optimale (recommandé)
- **VPS** - Maximum de contrôle

---

## 🎯 MÉTHODE 1 : DÉPLOIEMENT VIA GIT (RECOMMANDÉ)

### Étape 1 : Préparer le projet localement

```bash
# Dans votre terminal local
cd C:\laragon\www\hill_holding

# Créer un fichier .gitignore s'il n'existe pas
echo "node_modules/
vendor/
.env
storage/*.key
.phpunit.result.cache" > .gitignore

# Initialiser Git (si pas déjà fait)
git init
git add .
git commit -m "Initial commit for deployment"

# Créer un repo sur GitHub/GitLab/Bitbucket
# Puis pusher
git remote add origin votre_repo_url
git push -u origin main
```

### Étape 2 : Se connecter en SSH à Hostinger

```bash
# Ouvrir terminal/PowerShell
ssh u123456789@votredomaine.com -p 65002

# Remplacer :
# - u123456789 : votre username Hostinger (visible dans hPanel)
# - votredomaine.com : votre domaine
# - 65002 : port SSH (vérifier dans hPanel)
```

**Trouver vos identifiants SSH :**
1. Connexion hPanel → Hébergement → Avancé
2. Section "Accès SSH"
3. Noter : Username, Server IP, Port

### Étape 3 : Cloner le projet sur Hostinger

```bash
# Une fois connecté en SSH
cd domains/votredomaine.com

# Cloner le repo (choisir une option)

# Option A : Repo public
git clone https://github.com/votre-username/hill_holding.git public_html

# Option B : Repo privé (nécessite token/clé SSH)
git clone https://votre-token@github.com/votre-username/hill_holding.git public_html

# Entrer dans le dossier
cd public_html
```

### Étape 4 : Configuration PHP et Composer

```bash
# Vérifier version PHP (doit être 8.2+)
php -v

# Si version < 8.2, changer dans hPanel :
# hPanel → Hébergement → Configuration PHP → Sélectionner PHP 8.3

# Installer Composer s'il n'est pas disponible
curl -sS https://getcomposer.org/installer | php
mv composer.phar composer

# Installer les dépendances (sans dev)
./composer install --no-dev --optimize-autoloader

# OU si composer est global :
composer install --no-dev --optimize-autoloader
```

### Étape 5 : Configurer l'environnement

```bash
# Copier .env.example
cp .env.example .env

# Éditer .env avec nano
nano .env
```

**Configuration .env pour Hostinger :**
```env
APP_NAME="HillHolding"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://votredomaine.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Base de données MySQL Hostinger
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_hillholding
DB_USERNAME=u123456789_hilluser
DB_PASSWORD=VotreMotDePasseMySQL

# Cache
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail (utiliser SMTP Hostinger ou externe)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@votredomaine.com
MAIL_PASSWORD=VotreMotDePasseEmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@votredomaine.com
MAIL_FROM_NAME="HillHolding"
```

**Sauvegarder dans nano :** `Ctrl+X` → `Y` → `Enter`

### Étape 6 : Créer la base de données MySQL

**Via hPanel (plus facile) :**
1. hPanel → Bases de données → Gestion
2. Créer nouvelle base de données :
   - Nom : `u123456789_hillholding`
   - Utilisateur : `u123456789_hilluser`
   - Mot de passe : `MotDePasseSecurise123!`
3. Noter les identifiants

**OU via phpMyAdmin :**
1. hPanel → Bases de données → phpMyAdmin
2. Onglet SQL, exécuter :
```sql
CREATE DATABASE u123456789_hillholding CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Étape 7 : Configurer Laravel

```bash
# Générer clé application
php artisan key:generate

# Créer lien storage
php artisan storage:link

# Exécuter les migrations
php artisan migrate --force

# Optimiser pour production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Étape 8 : Créer l'utilisateur admin initial

```bash
php artisan tinker
```

**Dans tinker :**
```php
use App\Models\User;
use Spatie\Permission\Models\Role;

// Créer le rôle Super Admin
$role = Role::firstOrCreate(['name' => 'Super Admin']);

// Créer l'utilisateur
$admin = User::create([
    'name' => 'Super Admin',
    'email' => 'admin@votredomaine.com',
    'password' => bcrypt('MotDePasseAdmin123!'),
    'email_verified_at' => now()
]);

// Assigner le rôle
$admin->assignRole('Super Admin');

echo "✓ Admin créé avec succès !";
echo "\nEmail: admin@votredomaine.com";
echo "\nPassword: MotDePasseAdmin123!";
exit;
```

### Étape 9 : Configurer les permissions

```bash
# Définir les bonnes permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

### Étape 10 : Compiler les assets (optionnel)

**Si vous avez Node.js sur le serveur :**
```bash
npm install
npm run build
```

**Sinon, compiler en local et uploader :**
```bash
# En local (Windows)
cd C:\laragon\www\hill_holding
npm run build

# Puis uploader le dossier public/build via FTP
```

---

## 🎯 MÉTHODE 2 : DÉPLOIEMENT VIA FTP/SFTP

### Étape 1 : Préparer les fichiers en local

```bash
# Dans PowerShell
cd C:\laragon\www\hill_holding

# Compiler les assets
npm run build

# Créer archive sans node_modules et vendor
# (ils seront réinstallés sur le serveur)
```

### Étape 2 : Se connecter via FileZilla

**Identifiants FTP Hostinger :**
1. hPanel → Fichiers → Gestionnaire de fichiers → Compte FTP
2. Noter : Host, Username, Password, Port

**Connexion FileZilla :**
- Protocole : SFTP
- Hôte : votredomaine.com
- Port : 65002
- Username : u123456789
- Password : votre_mot_de_passe

### Étape 3 : Uploader les fichiers

**Structure sur Hostinger :**
```
/domains/votredomaine.com/public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/        ← Racine web
├── resources/
├── routes/
├── storage/
├── vendor/        ← À créer via Composer
├── .env
└── artisan
```

**⚠️ IMPORTANT :** 
- Uploader TOUT sauf `node_modules/` et `vendor/`
- Copier `.env.example` vers `.env` et éditer en ligne

### Étape 4 : Installer Composer et dépendances

```bash
# Via SSH
cd domains/votredomaine.com/public_html
composer install --no-dev --optimize-autoloader
```

### Étape 5 : Suivre étapes 6-10 de la Méthode 1

---

## 🔧 CONFIGURATION HOSTINGER SPÉCIFIQUE

### A. Pointer le domaine vers public/

**Par défaut, Hostinger pointe vers `public_html/`**

**Option 1 : Modifier dans hPanel (recommandé)**
1. hPanel → Domaines → Gérer
2. Cliquer sur votre domaine
3. Section "Répertoire document"
4. Changer de `/public_html` vers `/public_html/public`
5. Sauvegarder

**Option 2 : Utiliser .htaccess (alternative)**

Créer `.htaccess` dans `/public_html/` :
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### B. Configurer PHP (hPanel)

1. hPanel → Hébergement → Configuration PHP
2. **Version PHP :** 8.3 (recommandé)
3. **Extensions à activer :**
   - ✅ bcmath
   - ✅ ctype
   - ✅ fileinfo
   - ✅ json
   - ✅ mbstring
   - ✅ openssl
   - ✅ pdo_mysql
   - ✅ tokenizer
   - ✅ xml
   - ✅ gd

4. **Limites à augmenter :**
   - `memory_limit` : 256M
   - `upload_max_filesize` : 20M
   - `post_max_size` : 20M
   - `max_execution_time` : 300

### C. Configurer le Cron Job (pour queue:work)

**Via hPanel :**
1. hPanel → Avancé → Tâches Cron
2. Ajouter nouveau cron :
   - **Fréquence :** Chaque minute
   - **Commande :**
   ```bash
   cd /home/u123456789/domains/votredomaine.com/public_html && php artisan schedule:run >> /dev/null 2>&1
   ```

**Pour queue worker (optionnel) :**
```bash
cd /home/u123456789/domains/votredomaine.com/public_html && php artisan queue:work --tries=3 --timeout=60
```

### D. Activer SSL (Let's Encrypt)

**Via hPanel (gratuit) :**
1. hPanel → Sécurité → SSL
2. Cliquer sur "Installer SSL"
3. Sélectionner "Let's Encrypt (gratuit)"
4. Confirmer l'installation
5. Activer "Forcer HTTPS"

---

## 📧 CONFIGURATION EMAIL HOSTINGER

### Créer un email

1. hPanel → Emails → Comptes email
2. Créer : `contact@votredomaine.com`
3. Noter le mot de passe

### Configuration .env

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@votredomaine.com
MAIL_PASSWORD=VotreMotDePasseEmail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@votredomaine.com
MAIL_FROM_NAME="HillHolding"
```

**Tester l'envoi :**
```bash
php artisan tinker
```
```php
Mail::raw('Test email', function($message) {
    $message->to('votre@email.com')->subject('Test Hostinger');
});
exit;
```

---

## 🔒 SÉCURITÉ HOSTINGER

### 1. Protéger .env

Créer `.htaccess` dans `/public_html/` :
```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

### 2. Désactiver liste des fichiers

Ajouter dans `.htaccess` :
```apache
Options -Indexes
```

### 3. Bloquer accès aux fichiers sensibles

```apache
<FilesMatch "\.(env|log|sql|md)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 4. Configurer pare-feu (hPanel)

1. hPanel → Sécurité → Cloudflare
2. Activer protection DDOS
3. Configurer règles WAF

---

## 🚀 MISE À JOUR DU PROJET

### Via Git (recommandé)

```bash
# SSH vers serveur
ssh u123456789@votredomaine.com -p 65002

# Aller dans le dossier
cd domains/votredomaine.com/public_html

# Mode maintenance
php artisan down

# Récupérer dernières modifications
git pull origin main

# Mettre à jour dépendances
composer install --no-dev --optimize-autoloader

# Migrer base de données
php artisan migrate --force

# Vider caches
php artisan optimize:clear

# Recacher
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Sortir de maintenance
php artisan up
```

### Via FTP (alternative)

1. Mettre en maintenance : Créer `storage/framework/down`
2. Uploader fichiers modifiés
3. Exécuter commandes via SSH
4. Supprimer fichier de maintenance

---

## 🐛 RÉSOLUTION DE PROBLÈMES

### Erreur 500 - Internal Server Error

**Causes communes :**
```bash
# 1. Vérifier les logs
cat storage/logs/laravel.log | tail -50

# 2. Vérifier permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs

# 3. Régénérer clé
php artisan key:generate

# 4. Vider tous les caches
php artisan optimize:clear
```

### Erreur : Class not found

```bash
composer dump-autoload
php artisan optimize:clear
```

### Erreur : SQLSTATE Connection refused

**Vérifier .env :**
- `DB_HOST` doit être `localhost` (pas 127.0.0.1)
- Vérifier nom base de données et user
- Tester connexion MySQL via phpMyAdmin

### Assets (CSS/JS) non chargés

**Solutions :**
```bash
# 1. Vérifier APP_URL dans .env
APP_URL=https://votredomaine.com

# 2. Recompiler assets
npm run build

# 3. Vérifier permissions public/build
chmod -R 755 public/build

# 4. Vider cache navigateur
```

### Erreur "Too many redirects"

**Dans .env :**
```env
SESSION_SECURE_COOKIE=true
```

**Ajouter dans `public/.htaccess` :**
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST%}/$1 [L,R=301]
```

---

## 📊 MONITORING ET MAINTENANCE

### Logs à surveiller

```bash
# Logs Laravel
tail -f storage/logs/laravel.log

# Logs erreurs PHP (via hPanel)
# hPanel → Fichiers → Gestionnaire → domains/votredomaine.com/logs/
```

### Backup automatique

**Via hPanel :**
1. hPanel → Fichiers → Backups
2. Activer backups automatiques (quotidiens)
3. Télécharger backups manuellement si besoin

**Backup base de données :**
```bash
# Via SSH
mysqldump -u u123456789_hilluser -p u123456789_hillholding > backup_$(date +%Y%m%d).sql
```

### Optimisation base de données

```bash
php artisan optimize:clear
php artisan db:seed --class=OptimizeDatabaseSeeder
```

---

## ✅ CHECKLIST POST-DÉPLOIEMENT

- [ ] Site accessible via HTTPS
- [ ] Page d'accueil charge correctement
- [ ] Connexion admin fonctionne
- [ ] Upload fichiers fonctionne
- [ ] Emails s'envoient
- [ ] Base de données connectée
- [ ] Toutes les pages principales testées
- [ ] SSL actif (cadenas vert)
- [ ] Backup automatique configuré
- [ ] Cron jobs actifs
- [ ] Logs accessibles

---

## 📞 SUPPORT HOSTINGER

**Besoin d'aide ?**
- 🌐 Support : https://support.hostinger.com
- 💬 Chat en direct : 24/7
- 📧 Tickets : Via hPanel
- 📚 Base de connaissances : https://support.hostinger.com/fr/

---

## 🎯 RÉCAPITULATIF RAPIDE

```bash
# 1. Connexion SSH
ssh u123456789@votredomaine.com -p 65002

# 2. Cloner projet
cd domains/votredomaine.com
git clone votre_repo.git public_html

# 3. Configuration
cd public_html
composer install --no-dev
cp .env.example .env
nano .env  # Éditer configuration

# 4. Laravel
php artisan key:generate
php artisan storage:link
php artisan migrate --force
php artisan optimize

# 5. Créer admin
php artisan tinker
# ... code admin ...

# 6. Tester
https://votredomaine.com
```

**Temps total : 1-2 heures**

---

**🎊 Votre application Hill Holding est maintenant en ligne sur Hostinger !**

*Conservez ce guide pour les futures mises à jour.*
