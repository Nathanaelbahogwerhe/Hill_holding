# 🚀 COMMANDES DE DÉPLOIEMENT - MODULE OPERATIONS

## 📋 Liste des commandes à exécuter dans l'ordre

---

## 1️⃣ VÉRIFICATION PRÉALABLE

### Vérifier que Laravel fonctionne
```bash
php artisan --version
```

### Vérifier la connexion à la base de données
```bash
php artisan db:show
```

---

## 2️⃣ EXÉCUTION DES MIGRATIONS

### Lister les migrations en attente
```bash
php artisan migrate:status
```

### Exécuter les 8 migrations du module Operations
```bash
php artisan migrate
```

**Migrations qui seront exécutées :**
1. `2025_12_21_160000_create_stocks_table`
2. `2025_12_21_170000_create_reports_table`
3. `2025_12_21_170001_create_report_schedules_table`
4. `2025_12_21_175900_drop_old_activities_table` ⚠️ Supprime ancienne table activities
5. `2025_12_21_180000_add_hierarchy_to_projects_and_tasks`
6. `2025_12_21_180001_create_activities_table`
7. `2025_12_21_180002_create_daily_operations_table`
8. `2025_12_21_180003_create_evaluations_table`

### En cas d'erreur, rollback possible avec :
```bash
php artisan migrate:rollback
```

---

## 3️⃣ GÉNÉRATION DES DONNÉES DE TEST

### Exécuter le seeder Operations
```bash
php artisan db:seed --class=OperationsSeeder
```

**Données qui seront créées :**
- 10 mouvements de stock (5 entrées + 5 sorties)
- 3 rapports avec différents statuts
- 3 calendriers de rapports (quotidien, hebdo, mensuel)
- 4 activités planifiées
- 7 rapports journaliers (7 derniers jours)
- 2 évaluations (projet et tâche)

---

## 4️⃣ CONFIGURATION STORAGE

### Créer le lien symbolique pour storage
```bash
php artisan storage:link
```

Cette commande crée un lien de `public/storage` vers `storage/app/public`.
Nécessaire pour que les fichiers uploadés (attachments) soient accessibles.

---

## 5️⃣ OPTIMISATION & CACHE

### Vider tous les caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reconstruire les caches (production seulement)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 6️⃣ VÉRIFICATION POST-DÉPLOIEMENT

### Vérifier que les tables existent
```bash
php artisan db:table stocks
php artisan db:table reports
php artisan db:table report_schedules
php artisan db:table activities
php artisan db:table daily_operations
php artisan db:table evaluations
```

### Compter les données insérées par le seeder
```bash
# Dans tinker
php artisan tinker
>>> \App\Models\Stock::count()
>>> \App\Models\Report::count()
>>> \App\Models\Activity::count()
>>> \App\Models\DailyOperation::count()
>>> \App\Models\Evaluation::count()
>>> exit
```

---

## 7️⃣ CRÉATION/VÉRIFICATION DES RÔLES

### Vérifier si les rôles nécessaires existent
```bash
php artisan tinker
>>> \Spatie\Permission\Models\Role::pluck('name')
>>> exit
```

### Si les rôles manquent, créer manuellement :
```bash
php artisan tinker
>>> \Spatie\Permission\Models\Role::create(['name' => 'Chargé des Opérations']);
>>> \Spatie\Permission\Models\Role::create(['name' => 'Operations Manager']);
>>> exit
```

### Ou via un seeder (si existe) :
```bash
php artisan db:seed --class=RoleSeeder
```

---

## 8️⃣ ASSIGNATION DES RÔLES AUX UTILISATEURS

### Assigner le rôle "Chargé des Opérations" à un utilisateur
```bash
php artisan tinker
>>> $user = \App\Models\User::find(1); # Remplacer 1 par l'ID voulu
>>> $user->assignRole('Chargé des Opérations');
>>> $user->hasRole('Chargé des Opérations') # Vérifier
>>> exit
```

---

## 9️⃣ DÉMARRAGE DU SERVEUR DE DÉVELOPPEMENT

### Démarrer Laravel
```bash
php artisan serve
```

Application accessible sur : http://localhost:8000

