# Guide Opérationnel : Configuration de la Base Odoo

Ce guide décrit les étapes nécessaires pour configurer votre instance Odoo (Community Edition) afin qu'elle soit prête à interagir avec l'application Web développée (Laravel + Angular).

## 1. Installation des modules requis
Connectez-vous à votre instance Odoo avec un compte administrateur.
Rendez-vous dans le menu **Applications (Apps)** :
- Recherchez et installez l'application **Ventes (Sales)**.
  - *Cela installera automatiquement le CRM, Contacts et Facturation de base.*

## 2. Configuration pour le mobilier de bureau
### 2.1. Création des Catégories de Produits
- Allez dans **Ventes > Configuration > Catégories d'articles**.
- Créez les catégories : `Mobilier / Bureaux`, `Mobilier / Chaises`, `Mobilier / Armoires`.

### 2.2. Création des Produits (Mobilier)
- Allez dans **Ventes > Articles (Products)**.
- Créez quelques articles de démonstration :
  - **Bureau Réglable Ergonomique** (Type: Article stockable, Catégorie: `Mobilier / Bureaux`, Prix: 450€).
  - **Chaise de Bureau Confort** (Type: Article stockable, Catégorie: `Mobilier / Chaises`, Prix: 120€).
  - **Caisson de Rangement 3 tiroirs** (Type: Article stockable, Catégorie: `Mobilier / Armoires`, Prix: 85€).
- Assurez-vous que la case **"Peut être vendu" (Can be Sold)** est bien cochée pour chaque produit.
- (Optionnel) Allez dans l'onglet **Inventaire** des fiches produits et mettez à jour la quantité en main pour avoir du stock disponible.

### 2.3. Création des Clients (Contacts)
- Allez dans **Contacts**.
- Créez quelques clients professionnels :
  - **Entreprise A - SARL Dupont** (Type: Société).
  - **Entreprise B - Agence Web Dev** (Type: Société).
  - (Optionnel) Créez des contacts individuels liés à ces sociétés.

## 3. Configuration des Accès API (XML-RPC / JSON-RPC)
Odoo permet l'accès via RPC par défaut, mais il faut s'assurer des bonnes pratiques de sécurité.

### 3.1. Création d'un Utilisateur API dédié
Pour éviter d'utiliser le compte "admin" dans notre application (ce qui est une très mauvaise pratique), créons un utilisateur spécifique pour l'API.
- Allez dans **Paramètres > Utilisateurs et Sociétés > Utilisateurs**.
  - Si vous ne voyez pas ce menu, activez le *Mode Développeur* (Paramètres > Activer le mode développeur en bas de page).
- Créez un nouvel utilisateur :
  - **Nom :** `API User ERP`
  - **Email (Login) :** `api@mon-erp.com`
  - **Mot de passe :** `un_mot_de_passe_complexe` (À configurer via "Action > Changer le mot de passe").
- Dans l'onglet **Droits d'Accès** de cet utilisateur :
  - **Ventes :** Utilisateur : afficher tous les documents (ou Gestionnaire, selon les cas).
  - **Administration :** Laissez vide ou définissez à "Accès aux paramètres" uniquement si besoin pour certains endpoints, mais généralement "Ventes: Utilisateur" suffit pour ce projet.

## 4. Connexion depuis l'application
Dans votre projet Backend Laravel (`.env`), configurez les variables suivantes avec les informations de votre base de données :

```env
ODOO_URL=http://localhost:8069
ODOO_DB=nom_de_votre_base_odoo
ODOO_USERNAME=api@mon-erp.com
ODOO_PASSWORD=un_mot_de_passe_complexe
```

L'application utilisera ces identifiants pour interroger la base, récupérer les clients, produits, et créer de nouveaux devis pour le compte des commerciaux.
