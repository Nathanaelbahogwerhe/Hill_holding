# 🧪 GUIDE DE TEST - MODULE FINANCE
## HillHolding ERP - 21 Décembre 2025

---

## ✅ PRÉREQUIS

### 1. Migrations exécutées
- ✅ Toutes les migrations ont été appliquées
- ✅ Structure de la base de données mise à jour

### 2. Configuration du storage
Vérifier que le lien symbolique est créé :
```bash
php artisan storage:link
```

### 3. Utilisateurs de test
Assurez-vous d'avoir des comptes avec ces rôles :
- **Super Admin** (Maison Mère) - Accès total
- **Admin Finance** (Filiale) - Accès à sa filiale
- **Admin Finance** (Agence) - Accès à son agence

---

## 📋 PLAN DE TEST COMPLET

### TEST 1 : Création d'un Budget avec Catégorie
**Objectif** : Vérifier que les budgets sont créés correctement avec tracking

#### Étapes :
1. Se connecter en tant que **Super Admin**
2. Aller sur `/budgets/create`
3. Remplir le formulaire :
   - **Titre** : Budget Marketing Q1 2025
   - **Catégorie** : Marketing
   - **Montant** : 50000 €
   - **Date début** : 01/01/2025
   - **Date fin** : 31/03/2025
   - **Filiale** : Sélectionner une filiale
   - **Agence** : (Optionnel)
   - **Pièce jointe** : Uploader un PDF de test
   - **Status** : Active
4. Cliquer sur **Enregistrer**

#### Résultat attendu :
- ✅ Budget créé avec succès
- ✅ Redirection vers `/budgets`
- ✅ Budget affiché avec barre de progression à **0%** (vert)
- ✅ `amount_used` = 0.00 €
- ✅ `percentage_used` = 0.00%
- ✅ Fichier PDF uploadé et lien de téléchargement visible

---

### TEST 2 : Création d'une Dépense → Mise à jour automatique du Budget
**Objectif** : Vérifier que les budgets se mettent à jour automatiquement

#### Étapes :
1. Aller sur `/expenses/create`
2. Remplir le formulaire :
   - **Description** : Campagne publicitaire Facebook
   - **Montant** : 15000 €
   - **Date** : 15/01/2025
   - **Catégorie** : **Marketing** ⚠️ (même catégorie que le budget)
   - **Filiale** : **Même filiale** que le budget créé
   - **Agence** : **Même agence** (si applicable)
   - **Pièce jointe** : Uploader une facture PDF
3. Cliquer sur **Enregistrer**

#### Résultat attendu :
- ✅ Dépense créée avec succès
- ✅ Redirection vers `/expenses`
- ✅ **Retourner sur `/budgets`**
- ✅ Budget "Budget Marketing Q1 2025" affiche maintenant :
  - `amount_used` = 15000.00 €
  - `percentage_used` = 30.00%
  - Barre de progression à **30%** (vert)
  - Badge **"En cours"**

---

### TEST 3 : Ajout d'une 2ème Dépense → Alerte Orange (80%)
**Objectif** : Vérifier l'alerte "Près de la limite"

#### Étapes :
1. Créer une nouvelle dépense :
   - **Description** : Impression flyers et affiches
   - **Montant** : 25000 €
   - **Date** : 20/01/2025
   - **Catégorie** : **Marketing**
   - **Filiale/Agence** : Identiques au budget
2. Enregistrer

#### Résultat attendu :
- ✅ Dépense créée
- ✅ **Retourner sur `/budgets`**
- ✅ Budget "Budget Marketing Q1 2025" affiche :
  - `amount_used` = 40000.00 € (15000 + 25000)
  - `percentage_used` = 80.00%
  - Barre de progression à **80%** (orange)
  - Badge **"⚠️ Près de la limite"**

---

### TEST 4 : 3ème Dépense → Alerte Rouge (Dépassement)
**Objectif** : Vérifier l'alerte de dépassement de budget

