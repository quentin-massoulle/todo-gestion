# 📋 Todo-Gestion 
Une application de gestion de tâches complète développée avec **Laravel**, permettant aux utilisateurs de :

- ✅ S'inscrire et se connecter
- 🗂️ Créer, modifier et supprimer des tâches
- 💰 Gérer leur budget personnel
- 👥 Créer et gérer des groupes
- 🔄 Partager des tâches avec les membres de leurs groupes

Le tout dans un environnement conteneurisé avec **Docker**, propulsé par **Nginx**, **MySQL** et **phpMyAdmin**.

---

## 🚀 Fonctionnalités

- **Authentification** des utilisateurs (inscription / connexion / déconnexion)
- **CRUD complet des tâches**
- **Gestion du budget** avec suivi des dépenses
- **Création de groupes**
- **Partage de tâches entre membres d’un groupe**
- Interface simple et intuitive

---

## 🧰 Stack technique

- ⚙️ **Laravel**
- 🐳 **Docker**
- 🖥️ **Nginx** (serveur web)
- 🐬 **MySQL** (base de données)
- 🗃️ **phpMyAdmin** (interface de gestion de la BDD)

---

## 🛠️ Installation

### Prérequis

- Docker d'installer 

### Commande a éxécuter 

- cd todo-gestion
- docker compose -up --d
- docker exec -it app bash
- composer install 
- cp .env.example .env 
- php artisan key:generate
- php artisan migrate
- php artisan storage:link 
- npm install
- npm run build


---

##  🌐 Accès à l'application

🔗 Interface web : http://localhost:8989/

🗃️ Interface phpMyAdmin : http://localhost:8080/
👉 Identifiants de connexion :
    Utilisateur  : root
    Mot de passe : root

