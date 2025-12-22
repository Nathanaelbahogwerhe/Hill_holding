# ✅ CHECKLIST DÉPLOIEMENT HOSTINGER

**Projet:** Hill Holding  
**Date:** ____________________  
**Domaine:** ____________________

---

## 📋 PHASE 1 : PRÉPARATION LOCALE

- [ ] Code testé localement sans erreurs
- [ ] Assets compilés (`npm run build`)
- [ ] Base de données exportée (si migration données)
- [ ] `.gitignore` configuré (exclure `node_modules`, `vendor`, `.env`)
- [ ] Repo Git créé et pushé (GitHub/GitLab/Bitbucket)
- [ ] Documentation lue (DEPLOIEMENT_HOSTINGER.md)

---

## 📋 PHASE 2 : CONFIGURATION HOSTINGER

### A. Compte et domaine
- [ ] Compte Hostinger actif
- [ ] Plan suffisant (Business/Cloud/VPS)
- [ ] Domaine acheté/transféré
- [ ] DNS pointant vers Hostinger
- [ ] Accès hPanel confirmé

### B. SSH et FTP
- [ ] Accès SSH activé dans hPanel
- [ ] Identifiants SSH notés :
  - Username : __________________
  - Host : __________________
  - Port : __________________
- [ ] Connexion SSH testée
- [ ] Identifiants FTP notés (si besoin)

### C. PHP Configuration
- [ ] PHP 8.3 sélectionné dans hPanel
- [ ] Extensions PHP activées :
  - [ ] bcmath
  - [ ] ctype
  - [ ] fileinfo
  - [ ] mbstring
  - [ ] openssl
  - [ ] pdo_mysql
  - [ ] tokenizer
  - [ ] xml
  - [ ] gd
- [ ] Limites PHP augmentées :
  - [ ] memory_limit = 256M
  - [ ] upload_max_filesize = 20M
  - [ ] post_max_size = 20M

### D. Base de données
- [ ] Base MySQL créée dans hPanel
  - Nom : __________________
  - User : __________________
  - Password : __________________
- [ ] Accès phpMyAdmin vérifié
- [ ] Identifiants notés

---

## 📋 PHASE 3 : DÉPLOIEMENT

### A. Upload du code
- [ ] **Option choisie :** 
  - [ ] Via Git (recommandé)
  - [ ] Via FTP/SFTP

#### Si Git :
- [ ] Projet cloné sur serveur
- [ ] Branche `main` active
- [ ] `.git` présent

#### Si FTP :
- [ ] Tous fichiers uploadés sauf `node_modules` et `vendor`
- [ ] Structure correcte vérifiée

### B. Installation dépendances
- [ ] Composer installé/accessible
- [ ] `composer install --no-dev` exécuté
- [ ] Aucune erreur dans output

### C. Configuration .env
- [ ] `.env.example` copié vers `.env`
- [ ] Variables modifiées :
  - [ ] `APP_ENV=production`
  - [ ] `APP_DEBUG=false`
  - [ ] `APP_URL=https://votredomaine.com`
  - [ ] `DB_HOST=localhost`
  - [ ] `DB_DATABASE=` (nom BDD)
  - [ ] `DB_USERNAME=` (user BDD)
  - [ ] `DB_PASSWORD=` (password BDD)
  - [ ] `MAIL_HOST=smtp.hostinger.com`
  - [ ] `MAIL_USERNAME=` (email créé)
  - [ ] `MAIL_PASSWORD=` (password email)
  - [ ] `SESSION_DRIVER=database`
  - [ ] `QUEUE_CONNECTION=database`

### D. Setup Laravel
- [ ] `php artisan key:generate` exécuté
- [ ] APP_KEY généré dans .env
- [ ] `php artisan storage:link` exécuté
- [ ] Lien symbolique créé
- [ ] `php artisan migrate --force` exécuté
- [ ] Toutes migrations réussies (95/95)

