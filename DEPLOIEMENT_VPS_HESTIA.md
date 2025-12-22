# 🚀 Déploiement Hill Holding - VPS Ubuntu 24.04 + HestiaCP

## 📋 INFORMATIONS VPS

```
Hostname:     srv1191613.hstgr.cloud
IP:           72.60.100.232
OS:           Ubuntu 24.04
Panel:        HestiaCP
SSH User:     root
Domain:       hill.holding.com
Location:     Mumbai, India
```

---

## 🎯 AVANT DE COMMENCER

### 1. Créer un repo Git (GitHub/GitLab)
- Créez un nouveau repo sur GitHub ou GitLab
- Peut être privé ou public
- Notez l'URL du repo

### 2. Accès HestiaCP
- URL: `https://srv1191613.hstgr.cloud:8083` ou `https://72.60.100.232:8083`
- Username: root (ou admin si configuré)
- Mot de passe: celui que vous avez reçu

---

## 📦 DÉPLOIEMENT EN 12 ÉTAPES

### ÉTAPE 1 : Connexion SSH

```bash
ssh root@72.60.100.232
```

Ou avec le hostname :
```bash
ssh root@srv1191613.hstgr.cloud
```

---

### ÉTAPE 2 : Vérifier/Installer PHP 8.3

```bash
# Vérifier la version PHP
php -v

# Si PHP 8.3 n'est pas installé
apt update
apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring \
  php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-intl \
  php8.3-bcmath php8.3-soap php8.3-redis
```

---

### ÉTAPE 3 : Installer Composer

```bash
# Vérifier si Composer existe
composer --version

# Si pas installé
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
composer --version
```

---

### ÉTAPE 4 : Installer Git (si pas déjà installé)

```bash
git --version
# Si pas installé
apt install -y git
```

---

### ÉTAPE 5 : Créer le domaine dans HestiaCP

**Option A : Via interface web**
1. Allez sur `https://72.60.100.232:8083`
2. Connectez-vous avec root
3. **WEB** → **Add Web Domain**
4. Domain: `hill.holding.com`
5. Cochez "Enable SSL" et "Enable Let's Encrypt"
6. Créez

**Option B : Via CLI (plus rapide)**
```bash
v-add-web-domain admin hill.holding.com
v-add-letsencrypt-domain admin hill.holding.com
```

---

### ÉTAPE 6 : Créer la base de données MySQL

**Via HestiaCP CLI :**
```bash
# Créer la base de données
v-add-database admin hillholding hillholding $(openssl rand -base64 12)

# Voir les credentials
v-list-database admin hillholding
```

Notez le mot de passe généré !

**Ou via interface web :**
1. HestiaCP → **DB** → **Add Database**
2. Database: `hillholding`
3. User: `hillholding`
4. Password: (générez-en un fort)

---

### ÉTAPE 7 : Naviguer vers le répertoire web

```bash
cd /home/admin/web/hill.holding.com/public_html
rm -rf * .??*
```

---

### ÉTAPE 8 : Cloner le projet

```bash
# Cloner depuis votre repo
git clone https://github.com/VOTRE_USERNAME/hill_holding.git .

# OU si repo privé avec token
git clone https://VOTRE_TOKEN@github.com/VOTRE_USERNAME/hill_holding.git .
```

---

### ÉTAPE 9 : Installer les dépendances

```bash
composer install --no-dev --optimize-autoloader
```

---

### ÉTAPE 10 : Configurer .env

```bash
cp .env.example .env
nano .env
```

**Modifiez ces valeurs** :

```env
APP_NAME="Hill Holding"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hill.holding.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=admin_hillholding
DB_USERNAME=admin_hillholding
DB_PASSWORD=LE_MOT_DE_PASSE_GENERE

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@hill.holding.com
MAIL_PASSWORD=VOTRE_MOT_DE_PASSE_EMAIL
MAIL_FROM_ADDRESS="contact@hill.holding.com"
```

Sauvegardez : `Ctrl+O` puis `Enter`, Quittez : `Ctrl+X`

---

### ÉTAPE 11 : Configuration Laravel