#### Étapes :
1. Créer une 3ème dépense :
   - **Description** : Achat espace publicitaire TV
   - **Montant** : 12000 €
   - **Date** : 25/01/2025
   - **Catégorie** : **Marketing**
   - **Filiale/Agence** : Identiques
2. Enregistrer

#### Résultat attendu :
- ✅ Dépense créée
- ✅ **Retourner sur `/budgets`**
- ✅ Budget "Budget Marketing Q1 2025" affiche :
  - `amount_used` = 52000.00 € (15000 + 25000 + 12000)
  - `percentage_used` = 104.00%
  - Barre de progression à **100%+** (rouge)
  - Badge **"❌ Dépassé"**
  - Message d'alerte visible

---

### TEST 5 : Modification d'une Dépense → Recalcul du Budget
**Objectif** : Vérifier que le budget se recalcule après modification

#### Étapes :
1. Aller sur `/expenses`
2. Cliquer sur **Modifier** la 1ère dépense (15000 €)
3. Changer le montant de **15000** à **5000** €
4. Enregistrer

#### Résultat attendu :
- ✅ Dépense modifiée
- ✅ **Retourner sur `/budgets`**
- ✅ Budget recalculé automatiquement :
  - `amount_used` = 42000.00 € (5000 + 25000 + 12000)
  - `percentage_used` = 84.00%
  - Barre de progression à **84%** (orange)
  - Badge **"⚠️ Près de la limite"**

---

### TEST 6 : Suppression d'une Dépense → Recalcul du Budget
**Objectif** : Vérifier la mise à jour après suppression

#### Étapes :
1. Aller sur `/expenses`
2. Supprimer la 3ème dépense (12000 €)
3. Confirmer la suppression

#### Résultat attendu :
- ✅ Dépense supprimée
- ✅ Fichier PDF supprimé du storage
- ✅ **Retourner sur `/budgets`**
- ✅ Budget recalculé :
  - `amount_used` = 30000.00 € (5000 + 25000)
  - `percentage_used` = 60.00%
  - Barre de progression à **60%** (vert)
  - Badge **"En cours"**

---

### TEST 7 : Création Revenue avec Upload
**Objectif** : Tester le module Revenus avec attachments

#### Étapes :
1. Aller sur `/revenues/create`
2. Remplir :
   - **Description** : Vente produits janvier
   - **Montant** : 80000 €
   - **Date** : 31/01/2025
   - **Filiale/Agence** : Sélectionner
   - **Pièce jointe** : Upload PDF
3. Enregistrer

#### Résultat attendu :
- ✅ Revenue créé avec succès
- ✅ Fichier uploadé correctement
- ✅ Lien de téléchargement fonctionnel

---

### TEST 8 : Dashboard Rapports Financiers
**Objectif** : Vérifier les statistiques du dashboard

#### Étapes :
1. Aller sur `/financial_reports`
2. Observer le dashboard

#### Résultat attendu :
- ✅ **Statistiques Budget** :
  - Total Budget : 50000 €
  - Budget Utilisé : 30000 €
  - Pourcentage : 60%
  - Budgets dépassés : 0
  - Budgets proches limite : 0 (car maintenant à 60%)

- ✅ **Statistiques par Filiale** affichées
- ✅ **Statistiques par Agence** affichées
- ✅ **Graphiques** visibles et cohérents

---

### TEST 9 : Permissions Hiérarchiques
**Objectif** : Vérifier l'isolation des données par niveau

#### Test 9.1 : Super Admin (Maison Mère)
1. Se connecter en **Super Admin**
2. Vérifier accès à `/budgets`, `/expenses`, `/revenues`

**Résultat** : ✅ Voit TOUS les budgets/dépenses/revenus de toutes les filiales et agences

#### Test 9.2 : Admin Finance Filiale
1. Se connecter en **Admin Finance** (niveau Filiale)
2. Accéder à `/budgets`

