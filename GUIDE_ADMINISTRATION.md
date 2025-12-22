# Guide d'Administration - Hill Holding

## 🎯 Accès Rapide

Vous pouvez maintenant créer des utilisateurs, filiales et agences **directement depuis l'interface web** sans toucher au code !

### 📍 Accès depuis le Dashboard

Une fois connecté, vous verrez une section **"Raccourcis Administration"** sur le dashboard avec des boutons pour :

- 👤 **Créer un Utilisateur** avec rôles et permissions
- 🏭 **Créer une Filiale**
- 📍 **Créer une Agence**
- 👥 **Créer un Employé**
- Et bien plus...

### 📚 Guide Complet

Un **guide d'administration complet** est accessible depuis le dashboard via le bouton :
```
📚 Guide Complet d'Administration
```

Ou directement via l'URL : `http://127.0.0.1:8000/help/admin-guide`

---

## 🔑 Fonctionnalités Principales

### 1️⃣ Gestion des Utilisateurs

#### Créer un utilisateur
1. Dashboard → Cliquez sur **"👤 Nouvel Utilisateur"**
2. Remplissez les informations :
   - **Nom complet**
   - **Email** (identifiant de connexion)
   - **Mot de passe** (min 6 caractères)
   - **Confirmation du mot de passe**
3. Sélectionnez la **Filiale** (optionnel)
4. Cochez les **Rôles** appropriés :
   - 🔴 **Super Admin** : Accès total
   - 👥 **RH Manager** : Gestion RH complète
   - 🔧 **Operations Manager** : Gestion opérationnelle
   - 💻 **IT Manager** : Gestion IT
   - 👤 **Employee** : Employé standard
5. Ajoutez des **Permissions spécifiques** si nécessaire
6. Cliquez sur **"✅ Créer l'utilisateur"**

#### Modifier un utilisateur
1. **RH → Utilisateurs**
2. Cliquez sur **"✏️ Éditer"** à côté de l'utilisateur
3. Modifiez les informations
4. Changez les rôles/permissions si besoin
5. **Important** : Laissez le mot de passe vide si vous ne voulez pas le changer
6. Cliquez sur **"✅ Mettre à jour"**

---

### 2️⃣ Gestion des Filiales

#### Créer une filiale
1. Dashboard → Cliquez sur **"🏭 Nouvelle Filiale"**
2. Remplissez :
   - **Nom** (obligatoire, unique)
   - **Code** (ex: FIL-001)
   - **Localisation** (ville/adresse)
   - **Logo** (image, max 2MB)
3. Sélectionnez **Hill Holding** comme maison mère
4. Cliquez sur **"✅ Créer"**

#### Consulter les filiales
- **RH → Filiales** : Liste complète
- Cliquez sur une filiale pour voir :
  - Départements
  - Agences rattachées
  - Employés

---

### 3️⃣ Gestion des Agences

#### Créer une agence
1. Dashboard → Cliquez sur **"📍 Nouvelle Agence"**
2. Remplissez :
   - **Nom** (obligatoire, unique)
   - **Code** (ex: AGN-001)
   - **Localisation** (adresse précise)
   - **Filiale parente** (obligatoire)
   - **Logo** (image, max 2MB)
3. Cliquez sur **"✅ Créer"**

#### Structure hiérarchique
```
Hill Holding (Maison Mère)
└── Filiale 1
    ├── Agence 1A
    └── Agence 1B
└── Filiale 2
    └── Agence 2A
```

---

## 🎭 Rôles Disponibles

| Rôle | Icône | Description |
|------|-------|-------------|
| **Super Admin** | 🔴 | Accès complet à toutes les fonctionnalités |
| **RH Manager** | 👥 | Gestion employés, contrats, congés, utilisateurs, filiales, agences |
| **Operations Manager** | 🔧 | Gestion équipements, véhicules, missions, interventions |
| **IT Manager** | 💻 | Gestion matériel informatique, licences, interventions IT |
| **Employee** | 👤 | Accès limité, consultation et gestion personnelle |

### 💡 Points importants
- Un utilisateur peut avoir **plusieurs rôles** simultanément
- Les permissions des rôles sont **cumulatives**
- Les permissions directes s'**ajoutent** aux permissions des rôles

---

## 🚀 Accès Rapides

### Depuis le Dashboard
Tous les boutons de création rapide sont visibles directement sur le dashboard pour les utilisateurs ayant les permissions **Super Admin** ou **RH Manager**.

### Depuis le Menu
- **RH** → Utilisateurs, Employés, Départements, Filiales, Agences
- **Opérations** → Équipements, Véhicules, Missions
- **IT** → Équipements IT, Licences
- **Administration** → Rôles & Permissions (Super Admin uniquement)

---

## ⚙️ Administration Avancée (Super Admin)

Pour gérer les rôles et permissions :
1. Allez dans **Administration → Rôles & Permissions**
2. Créez de nouveaux rôles selon vos besoins
3. Assignez des permissions spécifiques
4. Créez des permissions personnalisées

---

## 📞 Support

Pour toute question ou assistance, consultez le **📚 Guide Complet d'Administration** accessible depuis le dashboard.

---

## ✅ Checklist de Configuration Initiale

- [ ] Créer les filiales principales
- [ ] Créer les agences
- [ ] Créer les départements
- [ ] Créer les utilisateurs avec leurs rôles
- [ ] Assigner les utilisateurs aux filiales/agences appropriées
- [ ] Vérifier les permissions de chaque rôle
- [ ] Créer les employés

---

**Dernière mise à jour** : 21 décembre 2025
