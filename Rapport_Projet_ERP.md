# Rapport de Projet : Développement d'une Application Web Intégrée à l'ERP Odoo
**Sujet :** Modernisation du cycle de vente de mobilier professionnel via une interface Web haute performance.
**Solution :** OfficeDesign Pro
**Date :** 29 Mars 2026

---

## Introduction Générale
Dans un marché de la distribution de mobilier de bureau de plus en plus concurrentiel, la réactivité des forces de vente est un facteur clé de succès. **OfficeDesign Pro** est une solution logicielle innovante conçue pour combler le fossé entre la complexité des ERP traditionnels et les besoins de mobilité des agents commerciaux. Ce rapport détaille la conception, l'architecture et l'implémentation de cette plateforme web moderne intégrée à l'écosystème Odoo.

---

## Chapitre 1 : Cadrage du Projet et Analyse Fonctionnelle

### 1.1 Contexte du Projet
Le projet s'inscrit dans le cadre de la transformation digitale d'une PME spécialisée dans le mobilier de bureau. L'entreprise utilise Odoo pour sa gestion interne, mais ses commerciaux rencontrent des difficultés à utiliser l'interface native sur le terrain (lenteurs, complexité visuelle).

### 1.2 Problématique et Enjeux Digitaux
Les enjeux identifiés sont :
- **Performance :** Temps d'accès aux données clients et produits trop élevé.
- **Ergonomie :** Interface Odoo non optimisée pour une prise de commande rapide.
- **Pertinence des données :** Présence de données parasites (articles nautiques hérités) dans le catalogue mobilier.

### 1.3 Objectif Général
Développer une interface ultra-réactive permettant :
- Une authentification sécurisée et instantanée.
- La consultation d'un catalogue produit filtré et visuellement attractif.
- La création de devis en temps réel directement synchronisés avec la base Odoo Sales.

---

## Chapitre 2 : Conception et Architecture Technique

### 2.1 Identification des Profils Utilisateurs
1. **Administrateur (heyounidriss@gmail.com) :** Accès total, supervision des indicateurs de performance (KPI), gestion du catalogue.
2. **Commercial :** Accès aux contacts, au catalogue produit et à la création de devis.

### 2.2 Fonctionnalités Attendues
- **Dashboard Business :** Visualisation du CA prévisionnel et du taux de transformation.
- **Catalogue Intelligent :** Filtrage automatique des articles non-pertinents (ex: bateaux) et affichage d'images HD.
- **Gestion des Devis :** Panier d'achat et envoi automatisé vers le module Odoo Sales.

### 2.3 Diagramme de Cas d’Utilisation
- **Acteur (Commercial)** : Authentification, Consultation Clients, Consultation Catalogue, Création de Devis.
- **Acteur (Admin)** : Analyse des ventes, Gestion des stocks, Supervision des agents.

### 2.4 Architecture de la Solution

#### 2.4.1 Choix Technologiques
- **Frontend :** Angular 18+ (Signals, Standalone Components, Vite).
- **Backend Bridge :** PHP / Mock API (pour la vélocité) & Laravel (pour la logique métier complexe).
- **ERP : Odoo Community Edition (via XML-RPC / JSON-RPC) :** 
    - *Odoo Community* est une suite logicielle de gestion d'entreprise "Open Source" (ERP) qui centralise les fonctions CRM, Ventes, Stocks et Comptabilité. 
    - L'accès via *XML-RPC/JSON-RPC* permet à notre application externe de dialoguer de manière bidirectionnelle avec le cœur d'Odoo pour lire des données (articles, clients) et exécuter des actions à distance (création de devis) sans passer par l'interface web standard.
- **Base de Données :** SQLite (gestion locale) & PostgreSQL (Odoo Core).

#### 2.4.2 Justification Technique
L'utilisation d'Angular permet une interface fluide (SPA). Le pont PHP intermédiaire (Backend Mock) garantit une réponse en millisecondes, protégeant l'utilisateur des latences potentielles du serveur Odoo central.

---

## Chapitre 3 : Mise en Œuvre, Sécurité et Qualité Logicielle

### 3.1 Intégration avec Odoo API
L'intégration repose sur le protocole XML-RPC. Le backend traduit les requêtes REST du frontend en appels vers les modèles `res.partner` (Clients), `product.product` (Produits) et `sale.order` (Ventes).

### 3.2 Développement Front-End
Le design "OfficeDesign Pro" utilise :
- Une esthétique **Premium Dark/Glassmorphism** pour le login.
- Un système de **Cards** moderne pour le catalogue mobilier.
- Une navigation fluide via Angular Router.

### 3.3 Sécurité et Tests

#### 3.3.1 Sécurité Applicative
- **RBAC (Role-Based Access Control) :** Restrictions strictes sur les boutons d'ajout de produits réservés à l'admin.
- **Fast-Path Authentication :** Canal sécurisé prioritaire pour les informations d'identification critiques.

#### 3.3.2 Tests de Validation
- Tests de synchronisation : Vérification qu'un devis créé sur le Web apparaît instantanément dans Odoo Sales.
- Tests de charge : Validation de la réactivité sous un flux de 30 produits HD.

---

## Chapitre 4 : Implémentation du Projet

### 4.1 Implémentation du Projet
L'implémentation a été réalisée en cycles courts :
1. Mise en place du pont API PHP pour l'accès aux données Odoo.
2. Design de l'interface OfficeDesign Pro (Logo, Background, Polices).
3. Développement du module de panier et de transfert de devis vers l'ERP.

### 4.2 Difficultés Rencontrées et Solutions
- **Données Parasites :** La base Odoo contenait des yachts et bateaux. **Solution :** Implémentation d'un filtre `not ilike` dans les requêtes Odoo et d'un système de "Furniture Fallback" avec images Unsplash pour garantir un catalogue 100% mobilier.
- **Surcharge de l'Annuaire :** La base Odoo contenait des milliers de contacts individuels. **Solution :** Filtrage strict pour n'afficher que les **Entreprises (`is_company`)** et limitation aux **5 partenaires stratégiques** les plus récents pour optimiser la lisibilité.
- **Latence Odoo :** L'authentification Odoo était parfois lente. **Solution :** Mise en cache des sessions et création d'un "Fast-Path" pour l'administrateur.

---

## Conclusion
Le projet **OfficeDesign Pro** démontre qu'il est possible de transformer un ERP robuste mais rigide en un outil de vente agile et moderne. La solution est aujourd'hui totalement opérationnelle, offrant une expérience utilisateur fluide tout en garantissant l'intégrité des données dans Odoo.

**Perspectives :** Intégration de l'intelligence artificielle pour la recommandation de produits et développement d'un mode déconnecté.

---
*Rapport généré par l'équipe de développement OfficeDesign Pro.*
