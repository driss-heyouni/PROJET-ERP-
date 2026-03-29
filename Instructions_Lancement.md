# Instructions de Lancement du Projet

Ce dépôt contient la structure principale du Mini-Projet ERP pour l'intégration Odoo.
L'application est découpée en deux dossiers majeurs :
1. `backend/` : L'API Middleware construite avec Laravel (PHP).
2. `frontend/` : L'application web construite avec Angular (TypeScript).

## Prérequis
- **PHP** (>= 8.1) et **Composer** installés.
- **Node.js** (>= 18) et **NPM** installés.
- **Angular CLI** installé globalement (`npm install -g @angular/cli`).
- Une instance **Odoo Community** en cours d'exécution (locale ou distante).

## Étape 1 : Lancement du Backend (Laravel)
1. Ouvrez un terminal dans le dossier `backend/`.
2. Installez les dépendances PHP :
   ```bash
   composer install
   ```
3. Copiez le fichier d'environnement et générez la clé :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Ouvrez le fichier `.env` généré et configurez les accès à votre Odoo (voir le fichier `Guide_Configuration_Odoo.md`).
   ```env
   ODOO_URL=http://localhost:8069
   ODOO_DB=mon_erp
   ODOO_USERNAME=api@mon-erp.com
   ODOO_PASSWORD=mon_mot_de_passe
   ```
5. Lancez le serveur de développement Laravel :
   ```bash
   php artisan serve
   ```
   L'API sera accessible sur `http://localhost:8000`.

## Étape 2 : Lancement du Frontend (Angular)
1. Ouvrez un deuxième terminal dans le dossier `frontend/`.
2. Installez les dépendances Node :
   ```bash
   npm install
   ```
3. Lancez le serveur de développement Angular :
   ```bash
   ng serve -o
   ```
L'application web s'ouvrira automatiquement dans votre navigateur à l'adresse `http://localhost:4200`.

## Contenu de l'interface
L'interface finale déployée par ces commandes affichera un Dashboard permettant de :
- Consulter les clients récupérés directement de Odoo.
- Afficher la liste du mobilier (Bureaux, Chaises, etc.) et ses stocks.
- Afficher le formulaire "Nouveau Devis" lié à l'API Odoo via le backend.
