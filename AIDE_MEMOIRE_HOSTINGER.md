# ⚡ AIDE-MÉMOIRE DÉPLOIEMENT HOSTINGER

## 🔌 CONNEXION SSH
```bash
ssh u123456789@votredomaine.com -p 65002
cd domains/votredomaine.com/public_html
```

## 🚀 DÉPLOIEMENT EN 6 COMMANDES
```bash
# 1. Cloner
git clone https://github.com/votre-repo/hill_holding.git .

# 2. Dépendances
composer install --no-dev --optimize-autoloader

# 3. Configuration
cp .env.example .env && nano .env
# Éditer: DB_*, APP_URL, MAIL_*

# 4. Laravel
php artisan key:generate && \
php artisan storage:link && \
php artisan migrate --force && \
php artisan optimize

# 5. Permissions
chmod -R 755 storage bootstrap/cache

# 6. Créer admin
php artisan tinker
# (voir section Créer Admin ci-dessous)
```

## 👤 CRÉER ADMIN (dans tinker)
```php
use App\Models\User;
use Spatie\Permission\Models\Role;

$role = Role::firstOrCreate(['name' => 'Super Admin']);
$admin = User::create([
    'name' => 'Super Admin',
    'email' => 'admin@votredomaine.com',
    'password' => bcrypt('VotreMotDePasse123!'),
    'email_verified_at' => now()
]);
$admin->assignRole('Super Admin');
echo "✓ Admin créé !";
exit;
```

## 📧 .env HOSTINGER (ESSENTIEL)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votredomaine.com

DB_HOST=localhost
DB_DATABASE=u123456789_hillholding
DB_USERNAME=u123456789_hilluser
DB_PASSWORD=VotreMotDePasseDB

MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@votredomaine.com
MAIL_PASSWORD=VotreMotDePasseEmail
MAIL_ENCRYPTION=tls

SESSION_DRIVER=database
QUEUE_CONNECTION=database
```

## 🔄 MISE À JOUR
```bash
php artisan down && \
git pull origin main && \
composer install --no-dev && \
php artisan migrate --force && \
php artisan optimize && \
php artisan up
```

## 🧹 DÉPANNAGE RAPIDE
```bash
# Erreur 500
php artisan optimize:clear && \
chmod -R 755 storage bootstrap/cache

# Vider tout
php artisan optimize:clear

# Recacher tout
php artisan optimize

# Voir logs
tail -50 storage/logs/laravel.log
```

## ⚙️ CONFIGURATION hPanel

### PHP 8.3
hPanel → Hébergement → Configuration PHP → Version: 8.3

### Document Root
hPanel → Domaines → Votre domaine → Document Root: `/public_html/public`

### SSL
hPanel → Sécurité → SSL → Let's Encrypt (gratuit) → Forcer HTTPS

### Base de données
hPanel → Bases de données → Créer:
- Nom: u123456789_hillholding
- User: u123456789_hilluser
- Copier identifiants dans .env

### Cron Job (Laravel Scheduler)
hPanel → Avancé → Tâches Cron → Ajouter:
```
* * * * * cd /home/u123456789/domains/votredomaine.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

## 📋 CHECKLIST POST-DÉPLOIEMENT
- [ ] Site accessible en HTTPS
- [ ] Login admin fonctionne
- [ ] Assets chargent (CSS/JS)
- [ ] Upload fichier marche
- [ ] Email de test reçu
- [ ] SSL actif (cadenas vert)
- [ ] Cron job configuré

## 📞 SUPPORT
**Hostinger:** https://support.hostinger.com (Chat 24/7)

## 📚 DOCUMENTATION COMPLÈTE
- Guide complet: [DEPLOIEMENT_HOSTINGER.md](DEPLOIEMENT_HOSTINGER.md)
- Checklist: [CHECKLIST_HOSTINGER.md](CHECKLIST_HOSTINGER.md)
- Commandes: [COMMANDES_HOSTINGER.md](COMMANDES_HOSTINGER.md)

---
**⏱️ Temps total: 1-2 heures** | **Version: 1.0** | **22/12/2025**
