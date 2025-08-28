# 🚀 Ecome

Une application Laravel de vente en ligne

## ✨ Fonctionnalités
- Gestion des utilisateurs avec authentification
- Ajouter une commande
- Tableau de bord intuitif pour l'admin
- 

## 🛠️ Installation

### Prérequis
- PHP >= 8.3.16
- Composer
- MySQL / MariaDB
- Node.js & npm

### Étapes
```bash
# Cloner le projet
git clone https://github.com/moussadjoulde/odc-project.git

cd odc-project

# Installer les dépendances PHP
composer install

# Installer les dépendances front-end
npm install && npm run dev

# Créer le fichier .env
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Lancer les migrations
php artisan migrate --seed

# Lancer tinker pour assigner des roles
php artisan tinker

ex: 

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

$user = User::findOrFail($userId); # Passer l'id du user pour lequel vous vous assigner le role
$user = assignRole('admin'); # admin, vendor, customer
