# 📦 INFORMATIONS PROJET - HILL HOLDING

**Date de préparation :** 22 Décembre 2025  
**Version Laravel :** 12.41.1  
**Version PHP requise :** 8.2+ (8.3 recommandé)

---

## 📊 STRUCTURE DU PROJET

### Base de données
- **95 migrations** à exécuter
- **60+ tables** créées
- **Système multi-tenant** : Hill Holdings → Filiales → Agences → Départements

### Modules principaux
1. **RH** (Ressources Humaines)
   - Employees, Positions, Contracts
   - Leaves, Attendances, Payrolls
   - Insurance plans

2. **Finance**
   - Budgets avec tracking
   - Expenses/Revenues par catégories
   - Invoices et client payments
   - Financial reports

3. **Projets & Activités**
   - Projects avec hiérarchie
   - Tasks avec assignations
   - Activities avec planification multi-mois
   - Daily operations et évaluations

4. **Logistique**
   - Gestion stocks et inventaire
   - Purchase requests/orders
   - Equipment et maintenance
   - Vehicles et missions
   - Suppliers et contrats

5. **IT**
   - IT Equipment
   - Software licenses
   - IT Interventions

6. **Système**
   - Activity logs (audit)
   - System notifications
   - Backups automatiques
   - Reports et schedules

---

## 👥 SYSTÈME DE RÔLES

### 6 Rôles configurés (Spatie Permission)

1. **Super Admin**
   - Accès complet à tout le système
   - Gestion globale Hill Holdings
   - Tous modules et toutes filiales

2. **Admin Finance**
   - Module Finance complet
   - Budgets, dépenses, revenus
   - Rapports financiers

3. **Admin RH**
   - Module RH complet
   - Gestion employés, contrats
   - Congés, présences, paies

4. **Chef de Projet**
   - Module Projets
   - Création et gestion projets
   - Assignation tâches

5. **Responsable Filiale**
   - Vue filiale uniquement
   - Tous modules de sa filiale
   - Gestion agences sous sa filiale

6. **Responsable Agence**
   - Vue agence uniquement
   - Modules limités à son agence
   - Gestion départements

### 55 Permissions définies
- Voir liste dans : `database/seeders/RolePermissionSeeder.php`

---

## 🗄️ TABLES IMPORTANTES

### Tables système
- `users` - Utilisateurs
- `employees` - Données employés détaillées
- `roles` - Rôles Spatie
- `permissions` - Permissions Spatie
- `model_has_roles` - Pivot users-roles

### Tables hiérarchie
- `hill_holdings` - Niveau 0 (groupe)
- `filiales` - Niveau 1 (filiales)
- `agences` - Niveau 2 (agences)
- `departments` - Niveau 3 (départements)

### Tables principales modules
- `projects`, `tasks`, `activities`
- `budgets`, `expenses`, `revenues`
- `contracts`, `leaves`, `attendances`, `payrolls`
- `stocks`, `equipment`, `vehicles`
- `purchase_orders`, `suppliers`

---

## 🔐 CONFIGURATION SÉCURITÉ

### Variables .env critiques

```env
# PRODUCTION UNIQUEMENT
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votredomaine.com

# Session sécurisée
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true

# Queue (recommandé)
QUEUE_CONNECTION=database

# Logs (production)
LOG_CHANNEL=stack
LOG_LEVEL=error
```

### Fichiers à protéger
- `.env` - Credentials
- `storage/` - Fichiers uploadés
- `database/` - Migrations et seeders
- `.git/` - Historique

### Headers sécurité (automatiques Laravel)
- CSRF Protection
- XSS Protection
- SQL Injection Prevention

---

## 📁 STRUCTURE DOSSIERS HOSTINGER

### Après déploiement
```
/home/u123456789/domains/votredomaine.com/
├── public_html/              ← Racine projet
│   ├── app/
│   ├── bootstrap/
│   │   └── cache/           ← Writable
│   ├── config/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── public/              ← Racine web (configurer Document Root)
│   │   ├── build/           ← Assets compilés
│   │   ├── css/
│   │   ├── images/
│   │   ├── storage/         ← Lien symbolique
│   │   ├── .htaccess
│   │   └── index.php
│   ├── resources/
│   │   ├── css/
│   │   ├── js/
│   │   └── views/
│   ├── routes/
│   ├── storage/             ← Writable
│   │   ├── app/
│   │   │   └── public/      ← Uploads
│   │   ├── framework/
│   │   │   ├── cache/
│   │   │   ├── sessions/
│   │   │   └── views/
│   │   └── logs/            ← Logs Laravel
│   ├── vendor/              ← Via composer install
│   ├── .env                 ← Configuration
│   └── artisan
└── logs/                    ← Logs serveur Hostinger
```

---

## 🎨 ASSETS & FRONTEND

### Technologies utilisées
- **Tailwind CSS 3.1** - Styling
- **Alpine.js 3.15** - JavaScript interactif
- **Flowbite 3.1** - Composants UI
- **Vite 6.0** - Build tool
- **Chart.js** - Graphiques (via CDN)
- **Blade Heroicons** - Icônes

### Compilation
```bash
# Développement (en local)
npm run dev

# Production (avant déploiement)
npm run build
```

