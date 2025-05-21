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
- 🐳 **Docker / Docker Compose**
- 🖥️ **Nginx** (serveur web)
- 🐬 **MySQL** (base de données)
- 🗃️ **phpMyAdmin** (interface de gestion de la BDD)

---

## 🛠️ Installation

### Prérequis

- Docker d'installer 

### Commande a éxécuter 

composer install 

cp .env.example .env 

php artisan key:generate
php artisan migrate 