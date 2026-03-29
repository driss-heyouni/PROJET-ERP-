# Schéma et Fonctionnement de la Base de Données

Ce projet repose sur une architecture **"ERP-Centric"**, où la base de donnée centrale est celle d'Odoo. Voici l'explication détaillée du fonctionnement.

## 1. La Source de Vérité : PostgreSQL (Odoo)
Toutes les données métier de l'entreprise de mobilier sont stockées dans **PostgreSQL**. Odoo gère ces tables automatiquement.

### Principales Tables utilisées :
- **`res_partner`** : Stocke tous les clients (Noms, adresses, emails).
- **`product_template`** & **`product_product`** : Contient le catalogue de mobilier (Bureaux, Chaises, Armoires), les prix de vente et les quantités en stock.
- **`sale_order`** : Enregistre les devis et les bons de commande.
- **`sale_order_line`** : Détail de chaque produit à l'intérieur d'un devis.
- **`res_users`** : Gère les comptes des employés (commerciaux et administrateurs).

## 2. Accès aux Données (Double Méthode)
Notre application Web (Angular + Laravel) accède à cette base PostgreSQL de deux façons :

### A. Via l'API Odoo (Sécurité & Logique métier)
Pour **écrire** des données (ex: créer un nouveau devis), l'application utilise des appels **XML-RPC** ou **JSON-RPC**.
- *Avantage :* Odoo vérifie automatiquement les stocks et les règles de calcul avant d'insérer les données dans Postgres.

### B. Via SQL Direct (Performance & Rapports)
Pour le rôle **Administrateur**, le backend Laravel se connecte directement à PostgreSQL via le driver `pgsql`.
- *Usage :* Cela permet de générer des statistiques ultra-rapides sans passer par les couches lourdes d'Odoo.

## 3. Sécurisation des Accès
- Les mots de passe dans la base Postgres sont **hachés (BCrypt)** par Odoo.
- L'application utilise un **token de session** pour s'assurer qu'un utilisateur non connecté ne peut pas voir les clients ou les prix.

## 4. Visualisation dans Odoo
Pour voir les données créées par l'application dans l'interface Odoo :
1. Allez dans **Ventes**.
2. Les devis apparaissent instantanément avec la mention "Créé par l'API" ou le nom du commercial.
3. Les stocks de mobilier diminuent automatiquement dès qu'une vente est validée.
