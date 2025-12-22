# 🏢 HILL HOLDING - Système de Gestion Intégré

**Version:** 1.0.0  
**Laravel:** 12.41.1  
**PHP:** 8.3.16  
**Date:** Décembre 2025

---

## 📋 À PROPOS

**Hill Holding** est une application web complète de gestion d'entreprise multi-tenant construite avec Laravel 12. Elle permet la gestion centralisée des ressources humaines, finances, projets, logistique et plus encore pour des organisations avec plusieurs filiales et agences.

### 🎯 Fonctionnalités principales

- ✅ **Système multi-tenant** : Hill Holdings → Filiales → Agences → Départements
- ✅ **Module RH complet** : Employés, contrats, congés, présences, paies
- ✅ **Module Finance** : Budgets, dépenses, revenus, factures, rapports
- ✅ **Gestion de projets** : Projets, tâches, activités avec planification
- ✅ **Logistique** : Stocks, achats, équipements, véhicules
- ✅ **Système IT** : Équipements informatiques, licences, interventions
- ✅ **Rôles et permissions** : 6 rôles, 55 permissions (Spatie)
- ✅ **Interface moderne** : Tailwind CSS, Alpine.js, Flowbite

---

## 🚀 DÉPLOIEMENT RAPIDE (HOSTINGER)

### Prérequis
- Compte Hostinger (Business/Cloud/VPS)
- PHP 8.2+ (8.3 recommandé)
- MySQL 5.7+
- Composer
- Git (recommandé)

### Installation en 5 étapes

```bash
# 1. Cloner le projet
git clone votre-repo.git public_html
cd public_html

# 2. Installer dépendances
composer install --no-dev --optimize-autoloader

# 3. Configuration
cp .env.example .env
nano .env  # Éditer DB_*, APP_URL, etc.

# 4. Laravel setup
php artisan key:generate
php artisan storage:link
php artisan migrate --force
php artisan optimize

# 5. Créer admin
php artisan tinker
# Voir guide complet dans DEPLOIEMENT_HOSTINGER.md
```

**⏱️ Temps estimé : 1-2 heures**

---

## 📚 DOCUMENTATION COMPLÈTE

### 🎯 Pour déployer sur Hostinger
1. **[DEPLOIEMENT_HOSTINGER.md](DEPLOIEMENT_HOSTINGER.md)** - Guide complet étape par étape
2. **[COMMANDES_HOSTINGER.md](COMMANDES_HOSTINGER.md)** - Commandes rapides et raccourcis
3. **[CHECKLIST_HOSTINGER.md](CHECKLIST_HOSTINGER.md)** - Checklist à cocher (10 phases)
4. **[INFOS_PROJET.md](INFOS_PROJET.md)** - Informations techniques du projet

### 📊 Pour comprendre le projet
5. **[DIAGNOSTIC_HEBERGEMENT.md](DIAGNOSTIC_HEBERGEMENT.md)** - Audit complet (10 sections)
6. **[RESUME_DIAGNOSTIC.md](RESUME_DIAGNOSTIC.md)** - Résumé exécutif

---

## 🗄️ STRUCTURE BASE DE DONNÉES

### 95 Migrations
- **Tables système** : users, roles, permissions
- **Hiérarchie** : hill_holdings, filiales, agences, departments
- **RH** : employees, positions, contracts, leaves, attendances, payrolls
- **Finance** : budgets, expenses, revenues, invoices, transactions
- **Projets** : projects, tasks, activities, daily_operations
- **Logistique** : stocks, equipment, vehicles, suppliers
- **IT** : it_equipment, software_licenses, it_interventions

### Relations clés
- User → Employee (one-to-one)
- User → Filiale → Agences → Departments (hiérarchie)
- Activity → Responsible (User) + Participants (many-to-many)
- Budget → Expenses/Revenues (tracking)

---

## 👥 SYSTÈME DE RÔLES