**Résultat** : ✅ Voit UNIQUEMENT les budgets de SA filiale et ses agences

#### Test 9.3 : Admin Finance Agence
1. Se connecter en **Admin Finance** (niveau Agence)
2. Accéder à `/budgets`

**Résultat** : ✅ Voit UNIQUEMENT les budgets de SON agence

---

### TEST 10 : Upload/Download de Fichiers
**Objectif** : Vérifier la gestion des pièces jointes

#### Étapes :
1. Créer un budget avec PDF de 5 MB
2. Télécharger le fichier depuis la liste
3. Modifier le budget et changer le fichier
4. Vérifier que l'ancien est supprimé et le nouveau sauvegardé
5. Supprimer le budget
6. Vérifier que le fichier est supprimé du storage

#### Résultat attendu :
- ✅ Upload réussi (max 10 MB)
- ✅ Download fonctionnel
- ✅ Ancien fichier supprimé lors du remplacement
- ✅ Fichier supprimé lors de la suppression d'entité

---

## 🎯 CHECKLIST FINALE

### Fonctionnalités Budget
- [ ] Création avec catégorie
- [ ] Calcul automatique `amount_used`
- [ ] Calcul automatique `percentage_used`
- [ ] Barre de progression dynamique
- [ ] Badge status (En cours / Près limite / Dépassé)
- [ ] Upload/Download pièce jointe

### Fonctionnalités Expense
- [ ] Création avec catégorie
- [ ] Mise à jour automatique du budget lié
- [ ] Modification → Recalcul de l'ancien ET nouveau budget si catégorie changée
- [ ] Suppression → Recalcul du budget
- [ ] Upload/Download pièce jointe

### Fonctionnalités Revenue
- [ ] Création avec description
- [ ] Upload/Download pièce jointe
- [ ] CRUD complet

### Dashboard Financier
- [ ] Statistiques budgets globales
- [ ] Statistiques par filiale
- [ ] Statistiques par agence
- [ ] Détection budgets dépassés
- [ ] Détection budgets proches limite

### Hiérarchie & Permissions
- [ ] Super Admin voit tout
- [ ] Admin Filiale voit sa filiale
- [ ] Admin Agence voit son agence
- [ ] Impossibilité de créer budget hors périmètre

### Storage
- [ ] `php artisan storage:link` exécuté
- [ ] Fichiers uploadés dans `storage/app/public/`
- [ ] Fichiers accessibles via `/storage/`
- [ ] Suppression automatique des anciens fichiers

---

## 🐛 RÉSOLUTION DES PROBLÈMES

### Erreur : "Storage not found"
**Solution** : 
```bash
php artisan storage:link
```

### Erreur : "Budget not updating"
**Vérifier** :
1. La catégorie de l'expense correspond à celle du budget
2. La filiale/agence de l'expense correspond au budget
3. La date de l'expense est dans la période du budget

### Erreur : "File upload failed"
**Vérifier** :
1. Le disque `public` est bien configuré dans `config/filesystems.php`
2. Le dossier `storage/app/public/` existe
3. Le dossier a les permissions d'écriture

---

## ✅ VALIDATION FINALE

Après avoir complété tous les tests :

1. **Budget Tracking** : ✅ Fonctionnel avec calculs automatiques
2. **Expense Tracking** : ✅ Mise à jour automatique des budgets
3. **Revenue Management** : ✅ CRUD complet avec attachments
4. **File Management** : ✅ Upload/Download/Delete opérationnels
5. **Hierarchy Logic** : ✅ Isolation des données par niveau
6. **Financial Reports** : ✅ Dashboard avec statistiques précises
7. **Permissions** : ✅ Contrôle d'accès hiérarchique fonctionnel

---

## 🎉 MODULE FINANCE - PRÊT POUR PRODUCTION !

**Date de validation** : __________________

**Testé par** : __________________

**Signature** : __________________
