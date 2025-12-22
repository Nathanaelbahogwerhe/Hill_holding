# 🚀 Commandes de Déploiement VPS - À exécuter dans l'ordre

**Vous êtes connecté en SSH à : root@srv1191613**

---

## ÉTAPE 1 : Vérifier l'environnement (2 min)

```bash
# Vérifier PHP
php -v

# Vérifier Composer
composer --version

# Vérifier Git
git --version

# Vérifier MySQL
mysql --version

# Vérifier Nginx
nginx -v
```

---

## ÉTAPE 2 : Installer ce qui manque (5-10 min)

### Si PHP < 8.3 ou manquant
```bash
apt update
apt install -y software-properties-common
add-apt-repository -y ppa:ondrej/php
apt update
apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring \
  php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath \
  php8.3-soap php8.3-redis php8.3-tokenizer php8.3-ctype php8.3-fileinfo
```

### Si Composer manquant
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
composer --version
```

### Si Git manquant
```bash
apt install -y git
```

---

## ÉTAPE 3 : Créer le domaine dans HestiaCP (2 min)

```bash
# Créer le domaine avec SSL
v-add-web-domain admin hill.holding.com

# Activer Let's Encrypt SSL
v-add-letsencrypt-domain admin hill.holding.com
```

**OU via interface web :**
1. Ouvrez https://72.60.100.232:8083
2. WEB → Add Web Domain
3. Domain: hill.holding.com
4. Cochez "Enable SSL" et "Enable Let's Encrypt"

---

## ÉTAPE 4 : Créer la base de données (1 min)

```bash
# Créer la base avec un mot de passe aléatoire sécurisé
v-add-database admin hillholding hillholding $(openssl rand -base64 16)

# Afficher les credentials (NOTEZ LE MOT DE PASSE !)
v-list-database admin hillholding
```

**Copiez le mot de passe affiché !** Vous en aurez besoin à l'étape 8.

---

## ÉTAPE 5 : Naviguer vers le répertoire web (1 min)

```bash
# Aller dans le dossier du domaine
cd /home/admin/web/hill.holding.com/public_html

# Supprimer le contenu par défaut
rm -rf * .??*

# Vérifier qu'on est au bon endroit
pwd
```

---

## ÉTAPE 6 : Cloner votre projet GitHub (2 min)

```bash
# Cloner le projet
git clone https://github.com/Nathanaelbahogwerhe/Hill_holding_Company.git .

# Vérifier que les fichiers sont là
ls -la
```

**Si erreur d'authentification (repo privé) :**
```bash
# Méthode 1 : Avec token GitHub
git clone https://VOTRE_TOKEN@github.com/Nathanaelbahogwerhe/Hill_holding_Company.git .

# Méthode 2 : Configurer SSH (si clé SSH configurée sur GitHub)
git clone git@github.com:Nathanaelbahogwerhe/Hill_holding_Company.git .
```

---

## ÉTAPE 7 : Installer les dépendances Composer (3-5 min)

```bash
# Installer les packages Laravel
composer install --no-dev --optimize-autoloader --no-interaction

# Si erreur de mémoire, augmentez la limite
php -d memory_limit=512M /usr/local/bin/composer install --no-dev --optimize-autoloader
```

---

## ÉTAPE 8 : Configurer le fichier .env (3 min)

```bash
# Copier le template
cp .env.example .env

# Éditer le fichier
nano .env
```

**Modifiez ces lignes** (utilisez les flèches ↑↓ pour naviguer) :

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
DB_PASSWORD=LE_MOT_DE_PASSE_DE_LETAPE_4

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

**Sauvegarder :**
- Appuyez sur `Ctrl+O` (Write Out)
- Appuyez sur `Enter`
- Appuyez sur `Ctrl+X` (Exit)

---

## ÉTAPE 9 : Configuration Laravel (5 min)

```bash
# Générer la clé de l'application
php artisan key:generate

# Créer le lien symbolique pour le storage
php artisan storage:link

# Définir les bonnes permissions
chown -R admin:admin /home/admin/web/hill.holding.com/public_html
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage

# Exécuter les migrations
php artisan migrate --force

# Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## ÉTAPE 10 : Créer l'utilisateur administrateur (2 min)

```bash
# Lancer Tinker
php artisan tinker
```

**Dans Tinker, copiez-collez ces lignes une par une :**

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

## ÉTAPE 11 : Configurer le Cron pour Laravel Scheduler (2 min)

```bash
# Éditer le crontab de l'utilisateur admin
crontab -e -u admin
```

Si demandé, choisissez l'éditeur `nano` (option 1 généralement).

**Ajoutez cette ligne à la fin :**
```
* * * * * cd /home/admin/web/hill.holding.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Sauvegarder :**
- `Ctrl+O`, `Enter`, `Ctrl+X`

---

## ÉTAPE 12 : Vérifier que tout fonctionne (1 min)

```bash
# Tester les logs
tail -20 storage/logs/laravel.log

# Vérifier les permissions
ls -la storage/

# Redémarrer les services
systemctl restart nginx
systemctl restart php8.3-fpm
```

---

## ✅ ÉTAPE 13 : Tester le site !

Ouvrez votre navigateur et allez sur :

**https://hill.holding.com**

**Connectez-vous avec :**
- Email : `admin@hill.holding.com`
- Mot de passe : `VotreMotDePasseSecure123!` (celui que vous avez mis)

---

## 🆘 EN CAS DE PROBLÈME

### Voir les logs Laravel
```bash
tail -50 /home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log
```

### Voir les logs Nginx
```bash
tail -50 /home/admin/web/hill.holding.com/logs/error.log
```

### Erreur 500
```bash
# Vérifier les permissions
chmod -R 755 storage bootstrap/cache
chown -R admin:admin /home/admin/web/hill.holding.com/public_html

# Nettoyer les caches
php artisan optimize:clear
php artisan optimize
```

### Erreur 502
```bash
systemctl status php8.3-fpm
systemctl restart php8.3-fpm nginx
```

### Tester la connexion à la DB
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

---

## 📊 Commandes utiles pour plus tard

### Mettre à jour le projet
```bash
cd /home/admin/web/hill.holding.com/public_html
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize:clear
php artisan optimize
systemctl restart nginx php8.3-fpm
```

### Backup de la base de données
```bash
mysqldump -u admin_hillholding -p admin_hillholding > ~/backup_$(date +%Y%m%d_%H%M%S).sql
```

### Voir l'espace disque
```bash
df -h
```

### Monitoring en temps réel
```bash
htop
```

---

**Bon déploiement ! 🚀**

Copiez-collez ces commandes une par une dans votre terminal SSH.
