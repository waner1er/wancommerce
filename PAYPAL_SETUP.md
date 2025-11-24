# Configuration PayPal

## Obtenir les clés API PayPal

### 1. Créer un compte PayPal Developer

1. Allez sur https://developer.paypal.com/
2. Connectez-vous ou créez un compte
3. Accédez au Dashboard

### 2. Créer une application

1. Dans le Dashboard, allez dans "My Apps & Credentials"
2. Cliquez sur "Create App"
3. Donnez un nom à votre application
4. Sélectionnez "Merchant" comme type de compte

### 3. Récupérer les clés

Dans l'onglet "Sandbox" (pour le développement) :

-   **Client ID** : Votre identifiant client
-   **Secret** : Cliquez sur "Show" pour voir votre clé secrète

Dans l'onglet "Live" (pour la production) :

-   Même chose mais pour l'environnement de production

## Configuration dans Laravel

### 1. Ajouter les variables d'environnement

Ajoutez ces lignes dans votre fichier `.env` :

```env
PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=votre_client_id_ici
PAYPAL_SECRET=votre_secret_ici
```

**Important :**

-   Pour le développement : `PAYPAL_MODE=sandbox`
-   Pour la production : `PAYPAL_MODE=live`

### 2. Configuration déjà en place

✅ Le fichier `config/services.php` est déjà configuré
✅ Le service `PayPalService` est créé
✅ L'intégration frontend est prête

## Tester avec un compte Sandbox

### 1. Créer des comptes de test

1. Dans le PayPal Developer Dashboard
2. Allez dans "Sandbox" > "Accounts"
3. Vous verrez deux comptes par défaut :
    - Un compte "Business" (marchand)
    - Un compte "Personal" (acheteur)

### 2. Tester le paiement

1. Sur votre site, ajoutez des produits au panier
2. Allez jusqu'au paiement
3. Sélectionnez PayPal
4. Utilisez les identifiants du compte "Personal" sandbox
5. Validez le paiement

### 3. Vérifier la transaction

Dans le Dashboard PayPal Developer > Sandbox > Accounts, vous pouvez :

-   Voir le solde des comptes
-   Consulter l'historique des transactions

## Fonctionnalités implémentées

✅ **Création de commande PayPal** - Côté serveur sécurisé
✅ **Popup PayPal** - Interface utilisateur PayPal native
✅ **Capture du paiement** - Validation et enregistrement
✅ **Gestion des erreurs** - Messages d'erreur clairs
✅ **Annulation** - Message informatif si l'utilisateur ferme la popup
✅ **Montant détaillé** - Produits + frais de port

## Scénarios gérés

### ✅ Paiement réussi

1. L'utilisateur clique sur "PayPal"
2. La popup s'ouvre
3. L'utilisateur se connecte et valide
4. La commande est créée en base de données
5. Le stock est mis à jour
6. Le panier est vidé
7. Redirection vers la page de confirmation

### ✅ Paiement refusé

-   Message d'erreur affiché
-   La commande n'est pas créée
-   Le panier reste intact

### ✅ Utilisateur ferme la popup

-   Message informatif : "Paiement annulé. Vous pouvez réessayer quand vous êtes prêt."
-   La commande n'est pas créée
-   Le panier reste intact

### ✅ Erreur PayPal

-   Affichage du message d'erreur
-   Log de l'erreur côté serveur
-   L'utilisateur peut réessayer

## Passer en production

### 1. Obtenir les clés de production

1. Dans le Dashboard PayPal Developer
2. Onglet "Live"
3. Récupérez votre Client ID et Secret de production

### 2. Mettre à jour .env

```env
PAYPAL_MODE=live
PAYPAL_CLIENT_ID=votre_client_id_live
PAYPAL_SECRET=votre_secret_live
```

### 3. Tests recommandés

Avant de passer en production, testez :

-   ✅ Paiement réussi
-   ✅ Paiement refusé
-   ✅ Annulation
-   ✅ Montants corrects (produits + livraison)
-   ✅ TVA calculée correctement
-   ✅ Stock mis à jour
-   ✅ Email de confirmation envoyé

## Support et documentation

-   Documentation officielle : https://developer.paypal.com/docs/
-   SDK PHP : https://github.com/paypal/Checkout-PHP-SDK
-   Sandbox : https://www.sandbox.paypal.com/

## Sécurité

✅ **Les paiements sont traités côté serveur** - Pas de manipulation frontend
✅ **HTTPS requis en production** - PayPal l'exige
✅ **Validation des montants** - Vérification avant capture
✅ **Logs des transactions** - Traçabilité complète
