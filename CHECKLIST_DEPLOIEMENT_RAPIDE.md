# ✅ Checklist de Déploiement Rapide - Hill Holding

## 📋 AVANT DE COMMENCER

### Sur votre machine Windows
- [ ] Git installé (vérifiez: `git --version`)
- [ ] Compte GitHub/GitLab créé
- [ ] Client SSH disponible (Git Bash, PuTTY, ou Windows Terminal)

### Sur Hostinger
- [ ] Accès SSH root: `ssh root@72.60.100.232`
- [ ] Accès HestiaCP: https://72.60.100.232:8083
- [ ] DNS du domaine `hill.holding.com` pointant vers `72.60.100.232`

---

## 🚀 DÉPLOIEMENT EN 3 PHASES

### PHASE 1️⃣ : PRÉPARATION LOCALE (10 min)

**1.1 Créer le repo GitHub**
```
1. Allez sur https://github.com/new
2. Nom: hill_holding
3. Privé ou Public (au choix)
4. NE PAS initialiser avec README
5. Créer le repo
6. Copiez l'URL (ex: https://github.com/username/hill_holding.git)
```

**1.2 Push le code**
```powershell
cd c:\laragon\www\hill_holding
.\deploy_git_init.ps1
# Suivez les instructions et entrez l'URL de votre repo
```

✅ **Résultat attendu**: Code sur GitHub/GitLab

---

### PHASE 2️⃣ : CONFIGURATION VPS (20 min)

**2.1 Connexion SSH**
```bash
ssh root@72.60.100.232
```

**2.2 Vérifier l'environnement**
```bash
php -v              # Doit être 8.x
composer --version
git --version
mysql --version
```

**2.3 Installer ce qui manque**

Si PHP < 8.3 :
```bash
apt update
apt install -y php8.3 php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring \
  php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath
```

Si Composer manquant :
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
```

**2.4 Créer le domaine dans HestiaCP**
```bash
v-add-web-domain admin hill.holding.com
v-add-letsencrypt-domain admin hill.holding.com
```

**2.5 Créer la base de données**
```bash
v-add-database admin hillholding hillholding $(openssl rand -base64 12)
v-list-database admin hillholding    # Noter le mot de passe !
```

✅ **Résultat attendu**: Domaine et base de données créés

---

### PHASE 3️⃣ : DÉPLOIEMENT LARAVEL (30 min)

**3.1 Naviguer et nettoyer**
```bash
cd /home/admin/web/hill.holding.com/public_html
rm -rf * .??*
```

**3.2 Cloner le projet**
```bash
# Remplacez par VOTRE URL de repo
git clone https://github.com/VOTRE_USERNAME/hill_holding.git .
```

Si repo privé :
```bash
git clone https://VOTRE_TOKEN@github.com/VOTRE_USERNAME/hill_holding.git .
```

**3.3 Installer les dépendances**
```bash
composer install --no-dev --optimize-autoloader
```

**3.4 Configurer .env**
```bash
cp .env.example .env
nano .env
```

Modifiez ces lignes :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hill.holding.com

DB_DATABASE=admin_hillholding
DB_USERNAME=admin_hillholding
DB_PASSWORD=LE_MOT_DE_PASSE_DE_LETAPE_2.5
```

Sauvegardez : `Ctrl+O`, `Enter`, `Ctrl+X`

**3.5 Configuration Laravel**
```bash
php artisan key:generate
php artisan storage:link
chown -R admin:admin /home/admin/web/hill.holding.com/public_html
chmod -R 755 storage bootstrap/cache
php artisan migrate --force
php artisan optimize
```

**3.6 Créer l'admin**
```bash
php artisan tinker
```

Dans tinker :
```php
$admin = new App\Models\User();
$admin->name = 'Super Admin';
$admin->email = 'admin@hill.holding.com';
$admin->password = bcrypt('VotreMotDePasse123!');
$admin->email_verified_at = now();
$admin->save();
$admin->assignRole('super_admin');
exit
```

**3.7 Cron pour Laravel Scheduler**
```bash
crontab -e -u admin
```

Ajoutez :
```
* * * * * cd /home/admin/web/hill.holding.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

✅ **Résultat attendu**: Application fonctionnelle

---

## 🎯 VÉRIFICATION FINALE

### Accédez à votre site
```
https://hill.holding.com
```

### Connectez-vous
- Email: `admin@hill.holding.com`
- Mot de passe: celui que vous avez défini

### Tests essentiels
- [ ] Page d'accueil s'affiche
- [ ] Connexion admin fonctionne
- [ ] Dashboard s'affiche
- [ ] Menu de navigation fonctionne
- [ ] HTTPS actif (cadenas vert)

---

## 🆘 EN CAS DE PROBLÈME

### Erreur 500
```bash
tail -50 /home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log
```

### Erreur 502
```bash
systemctl restart php8.3-fpm nginx
```

### Erreur de DB
```bash
# Vérifier les credentials
cat .env | grep DB_

# Tester la connexion
mysql -u admin_hillholding -p admin_hillholding
```

### Page blanche
```bash
# Vérifier les permissions
chown -R admin:admin /home/admin/web/hill.holding.com/public_html
chmod -R 755 storage bootstrap/cache

# Recréer les caches
php artisan optimize:clear
php artisan optimize
```

---

## 📞 SUPPORT

- Guide détaillé : `DEPLOIEMENT_VPS_HESTIA.md`
- Logs Laravel : `/home/admin/web/hill.holding.com/public_html/storage/logs/laravel.log`
- Logs Nginx : `/home/admin/web/hill.holding.com/logs/error.log`

---

## ⏱️ TEMPS ESTIMÉ TOTAL : 60 min

- Phase 1 : 10 min
- Phase 2 : 20 min
- Phase 3 : 30 min

**Bonne chance ! 🚀**