### E. Optimisation
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan optimize`
- [ ] Aucune erreur retournée

### F. Permissions
- [ ] `chmod -R 755 storage bootstrap/cache`
- [ ] `chmod -R 775 storage/logs`
- [ ] Droits d'écriture vérifiés

---

## 📋 PHASE 4 : CONFIGURATION AVANCÉE

### A. Racine web (Document Root)
- [ ] **Option choisie :**
  - [ ] Modifier Document Root → `/public_html/public`
  - [ ] Utiliser `.htaccess` redirect

#### Si Document Root modifié :
- [ ] hPanel → Domaines → Document Root changé
- [ ] Redémarrage serveur effectué

#### Si .htaccess :
- [ ] Fichier créé dans `/public_html/`
- [ ] Règle redirect testée

### B. SSL/HTTPS
- [ ] SSL Let's Encrypt installé (via hPanel)
- [ ] Certificat actif (cadenas vert)
- [ ] "Forcer HTTPS" activé
- [ ] Redirect HTTP → HTTPS fonctionne

### C. Email
- [ ] Compte email créé : __________________
- [ ] SMTP configuré dans .env
- [ ] Email de test envoyé et reçu

### D. Cron Jobs
- [ ] Scheduler Laravel configuré (chaque minute)
- [ ] Queue worker configuré (si besoin)
- [ ] Logs cron vérifiés

---

## 📋 PHASE 5 : DONNÉES ET UTILISATEURS

### A. Utilisateur admin
- [ ] Admin créé via tinker
  - Email : __________________
  - Password : __________________
- [ ] Rôle "Super Admin" assigné
- [ ] Connexion admin testée

### B. Rôles et permissions
- [ ] 6 rôles créés
- [ ] 55 permissions créées
- [ ] Associations vérifiées

### C. Données initiales (si besoin)
- [ ] Filiales importées
- [ ] Agences importées
- [ ] Départements importés
- [ ] Employés importés
- [ ] Autres données critiques

---

## 📋 PHASE 6 : TESTS

### A. Tests fonctionnels
- [ ] Page d'accueil charge (https://votredomaine.com)
- [ ] Login fonctionne
- [ ] Dashboard accessible
- [ ] Assets (CSS/JS) chargent correctement
- [ ] Images s'affichent
- [ ] Navigation fonctionne

### B. Tests modules (principaux)
- [ ] Module RH accessible
  - [ ] Employees list
  - [ ] Créer employé
  - [ ] Upload photo
- [ ] Module Finance accessible
  - [ ] Budgets
  - [ ] Dépenses/Revenus
- [ ] Module Activités
  - [ ] Planning
  - [ ] Créer activité
- [ ] Module Projets
  - [ ] Liste projets
  - [ ] Créer projet

### C. Tests uploads
- [ ] Upload image fonctionne
- [ ] Upload PDF fonctionne
- [ ] Fichiers stockés dans `storage/app/public`
- [ ] Accessible via `/storage/`

### D. Tests email
- [ ] Reset password fonctionne
- [ ] Notification reçue
- [ ] Format email correct

### E. Tests permissions
- [ ] Rôles limitent accès correctement
- [ ] Filiale filter fonctionne
- [ ] Agence filter fonctionne

---

## 📋 PHASE 7 : SÉCURITÉ

### A. Fichiers sensibles
- [ ] `.env` non accessible (https://votredomaine.com/.env → 403)
- [ ] Dossier `storage` protégé
- [ ] `composer.json` protégé

### B. Configuration
- [ ] `APP_DEBUG=false` confirmé
- [ ] `APP_ENV=production` confirmé
- [ ] Logs en mode `error` seulement

### C. Headers sécurité
- [ ] HTTPS forcé
- [ ] Session cookies sécurisés
- [ ] CSRF protection active

---

## 📋 PHASE 8 : MONITORING

### A. Logs
- [ ] `storage/logs/laravel.log` accessible
- [ ] Aucune erreur critique
- [ ] Rotation logs configurée (si besoin)

### B. Performance
- [ ] Temps de chargement < 3s
- [ ] Toutes les pages répondent
- [ ] Base de données optimale

### C. Backup
- [ ] Backup automatique Hostinger activé
- [ ] Premier backup manuel créé
- [ ] Backup DB manuel créé
- [ ] Procédure restauration testée

---

## 📋 PHASE 9 : DOCUMENTATION

- [ ] Identifiants notés dans gestionnaire mots de passe :
  - [ ] hPanel
  - [ ] SSH
  - [ ] MySQL
  - [ ] Email
  - [ ] Admin app
- [ ] URLs importantes notées :
  - [ ] Site : https://votredomaine.com
  - [ ] Admin : https://votredomaine.com/login
  - [ ] hPanel : https://hpanel.hostinger.com
- [ ] Fichiers guides conservés :
  - [ ] DEPLOIEMENT_HOSTINGER.md
  - [ ] COMMANDES_HOSTINGER.md
  - [ ] Cette checklist

---

## 📋 PHASE 10 : GO LIVE

### A. Communication
- [ ] Équipe informée du déploiement
- [ ] Horaire maintenance communiqué (si applicable)
- [ ] Support contacté si problème

### B. Mode production final
- [ ] `.env` vérifié une dernière fois
- [ ] Caches vidés et recachés
- [ ] Session de test complète effectuée

### C. Post-déploiement
- [ ] Monitoring actif première heure
- [ ] Logs surveillés
- [ ] Équipe disponible pour support
- [ ] Feedback utilisateurs collecté

---

## ✅ VALIDATION FINALE

**Site fonctionnel :** [ ] OUI [ ] NON

**Problèmes restants :**
_______________________________________
_______________________________________
_______________________________________

**Actions de suivi :**
_______________________________________
_______________________________________
_______________________________________

---

## 📞 CONTACTS URGENCE

**Support Hostinger :** https://support.hostinger.com  
**Chat 24/7 :** Via hPanel  
**Téléphone :** (Voir hPanel)

**Équipe technique :**
- Nom : _______________________
- Tel : _______________________
- Email : _______________________

---

**Date déploiement :** ____________________  
**Déployé par :** ____________________  
**Validé par :** ____________________  

**✅ PROJET HILL HOLDING DÉPLOYÉ AVEC SUCCÈS !**
