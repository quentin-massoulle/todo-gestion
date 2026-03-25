# 🤖 Agent Guide: Todo-Gestion

Ce document fournit une vue d'ensemble complète du projet Todo-Gestion pour les agents IA et les futurs développeurs.

## 📝 Project Overview

**Todo-Gestion** est une application complète de gestion de tâches et de budget personnel développée avec Laravel. Elle permet aux utilisateurs de gérer leurs tâches quotidiennes, de suivre leurs finances et de collaborer via des groupes de travail avec partage de tâches.

## 🛠️ Tech Stack

- **Framework**: Laravel 11 (PHP 8.2)
- **Frontend**: Blade templates, Tailwind CSS 3, Vite
- **Database**: MySQL (stockage relationnel)
- **Containerization**: Docker & Nginx
- **Key Libraries**:
    - `chart.js`: Pour la visualisation des données (budget/tâches)
    - `select2`: Menus de sélection améliorés
    - `sweetalert2`: Alertes et fenêtres modales interactives
    - `axios` & `jquery`: Interactions frontend et appels API

## 📁 Key File Structure

- `app/Models/`: Modèles de domaine (User, Tache, Groupe, Message, etc.)
- `app/Http/Controllers/`: Logique de traitement des requêtes
- `resources/views/`: Templates Blade pour l'interface utilisateur
- `routes/web.php`: Routes web principales et navigation
- `database/migrations/`: Définitions du schéma de la base de données
- `docker-compose.yml`: Configuration de l'infrastructure locale

## 🔑 Core Features & Logic

1. **Authentication**: Gérée via `AuthController`. Support des rôles Utilisateur et Administrateur.
2. **Tasks (Taches)**: CRUD complet. Les tâches peuvent avoir des relations de dépendance (`TacheDependance`) et des rappels (`Rappel`).
3. **Groups (Groupes)**: Les utilisateurs peuvent créer des groupes, inviter d'autres personnes et partager des tâches. Dispose d'une vue Gantt.
4. **Messaging**: Fonctionnalité de messagerie de base dans l'application via `MessageController`.
5. **Dashboard**: Tableaux de bord distincts et personnalisés pour les utilisateurs et les administrateurs.

## 🚀 Common Commands

- **Start Project (Docker)**: `docker compose up -d`
- **Enter App Container**: `docker exec -it app bash`
- **Database Migrations**: `php artisan migrate`
- **Frontend Build**: `npm run dev` ou `npm run build`
- **Run Tests**: `php artisan test`

## 💡 Development Conventions

- **Controllers**: La logique doit idéalement rester dans les contrôleurs, en privilégiant les contrôleurs.
- **Models**: Utiliser les relations Eloquent (définies dans `Tache.php`, `Groupe.php`, etc.).
- **Middleware**: `auth`, `IsAdmin`, and `CheckRoute` are used for access control.
- **UI**: Cohérence visuelle avec Tailwind CSS. Respecter la structure des dossiers de Laravel pour les vues.