### Fichiers générés
- `public/build/assets/app-[hash].js`
- `public/build/assets/app-[hash].css`
- `public/build/manifest.json`

---

## 📧 CONFIGURATION EMAIL

### SMTP Hostinger
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=contact@votredomaine.com
MAIL_PASSWORD=VotreMotDePasse
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@votredomaine.com
MAIL_FROM_NAME="HillHolding"
```

### Emails utilisés dans l'app
- Reset password
- Notifications employés
- Alertes système
- Rapports automatiques

---

## 🔄 CRON JOBS REQUIS

### Laravel Scheduler (obligatoire)
```bash
* * * * * cd /home/u123456789/domains/votredomaine.com/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**Tâches automatiques :**
- Génération rapports quotidiens
- Nettoyage cache
- Notifications programmées

### Queue Worker (optionnel mais recommandé)
```bash
*/5 * * * * cd /home/u123456789/domains/votredomaine.com/public_html && php artisan queue:work --stop-when-empty
```

**Traite :**
- Envoi emails en arrière-plan
- Génération exports lourds
- Traitements asynchrones

---

## 💾 DONNÉES DE TEST ACTUELLES

### Utilisateurs (31)
- Super Admin
- Admins Finance (3)
- Admins RH (2)
- Test users (25+)

### Structure
- 3 Filiales (Rwanda, Burundi, RDC)
- 6 Agences
- 10 Départements

### Contenu
- 5 Projets
- 15 Activités (avec relations RH)
- 3 Employés complets

**⚠️ Note :** Ces données sont de TEST. À nettoyer avant production réelle.

---

## 🚀 COMMANDES APRÈS DÉPLOIEMENT

### Pour nettoyer données de test
```bash
# ⚠️ ATTENTION : Supprime TOUTES les données
php artisan migrate:fresh --force

# Puis recréer structure
php artisan migrate --force

# Créer nouvel admin (via tinker)
```

### Pour garder structure mais vider contenu
```sql
-- Via phpMyAdmin, exécuter pour chaque table de données
TRUNCATE TABLE activities;
TRUNCATE TABLE employees;
TRUNCATE TABLE projects;
-- etc.

-- Ne PAS truncate :
-- users (garder admin), roles, permissions
```

---

## 📈 PERFORMANCE

### Optimisations activées
- ✅ Config cached
- ✅ Routes cached
- ✅ Views cached
- ✅ Autoloader optimized
- ✅ Assets compilés (production)

### Recommandations Hostinger
- **Plan minimum :** Business Hosting
- **Plan recommandé :** Cloud Startup
- **RAM :** 2GB minimum
- **PHP :** 8.3 avec OPcache activé

---

## 🔧 EXTENSIONS PHP REQUISES

### Obligatoires
- [x] BCMath
- [x] Ctype
- [x] Fileinfo
- [x] JSON
- [x] Mbstring
- [x] OpenSSL
- [x] PDO
- [x] PDO_MySQL
- [x] Tokenizer
- [x] XML

### Recommandées
- [x] GD (manipulation images)
- [x] Zip (backups)
- [x] Curl (API externes)

**Toutes disponibles par défaut sur Hostinger PHP 8.3**

---

## 📞 SUPPORT & MAINTENANCE

### Logs à surveiller
1. **Laravel :** `storage/logs/laravel.log`
2. **Serveur :** Via hPanel → Fichiers → logs/
3. **PHP :** Via hPanel → Configuration PHP → Error logs

### Backups recommandés
- **Quotidien :** Base de données (MySQL)
- **Hebdomadaire :** Fichiers complets
- **Avant update :** Snapshot complet

### Mises à jour
```bash
# Via Git
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize
```

---

## ✅ CHECKLIST PRÉ-PRODUCTION

Avant de laisser les utilisateurs finaux accéder :

- [ ] Toutes données de test supprimées
- [ ] Utilisateurs réels créés avec bons rôles
- [ ] Filiales/Agences réelles configurées
- [ ] Emails fonctionnent (test reset password)
- [ ] SSL actif et forcé
- [ ] `APP_DEBUG=false` vérifié
- [ ] Backups automatiques actifs
- [ ] Documentation remise à l'équipe
- [ ] Formation utilisateurs effectuée
- [ ] Support disponible pour J+1

---

## 🎯 URLS IMPORTANTES

**Application :**
- Site : https://votredomaine.com
- Login : https://votredomaine.com/login
- Dashboard : https://votredomaine.com/dashboard

**Administration Hostinger :**
- hPanel : https://hpanel.hostinger.com
- phpMyAdmin : Via hPanel → Bases de données
- Webmail : https://webmail.hostinger.com

---

**📚 Documentation complète :**
- Guide : [DEPLOIEMENT_HOSTINGER.md](DEPLOIEMENT_HOSTINGER.md)
- Commandes : [COMMANDES_HOSTINGER.md](COMMANDES_HOSTINGER.md)
- Checklist : [CHECKLIST_HOSTINGER.md](CHECKLIST_HOSTINGER.md)
- Diagnostic : [DIAGNOSTIC_HEBERGEMENT.md](DIAGNOSTIC_HEBERGEMENT.md)

---

**✅ Projet prêt pour déploiement Hostinger !**

*Dernière mise à jour : 22 Décembre 2025*