### Ou avec Laragon (si installé)
- Cliquer sur "Start All" dans Laragon
- Accéder à : http://hill_holding.test

---

## 🔟 TESTS MANUELS

### Accéder au module Operations

1. **Login** avec un compte ayant le rôle approprié
   ```
   URL: http://localhost:8000/login
   ```

2. **Menu Opérations** → Tester chaque lien :
   - ✅ Activities (http://localhost:8000/activities)
   - ✅ Daily Operations (http://localhost:8000/daily_operations)
   - ✅ Evaluations (http://localhost:8000/evaluations)
   - ✅ Stock (http://localhost:8000/stocks)
   - ✅ Reports (http://localhost:8000/reports)
   - ✅ Report Schedules (http://localhost:8000/report_schedules)

3. **Tester chaque fonctionnalité** :
   - Créer un mouvement de stock
   - Créer un rapport et le soumettre
   - Créer une activité avec participants
   - Créer un rapport journalier avec fichiers
   - Créer une évaluation

---

## ⚠️ EN CAS DE PROBLÈME

### Problème : Migration échoue
```bash
# Voir les détails de l'erreur
php artisan migrate --pretend

# Vérifier les tables existantes
php artisan db:show

# Rollback et réessayer
php artisan migrate:rollback
php artisan migrate
```

### Problème : Seeder échoue
```bash
# Exécuter avec verbose pour voir l'erreur
php artisan db:seed --class=OperationsSeeder --verbose
```

### Problème : Routes non trouvées (404)
```bash
# Vérifier les routes
php artisan route:list --path=operations
php artisan route:list --path=stocks
php artisan route:list --path=reports

# Vider le cache des routes
php artisan route:clear
```

### Problème : Accès refusé (403)
```bash
# Vérifier les rôles de l'utilisateur
php artisan tinker
>>> $user = auth()->user();
>>> $user->getRoleNames()
>>> exit

# Assigner le rôle manquant
php artisan tinker
>>> $user->assignRole('Chargé des Opérations');
>>> exit
```

### Problème : Fichiers attachés inaccessibles
```bash
# Vérifier le lien symbolique
ls -l public/storage

# Recréer le lien si nécessaire
rm public/storage
php artisan storage:link
```

### Problème : Vues non trouvées
```bash
# Vérifier que les vues existent
ls -R resources/views/stocks
ls -R resources/views/reports
ls -R resources/views/activities
ls -R resources/views/evaluations
ls -R resources/views/daily_operations
ls -R resources/views/report_schedules

# Vider le cache des vues
php artisan view:clear
```

---

## 📊 COMMANDES DE DEBUG

### Afficher les logs Laravel
```bash
tail -f storage/logs/laravel.log
```

### Mode debug activé (dans .env)
```env
APP_DEBUG=true
APP_ENV=local
```

### Vérifier les permissions fichiers (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Vérifier les permissions fichiers (Windows)
```powershell
# Aucune action nécessaire généralement sur Windows
```

---

## ✅ CHECKLIST FINALE

Cocher chaque étape après exécution :

- [ ] ✅ Migrations exécutées sans erreur
- [ ] ✅ Seeder exécuté avec succès
- [ ] ✅ Lien symbolique storage créé
- [ ] ✅ Caches vidés
- [ ] ✅ Rôles vérifiés/créés
- [ ] ✅ Utilisateur avec rôle assigné
- [ ] ✅ Serveur démarré
- [ ] ✅ Login réussi
- [ ] ✅ Menu Opérations visible
- [ ] ✅ Accès à Stock testé
- [ ] ✅ Accès à Reports testé
- [ ] ✅ Accès à Activities testé
- [ ] ✅ Accès à Daily Operations testé
- [ ] ✅ Accès à Evaluations testé
- [ ] ✅ Accès à Report Schedules testé

---

## 🎉 FÉLICITATIONS !

Si toutes les étapes sont validées, le module Operations est **100% opérationnel** ! 🚀

Vous pouvez maintenant commencer à l'utiliser ou passer au développement d'un autre module.

---

**Document créé le :** 21 Décembre 2025
**Version du module :** 1.0.0
**Auteur :** GitHub Copilot