### 6 Rôles principaux
1. **Super Admin** - Accès total
2. **Admin Finance** - Module finance complet
3. **Admin RH** - Module RH complet
4. **Chef de Projet** - Gestion projets
5. **Responsable Filiale** - Vue filiale
6. **Responsable Agence** - Vue agence

### 55 Permissions
- CRUD sur chaque module
- Filtres par filiale/agence
- Permissions granulaires

---

## 🛠️ TECHNOLOGIES

### Backend
- **Laravel 12.41.1** - Framework PHP
- **PHP 8.3.16** - Langage
- **MySQL** - Base de données
- **Spatie Permission 6.23** - Rôles et permissions
- **Laravel Sanctum** - API authentication

### Frontend
- **Tailwind CSS 3.1** - Styling
- **Alpine.js 3.15** - JavaScript réactif
- **Flowbite 3.1** - Composants UI
- **Blade** - Template engine
- **Vite 6.0** - Build tool
- **Chart.js** - Graphiques

---

## 📦 INSTALLATION LOCALE (Développement)

```bash
# 1. Cloner
git clone votre-repo.git
cd hill_holding

# 2. Installer dépendances
composer install
npm install

# 3. Configuration
cp .env.example .env
php artisan key:generate

# 4. Base de données
# Créer la DB dans MySQL
php artisan migrate
php artisan db:seed  # Optionnel

# 5. Storage
php artisan storage:link

# 6. Lancer serveur
php artisan serve
npm run dev

# Accès : http://127.0.0.1:8000
```

---

## 🔐 SÉCURITÉ

- ✅ CSRF Protection (Laravel)
- ✅ XSS Protection
- ✅ SQL Injection Prevention (Eloquent)
- ✅ Password Hashing (bcrypt)
- ✅ Rate Limiting
- ✅ Session sécurisées
- ✅ SSL/HTTPS forcé (production)
- ✅ Validation des uploads

---

## 🧪 TESTS

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter AuthTest
```

---

## 📈 PERFORMANCE

### Optimisations activées
- Config, routes, views cachées
- Autoloader optimisé
- Assets compilés et minifiés
- Eager loading des relations
- Database indexes

### Benchmarks (local)
- Temps chargement : < 300ms
- Requêtes DB : < 50 par page
- Taille page : < 2MB

---

## 🐛 DÉPANNAGE

### Erreur 500
```bash
php artisan optimize:clear
chmod -R 755 storage bootstrap/cache
tail -50 storage/logs/laravel.log
```

### Assets non chargés
```bash
npm run build
php artisan optimize
```

### Connexion DB
```bash
php artisan tinker
DB::connection()->getPdo();
```

---

## 🔄 MISES À JOUR

```bash
# Via Git
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan optimize
```

---

## 📞 SUPPORT

**Documentation :**
- Guide Hostinger : [DEPLOIEMENT_HOSTINGER.md](DEPLOIEMENT_HOSTINGER.md)
- Commandes rapides : [COMMANDES_HOSTINGER.md](COMMANDES_HOSTINGER.md)

**Logs :**
- Laravel : `storage/logs/laravel.log`
- Serveur : Via hPanel

---

## 📊 STATISTIQUES

```
Migrations:       95
Tables:           60+
Contrôleurs:      45+
Modèles:          40+
Vues Blade:       120+
Routes:           250+
Lignes de code:   30,000+
```

---

## 📝 LICENCE

Ce projet est propriétaire. Tous droits réservés.

---

## ✅ STATUT DU PROJET

**Version:** 1.0.0  
**Status:** ✅ Production Ready  
**Dernière mise à jour:** 22 Décembre 2025

**Prêt pour déploiement Hostinger !**

---

## 🎯 PROCHAINES ÉTAPES

1. Lire [DEPLOIEMENT_HOSTINGER.md](DEPLOIEMENT_HOSTINGER.md)
2. Suivre [CHECKLIST_HOSTINGER.md](CHECKLIST_HOSTINGER.md)
3. Déployer en 1-2 heures
4. Profiter de votre application ! 🎉

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