```bash
# Générer la clé
php artisan key:generate

# Storage link
php artisan storage:link

# Permissions
chown -R admin:admin /home/admin/web/hill.holding.com/public_html
chmod -R 755 storage bootstrap/cache

# Migrations
php artisan migrate --force

# Caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

### ÉTAPE 12 : Configurer Nginx pour Laravel

HestiaCP configure déjà Nginx, mais nous devons ajuster pour Laravel.

**Créer un template Nginx personnalisé :**

```bash
nano /home/admin/conf/web/hill.holding.com/nginx.conf_laravel
```

Collez ce contenu :

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}

location ~ /\.(?!well-known).* {
    deny all;
}
```

**Ou utilisez la commande HestiaCP pour appliquer :**

```bash
# Configurer le proxy Nginx
v-change-web-domain-proxy-tpl admin hill.holding.com default

# Redémarrer Nginx
systemctl restart nginx
```

---

### ÉTAPE 13 : Créer l'admin

```bash
php artisan tinker
```

Dans tinker :
```php
$admin = new App\Models\User();
$admin->name = 'Super Admin';
$admin->email = 'admin@hill.holding.com';
$admin->password = bcrypt('VotreMotDePasseSecure123!');
$admin->email_verified_at = now();
$admin->save();
$admin->assignRole('super_admin');
exit
```

---

### ÉTAPE 14 : Configurer le Cron (Laravel Scheduler)

```bash
# Éditer le crontab pour l'utilisateur admin
crontab -e -u admin
```

Ajoutez cette ligne :
```
* * * * * cd /home/admin/web/hill.holding.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

---

### ÉTAPE 15 : Vérifier les DNS

Assurez-vous que votre domaine `hill.holding.com` pointe vers `72.60.100.232`

**Records DNS à créer chez votre registrar :**
```
Type A:     hill.holding.com    →  72.60.100.232
Type CNAME: www.hill.holding.com →  hill.holding.com
```

---

## ✅ VÉRIFICATION

Allez sur : **https://hill.holding.com**

Testez la connexion :
- Email: `admin@hill.holding.com`
- Mot de passe: celui que vous avez défini

---

## 🔧 COMMANDES UTILES

### Voir les logs Laravel
```bash
tail -f /home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log
```

### Voir les logs Nginx
```bash
tail -f /home/admin/web/hill.holding.com/logs/error.log
```

### Mettre à jour le projet
```bash
cd /home/admin/web/hill.holding.com/public_html
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
```

### Redémarrer les services
```bash
systemctl restart nginx
systemctl restart php8.3-fpm
systemctl restart mysql
```

### Backup de la base de données
```bash
mysqldump -u admin_hillholding -p admin_hillholding > backup_$(date +%Y%m%d).sql
```

---

## 🆘 DÉPANNAGE

### Erreur 500
```bash
# Vérifier les logs
tail -50 /home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log

# Vérifier les permissions
chown -R admin:admin /home/admin/web/hill.holding.com/public_html
chmod -R 755 storage bootstrap/cache
```

### Erreur 502 Bad Gateway
```bash
# Vérifier PHP-FPM
systemctl status php8.3-fpm
systemctl restart php8.3-fpm
```

### Erreur de connexion DB
```bash
# Tester la connexion MySQL
mysql -u admin_hillholding -p admin_hillholding

# Vérifier les credentials dans .env
nano /home/admin/web/hill.holding.com/public_html/.env
```

### Page blanche
```bash
# Activer le mode debug temporairement
nano .env
# Changez APP_DEBUG=true
# Rechargez la page pour voir l'erreur
# N'oubliez pas de remettre APP_DEBUG=false après !
```

---

## 🔒 SÉCURITÉ POST-DÉPLOIEMENT

### 1. Configurer le Firewall
```bash
# Si UFW n'est pas activé
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw allow 8083/tcp  # HestiaCP
ufw enable
```

### 2. Désactiver l'accès root direct (optionnel)
Créez un utilisateur admin et désactivez l'accès SSH root après configuration.

### 3. Backups automatiques
HestiaCP a un système de backup intégré. Configurez-le dans le panel.

---

## 📊 MONITORING

### Vérifier l'utilisation des ressources
```bash
# CPU et RAM
htop

# Espace disque
df -h

# Logs en temps réel
tail -f /home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log
```

---

## 🎯 PROCHAINES ÉTAPES

Après déploiement :
1. ✅ Tester toutes les fonctionnalités
2. ✅ Nettoyer les données de test
3. ✅ Créer les utilisateurs réels
4. ✅ Configurer les backups automatiques
5. ✅ Monitorer pendant 48h
6. ✅ Former les utilisateurs finaux

---

**Bon déploiement ! 🚀**
