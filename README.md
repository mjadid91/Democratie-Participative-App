# 🚀 Démocratie Participative
Plateforme web permettant à des groupes de proposer, débattre et voter des idées avec gestion de budget.
👉 Objectif : rendre la prise de décision collective, claire et structurée.

## ✨ Fonctionnalités principales

### 👤 Authentification

* Inscription sécurisée (hash password)
* Connexion / Déconnexion
* Session utilisateur

### 👥 Gestion des groupes

* Création de groupe
* Ajout automatique du créateur en admin
* Invitation d'utilisateurs par email
* Gestion des rôles :
   * Administrateur
   * Membre
   * Organisateur

### 💡 Propositions

* Création de propositions dans un groupe
* Budget associé à chaque proposition
* Statuts :
   * `en_attente`
   * `en_vote`
   * `approuvee`
   * `rejetee`
   * etc.

### 💬 Commentaires & Réactions

* Ajout de commentaires
* Suppression logique (soft delete)
* Réactions type :
   * 👍 ❤️ 😂 😢 👎

### 🗳️ Système de vote

* Création de vote (majoritaire, consultatif…)
* Vote utilisateur :
   * Pour
   * Contre
   * Abstention
* Résultats en temps réel

### ⚠️ Modération

* Signalement de :
   * Commentaires
   * Propositions
* Traitement des signalements (admin / modo)

### 👤 Profil utilisateur

* Consultation des informations
* Gestion du compte

---

## 🛠️ Stack technique

### Backend

* PHP 8+
* Architecture MVC custom
* PDO (requêtes sécurisées)

### Frontend

* HTML5 / CSS3
* Bootstrap 5
* UI custom (design premium)

### Base de données

* MySQL / MariaDB

---

## 📁 Architecture du projet

```
/config
    Connexion.php
    Config.php

/controleur
    ControleurAuth.php
    ControleurGroupe.php
    ControleurProposition.php
    ControleurSignalement.php
    ControleurInvitation.php
    ControleurUtilisateur.php
    ControleurMain.php

/models
    Model.php
    Utilisateur.php
    Groupe.php
    Budget.php
    Proposition.php
    Commentaire.php
    ReactionCommentaire.php
    Vote.php
    Invitation.php
    Signalement.php
    RoleDansGroupe.php

/vue
    /layout
        debut.php
        fin.php
        menu.php

    /pages
        /auth
        /groupe
        /proposition
        /moderation

/style
    app.css

routeur.php
```

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/ton-repo/Democratie-Participative-App.git
cd Democratie-Participative-App
```

### 2. Configurer la base de données
Créer une base :

```sql
CREATE DATABASE democratie;
```

Importer le fichier SQL (si fourni).

### 3. Configurer la connexion
Modifier :

```
/config/Config.php
```

```php
define('HOSTNAME', 'localhost');
define('DATABASE', 'democratie');
define('LOGIN', 'root');
define('PASSWORD', '');
```

### 4. Lancer le projet
Avec XAMPP / WAMP :

```
http://localhost/Democratie-Participative-App/routeur.php
```

---

## 🔐 Sécurité

* ✅ Hash des mots de passe (`password_hash`)
* ✅ Vérification (`password_verify`)
* ✅ Requêtes préparées (PDO)
* ✅ Protection basique des accès (session + rôles)

---

## 🚧 Améliorations possibles

* 🔔 Notifications en temps réel
* 📄 Système de pagination
* 📊 Dashboard analytics
* 🖼️ Upload d'images (groupes / propositions)
* 🔌 WebSocket pour votes live
* 🌐 API REST (pour React / mobile)

---

## 👨‍💻 Auteur
Mohamed Jadid

* LinkedIn : www.linkedin.com/in/mohamedjadid91
* GitHub : https://github.com/mjadid91

---

## 📄 Licence
Projet réalisé dans un cadre pédagogique (BUT Informatique).
